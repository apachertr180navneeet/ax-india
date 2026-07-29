<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spam_detection_logs', function (Blueprint $table) {
            $table->id();
            $table->string('target_type'); // video, comment
            $table->unsignedBigInteger('target_id');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('spam_score', 5, 2)->default(0.00); // 0.00 to 100.00%
            $table->json('detected_flags')->nullable(); // e.g. ["excessive_links", "profanity", "bot_behavior"]
            $table->enum('action_taken', ['none', 'flagged', 'hidden', 'blocked'])->default('none');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spam_detection_logs');
    }
};
