<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DalEntriesSeeder extends Seeder
{
    /**
     * Seed all DAL (Delegation of Authority Limits) entries.
     *
     * Column mapping for approver fields:
     *   shr, sub_shr, bod, sub_bod, nrc, ac, rmc, tpc, fic, sc,
     *   sub_exco, ceo, deputy_ceo_coo, sevp, evp, dgm, gm, deputy_gm_head
     *
     * For rows with a single "Any Amount / More than RM..." covering all regions,
     * the amount is stored in `malaysia` and other currency columns are left null.
     */
    public function run(): void
    {
        DB::table('dal_entries')->delete();

        // ─────────────────────────────────────────────────────────────────────
        // CAPITAL EXPENDITURE
        // ─────────────────────────────────────────────────────────────────────
        $capital = [

            // ── 4.1 Acquisition of Budgeted Capital Expenditure (exclude land and building) ──
            [
                'section_title'  => '4.1 Acquisition of Budgeted Capital Expenditure (exclude land and building)',
                'row_number'     => 1,
                'malaysia'       => '> RM250k',
                'singapore'      => '> SGD250k',
                'australia'      => '> AUD250k',
                'vietnam'        => '> USD125k',
                'japan'          => '> JPY6 mil',
                'ceo'            => 'A',
                'sevp'           => 'R#',
                'evp'            => 'R#',
                'dgm'            => 'R#',
                'gm'             => 'P#',
                'deputy_gm_head' => 'P#',
            ],
            [
                'section_title'  => '4.1 Acquisition of Budgeted Capital Expenditure (exclude land and building)',
                'row_number'     => 2,
                'malaysia'       => '<= RM250k',
                'singapore'      => '<= SGD250k',
                'australia'      => '<= AUD250k',
                'vietnam'        => '<= USD125k',
                'japan'          => '<= JPY6 mil',
                'deputy_ceo_coo' => 'A#',
                'sevp'           => 'R#',
                'evp'            => 'R#',
                'dgm'            => 'R#',
                'gm'             => 'P#',
                'deputy_gm_head' => 'P#',
            ],
            [
                'section_title'  => '4.1 Acquisition of Budgeted Capital Expenditure (exclude land and building)',
                'row_number'     => 3,
                'malaysia'       => '<= RM200k',
                'singapore'      => '<= SGD200k',
                'australia'      => '<= AUD200k',
                'vietnam'        => '<= USD100k',
                'japan'          => '<= JPY5 mil',
                'sevp'           => 'A#',
                'evp'            => 'R#',
                'dgm'            => 'R#',
                'gm'             => 'R#',
            ],
            [
                'section_title'  => '4.1 Acquisition of Budgeted Capital Expenditure (exclude land and building)',
                'row_number'     => 4,
                'malaysia'       => '<= RM150k',
                'singapore'      => '<= SGD150k',
                'australia'      => '<= AUD150k',
                'vietnam'        => '<= USD75k',
                'japan'          => '<= JPY4 mil',
                'evp'            => 'A#',
                'dgm'            => 'R#',
                'gm'             => 'R#',
                'deputy_gm_head' => 'R#',
            ],
            [
                'section_title'  => '4.1 Acquisition of Budgeted Capital Expenditure (exclude land and building)',
                'row_number'     => 5,
                'malaysia'       => '<= RM100k',
                'singapore'      => '<= SGD100k',
                'australia'      => '<= AUD100k',
                'vietnam'        => '<= USD50k',
                'japan'          => '<= JPY3 mil',
                'dgm'            => 'A#',
                'gm'             => 'R#',
                'deputy_gm_head' => 'R#',
            ],
            [
                'section_title'  => '4.1 Acquisition of Budgeted Capital Expenditure (exclude land and building)',
                'row_number'     => 6,
                'malaysia'       => '<= RM50k',
                'singapore'      => '<= SGD50k',
                'australia'      => '<= AUD50k',
                'vietnam'        => '<= USD25k',
                'japan'          => '<= JPY1.5 mil',
                'gm'             => 'A#',
            ],
            [
                'section_title'  => '4.1 Acquisition of Budgeted Capital Expenditure (exclude land and building)',
                'row_number'     => 7,
                'malaysia'       => '<= RM25k',
                'singapore'      => '<= SGD25k',
                'australia'      => '-',
                'vietnam'        => '-',
                'japan'          => '-',
                'deputy_gm_head' => 'A#',
                'remarks'        => 'Malaysia and Singapore only',
            ],

            // ── 4.2 Disposal / Write-Off of Budgeted CAPEX and Transfer of Fixed Assets (exclude land and building)* ──
            [
                'section_title'  => '4.2 Disposal / Write-Off of Budgeted Capital Expenditure and Budgeted Transfer of Fixed Assets within the Group (exclude land and building)*',
                'row_number'     => 1,
                'malaysia'       => '> RM250k',
                'singapore'      => '> SGD250k',
                'australia'      => '> AUD250k',
                'vietnam'        => '> USD125k',
                'japan'          => '> JPY6 mil',
                'ceo'            => 'A',
                'sevp'           => 'R#',
                'evp'            => 'R#',
                'dgm'            => 'R#',
                'gm'             => 'P#',
                'deputy_gm_head' => 'P#',
                'remarks'        => '*Based on the disposal value',
            ],
            [
                'section_title'  => '4.2 Disposal / Write-Off of Budgeted Capital Expenditure and Budgeted Transfer of Fixed Assets within the Group (exclude land and building)*',
                'row_number'     => 2,
                'malaysia'       => '<= RM250k',
                'singapore'      => '<= SGD250k',
                'australia'      => '<= AUD250k',
                'vietnam'        => '<= USD125k',
                'japan'          => '<= JPY6 mil',
                'deputy_ceo_coo' => 'A#',
                'sevp'           => 'R#',
                'evp'            => 'R#',
                'dgm'            => 'R#',
                'gm'             => 'P#',
                'deputy_gm_head' => 'P#',
            ],
            [
                'section_title'  => '4.2 Disposal / Write-Off of Budgeted Capital Expenditure and Budgeted Transfer of Fixed Assets within the Group (exclude land and building)*',
                'row_number'     => 3,
                'malaysia'       => '<= RM200k',
                'singapore'      => '<= SGD200k',
                'australia'      => '<= AUD200k',
                'vietnam'        => '<= USD100k',
                'japan'          => '<= JPY5 mil',
                'sevp'           => 'A#',
                'dgm'            => 'R#',
                'gm'             => 'R#',
                'deputy_gm_head' => 'R#',
            ],
            [
                'section_title'  => '4.2 Disposal / Write-Off of Budgeted Capital Expenditure and Budgeted Transfer of Fixed Assets within the Group (exclude land and building)*',
                'row_number'     => 4,
                'malaysia'       => '<= RM150k',
                'singapore'      => '<= SGD150k',
                'australia'      => '<= AUD150k',
                'vietnam'        => '<= USD75k',
                'japan'          => '<= JPY4 mil',
                'evp'            => 'A#',
                'dgm'            => 'R#',
                'gm'             => 'R#',
                'deputy_gm_head' => 'R#',
            ],

            // ── 4.3 Procurement of Budgeted Contingencies / Miscellaneous Capital Expenditure* ──
            [
                'section_title'  => '4.3 Procurement of Budgeted Contingencies / Miscellaneous Capital Expenditure*',
                'row_number'     => 1,
                'malaysia'       => 'More than RM500k',
                'ceo'            => 'A',
                'deputy_ceo_coo' => 'R#',
                'sevp'           => 'R#',
                'evp'            => 'R#',
                'dgm'            => 'P#',
                'gm'             => 'P#',
                'remarks'        => '*10% of the approved individual CAPEX line item subject to a limit of not exceeding 5% of the total approved budgeted CAPEX.',
            ],
            [
                'section_title'  => '4.3 Procurement of Budgeted Contingencies / Miscellaneous Capital Expenditure*',
                'row_number'     => 2,
                'malaysia'       => 'Up to RM500k',
                'deputy_ceo_coo' => 'A',
                'sevp'           => 'R#',
                'evp'            => 'R#',
                'dgm'            => 'R#',
                'gm'             => 'P#',
                'deputy_gm_head' => 'P#',
            ],

            // ── 4.4 Acquisition of Non-Budgeted Capital Expenditure ──
            [
                'section_title'  => '4.4 Acquisition of Non-Budgeted Capital Expenditure (exclude land and building, and items under budgeted contingencies / miscellaneous capital expenditure)',
                'row_number'     => 1,
                'malaysia'       => 'Any Amount',
                'bod'            => 'A',
                'ceo'            => 'R',
                'deputy_ceo_coo' => 'R#',
                'sevp'           => 'P#',
                'evp'            => 'P#',
            ],

            // ── 4.5 Non-Budgeted Disposal and Write Off of Capital Expenditure* ──
            [
                'section_title'  => '4.5 Non-Budgeted Disposal and Write Off of Capital Expenditure* (exclude land and building)',
                'row_number'     => 1,
                'malaysia'       => 'More than RM100k',
                'bod'            => 'A',
                'ceo'            => 'R',
                'deputy_ceo_coo' => 'R#',
                'sevp'           => 'P#',
                'evp'            => 'P#',
                'remarks'        => '*Based on the disposal value',
            ],
            [
                'section_title'  => '4.5 Non-Budgeted Disposal and Write Off of Capital Expenditure* (exclude land and building)',
                'row_number'     => 2,
                'malaysia'       => 'Up to RM100k',
                'ceo'            => 'A',
                'deputy_ceo_coo' => 'R#',
                'sevp'           => 'R#',
            ],

            // ── 4.6 Non-Budgeted Transfer of Fixed Assets within the Group* ──
            [
                'section_title'  => '4.6 Non-Budgeted Transfer of Fixed Assets within the Group* (exclude land and building)',
                'row_number'     => 1,
                'malaysia'       => 'Any Amount',
                'ceo'            => 'A',
                'deputy_ceo_coo' => 'R#',
                'sevp'           => 'P#',
                'evp'            => 'P#',
                'remarks'        => '*Based on the disposal value',
            ],
        ];

        // ─────────────────────────────────────────────────────────────────────
        // NON-CAPITAL EXPENDITURE
        // ─────────────────────────────────────────────────────────────────────
        $noncapital = [

            // ── 5.1 Procurement of Budgeted Non-Capital Expenditure ──
            [
                'section_title'  => '5.1 Procurement of Budgeted Non-Capital Expenditure',
                'row_number'     => 1,
                'malaysia'       => '> RM250k',
                'singapore'      => '> SGD250k',
                'australia'      => '> AUD250k',
                'vietnam'        => '> USD125k',
                'japan'          => '> JPY6 mil',
                'ceo'            => 'A',
                'sevp'           => 'R#',
                'evp'            => 'R#',
                'dgm'            => 'R#',
                'gm'             => 'P#',
                'deputy_gm_head' => 'P#',
                'remarks'        => 'Appointment of legal firm must be in consultation with Group Legal',
            ],
            [
                'section_title'  => '5.1 Procurement of Budgeted Non-Capital Expenditure',
                'row_number'     => 2,
                'malaysia'       => '<= RM250k',
                'singapore'      => '<= SGD250k',
                'australia'      => '<= AUD250k',
                'vietnam'        => '<= USD125k',
                'japan'          => '<= JPY6 mil',
                'deputy_ceo_coo' => 'A#',
                'sevp'           => 'R#',
                'evp'            => 'R#',
                'dgm'            => 'R#',
                'gm'             => 'P#',
                'deputy_gm_head' => 'P#',
            ],
            [
                'section_title'  => '5.1 Procurement of Budgeted Non-Capital Expenditure',
                'row_number'     => 3,
                'malaysia'       => '<= RM200k',
                'singapore'      => '<= SGD200k',
                'australia'      => '<= AUD200k',
                'vietnam'        => '<= USD100k',
                'japan'          => '<= JPY5 mil',
                'sevp'           => 'A#',
                'dgm'            => 'R#',
                'gm'             => 'R#',
                'deputy_gm_head' => 'R#',
            ],
            [
                'section_title'  => '5.1 Procurement of Budgeted Non-Capital Expenditure',
                'row_number'     => 4,
                'malaysia'       => '<= RM150k',
                'singapore'      => '<= SGD150k',
                'australia'      => '<= AUD150k',
                'vietnam'        => '<= USD75k',
                'japan'          => '<= JPY4 mil',
                'evp'            => 'A#',
                'dgm'            => 'R#',
                'gm'             => 'R#',
                'deputy_gm_head' => 'R#',
            ],
            [
                'section_title'  => '5.1 Procurement of Budgeted Non-Capital Expenditure',
                'row_number'     => 5,
                'malaysia'       => '<= RM100k',
                'singapore'      => '<= SGD100k',
                'australia'      => '<= AUD100k',
                'vietnam'        => '<= USD50k',
                'japan'          => '<= JPY3 mil',
                'dgm'            => 'A#',
                'gm'             => 'R#',
                'deputy_gm_head' => 'R#',
            ],
            [
                'section_title'  => '5.1 Procurement of Budgeted Non-Capital Expenditure',
                'row_number'     => 6,
                'malaysia'       => '<= RM50k',
                'singapore'      => '<= SGD50k',
                'australia'      => '<= AUD50k',
                'vietnam'        => '<= USD25k',
                'japan'          => '<= JPY1.5 mil',
                'gm'             => 'A#',
            ],
            [
                'section_title'  => '5.1 Procurement of Budgeted Non-Capital Expenditure',
                'row_number'     => 7,
                'malaysia'       => '<= RM25k',
                'singapore'      => '<= SGD25k',
                'australia'      => '-',
                'vietnam'        => '-',
                'japan'          => '-',
                'deputy_gm_head' => 'A#',
                'remarks'        => 'Malaysia and Singapore only',
            ],
            [
                'section_title'  => '5.1 Procurement of Budgeted Non-Capital Expenditure',
                'row_number'     => 8,
                'malaysia'       => '<= RM25k',
                'singapore'      => '<= SGD25k',
                'australia'      => '<= AUD5k',
                'vietnam'        => '<= USD2.5k',
                'japan'          => '<= JPY150k',
                'deputy_gm_head' => 'A#(1)',
                'remarks'        => '(1) All regions including Australia, Vietnam and Japan',
            ],

            // ── 5.2 Contribution / Sponsorship (includes cash and in-kind sponsorship) ──
            [
                'section_title'  => '5.2 Contribution / Sponsorship (includes cash and in-kind sponsorship)',
                'row_number'     => 1,
                'malaysia'       => 'RM100k and above',
                'bod'            => 'A',
                'ceo'            => 'R',
                'sevp'           => 'P#',
                'evp'            => 'P#',
                'dgm'            => 'P#',
            ],
            [
                'section_title'  => '5.2 Contribution / Sponsorship (includes cash and in-kind sponsorship)',
                'row_number'     => 2,
                'malaysia'       => 'Below RM100k',
                'rmc'            => 'I',
                'ceo'            => 'A',
                'sevp'           => 'P#',
                'evp'            => 'P#',
                'dgm'            => 'P#',
            ],
            [
                'section_title'  => '5.2 Contribution / Sponsorship (includes cash and in-kind sponsorship)',
                'row_number'     => 3,
                'malaysia'       => 'Below RM50k',
                'rmc'            => 'I',
                'deputy_ceo_coo' => 'A#',
                'sevp'           => 'R#',
                'evp'            => 'R#',
                'dgm'            => 'R#',
            ],
            [
                'section_title'  => '5.2 Contribution / Sponsorship (includes cash and in-kind sponsorship)',
                'row_number'     => 4,
                'malaysia'       => 'Below RM10k',
                'rmc'            => 'I',
                'evp'            => 'A#',
                'dgm'            => 'A#',
            ],

            // ── 5.3 Professional / Consultancy Services for Corporate Related Matters ──
            [
                'section_title'  => '5.3 Professional / Consultancy Services for Corporate Related Matters',
                'row_number'     => 1,
                'malaysia'       => 'More than RM1 mil',
                'ceo'            => 'R',
                'evp'            => 'R',
                'gm'             => 'P#',
                'deputy_gm_head' => 'P#',
                'remarks'        => 'Exclude out-of-pocket expenses',
            ],
            [
                'section_title'  => '5.3 Professional / Consultancy Services for Corporate Related Matters',
                'row_number'     => 2,
                'malaysia'       => 'Up to RM1 mil',
                'ceo'            => 'A',
                'evp'            => 'R',
                'gm'             => 'P#',
                'deputy_gm_head' => 'P#',
            ],
            [
                'section_title'  => '5.3 Professional / Consultancy Services for Corporate Related Matters',
                'row_number'     => 3,
                'malaysia'       => 'Up to RM100k',
                'evp'            => 'A (CFO)',
                'gm'             => 'P#',
                'deputy_gm_head' => 'P#',
            ],

            // ── 5.4 Appointment of Training Consultant ──
            [
                'section_title'  => '5.4 Appointment of Training Consultant',
                'row_number'     => 1,
                'malaysia'       => 'More than RM15k per day',
                'ceo'            => 'A',
                'deputy_ceo_coo' => 'R#',
                'dgm'            => 'P (CHCO)',
            ],

            // ── 5.5 Procurement of Budgeted Contingencies / Miscellaneous Non-Capital Expenditure* ──
            [
                'section_title'  => '5.5 Procurement of Budgeted Contingencies / Miscellaneous Non-Capital Expenditure*',
                'row_number'     => 1,
                'malaysia'       => 'More than RM500k',
                'sevp'           => 'A#',
                'evp'            => 'R#',
                'dgm'            => 'R#',
                'gm'             => 'P#',
                'deputy_gm_head' => 'P#',
                'remarks'        => '*10% of the approved individual Non-CAPEX line item subject to maximum cap limit of not exceeding 5% of the approved annual budgeted Non-CAPEX (excluding staff costs, non-cash items, donations and sponsorship)',
            ],
            [
                'section_title'  => '5.5 Procurement of Budgeted Contingencies / Miscellaneous Non-Capital Expenditure*',
                'row_number'     => 2,
                'malaysia'       => 'Up to RM500k',
                'deputy_ceo_coo' => 'A#',
                'sevp'           => 'R#',
                'evp'            => 'R#',
                'dgm'            => 'R#',
                'gm'             => 'P#',
                'deputy_gm_head' => 'P#',
            ],

            // ── 5.6 Acquisition of Non-Budgeted Non-Capital Expenditure ──
            [
                'section_title'  => '5.6 Acquisition of Non-Budgeted Non-Capital Expenditure (excluding items under budgeted contingencies / miscellaneous non-capital expenditure)',
                'row_number'     => 1,
                'malaysia'       => 'Any Amount',
                'bod'            => 'A',
                'ceo'            => 'R',
                'deputy_ceo_coo' => 'P#',
                'sevp'           => 'P#',
                'evp'            => 'P#',
            ],

            // ── 5.7 Acquisition of Non-Budgeted Non-Capital Expenditure (staff costs / budget transfer) ──
            [
                'section_title'  => '5.7 Acquisition of Non-Budgeted Non-Capital Expenditure (excluding items under budgeted contingencies / miscellaneous non-capital expenditure) - Budget Transfer',
                'row_number'     => 1,
                'malaysia'       => 'As per approved budgeted amount',
                'sevp'           => 'A#',
                'evp'            => 'A#',
                'dgm'            => 'A#',
                'gm'             => 'R#',
                'deputy_gm_head' => 'R#',
            ],

            // ── 5.8 Appointment / Termination of Assurance Provider ──
            [
                'section_title'  => '5.8 Appointment / Termination of Assurance Provider',
                'row_number'     => 1,
                'malaysia'       => 'Any Amount',
                'ac'             => 'A',
                'dgm'            => 'P (CIA)',
                'remarks'        => 'For matters under AC\'s purview',
            ],
        ];

        $now = now();

        // Insert capital entries
        foreach ($capital as $entry) {
            DB::table('dal_entries')->insert(array_merge([
                'type'           => 'capital',
                'section_title'  => null,
                'row_number'     => null,
                'malaysia'       => null,
                'singapore'      => null,
                'australia'      => null,
                'vietnam'        => null,
                'japan'          => null,
                'shr'            => null,
                'sub_shr'        => null,
                'bod'            => null,
                'sub_bod'        => null,
                'nrc'            => null,
                'ac'             => null,
                'rmc'            => null,
                'tpc'            => null,
                'fic'            => null,
                'sc'             => null,
                'sub_exco'       => null,
                'ceo'            => null,
                'deputy_ceo_coo' => null,
                'sevp'           => null,
                'evp'            => null,
                'dgm'            => null,
                'gm'             => null,
                'deputy_gm_head' => null,
                'remarks'        => null,
                'created_at'     => $now,
                'updated_at'     => $now,
            ], $entry));
        }

        // Insert non-capital entries
        foreach ($noncapital as $entry) {
            DB::table('dal_entries')->insert(array_merge([
                'type'           => 'noncapital',
                'section_title'  => null,
                'row_number'     => null,
                'malaysia'       => null,
                'singapore'      => null,
                'australia'      => null,
                'vietnam'        => null,
                'japan'          => null,
                'shr'            => null,
                'sub_shr'        => null,
                'bod'            => null,
                'sub_bod'        => null,
                'nrc'            => null,
                'ac'             => null,
                'rmc'            => null,
                'tpc'            => null,
                'fic'            => null,
                'sc'             => null,
                'sub_exco'       => null,
                'ceo'            => null,
                'deputy_ceo_coo' => null,
                'sevp'           => null,
                'evp'            => null,
                'dgm'            => null,
                'gm'             => null,
                'deputy_gm_head' => null,
                'remarks'        => null,
                'created_at'     => $now,
                'updated_at'     => $now,
            ], $entry));
        }

        $totalCapital    = count($capital);
        $totalNonCapital = count($noncapital);
        $this->command->info("✅ Seeded {$totalCapital} capital entries and {$totalNonCapital} non-capital entries.");
    }
}
