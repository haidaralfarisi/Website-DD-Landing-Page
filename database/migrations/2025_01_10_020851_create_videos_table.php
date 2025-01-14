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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');  // Kolom untuk judul video
            $table->bigInteger('unit_id')->unsigned(); // ID Unit
            $table->string('image')->nullable();  // Kolom untuk menyimpan nama file gambar, nullable jika tidak ada gambar
            $table->enum('status', ['Active', 'Inactive'])->default('Inactive');  // Kolom status, bisa aktif atau nonaktif
            $table->string('url');  // Kolom untuk URL video
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
