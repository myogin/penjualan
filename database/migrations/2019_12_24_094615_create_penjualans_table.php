<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal_transaksi');
            $table->integer('customer_id')->unsigned();
            $table->string('invoice_number');
            $table->integer('total_harga');
            $table->integer('shipping')->nullable();;
            $table->integer('profit');
            $table->enum('status', ['PROCESS', 'FINISH', 'CANCEL']);

            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('updated_by')->nullable();

            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}
