<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceDirectoriesUsersActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_directories_users_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('subject_dir_first_name')->nullable();
            $table->string('subject_dir_middle_name')->nullable();
            $table->string('subject_dir_last_name')->nullable();
            $table->string('subject_dir_post_desi')->nullable();
            $table->string('subject_dir_directory_type')->nullable();
            $table->string('subject_dir_contact_no_1')->nullable();
            $table->string('subject_dir_contact_no_2')->nullable();
            $table->string('subject_dir_contact_no_3')->nullable();
            $table->string('subject_dir_email')->nullable();
            $table->string('subject_dir_facebook')->nullable();
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
        Schema::dropIfExists('maintenance_directories_users_activity_logs');
    }
}
