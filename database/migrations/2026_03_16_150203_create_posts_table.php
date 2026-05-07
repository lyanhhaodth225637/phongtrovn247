<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {

            $table->id();
            // Chủ phòng
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Loại phòng
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            // Khu vực
            $table->foreignId('ward_id')->constrained();
            // Gói tin
            $table->foreignId('membership_id')->nullable()->constrained()->nullOnDelete();
            // Nội dung
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            // Giá & diện tích
            $table->decimal('price', 10, 2);
            $table->enum('price_unit', ['month', 'day'])->default('month');
            $table->integer('area');
            // Địa chỉ
            $table->string('address');
            // Bản đồ
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Trạng thái duyệt
            $table->enum('status', ['pending', 'approved', 'rejected', 'expired'])->default('pending');
            // Ẩn / hiện
            $table->boolean('is_visible_admin')->default(true);
            $table->boolean('is_visible_owner')->default(true);
            // lý do từ chối
            $table->text('admin_note')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            // Thống kê
            $table->integer('view_count')->default(0);
            $table->timestamp('pushed_at')->nullable();
            $table->integer('push_count')->default(0);
            // Hết hạn tin
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
    // public function savedByUsers()
    // {
    //     return $this->belongsToMany(User::class, 'saved_posts', 'post_id', 'user_id')
    //         ->withTimestamps();
    // }
};
