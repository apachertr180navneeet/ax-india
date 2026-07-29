<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->boolean('is_short')->default(false)->after('visibility');
            $table->boolean('is_live')->default(false)->after('is_short');
            $table->string('stream_key')->nullable()->unique()->after('is_live');
            $table->enum('live_status', ['offline', 'starting', 'live', 'ended'])->default('offline')->after('stream_key');
            $table->decimal('earnings', 10, 2)->default(0.00)->after('comments_count');
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['is_short', 'is_live', 'stream_key', 'live_status', 'earnings']);
        });
    }
};
