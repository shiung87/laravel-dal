<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\TrafficLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TrafficDataSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $departments = Department::with('dalCategories')->get();

        $categories = [
            'corporate_matter',
            'tender_contracts',
            'legal',
            'finance',
            'human_capital',
            'commercial',
            'asset_management',
            'hse',
        ];

        $searchQueries = [
            'CEO approval',
            'Bank guarantee',
            'Auditor',
            'Tender threshold',
            'Disposal limit',
            'Capex budget',
            'Insurance policy',
            'Procurement quotation',
            'Employment contract',
            'Petty cash',
            'Board resolution',
            'Emergency spend',
            'Sign-off matrix',
        ];

        $countries = ['MY', 'SG', 'AU', 'VN', 'JP', null, null];
        $approvers = ['BOD', 'CEO', 'DEP_CEO', 'SEVP', 'EVP', 'GM', null, null, null];
        $devices = ['desktop', 'desktop', 'desktop', 'mobile', 'mobile', 'tablet'];

        // Generate past 30 days of realistic traffic
        $now = Carbon::now();
        $logs = [];

        for ($day = 30; $day >= 0; $day--) {
            $date = $now->copy()->subDays($day);
            // Higher traffic on weekdays, lower on weekends
            $dailyHits = $date->isWeekend() ? rand(8, 22) : rand(35, 95);

            for ($i = 0; $i < $dailyHits; $i++) {
                $user = $users->isNotEmpty() ? $users->random() : null;
                $dept = $user?->department ?? ($departments->isNotEmpty() ? $departments->random() : null);

                // Prefer mapped categories if dept has them
                if ($dept && $dept->dalCategories->isNotEmpty()) {
                    $catSlug = (rand(1, 10) <= 7)
                        ? $dept->dalCategories->random()->slug
                        : $categories[array_rand($categories)];
                } else {
                    $catSlug = $categories[array_rand($categories)];
                }

                $hasSearch = (rand(1, 10) <= 4);
                $search = $hasSearch ? $searchQueries[array_rand($searchQueries)] : null;
                $country = $countries[array_rand($countries)];
                $approver = $approvers[array_rand($approvers)];
                $device = $devices[array_rand($devices)];

                $timestamp = $date->copy()->setTime(rand(8, 20), rand(0, 59), rand(0, 59));

                $logs[] = [
                    'user_id'         => $user?->id,
                    'user_name'       => $user?->name ?? 'Staff User',
                    'department_id'   => $dept?->id,
                    'department_name' => $dept?->name ?? 'General',
                    'path'            => '/dal-manage',
                    'category_slug'   => $catSlug,
                    'search_query'    => $search,
                    'country_filter'  => $country,
                    'approver_filter' => $approver,
                    'ip_address'      => '192.168.1.' . rand(10, 240),
                    'user_agent'      => $device === 'mobile'
                        ? 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_4 like Mac OS X)'
                        : 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'device'          => $device,
                    'created_at'      => $timestamp,
                ];

                if (count($logs) >= 250) {
                    TrafficLog::insert($logs);
                    $logs = [];
                }
            }
        }

        if (!empty($logs)) {
            TrafficLog::insert($logs);
        }
    }
}
