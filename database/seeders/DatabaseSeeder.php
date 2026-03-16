<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        //tạo 3 role 
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'landlord']);
        Role::create(['name' => 'user']);

        //khởi tạo user admin
        $name = 'Anh Hào';
        $user = User::factory()->create([
            'name' => $name,
            'slug' => Str::slug($name),
            'email' => 'hao@gmail.com',
            'phone' => '0855657770',
            'password' => Hash::make('12345678'),
        ]);

        //Gán role admin
        $user->assignRole('admin');

        $this->call([
            CategorySeeder::class,
            ProvinceSeeder::class,
            WardSeeder::class,
            LocationSeeder::class,
        ]);
    }
}
