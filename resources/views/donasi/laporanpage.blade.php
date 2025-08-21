<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan Dana Donasi - LKSA Yatim Muhammadiyah Karangasem</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="report-container">
                <!-- Page Title -->
                <div class="page-header">
                    <h1 class="page-title">Laporan Keuangan Dana</h1>
                    <h2 class="page-subtitle">Donasi Panti Asuhan</h2>
                </div>

                <!-- Filter Section -->
                <div class="filter-section">
                    <select id="reportFilter" class="filter-select">
                        <option value="monthly">Per Semester</option>
                        <option value="yearly">Per Tahun</option>
                    </select>
                </div>

                <!-- Report Table -->
                <div class="report-table-container">
                    <table class="report-table" id="reportTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Total Uang</th>
                                <th>Ket</th>
                            </tr>
                        </thead>
                        <tbody id="reportTableBody">
                            <!-- Data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Chart Section -->
                <div class="chart-section">
                    <h3 class="chart-title">Grafik Donasi</h3>
                    <div class="chart-container">
                        <canvas id="donationChart" width="400" height="200"></canvas>
                    </div>
                </div>

                <!-- bar chart -->
<canvas id="donationChart" width="800" height="400"></canvas>
<script src="{{ asset('js/report.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        initializeReportPage();
    });
</script>


                <!-- Download Button -->
                <div class="download-section">
                    <button class="btn btn-primary btn-download" id="downloadBtn">Download</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <div class="footer-icon">FH</div>
            </div>
            <div class="footer-divider"></div>
            <div class="footer-social">
                <div class="social-icon"></div>
                <div class="social-icon"></div>
                <div class="social-icon"></div>
                <div class="social-icon"></div>
            </div>
            <div class="footer-copyright">
                © Since 2025. Fahmi Huwadi
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
