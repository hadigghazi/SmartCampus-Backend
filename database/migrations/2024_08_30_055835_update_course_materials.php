<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('course_materials', function (Blueprint $table) {
            // Drop the foreign key constraint and then the course_id column
            $table->dropForeign(['course_id']);
            $table->dropColumn('course_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_materials', function (Blueprint $table) {
 
        });
    }
};
