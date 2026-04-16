<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
      
        $roles = ['admin', 'landlord', 'user'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

     
        $admin = User::updateOrCreate(
            ['email' => 'hao@gmail.com'],
            [
                'name' => 'Anh Hào',
                'slug' => Str::slug('Anh Hào'),
                'phone' => '0855657770',
                'password' => Hash::make('12345678'),
            ]
        );

        $admin->syncRoles(['admin']);

       
        $fakeUsers = [
            ['name' => 'Nguyễn Văn A', 'email' => 'a@gmail.com', 'role' => 'landlord'],
            ['name' => 'Trần Thị B', 'email' => 'b@gmail.com', 'role' => 'landlord'],
            ['name' => 'Lê Văn C', 'email' => 'c@gmail.com', 'role' => 'landlord'],
            ['name' => 'Phạm Thị D', 'email' => 'd@gmail.com', 'role' => 'landlord'],
            ['name' => 'Hoàng Văn E', 'email' => 'e@gmail.com', 'role' => 'landlord'],
        ];

        foreach ($fakeUsers as $item) {
            $user = User::updateOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'phone' => '09' . rand(10000000, 99999999),
                    'password' => Hash::make('12345678'),
                ]
            );

            $user->syncRoles([$item['role']]);
        }
    }
}