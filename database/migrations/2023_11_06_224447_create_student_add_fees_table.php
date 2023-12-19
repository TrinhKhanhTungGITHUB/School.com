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
        Schema::create('student_add_fees', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('paid_amount')->nullable();
            $table->integer('remaining_amount')->nullable();
            $table->string('payment_type',255)->nullable();
            $table->text('remark')->nullable();
            $table->integer('created_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_add_fees');
    }
};
