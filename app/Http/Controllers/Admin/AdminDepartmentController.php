<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DalCategory;
use App\Models\Department;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminDepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('dalCategories')->withCount('users')->orderBy('name')->get();
        $categories  = DalCategory::active()->ordered()->get();

        return view('admin.departments.index', compact('departments', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'        => ['required', 'string', 'max:50', 'unique:departments,code'],
            'name'        => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'categories'  => ['nullable', 'array'],
            'categories.*'=> ['exists:dal_categories,id'],
        ]);

        $code = strtoupper(trim($validated['code']));

        $department = Department::create([
            'code'        => $code,
            'name'        => trim($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active'   => true,
        ]);

        if (!empty($validated['categories'])) {
            $department->dalCategories()->sync($validated['categories']);
        }

        AuditLogger::log('create_department', auth()->user(), [
            'department_id' => $department->id,
            'code'          => $department->code,
            'name'          => $department->name,
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success', "Department \"{$department->name}\" created successfully.");
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'code'        => ['required', 'string', 'max:50', 'unique:departments,code,' . $department->id],
            'name'        => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['nullable', 'boolean'],
            'categories'  => ['nullable', 'array'],
            'categories.*'=> ['exists:dal_categories,id'],
        ]);

        $code = strtoupper(trim($validated['code']));
        $name = trim($validated['name']);

        $department->update([
            'code'        => $code,
            'name'        => $name,
            'description' => $validated['description'] ?? null,
            'is_active'   => $request->has('is_active') ? (bool) $request->input('is_active') : $department->is_active,
        ]);

        $department->dalCategories()->sync($validated['categories'] ?? []);

        // Also keep users table department_name in sync
        \App\Models\User::where('department_id', $department->id)->update([
            'department_name' => $name
        ]);

        AuditLogger::log('update_department', auth()->user(), [
            'department_id' => $department->id,
            'code'          => $department->code,
            'name'          => $department->name,
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success', "Department \"{$department->name}\" updated successfully.");
    }

    public function toggleActive(Department $department)
    {
        $department->is_active = !$department->is_active;
        $department->save();

        AuditLogger::log('toggle_department_status', auth()->user(), [
            'department_id' => $department->id,
            'is_active'     => $department->is_active,
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success', "Department \"{$department->name}\" status updated to " . ($department->is_active ? 'Active' : 'Inactive') . ".");
    }

    public function destroy(Department $department)
    {
        $name = $department->name;
        $department->delete();

        AuditLogger::log('delete_department', auth()->user(), [
            'department_id' => $department->id,
            'name'          => $name,
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success', "Department \"{$name}\" deleted successfully.");
    }
}
