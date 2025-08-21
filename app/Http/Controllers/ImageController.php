<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Interface Adapter Layer - Image Controller
 * 
 * Penerapan SOLID:
 * - SRP: Controller hanya bertanggung jawab untuk mengatur request/response
 * - DIP: Bergantung pada service interface, bukan implementasi langsung
 * - OCP: Bisa ditambah method baru tanpa mengubah kode utama
 * - LSP: Bisa menggunakan service apapun yang mengikuti kontrak yang sama
 */
class ImageController extends Controller
{
    /**
     * @var ImageService
     */
    protected $imageService;

    /**
     * ImageController constructor.
     *
     * @param ImageService $imageService
     */
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display the upload form
     *
     * @return View
     */
    public function create(): View
    {
        return view('image.upload');
    }

    /**
     * Store a newly uploaded image
     *
     * @param StoreImageRequest $request
     * @return RedirectResponse
     */
    public function store(StoreImageRequest $request): RedirectResponse
    {
        try {
            $file = $request->file('image');
            $description = $request->input('description');

            $additionalData = [];
            if ($description) {
                $additionalData['description'] = $description;
            }

            $image = $this->imageService->uploadImage($file, $additionalData);

            return redirect()
                ->route('images.show', $image->id)
                ->with('success', 'Gambar berhasil diupload!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified image
     *
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $image = $this->imageService->getImageById($id);

        if (!$image) {
            abort(404, 'Gambar tidak ditemukan');
        }

        return view('image.show', compact('image'));
    }

    /**
     * Display a listing of all images
     *
     * @return View
     */
    public function index(): View
    {
        $images = $this->imageService->getAllImages();

        return view('image.index', compact('images'));
    }

    /**
     * Remove the specified image
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $deleted = $this->imageService->deleteImage($id);

            if (!$deleted) {
                return back()->withErrors(['error' => 'Gambar tidak ditemukan']);
            }

            return redirect()
                ->route('images.index')
                ->with('success', 'Gambar berhasil dihapus!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
