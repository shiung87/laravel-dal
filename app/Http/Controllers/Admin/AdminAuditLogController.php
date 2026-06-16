<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminAuditLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $action = $request->input('action', '');

        $query = ActivityLog::with('user')
            ->orderBy('created_at', 'desc');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('user_name',     'like', "%{$search}%")
                  ->orWhere('user_email',  'like', "%{$search}%")
                  ->orWhere('subject_label','like', "%{$search}%")
                  ->orWhere('ip_address',  'like', "%{$search}%");
            });
        }

        if ($action !== '') {
            $query->where('action', $action);
        }

        $logs    = $query->paginate(25)->withQueryString();
        $actions = ActivityLog::$actionLabels;

        return view('admin.audit-log', compact('logs', 'search', 'action', 'actions'));
    }
}
