<?php

namespace Database\Seeders;

use App\Models\DalCategory;
use App\Models\Department;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Categories Master
        $categories = [
            [
                'code'        => '1.0',
                'slug'        => 'corporate_matter',
                'name'        => 'Corporate Matter',
                'full_title'  => '1.0 Corporate Matter',
                'short_title' => '1.0 Corporate',
                'badge_color' => 'indigo',
                'icon'        => 'building',
                'description' => 'Board resolutions, statutory compliance, corporate secretarial & entity governance',
                'sort_order'  => 1,
                'is_active'   => true,
            ],
            [
                'code'        => '2.0',
                'slug'        => 'tender_contracts',
                'name'        => 'Tender & Contracts',
                'full_title'  => '2.0 Tender & Contracts',
                'short_title' => '2.0 Tender & Contracts',
                'badge_color' => 'blue',
                'icon'        => 'document-check',
                'description' => 'Tender evaluation, contract awards, vendor prequalification & variations',
                'sort_order'  => 2,
                'is_active'   => true,
            ],
            [
                'code'        => '3.0',
                'slug'        => 'legal',
                'name'        => 'Legal',
                'full_title'  => '3.0 Legal',
                'short_title' => '3.0 Legal',
                'badge_color' => 'purple',
                'icon'        => 'scale',
                'description' => 'Litigation, power of attorney, NDA, settlements & legal agreements',
                'sort_order'  => 3,
                'is_active'   => true,
            ],
            [
                'code'        => '4.0 - 6.0',
                'slug'        => 'finance',
                'name'        => 'Finance',
                'full_title'  => '4.0 - 6.0 Finance',
                'short_title' => '4.0 - 6.0 Finance',
                'badge_color' => 'amber',
                'icon'        => 'banknotes',
                'description' => 'Capital expenditure (CAPEX), non-capital expenditure (OPEX), banking, treasury & credit limits',
                'sort_order'  => 4,
                'is_active'   => true,
            ],
            [
                'code'        => '7.0',
                'slug'        => 'human_capital',
                'name'        => 'Human Capital',
                'full_title'  => '7.0 Human Capital',
                'short_title' => '7.0 Human Capital',
                'badge_color' => 'rose',
                'icon'        => 'user-group',
                'description' => 'Manpower planning, recruitment, promotions, benefits, secondment & payroll',
                'sort_order'  => 5,
                'is_active'   => true,
            ],
            [
                'code'        => '8.0',
                'slug'        => 'commercial',
                'name'        => 'Commercial',
                'full_title'  => '8.0 Commercial',
                'short_title' => '8.0 Commercial',
                'badge_color' => 'cyan',
                'icon'        => 'megaphone',
                'description' => 'Press statements, official spokespersons, media releases & public announcements',
                'sort_order'  => 6,
                'is_active'   => true,
            ],
            [
                'code'        => '9.0',
                'slug'        => 'asset_management',
                'name'        => 'Asset Management',
                'full_title'  => '9.0 Asset Management',
                'short_title' => '9.0 Asset Management',
                'badge_color' => 'emerald',
                'icon'        => 'cube',
                'description' => 'Asset acquisition, leasing, maintenance, disposals & inventory write-offs',
                'sort_order'  => 7,
                'is_active'   => true,
            ],
            [
                'code'        => '10.0',
                'slug'        => 'hse',
                'name'        => 'HSE',
                'full_title'  => '10.0 HSE',
                'short_title' => '10.0 HSE',
                'badge_color' => 'teal',
                'icon'        => 'shield-check',
                'description' => 'Health, Safety & Environment compliance, permits, incident reporting & safety audits',
                'sort_order'  => 8,
                'is_active'   => true,
            ],
        ];

        $savedCategories = [];
        foreach ($categories as $catData) {
            $savedCategories[$catData['slug']] = DalCategory::updateOrCreate(
                ['slug' => $catData['slug']],
                $catData
            );
        }

        // 2. Seed Departments Master
        $departments = [
            [
                'code'        => 'CORP_SEC',
                'name'        => 'Corporate Secretarial & Governance',
                'description' => 'Board relations, resolutions, compliance & company secretarial affairs',
                'categories'  => ['corporate_matter', 'legal'],
            ],
            [
                'code'        => 'PROC',
                'name'        => 'Procurement & Contracts',
                'description' => 'Tenders, vendor procurement, quotations & commercial contracts',
                'categories'  => ['tender_contracts', 'finance'],
            ],
            [
                'code'        => 'LEGAL',
                'name'        => 'Legal & Compliance',
                'description' => 'Legal advisory, litigation, contracts, settlement & regulatory compliance',
                'categories'  => ['legal', 'corporate_matter'],
            ],
            [
                'code'        => 'FIN',
                'name'        => 'Finance & Treasury',
                'description' => 'Financial accounting, CAPEX/OPEX budgets, treasury, banking & cash management',
                'categories'  => ['finance', 'tender_contracts'],
            ],
            [
                'code'        => 'HR',
                'name'        => 'Human Capital & People Experience',
                'description' => 'Talent acquisition, manpower planning, payroll, benefits & employee relations',
                'categories'  => ['human_capital'],
            ],
            [
                'code'        => 'COMM',
                'name'        => 'Commercial & Strategic Communications',
                'description' => 'Media relations, public affairs, marketing & commercial spokesmanship',
                'categories'  => ['commercial'],
            ],
            [
                'code'        => 'AM',
                'name'        => 'Asset Management & Facilities',
                'description' => 'Real estate leasing, property maintenance, tenant management & asset write-offs',
                'categories'  => ['asset_management', 'finance'],
            ],
            [
                'code'        => 'HSE',
                'name'        => 'Health, Safety & Environment (HSE)',
                'description' => 'Occupational safety, environmental standards, HSE audits & crisis notifications',
                'categories'  => ['hse'],
            ],
            [
                'code'        => 'IT',
                'name'        => 'Information Technology & Digital',
                'description' => 'Enterprise systems, software, IT infrastructure & cybersecurity',
                'categories'  => ['finance', 'tender_contracts'],
            ],
            [
                'code'        => 'OPS',
                'name'        => 'Operations & Business Units',
                'description' => 'Operational business units and site management',
                'categories'  => ['finance', 'tender_contracts', 'hse'],
            ],
        ];

        foreach ($departments as $deptData) {
            $catSlugs = $deptData['categories'];
            unset($deptData['categories']);

            $dept = Department::updateOrCreate(
                ['code' => $deptData['code']],
                $deptData
            );

            // Sync category mappings
            $catIds = [];
            foreach ($catSlugs as $slug) {
                if (isset($savedCategories[$slug])) {
                    $catIds[] = $savedCategories[$slug]->id;
                }
            }
            $dept->dalCategories()->sync($catIds);
        }
    }
}
