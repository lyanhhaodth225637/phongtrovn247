<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewController extends Controller
{
    private const ITEMS_PER_FEED = 20;
    private const ITEMS_PER_PAGE = 20;

    private const FEEDS = [
        'VnExpress' => 'https://vnexpress.net/rss/tin-moi-nhat.rss',
        'VnExpress ND' => 'https://vnexpress.net/rss/nha-dat.rss',
        'Tuoi Tre' => 'https://tuoitre.vn/rss/tin-moi-nhat.rss',
        'Tuoi Tre KD' => 'https://tuoitre.vn/rss/kinh-doanh.rss',
        'Thanh Nien' => 'https://thanhnien.vn/rss/home.rss',
    ];

    public function index()
    {
        $articles = Cache::remember('frontend_news_v3', 600, function () {
            $articles = collect();

            foreach (self::FEEDS as $source => $url) {
                try {
                    $response = Http::timeout(7)
                        ->withHeaders([
                            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                            'Accept' => 'application/rss+xml, text/xml, */*',
                            'Accept-Language' => 'vi-VN,vi;q=0.9',
                            'Referer' => 'https://www.google.com/',
                        ])
                        ->get($url);

                    if ($response->successful()) {
                        $parsed = $this->parseFeed($response->body(), $source);
                        $articles = $articles->merge($parsed);
                        Log::info("RSS OK: {$source} -> " . $parsed->count() . ' bai');
                    } else {
                        Log::warning("RSS FAIL: {$source} -> Status " . $response->status());
                    }
                } catch (\Throwable $e) {
                    Log::error("RSS ERROR: {$source} -> " . $e->getMessage());
                }
            }

            return $articles
                ->filter(fn ($article) => !empty($article['title']) && !empty($article['link']))
                ->sortByDesc('published_at')
                ->unique('link')
                ->values();
        });

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginatedArticles = new LengthAwarePaginator(
            $articles->forPage($currentPage, self::ITEMS_PER_PAGE)->values(),
            $articles->count(),
            self::ITEMS_PER_PAGE,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('frontend.new.index', [
            'articles' => $paginatedArticles,
        ]);
    }

    private function parseFeed(string $xml, string $source)
    {
        $xml = preg_replace('/&(?!#?[a-z0-9]+;)/i', '&amp;', $xml);

        libxml_use_internal_errors(true);
        $rss = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOERROR);

        if ($rss === false || !isset($rss->channel->item)) {
            return collect();
        }

        $items = iterator_to_array($rss->channel->item, false);

        return collect($items)
            ->take(self::ITEMS_PER_FEED)
            ->map(function ($item) use ($source) {
                $description = (string) $item->description;
                $content = (string) ($item->{'content:encoded'} ?? '');
                $image = $this->extractImage($item, $description, $content);

                $summary = $description ?: $content;
                $summary = preg_replace('/<img[^>]*>/i', '', $summary);
                $summary = trim(strip_tags(html_entity_decode($summary, ENT_QUOTES | ENT_HTML5, 'UTF-8')));

                return [
                    'title' => trim((string) $item->title),
                    'link' => trim((string) $item->link),
                    'description' => Str::limit($summary, 150),
                    'image' => $image,
                    'pubDate' => trim((string) $item->pubDate),
                    'published_at' => $this->parseDate((string) $item->pubDate),
                    'source' => $source,
                ];
            });
    }

    private function extractImage(\SimpleXMLElement $item, string $description, string $content): ?string
    {
        $media = $item->children('media', true);

        if (isset($media->thumbnail)) {
            $url = (string) ($media->thumbnail->attributes()['url'] ?? '');
            if ($url) {
                return $url;
            }
        }

        if (isset($media->content)) {
            $url = (string) ($media->content->attributes()['url'] ?? '');
            if ($url) {
                return $url;
            }
        }

        if (isset($item->enclosure)) {
            $url = (string) ($item->enclosure->attributes()['url'] ?? '');
            if ($url) {
                return $url;
            }
        }

        foreach ([$content, $description] as $html) {
            if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $html, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    private function parseDate(?string $date): Carbon
    {
        try {
            return Carbon::parse($date)->timezone('Asia/Ho_Chi_Minh');
        } catch (\Throwable) {
            return now();
        }
    }
}
