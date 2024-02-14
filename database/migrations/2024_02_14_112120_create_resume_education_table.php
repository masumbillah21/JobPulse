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
        Schema::create('resume_education', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained();
            $table->string('degree');
            $table->string('institute');
            $table->string('board_university');
            $table->date('passing_year')->nullable();
            $table->boolean('in_progress')->default(0);
            $table->enum('result_type', ['grade', 'division'])->nullable();
            $table->string('division')->nullable();
            $table->string('grade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_education');
    }
};
