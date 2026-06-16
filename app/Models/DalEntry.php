<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DalEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'section_title', 'row_number',
        'malaysia', 'singapore', 'australia', 'vietnam', 'japan',
        'shr', 'sub_shr', 'bod', 'sub_bod', 'nrc', 'ac', 'rmc',
        'tpc', 'fic', 'sc', 'sub_exco', 'ceo', 'deputy_ceo_coo',
        'sevp', 'evp', 'dgm', 'gm', 'deputy_gm_head', 'remarks',
        'created_by', 'updated_by',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
