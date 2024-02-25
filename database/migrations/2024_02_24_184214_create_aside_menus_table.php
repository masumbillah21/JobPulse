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
        Schema::create('aside_menus', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('route')->nullable();
            $table->string('icon');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('aside_menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aside_menus');
    }
};
