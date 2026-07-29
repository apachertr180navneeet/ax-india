<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('thumbnail')->nullable();
            $table->decimal('duration', 10, 2)->nullable();
            $table->string('file_path');
            $table->bigInteger('file_size')->default(0);
            $table->string('mime_type')->nullable();
            $table->string('extension')->nullable();
            $table->string('resolution')->nullable();
            $table->enum('visibility', ['public', 'unlisted', 'private', 'scheduled'])->default('public');
            $table->boolean('is_published')->default(false);
            $table->timestamp('scheduled_at')->nullable();
            $table->boolean('allow_downloads')->default(true);
            $table->bigInteger('views_count')->default(0);
            $table->bigInteger('likes_count')->default(0);
            $table->bigInteger('dislikes_count')->default(0);
            $table->bigInteger('comments_count')->default(0);
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejected_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
