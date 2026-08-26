<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DalCategory;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminDalCategoryController extends Controller
{
    public function index()
    {
        $categories = DalCategory::withCount('departments')->ordered()->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'        => ['required', 'string', 'max:30'],
            'name'        => ['required', 'string', 'max:100'],
            'slug'        => ['nullable', 'string', 'max:60', 'unique:dal_categories,slug'],
            'short_title' => ['nullable', 'string', 'max:100'],
            'badge_color' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string'],
            'sort_order'  => ['nullable', 'integer'],
        ]);

        $slug = filled($validated['slug'] ?? null)
            ? Str::slug($validated['slug'], '_')
            : Str::slug($validated['name'], '_');

        $fullTitle = trim($validated['code'] . ' ' . $validated['name']);
        $shortTitle = filled($validated['short_title'] ?? null) ? $validated['short_title'] : $fullTitle;

        $category = DalCategory::create([
            'code'        => $validated['code'],
            'slug'        => $slug,
            'name'        => $validated['name'],
            'full_title'  => $fullTitle,
            'short_title' => $shortTitle,
            'badge_color' => $validated['badge_color'] ?: 'blue',
            'icon'        => 'folder',
            'description' => $validated['description'] ?? null,
            'sort_order'  => $validated['sort_order'] ?? (DalCategory::max('sort_order') + 1),
            'is_active'   => true,
        ]);

        AuditLogger::log('create_dal_category', auth()->user(), [
            'category_id' => $category->id,
            'code'        => $category->code,
            'slug'        => $category->slug,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', "DAL Category \"{$category->full_title}\" created successfully.");
    }

    public function update(Request $request, DalCategory $category)
    {
        $validated = $request->validate([
            'code'        => ['required', 'string', 'max:30'],
            'name'        => ['required', 'string', 'max:100'],
            'short_title' => ['nullable', 'string', 'max:100'],
            'badge_color' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string'],
            'sort_order'  => ['nullable', 'integer'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $fullTitle = trim($validated['code'] . ' ' . $validated['name']);
        $shortTitle = filled($validated['short_title'] ?? null) ? $validated['short_title'] : $fullTitle;

        $category->update([
            'code'        => $validated['code'],
            'name'        => $validated['name'],
            'full_title'  => $fullTitle,
            'short_title' => $shortTitle,
            'badge_color' => $validated['badge_color'] ?: $category->badge_color,
            'description' => $validated['description'] ?? null,
            'sort_order'  => $validated['sort_order'] ?? $category->sort_order,
            'is_active'   => $request->has('is_active') ? (bool) $request->input('is_active') : $category->is_active,
        ]);

        AuditLogger::log('update_dal_category', auth()->user(), [
            'category_id' => $category->id,
            'code'        => $category->code,
            'slug'        => $category->slug,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', "DAL Category \"{$category->full_title}\" updated successfully.");
    }

    public function toggleActive(DalCategory $category)
    {
        $category->is_active = !$category->is_active;
        $category->save();

        AuditLogger::log('toggle_dal_category_status', auth()->user(), [
            'category_id' => $category->id,
            'is_active'   => $category->is_active,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', "DAL Category \"{$category->full_title}\" status updated to " . ($category->is_active ? 'Active' : 'Inactive') . ".");
    }

    public function destroy(DalCategory $category)
    {
        $title = $category->full_title;
        $category->delete();

        AuditLogger::log('delete_dal_category', auth()->user(), [
            'category_id' => $category->id,
            'title'       => $title,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', "DAL Category \"{$title}\" deleted successfully.");
    }
}
