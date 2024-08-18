<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatefeesTable extends Migration
{
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->decimal('amount_usd', 10, 2);
            $table->decimal('amount_lbp', 10, 2);
            $table->decimal('exchange_rate', 10, 4);
            $table->unsignedBigInteger('faculty_id');
            $table->decimal('credit_price_usd', 10, 2);
            $table->decimal('credit_price_lbp', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fees');
    }
}
