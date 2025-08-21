<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Campaign extends Model
{
    protected $fillable = [
        'title','description','image','target','collected',
        // tambah kolom lain jika ada (status, slug, dsb)
    ];
}
// database/migrations/2025_01_01_000000_create_campaigns_table.php


return new class extends Migration {
    public function up(): void {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // simpan nama file di storage
            $table->unsignedBigInteger('target')->default(0);
            $table->unsignedBigInteger('collected')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('campaigns');
    }
};
