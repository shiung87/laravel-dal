<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DalCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'slug',
        'name',
        'full_title',
        'short_title',
        'badge_color',
        'icon',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
    ];

    /**
     * Departments mapped to this DAL Category.
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'dal_category_department')
            ->withTimestamps();
    }

    /**
     * Scope active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordered categories.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Get all active categories as an associative array keyed by slug.
     */
    public static function getTaxonomyArray(): array
    {
        try {
            $categories = self::active()->ordered()->get();
            if ($categories->isNotEmpty()) {
                $result = [];
                foreach ($categories as $cat) {
                    $result[$cat->slug] = [
                        'id'          => $cat->id,
                        'code'        => $cat->code,
                        'name'        => $cat->name,
                        'full_title'  => $cat->full_title,
                        'short_title' => $cat->short_title,
                        'badge_color' => $cat->badge_color,
                        'icon'        => $cat->icon,
                        'description' => $cat->description,
                        'sort_order'  => $cat->sort_order,
                    ];
                }
                return $result;
            }
        } catch (\Throwable $e) {
            // Fallback during initial setup or migration
        }

        return DalEntry::$categories;
    }
}
