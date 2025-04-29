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
        Schema::create('survey_student_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_student_id')->constrained('survey_students')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('survey_question_id')->constrained('survey_questions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('selected_option'); // this is the selected radio button value
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_student_answers');
    }
};
