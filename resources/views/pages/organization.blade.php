@extends('layouts.app')

@section('title', '기관·한인단체')

@section('content')

    <style>
        .btn-wrap.all{
            text-align: center;
            margin-top: 20px;
        }
        .btn-wrap .more{
            border-radius: 30px;
        }
        .listnews-item .text-wrap{
            font-size: 13px;
        }
        .listnews-item .text-wrap ul{
            padding-left: 10px;
            margin-bottom: 0;
        }
        .listnews-item .text-wrap .stick{
            margin-bottom: 10px;
        }
        .listnews-item .text-wrap .stick a{
            color: #fff;
            font-size: 12px;
            text-transform: none;
        }
        .listnews-item .text-wrap .btn-wrap a{
            border: 1px solid #f04e19;
            padding: 10px 30px;
            display: block;
            width: 100%;
            text-align: center;
            transition: all .3s ease;
        }
        .listnews-item .text-wrap .btn-wrap a:hover{
            background-color: #f04e19;
            color: #fff;
        }
    </style>

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
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-wrap all" style="margin-bottom: 40px">
                        <a href="{{ route('org_organizations', ['category' => '공공기관']) }}" class="more">더 읽어</a>
                    </div>
                </div>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-wrap all" style="margin-bottom: 40px">
                        <a href="{{ route('org_korean', ['category' => '한인단체']) }}" class="more">더 읽어</a>
                    </div>
                </div>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-wrap all" style="margin-bottom: 40px">
                        <a href="{{ route('org_educations', ['category' => '교육 학술']) }}" class="more">더 읽어</a>
                    </div>
                </div>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-wrap all" style="margin-bottom: 40px">
                        <a href="{{ route('org_media', ['category' => '언론종교']) }}" class="more">더 읽어</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
