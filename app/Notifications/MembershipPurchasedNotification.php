<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MembershipPurchasedNotification extends Notification
{
    use Queueable;

    protected $package;
    protected $transaction;
    protected $userMembership;

    public function __construct($package, $transaction, $userMembership)
    {
        $this->package = $package;
        $this->transaction = $transaction;
        $this->userMembership = $userMembership;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Đăng ký gói dịch vụ thành công',
            'message' => 'Bạn đã thanh toán thành công gói ' . $this->package->membership->name .
                ' (' . $this->package->duration_days . ' ngày).',
            'amount' => $this->transaction->amount,
            'transaction_code' => $this->transaction->transaction_code,
            'membership_name' => $this->package->membership->name,
            'duration_days' => $this->package->duration_days,
            'start_date' => optional($this->userMembership->start_date)->format('d/m/Y H:i'),
            'end_date' => optional($this->userMembership->end_date)->format('d/m/Y H:i'),
            'url' => route('user.wallet.index'),
        ];
    }
}