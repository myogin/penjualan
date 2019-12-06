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
            $table->increments('id');
            $table->integer('pembelian_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('pembelian_id')->references('id')->on('pembelians');
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
        Schema::dropIfExists('pembelian_product');
    }
}
