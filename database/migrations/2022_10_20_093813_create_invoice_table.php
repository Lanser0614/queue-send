<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('attempt');
            $table->dateTime('changed_time');
            $table->date('date');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('last_attempt')->nullable();
            $table->string('status');
            $table->integer('tariff');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('phone');
            $table->float('price');
            $table->string('uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
