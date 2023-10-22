<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('full_name',40);
            $table->string('city',15);
            $table->string('address');
            $table->char('tel',10);
            $table->char('mobile',10);
            $table->decimal('cart_cost', $precision = 7, $scale = 2);
            $table->decimal('delivery_charges', $precision = 7, $scale = 2);
            $table->string('order_notes');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('orders');
    }
};
