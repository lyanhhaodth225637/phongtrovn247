<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_moderations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->enum('action', ['approved', 'rejected']);
            $table->enum('reason_type', ['spam', 'scam', 'false_info', 'duplicate', 'other'])->nullable();
            $table->text('reason_detail')->nullable();
            $table->boolean('is_view')->default(false);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_moderations');
    }
};
