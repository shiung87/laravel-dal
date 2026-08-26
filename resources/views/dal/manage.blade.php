<x-app-layout>
    <style>
        /* Mobile-responsive styles for DAL management */
        .cat-tabs-bar {
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }
        .cat-tabs-bar::-webkit-scrollbar {
            height: 4px;
        }
        .cat-tabs-bar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .mobile-swipe-banner {
            display: none;
            background: #eff6ff;
            border-bottom: 1px solid #dbeafe;
            color: #1e40af;
            padding: 8px 14px;
            font-size: 11.5px;
            font-weight: 600;
            align-items: center;
            gap: 6px;
        }

        @media (max-width: 768px) {
            .mobile-swipe-banner {
                display: flex;
            }
            .header-flex-wrap {
                flex-direction: column;
                align-items: stretch !important;
            }
            .header-btn-wrap {
                width: 100%;
            }
            .header-btn-wrap a {
                width: 100%;
                justify-content: center;
                box-sizing: border-box;
            }
            .filter-card-body {
                padding: 14px 16px !important;
            }
            .filter-form-row {
                flex-direction: column;
                align-items: stretch !important;
            }
            .search-input-field {
                width: 100% !important;
                min-width: 100% !important;
                font-size: 15px !important;
            }
            .search-btn {
                width: 100% !important;
                justify-content: center;
            }
            .finance-tabs-wrap {
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .filter-sub-row {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 10px !important;
            }
            .approver-select-wrap {
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .approver-select-wrap select {
                flex: 1;
                font-size: 14px !important;
            }
        }
    </style>

    <x-slot name="header">
        <div class="header-flex-wrap" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <div>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                    <h2 style="font-size:20px;font-weight:800;color:#0b3b63;letter-spacing:-0.4px;">
                        {{ $currentCategoryMeta['full_title'] }}
                    </h2>
                    <span style="background:rgba(11,59,99,0.08);color:#0b3b63;border:1px solid rgba(11,59,99,0.15);border-radius:20px;padding:3px 10px;font-size:11px;font-weight:700;">
                        {{ $entries->count() }} {{ Str::plural('Clause', $entries->count()) }}
                    </span>
                    @if(!auth()->user()->is_admin)
                        <span style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:600;">
                            👁 View Only
                        </span>
                    @endif
                </div>
                <p style="font-size:13px;color:#64748b;margin-top:3px;">{{ $currentCategoryMeta['description'] }}</p>
            </div>
            @if(auth()->user()->is_admin)
                <div class="header-btn-wrap">
                    <a href="{{ route('dal.manage.create', ['category' => $category]) }}" id="btn-add-entry"
                       style="display:inline-flex;align-items:center;gap:7px;background:linear-gradient(135deg,#0b3b63,#1e5f94);color:#f7d768;font-weight:700;font-size:14px;padding:10px 20px;border-radius:10px;text-decoration:none;box-shadow:0 4px 12px rgba(11,59,99,0.25);transition:transform 0.15s,opacity 0.2s;"
                       onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">
                        <svg style="width:15px;height:15px;fill:currentColor;" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                        Add Entry in {{ $currentCategoryMeta['name'] }}
                    </a>
                </div>
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

            {{-- ──────────────────────────────────────────────────────────
                 DEPARTMENT SSO SYNC GUIDANCE BANNER
            ────────────────────────────────────────────────────────── --}}
            @if(auth()->user()->department && !empty($userMappedCategories) && $userMappedCategories->isNotEmpty())
                <div style="background:linear-gradient(135deg,#f0fdf4,#eff6ff);border:1px solid #bbf7d0;border-radius:14px;padding:14px 20px;margin-bottom:20px;box-shadow:0 1px 3px rgba(0,0,0,0.05);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div style="width:38px;height:38px;border-radius:10px;background:#dcfce7;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">
                            🏢
                        </div>
                        <div>
                            <div style="font-size:13.5px;font-weight:700;color:#14532d;">
                                Synced Department: <span style="color:#0b3b63;">{{ auth()->user()->department->name }}</span>
                            </div>
                            <div style="font-size:12px;color:#475569;margin-top:2px;">
                                Your department is mapped to:
                                @foreach($userMappedCategories as $mCat)
                                    <a href="{{ route('dal.manage.index', ['category' => $mCat->slug]) }}"
                                       style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:6px;background:#e0e7ff;color:#3730a3;font-weight:700;text-decoration:none;margin-left:4px;font-size:11.5px;">
                                        ⭐ {{ $mCat->full_title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ──────────────────────────────────────────────────────────
                 CATEGORY TABS NAVIGATION BAR (Global All + 1.0 to 10.0)
            ────────────────────────────────────────────────────────── --}}
            <div class="cat-tabs-bar" style="background:#fff;border-radius:16px;padding:12px 14px;box-shadow:0 1px 4px rgba(0,0,0,0.06);margin-bottom:20px;border:1px solid #e2e8f0;overflow-x:auto;">
                <div style="display:flex;gap:8px;min-width:max-content;align-items:center;">
                    {{-- All Categories Global Tab --}}
                    @php
                        $isAllActive = ($category === 'all');
                    @endphp
                    <a href="{{ route('dal.manage.index', ['category' => 'all', 'search' => $search, 'country' => $country, 'approver' => $approver]) }}"
                       style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:700;transition:all 0.15s;white-space:nowrap;
                              background:{{ $isAllActive ? 'linear-gradient(135deg,#0b3b63,#1e5f94)' : '#f8fafc' }};
                              color:{{ $isAllActive ? '#f7d768' : '#475569' }};
                              border:1px solid {{ $isAllActive ? '#0b3b63' : '#e2e8f0' }};
                              box-shadow:{{ $isAllActive ? '0 3px 10px rgba(11,59,99,0.2)' : 'none' }};">
                        <span>🌐 {{ $userMappedCategories->isNotEmpty() ? 'All Mapped Categories' : 'All Categories' }}</span>
                        <span style="font-size:11px;padding:2px 7px;border-radius:12px;font-weight:700;
                                     background:{{ $isAllActive ? 'rgba(247,215,104,0.2)' : 'rgba(0,0,0,0.06)' }};
                                     color:{{ $isAllActive ? '#f7d768' : '#64748b' }};">
                            {{ $totalAllCount ?? array_sum($categoryCounts) }}
                        </span>
                    </a>

                    @foreach($categories as $catKey => $cat)
                        @php
                            $isActive = ($category === $catKey);
                            $count = $categoryCounts[$catKey] ?? 0;
                            $isUserMapped = in_array($catKey, $userMappedSlugs ?? [], true);
                        @endphp
                        <a href="{{ route('dal.manage.index', ['category' => $catKey, 'search' => $search, 'country' => $country, 'approver' => $approver]) }}"
                           style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:700;transition:all 0.15s;white-space:nowrap;
                                  background:{{ $isActive ? 'linear-gradient(135deg,#0b3b63,#1e5f94)' : ($isUserMapped ? '#f0fdf4' : '#f8fafc') }};
                                  color:{{ $isActive ? '#f7d768' : ($isUserMapped ? '#166534' : '#475569') }};
                                  border:1px solid {{ $isActive ? '#0b3b63' : ($isUserMapped ? '#bbf7d0' : '#e2e8f0') }};
                                  box-shadow:{{ $isActive ? '0 3px 10px rgba(11,59,99,0.2)' : 'none' }};">
                            @if($isUserMapped && !$isActive)
                                <span title="Mapped to your department">⭐</span>
                            @endif
                            <span>{{ $cat['full_title'] }}</span>
                            <span style="font-size:11px;padding:2px 7px;border-radius:12px;font-weight:700;
                                         background:{{ $isActive ? 'rgba(247,215,104,0.2)' : 'rgba(0,0,0,0.06)' }};
                                         color:{{ $isActive ? '#f7d768' : '#64748b' }};">
                                {{ $count }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Filters + Controls row --}}
            <div style="display:flex;gap:16px;align-items:flex-start;margin-bottom:20px;flex-wrap:wrap;">

                {{-- Filter card --}}
                <div class="filter-card-body" style="flex:1;min-width:0;background:white;border-radius:16px;padding:20px 24px;box-shadow:0 1px 4px rgba(0,0,0,0.06);display:flex;flex-direction:column;gap:14px;border:1px solid #e2e8f0;">

                    {{-- Row 1: Scope Dropdown + Subtypes (if finance) + Search --}}
                    <form method="GET" action="{{ route('dal.manage.index') }}" id="filterForm" class="filter-form-row" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
                        <input type="hidden" name="country"  value="{{ $country }}">
                        <input type="hidden" name="approver" value="{{ $approver }}">

                        {{-- Search Scope selector --}}
                        <select name="category" onchange="this.form.submit()"
                                style="padding:9px 12px;border:1px solid #e5e7eb;border-radius:10px;font-size:13px;font-weight:600;color:#0b3b63;background:#f8fafc;outline:none;cursor:pointer;">
                            <option value="all" {{ $category === 'all' ? 'selected' : '' }}>
                                🌐 {{ $userMappedCategories->isNotEmpty() ? 'Search All Mapped Categories' : 'Search All Categories' }}
                            </option>
                            @foreach($categories as $catKey => $cat)
                                @php $isDeptMap = in_array($catKey, $userMappedSlugs ?? [], true); @endphp
                                <option value="{{ $catKey }}" {{ $category === $catKey ? 'selected' : '' }}>
                                    {{ $isDeptMap ? '⭐ ' : '' }}Search in {{ $cat['name'] }}
                                </option>
                            @endforeach
                        </select>

                        @if($category === 'finance')
                            {{-- Finance Sub-tabs --}}
                            <div class="finance-tabs-wrap" style="display:flex;gap:4px;background:#f3f4f6;border-radius:10px;padding:4px;">
                                <button type="submit" name="type" value=""
                                    style="padding:7px 14px;border-radius:8px;border:none;font-size:12.5px;font-weight:600;cursor:pointer;transition:all 0.2s;white-space:nowrap;
                                           background:{{ empty($type) ? '#0b3b63' : 'transparent' }};
                                           color:{{ empty($type) ? '#f7d768' : '#374151' }};">
                                    All Finance
                                </button>
                                <button type="submit" name="type" value="capital"
                                    style="padding:7px 14px;border-radius:8px;border:none;font-size:12.5px;font-weight:600;cursor:pointer;transition:all 0.2s;white-space:nowrap;
                                           background:{{ $type === 'capital' ? '#0b3b63' : 'transparent' }};
                                           color:{{ $type === 'capital' ? '#f7d768' : '#374151' }};">
                                    4.0 Capital
                                </button>
                                <button type="submit" name="type" value="noncapital"
                                    style="padding:7px 14px;border-radius:8px;border:none;font-size:12.5px;font-weight:600;cursor:pointer;transition:all 0.2s;white-space:nowrap;
                                           background:{{ $type === 'noncapital' ? '#0b3b63' : 'transparent' }};
                                           color:{{ $type === 'noncapital' ? '#f7d768' : '#374151' }};">
                                    5.0 Non-Capital
                                </button>
                                <button type="submit" name="type" value="treasury"
                                    style="padding:7px 14px;border-radius:8px;border:none;font-size:12.5px;font-weight:600;cursor:pointer;transition:all 0.2s;white-space:nowrap;
                                           background:{{ $type === 'treasury' ? '#0b3b63' : 'transparent' }};
                                           color:{{ $type === 'treasury' ? '#f7d768' : '#374151' }};">
                                    6.0 Treasury
                                </button>
                            </div>
                        @endif

                        {{-- Search box --}}
                        <input type="text" name="search" value="{{ $search }}" class="search-input-field"
                            placeholder="{{ $category === 'all' ? 'Search globally across all categories (clause, section, amount, remarks)...' : 'Search in ' . $currentCategoryMeta['name'] . ' (clause, amount, remarks)...' }}"
                            style="flex:1;min-width:240px;padding:9px 14px;border:1px solid #e5e7eb;border-radius:10px;font-size:13.5px;outline:none;transition:border-color 0.2s;"
                            onfocus="this.style.borderColor='#0b3b63'" onblur="this.style.borderColor='#e5e7eb'">

                        <button type="submit" class="search-btn"
                            style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#0b3b63;color:white;border:none;border-radius:10px;font-size:13.5px;font-weight:600;cursor:pointer;">
                            <svg style="width:14px;height:14px;fill:currentColor;" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                            Search
                        </button>

                        @if($search || $country || $approver || ($category === 'finance' && $type))
                            <a href="{{ route('dal.manage.index', ['category' => $category]) }}"
                               style="font-size:13px;color:#6b7280;text-decoration:none;white-space:nowrap;padding:4px 0;">✕ Clear filters</a>
                        @endif
                    </form>

                    {{-- Row 2: Country filter pills & Approver dropdown --}}
                    <div class="filter-sub-row" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
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
                        <div class="country-pills-row" style="display:flex;flex-wrap:wrap;gap:8px;align-items:center;">
                            <span style="font-size:12px;font-weight:600;color:#6b7280;margin-right:4px;">Country:</span>
                            @foreach($countries as $code => $label)
                                @php $isActive = ($country === $code); @endphp
                                <a href="{{ route('dal.manage.index', ['category' => $category, 'type' => $type, 'search' => $search, 'country' => $code, 'approver' => $approver]) }}"
                                   style="display:inline-flex;align-items:center;gap:4px;
                                          padding:5px 12px;border-radius:20px;font-size:12px;font-weight:600;
                                          text-decoration:none;transition:all 0.15s;
                                          background:{{ $isActive ? '#0b3b63' : '#f3f4f6' }};
                                          color:{{      $isActive ? '#f7d768' : '#374151' }};
                                          border:1px solid {{ $isActive ? '#0b3b63' : '#e5e7eb' }};">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>

                        {{-- Approver filter & Legend Toggle --}}
                        <div class="approver-select-wrap" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <span style="font-size:12px;font-weight:600;color:#6b7280;white-space:nowrap;">Filter Approver:</span>
                                <select onchange="window.location.href=this.value"
                                        style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:8px;font-size:12.5px;color:#374151;background:#f9fafb;outline:none;cursor:pointer;">
                                    <option value="{{ route('dal.manage.index', ['category' => $category, 'type' => $type, 'search' => $search, 'country' => $country, 'approver' => '']) }}">
                                        All Roles
                                    </option>
                                    @foreach(\App\Models\DalEntry::$approverColumns as $appCol => $appLabel)
                                        <option value="{{ route('dal.manage.index', ['category' => $category, 'type' => $type, 'search' => $search, 'country' => $country, 'approver' => strtoupper($appCol)]) }}"
                                                {{ $approver === strtoupper($appCol) ? 'selected' : '' }}>
                                            {{ $appLabel }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="button" onclick="toggleDalLegend()" id="btn-toggle-legend"
                                    style="display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border-radius:8px;border:1px solid #e2e8f0;background:#f8fafc;font-size:12.5px;font-weight:700;color:#0b3b63;cursor:pointer;transition:all 0.15s;"
                                    onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                                <span>ℹ️</span> Legend
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ──────────────────────────────────────────────────────────
                 DAL AUTHORITY LEGEND COMPONENT
            ────────────────────────────────────────────────────────── --}}
            @include('dal.partials.legend')

            {{-- ──────────────────────────────────────────────────────────
                 ENTRIES TABLE MATRIX
            ────────────────────────────────────────────────────────── --}}
            @if($entries->isEmpty())
                <div style="background:white;border-radius:16px;padding:60px 20px;text-align:center;border:1px solid #e2e8f0;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
                    <div style="width:54px;height:54px;border-radius:14px;background:#eff6ff;display:inline-flex;align-items:center;justify-content:center;margin-bottom:14px;">
                        <svg style="width:26px;height:26px;fill:#0b3b63;" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                    </div>
                    <h3 style="font-size:16px;font-weight:700;color:#1e293b;margin-bottom:6px;">No entries found in {{ $currentCategoryMeta['full_title'] }}</h3>
                    <p style="font-size:13px;color:#64748b;max-width:440px;margin:0 auto 20px;">
                        {{ $search || $country || $approver ? 'No clauses matched your active search or filter criteria. Try clearing search filters.' : 'There are currently no Delegation of Authority entries configured under this category.' }}
                    </p>
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('dal.manage.create', ['category' => $category === 'all' ? 'corporate_matter' : $category]) }}"
                           style="display:inline-flex;align-items:center;gap:7px;background:#0b3b63;color:#f7d768;font-weight:700;font-size:13.5px;padding:10px 22px;border-radius:10px;text-decoration:none;">
                            + Add Clause
                        </a>
                    @endif
                </div>
            @else
                @php
                    $allCountryCols = [
                        'MY' => ['col' => 'malaysia',  'label' => '🇲🇾 Malaysia',  'min_width' => '105px'],
                        'SG' => ['col' => 'singapore', 'label' => '🇸🇬 Singapore', 'min_width' => '105px'],
                        'AU' => ['col' => 'australia', 'label' => '🇦🇺 Australia', 'min_width' => '105px'],
                        'VN' => ['col' => 'vietnam',   'label' => '🇻🇳 Vietnam',   'min_width' => '105px'],
                        'JP' => ['col' => 'japan',     'label' => '🇯🇵 Japan',     'min_width' => '105px'],
                    ];

                    if (!empty($country) && isset($allCountryCols[$country])) {
                        $visibleCountryCols = [$country => $allCountryCols[$country]];
                    } else {
                        $visibleCountryCols = $allCountryCols;
                    }
                @endphp
                <div style="background:white;border-radius:16px;box-shadow:0 1px 4px rgba(0,0,0,0.06);border:1px solid #e2e8f0;overflow:hidden;">
                    {{-- Mobile swipe guidance banner --}}
                    <div class="mobile-swipe-banner">
                        <svg style="width:14px;height:14px;fill:currentColor;flex-shrink:0;" viewBox="0 0 24 24"><path d="M10 9h4V6h3l-5-5-5 5h3v3zm-1 1H6V7l-5 5 5 5v-3h3v-4zm14 2l-5-5v3h-3v4h3v3l5-5zm-9 3h-4v3H7l5 5 5-5h-3v-3z"/></svg>
                        <span>Swipe horizontally to view full matrix &amp; all approval limits &rarr;</span>
                    </div>

                    <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
                        <table style="width:100%;border-collapse:collapse;font-size:12px;text-align:left;">
                            <thead>
                                <tr style="background:#0b3b63;color:#f8fafc;">
                                    <th style="padding:12px 14px;font-weight:700;min-width:220px;">Section / Activity</th>
                                    <th style="padding:12px 8px;font-weight:700;text-align:center;width:45px;">#</th>
                                    @foreach($visibleCountryCols as $cCode => $cMeta)
                                        <th style="padding:12px 10px;font-weight:700;min-width:{{ $cMeta['min_width'] }};">
                                            {{ $cMeta['label'] }}
                                        </th>
                                    @endforeach

                                    {{-- Approver Headers --}}
                                    @foreach(\App\Models\DalEntry::$approverColumns as $appCol => $appLabel)
                                        <th style="padding:12px 6px;font-weight:700;text-align:center;min-width:40px;font-size:11px;" title="{{ $appLabel }}">
                                            {{ $appLabel }}
                                        </th>
                                    @endforeach

                                    <th style="padding:12px 14px;font-weight:700;min-width:160px;">Remarks</th>
                                    @if(auth()->user()->is_admin)
                                        <th style="padding:12px 14px;font-weight:700;text-align:center;min-width:90px;">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $currentSection = null; @endphp
                                @foreach($entries as $entry)
                                    @php
                                        $isNewSection = ($currentSection !== $entry->section_title);
                                        if ($isNewSection) {
                                            $currentSection = $entry->section_title;
                                        }
                                    @endphp

                                    @if($isNewSection)
                                        @php
                                            $entryCatMeta = \App\Models\DalEntry::getCategory($entry->category);
                                        @endphp
                                        <tr style="background:#f1f5f9;border-top:2px solid #cbd5e1;border-bottom:1px solid #e2e8f0;">
                                            <td colspan="{{ 3 + count($visibleCountryCols) + count(\App\Models\DalEntry::$approverColumns) + (auth()->user()->is_admin ? 1 : 0) }}"
                                                style="padding:10px 14px;font-weight:800;font-size:13px;color:#0b3b63;">
                                                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                                    <span>📌 {{ $entry->section_title }}</span>
                                                    @if($category === 'all')
                                                        <span style="font-size:10.5px;padding:2px 8px;border-radius:6px;background:rgba(11,59,99,0.1);color:#0b3b63;font-weight:700;">
                                                            {{ $entryCatMeta['full_title'] ?? $entry->category }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endif

                                    <tr style="border-bottom:1px solid #f1f5f9;transition:background 0.1s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                                        <td style="padding:10px 14px;color:#475569;vertical-align:middle;">
                                            {{ $entry->section_title }}
                                        </td>
                                        <td style="padding:10px 8px;text-align:center;font-weight:700;color:#0b3b63;vertical-align:middle;">
                                            {{ $entry->row_number }}
                                        </td>
                                        @foreach($visibleCountryCols as $cCode => $cMeta)
                                            @php $cCol = $cMeta['col']; @endphp
                                            <td style="padding:10px;color:#1e293b;font-weight:500;vertical-align:middle;">
                                                {{ $entry->$cCol ?: '-' }}
                                            </td>
                                        @endforeach

                                        {{-- Approver Cells --}}
                                        @foreach(\App\Models\DalEntry::$approverColumns as $appCol => $appLabel)
                                            @php
                                                $val = trim((string)$entry->$appCol);
                                                $bg = 'transparent';
                                                $fg = '#64748b';
                                                if (str_starts_with($val, 'A')) { $bg = '#dcfce7'; $fg = '#15803d'; }
                                                elseif (str_starts_with($val, 'R')) { $bg = '#fef3c7'; $fg = '#b45309'; }
                                                elseif (str_starts_with($val, 'P')) { $bg = '#dbeafe'; $fg = '#1d4ed8'; }
                                                elseif (str_starts_with($val, 'E')) { $bg = '#f3e8ff'; $fg = '#7e22ce'; }
                                                elseif (str_starts_with($val, 'N')) { $bg = '#f1f5f9'; $fg = '#475569'; }
                                            @endphp
                                            <td style="padding:10px 4px;text-align:center;vertical-align:middle;">
                                                @if(filled($val))
                                                    <span style="display:inline-block;padding:2px 6px;border-radius:4px;font-weight:700;font-size:11px;background:{{ $bg }};color:{{ $fg }};">
                                                        {{ $val }}
                                                    </span>
                                                @else
                                                    <span style="color:#cbd5e1;">-</span>
                                                @endif
                                            </td>
                                        @endforeach

                                        <td style="padding:10px 14px;color:#64748b;font-size:11.5px;line-height:1.4;vertical-align:middle;">
                                            {{ $entry->remarks ?: '-' }}
                                        </td>

                                        @if(auth()->user()->is_admin)
                                            <td style="padding:10px 14px;text-align:center;vertical-align:middle;white-space:nowrap;">
                                                <a href="{{ route('dal.manage.edit', $entry) }}"
                                                   style="color:#0b3b63;font-weight:700;text-decoration:none;margin-right:8px;" title="Edit">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('dal.manage.destroy', $entry) }}" style="display:inline;"
                                                      onsubmit="return confirm('Are you sure you want to delete this clause (Row {{ $entry->row_number }})?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="color:#dc2626;background:none;border:none;cursor:pointer;font-weight:600;font-size:12px;padding:0;">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleDalLegend() {
            const legendBox = document.getElementById('dal-legend-box');
            if (legendBox) {
                if (legendBox.style.display === 'none') {
                    legendBox.style.display = 'block';
                } else {
                    legendBox.style.display = 'none';
                }
            }
        }
    </script>
</x-app-layout>
