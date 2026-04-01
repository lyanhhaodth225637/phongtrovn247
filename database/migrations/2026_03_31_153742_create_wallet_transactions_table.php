<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('transaction_code', 50)->unique();
            $table->string('payment_code', 50)->nullable()->unique();

            $table->enum('type', [
                'deposit',
                'buy_membership',
                'renew_membership',
                'push_post',
                'refund',
                'admin_adjust',
                'promotion',
            ]);

            $table->bigInteger('amount');
            $table->bigInteger('balance_before')->default(0);
            $table->bigInteger('balance_after')->default(0);

            $table->enum('payment_gateway', [
                'vnpay',
                'bank_transfer',
                'momo',
                'zalopay',
                'manual'
            ])->nullable();

            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('transfer_content')->nullable();

            $table->enum('status', [
                'pending',
                'processing',
                'success',
                'failed',
                'cancelled',
            ])->default('pending');

            $table->string('description')->nullable();

            // sửa chỗ này
            $table->nullableMorphs('transactionable', 'wt_trxable_idx');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('requested_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->text('admin_note')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'type']);
            $table->index(['user_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
