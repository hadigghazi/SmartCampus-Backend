<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add columns if they don't already exist
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name', 50)->nullable()->after('id');
            }

            if (!Schema::hasColumn('users', 'middle_name')) {
                $table->string('middle_name', 50)->nullable()->after('first_name');
            }

            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name', 50)->nullable()->after('middle_name');
            }

            if (!Schema::hasColumn('users', 'mother_full_name')) {
                $table->string('mother_full_name', 50)->nullable()->after('last_name');
            }

            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email', 100)->unique()->after('mother_full_name');
            }

            if (!Schema::hasColumn('users', 'password')) {
                $table->string('password')->after('email');
            }

            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number', 20)->nullable()->after('password');
            }

            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['Student', 'Admin', 'Instructor'])->after('phone_number');
            }

            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['Pending', 'Approved', 'Rejected'])->after('role');
            }

            if (!Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('status');
            }

            if (!Schema::hasColumn('users', 'nationality')) {
                $table->string('nationality', 50)->nullable()->after('date_of_birth');
            }

            if (!Schema::hasColumn('users', 'second_nationality')) {
                $table->string('second_nationality', 50)->nullable()->after('nationality');
            }

            if (!Schema::hasColumn('users', 'country_of_birth')) {
                $table->string('country_of_birth', 50)->nullable()->after('second_nationality');
            }

            if (!Schema::hasColumn('users', 'gender')) {
                $table->enum('gender', ['Male', 'Female'])->nullable()->after('country_of_birth');
            }

            if (!Schema::hasColumn('users', 'marital_status')) {
                $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed'])->nullable()->after('gender');
            }

            if (!Schema::hasColumn('users', 'profile_picture')) {
                $table->string('profile_picture', 255)->nullable()->after('marital_status');
            }

            if (!Schema::hasColumn('users', 'created_at')) {
                $table->timestamps();
            }

            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'middle_name',
                'last_name',
                'mother_full_name',
                'email',
                'password',
                'phone_number',
                'role',
                'status',
                'date_of_birth',
                'nationality',
                'second_nationality',
                'country_of_birth',
                'gender',
                'marital_status',
                'profile_picture',
            ]);
        });
    }
}
