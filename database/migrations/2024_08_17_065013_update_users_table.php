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
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->string('mother_full_name', 50)->nullable();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('phone_number', 20)->nullable();
            $table->enum('role', ['Student', 'Admin', 'Instructor']);
            $table->enum('status', ['Pending', 'Approved', 'Rejected']);
            $table->date('date_of_birth')->nullable();
            $table->string('nationality', 50)->nullable();
            $table->string('second_nationality', 50)->nullable();
            $table->string('country_of_birth', 50)->nullable();
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed'])->nullable();
            $table->string('profile_picture', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
