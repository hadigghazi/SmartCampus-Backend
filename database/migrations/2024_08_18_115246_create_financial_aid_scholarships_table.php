<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialAidScholarshipsTable extends Migration
{
    public function up()
    {
        Schema::create('financial_aid_scholarships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('type', 100);
            $table->decimal('amount_usd', 10, 2);
            $table->decimal('amount_lbp', 10, 2);
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_aid_scholarships');
    }
}
