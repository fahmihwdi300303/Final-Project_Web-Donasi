<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationVerification extends Model
{
    use HasFactory;

    protected $primaryKey = 'verification_id';

    protected $fillable = [
        'donasi_id',
        'admin_id',
        'status',
        'catatan',
        'verified_at',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donasi_id');
    }
}
