@extends('layouts.app')

@section('title', 'Journals')

@section('content')

    <div class="journal">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @foreach($journals as $post)
                            <div class="col-lg-6 col-md-6">
                                <div class="journal-item">
                                    <a href="{{ route('post', $post->id) }}">
                                        <div class="img"
                                             style="background-image: url({{ Storage::url($post->image) }})"></div>
                                    </a>
                                    <div class="text-wrap">
                                        <h5>{{ $post->title }}</h5>
                                        <p>{{Illuminate\Support\Str::limit(strip_tags($post->description), 40)}}</p>
                                        <div class="btn-wrap">
                                            <a href="{{ route('post', $post->id) }}">더 읽어보기</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($tjournals as $post)
                            <div class="col-lg-4 col-md-6">
                                <div class="journal-item">
                                    <a href="{{ route('post', $post->id) }}">
                                        <div class="img"
                                             style="background-image: url({{ Storage::url($post->image) }})"></div>
                                    </a>
                                    <div class="text-wrap">
                                        <h5>{{ $post->title }}</h5>
                                        <p>{{Illuminate\Support\Str::limit(strip_tags($post->description), 40)}}</p>
                                        <div class="btn-wrap">
                                            <a href="{{ route('post', $post->id) }}">더 읽어보기</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <h3>러시아 여행</h3>
                    @foreach($travels as $post)
                        <div class="list-item">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="img"
                                     style="background-image: url({{ Storage::url($post->image) }})"></div>
                            </a>
                            <div class="text-wrap">
                                <h5>{{ $post->title }}</h5>
                                <p>{{Illuminate\Support\Str::limit(strip_tags($post->description), 40)}}</p>
                                <div class="btn-wrap">
                                    <a href="{{ route('post', $post->id) }}">더 읽어보기</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="popular">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>가장 인기 있는</h2>
                </div>
            </div>
            <div class="row">
                @foreach($populars as $post)
                    <div class="col-lg-4">
                        <div class="popular-item">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="img"
                                     style="background-image: url({{ Storage::url($post->image) }})"></div>
                            </a>
                            <div class="text-wrap">
                                <h5>{{ $post->title }}</h5>
                                <div class="btn-wrap">
                                    <a href="{{ route('post', $post->id) }}">Read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <div class="row">
                @foreach($mjournals as $post)
                    <div class="col-lg-6 col-md-6">
                        <div class="listnews-item">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="img"
                                     style="background-image: url({{ Storage::url($post->image) }})"></div>
                            </a>
                            <div class="text-wrap">
                                <h5>{{ $post->title }}</h5>
                                <div class="btn-wrap">
                                    <a href="{{ route('post', $post->id) }}">더 읽어보기</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @foreach($ljournals as $post)
                    <div class="col-lg-3 col-md-4">
                        <div class="listnews-item">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="img"
                                     style="background-image: url({{ Storage::url($post->image) }})"></div>
                            </a>
                            <div class="text-wrap">
                                <h5>{{ $post->title }}</h5>
                                <div class="btn-wrap">
                                    <a href="{{ route('post', $post->id) }}">더 읽어보기</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
