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
            $table->decimal('payout_threshold', 10, 2)->default(100.00); // Minimum payout threshold e.g. $100 or ₹1000
            $table->decimal('tax_deduction_rate', 5, 2)->default(10.00); // e.g. 10% TDS / withholding tax
            $table->string('payout_method')->default('bank_transfer'); // bank_transfer, upi, paypal
            $table->text('payout_details')->nullable(); // Account number, IFSC/SWIFT, Bank Name, PAN/Tax ID
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
