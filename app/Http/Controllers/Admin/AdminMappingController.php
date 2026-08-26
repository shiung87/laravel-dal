<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DalCategory;
use App\Models\Department;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class AdminMappingController extends Controller
{
    public function index()
    {
        $departments = Department::active()->with('dalCategories')->orderBy('name')->get();
        $categories  = DalCategory::active()->ordered()->get();

        return view('admin.mappings.index', compact('departments', 'categories'));
    }

    public function update(Request $request)
    {
        $mappings = $request->input('mappings', []); // format: [dept_id => [cat_id1, cat_id2]]

        $departments = Department::all();

        foreach ($departments as $dept) {
            $catIds = $mappings[$dept->id] ?? [];
            $dept->dalCategories()->sync($catIds);
        }

        AuditLogger::log('update_category_department_mappings', auth()->user(), [
            'department_count' => $departments->count(),
        ]);

        return redirect()->route('admin.mappings.index')
            ->with('success', 'Department to DAL Category mappings updated successfully.');
    }
}
