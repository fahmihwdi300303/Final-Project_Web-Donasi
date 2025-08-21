<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Donasi - LKSA Yatim Muhammadiyah Karangasem</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-donasi.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .laporan-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .laporan-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            font-family: 'Inter', sans-serif;
        }
        
        .laporan-subtitle {
            color: #6b7280;
            margin-bottom: 2rem;
            font-family: 'Inter', sans-serif;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }
        
        .table-container {
            overflow-x: auto;
            margin-top: 2rem;
        }
        
        .donasi-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .donasi-table th,
        .donasi-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .donasi-table th {
            background: #f9fafb;
            font-weight: 600;
            color: #374151;
        }
        
        .donasi-table tr:hover {
            background: #f9fafb;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-selesai {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-proses {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-pending {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .filter-section {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        
        .filter-select {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.875rem;
        }
        
        .search-input {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.875rem;
            min-width: 200px;
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .filter-section {
                flex-direction: column;
            }
            
            .donasi-table {
                font-size: 0.875rem;
            }
            
            .donasi-table th,
            .donasi-table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="laporan-section">
                <h1 class="laporan-title">Laporan Donasi</h1>
                <p class="laporan-subtitle">Transparansi penggunaan dana donasi untuk anak-anak yatim</p>
                
                <!-- Statistics -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">Rp 15.750.000</div>
                        <div class="stat-label">Total Donasi Uang</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">247</div>
                        <div class="stat-label">Total Donatur</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">89</div>
                        <div class="stat-label">Donasi Barang</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">12</div>
                        <div class="stat-label">Program Terlaksana</div>
                    </div>
                </div>
                
                <!-- Filters -->
                <div class="filter-section">
                    <select class="filter-select" id="jenisFilter">
                        <option value="">Semua Jenis</option>
                        <option value="uang">Donasi Uang</option>
                        <option value="barang">Donasi Barang</option>
                    </select>
                    
                    <select class="filter-select" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="selesai">Selesai</option>
                        <option value="proses">Proses</option>
                        <option value="pending">Pending</option>
                    </select>
                    
                    <input type="text" class="search-input" id="searchInput" placeholder="Cari donatur...">
                </div>
                
                <!-- Table -->
                <div class="table-container">
                    <table class="donasi-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Donatur</th>
                                <th>Jenis Donasi</th>
                                <th>Jumlah/Nilai</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>15 Jan 2025</td>
                                <td>Ahmad Fahmi</td>
                                <td>Uang</td>
                                <td>Rp 500.000</td>
                                <td><span class="status-badge status-selesai">Selesai</span></td>
                                <td>Untuk pembelian buku pelajaran</td>
                            </tr>
                            <tr>
                                <td>14 Jan 2025</td>
                                <td>Siti Nurhaliza</td>
                                <td>Barang</td>
                                <td>10 Pakaian</td>
                                <td><span class="status-badge status-proses">Proses</span></td>
                                <td>Pakaian anak-anak</td>
                            </tr>
                            <tr>
                                <td>13 Jan 2025</td>
                                <td>Budi Santoso</td>
                                <td>Uang</td>
                                <td>Rp 1.000.000</td>
                                <td><span class="status-badge status-selesai">Selesai</span></td>
                                <td>Untuk renovasi asrama</td>
                            </tr>
                            <tr>
                                <td>12 Jan 2025</td>
                                <td>Dewi Sartika</td>
                                <td>Barang</td>
                                <td>5 Buku</td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td>Buku bacaan anak</td>
                            </tr>
                            <tr>
                                <td>11 Jan 2025</td>
                                <td>Rudi Hermawan</td>
                                <td>Uang</td>
                                <td>Rp 750.000</td>
                                <td><span class="status-badge status-selesai">Selesai</span></td>
                                <td>Untuk kegiatan olahraga</td>
                            </tr>
                            <tr>
                                <td>10 Jan 2025</td>
                                <td>Maya Indah</td>
                                <td>Barang</td>
                                <td>3 Mainan</td>
                                <td><span class="status-badge status-proses">Proses</span></td>
                                <td>Mainan edukatif</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <div class="footer-logo">
                    <i class="fas fa-quote-left"></i>
                    <span>FH</span>
                </div>
            </div>
            
            <div class="footer-divider"></div>
            
            <div class="footer-social">
                <a href="#" class="social-icon">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="#" class="social-icon">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
            
            <div class="footer-copyright">
                <p>&copy; Since. 2025. Fahmi Huwaidi</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script>
        // Simple filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const jenisFilter = document.getElementById('jenisFilter');
            const statusFilter = document.getElementById('statusFilter');
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('.donasi-table tbody tr');
            
            function filterTable() {
                const jenisValue = jenisFilter.value.toLowerCase();
                const statusValue = statusFilter.value.toLowerCase();
                const searchValue = searchInput.value.toLowerCase();
                
                tableRows.forEach(row => {
                    const jenis = row.cells[2].textContent.toLowerCase();
                    const status = row.cells[4].textContent.toLowerCase();
                    const nama = row.cells[1].textContent.toLowerCase();
                    
                    const jenisMatch = !jenisValue || jenis.includes(jenisValue);
                    const statusMatch = !statusValue || status.includes(statusValue);
                    const searchMatch = !searchValue || nama.includes(searchValue);
                    
                    if (jenisMatch && statusMatch && searchMatch) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
            
            jenisFilter.addEventListener('change', filterTable);
            statusFilter.addEventListener('change', filterTable);
            searchInput.addEventListener('input', filterTable);
        });
    </script>
</body>
</html>
