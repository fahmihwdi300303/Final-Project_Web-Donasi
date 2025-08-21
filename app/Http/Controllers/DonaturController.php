<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonaturController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:donatur');
    }

    public function dashboard()
{
    $user = auth()->user();

    // contoh dummy data sementara
    $activities = [
        ['id' => 1, 'type' => 'Uang', 'amount' => 100000, 'status' => 'verified', 'date' => now()->subDays(5)],
            ['id' => 2, 'type' => 'Barang', 'description' => 'Buku Pelajaran', 'status' => 'pending', 'date' => now()->subDays(2)],
        ];         
        return view('donatur.dashboard', compact('user', 'activities'));
}
        


    public function donationForm()
    {
        return view('donatur.donation-form');
    }

    public function submitDonation(Request $request)
    {
        $request->validate([
            'type' => 'required|in:uang,barang',
            'amount' => 'required_if:type,uang|numeric|min:1000',
            'description' => 'required_if:type,barang|string|max:500',
            'quantity' => 'required_if:type,barang|numeric|min:1',
        ]);

        // Placeholder for donation submission
        // In real implementation, this would save to database
        
        return redirect()->route('donatur.dashboard')
            ->with('success', 'Donasi berhasil disubmit dan sedang menunggu validasi.');
    }

    public function donationValidation()
    {
        // Placeholder for donation validation page
        $pendingDonations = [
            ['id' => 1, 'donatur' => 'John Doe', 'type' => 'Uang', 'amount' => 100000, 'date' => now()->subDays(1)],
            ['id' => 2, 'donatur' => 'Jane Smith', 'type' => 'Barang', 'description' => 'Buku Pelajaran', 'date' => now()->subDays(2)],
        ];
        
        return view('donatur.donation-validation', compact('pendingDonations'));
    }

    public function validateDonation(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'notes' => 'nullable|string|max:500',
        ]);

        // Placeholder for donation validation
        // In real implementation, this would update database
        
        $status = $request->status === 'verified' ? 'diverifikasi' : 'ditolak';
        
        return redirect()->back()
            ->with('success', "Donasi berhasil {$status}.");
    }

    public function donationReport()
    {
        // Placeholder for donation report
        $reports = [
            ['month' => 'Januari', 'total' => 1500000, 'count' => 15, 'verified' => 12],
            ['month' => 'Februari', 'total' => 2000000, 'count' => 20, 'verified' => 18],
            ['month' => 'Maret', 'total' => 1750000, 'count' => 18, 'verified' => 16],
        ];
        
        return view('donatur.donation-report', compact('reports'));
    }

    public function myDonations()
    {
        $user = auth()->user();
        
        // Placeholder for user's donations
        $donations = [
            ['id' => 1, 'type' => 'Uang', 'amount' => 100000, 'status' => 'verified', 'date' => now()->subDays(5)],
            ['id' => 2, 'type' => 'Barang', 'description' => 'Buku Pelajaran', 'status' => 'pending', 'date' => now()->subDays(2)],
            ['id' => 3, 'type' => 'Uang', 'amount' => 50000, 'status' => 'rejected', 'date' => now()->subDays(10)],
        ];
        
        return view('donatur.my-donations', compact('donations'));
    }
}
