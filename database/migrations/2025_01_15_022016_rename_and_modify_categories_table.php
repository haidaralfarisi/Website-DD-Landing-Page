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
        // Rename tabel 'categories' menjadi 'post_categories'
        Schema::rename('categories', 'post_categories');

        // Tambahkan kolom 'unit_id' di tabel yang baru di-rename
        // Schema::table('post_categories', function (Blueprint $table) {
        //     $table->unsignedBigInteger('unit_id')->after('name');  // Tambahkan kolom 'unit_id'
        // });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan nama tabel ke 'categories'
        Schema::rename('post_categories', 'categories');

        // Hapus kolom 'unit_id' saat rollback
        // Schema::table('categories', function (Blueprint $table) {
        //     $table->dropColumn('unit_id');
        // });
    }
};