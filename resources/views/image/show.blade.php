<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $image->original_name }} - Website Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .image-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .image-display {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            transition: transform 0.3s ease;
        }
        .image-display:hover {
            transform: scale(1.02);
        }
        .info-card {
            background: rgba(255,255,255,0.95);
            border-radius: 10px;
            padding: 20px;
            backdrop-filter: blur(10px);
        }
        .btn-action {
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-action:hover {
            transform: translateY(-2px);
        }
        .metadata-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .metadata-item:last-child {
            border-bottom: none;
        }
        .metadata-label {
            font-weight: 600;
            color: #495057;
        }
        .metadata-value {
            color: #6c757d;
        }
        .success-message {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            border: none;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        @if(session('success'))
            <div class="alert success-message alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="image-container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="text-center">
                                <img src="{{ $image->url }}" 
                                     alt="{{ $image->original_name }}" 
                                     class="image-display img-fluid"
                                     style="max-height: 500px;">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="info-card h-100">
                                <h4 class="mb-4">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>
                                    Informasi Gambar
                                </h4>
                                
                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-file-image me-2"></i>
                                        Nama File
                                    </div>
                                    <div class="metadata-value">{{ $image->original_name }}</div>
                                </div>

                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-calendar me-2"></i>
                                        Tanggal Upload
                                    </div>
                                    <div class="metadata-value">{{ $image->created_at->format('d M Y H:i') }}</div>
                                </div>

                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-weight me-2"></i>
                                        Ukuran File
                                    </div>
                                    <div class="metadata-value">{{ number_format($image->size / 1024, 2) }} KB</div>
                                </div>

                                <div class="metadata-item">
                                    <div class="metadata-label">
                                        <i class="fas fa-file-code me-2"></i>
                                        Tipe File
                                    </div>
                                    <div class="metadata-value">{{ strtoupper(pathinfo($image->original_name, PATHINFO_EXTENSION)) }}</div>
                                </div>

                                @if($image->description)
                                    <div class="metadata-item">
                                        <div class="metadata-label">
                                            <i class="fas fa-comment me-2"></i>
                                            Deskripsi
                                        </div>
                                        <div class="metadata-value">{{ $image->description }}</div>
                                    </div>
                                @endif

                                @if($image->user)
                                    <div class="metadata-item">
                                        <div class="metadata-label">
                                            <i class="fas fa-user me-2"></i>
                                            Diupload Oleh
                                        </div>
                                        <div class="metadata-value">{{ $image->user->name ?? 'User' }}</div>
                                    </div>
                                @endif

                                <hr class="my-4">

                                <div class="d-grid gap-2">
                                    <a href="{{ $image->url }}" 
                                       target="_blank" 
                                       class="btn btn-primary btn-action">
                                        <i class="fas fa-external-link-alt me-2"></i>
                                        Lihat Gambar Asli
                                    </a>
                                    
                                    <a href="{{ route('images.create') }}" 
                                       class="btn btn-success btn-action">
                                        <i class="fas fa-plus me-2"></i>
                                        Upload Gambar Baru
                                    </a>
                                    
                                    <a href="{{ route('images.index') }}" 
                                       class="btn btn-outline-secondary btn-action">
                                        <i class="fas fa-list me-2"></i>
                                        Daftar Semua Gambar
                                    </a>

                                    <form action="{{ route('images.destroy', $image->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-action w-100">
                                            <i class="fas fa-trash me-2"></i>
                                            Hapus Gambar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
