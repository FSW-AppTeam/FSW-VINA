<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_students', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->dateTime('exported_at')->nullable();
            $table->unique(['name', 'survey_id']);
            $table->foreignId('survey_id')->constrained('surveys');
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
        Schema::dropIfExists('survey_students');
    }
};
