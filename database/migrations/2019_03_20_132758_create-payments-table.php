<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mollie_id');
            $table->decimal('amount', 10, 2);
            $table->string('currency');
            $table->string('status');
            $table->mediumText('description');
            $table->string('payment_url');
            $table->string('banking_number');
            $table->string('name');
            $table->string('email_address');
            $table->datetime('paid_at')->nullable();
            $table->integer('user_id');
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
        //
    }
}
