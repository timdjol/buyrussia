@extends('layouts.app')

@section('title', 'Organization')

@section('content')

    <div class="slider">
        <div class="owl-carousel owl-slider">
            @foreach($sliders as $slider)
                <div class="slider-item">
                    <a href="{{ $slider->link }}">
                        <div class="img" style="background-image: url({{ Storage::url($slider->image) }})"></div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>공공기관</h2>
                </div>
            </div>
            <div class="row">
                @foreach($institutions as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.cardorg')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>한인단체</h2>
                </div>
            </div>
            <div class="row">
                @foreach($kor_orgs as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.cardorg')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>교육 학술</h2>
                </div>
            </div>
            <div class="row">
                @foreach($edus as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.cardorg')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>언론종교</h2>
                </div>
            </div>
            <div class="row">
                @foreach($medias as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.cardorg')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
