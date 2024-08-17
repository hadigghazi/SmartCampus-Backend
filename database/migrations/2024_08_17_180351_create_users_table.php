<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('middle_name', 50);
            $table->string('last_name', 50);
            $table->string('mother_full_name', 50);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('phone_number', 20);
            $table->enum('role', ['Student', 'Admin', 'Instructor']);
            $table->enum('status', ['Pending', 'Approved', 'Rejected']);
            $table->date('date_of_birth');
            $table->string('nationality', 50);
            $table->string('second_nationality', 50);
            $table->string('country_of_birth', 50);
            $table->enum('gender', ['Male', 'Female']);
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed']);
            $table->string('profile_picture', 255);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
