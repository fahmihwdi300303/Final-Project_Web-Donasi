<?php

namespace App\Repositories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface Adapter Layer - Eloquent Image Repository Implementation
 * 
 * Penerapan SOLID:
 * - LSP (Liskov Substitution Principle): Implementasi bisa diinterchange dengan implementasi lain
 * - SRP: Repository hanya bertanggung jawab untuk operasi database gambar
 * - OCP: Bisa ditambah implementasi repository lain tanpa mengubah interface
 */
class EloquentImageRepository implements ImageRepositoryInterface
{
    /**
     * Store a new image in the database
     *
     * @param array $data
     * @return Image
     */
    public function store(array $data): Image
    {
        return Image::create($data);
    }

    /**
     * Get all images
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Image::orderBy('created_at', 'desc')->get();
    }

    /**
     * Get image by ID
     *
     * @param int $id
     * @return Image|null
     */
    public function findById(int $id): ?Image
    {
        return Image::find($id);
    }

    /**
     * Delete image by ID
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $image = $this->findById($id);
        
        if (!$image) {
            return false;
        }

        // Delete file from storage
        if (file_exists($image->storage_path)) {
            unlink($image->storage_path);
        }

        return $image->delete();
    }

    /**
     * Update image data
     *
     * @param int $id
     * @param array $data
     * @return Image|null
     */
    public function update(int $id, array $data): ?Image
    {
        $image = $this->findById($id);
        
        if (!$image) {
            return null;
        }

        $image->update($data);
        return $image;
    }
}
