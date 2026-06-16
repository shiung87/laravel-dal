<style>
    .del-btn-danger {
        display: inline-flex; align-items: center; gap: 6px;
        background: #fef2f2; color: #dc2626;
        border: 1px solid #fecaca; border-radius: 10px;
        font-family: inherit; font-size: 14px; font-weight: 700;
        padding: 10px 20px; cursor: pointer;
        transition: background 0.15s, border-color 0.15s, transform 0.12s;
    }
    .del-btn-danger:hover { background: #fee2e2; border-color: #fca5a5; transform: translateY(-1px); }

    /* Modal overlay */
    .del-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.4); backdrop-filter: blur(4px);
        z-index: 500; align-items: center; justify-content: center;
    }
    .del-overlay.open { display: flex; }
    .del-modal {
        background: #fff; border-radius: 18px;
        padding: 32px; width: 100%; max-width: 440px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        animation: delIn 0.2s ease;
    }
    @keyframes delIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
    .del-modal h3 { font-size:17px; font-weight:700; color:#0f172a; margin-bottom:8px; }
    .del-modal p  { font-size:13.5px; color:#64748b; line-height:1.6; margin-bottom:22px; }
    .del-input {
        width: 100%; border: 1px solid #e2e8f0; border-radius: 10px;
        font-size: 14px; padding: 10px 14px; color: #1e293b;
        background: #f8fafc; font-family: inherit; outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        margin-bottom: 6px;
    }
    .del-input:focus { border-color: #dc2626; box-shadow: 0 0 0 3px rgba(220,38,38,0.1); background:#fff; }
    .del-error { color: #dc2626; font-size: 12px; margin-bottom: 18px; }
    .del-modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px; }
    .del-btn-cancel {
        background: #f1f5f9; color: #475569; border: none; border-radius: 10px;
        font-family: inherit; font-size: 14px; font-weight: 600;
        padding: 10px 20px; cursor: pointer;
        transition: background 0.15s;
    }
    .del-btn-cancel:hover { background: #e2e8f0; }
    .del-btn-confirm {
        background: #dc2626; color: #fff; border: none; border-radius: 10px;
        font-family: inherit; font-size: 14px; font-weight: 700;
        padding: 10px 20px; cursor: pointer;
        transition: opacity 0.15s, transform 0.12s;
    }
    .del-btn-confirm:hover { opacity: 0.88; transform: translateY(-1px); }
</style>

<p style="font-size:13.5px;color:#64748b;line-height:1.6;margin-bottom:20px;">
    Once your account is deleted, all data will be permanently removed. This action cannot be undone.
</p>

<button type="button" class="del-btn-danger" id="open-delete-modal">
    <svg style="width:14px;height:14px;fill:currentColor;" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
    Delete My Account
</button>

{{-- Custom modal --}}
<div class="del-overlay" id="delete-modal-overlay" role="dialog" aria-modal="true">
    <div class="del-modal">
        <h3>⚠ Delete your account?</h3>
        <p>This will permanently delete your account and all associated data. Please enter your password to confirm.</p>

        <form method="post" action="{{ route('profile.destroy') }}" id="delete-account-form">
            @csrf
            @method('delete')

            <label style="display:block;font-size:12px;font-weight:600;color:#475569;margin-bottom:6px;" for="del-password">Password</label>
            <input id="del-password" name="password" type="password"
                   class="del-input {{ $errors->userDeletion->has('password') ? 'border-red-400' : '' }}"
                   placeholder="Enter your password to confirm">
            @if ($errors->userDeletion->has('password'))
                <p class="del-error">{{ $errors->userDeletion->first('password') }}</p>
            @endif

            <div class="del-modal-actions">
                <button type="button" class="del-btn-cancel" id="cancel-delete-modal">Cancel</button>
                <button type="submit" class="del-btn-confirm" id="confirm-delete-btn">Yes, Delete Account</button>
            </div>
        </form>
    </div>
</div>

<script>
    const delOverlay  = document.getElementById('delete-modal-overlay');
    const openDelBtn  = document.getElementById('open-delete-modal');
    const cancelDelBtn = document.getElementById('cancel-delete-modal');

    function openDelModal()  { delOverlay.classList.add('open');    document.body.style.overflow = 'hidden'; }
    function closeDelModal() { delOverlay.classList.remove('open'); document.body.style.overflow = ''; }

    openDelBtn.addEventListener('click', openDelModal);
    cancelDelBtn.addEventListener('click', closeDelModal);
    delOverlay.addEventListener('click', (e) => { if (e.target === delOverlay) closeDelModal(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeDelModal(); });

    // Auto-open if there are validation errors for deletion
    @if ($errors->userDeletion->isNotEmpty())
        openDelModal();
    @endif
</script>
