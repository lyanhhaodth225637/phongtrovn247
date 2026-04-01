<?php

namespace App\Services;

class VnpayService
{
    public function createPaymentUrl(array $data): string
    {
        $vnp_Url = config('services.vnpay.url');
        $vnp_HashSecret = config('services.vnpay.hash_secret');

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_Command" => "pay",
            "vnp_TmnCode" => config('services.vnpay.tmn_code'),
            "vnp_Amount" => $data['amount'] * 100,
            "vnp_CurrCode" => "VND",
            "vnp_TxnRef" => $data['txn_ref'],
            "vnp_OrderInfo" => $data['order_info'],
            "vnp_OrderType" => "other",
            "vnp_Locale" => "vn",
            "vnp_ReturnUrl" => config('services.vnpay.return_url'),
            "vnp_IpAddr" => $data['ip'],
            "vnp_CreateDate" => now()->format('YmdHis'),
        ];

        ksort($inputData);

        $query = "";
        $hashdata = "";

        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }

            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        return $vnp_Url . "?" . $query . 'vnp_SecureHash=' . $vnpSecureHash;
    }
    public function validateReturn(array $input): bool
    {
        $vnpSecureHash = $input['vnp_SecureHash'] ?? null;

        if (!$vnpSecureHash) {
            return false;
        }

        unset($input['vnp_SecureHash'], $input['vnp_SecureHashType']);

        ksort($input);

        $hashdata = '';
        $i = 0;

        foreach ($input as $key => $value) {
            if ($value === '' || $value === null) {
                continue;
            }

            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashdata, config('services.vnpay.hash_secret'));

        return hash_equals($secureHash, $vnpSecureHash);
    }
}