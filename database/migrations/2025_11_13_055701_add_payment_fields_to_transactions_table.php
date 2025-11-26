<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable()->after('total');
            $table->integer('dibayar')->nullable()->after('metode_pembayaran');
            $table->integer('kembalian')->nullable()->after('dibayar');
            $table->string('catatan')->nullable()->after('kembalian');
        });
    
    
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'catatan']);
        });
    }
};
