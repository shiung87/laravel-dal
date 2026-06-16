<x-app-layout>
    <x-slot name="header">
        <div style="display:flex;align-items:center;gap:12px;">
            <a href="{{ route('dal.manage.index') }}"
               style="width:32px;height:32px;border-radius:8px;background:#f1f5f9;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;color:#64748b;text-decoration:none;transition:background 0.15s;"
               onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'"
               title="Back to DAL Manage">
                <svg style="width:16px;height:16px;fill:currentColor;" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
            </a>
            <div>
                <h2 style="font-size:18px;font-weight:700;color:#0b3b63;">Add DAL Entry</h2>
                <p style="font-size:13px;color:#94a3b8;margin-top:2px;">Create a new Delegation of Authority record.</p>
            </div>
        </div>
    </x-slot>

    <div style="max-width:900px;">
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:16px;padding:28px 32px;box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <form method="POST" action="{{ route('dal.manage.store') }}" id="create-dal-form">
                @csrf
                @include('dal._form', ['approverColumns' => $approverColumns, 'isCreate' => true])

                <div style="display:flex;gap:12px;margin-top:28px;padding-top:20px;border-top:1px solid #f1f5f9;">
                    <button type="submit" id="create-dal-btn"
                        style="display:inline-flex;align-items:center;gap:7px;background:linear-gradient(135deg,#0b3b63,#1e5f94);color:#f7d768;border:none;border-radius:10px;font-family:inherit;font-size:14px;font-weight:700;padding:11px 28px;cursor:pointer;box-shadow:0 4px 12px rgba(11,59,99,0.25);transition:opacity 0.2s,transform 0.15s;"
                        onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">
                        <svg style="width:15px;height:15px;fill:currentColor;" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                        Save Entry
                    </button>
                    <a href="{{ route('dal.manage.index') }}"
                       style="display:inline-flex;align-items:center;padding:11px 22px;background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;border-radius:10px;font-size:14px;font-weight:600;text-decoration:none;transition:background 0.15s;"
                       onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
