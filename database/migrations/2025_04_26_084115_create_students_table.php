<?php

use App\Enums\GenderType;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nationality_id')->constrained('nationalities')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('student_number')->unique();
            $table->string('qr_code');
            $table->string('name');
            $table->tinyInteger('gender')->unsigned()->default(GenderType::Male);
            $table->date('date_from');
            $table->date('date_to');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
