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
    Schema::create('posts', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->string('title'); // Judul Post
        $table->string('slug')->unique(); // Slug
        $table->string('meta_keyword')->nullable(); // Meta Keyword
        $table->text('meta_description')->nullable(); // Meta Deskripsi
        $table->string('meta_thumbnail')->nullable(); // Meta Thumbnail
        $table->string('image')->nullable(); // Image
        $table->text('description')->nullable(); // Deskripsi
        $table->date('publish_date')->nullable(); // Tanggal Publish
        $table->enum('status', ['active', 'inactive'])->default('active'); // Status
        $table->string('unit')->nullable(); // Unit
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel Users
        $table->timestamps(); // created_at dan updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
