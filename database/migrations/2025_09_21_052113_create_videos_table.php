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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('original_video');
            $table->string('hls_output');
            $table->string('conversion_percent');
            $table->string('videos');
            $table->string('hls-outputs');
            $table->string('secure');
            $table->string('streamed/hls');
            $table->string('streamed/secrets');
            $table->string('tmp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
