<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'is_admin', 'is_sso', 'department_id', 'department_name'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
            'is_sso'            => 'boolean',
        ];
    }

    /**
     * Check whether this account is authenticated via Enterprise Single Sign-On (Azure AD).
     */
    public function isSso(): bool
    {
        return (bool) $this->is_sso;
    }

    /**
     * Department this user belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the DAL Categories mapped to this user's department.
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\DalCategory>
     */
    public function mappedDalCategories()
    {
        if ($this->department_id && $this->department) {
            return $this->department->dalCategories()->where('is_active', true)->ordered()->get();
        }

        return collect();
    }

    /**
     * Get the primary DAL category slug mapped to this user's department.
     */
    public function primaryDalCategorySlug(): ?string
    {
        $mapped = $this->mappedDalCategories();
        if ($mapped->isNotEmpty()) {
            return $mapped->first()->slug;
        }

        return null;
    }
}

