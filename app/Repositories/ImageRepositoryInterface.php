<?php

namespace App\Repositories;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface Adapter Layer - Image Repository Interface
 * 
 * Penerapan SOLID:
 * - ISP (Interface Segregation Principle): Interface terpisah untuk operasi upload dan fetch
 * - DIP (Dependency Inversion Principle): Controller bergantung pada interface, bukan implementasi
 * - SRP: Interface hanya mendefinisikan kontrak untuk operasi gambar
 */
interface ImageRepositoryInterface
{
    /**
     * Store a new image in the database
     *
     * @param array $data
     * @return Image
     */
    public function store(array $data): Image;

    /**
     * Get all images
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get image by ID
     *
     * @param int $id
     * @return Image|null
     */
    public function findById(int $id): ?Image;

    /**
     * Delete image by ID
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Update image data
     *
     * @param int $id
     * @param array $data
     * @return Image|null
     */
    public function update(int $id, array $data): ?Image;
}
