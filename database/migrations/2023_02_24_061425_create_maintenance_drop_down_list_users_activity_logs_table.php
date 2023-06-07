<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceDropDownListUsersActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_drop_down_list_users_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('subject_category_name')->nullable();
            $table->string('subject_item_name')->nullable();
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
        Schema::dropIfExists('maintenance_drop_down_list_users_activity_logs');
    }
}
