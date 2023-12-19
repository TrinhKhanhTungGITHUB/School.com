<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name',255)->nullable();
            $table->string('admission_number',50)->nullable();
            $table->string('roll_number',50)->nullable();
            $table->string('class_id')->nullable();
            $table->string('gender',50)->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('caste',50)->nullable();
            $table->string('religion',50)->nullable();
            $table->string('mobile_number',15)->nullable();
            $table->string('admission_date')->nullable();
            $table->string('profile_pc',100)->nullable();
            $table->string('blood_group',10)->nullable();
            $table->string('height',10)->nullable();
            $table->string('weight',10)->nullable();
            $table->tinyInteger('status')->default(0)->nullable()->comment('0:active, 1:inactive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
