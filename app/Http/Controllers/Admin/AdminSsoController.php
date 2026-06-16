<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SsoSetting;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class AdminSsoController extends Controller
{
    public function show()
    {
        $sso = SsoSetting::current();
        return view('admin.sso', compact('sso'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'tenant_id'    => ['nullable', 'string', 'max:255'],
            'client_id'    => ['nullable', 'string', 'max:255'],
            'client_secret'=> ['nullable', 'string', 'max:500'],
            'redirect_uri' => ['nullable', 'url', 'max:500'],
            'enabled'      => ['boolean'],
        ]);

        $sso = SsoSetting::current();

        // Only overwrite client_secret if a new value was submitted
        if (empty($data['client_secret'])) {
            unset($data['client_secret']);
        }

        $wasEnabled = $sso->enabled;
        $sso->update($data);

        // Audit: log when SSO is toggled
        if ($wasEnabled !== $sso->enabled) {
            AuditLogger::log(
                action:    $sso->enabled ? 'sso_enabled' : 'sso_disabled',
                subject:   null,
                newValues: ['enabled' => $sso->enabled, 'tenant_id' => $sso->tenant_id],
            );
        }

        return back()->with('success', 'SSO settings saved successfully.');
    }
}
