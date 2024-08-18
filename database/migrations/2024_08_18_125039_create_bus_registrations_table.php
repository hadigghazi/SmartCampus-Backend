<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::create('bus_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('bus_route_id')->constrained()->onDelete('cascade');
            $table->date('registration_date');
            $table->enum('status', ['Pending', 'Confirmed', 'Canceled'])->default('Pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bus_registrations');
    }
}
