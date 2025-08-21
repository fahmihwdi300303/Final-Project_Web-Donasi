<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\ImageService;

/**
 * Interface Adapter Layer - Store Image Request Validation
 * 
 * Penerapan SOLID:
 * - SRP: Request hanya bertanggung jawab untuk validasi input upload gambar
 * - DIP: Bergantung pada service untuk mendapatkan konfigurasi validasi
 * - OCP: Bisa ditambah rule validasi baru tanpa mengubah kode utama
 */
class StoreImageRequest extends FormRequest
{
    /**
     * @var ImageService
     */
    protected $imageService;

    /**
     * StoreImageRequest constructor.
     *
     * @param ImageService $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Bisa disesuaikan dengan middleware auth
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $allowedMimeTypes = implode(',', $this->imageService->getAllowedMimeTypes());
        $maxFileSize = $this->imageService->getMaxFileSize() / 1024; // Convert to KB

        return [
            'image' => [
                'required',
                'file',
                'image',
                'mimes:' . str_replace('image/', '', $allowedMimeTypes),
                'max:' . $maxFileSize,
            ],
            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'image.required' => 'Pilih file gambar untuk diupload.',
            'image.file' => 'File yang diupload harus berupa file.',
            'image.image' => 'File yang diupload harus berupa gambar.',
            'image.mimes' => 'Format gambar tidak didukung. Format yang didukung: JPG, PNG, GIF, WEBP.',
            'image.max' => 'Ukuran file terlalu besar. Maksimal ' . ($this->imageService->getMaxFileSize() / 1024 / 1024) . 'MB.',
            'description.max' => 'Deskripsi gambar maksimal 500 karakter.',
        ];
    }

    /**
     * Get custom attributes for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'image' => 'gambar',
            'description' => 'deskripsi',
        ];
    }
}
