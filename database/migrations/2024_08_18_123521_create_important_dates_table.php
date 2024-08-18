<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportantDateTable extends Migration
{
    public function up()
    {
        Schema::create('important_dates', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->date('date');
            $table->date('end_date')->nullable();
            $table->enum('type', ['Deadline', 'Event', 'Holiday', 'Other']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('important_dates');
    }
}
