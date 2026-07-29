<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('copyright_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained()->cascadeOnDelete();
            $table->foreignId('claimant_id')->constrained('users')->cascadeOnDelete();
            $table->string('claim_type')->default('audio'); // audio, visual, full_content
            $table->text('reason');
            $table->string('copyright_owner_name');
            $table->enum('status', ['pending', 'investigating', 'upheld', 'rejected', 'withdrawn'])->default('pending');
            $table->text('resolution_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('copyright_claims');
    }
};
