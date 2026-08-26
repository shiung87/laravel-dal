<style>
    .f-section { margin-bottom: 24px; }
    .f-section-title { font-size: 13px; font-weight: 700; color: #0b3b63; letter-spacing: 0.06em; text-transform: uppercase; border-bottom: 2px solid #f7d768; padding-bottom: 6px; margin-bottom: 16px; }
    .f-grid { display: grid; gap: 14px; }
    .f-grid-2 { grid-template-columns: repeat(2, 1fr); }
    .f-grid-3 { grid-template-columns: repeat(3, 1fr); }
    .f-grid-4 { grid-template-columns: repeat(4, 1fr); }
    .f-group label { display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 5px; }
    .f-input, .f-select, .f-textarea {
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 13px;
        padding: 9px 12px;
        color: #111827;
        background: #fafafa;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .f-input:focus, .f-select:focus, .f-textarea:focus {
        border-color: #0b3b63;
        box-shadow: 0 0 0 3px rgba(11,59,99,0.08);
        background: #fff;
    }
    .f-textarea { min-height: 80px; resize: vertical; }
    .f-error { color: #dc2626; font-size: 11px; margin-top: 4px; }
    @media (max-width: 640px) {
        .f-grid-2, .f-grid-3, .f-grid-4 { grid-template-columns: 1fr !important; }
        .f-input, .f-select, .f-textarea { font-size: 15px !important; padding: 10px 12px; }
        .f-section { margin-bottom: 20px; }
    }
</style>

@php
    $currentCategory = old('category', $dalEntry->category ?? ($selectedCategory ?? 'finance'));
@endphp

{{-- Category & basic info --}}
<div class="f-section">
    <div class="f-section-title">Category &amp; Clause Details</div>
    <div class="f-grid f-grid-3">
        {{-- Category Selection --}}
        <div class="f-group">
            <label for="f_category">DAL Category *</label>
            <select id="f_category" name="category" class="f-select" required onchange="onCategoryChange(this.value)">
                @foreach(\App\Models\DalEntry::$categories as $catKey => $cat)
                    <option value="{{ $catKey }}" {{ $currentCategory === $catKey ? 'selected' : '' }}>
                        {{ $cat['full_title'] }}
                    </option>
                @endforeach
            </select>
            @error('category')<p class="f-error">{{ $message }}</p>@enderror
        </div>

        {{-- Sub-type (Only relevant if category is finance) --}}
        <div class="f-group" id="group_type" style="display: {{ $currentCategory === 'finance' ? 'block' : 'none' }};">
            <label for="f_type">Finance Sub-Section</label>
            <select id="f_type" name="type" class="f-select">
                <option value="capital"    {{ old('type', $dalEntry->type ?? '') === 'capital'    ? 'selected' : '' }}>4.0 Capital Expenditure</option>
                <option value="noncapital" {{ old('type', $dalEntry->type ?? '') === 'noncapital' ? 'selected' : '' }}>5.0 Non-Capital Expenditure</option>
                <option value="treasury"   {{ old('type', $dalEntry->type ?? '') === 'treasury'   ? 'selected' : '' }}>6.0 Treasury &amp; Financing</option>
            </select>
            @error('type')<p class="f-error">{{ $message }}</p>@enderror
        </div>

        {{-- Row Number --}}
        <div class="f-group">
            <label for="f_row_number" style="display:flex;align-items:center;gap:6px;">
                Row #&nbsp;<span style="font-weight:400;color:#94a3b8;font-size:11px;">*</span>
                @isset($isCreate)
                <span id="row-hint" style="display:none;font-size:10.5px;font-weight:500;color:#0b3b63;background:#eff6ff;border:1px solid #bfdbfe;border-radius:5px;padding:1px 6px;">auto</span>
                @endisset
            </label>
            <input id="f_row_number" name="row_number" class="f-input" type="number" min="1"
                value="{{ old('row_number', $dalEntry->row_number ?? '') }}"
                {{ isset($isCreate) ? 'placeholder=auto' : 'required' }}>
            @error('row_number')<p class="f-error">{{ $message }}</p>@enderror
        </div>

        {{-- Section Title --}}
        <div class="f-group" style="grid-column: 1 / -1;">
            <label for="f_section_title">Section / Activity Title *</label>
            <input id="f_section_title" name="section_title" class="f-input" type="text"
                value="{{ old('section_title', $dalEntry->section_title ?? '') }}"
                placeholder="e.g. 1.1 Approval of Annual Statutory Audited Accounts, 2.1 Award of Contract..." required>
            @error('section_title')<p class="f-error">{{ $message }}</p>@enderror
        </div>
    </div>
</div>

<script>
function onCategoryChange(cat) {
    const typeGroup = document.getElementById('group_type');
    if (typeGroup) {
        typeGroup.style.display = (cat === 'finance') ? 'block' : 'none';
    }
}
</script>

@isset($isCreate)
<script>
(function () {
    const categoryEl = document.getElementById('f_category');
    const typeEl     = document.getElementById('f_type');
    const titleEl    = document.getElementById('f_section_title');
    const rowEl      = document.getElementById('f_row_number');
    const hintEl     = document.getElementById('row-hint');
    const endpoint   = '{{ route("dal.manage.next-row-number") }}';
    let debounce;

    function fetchNext() {
        const cat   = categoryEl.value;
        const type  = (cat === 'finance') ? typeEl.value : '';
        const title = titleEl.value.trim();
        if (!title) {
            rowEl.placeholder = 'auto';
            hintEl.style.display = 'none';
            return;
        }

        clearTimeout(debounce);
        debounce = setTimeout(async () => {
            hintEl.textContent = '…';
            hintEl.style.display = 'inline';
            try {
                const url = `${endpoint}?category=${encodeURIComponent(cat)}&type=${encodeURIComponent(type)}&section_title=${encodeURIComponent(title)}`;
                const res  = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                const data = await res.json();
                rowEl.value       = data.next;
                hintEl.textContent = 'auto';
                hintEl.style.display = 'inline';
            } catch (e) {
                hintEl.style.display = 'none';
            }
        }, 400);
    }

    categoryEl.addEventListener('change', () => {
        onCategoryChange(categoryEl.value);
        fetchNext();
    });
    typeEl.addEventListener('change', fetchNext);
    titleEl.addEventListener('input', fetchNext);

    // Run on page load in case old() values are already populated
    if (titleEl.value.trim()) fetchNext();
})();
</script>
@endisset

{{-- Amount thresholds --}}
<div class="f-section">
    <div class="f-section-title">Amount Thresholds (Optional by region)</div>
    <div class="f-grid f-grid-4">
        @foreach(['malaysia' => 'Malaysia (RM)', 'singapore' => 'Singapore (SGD)', 'australia' => 'Australia (AUD)', 'vietnam' => 'Vietnam (USD)', 'japan' => 'Japan (JPY)'] as $col => $label)
        <div class="f-group">
            <label for="f_{{ $col }}">{{ $label }}</label>
            <input id="f_{{ $col }}" name="{{ $col }}" class="f-input" type="text"
                value="{{ old($col, $dalEntry->$col ?? '') }}"
                placeholder="e.g. > RM250k or Any Amount">
            @error($col)<p class="f-error">{{ $message }}</p>@enderror
        </div>
        @endforeach
    </div>
</div>

{{-- Approver columns --}}
<div class="f-section">
    <div class="f-section-title">Approver Roles <span style="font-size:11px;font-weight:400;text-transform:none;color:#6b7280;">(A = Approve, R = Recommend, P = Propose, E = Endorse, I = Inform)</span></div>
    <div class="f-grid f-grid-4">
        @foreach($approverColumns as $col => $label)
        <div class="f-group">
            <label for="f_{{ $col }}">{{ $label }}</label>
            <input id="f_{{ $col }}" name="{{ $col }}" class="f-input" type="text"
                value="{{ old($col, $dalEntry->$col ?? '') }}"
                placeholder="A / R / P / R#">
            @error($col)<p class="f-error">{{ $message }}</p>@enderror
        </div>
        @endforeach
    </div>
</div>

{{-- Remarks --}}
<div class="f-section">
    <div class="f-section-title">Remarks &amp; Clarification</div>
    <div class="f-group">
        <label for="f_remarks">Remarks</label>
        <textarea id="f_remarks" name="remarks" class="f-textarea"
            placeholder="Additional governance notes, condition precedents, or committee quorum requirements...">{{ old('remarks', $dalEntry->remarks ?? '') }}</textarea>
        @error('remarks')<p class="f-error">{{ $message }}</p>@enderror
    </div>
</div>
