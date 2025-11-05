<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('nama_produk');
            $table->foreignId('id_kategori')->constrained('categories');
            $table->integer('stok');
            $table->integer('harga');
            $table->timestamps(); // bikin created_at & updated_at otomatis
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
