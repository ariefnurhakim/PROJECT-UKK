<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {

            if (!Schema::hasColumn('transactions', 'metode_pembayaran')) {
                $table->string('metode_pembayaran')->nullable()->after('kembalian');
            }

            if (!Schema::hasColumn('transactions', 'catatan')) {
                $table->string('catatan')->nullable()->after('metode_pembayaran');
            }
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {

            if (Schema::hasColumn('transactions', 'metode_pembayaran')) {
                $table->dropColumn('metode_pembayaran');
            }

            if (Schema::hasColumn('transactions', 'catatan')) {
                $table->dropColumn('catatan');
            }
        });
    }
};
