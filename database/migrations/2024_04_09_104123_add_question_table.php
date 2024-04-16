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
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('order');
            $table->boolean('enabled')->default(true);
            $table->string('form_type')->nullable();
            $table->string('question_type');
            $table->string('question_title');
            $table->string('question_content');
            $table->json('question_answer_options')->nullable();
            $table->json('question_options')->nullable();

            $table->boolean('default_disable_next')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
