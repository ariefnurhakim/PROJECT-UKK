<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            // Hapus foreign key lama
            $table->dropForeign(['product_id']);

            // Buat foreign key baru yang tidak menghapus transaction_items
            $table->foreign('product_id')
                  ->references('id_produk')->on('produk')
                  ->nullOnDelete();  // INI FIX-NYA
        });
    }

    public function down(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            // Balik ke cascade kalau revert migration
            $table->dropForeign(['product_id']);

            $table->foreign('product_id')
                  ->references('id_produk')->on('produk')
                  ->onDelete('cascade');
        });
    }
};
