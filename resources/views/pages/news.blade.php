@extends('layouts.app')

@section('title', 'News')

@section('content')

    <div class="mainnews">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-7">
                    @foreach($main as $post)
                        <div class="mainnews-item">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="img" style="background-image: url({{ Storage::url($post->image) }})"></div>
                            </a>
{{--                            <div class="tag">{{ $post->tag->title ?? '' }}</div>--}}
                            <div class="overlay"></div>
                            <div class="text-wrap">
                                <div class="date">{{ $post->created_at->format('d M Y') }}</div>
                                <h5>{{ $post->title }}</h5>
                                <p>{{Illuminate\Support\Str::limit(strip_tags($post->description), 40)}}</p>
                                <div class="btn-wrap">
                                    <a href="{{ route('post', $post->id) }}" class="more">더 읽어보기</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-4 col-md-5">
                    @foreach($maint as $post)
                        <div class="mainnews-item">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="img" style="background-image: url({{ Storage::url($post->image) }})"></div>
                            </a>
{{--                            <div class="tag">{{ $post->tag->title ?? '' }}</div>--}}
                            <div class="overlay"></div>
                            <div class="text-wrap">
                                <div class="date">{{ $post->created_at->format('d M Y') }}</div>
                                <h5>{{ $post->title }}</h5>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <div class="trending">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>이슈</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @foreach($trends as $post)
                            <div class="col-md-6">
                                <div class="trending-item">
                                    <a href="{{ route('post', $post->id) }}">
                                        <div class="img"
                                             style="background-image: url({{ Storage::url($post->image) }})"></div>
                                    </a>
                                    <div class="overlay"></div>
                                    <div class="text-wrap">
                                        <h5>{{ $post->title }}</h5>
                                        <div class="date">{{ $post->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">

                </div>
            </div>
        </div>
    </div>

    <div class="categories">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>인기 카테고리</h2>
{{--                    <h2>인기 카테고리 (trend)</h2>--}}
                </div>
            </div>
            <div class="row">
                @foreach($categories as $category)
                <div class="col-lg-3 col-md-6">
                    <div class="categories-item">
                        <a href="{{ route('category', $category->id) }}">
                            <div class="img" style="background-image: url({{ Storage::url($category->image) }})"></div>
                        </a>
                        <div class="overlay"></div>
                        <div class="text-wrap">
                            <h5>{{ $category->title }}</h5>
{{--                            <p>Далеко-далеко за словесными горами в стране гласных.</p>--}}
                            <div class="btn-wrap">
                                <a href="{{ route('category', $category->id) }}" class="more">더 읽어보기</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="latest">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>지난 기사</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @foreach($latest as $post)
                            <div class="col-lg-6 col-md-6">
                                <div class="latest-item">
                                    <a href="{{ route('post', $post->id) }}">
                                        <div class="img"
                                             style="background-image: url({{ Storage::url($post->image) }})"></div>
                                    </a>
{{--                                    <div class="tag">{{ $post->tag->title ?? '' }}</div>--}}
                                    <div class="text-wrap">
                                        <h5>{{ $post->title }}</h5>
                                        <div class="date">{{ $post->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    @foreach($latestlist as $post)
                        <div class="list-item">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="img" style="background-image: url({{ Storage::url($post->image) }})"></div>
                            </a>
                            <div class="text-wrap">
                                <h5>{{ $post->title }}</h5>
                                <div class="date">{{ $post->created_at->format('d M Y') }}</div>
                                <div class="btn-wrap">
                                    <a href="{{ route('post', [isset($categories) ? $categories->first()
                                                ->id : $post->categories->first()->id, $post->id]) }}">더 읽어보기</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="editor">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>편집자 추천</h2>
                </div>
            </div>
            <div class="row">
                @foreach($featured as $post)
                    <div class="col-lg-6">
                        <div class="editor-item">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="img" style="background-image: url({{ Storage::url($post->image) }})"></div>
                            </a>
                            <div class="text-wrap">
                                <h5>{{ $post->title }}</h5>
                                <div class="date">{{ $post->created_at->format('d M Y') }}</div>
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
    </div>

@endsection
