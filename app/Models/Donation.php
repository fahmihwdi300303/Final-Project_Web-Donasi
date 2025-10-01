<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    protected $table = 'donations';
    protected $primaryKey = 'donation_id'; // <- ganti sesuai kolom PK sebenarnya
    public $incrementing = true;           // atau false kalau bukan auto-increment
    protected $keyType = 'int';            // atau 'string' sesuai tipe
    protected $fillable = ['user_id','jumlah','metode_pembayaran','status','bukti_transfer'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
