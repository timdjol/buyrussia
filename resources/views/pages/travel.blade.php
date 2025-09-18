@extends('layouts.app')

@section('title', 'Travel')

@section('content')


    <div class="travel_title">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>현지인만 아는 장소와 알찬 일정을 만나보세요
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="travel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>러시아</h2>
                </div>
            </div>
            <div class="row">
                @foreach($russia as $post)
                    <div class="col-lg-4">
                        <div class="travel-item">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="img" style="background-image: url({{ Storage::url($post->image) }})"></div>
                            </a>
                            <div class="text-wrap">
                                <h5>{{ $post->title }}</h5>
                                <p>{{Illuminate\Support\Str::limit(strip_tags($post->description), 40)}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="travel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>키르기스스탄 </h2>
                </div>
            </div>
            <div class="row">
                @foreach($kg as $post)
                    <div class="col-lg-4">
                        <div class="travel-item">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="img" style="background-image: url({{ Storage::url($post->image) }})"></div>
                            </a>
                            <div class="text-wrap">
                                <h5>{{ $post->title }}</h5>
                                <p>{{Illuminate\Support\Str::limit(strip_tags($post->description), 40)}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="travel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>카자흐스탄</h2>
                </div>
            </div>
            <div class="row">
                @foreach($kz as $post)
                    <div class="col-lg-4">
                        <div class="travel-item">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="img" style="background-image: url({{ Storage::url($post->image) }})"></div>
                            </a>
                            <div class="text-wrap">
                                <h5>{{ $post->title }}</h5>
                                <p>{{Illuminate\Support\Str::limit(strip_tags($post->description), 40)}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="travel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>우즈베키스탄</h2>
                </div>
            </div>
            <div class="row">
                @foreach($uz as $post)
                    <div class="col-lg-4">
                        <div class="travel-item">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="img" style="background-image: url({{ Storage::url($post->image) }})"></div>
                            </a>
                            <div class="text-wrap">
                                <h5>{{ $post->title }}</h5>
                                <p>{{Illuminate\Support\Str::limit(strip_tags($post->description), 40)}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection
