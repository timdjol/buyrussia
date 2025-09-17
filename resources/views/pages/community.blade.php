@extends('layouts.app')

@section('title', 'Community')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        a.btn {
            font-size: 14px;
            padding: 8px 10px;
            border-radius: 5px;
            background-color: #24C3B1;
            text-decoration: none;
            color: #fff;
            border: none;
        }

        a {
            color: #24C3B1;
            text-decoration: none;
        }

        .community .search {
            margin: 20px 0;
            position: relative;
        }

        .community .search form input {
            border-radius: 30px;
            padding: 5px 30px
        }

        .community .search form button {
            width: auto;
            position: absolute;
            right: 0;
            top: 0;
            padding: 2px 15px;
            border-radius: 30px
        }

        .community .search form button img {
            width: 20px;
            height: 20px
        }

    </style>

    <div class="community">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-md-12">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2 col-md-12">
                            <h1>잡러시아
                            </h1>
                            <div class="descr">
                                러시아 및 독립국가연합(CIS)에서 직장을 찾고 계신가요? 러시아와 CIS 지역에서 생활하거나 일하는 것을 고려하고 있는 교민 및 한국에 계신 분들 중 러시아
                                및 CIS에서
                                새로운 기회를 찾고자 하는 분들을 위해 구인구직 정보를 소개합니다.
                            </div>
                            <div class="search">
                                <form action="{{ route('searchad') }}">
                                    <input type="search" name="title" placeholder="찾다...">
                                    <button class="more"><img src="{{ route('index') }}/img/search.svg" alt=""></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="table-wrap">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>번호
                                        </th>
                                        <th>제목</th>
                                        <th>작성자
                                        </th>
                                        <th>작성일
                                        </th>
                                        <th>행동</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ads as $ad)
                                        <tr>
                                            <td>{{ $ad->id }}</td>
                                            <td>
                                                <h5><a href="{{ route('ad', $ad->id) }}">{{ $ad->title }}</a></h5>
                                                <p>{{Illuminate\Support\Str::limit(strip_tags
                                        ($ad->description), 40)}}</p>
                                            </td>
                                            <td style="font-size: 14px">{!! Avatar::create($ad->user->name)->setDimension(35,
                                     35)->setFontSize
                                    (15)
                                    ->toSvg() !!} {{ $ad->user->name }}</td>
                                            <td>
                                                <div class="date">{{ $ad->created_at->format('d M Y') }}</div>
                                            </td>
                                            <td><a href="{{ route('ad', $ad->id) }}" class="btn view"><i
                                                            class="fa-regular fa-eye"></i></a></td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                                <div class="btn-wrap">
                                    <a href="{{ route('createAd') }}" class="more">추가하다</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12">
                    @isset($contacts->ban)
                        <div class="ban">
                            <a href="{{ $contacts->link_ban }}" target="_blank">
                                <img src="{{ Storage::url($contacts->ban) }}" alt="">
                            </a>
                        </div>
                    @endisset
                    @isset($contacts->ban2)
                        <div class="ban">
                            <a href="{{ $contacts->link_ban2 }}" target="_blank">
                                <img src="{{ Storage::url($contacts->ban2) }}" alt="">
                            </a>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>

@endsection