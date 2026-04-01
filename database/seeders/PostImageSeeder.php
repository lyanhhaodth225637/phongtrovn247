<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\PostImage;

class PostImageSeeder extends Seeder
{
    /**
     * Unsplash source — không cần API key, trả về ảnh ngẫu nhiên theo keyword.
     * Format: https://source.unsplash.com/featured/{width}x{height}/?{keyword}
     */
    private array $keywords = [
        'room,apartment',
        'bedroom,interior',
        'studio,apartment',
        'living,room',
        'rental,room',
    ];

    public function run(): void
    {
        $posts = Post::all();

        if ($posts->isEmpty()) {
            $this->command->warn('Không có post nào. Chạy PostSeeder trước.');
            return;
        }

        // Đảm bảo thư mục tồn tại
        Storage::disk('public')->makeDirectory('posts');

        foreach ($posts as $post) {
            $imageCount = rand(3, 6); // mỗi post 3–6 ảnh

            for ($i = 0; $i < $imageCount; $i++) {
                $keyword = $this->keywords[array_rand($this->keywords)];
                $width = 800;
                $height = 600;
                $url = "https://source.unsplash.com/featured/{$width}x{$height}/?{$keyword}&sig=" . uniqid();

                $path = $this->downloadImage($url, $post->id, $i);

                if (!$path) {
                    $this->command->warn("  ✗ Bỏ qua ảnh #{$i} cho post [{$post->id}]");
                    continue;
                }

                PostImage::create([
                    'post_id' => $post->id,
                    'image' => $path,
                    'sort_order' => $i,
                    'is_thumbnail' => $i === 0, // ảnh đầu tiên làm thumbnail
                ]);
            }

            $this->command->info("✓ Post [{$post->id}] — đã thêm {$imageCount} ảnh");
        }
    }

    private function downloadImage(string $url, int $postId, int $index): ?string
    {
        try {
            $response = Http::timeout(15)
                ->withOptions(['allow_redirects' => true]) // Unsplash redirect về CDN
                ->get($url);

            if (!$response->successful()) {
                return null;
            }

            $filename = "posts/{$postId}_{$index}_" . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $response->body());

            return $filename;

        } catch (\Throwable $e) {
            $this->command->error("  Download lỗi: " . $e->getMessage());
            return null;
        }
    }
}