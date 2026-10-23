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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('cover');
            $table->string('title');
            $table->integer('price');
            $table->text('description')->nullable();
            $table->string('language');
            $table->string('publisher');
            $table->string('writer');
            $table->date('release_date');
            $table->integer('page_of_book');
            //ForeignId: membuat kolom book_category_id sebagai foreign key yang mengacu pada kolom id di tabel book_categories.
            //constrained('book_categories') digunakan untuk menentukan tabel yang menjadi referensi.
            //dan onDelete('cascade') digunakan untuk menghapus data buku jika kategori buku terkait di hapus.
            $table->foreignId('category_id')->constrained('book_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
