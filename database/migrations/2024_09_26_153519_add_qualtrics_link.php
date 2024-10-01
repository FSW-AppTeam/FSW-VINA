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
        Schema::table('surveys', function (Blueprint $table) {
            $table->after('survey_code', function ($table) {
                $table->string('qualtrics_id')->nullable();
                $table->string('qualtrics_param')->nullable();
                $table->string('qualtrics_name')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('qualtrics_id');
            $table->dropColumn('qualtrics_param');
            $table->dropColumn('qualtrics_name');
        });
    }
};
