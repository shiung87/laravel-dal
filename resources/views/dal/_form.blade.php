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
        .f-grid-2, .f-grid-3, .f-grid-4 { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 420px) {
        .f-grid-2, .f-grid-3, .f-grid-4 { grid-template-columns: 1fr; }
    }
</style>

{{-- Type & basic info --}}
<div class="f-section">
    <div class="f-section-title">Entry Details</div>
    <div class="f-grid f-grid-3">
        <div class="f-group">
            <label for="f_type">Type *</label>
            <select id="f_type" name="type" class="f-select" required>
                <option value="capital"    {{ old('type', $entry->type ?? '') === 'capital'    ? 'selected' : '' }}>Capital Expenditure</option>
                <option value="noncapital" {{ old('type', $entry->type ?? '') === 'noncapital' ? 'selected' : '' }}>Non-Capital Expenditure</option>
            </select>
            @error('type')<p class="f-error">{{ $message }}</p>@enderror
        </div>
        <div class="f-group" style="grid-column: span 2">
            <label for="f_section_title">Section Title *</label>
            <input id="f_section_title" name="section_title" class="f-input" type="text"
                value="{{ old('section_title', $entry->section_title ?? '') }}"
                placeholder="e.g. 4.1 Acquisition of Budgeted Capital Expenditure" required>
            @error('section_title')<p class="f-error">{{ $message }}</p>@enderror
        </div>
        <div class="f-group">
            <label for="f_row_number" style="display:flex;align-items:center;gap:6px;">
                Row #&nbsp;<span style="font-weight:400;color:#94a3b8;font-size:11px;">*</span>
                @isset($isCreate)
                <span id="row-hint" style="display:none;font-size:10.5px;font-weight:500;color:#0b3b63;background:#eff6ff;border:1px solid #bfdbfe;border-radius:5px;padding:1px 6px;">auto</span>
                @endisset
            </label>
            <input id="f_row_number" name="row_number" class="f-input" type="number" min="1"
                value="{{ old('row_number', $entry->row_number ?? '') }}"
                {{ isset($isCreate) ? 'placeholder=auto' : 'required' }}>
            @error('row_number')<p class="f-error">{{ $message }}</p>@enderror
        </div>
    </div>
</div>

@isset($isCreate)
<script>
(function () {
    const typeEl    = document.getElementById('f_type');
    const titleEl   = document.getElementById('f_section_title');
    const rowEl     = document.getElementById('f_row_number');
    const hintEl    = document.getElementById('row-hint');
    const endpoint  = '{{ route("dal.manage.next-row-number") }}';
    let debounce;

    function fetchNext() {
        const type  = typeEl.value;
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
                const url = `${endpoint}?type=${encodeURIComponent(type)}&section_title=${encodeURIComponent(title)}`;
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

    typeEl.addEventListener('change', fetchNext);
    titleEl.addEventListener('input', fetchNext);

    // Run on page load in case old() values are already populated
    if (titleEl.value.trim()) fetchNext();
})();
</script>
@endisset


{{-- Amount thresholds --}}
<div class="f-section">
    <div class="f-section-title">Amount Thresholds</div>
    <div class="f-grid f-grid-4">
        @foreach(['malaysia' => 'Malaysia (RM)', 'singapore' => 'Singapore (SGD)', 'australia' => 'Australia (AUD)', 'vietnam' => 'Vietnam (USD)', 'japan' => 'Japan (JPY)'] as $col => $label)
        <div class="f-group">
            <label for="f_{{ $col }}">{{ $label }}</label>
            <input id="f_{{ $col }}" name="{{ $col }}" class="f-input" type="text"
                value="{{ old($col, $entry->$col ?? '') }}"
                placeholder="e.g. > RM250k">
            @error($col)<p class="f-error">{{ $message }}</p>@enderror
        </div>
        @endforeach
    </div>
</div>

{{-- Approver columns --}}
<div class="f-section">
    <div class="f-section-title">Approver Roles <span style="font-size:11px;font-weight:400;text-transform:none;color:#6b7280;">(A = Approve, R = Recommend, P = Propose)</span></div>
    <div class="f-grid f-grid-4">
        @foreach($approverColumns as $col => $label)
        <div class="f-group">
            <label for="f_{{ $col }}">{{ $label }}</label>
            <input id="f_{{ $col }}" name="{{ $col }}" class="f-input" type="text"
                value="{{ old($col, $entry->$col ?? '') }}"
                placeholder="A / R / P / R#">
            @error($col)<p class="f-error">{{ $message }}</p>@enderror
        </div>
        @endforeach
    </div>
</div>

{{-- Remarks --}}
<div class="f-section">
    <div class="f-section-title">Remarks & Clarification</div>
    <div class="f-group">
        <label for="f_remarks">Remarks</label>
        <textarea id="f_remarks" name="remarks" class="f-textarea"
            placeholder="Additional notes or clarifications...">{{ old('remarks', $entry->remarks ?? '') }}</textarea>
        @error('remarks')<p class="f-error">{{ $message }}</p>@enderror
    </div>
</div>
