<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class CampaignController extends Controller
{
    public function index()
    {
        // ambil semua campaign (urut terbaru)
        $campaigns = Campaign::query()->latest()->get();

        // sesuaikan dengan nama file view kamu: 'donasipage' atau 'donasi'
        return view('donasipage', compact('campaigns'));
    }
}
