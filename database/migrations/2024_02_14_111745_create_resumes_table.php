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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('alt_email')->unique();
            $table->string('phone')->unique();
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('dob');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('nationality');
            $table->string('religion');
            $table->string('present_address');
            $table->string('permanent_address');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
