<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display the kegiatan page
     */
    public function index()
    {
        // Sample activity data - in a real application, this would come from a database
        $activities = [
            [
                'id' => 1,
                'title' => 'Donasi 38 Pasang Sepatu untuk Anak LKSA Yatim Muhammadiyah Karangasem',
                'image' => 'https://via.placeholder.com/600x400/4A90E2/FFFFFF?text=Donasi+Sepatu',
                'description' => 'Kegiatan donasi sepatu untuk anak-anak panti asuhan',
                'date' => '2024-01-15'
            ],
            [
                'id' => 2,
                'title' => 'Kegiatan Kontribusi Nasional Modul Nusantara oleh Kaka-kaka Volunteer ABHINAYA',
                'image' => 'https://via.placeholder.com/600x400/50C878/FFFFFF?text=Kontribusi+Nasional',
                'description' => 'Program kontribusi nasional untuk pengembangan modul pendidikan',
                'date' => '2024-01-20'
            ],
            [
                'id' => 3,
                'title' => 'Donasi oleh Volunteer ABHINAYA ke Anak LKSA Yatim Muhammadiyah Karangasem',
                'image' => 'https://via.placeholder.com/600x400/FF6B35/FFFFFF?text=Donasi+Volunteer',
                'description' => 'Kegiatan donasi dan bantuan dari para volunteer',
                'date' => '2024-02-01'
            ],
            [
                'id' => 4,
                'title' => 'Pelantikan Pengurus Organisasi Pelajar LKSA Yatim Muhammadiyah Karangasem',
                'image' => 'https://via.placeholder.com/600x400/8B4513/FFFFFF?text=Pelantikan+Pengurus',
                'description' => 'Acara pelantikan pengurus baru organisasi pelajar',
                'date' => '2024-02-10'
            ],
            [
                'id' => 5,
                'title' => 'Pengajian Oleh Ibu-Ibu Aisyiyah Daerah Lamongan',
                'image' => 'https://via.placeholder.com/600x400/9B59B6/FFFFFF?text=Pengajian+Aisyiyah',
                'description' => 'Kegiatan pengajian rutin oleh ibu-ibu Aisyiyah',
                'date' => '2024-02-15'
            ],
            [
                'id' => 6,
                'title' => 'Bakti Sosial dari Panguyuban Ibu-Ibu Aisyiyah Daerah Lamongan',
                'image' => 'https://via.placeholder.com/600x400/3498DB/FFFFFF?text=Bakti+Sosial',
                'description' => 'Program bakti sosial untuk masyarakat sekitar',
                'date' => '2024-02-25'
            ]
        ];

        return view('kegiatanpage', compact('activities'));
    }
}
