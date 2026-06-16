<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div>
                    <h2 style="font-size:18px;font-weight:700;color:#0b3b63;">DAL Data Maintenance</h2>
                    <p style="font-size:13px;color:#94a3b8;margin-top:2px;">Delegation of Authority entries</p>
                </div>
                @if(!auth()->user()->is_admin)
                    <span style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;border-radius:20px;padding:4px 12px;font-size:12px;font-weight:600;">
                        👁 View Only
                    </span>
                @endif
            </div>
            @if(auth()->user()->is_admin)
                <a href="{{ route('dal.manage.create') }}" id="btn-add-entry"
                   style="display:inline-flex;align-items:center;gap:7px;background:linear-gradient(135deg,#0b3b63,#1e5f94);color:#f7d768;font-weight:700;font-size:14px;padding:10px 20px;border-radius:10px;text-decoration:none;box-shadow:0 4px 12px rgba(11,59,99,0.25);transition:transform 0.15s,opacity 0.2s;"
                   onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">
                    <svg style="width:15px;height:15px;fill:currentColor;" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    Add Entry
                </a>
            @endif
        </div>
    </x-slot>


    <div>
        <div>

            {{-- Flash messages --}}
            @if(session('success'))
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:14px;display:flex;align-items:center;gap:8px;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Filters + Legend row --}}
            <div style="display:flex;gap:16px;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;">

                {{-- Filter card --}}
                <div style="flex:1;min-width:0;background:white;border-radius:16px;padding:20px 24px;box-shadow:0 1px 4px rgba(0,0,0,0.06);display:flex;flex-direction:column;gap:14px;">

                    {{-- Row 1: Type tabs + Search --}}
                    <form method="GET" action="{{ route('dal.manage.index') }}" id="filterForm" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
                        {{-- Hidden fallbacks (must come first so button values override) --}}
                        <input type="hidden" name="type"     value="{{ $type }}">
                        <input type="hidden" name="country"  value="{{ $country }}">
                        <input type="hidden" name="approver" value="{{ $approver }}">

                        {{-- Capital / Non-Capital tabs --}}
                        <div style="display:flex;gap:4px;background:#f3f4f6;border-radius:10px;padding:4px;">
                            <button type="submit" name="type" value="capital"
                                style="padding:7px 18px;border-radius:8px;border:none;font-size:13px;font-weight:600;cursor:pointer;transition:all 0.2s;
                                       background:{{ $type === 'capital'    ? '#0b3b63' : 'transparent' }};
                                       color:{{    $type === 'capital'    ? '#f7d768' : '#374151' }};">
                                Capital
                            </button>
                            <button type="submit" name="type" value="noncapital"
                                style="padding:7px 18px;border-radius:8px;border:none;font-size:13px;font-weight:600;cursor:pointer;transition:all 0.2s;
                                       background:{{ $type === 'noncapital' ? '#0b3b63' : 'transparent' }};
                                       color:{{    $type === 'noncapital' ? '#f7d768' : '#374151' }};">
                                Non-Capital
                            </button>
                        </div>

                        {{-- Search box --}}
                        <input type="text" name="search" value="{{ $search }}"
                            placeholder="Search section, amount, remarks..."
                            style="flex:1;min-width:180px;padding:9px 14px;border:1px solid #e5e7eb;border-radius:10px;font-size:14px;outline:none;transition:border-color 0.2s;"
                            onfocus="this.style.borderColor='#0b3b63'" onblur="this.style.borderColor='#e5e7eb'">

                        <button type="submit"
                            style="padding:9px 18px;background:#0b3b63;color:white;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;">
                            Search
                        </button>

                        @if($search || $country || $approver)
                            <a href="{{ route('dal.manage.index', ['type' => $type]) }}"
                               style="font-size:13px;color:#6b7280;text-decoration:none;white-space:nowrap;">✕ Clear all</a>
                        @endif
                    </form>

                    {{-- Row 2: Country filter pills --}}
                    @php
                        $countries = [
                            ''   => 'All Countries',
                            'MY' => '🇲🇾 MY',
                            'SG' => '🇸🇬 SG',
                            'AU' => '🇦🇺 AU',
                            'VN' => '🇻🇳 VN',
                            'JP' => '🇯🇵 JP',
                        ];
                    @endphp
                    <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">
                        <span style="font-size:12px;font-weight:600;color:#6b7280;margin-right:4px;">Country:</span>
                        @foreach($countries as $code => $label)
                            @php $isActive = ($country === $code); @endphp
                            <a href="{{ route('dal.manage.index', ['type' => $type, 'search' => $search, 'country' => $code, 'approver' => $approver]) }}"
                               style="display:inline-flex;align-items:center;gap:4px;
                                      padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600;
                                      text-decoration:none;transition:all 0.15s;
                                      border: 1px solid {{ $isActive ? '#0b3b63' : '#e5e7eb' }};
                                      background: {{ $isActive ? '#0b3b63' : 'white' }};
                                      color: {{ $isActive ? '#f7d768' : '#374151' }};
                                      box-shadow: {{ $isActive ? '0 2px 6px rgba(11,59,99,0.25)' : 'none' }};"
                               onmouseover="if(!{{ $isActive ? 'true' : 'false' }}) { this.style.borderColor='#0b3b63'; this.style.color='#0b3b63'; }"
                               onmouseout="if(!{{ $isActive ? 'true' : 'false' }}) { this.style.borderColor='#e5e7eb'; this.style.color='#374151'; }"
                            >
                                {{ $label }}
                            </a>
                        @endforeach

                        @if($country)
                            <span style="font-size:12px;color:#9ca3af;margin-left:4px;">
                                — showing entries applicable to <strong>{{ $country }}</strong>
                            </span>
                        @endif
                    </div>

                    {{-- Row 3: Approver filter pills --}}
                    @php
                        $approvers = [
                            ''        => 'All Approvers',
                            'BOD'     => 'Board',
                            'CEO'     => 'CEO',
                            'DEP_CEO' => 'Dep. CEO/COO',
                            'SEVP'    => 'SEVP',
                            'EVP'     => 'EVP',
                            'DGM'     => 'DGM',
                            'GM'      => 'GM',
                            'DEP_GM'  => 'Deputy GM / Head',
                        ];
                    @endphp
                    <div style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">
                        <span style="font-size:12px;font-weight:600;color:#6b7280;margin-right:4px;">Approver:</span>
                        @foreach($approvers as $code => $label)
                            @php $isActive = ($approver === $code); @endphp
                            <a href="{{ route('dal.manage.index', ['type' => $type, 'search' => $search, 'country' => $country, 'approver' => $code]) }}"
                               style="display:inline-flex;align-items:center;gap:4px;
                                      padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600;
                                      text-decoration:none;transition:all 0.15s;
                                      border: 1px solid {{ $isActive ? '#0b3b63' : '#e5e7eb' }};
                                      background: {{ $isActive ? '#0b3b63' : 'white' }};
                                      color: {{ $isActive ? '#f7d768' : '#374151' }};
                                      box-shadow: {{ $isActive ? '0 2px 6px rgba(11,59,99,0.25)' : 'none' }};"
                               onmouseover="if(!{{ $isActive ? 'true' : 'false' }}) { this.style.borderColor='#0b3b63'; this.style.color='#0b3b63'; }"
                               onmouseout="if(!{{ $isActive ? 'true' : 'false' }}) { this.style.borderColor='#e5e7eb'; this.style.color='#374151'; }"
                            >
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>

                </div>{{-- end filter card --}}

                {{-- Legend card --}}
                <div style="flex-shrink:0;width:258px;background:white;border-radius:16px;padding:16px 18px;box-shadow:0 1px 4px rgba(0,0,0,0.06);border:1px solid #f1f5f9;">
                    <div style="font-size:11px;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;color:#0b3b63;margin-bottom:10px;display:flex;align-items:center;gap:6px;">
                        <svg style="width:13px;height:13px;fill:#0b3b63;flex-shrink:0;" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                        Legend
                    </div>
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="border-bottom:1px solid #e2e8f0;">
                                <th style="font-size:10.5px;font-weight:700;color:#94a3b8;padding:0 8px 6px 0;text-align:left;white-space:nowrap;">Code</th>
                                <th style="font-size:10.5px;font-weight:700;color:#94a3b8;padding:0 0 6px;text-align:left;">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach([
                                ['A / JA', 'Approve / Joint Approval',             '#eff6ff', '#1d4ed8'],
                                ['R / JR', 'Recommend / Joint Recommendation',     '#f0fdf4', '#15803d'],
                                ['P / JP', 'Propose / Joint Proposal',             '#fefce8', '#a16207'],
                                ['I',      'Inform',                               '#f5f3ff', '#6d28d9'],
                                ['#',      'Either one to approve / recommend / propose based on the endorsed reporting line', '#fff7ed', '#9a3412'],
                            ] as [$code, $desc, $bg, $col])
                            <tr style="border-bottom:1px solid #f8fafc;">
                                <td style="padding:5px 10px 5px 0;vertical-align:top;">
                                    <span style="display:inline-block;background:{{ $bg }};color:{{ $col }};border:1px solid {{ $col }}22;border-radius:6px;font-size:11px;font-weight:700;padding:2px 7px;white-space:nowrap;">{{ $code }}</span>
                                </td>
                                <td style="padding:5px 0;font-size:11.5px;color:#475569;line-height:1.4;vertical-align:top;">{{ $desc }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>{{-- end legend card --}}

            </div>{{-- end filter + legend row --}}

            {{-- Table / Cards --}}
            <div style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.06);">

                @if($entries->isEmpty())
                    <div style="padding:60px;text-align:center;color:#9ca3af;">
                        <div style="font-size:48px;margin-bottom:12px;">📋</div>
                        <p style="font-size:16px;font-weight:600;margin-bottom:6px;">No entries found</p>
                        <p style="font-size:14px;">
                            @if($search) Try a different search term.
                            @elseif(auth()->user()->is_admin)
                                <a href="{{ route('dal.manage.create') }}" style="color:#0b3b63;font-weight:600;">Add the first entry</a>.
                            @endif
                        </p>
                    </div>
                @else
                    {{-- Desktop table --}}
                    <div class="hidden-mobile" style="overflow-x:auto;">
                        <table style="width:100%;border-collapse:collapse;font-size:13px;">
                            <thead>
                                <tr style="background:#0b3b63;color:white;">
                                    <th style="padding:12px 16px;text-align:left;font-weight:600;white-space:nowrap;">Section</th>
                                    <th style="padding:12px 10px;text-align:center;font-weight:600;">#</th>
									@if($country == '' || $country == 'MY')
                                    <th style="padding:12px 10px;text-align:left;font-weight:600;">MY</th>
									@endif
									@if($country == '' || $country == 'SG')
                                    <th style="padding:12px 10px;text-align:left;font-weight:600;">SG</th>
									@endif
									@if($country == '' || $country == 'AU')
                                    <th style="padding:12px 10px;text-align:left;font-weight:600;">AU</th>
									@endif
									@if($country == '' || $country == 'VN')
                                    <th style="padding:12px 10px;text-align:left;font-weight:600;">VN</th>
									@endif
									@if($country == '' || $country == 'JP')
                                    <th style="padding:12px 10px;text-align:left;font-weight:600;">JP</th>
									@endif
                                    <th style="padding:12px 10px;text-align:center;font-weight:600;">Board</th>
                                    <th style="padding:12px 10px;text-align:center;font-weight:600;">CEO</th>
                                    <th style="padding:12px 10px;text-align:center;font-weight:600;">Dep.CEO</th>
                                    <th style="padding:12px 10px;text-align:center;font-weight:600;">SEVP</th>
                                    <th style="padding:12px 10px;text-align:center;font-weight:600;">EVP</th>
                                    <th style="padding:12px 10px;text-align:center;font-weight:600;">DGM</th>
                                    <th style="padding:12px 10px;text-align:center;font-weight:600;">GM</th>
                                    <th style="padding:12px 10px;text-align:center;font-weight:600;">Deputy GM / Head</th>
                                    <th style="padding:12px 16px;text-align:left;font-weight:600;">Remarks</th>
                                    <th style="padding:12px 16px;text-align:center;font-weight:600;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Pre-calculate how many rows each section spans
                                    $sectionRowspans = [];
                                    foreach ($entries as $e) {
                                        $sectionRowspans[$e->section_title] = ($sectionRowspans[$e->section_title] ?? 0) + 1;
                                    }
                                    $renderedSections = [];
                                @endphp
                                @foreach($entries as $entry)
                                    @php
                                        $isFirstInSection = !in_array($entry->section_title, $renderedSections);
                                        if ($isFirstInSection) {
                                            $renderedSections[] = $entry->section_title;
                                        }
                                    @endphp
                                    <tr style="border-bottom:1px solid #f3f4f6;transition:background 0.15s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background=''">
                                        @if($isFirstInSection)
                                        <td rowspan="{{ $sectionRowspans[$entry->section_title] }}"
                                            style="padding:12px 16px;font-weight:600;color:#0b3b63;max-width:220px;
                                                   vertical-align:top;border-right:3px solid #e2e8f0;
                                                   background:#f8fafc;">
                                            <span style="font-size:11px;display:block;font-weight:600;color:#0b3b63;line-height:1.4;">
                                                {{ $entry->section_title }}
                                            </span>
                                        </td>
                                        @endif
										
                                        <td style="padding:12px 10px;text-align:center;color:#9ca3af;">{{ $entry->row_number }}</td>
										@if($country == '' || $country == 'MY')
                                        <td style="padding:12px 10px;font-weight:600;color:#0b3b63;">{{ $entry->malaysia ?: '—' }}</td>
										@endif
										@if($country == '' || $country == 'SG')
                                        <td style="padding:12px 10px;font-weight:600;color:#0b3b63;">{{ $entry->singapore ?: '—' }}</td>
										@endif
										@if($country == '' || $country == 'AU')
                                        <td style="padding:12px 10px;font-weight:600;color:#0b3b63;">{{ $entry->australia ?: '—' }}</td>
										@endif
										@if($country == '' || $country == 'VN')
                                        <td style="padding:12px 10px;font-weight:600;color:#0b3b63;">{{ $entry->vietnam ?: '—' }}</td>
										@endif
										@if($country == '' || $country == 'JP')
                                        <td style="padding:12px 10px;font-weight:600;color:#0b3b63;">{{ $entry->japan ?: '—' }}</td>
										@endif
                                        {{-- Board / BOD — Violet --}}
                                        <td style="padding:12px 10px;text-align:center;">
                                            @if($entry->bod)
                                                <span style="background:#ede9fe;color:#6d28d9;border:1px solid #ddd6fe;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;">{{ $entry->bod }}</span>
                                            @else<span style="color:#d1d5db;">—</span>@endif
                                        </td>
                                        {{-- CEO — Emerald --}}
                                        <td style="padding:12px 10px;text-align:center;">
                                            @if($entry->ceo)
                                                <span style="background:#d1fae5;color:#065f46;border:1px solid #a7f3d0;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;">{{ $entry->ceo }}</span>
                                            @else<span style="color:#d1d5db;">—</span>@endif
                                        </td>
                                        {{-- Deputy CEO/COO — Sky --}}
                                        <td style="padding:12px 10px;text-align:center;">
                                            @if($entry->deputy_ceo_coo)
                                                <span style="background:#e0f2fe;color:#0369a1;border:1px solid #bae6fd;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;">{{ $entry->deputy_ceo_coo }}</span>
                                            @else<span style="color:#d1d5db;">—</span>@endif
                                        </td>
                                        {{-- SEVP — Rose --}}
                                        <td style="padding:12px 10px;text-align:center;">
                                            @if($entry->sevp)
                                                <span style="background:#ffe4e6;color:#9f1239;border:1px solid #fecdd3;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;">{{ $entry->sevp }}</span>
                                            @else<span style="color:#d1d5db;">—</span>@endif
                                        </td>
                                        {{-- EVP — Orange --}}
                                        <td style="padding:12px 10px;text-align:center;">
                                            @if($entry->evp)
                                                <span style="background:#ffedd5;color:#9a3412;border:1px solid #fed7aa;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;">{{ $entry->evp }}</span>
                                            @else<span style="color:#d1d5db;">—</span>@endif
                                        </td>
                                        {{-- DGM — Amber --}}
                                        <td style="padding:12px 10px;text-align:center;">
                                            @if($entry->dgm)
                                                <span style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;">{{ $entry->dgm }}</span>
                                            @else<span style="color:#d1d5db;">—</span>@endif
                                        </td>
                                        {{-- GM — Teal --}}
                                        <td style="padding:12px 10px;text-align:center;">
                                            @if($entry->gm)
                                                <span style="background:#ccfbf1;color:#0f766e;border:1px solid #99f6e4;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;">{{ $entry->gm }}</span>
                                            @else<span style="color:#d1d5db;">—</span>@endif
                                        </td>
                                        {{-- Deputy GM / Head — Indigo --}}
                                        <td style="padding:12px 10px;text-align:center;">
                                            @if($entry->deputy_gm_head)
                                                <span style="background:#e0e7ff;color:#3730a3;border:1px solid #c7d2fe;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;">{{ $entry->deputy_gm_head }}</span>
                                            @else<span style="color:#d1d5db;">—</span>@endif
                                        </td>
                                        <td style="padding:12px 16px;color:#6b7280;font-size:12px;max-width:160px;">
                                            {{ Str::limit($entry->remarks, 50) ?: '—' }}
                                        </td>
                                        <td style="padding:12px 16px;text-align:center;white-space:nowrap;">
                                            @if(auth()->user()->is_admin)
                                                <a href="{{ route('dal.manage.edit', $entry) }}"
                                                   style="display:inline-flex;align-items:center;gap:4px;background:#0b3b63;color:#f7d768;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:600;text-decoration:none;margin-right:6px;">
                                                    ✏️ Edit
                                                </a>
                                                <form method="POST" action="{{ route('dal.manage.destroy', $entry) }}" style="display:inline;" onsubmit="return confirm('Delete this entry?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:600;cursor:pointer;">
                                                        🗑 Del
                                                    </button>
                                                </form>
                                            @else
                                                <span style="color:#d1d5db;font-size:12px;">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile cards --}}
                    <div class="show-mobile" style="display:none;padding:16px;gap:12px;flex-direction:column;">
                        @foreach($entries as $entry)
                            <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                                {{-- Card header --}}
                                <div style="background:#0b3b63;color:#f7d768;padding:10px 14px;font-size:12px;font-weight:700;">
                                    {{ $entry->section_title }} — Row {{ $entry->row_number }}
                                </div>
                                <div style="padding:14px;display:flex;flex-direction:column;gap:8px;">

                                    {{-- Country threshold(s): show only active country column, or all if 'All' --}}
                                    @php
                                        $mobileCountryCols = [
                                            'MY' => ['malaysia'  => 'MY (RM)'],
                                            'SG' => ['singapore' => 'SG (SGD)'],
                                            'AU' => ['australia' => 'AU (AUD)'],
                                            'VN' => ['vietnam'   => 'VN (USD)'],
                                            'JP' => ['japan'     => 'JP (JPY)'],
                                            ''   => [
                                                'malaysia'  => 'MY (RM)',
                                                'singapore' => 'SG (SGD)',
                                                'australia' => 'AU (AUD)',
                                                'vietnam'   => 'VN (USD)',
                                                'japan'     => 'JP (JPY)',
                                            ],
                                        ];
                                        $activeCols = $mobileCountryCols[$country] ?? $mobileCountryCols[''];
                                    @endphp
                                    @foreach($activeCols as $col => $label)
                                        @if($entry->$col && $entry->$col !== '-')
                                            <div style="display:flex;justify-content:space-between;border-bottom:1px solid #e5e7eb;padding-bottom:6px;">
                                                <span style="font-size:12px;color:#6b7280;font-weight:500;">{{ $label }}</span>
                                                <span style="font-size:13px;font-weight:700;color:#0b3b63;">{{ $entry->$col }}</span>
                                            </div>
                                        @endif
                                    @endforeach

                                    {{-- Approver columns — each with its own colour --}}
                                    @php
                                        $approvers = [
                                            'bod'            => ['label' => 'Board',            'bg' => '#ede9fe', 'color' => '#6d28d9', 'border' => '#ddd6fe'],
                                            'ceo'            => ['label' => 'CEO',              'bg' => '#d1fae5', 'color' => '#065f46', 'border' => '#a7f3d0'],
                                            'deputy_ceo_coo' => ['label' => 'Dep. CEO/COO',    'bg' => '#e0f2fe', 'color' => '#0369a1', 'border' => '#bae6fd'],
                                            'sevp'           => ['label' => 'SEVP',             'bg' => '#ffe4e6', 'color' => '#9f1239', 'border' => '#fecdd3'],
                                            'evp'            => ['label' => 'EVP',              'bg' => '#ffedd5', 'color' => '#9a3412', 'border' => '#fed7aa'],
                                            'dgm'            => ['label' => 'DGM',              'bg' => '#fef3c7', 'color' => '#92400e', 'border' => '#fde68a'],
                                            'gm'             => ['label' => 'GM',               'bg' => '#ccfbf1', 'color' => '#0f766e', 'border' => '#99f6e4'],
                                            'deputy_gm_head' => ['label' => 'Deputy GM / Head', 'bg' => '#e0e7ff', 'color' => '#3730a3', 'border' => '#c7d2fe'],
                                        ];
                                    @endphp
                                    @foreach($approvers as $col => $meta)
                                        @if($entry->$col)
                                            <div style="display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #f1f5f9;padding-bottom:5px;">
                                                <span style="font-size:12px;color:#6b7280;font-weight:500;">{{ $meta['label'] }}</span>
                                                <span style="background:{{ $meta['bg'] }};color:{{ $meta['color'] }};border:1px solid {{ $meta['border'] }};padding:2px 9px;border-radius:12px;font-size:11px;font-weight:700;">{{ $entry->$col }}</span>
                                            </div>
                                        @endif
                                    @endforeach

                                    @if($entry->remarks)
                                        <p style="font-size:12px;color:#6b7280;font-style:italic;margin-top:2px;">{{ Str::limit($entry->remarks, 80) }}</p>
                                    @endif

                                    @if(auth()->user()->is_admin)
                                        <div style="display:flex;gap:8px;margin-top:6px;">
                                            <a href="{{ route('dal.manage.edit', $entry) }}"
                                               style="flex:1;text-align:center;background:#0b3b63;color:#f7d768;padding:8px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
                                                ✏️ Edit
                                            </a>
                                            <form method="POST" action="{{ route('dal.manage.destroy', $entry) }}" style="flex:1;" onsubmit="return confirm('Delete?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" style="width:100%;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;padding:8px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">
                                                    🗑 Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <p style="font-size:12px;color:#9ca3af;margin-top:12px;text-align:right;">
                {{ $entries->count() }} {{ Str::plural('entry', $entries->count()) }} shown
                @if($country)  &nbsp;·&nbsp; country: <strong>{{ $country }}</strong>  @endif
                @if($approver) &nbsp;·&nbsp; approver: <strong>{{ $approvers[$approver] ?? $approver }}</strong> @endif
                @if($search)   &nbsp;·&nbsp; search: "{{ $search }}" @endif
            </p>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            .hidden-mobile { display: none !important; }
            .show-mobile   { display: flex !important; }
        }
    </style>
</x-app-layout>
