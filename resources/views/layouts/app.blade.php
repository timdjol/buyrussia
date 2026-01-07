<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <!-- <base href="/"> -->
    <title>@yield('title') - BuyRussia21</title>
    <meta name="description" content="">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Template Basic Images Start -->
    <meta property="og:image" content="path/to/image.jpg">
    <link rel="icon" href="{{route('index')}}/img/favicon.jpg">
    <link rel="apple-touch-icon" sizes="180x180" href="{{route('index')}}/img/favicon.jpg">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Template Basic Images End -->

    <!-- Custom Browsers Color Start -->
    <meta name="theme-color" content="#000">
    <!-- Custom Browsers Color End -->
    <link rel="stylesheet" href="{{ route('index') }}/css/main.min.css">
    <link rel="stylesheet" href="{{ route('index') }}/css/style.css?ver=1.7">
</head>

<body>
<header>
    <div class="top-head d-xl-block d-lg-block d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="logo">
                        <a href="{{ route('index') }}"><img src="{{ route('index') }}/img/logo.svg" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="search">
                        <form action="{{ route('search') }}">
                            <input type="search" name="title" placeholder="검색어를 입력해 주세요">
                            <button class="more"><img src="{{ route('index') }}/img/search.svg" alt=""></button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="auth">
                        @auth
                            <ul>
                                <li>
                                    <a href="{{ route('profile.edit') }}">
                                        {{ \Illuminate\Support\Facades\Auth::user()->name }}
                                    </a>
                                </li>
                            </ul>
                        @else
                            <ul>
                                <li><a href="{{ route('login') }}">로그인</a></li>
                                <li><a href="{{ route('register') }}">회원가입</a></li>
                            </ul>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="top-head d-xl-none d-lg-none d-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-6">
                    <div class="logo">
                        <a href="{{ route('index') }}/"><img src="{{ route('index') }}/img/logo.svg" alt=""></a>
                    </div>
                </div>
                <div class="col-md-6 col-6 right">
                    <div class="search">
                        <a href="#search"><img src="{{ route('index') }}/img/search.svg" alt=""></a>
                    </div>
                    <div class="auth">
                        <a href="{{ route('login') }}"><img src="{{ route('index') }}/img/auth.png" alt=""></a>
                    </div>
                    <div class="menu">
                        <a href="#" class="toggle-mnu d-xl-none d-lg-none"><span></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="head">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav>
                        <ul>
                            <li @routeactive(
                            'new*')><a href="{{ route('news') }}">뉴스</a></li>
                            <li @routeactive(
                            'journal*')><a href="{{ route('journals') }}">매거진</a></li>
                            <li @routeactive(
                            'organiz*')><a href="{{ route('organizations') }}">기관·한인단체</a></li>
                            <li @routeactive(
                            'business*')><a href="{{ route('business') }}">한인 비즈니스</a></li>
                            <li @routeactive(
                            'communit*')><a href="{{ route('community') }}">커뮤니티</a></li>
                            <li @routeactive(
                            'travel*')><a href="{{ route('travel') }}">여행</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

@yield('content')

<footer>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-3">
                            <h4>바이러시아 21 소개</h4>
                        </div>
                        <div class="col-lg-3">
                            <h4>개인정보처리방침</h4>
                        </div>
                        <div class="col-lg-3">
                            <h4>공지사항</h4>
                        </div>
                        <div class="col-lg-3">
                            <h4>파트너 가입</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            {!! $contacts->description !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <ul class="soc">
                        @isset($contacts->twitter)
                            <li><a href="{{ $contacts->twitter }}" target="_blank"><img src="{{ route('index')
                        }}/img/twitter.png" alt=""></a></li>
                        @endisset
                        @isset($contacts->talk)
                            <li><a href="{{ $contacts->talk }}" target="_blank"><img
                                            src="{{ route('index') }}/img/talk.png"
                                            alt=""></a></li>
                        @endisset
                        @isset($contacts->facebook)
                            <li><a href="{{ $contacts->facebook }}" target="_blank"><img src="{{ route('index')
                        }}/img/facebook.png" alt=""></a></li>
                        @endisset
                        @isset($contacts->youtube)
                            <li><a href="{{ $contacts->youtube }}" target="_blank"><img
                                            src="{{ route('index')}}/img/youtube.png" alt=""></a></li>
                        @endisset
                        @isset($contacts->blogger)
                            <li><a href="{{ $contacts->blogger }}" target="_blank"><img src="{{ route('index')
                        }}/img/blogger.png" alt=""></a></li>
                        @endisset
                    </ul>
                    <div class="right">
                        <p>Copyright © {{date('Y')}} 바이러시아21. All rights reserved. <br>
                            <a href="mailto:{{ $contacts->email }}">{{ $contacts->email }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="{{ route('index') }}/js/scripts.min.js"></script>

</body>

</html>
