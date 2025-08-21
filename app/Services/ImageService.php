<?php

namespace App\Services;

use App\Repositories\ImageRepositoryInterface;
use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

/**
 * Use Case Layer - Image Service
 * 
 * Penerapan SOLID:
 * - SRP: Service hanya bertanggung jawab untuk business logic gambar
 * - DIP: Bergantung pada interface repository, bukan implementasi langsung
 * - OCP: Bisa ditambah tipe gambar baru tanpa mengubah kode utama
 * - LSP: Bisa menggunakan implementasi repository apapun yang mengikuti interface
 */
class ImageService
{
    /**
     * @var ImageRepositoryInterface
     */
    protected $imageRepository;

    /**
     * @var string
     */
    protected $storagePath = 'images';

    /**
     * @var array
     */
    protected $allowedMimeTypes = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'image/webp'
    ];

    /**
     * @var int
     */
    protected $maxFileSize = 5242880; // 5MB

    /**
     * ImageService constructor.
     *
     * @param ImageRepositoryInterface $imageRepository
     */
    public function __construct(ImageRepositoryInterface $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    /**
     * Upload and store image
     *
     * @param UploadedFile $file
     * @param array $additionalData
     * @return Image
     * @throws \Exception
     */
    public function uploadImage(UploadedFile $file, array $additionalData = []): Image
    {
        // Validate file
        $this->validateFile($file);

        // Generate unique filename
        $filename = $this->generateFilename($file);
        
        // Store file in storage
        $path = $file->storeAs($this->storagePath, $filename, 'public');

        // Prepare data for database
        $data = array_merge([
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_by' => auth()->id() ?? 1, // Default to user ID 1 if not authenticated
        ], $additionalData);

        // Store in database
        return $this->imageRepository->store($data);
    }

    /**
     * Get all images
     *
     * @return Collection
     */
    public function getAllImages(): Collection
    {
        return $this->imageRepository->getAll();
    }

    /**
     * Get image by ID
     *
     * @param int $id
     * @return Image|null
     */
    public function getImageById(int $id): ?Image
    {
        return $this->imageRepository->findById($id);
    }

    /**
     * Delete image
     *
     * @param int $id
     * @return bool
     */
    public function deleteImage(int $id): bool
    {
        return $this->imageRepository->delete($id);
    }

    /**
     * Update image data
     *
     * @param int $id
     * @param array $data
     * @return Image|null
     */
    public function updateImage(int $id, array $data): ?Image
    {
        return $this->imageRepository->update($id, $data);
    }

    /**
     * Validate uploaded file
     *
     * @param UploadedFile $file
     * @throws \Exception
     */
    protected function validateFile(UploadedFile $file): void
    {
        if (!$file->isValid()) {
            throw new \Exception('File upload failed');
        }

        if (!in_array($file->getMimeType(), $this->allowedMimeTypes)) {
            throw new \Exception('File type not allowed. Allowed types: ' . implode(', ', $this->allowedMimeTypes));
        }

        if ($file->getSize() > $this->maxFileSize) {
            throw new \Exception('File size too large. Maximum size: ' . ($this->maxFileSize / 1024 / 1024) . 'MB');
        }
    }

    /**
     * Generate unique filename
     *
     * @param UploadedFile $file
     * @return string
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('Y-m-d_H-i-s');
        $random = Str::random(8);
        
        return "{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Get allowed mime types
     *
     * @return array
     */
    public function getAllowedMimeTypes(): array
    {
        return $this->allowedMimeTypes;
    }

    /**
     * Get max file size
     *
     * @return int
     */
    public function getMaxFileSize(): int
    {
        return $this->maxFileSize;
    }
}
