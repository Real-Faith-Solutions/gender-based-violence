<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAccountUsersActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_account_users_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('subject_user_account_email')->nullable();
            $table->string('subject_user_account_username')->nullable();
            $table->string('subject_user_account_last_name')->nullable();
            $table->string('subject_user_account_first_name')->nullable();
            $table->string('subject_user_account_middle_name')->nullable();
            $table->string('accountable_user_activity')->nullable();
            $table->string('accountable_user_email')->nullable();
            $table->string('accountable_user_username')->nullable();
            $table->string('accountable_user_last_name')->nullable();
            $table->string('accountable_user_first_name')->nullable();
            $table->string('accountable_user_middle_name')->nullable();
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
        Schema::dropIfExists('users_account_users_activity_logs');
    }
}
