<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembelianProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_product', function (Blueprint $table) {
            $table->integer('pembelian_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('qty');
            $table->integer('harga_beli');
            $table->timestamps();

            $table->primary(['pembelian_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelian_product');
    }
}
