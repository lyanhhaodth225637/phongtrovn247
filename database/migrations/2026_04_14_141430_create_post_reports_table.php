<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();

            $table->enum('reason_type', [
                'spam',
                'scam',
                'false_info',
                'duplicate',
                'inappropriate',
                'wrong_price',
                'other',
            ]);

            $table->text('reason_detail')->nullable();

            $table->enum('status', ['pending', 'resolved', 'rejected'])->default('pending');

            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('handled_at')->nullable();
            $table->text('admin_note')->nullable();

            $table->timestamps();

            $table->index(['post_id', 'status']);
            $table->index(['reporter_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_reports');
    }
};