<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // tên gói (Free, VIP, Pro)
            $table->string('slug')->unique();
            $table->decimal('price', 10, 2)->default(0); // giá
            $table->integer('duration'); // số ngày (30, 60...)
            $table->integer('priority')->default(0);
            // độ ưu tiên (hiển thị cao hơn)
            $table->integer('max_posts')->default(1);
            // số bài được đăng
            $table->boolean('is_featured')->default(false);
            // có nổi bật không
            $table->enum('status', ['active', 'inactive'])
                ->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
