<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualanProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('penjualan_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('penjualan_id')->references('id')->on('penjualans');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan_product');
    }
}
