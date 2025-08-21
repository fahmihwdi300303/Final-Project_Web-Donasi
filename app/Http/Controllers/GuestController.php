<?php

namespace App\Http\Controllers;

class GuestController extends Controller
{
    public function homepage()
    {
        // Data program unggulan
        $programs = [
            [
                'title' => "Hafalan Al-Qur'an dengan Target lulus 15 juz",
                'description' => "Program hafalan Al-Qur'an setiap hari dengan target 15 juz, dibimbing guru berpengalaman dengan fokus tajwid dan tahsin.",
                'image' => "https://via.placeholder.com/400x300/4A90E2/FFFFFF?text=Hafalan+Al-Qur'an"
            ],
            [
                'title' => "Belajar Qiro'ah dengan Qori' Nasional Setiap Kamis Malam",
                'description' => "Pembelajaran Qiro'ah setiap Kamis malam bersama Qori' Nasional untuk meningkatkan kemampuan membaca Al-Qur'an dengan tartil.",
                'image' => "https://via.placeholder.com/400x300/50C878/FFFFFF?text=Qiro'ah"
            ],
            [
                'title' => "Latihan Menjahit di Bimbing langsung Oleh Penjahit Professional",
                'description' => "Pelatihan menjahit dari dasar hingga mahir untuk membekali anak dengan keterampilan wirausaha dan disiplin.",
                'image' => "https://via.placeholder.com/400x300/FF6B35/FFFFFF?text=Menjahit"
            ]
        ];

        // Data fasilitas
        $facilities = [
            [
                'title' => 'Masjid dan Asrama',
                'description' => 'Gedung masjid dan asrama sepenuhnya milik LKSA.',
                'image' => 'https://via.placeholder.com/300x200/8B4513/FFFFFF?text=Masjid+dan+Asrama'
            ],
            [
                'title' => 'Sekolah',
                'description' => 'Aktivitas sekolah berada di Ponpes Karangasem (SD-SMA).',
                'image' => 'https://via.placeholder.com/300x200/228B22/FFFFFF?text=Sekolah'
            ],
            [
                'title' => 'Dapur Bersama',
                'description' => 'Dapur pribadi dengan koki, anak-anak juga bisa belajar memasak.',
                'image' => 'https://via.placeholder.com/300x200/FFD700/000000?text=Dapur+Bersama'
            ],
            [
                'title' => 'Pendopo dan Aula',
                'description' => 'Fasilitas untuk aktivitas bersama anak-anak.',
                'image' => 'https://via.placeholder.com/300x200/CD853F/FFFFFF?text=Pendopo+dan+Aula'
            ]
        ];

        // Statistik
        $statistics = [
            ['icon' => 'fas fa-hand-holding-usd', 'value' => '300+', 'label' => 'Donatur Tetap'],
            ['icon' => 'fas fa-certificate', 'value' => 'Terakreditasi A', 'label' => 'oleh Lembaga Kesejahteraan Sosial'],
            ['icon' => 'fas fa-users', 'value' => '129', 'label' => 'Total anak asuh saat ini'],
            ['icon' => 'fas fa-graduation-cap', 'value' => 'Ratusan', 'label' => 'alumni menjadi tenaga profesional'],
        ];

        return view('guest.homepage', compact('programs', 'facilities', 'statistics'));
    }

    // Kalau masih butuh profile, activities, about, contact bisa disesuaikan dengan struktur yang sama
    public function aboutUs()
{
    return view('aboutus'); // pastikan file view resources/views/about.blade.php ada
}

    // Halaman kegiatan
    public function profile()
    {
        return view('kegiatanpage');
    }
}
