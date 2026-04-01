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
        Schema::create('system_wallet_notifications', function (Blueprint $table) {
            $table->id();

            // Ví hệ thống nhận tiền
            $table->foreignId('system_wallet_id')
                ->nullable()
                ->constrained('system_wallets')
                ->nullOnDelete();

            // Có thể khớp với giao dịch nạp của user
            $table->foreignId('wallet_transaction_id')
                ->nullable()
                ->constrained('wallet_transactions')
                ->nullOnDelete();

            // Thông tin người gửi / giao dịch nhận được
            $table->string('sender_name')->nullable();
            $table->string('sender_account_number')->nullable();
            $table->string('receiver_account_number')->nullable();
            $table->string('bank_name')->nullable();

            // Nội dung biến động số dư
            $table->bigInteger('amount');
            $table->string('transfer_content')->nullable();
            $table->text('raw_message')->nullable();

            // Trạng thái đối soát
            $table->enum('match_status', [
                'unmatched',   // chưa khớp giao dịch nào
                'matched',     // đã khớp giao dịch user
                'approved',    // admin đã duyệt
                'rejected',    // admin đã từ chối
            ])->default('unmatched');

            // admin xử lý
            $table->foreignId('handled_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('notified_at')->nullable();
            $table->timestamp('handled_at')->nullable();

            $table->text('admin_note')->nullable();

            $table->timestamps();

            $table->index(['amount', 'match_status']);
            $table->index(['transfer_content']);
            $table->index(['notified_at']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_wallet_notifications');
    }
};
