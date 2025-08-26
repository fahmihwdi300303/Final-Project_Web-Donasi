<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory;

    protected $table = 'donations';
    protected $primaryKey = 'donation_id'; // penting: di Blade kamu pakai donation_id
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id', 'jumlah', 'metode_pembayaran', 'status', 'catatan'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
