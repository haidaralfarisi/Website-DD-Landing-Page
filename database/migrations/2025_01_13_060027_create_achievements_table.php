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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title'); // Judul
            $table->bigInteger('unit_id')->unsigned(); // ID Unit
            $table->string('image')->nullable(); // Gambar
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status
            $table->date('achievement_date')->nullable(); // Tanggal pencapaian
            $table->timestamps(); // Timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
