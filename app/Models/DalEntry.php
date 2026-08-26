<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DalEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'category', 'type', 'section_title', 'row_number',
        'malaysia', 'singapore', 'australia', 'vietnam', 'japan',
        'shr', 'sub_shr', 'bod', 'sub_bod', 'nrc', 'ac', 'rmc',
        'tpc', 'fic', 'sc', 'sub_exco', 'ceo', 'deputy_ceo_coo',
        'sevp', 'evp', 'dgm', 'gm', 'deputy_gm_head', 'remarks',
        'created_by', 'updated_by',
    ];

    /**
     * Corporate Categories Taxonomy for DAL System.
     */
    public static array $categories = [
        'corporate_matter' => [
            'code'        => '1.0',
            'name'        => 'Corporate Matter',
            'full_title'  => '1.0 Corporate Matter',
            'short_title' => '1.0 Corporate',
            'badge_color' => 'indigo',
            'icon'        => 'building',
            'description' => 'Board resolutions, statutory compliance, corporate secretarial & entity governance',
        ],
        'tender_contracts' => [
            'code'        => '2.0',
            'name'        => 'Tender & Contracts',
            'full_title'  => '2.0 Tender & Contracts',
            'short_title' => '2.0 Tender & Contracts',
            'badge_color' => 'blue',
            'icon'        => 'document-check',
            'description' => 'Tender evaluation, contract awards, vendor prequalification & variations',
        ],
        'legal' => [
            'code'        => '3.0',
            'name'        => 'Legal',
            'full_title'  => '3.0 Legal',
            'short_title' => '3.0 Legal',
            'badge_color' => 'purple',
            'icon'        => 'scale',
            'description' => 'Litigation, power of attorney, NDA, settlements & legal agreements',
        ],
        'finance' => [
            'code'        => '4.0 - 6.0',
            'name'        => 'Finance',
            'full_title'  => '4.0 - 6.0 Finance',
            'short_title' => '4.0 - 6.0 Finance',
            'badge_color' => 'amber',
            'icon'        => 'banknotes',
            'description' => 'Capital expenditure (CAPEX), non-capital expenditure (OPEX), banking, treasury & credit limits',
            'subtypes'    => [
                'capital'    => '4.0 Capital Expenditure',
                'noncapital' => '5.0 Non-Capital Expenditure',
                'treasury'   => '6.0 Treasury & Financing',
            ],
        ],
        'human_capital' => [
            'code'        => '7.0',
            'name'        => 'Human Capital',
            'full_title'  => '7.0 Human Capital',
            'short_title' => '7.0 Human Capital',
            'badge_color' => 'emerald',
            'icon'        => 'users',
            'description' => 'Manpower requisition, recruitment, compensation, benefits & terminations',
        ],
        'commercial' => [
            'code'        => '8.0',
            'name'        => 'Commercial',
            'full_title'  => '8.0 Commercial',
            'short_title' => '8.0 Commercial',
            'badge_color' => 'cyan',
            'icon'        => 'shopping-cart',
            'description' => 'Sales agreements, pricing approvals, customer credit limits & trading',
        ],
        'asset_management' => [
            'code'        => '9.0',
            'name'        => 'Asset Management',
            'full_title'  => '9.0 Asset Management',
            'short_title' => '9.0 Asset Mgmt',
            'badge_color' => 'rose',
            'icon'        => 'cube',
            'description' => 'Asset acquisition, leasing, maintenance, disposals & inventory write-offs',
        ],
        'hse' => [
            'code'        => '10.0',
            'name'        => 'HSE',
            'full_title'  => '10.0 HSE',
            'short_title' => '10.0 HSE',
            'badge_color' => 'teal',
            'icon'        => 'shield-check',
            'description' => 'Health, Safety & Environment compliance, permits, incident reporting & safety audits',
        ],
    ];

    /**
     * The approver column labels for display.
     */
    public static array $approverColumns = [
        'shr'            => 'SHR',
        'sub_shr'        => 'Sub SHR',
        'bod'            => 'BOD',
        'sub_bod'        => 'Sub BOD',
        'nrc'            => 'NRC',
        'ac'             => 'AC',
        'rmc'            => 'RMC',
        'tpc'            => 'TPC',
        'fic'            => 'FIC',
        'sc'             => 'SC',
        'sub_exco'       => 'Sub EXCO',
        'ceo'            => 'CEO',
        'deputy_ceo_coo' => 'Deputy CEO/COO',
        'sevp'           => 'SEVP',
        'evp'            => 'EVP',
        'dgm'            => 'DGM',
        'gm'             => 'GM',
        'deputy_gm_head' => 'Deputy GM / Head',
    ];

    /**
     * Get metadata for a specific category key.
     */
    public static function getCategory(?string $key): array
    {
        $key = $key ?: 'all';
        if ($key === 'all') {
            return [
                'code'        => 'ALL',
                'name'        => 'All Categories',
                'full_title'  => '🌐 All Categories (Global DAL)',
                'short_title' => 'All Categories',
                'badge_color' => 'blue',
                'icon'        => 'globe',
                'description' => 'Global search across all Delegation of Authority governance categories',
            ];
        }

        try {
            $cat = DalCategory::where('slug', $key)->first();
            if ($cat) {
                return [
                    'id'          => $cat->id,
                    'code'        => $cat->code,
                    'name'        => $cat->name,
                    'full_title'  => $cat->full_title,
                    'short_title' => $cat->short_title,
                    'badge_color' => $cat->badge_color,
                    'icon'        => $cat->icon,
                    'description' => $cat->description,
                ];
            }
        } catch (\Throwable $e) {}

        return self::$categories[$key] ?? [
            'code'        => '',
            'name'        => ucfirst(str_replace('_', ' ', $key)),
            'full_title'  => ucfirst(str_replace('_', ' ', $key)),
            'short_title' => ucfirst(str_replace('_', ' ', $key)),
            'badge_color' => 'slate',
            'icon'        => 'folder',
            'description' => '',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
