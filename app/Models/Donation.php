<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $primaryKey = 'donation_id';

    protected $fillable = [
        'user_id',
        'jumlah',
        'metode_pembayaran',
        'bukti_transfer',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verification()
    {
        return $this->hasOne(DonationVerification::class, 'donasi_id');
    }
}
