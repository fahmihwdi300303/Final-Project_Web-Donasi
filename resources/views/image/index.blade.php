<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Gambar - Website Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gallery-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .gallery-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .gallery-card:hover .gallery-image {
            transform: scale(1.05);
        }
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .gallery-card:hover .image-overlay {
            opacity: 1;
        }
        .btn-floating {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        .btn-floating:hover {
            transform: scale(1.1);
        }
        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
        }
        .stats-card {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            backdrop-filter: blur(10px);
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Header Section -->
        <div class="header-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-3">
                        <i class="fas fa-images me-3"></i>
                        Galeri Gambar Donasi
                    </h2>
                    <p class="mb-0 opacity-75">
                        Kelola dan lihat semua gambar yang telah diupload untuk kegiatan donasi
                    </p>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <h3 class="mb-1">{{ $images->count() }}</h3>
                        <p class="mb-0 opacity-75">Total Gambar</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('images.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>
                    Upload Gambar Baru
                </a>
            </div>
        </div>

        <!-- Gallery Grid -->
        @if($images->count() > 0)
            <div class="row">
                @foreach($images as $image)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card gallery-card">
                            <div class="position-relative">
                                <img src="{{ $image->url }}" 
                                     alt="{{ $image->original_name }}" 
                                     class="gallery-image"
                                     loading="lazy">
                                
                                <div class="image-overlay">
                                    <a href="{{ route('images.show', $image->id) }}" 
                                       class="btn btn-light btn-floating" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ $image->url }}" 
                                       target="_blank" 
                                       class="btn btn-primary btn-floating" 
                                       title="Lihat Gambar Asli">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <form action="{{ route('images.destroy', $image->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-floating" 
                                                title="Hapus Gambar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <h6 class="card-title text-truncate" title="{{ $image->original_name }}">
                                    {{ $image->original_name }}
                                </h6>
                                
                                @if($image->description)
                                    <p class="card-text text-muted small text-truncate" title="{{ $image->description }}">
                                        {{ $image->description }}
                                    </p>
                                @endif
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $image->created_at->format('d M Y') }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-weight me-1"></i>
                                        {{ number_format($image->size / 1024, 1) }} KB
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-images"></i>
                <h4>Belum Ada Gambar</h4>
                <p class="mb-4">Mulai dengan mengupload gambar pertama Anda untuk kegiatan donasi.</p>
                <a href="{{ route('images.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>
                    Upload Gambar Pertama
                </a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
