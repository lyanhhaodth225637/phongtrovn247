@extends('layouts.frontend.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Tin tức</h2>

        <div class="row g-4">
            @foreach($articles as $article)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">

                        @if($article['image'])
                            <img src="{{ $article['image'] }}"
                                class="card-img-top"
                                style="height:220px;object-fit:cover;"
                                alt="{{ $article['title'] }}">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                {{ $article['title'] }}
                            </h5>

                            <p class="text-muted small mb-2">
                                {{ \Carbon\Carbon::parse($article['pubDate'])->format('d/m/Y H:i') }}
                            </p>

                            <p class="card-text">
                                {{ \Illuminate\Support\Str::limit($article['description'], 120) }}
                            </p>

                            <a href="{{ $article['link'] }}" target="_blank" class="btn btn-outline-primary mt-auto">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection