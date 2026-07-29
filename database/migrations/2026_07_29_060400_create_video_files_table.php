<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('video_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->cascadeOnDelete();
            $table->string('file_path');
            $table->enum('file_type', ['original', 'thumbnail', 'processed']);
            $table->string('mime_type')->nullable();
            $table->bigInteger('size')->default(0);
            $table->string('resolution')->nullable();
            $table->decimal('duration', 10, 2)->nullable();
            $table->boolean('is_processed')->default(false);
            $table->enum('processing_status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_files');
    }
};
