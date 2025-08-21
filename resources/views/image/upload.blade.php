<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Gambar - Website Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        .upload-area:hover {
            border-color: #007bff;
            background-color: #e3f2fd;
        }
        .upload-area.dragover {
            border-color: #28a745;
            background-color: #d4edda;
        }
        .file-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 15px;
        }
        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #004085);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="mb-0">
                            <i class="fas fa-cloud-upload-alt me-2"></i>
                            Upload Gambar Donasi
                        </h3>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                            @csrf
                            
                            <div class="upload-area mb-4" id="uploadArea">
                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Pilih atau Drag & Drop Gambar</h5>
                                <p class="text-muted mb-3">
                                    Format yang didukung: JPG, PNG, GIF, WEBP<br>
                                    Maksimal ukuran: 5MB
                                </p>
                                <input type="file" name="image" id="imageInput" class="form-control" accept="image/*" style="display: none;">
                                <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('imageInput').click()">
                                    <i class="fas fa-folder-open me-2"></i>
                                    Pilih File
                                </button>
                            </div>

                            <div id="filePreview" class="text-center mb-4" style="display: none;">
                                <img id="previewImage" class="file-preview mb-3">
                                <div>
                                    <strong id="fileName"></strong><br>
                                    <small class="text-muted" id="fileSize"></small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">
                                    <i class="fas fa-comment me-2"></i>
                                    Deskripsi Gambar (Opsional)
                                </label>
                                <textarea 
                                    name="description" 
                                    id="description" 
                                    class="form-control" 
                                    rows="3" 
                                    placeholder="Tambahkan deskripsi untuk gambar ini..."
                                    maxlength="500"
                                >{{ old('description') }}</textarea>
                                <div class="form-text">
                                    <span id="charCount">0</span>/500 karakter
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                                    <i class="fas fa-upload me-2"></i>
                                    Upload Gambar
                                </button>
                                <a href="{{ route('images.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali ke Daftar Gambar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const uploadArea = document.getElementById('uploadArea');
        const imageInput = document.getElementById('imageInput');
        const filePreview = document.getElementById('filePreview');
        const previewImage = document.getElementById('previewImage');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const submitBtn = document.getElementById('submitBtn');
        const description = document.getElementById('description');
        const charCount = document.getElementById('charCount');

        // Drag and drop functionality
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                imageInput.files = files;
                handleFileSelect();
            }
        });

        // File input change
        imageInput.addEventListener('change', handleFileSelect);

        function handleFileSelect() {
            const file = imageInput.files[0];
            if (file) {
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    filePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);

                // Show file info
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);

                // Enable submit button
                submitBtn.disabled = false;
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Character count for description
        description.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            if (count > 450) {
                charCount.style.color = '#dc3545';
            } else if (count > 400) {
                charCount.style.color = '#ffc107';
            } else {
                charCount.style.color = '#6c757d';
            }
        });
    </script>
</body>
</html>
