<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Ward;
use App\Models\Membership;
use App\Models\Amenity;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::role('landlord')->get();
        $categories = Category::all();
        $wards = Ward::all();
        $adminId = User::role('admin')->first()?->id;
        $amenities = Amenity::all();  // 👈 thêm

        if ($users->isEmpty() || $categories->isEmpty() || $wards->isEmpty()) {
            return;
        }

        $titles = [
            'Phòng trọ giá rẻ gần trung tâm',
            'Phòng full nội thất, dọn vào ở ngay',
            'Phòng trọ sinh viên giá tốt',
            'Cho thuê nhà nguyên căn',
            'Căn hộ mini cao cấp',
        ];

        $plan = [
            1 => 10,  
            
            4 => 50,   
            5 => 100,  
        ];

        foreach ($plan as $membershipId => $count) {
            for ($i = 0; $i < $count; $i++) {
                $title = $titles[array_rand($titles)] . ' #' . rand(1, 9999);
                $start = now()->subDays(rand(0, 10));
                $expires = (clone $start)->addDays(30);

                $post = Post::create([
                    'user_id' => $users->random()->id,
                    'category_id' => $categories->random()->id,
                    'ward_id' => $wards->random()->id,
                    'membership_id' => $membershipId,  // 👈 dùng thẳng id

                    'title' => $title,
                    'slug' => Str::slug($title . '-' . uniqid()),
                    'description' => 'Phòng đẹp, sạch sẽ, an ninh tốt, gần chợ và trường học.',

                    'price' => rand(1_000_000, 5_000_000),
                    'price_unit' => 'month',
                    'area' => rand(15, 40),

                    'address' => 'Long Xuyên, An Giang',
                    'latitude' => 10.38 + rand(0, 1000) / 10000,
                    'longitude' => 105.43 + rand(0, 1000) / 10000,

                    'status' => 'approved',
                    'is_visible_admin' => true,
                    'is_visible_owner' => true,

                    'approved_by' => $adminId,
                    'approved_at' => now(),

                    'view_count' => rand(0, 500),
                    'pushed_at' => now()->subDays(rand(0, 5)),
                    'push_count' => rand(0, 10),

                    'expires_at' => $expires,
                ]);

                if ($amenities->isNotEmpty()) {
                    $randomAmenities = $amenities->random(min(rand(2, 5), $amenities->count()));
                    $post->amenities()->attach($randomAmenities->pluck('id'));
                }
            }

            $this->command->info("✓ Seeded {$count} posts for [membership_id={$membershipId}]");
        }


    }
}