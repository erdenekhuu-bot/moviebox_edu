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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->mediumText('title');
            $table->mediumText('description')->nullable();
            $table->integer('rating')->default(1);
            $table->string('original_file_path');
            $table->string('hls_path');
            $table->string('thumbnail_path')->nullable();
            $table->integer('duration')->default(0);
            $table->string('status')->default('pending');
            $table->json('qualities')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
