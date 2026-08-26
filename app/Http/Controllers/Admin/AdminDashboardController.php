<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\DalCategory;
use App\Models\Department;
use App\Models\TrafficLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard with full Traffic & Analytics suite and Date Filtering.
     */
    public function index(Request $request)
    {
        // ── 1. Date Range & Period Resolution ──
        $period = $request->query('period', 'monthly'); // daily, weekly, monthly, custom
        $fromDate = $request->query('from_date');
        $toDate   = $request->query('to_date');

        $now = Carbon::now();

        switch ($period) {
            case 'daily':
                $startDate = Carbon::today()->startOfDay();
                $endDate   = Carbon::today()->endOfDay();
                $periodLabel = 'Today (' . $now->format('d M Y') . ')';
                break;

            case 'weekly':
                $startDate = Carbon::now()->subDays(6)->startOfDay();
                $endDate   = Carbon::now()->endOfDay();
                $periodLabel = 'Past 7 Days (' . $startDate->format('d M') . ' – ' . $endDate->format('d M Y') . ')';
                break;

            case 'custom':
                try {
                    $startDate = $fromDate ? Carbon::parse($fromDate)->startOfDay() : Carbon::now()->subDays(30)->startOfDay();
                    $endDate   = $toDate ? Carbon::parse($toDate)->endOfDay() : Carbon::now()->endOfDay();
                    if ($startDate->gt($endDate)) {
                        [$startDate, $endDate] = [$endDate->copy()->startOfDay(), $startDate->copy()->endOfDay()];
                    }
                } catch (\Throwable) {
                    $startDate = Carbon::now()->subDays(30)->startOfDay();
                    $endDate   = Carbon::now()->endOfDay();
                }
                $periodLabel = $startDate->format('d M Y') . ' – ' . $endDate->format('d M Y');
                break;

            case 'monthly':
            default:
                $period = 'monthly';
                $startDate = Carbon::now()->subDays(29)->startOfDay();
                $endDate   = Carbon::now()->endOfDay();
                $periodLabel = 'Past 30 Days (' . $startDate->format('d M') . ' – ' . $endDate->format('d M Y') . ')';
                break;
        }

        // Format dates for inputs
        $inputFromDate = $startDate->format('Y-m-d');
        $inputToDate   = $endDate->format('Y-m-d');

        // ── 2. User Accounts Summary ──
        $totalUsers   = User::count();
        $adminUsers   = User::where('is_admin', true)->count();
        $regularUsers = $totalUsers - $adminUsers;
        $ssoUsers     = User::where('is_sso', true)->count();

        // ── 3. Filtered Traffic Overview Metrics ──
        $periodViews = TrafficLog::whereBetween('created_at', [$startDate, $endDate])->count();
        $periodUniqueUsers = TrafficLog::whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');
        $periodSearches = TrafficLog::whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('search_query')
            ->where('search_query', '!=', '')
            ->count();

        $todayStart = Carbon::today();
        $viewsToday = TrafficLog::where('created_at', '>=', $todayStart)->count();
        $uniqueUsersToday = TrafficLog::where('created_at', '>=', $todayStart)
            ->whereNotNull('user_id')
            ->distinct('user_id')
            ->count('user_id');

        // ── 4. Dynamic Traffic Trend Chart ──
        $chartData = [];

        if ($period === 'daily') {
            // Group by 2-hour intervals for today (00:00 to 22:00)
            for ($h = 0; $h < 24; $h += 2) {
                $slotStart = Carbon::today()->addHours($h);
                $slotEnd   = Carbon::today()->addHours($h + 2);
                $label     = sprintf('%02d:00', $h);

                $slotViews = TrafficLog::whereBetween('created_at', [$slotStart, $slotEnd])->count();
                $slotUsers = TrafficLog::whereBetween('created_at', [$slotStart, $slotEnd])
                    ->whereNotNull('user_id')
                    ->distinct('user_id')
                    ->count('user_id');
                $slotSearches = TrafficLog::whereBetween('created_at', [$slotStart, $slotEnd])
                    ->whereNotNull('search_query')
                    ->where('search_query', '!=', '')
                    ->count();

                $chartData[] = [
                    'label'    => $label,
                    'views'    => $slotViews,
                    'users'    => $slotUsers,
                    'searches' => $slotSearches,
                ];
            }
        } elseif ($period === 'weekly') {
            // 7 daily intervals
            for ($i = 6; $i >= 0; $i--) {
                $day = Carbon::now()->subDays($i);
                $dayStr = $day->format('Y-m-d');
                $label = $day->format('D, d M');

                $dayViews = TrafficLog::whereDate('created_at', $dayStr)->count();
                $dayUsers = TrafficLog::whereDate('created_at', $dayStr)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
                $daySearches = TrafficLog::whereDate('created_at', $dayStr)->whereNotNull('search_query')->where('search_query', '!=', '')->count();

                $chartData[] = [
                    'label'    => $label,
                    'views'    => $dayViews,
                    'users'    => $dayUsers,
                    'searches' => $daySearches,
                ];
            }
        } else {
            // Monthly or custom: distribute across up to 15-20 aggregated date ticks
            $diffDays = max(1, $startDate->diffInDays($endDate) + 1);
            $step = max(1, (int) ceil($diffDays / 15));

            $cursor = $startDate->copy();
            while ($cursor->lte($endDate)) {
                $subEnd = $cursor->copy()->addDays($step - 1)->endOfDay();
                if ($subEnd->gt($endDate)) {
                    $subEnd = $endDate->copy();
                }

                $label = $cursor->format('d M');
                if ($step > 1 && $cursor->format('d M') !== $subEnd->format('d M')) {
                    $label = $cursor->format('d') . '–' . $subEnd->format('d M');
                }

                $slotViews = TrafficLog::whereBetween('created_at', [$cursor->copy()->startOfDay(), $subEnd])->count();
                $slotUsers = TrafficLog::whereBetween('created_at', [$cursor->copy()->startOfDay(), $subEnd])
                    ->whereNotNull('user_id')
                    ->distinct('user_id')
                    ->count('user_id');
                $slotSearches = TrafficLog::whereBetween('created_at', [$cursor->copy()->startOfDay(), $subEnd])
                    ->whereNotNull('search_query')
                    ->where('search_query', '!=', '')
                    ->count();

                $chartData[] = [
                    'label'    => $label,
                    'views'    => $slotViews,
                    'users'    => $slotUsers,
                    'searches' => $slotSearches,
                ];

                $cursor->addDays($step);
            }
        }

        $maxChartViews = max(1, max(array_column($chartData, 'views')));

        // ── 5. Filtered Category Breakdown ──
        $categoriesTaxonomy = DalCategory::active()->ordered()->get()->keyBy('slug');
        $categoryViewsRaw = TrafficLog::select('category_slug', DB::raw('count(*) as count'))
            ->whereNotNull('category_slug')
            ->where('category_slug', '!=', '')
            ->where('category_slug', '!=', 'all')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('category_slug')
            ->orderByDesc('count')
            ->get();

        $totalCatViews = max(1, $categoryViewsRaw->sum('count'));
        $categoryBreakdown = [];

        foreach ($categoryViewsRaw as $item) {
            $catMeta = $categoriesTaxonomy->get($item->category_slug);
            $categoryBreakdown[] = [
                'slug'       => $item->category_slug,
                'code'       => $catMeta->code ?? $item->category_slug,
                'name'       => $catMeta->name ?? ucwords(str_replace('_', ' ', $item->category_slug)),
                'full_title' => $catMeta->full_title ?? $item->category_slug,
                'count'      => $item->count,
                'pct'        => round(($item->count / $totalCatViews) * 100, 1),
            ];
        }

        // ── 6. Filtered Department Breakdown ──
        $deptTrafficRaw = TrafficLog::select('department_name', DB::raw('count(*) as count'))
            ->whereNotNull('department_name')
            ->where('department_name', '!=', '')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('department_name')
            ->orderByDesc('count')
            ->limit(8)
            ->get();

        $totalDeptViews = max(1, $deptTrafficRaw->sum('count'));
        $departmentBreakdown = [];
        foreach ($deptTrafficRaw as $dItem) {
            $departmentBreakdown[] = [
                'name'  => $dItem->department_name,
                'count' => $dItem->count,
                'pct'   => round(($dItem->count / $totalDeptViews) * 100, 1),
            ];
        }

        // ── 7. Filtered Top Search Queries ──
        $topSearches = TrafficLog::select('search_query', DB::raw('count(*) as count'), DB::raw('max(created_at) as last_searched'))
            ->whereNotNull('search_query')
            ->where('search_query', '!=', '')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('search_query')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // ── 8. Filtered Device & Platform Distribution ──
        $deviceRaw = TrafficLog::select('device', DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('device')
            ->pluck('count', 'device')
            ->toArray();

        $totalDeviceHits = max(1, array_sum($deviceRaw));
        $deviceBreakdown = [
            'desktop' => round((($deviceRaw['desktop'] ?? 0) / $totalDeviceHits) * 100, 1),
            'mobile'  => round((($deviceRaw['mobile'] ?? 0) / $totalDeviceHits) * 100, 1),
            'tablet'  => round((($deviceRaw['tablet'] ?? 0) / $totalDeviceHits) * 100, 1),
        ];

        // ── 9. Filtered Country Filter Usage ──
        $countryUsage = TrafficLog::select('country_filter', DB::raw('count(*) as count'))
            ->whereNotNull('country_filter')
            ->where('country_filter', '!=', '')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('country_filter')
            ->orderByDesc('count')
            ->pluck('count', 'country_filter')
            ->toArray();

        // ── 10. Recent Audit Logs ──
        $recentActivities = ActivityLog::orderByDesc('created_at')->limit(8)->get();

        return view('admin.dashboard', compact(
            'period',
            'periodLabel',
            'inputFromDate',
            'inputToDate',
            'totalUsers',
            'adminUsers',
            'regularUsers',
            'ssoUsers',
            'periodViews',
            'periodUniqueUsers',
            'periodSearches',
            'viewsToday',
            'uniqueUsersToday',
            'chartData',
            'maxChartViews',
            'categoryBreakdown',
            'departmentBreakdown',
            'topSearches',
            'deviceBreakdown',
            'countryUsage',
            'recentActivities'
        ));
    }
}
