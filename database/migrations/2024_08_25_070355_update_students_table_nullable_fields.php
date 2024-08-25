<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStudentsTableNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('passport_number')->nullable()->change();
            $table->string('visa_status')->nullable()->change();
            $table->text('additional_info')->nullable()->change();
            $table->unsignedBigInteger('current_semester_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('passport_number')->nullable(false)->change();
            $table->string('visa_status')->nullable(false)->change();
            $table->text('additional_info')->nullable(false)->change();
            $table->unsignedBigInteger('current_semester_id')->nullable(false)->change();
        });
    }
}
