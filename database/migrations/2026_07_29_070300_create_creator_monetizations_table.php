<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creator_monetizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->enum('status', ['ineligible', 'eligible', 'pending_approval', 'approved', 'suspended'])->default('ineligible');
            $table->decimal('ad_revenue_share_percentage', 5, 2)->default(55.00); // 55% creator share default
            $table->decimal('total_earnings', 12, 2)->default(0.00);
            $table->decimal('pending_payout', 12, 2)->default(0.00);
            $table->string('payout_method')->nullable(); // bank_transfer, paypal, upi
            $table->text('payout_details')->nullable();
            $table->timestamp('applied_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creator_monetizations');
    }
};
