@extends('layouts.app')

@section('title', 'Business')

@section('content')

    <div class="business_title">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>러시아 . CIS 한인업소 페이지입니다</h1>
                    <div class="descr">러시아 및 CIS 국가 기관 및 한인단체에서 정보를 제공합니다.</div>
{{--                    <div class="btn-wrap">--}}
{{--                        <a href="" class="more">무료 등록하기</a>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <h2>음식점</h2>
            <div class="row">
                @foreach($rests as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.card')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <h2>한인 민박</h2>
            <div class="row">
                @foreach($hotels as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.card')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <h2>스포츠/ 취미/동아리</h2>
            <div class="row">
                @foreach($sports as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.card')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <h2>의료 건강</h2>
            <div class="row">
                @foreach($medical as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.card')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <h2>여행사</h2>
            <div class="row">
                @foreach($tourism as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.card')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <h2>교육학원</h2>
            <div class="row">
                @foreach($edus as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.card')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <h2>법무 회계</h2>
            <div class="row">
                @foreach($laws as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.card')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <h2>노래방/주점</h2>
            <div class="row">
                @foreach($karaoke as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.card')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <h2>뷰티 미용실</h2>
            <div class="row">
                @foreach($beauty as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.card')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="listnews">
        <div class="container">
            <h2>교육 학원</h2>
            <div class="row">
                @foreach($academies as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.card')
                    </div>
                @endforeach
            </div>
        </div>
    </div>



@endsection
