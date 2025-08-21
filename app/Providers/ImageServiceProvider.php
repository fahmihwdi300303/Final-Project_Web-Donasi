<?php

namespace App\Providers;

use App\Repositories\ImageRepositoryInterface;
use App\Repositories\EloquentImageRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Service Provider untuk Image Management
 * 
 * Penerapan SOLID:
 * - DIP: Binding interface ke implementasi konkret
 * - OCP: Bisa ganti implementasi repository tanpa mengubah kode lain
 * - LSP: Memastikan implementasi bisa diinterchange
 */
class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind interface repository ke implementasi Eloquent
        $this->app->bind(ImageRepositoryInterface::class, EloquentImageRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
