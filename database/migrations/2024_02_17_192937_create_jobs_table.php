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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('location');
            $table->string('job_type');
            $table->string('job_level');
            $table->foreignId('job_category_id')->constrained()->restrictOnDelete();
            $table->string('work_type');
            $table->text('description');
            $table->text('requirements');
            $table->text('responsibilities');
            $table->float('salary');
            $table->string('facilities');
            $table->text('skills');
            $table->date('closing_date');
            $table->string('status');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
