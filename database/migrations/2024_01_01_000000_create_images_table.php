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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('filename'); // Nama file yang disimpan di storage
            $table->string('original_name'); // Nama asli file yang diupload
            $table->string('path'); // Path relatif di storage
            $table->bigInteger('size'); // Ukuran file dalam bytes
            $table->string('mime_type'); // Tipe MIME file
            $table->text('description')->nullable(); // Deskripsi gambar (opsional)
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null'); // User yang upload
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index('uploaded_by');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
