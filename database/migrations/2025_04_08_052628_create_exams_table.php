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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('exam_name');
            $table->unsignedBigInteger('class_id'); // Foreign key to Classes table
            $table->unsignedBigInteger('subject_id')->nullable(); // Foreign key to Subjects table (optional)
            $table->date('exam_date');
            $table->integer('duration')->nullable();
            $table->text('description')->nullable();
            $table->string('exam_type_code'); // Foreign key to exam_types table
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('subject_id')->references('id')->on('subjects');
            $table->foreign('exam_type_code')->references('exam_type_code')->on('exam_types'); // Link to exam_types table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
