<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * DAL Categories mapped to this Department.
     */
    public function dalCategories()
    {
        return $this->belongsToMany(DalCategory::class, 'dal_category_department')
            ->withTimestamps();
    }

    /**
     * Users belonging to this department.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Scope active departments.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Find or create/sync a department from an SSO department claim.
     */
    public static function findOrSyncFromSso(?string $deptName): ?self
    {
        if (blank($deptName)) {
            return null;
        }

        $trimmed = trim($deptName);

        // Try exact match by name
        $dept = self::where('name', $trimmed)->first();
        if ($dept) {
            return $dept;
        }

        // Try match by code or normalized name
        $codeGuess = strtoupper(Str::slug(substr($trimmed, 0, 20), '_'));
        $dept = self::where('code', $codeGuess)->first();
        if ($dept) {
            return $dept;
        }

        // Auto-provision new department if not found
        return self::create([
            'code'        => $codeGuess,
            'name'        => $trimmed,
            'description' => 'Auto-synced from Enterprise SSO (Azure AD)',
            'is_active'   => true,
        ]);
    }
}
