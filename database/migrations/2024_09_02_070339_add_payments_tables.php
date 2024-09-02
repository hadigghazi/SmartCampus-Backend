<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('fees');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('financial_aid_scholarships');

        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('exchange_rate', 10, 4); 
            $table->decimal('lbp_percentage', 5, 2);
            $table->decimal('registration_fee_usd', 10, 2); 
            $table->date('effective_date'); 
            $table->timestamps(); 
            $table->softDeletes();
        });

        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->text('description');
            $table->decimal('amount_usd', 10, 2);
            $table->decimal('amount_lbp', 10, 2);
            $table->timestamps(); 
            $table->softDeletes(); 
        });

        Schema::create('payments_usd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->text('description');
            $table->decimal('amount_paid', 10, 2);
            $table->date('payment_date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('payments_lbp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->text('description');
            $table->decimal('amount_paid', 10, 2);
            $table->date('payment_date');
            $table->timestamps();
            $table->softDeletes(); 
        });

        Schema::create('financial_aid_scholarships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('type', 100);
            $table->decimal('percentage', 5, 2); 
            $table->text('description');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
