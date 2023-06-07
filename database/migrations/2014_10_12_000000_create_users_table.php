<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_last_name');
            $table->string('user_first_name');
            $table->string('user_middle_name');
            $table->string('user_contact_no');
            $table->string('email')->unique();
            $table->string('user_employee_id');
            $table->string('username')->unique();
            $table->string('role');
            $table->string('user_service_provider')->nullable();
            $table->string('password');
            $table->string('is_active')->nullable();
            $table->text('user_region');
            $table->text('user_province');
            $table->text('user_municipality');
            $table->text('user_barangay');            
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
