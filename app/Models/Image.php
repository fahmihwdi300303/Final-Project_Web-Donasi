<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Entity Layer - Model Image
 * 
 * Penerapan SOLID:
 * - SRP: Model hanya bertanggung jawab untuk representasi data gambar
 * - OCP: Bisa diperluas dengan trait atau interface tanpa mengubah kode utama
 * - LSP: Mengikuti kontrak Model Laravel sehingga bisa diinterchange
 */
class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'filename',
        'original_name',
        'path',
        'size',
        'mime_type',
        'description',
        'uploaded_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'size' => 'integer',
    ];

    /**
     * Get the user who uploaded the image.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the full URL of the image.
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }

    /**
     * Get the storage path of the image.
     */
    public function getStoragePathAttribute()
    {
        return storage_path('app/public/' . $this->path);
    }
}
