<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('transaction_items', function (Blueprint $table) {
        $table->string('product_name')->nullable();
        $table->decimal('product_price', 12, 2)->nullable();
    });
}

public function down()
{
    Schema::table('transaction_items', function (Blueprint $table) {
        $table->dropColumn(['product_name', 'product_price']);
    });
}

};
