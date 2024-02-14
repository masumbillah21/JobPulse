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
        Schema::create('resume_references', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->constrained();
            $table->string('name');
            $table->string('organization');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('relationship');
            $table->unique(['resume_id', 'phone']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_references');
    }
};
