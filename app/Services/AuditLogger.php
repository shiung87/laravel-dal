<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;

class AuditLogger
{
    /**
     * Write a single audit entry.
     *
     * @param  string      $action       e.g. 'dal_create', 'login'
     * @param  Model|null  $subject      Eloquent model being acted on (optional)
     * @param  array|null  $oldValues    Field values before the change
     * @param  array|null  $newValues    Field values after the change
     * @param  string|null $subjectLabel Human-readable identifier override
     */
    public static function log(
        string  $action,
        ?Model  $subject    = null,
        ?array  $oldValues  = null,
        ?array  $newValues  = null,
        ?string $subjectLabel = null,
    ): void {
        $user = Auth::user();

        ActivityLog::create([
            'user_id'       => $user?->id,
            'user_name'     => $user?->name,
            'user_email'    => $user?->email,
            'action'        => $action,
            'subject_type'  => $subject ? class_basename($subject) : null,
            'subject_id'    => $subject?->getKey(),
            'subject_label' => $subjectLabel ?? self::resolveLabel($subject),
            'old_values'    => $oldValues,
            'new_values'    => $newValues,
            'ip_address'    => RequestFacade::ip(),
            'user_agent'    => RequestFacade::userAgent(),
        ]);
    }

    /**
     * Extract only the fields that actually changed between old and new data.
     * Returns ['old' => [...], 'new' => [...]] containing only dirty fields.
     */
    public static function diff(array $original, array $updated, array $exclude = []): array
    {
        $exclude = array_merge(['updated_at', 'created_at', 'updated_by'], $exclude);
        $old = [];
        $new = [];

        foreach ($updated as $key => $newVal) {
            if (in_array($key, $exclude)) {
                continue;
            }
            $oldVal = $original[$key] ?? null;
            if ($oldVal != $newVal) {
                $old[$key] = $oldVal;
                $new[$key] = $newVal;
            }
        }

        return ['old' => $old ?: null, 'new' => $new ?: null];
    }

    /**
     * Derive a human-readable label from common model fields.
     */
    private static function resolveLabel(?Model $subject): ?string
    {
        if ($subject === null) {
            return null;
        }

        // User
        if (isset($subject->name) && isset($subject->email)) {
            return "{$subject->name} ({$subject->email})";
        }

        // DalEntry
        if (isset($subject->section_title)) {
            return $subject->section_title . ($subject->row_number ? " #" . $subject->row_number : '');
        }

        return class_basename($subject) . ' #' . $subject->getKey();
    }
}
