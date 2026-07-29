<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brand_collaborations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            $table->string('brand_name');
            $table->string('campaign_title');
            $table->text('campaign_details')->nullable();
            $table->decimal('compensation', 10, 2)->default(0.00);
            $table->enum('status', ['proposed', 'accepted', 'in_progress', 'completed', 'cancelled'])->default('proposed');
            $table->timestamp('deadline_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brand_collaborations');
    }
};
