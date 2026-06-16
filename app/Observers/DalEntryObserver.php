<?php

namespace App\Observers;

use App\Models\DalEntry;
use App\Services\AuditLogger;

class DalEntryObserver
{
    /**
     * In-memory store of original values, keyed by model ID.
     * Using static avoids any interaction with Eloquent's attribute system.
     *
     * @var array<int, array<string, mixed>>
     */
    private static array $originals = [];

    /**
     * Called after a new DAL entry is saved.
     */
    public function created(DalEntry $entry): void
    {
        AuditLogger::log(
            action:    'dal_create',
            subject:   $entry,
            newValues: $entry->toArray(),
        );
    }

    /**
     * Called just BEFORE an update is written to the DB.
     * Snapshot the original (pre-change) values into the static store.
     */
    public function updating(DalEntry $entry): void
    {
        self::$originals[$entry->getKey()] = $entry->getOriginal();
    }

    /**
     * Called AFTER the update is written.
     * Diff the snapshot against the new state and log changed fields only.
     */
    public function updated(DalEntry $entry): void
    {
        $original = self::$originals[$entry->getKey()] ?? $entry->getOriginal();

        // Clean up the snapshot immediately
        unset(self::$originals[$entry->getKey()]);

        $diff = AuditLogger::diff($original, $entry->toArray());

        if ($diff['old'] || $diff['new']) {
            AuditLogger::log(
                action:    'dal_update',
                subject:   $entry,
                oldValues: $diff['old'],
                newValues: $diff['new'],
            );
        }
    }

    /**
     * Called after a DAL entry is deleted.
     * Log the full snapshot so there's a permanent record even after deletion.
     */
    public function deleted(DalEntry $entry): void
    {
        AuditLogger::log(
            action:    'dal_delete',
            subject:   $entry,
            oldValues: $entry->toArray(),
        );
    }
}
