<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monetization_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('video_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['ad_revenue', 'video_share', 'performance_bonus', 'brand_collaboration', 'premium_content', 'live_gift', 'fan_subscription']);
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('description')->nullable();
            $table->enum('status', ['pending', 'credited', 'paid_out'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monetization_earnings');
    }
};
