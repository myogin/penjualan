<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal_transaksi');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('supplier_id')->unsigned();
            $table->string('invoice_number');
            $table->integer('total_harga');
            $table->enum('status', ['PROCESS', 'FINISH', 'CANCEL']);
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembelians');
    }
}
