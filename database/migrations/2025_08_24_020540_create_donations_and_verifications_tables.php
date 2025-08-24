<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the donations table based on the ERD
        Schema::create('donations', function (Blueprint $table) {
            $table->id('donation_id');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('jumlah', 15, 2);
            $table->string('metode_pembayaran');
            $table->string('bukti_transfer')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
        });

        // Create the donation_verifications table (renamed from 'Verification' for clarity)
        Schema::create('donation_verifications', function (Blueprint $table) {
            $table->id('verification_id');
            $table->foreignId('donasi_id')->constrained('donations', 'donation_id')->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['verified', 'rejected']);
            $table->text('catatan')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_verifications');
        Schema::dropIfExists('donations');
    }
};
