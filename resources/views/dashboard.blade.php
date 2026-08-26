<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <div>
                <h2 style="font-size:20px;font-weight:800;color:#0b3b63;letter-spacing:-0.4px;">DAL Governance Dashboard</h2>
                <p style="font-size:13px;color:#64748b;margin-top:2px;">Welcome back, {{ Auth::user()->name }}! Select a category to inspect or manage authority limits.</p>
            </div>
            @if(Auth::user()->is_admin)
                <a href="{{ route('dal.manage.create') }}"
                   style="display:inline-flex;align-items:center;gap:7px;background:linear-gradient(135deg,#0b3b63,#1e5f94);color:#f7d768;font-weight:700;font-size:13.5px;padding:10px 20px;border-radius:10px;text-decoration:none;box-shadow:0 4px 12px rgba(11,59,99,0.25);">
                    <svg style="width:15px;height:15px;fill:currentColor;" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    Add DAL Clause
                </a>
            @endif
        </div>
    </x-slot>

    {{-- Flash messages --}}
    @if(session('error'))
        <div style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:14px;display:flex;align-items:center;gap:8px;">
            <svg style="width:16px;height:16px;fill:currentColor;flex-shrink:0;" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:14px;display:flex;align-items:center;gap:8px;">
            <svg style="width:16px;height:16px;fill:currentColor;flex-shrink:0;" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @php
        $user = auth()->user();
        $userMappedCats = $user ? $user->mappedDalCategories() : collect();
        $userMappedSlugs = $userMappedCats->pluck('slug')->toArray();

        $categoryCountsQuery = \App\Models\DalEntry::select('category', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->groupBy('category');

        if (!empty($userMappedSlugs)) {
            $categoryCountsQuery->whereIn('category', $userMappedSlugs);
        }
        $categoryCounts = $categoryCountsQuery->pluck('count', 'category')->toArray();

        if ($userMappedCats->isNotEmpty()) {
            $dashboardCategories = [];
            foreach ($userMappedCats as $cat) {
                $dashboardCategories[$cat->slug] = [
                    'code'        => $cat->code,
                    'name'        => $cat->name,
                    'full_title'  => $cat->full_title,
                    'description' => $cat->description,
                ];
            }
        } else {
            $dashboardCategories = \App\Models\DalCategory::getTaxonomyArray();
        }
    @endphp

    {{-- ──────────────────────────────────────────────────────────
         DEPARTMENT SSO SYNC RECOMMENDATION HERO
    ────────────────────────────────────────────────────────── --}}
    @if(auth()->user()->department && $userMappedCats->isNotEmpty())
        <div style="background:linear-gradient(135deg,#0b3b63,#1e5f94);border-radius:16px;padding:22px 26px;color:#fff;margin-bottom:24px;box-shadow:0 4px 16px rgba(11,59,99,0.2);">
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                <div>
                    <div style="font-size:12px;font-weight:700;color:#f7d768;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:4px;">
                        🏢 Synced Department
                    </div>
                    <h3 style="font-size:18px;font-weight:800;margin-bottom:6px;">
                        {{ auth()->user()->department->name }}
                    </h3>
                    <p style="font-size:13px;color:rgba(255,255,255,0.85);max-width:560px;">
                        Based on your corporate department, the following Delegation of Authority Limits (DAL) categories apply strictly to your functional governance area:
                    </p>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
                    @foreach($userMappedCats as $mCat)
                        <a href="{{ route('dal.manage.index', ['category' => $mCat->slug]) }}"
                           style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);color:#fff;padding:8px 14px;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;transition:background 0.15s;"
                           onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                            ⭐ {{ $mCat->full_title }} &rarr;
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- ──────────────────────────────────────────────────────────
         DAL CATEGORIES MATRIX GRID (Strictly Mapped or All)
    ────────────────────────────────────────────────────────── --}}
    <div style="margin-bottom:12px;display:flex;align-items:center;justify-content:space-between;">
        <h3 style="font-size:14px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#64748b;">
            {{ $userMappedCats->isNotEmpty() ? 'Your Department Governance Categories' : 'Corporate Authority Categories' }}
        </h3>
        <span style="font-size:12px;color:#94a3b8;font-weight:500;">
            {{ count($dashboardCategories) }} {{ Str::plural('Governance Area', count($dashboardCategories)) }}
        </span>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px;margin-bottom:28px;">
        @foreach($dashboardCategories as $catKey => $cat)
            @php
                $count = $categoryCounts[$catKey] ?? 0;
            @endphp
            <a href="{{ route('dal.manage.index', ['category' => $catKey]) }}"
               style="display:flex;flex-direction:column;justify-content:space-between;background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:20px 22px;text-decoration:none;transition:transform 0.15s,box-shadow 0.2s,border-color 0.2s;box-shadow:0 1px 4px rgba(0,0,0,0.05);"
               onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(11,59,99,0.12)';this.style.borderColor='#cbd5e1'"
               onmouseout="this.style.transform='';this.style.boxShadow='0 1px 4px rgba(0,0,0,0.05)';this.style.borderColor='#e2e8f0'">
                <div>
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                        <span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:800;background:rgba(11,59,99,0.08);color:#0b3b63;border:1px solid rgba(11,59,99,0.12);">
                            {{ $cat['code'] }}
                        </span>
                        <span style="font-size:12px;font-weight:700;color:{{ $count > 0 ? '#15803d' : '#94a3b8' }};background:{{ $count > 0 ? '#f0fdf4' : '#f8fafc' }};padding:2px 8px;border-radius:12px;">
                            {{ $count }} {{ Str::plural('clause', $count) }}
                        </span>
                    </div>

                    <h4 style="font-size:16px;font-weight:700;color:#0b3b63;margin-bottom:6px;">
                        {{ $cat['name'] }}
                    </h4>
                    <p style="font-size:12.5px;color:#64748b;line-height:1.5;margin-bottom:16px;">
                        {{ $cat['description'] ?? '' }}
                    </p>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;padding-top:12px;border-top:1px solid #f1f5f9;font-size:12.5px;font-weight:600;color:#1e5f94;">
                    <span>View Matrix &rarr;</span>
                    @if($catKey === 'finance')
                        <span style="font-size:11px;color:#94a3b8;font-weight:500;">CAPEX / OPEX / Treasury</span>
                    @endif
                </div>
            </a>
        @endforeach
    </div>

    {{-- Bottom helper cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;">
        <a href="{{ route('profile.edit') }}" id="card-profile"
           style="display:flex;align-items:center;gap:14px;background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:18px;text-decoration:none;transition:box-shadow 0.2s,transform 0.15s;box-shadow:0 1px 4px rgba(0,0,0,0.05);"
           onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">
            <div style="width:40px;height:40px;border-radius:10px;background:#f0fdf4;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:20px;height:20px;fill:#166534;" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <div>
                <div style="font-size:14px;font-weight:700;color:#166534;">My Account Profile</div>
                <div style="font-size:12px;color:#94a3b8;">View account details &amp; credentials</div>
            </div>
        </a>

        @if(Auth::user()->is_admin)
        <a href="{{ route('admin.dashboard') }}" id="card-admin"
           style="display:flex;align-items:center;gap:14px;background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:18px;text-decoration:none;transition:box-shadow 0.2s,transform 0.15s;box-shadow:0 1px 4px rgba(0,0,0,0.05);"
           onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">
            <div style="width:40px;height:40px;border-radius:10px;background:#f5f3ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:20px;height:20px;fill:#6d28d9;" viewBox="0 0 24 24"><path d="M12 1l2.65 5.37L21 7.64l-4.5 4.39L17.65 19 12 16.22 6.35 19l1.15-6.97L3 7.64l6.35-.27L12 1z"/></svg>
            </div>
            <div>
                <div style="font-size:14px;font-weight:700;color:#6d28d9;">System Administration</div>
                <div style="font-size:12px;color:#94a3b8;">Users, SSO, email notifications &amp; audit trail</div>
            </div>
        </a>
        @endif
    </div>

</x-app-layout>
