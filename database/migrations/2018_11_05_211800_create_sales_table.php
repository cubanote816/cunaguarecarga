<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
          $table->increments('id');
          $table->string('ref');
          $table->integer('type');
          $table->string('phone');
          $table->decimal('cost','13','4');
          $table->enum('status', ['complete', 'pending', 'deny'])->default('pending');
          $table->boolean('paid')->default(false);
          $table->integer('sold_by')->unsigned();
          $table->foreign('sold_by')->references('id')->on('users');
          $table->integer('hired_by')->unsigned()->nullable();
          $table->foreign('hired_by')->references('id')->on('users');
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
