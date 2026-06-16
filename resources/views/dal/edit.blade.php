<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:12px;">
            <a href="{{ route('dal.manage.index', ['type' => $dalEntry->type]) }}"
               style="width:32px;height:32px;border-radius:8px;background:#f1f5f9;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;color:#64748b;text-decoration:none;transition:background 0.15s;"
               onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'"
               title="Back to DAL Manage">
                <svg style="width:16px;height:16px;fill:currentColor;" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
            </a>
            <div>
                <h2 style="font-size:18px;font-weight:700;color:#0b3b63;">Edit DAL Entry <span style="color:#94a3b8;font-weight:500;">#{{ $dalEntry->id }}</span></h2>
                <p style="font-size:13px;color:#94a3b8;margin-top:2px;">{{ $dalEntry->section_title }}</p>
            </div>
        </div>
    </x-slot>

    <div style="max-width:900px;">

        {{-- ── LEGEND ── --}}
        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;padding:16px 24px;margin-bottom:16px;box-shadow:0 1px 3px rgba(0,0,0,0.04);">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <svg style="width:15px;height:15px;fill:#0b3b63;flex-shrink:0;" viewBox="0 0 24 24"><path d="M11 17h2v-6h-2v6zm1-15C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM11 9h2V7h-2v2z"/></svg>
                <span style="font-size:12px;font-weight:700;color:#0b3b63;letter-spacing:0.06em;text-transform:uppercase;">Legend</span>
            </div>
            <table style="width:100%;border-collapse:collapse;font-size:12.5px;">
                <thead>
                    <tr>
                        <th style="text-align:left;padding:4px 16px 8px 0;font-weight:600;color:#94a3b8;font-size:11.5px;width:90px;">Code</th>
                        <th style="text-align:left;padding:4px 0 8px;font-weight:600;color:#94a3b8;font-size:11.5px;">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-top:1px solid #e2e8f0;">
                        <td style="padding:9px 16px 9px 0;vertical-align:middle;">
                            <span style="display:inline-block;background:#eff6ff;color:#1d4ed8;border:1.5px solid #93c5fd;border-radius:8px;padding:3px 10px;font-size:12px;font-weight:700;letter-spacing:0.03em;">A / JA</span>
                        </td>
                        <td style="padding:9px 0;color:#374151;vertical-align:middle;">Approve / Joint Approval</td>
                    </tr>
                    <tr style="border-top:1px solid #e2e8f0;">
                        <td style="padding:9px 16px 9px 0;vertical-align:middle;">
                            <span style="display:inline-block;background:#f0fdf4;color:#15803d;border:1.5px solid #86efac;border-radius:8px;padding:3px 10px;font-size:12px;font-weight:700;letter-spacing:0.03em;">R / JR</span>
                        </td>
                        <td style="padding:9px 0;color:#374151;vertical-align:middle;">Recommend / Joint Recommendation</td>
                    </tr>
                    <tr style="border-top:1px solid #e2e8f0;">
                        <td style="padding:9px 16px 9px 0;vertical-align:middle;">
                            <span style="display:inline-block;background:#fefce8;color:#a16207;border:1.5px solid #fde047;border-radius:8px;padding:3px 10px;font-size:12px;font-weight:700;letter-spacing:0.03em;">P / JP</span>
                        </td>
                        <td style="padding:9px 0;color:#374151;vertical-align:middle;">Propose / Joint Proposal</td>
                    </tr>
                    <tr style="border-top:1px solid #e2e8f0;">
                        <td style="padding:9px 16px 9px 0;vertical-align:middle;">
                            <span style="display:inline-block;background:#faf5ff;color:#7c3aed;border:1.5px solid #c4b5fd;border-radius:8px;padding:3px 10px;font-size:12px;font-weight:700;letter-spacing:0.03em;">I</span>
                        </td>
                        <td style="padding:9px 0;color:#374151;vertical-align:middle;">Inform</td>
                    </tr>
                    <tr style="border-top:1px solid #e2e8f0;">
                        <td style="padding:9px 16px 9px 0;vertical-align:middle;">
                            <span style="display:inline-block;background:#fff7ed;color:#c2410c;border:1.5px solid #fdba74;border-radius:8px;padding:3px 10px;font-size:12px;font-weight:700;letter-spacing:0.03em;">#</span>
                        </td>
                        <td style="padding:9px 0;color:#374151;vertical-align:middle;">Either one to approve / recommend / propose based on the endorsed reporting line</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:28px 32px;box-shadow:0 1px 4px rgba(0,0,0,0.05);">

            {{-- ── UPDATE FORM ── --}}
            <form method="POST" action="{{ route('dal.manage.update', $dalEntry) }}" id="edit-dal-form">
                @csrf
                @method('PUT')
                @include('dal._form', ['approverColumns' => $approverColumns, 'entry' => $dalEntry])

                <div style="display:flex;align-items:center;gap:12px;margin-top:28px;padding-top:20px;border-top:1px solid #f1f5f9;">
                    <button type="submit" id="update-dal-btn"
                        style="display:inline-flex;align-items:center;gap:7px;background:linear-gradient(135deg,#0b3b63,#1e5f94);color:#f7d768;border:none;border-radius:10px;font-family:inherit;font-size:14px;font-weight:700;padding:11px 28px;cursor:pointer;box-shadow:0 4px 12px rgba(11,59,99,0.25);transition:opacity 0.2s,transform 0.15s;"
                        onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">
                        <svg style="width:15px;height:15px;fill:currentColor;" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                        Update Entry
                    </button>

                    <a href="{{ route('dal.manage.index', ['type' => $dalEntry->type]) }}"
                       style="display:inline-flex;align-items:center;padding:11px 22px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;border-radius:10px;font-size:14px;font-weight:600;text-decoration:none;transition:background 0.15s;"
                       onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                        Cancel
                    </a>

                    {{-- Delete button triggers the separate delete form below (outside this form) --}}
                    <button type="button" id="delete-dal-btn"
                        onclick="document.getElementById('delete-dal-form').dispatchEvent(new Event('submit', {cancelable:true, bubbles:true}))"
                        style="margin-left:auto;display:inline-flex;align-items:center;gap:6px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;border-radius:10px;font-family:inherit;font-size:14px;font-weight:600;padding:11px 20px;cursor:pointer;transition:background 0.15s,border-color 0.15s,transform 0.12s;"
                        onmouseover="this.style.background='#fee2e2';this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.background='#fef2f2';this.style.transform=''">
                        <svg style="width:14px;height:14px;fill:currentColor;" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                        Delete Entry
                    </button>
                </div>
            </form>

            {{-- ── DELETE FORM — kept OUTSIDE the update form to avoid nested-form conflicts ── --}}
            <form method="POST" action="{{ route('dal.manage.destroy', $dalEntry) }}"
                  id="delete-dal-form"
                  onsubmit="return confirm('Permanently delete this entry? This cannot be undone.')">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </div>
</x-app-layout>
