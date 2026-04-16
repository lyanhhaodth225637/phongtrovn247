<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class NewController extends Controller
{
    public function index()
    {
        $response = Http::timeout(10)->get('https://vnexpress.net/rss/nha-dat.rss');

        if (!$response->successful()) {
            return view('frontend.new.index', [
                'articles' => collect(),
            ]);
        }

        $xml = $response->body();

        // sửa các dấu & lỗi trong XML
        $xml = preg_replace('/&(?!#?[a-z0-9]+;)/i', '&amp;', $xml);

        libxml_use_internal_errors(true);
        $rss = simplexml_load_string($xml);

        if ($rss === false) {
            return view('frontend.new.index', [
                'articles' => collect(),
            ]);
        }

        $articles = collect($rss->channel->item ?? [])
            ->map(function ($item) {
                $description = (string) $item->description;

                preg_match('/<img[^>]+src="([^"]+)"/i', $description, $matches);

                $description = preg_replace('/<img[^>]*>/i', '', $description);

                return [
                    'title' => (string) $item->title,
                    'link' => (string) $item->link,
                    'description' => trim(strip_tags($description)),
                    'image' => $matches[1] ?? null,
                    'pubDate' => (string) $item->pubDate,
                ];
            })
            ->take(12);

        return view('frontend.new.index', compact('articles'));
    }
}