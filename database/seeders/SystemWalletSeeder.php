<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemWallet;

class SystemWalletSeeder extends Seeder
{
    public function run(): void
    {
        // reset ví cũ về không hoạt động
        // SystemWallet::query()->update([
        //     'is_active' => false,
        // ]);

        SystemWallet::create([
            'name' => 'Ví Hệ Thống',
            'bank_name' => 'Fake Bank',
            'account_name' => 'PHONGTROVN247',
            'account_number' => '1472583690',
            'is_active' => true,
        ]);
    }
}