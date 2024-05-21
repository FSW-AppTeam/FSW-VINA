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
//        DB::table('survey_questions')->whereIn('id', [7, 9])->update(['question_type' => 'json']);
        DB::table('survey_answers')->whereIn('question_id', [7, 9])
            ->where('created_at', '>=', '2024-04-25' )->update(['question_type' => 'json']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('survey_questions')->whereIn('id', [7, 9])->update(['question_type' => 'int']);
        DB::table('survey_answers')->whereIn('question_id', [7, 9])
            ->where('created_at', '>=', '2024-04-25' )->update(['question_type' => 'int']);
    }
};
