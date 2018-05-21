<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('deliver_id')->unsigned()->nullable();
            $table->enum('status', ['processing', 'cancelled', 'delivered', 'completed'])->default('processing');
            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_phone');
            $table->dateTime('delivery_time');
            $table->float('shipping_fee');
            $table->enum('payment_method', ['cash on delivery', 'bank transfers', 'credit cards', 'e-wallet']);
            $table->float('subtotal');
            $table->float('total');
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
}
