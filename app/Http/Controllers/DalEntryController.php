<?php

namespace App\Http\Controllers;

use App\Models\DalEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DalEntryController extends Controller
{
    /**
     * List DAL entries filtered by category, sub-type, country, approver, and keyword.
     */
    // Map country codes to their DB column names
    private const COUNTRY_COLUMNS = [
        'MY' => 'malaysia',
        'SG' => 'singapore',
        'AU' => 'australia',
        'VN' => 'vietnam',
        'JP' => 'japan',
    ];

    // Map approver filter keys to their DB column names
    private const APPROVER_COLUMNS = [
        'BOD'      => 'bod',
        'CEO'      => 'ceo',
        'DEP_CEO'  => 'deputy_ceo_coo',
        'SEVP'     => 'sevp',
        'EVP'      => 'evp',
        'DGM'      => 'dgm',
        'GM'       => 'gm',
        'DEP_GM'   => 'deputy_gm_head',
    ];

    public function index(Request $request)
    {
        $categories = DalEntry::$categories;
        $categoryKeys = array_keys($categories);

        $category = $request->query('category', 'finance');
        if (!in_array($category, $categoryKeys, true)) {
            $category = 'finance';
        }

        $type     = $request->query('type', ''); // for finance: 'capital', 'noncapital', 'treasury', or '' (all)
        $search   = $request->query('search', '');
        $country  = $request->query('country', '');
        $approver = $request->query('approver', '');

        $countryColumn  = self::COUNTRY_COLUMNS[$country]   ?? null;
        $approverColumn = self::APPROVER_COLUMNS[$approver] ?? null;

        // Fetch counts per category for the tab bar badges
        $categoryCounts = DalEntry::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        $entriesQuery = DalEntry::where('category', $category);

        if ($category === 'finance' && filled($type)) {
            $entriesQuery->where('type', $type);
        }

        $entries = $entriesQuery
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('section_title', 'like', "%{$search}%")
                  ->orWhere('malaysia',     'like', "%{$search}%")
                  ->orWhere('singapore',    'like', "%{$search}%")
                  ->orWhere('australia',    'like', "%{$search}%")
                  ->orWhere('vietnam',      'like', "%{$search}%")
                  ->orWhere('japan',        'like', "%{$search}%")
                  ->orWhere('remarks',      'like', "%{$search}%");
            }))
            ->when($countryColumn, fn ($q) =>
                $q->whereNotNull($countryColumn)
                  ->where($countryColumn, '!=', '-')
            )
            ->when($approverColumn, fn ($q) =>
                $q->whereNotNull($approverColumn)
                  ->where($approverColumn, '!=', '')
            )
            ->orderBy('section_title')
            ->orderBy('row_number')
            ->get();

        $currentCategoryMeta = DalEntry::getCategory($category);

        return view('dal.manage', compact(
            'entries',
            'categories',
            'category',
            'currentCategoryMeta',
            'categoryCounts',
            'type',
            'search',
            'country',
            'approver'
        ));
    }

    /**
     * Show create form.
     */
    public function create(Request $request)
    {
        $categories = DalEntry::$categories;
        $approverColumns = DalEntry::$approverColumns;
        $selectedCategory = $request->query('category', 'finance');

        return view('dal.create', compact('categories', 'approverColumns', 'selectedCategory'));
    }

    /**
     * Store new DAL entry.
     */
    public function store(Request $request)
    {
        $validated = $this->validateEntry($request);
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        // Server-side safety net: if row_number was not explicitly set,
        // auto-assign the next available number for this category + section_title.
        if (empty($validated['row_number'])) {
            $validated['row_number'] = $this->calcNextRowNumber(
                $validated['category'],
                $validated['type'] ?? '',
                $validated['section_title']
            );
        }

        DalEntry::create($validated);

        return redirect()->route('dal.manage.index', [
            'category' => $validated['category'],
            'type'     => $validated['type'] ?? '',
        ])->with('success', 'DAL entry created successfully.');
    }

    /**
     * AJAX endpoint: return the next row_number for a given category + type + section_title.
     */
    public function nextRowNumber(Request $request): \Illuminate\Http\JsonResponse
    {
        $category     = $request->query('category', 'finance');
        $type         = (string) $request->query('type', '');
        $sectionTitle = trim((string) $request->query('section_title', ''));

        return response()->json([
            'next' => $this->calcNextRowNumber($category, $type, $sectionTitle),
        ]);
    }

    /**
     * Calculate MAX(row_number) + 1 for the given category + section_title.
     */
    private function calcNextRowNumber(string $category, string $type, string $sectionTitle): int
    {
        $max = DalEntry::where('category', $category)
            ->where('section_title', $sectionTitle)
            ->max('row_number');

        return $max ? $max + 1 : 1;
    }

    /**
     * Show edit form.
     */
    public function edit(DalEntry $dalEntry)
    {
        $categories = DalEntry::$categories;
        $approverColumns = DalEntry::$approverColumns;

        return view('dal.edit', compact('dalEntry', 'categories', 'approverColumns'));
    }

    /**
     * Update DAL entry.
     */
    public function update(Request $request, DalEntry $dalEntry)
    {
        $validated = $this->validateEntry($request);
        $validated['updated_by'] = Auth::id();

        $dalEntry->update($validated);

        return redirect()->route('dal.manage.index', [
            'category' => $validated['category'],
            'type'     => $validated['type'] ?? '',
        ])->with('success', 'DAL entry updated successfully.');
    }

    /**
     * Delete DAL entry.
     */
    public function destroy(DalEntry $dalEntry)
    {
        $category = $dalEntry->category;
        $type     = $dalEntry->type;
        $dalEntry->delete();

        return redirect()->route('dal.manage.index', [
            'category' => $category,
            'type'     => $type,
        ])->with('success', 'DAL entry deleted successfully.');
    }

    /**
     * Validate DAL entry request fields.
     */
    private function validateEntry(Request $request): array
    {
        $allowedCategories = implode(',', array_keys(DalEntry::$categories));

        return $request->validate([
            'category'       => ['required', 'string', 'in:' . $allowedCategories],
            'type'           => ['nullable', 'string', 'max:50'],
            'section_title'  => ['required', 'string', 'max:255'],
            'row_number'     => ['nullable', 'integer', 'min:1'],
            'malaysia'       => ['nullable', 'string', 'max:100'],
            'singapore'      => ['nullable', 'string', 'max:100'],
            'australia'      => ['nullable', 'string', 'max:100'],
            'vietnam'        => ['nullable', 'string', 'max:100'],
            'japan'          => ['nullable', 'string', 'max:100'],
            'shr'            => ['nullable', 'string', 'max:20'],
            'sub_shr'        => ['nullable', 'string', 'max:20'],
            'bod'            => ['nullable', 'string', 'max:20'],
            'sub_bod'        => ['nullable', 'string', 'max:20'],
            'nrc'            => ['nullable', 'string', 'max:20'],
            'ac'             => ['nullable', 'string', 'max:20'],
            'rmc'            => ['nullable', 'string', 'max:20'],
            'tpc'            => ['nullable', 'string', 'max:20'],
            'fic'            => ['nullable', 'string', 'max:20'],
            'sc'             => ['nullable', 'string', 'max:20'],
            'sub_exco'       => ['nullable', 'string', 'max:20'],
            'ceo'            => ['nullable', 'string', 'max:20'],
            'deputy_ceo_coo' => ['nullable', 'string', 'max:20'],
            'sevp'           => ['nullable', 'string', 'max:20'],
            'evp'            => ['nullable', 'string', 'max:20'],
            'dgm'            => ['nullable', 'string', 'max:20'],
            'gm'             => ['nullable', 'string', 'max:20'],
            'deputy_gm_head' => ['nullable', 'string', 'max:20'],
            'remarks'        => ['nullable', 'string'],
        ]);
    }
}
