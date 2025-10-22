@extends('layouts.app')

@section('title', '한인업소')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        a.btn {
            font-size: 16px;
            padding: 12px 20px;
            border-radius: 5px;
            background-color: #24C3B1;
            text-decoration: none;
            color: #fff;
            border: none;
        }
        form button{
            padding: 5px 20px;
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
{{--                            <div class="search">--}}
{{--                                <form action="{{ route('searchad') }}">--}}
{{--                                    <input type="search" name="title" placeholder="찾다...">--}}
{{--                                    <button class="more"><img src="{{ route('index') }}/img/search.svg" alt=""></button>--}}
{{--                                </form>--}}
{{--                            </div>--}}
                            <div class="search">
                                <form action="{{ route('community') }}" method="get">
                                    <input type="search" name="title" value="{{ request('title') }}" placeholder="찾다...">
                                    @if(request('region'))  <input type="hidden" name="region" value="{{ request('region') }}"> @endif
                                    @if(request('company')) <input type="hidden" name="company" value="{{ request('company') }}"> @endif
                                    <button class="more"><img src="{{ route('index') }}/img/search.svg" alt=""></button>
                                </form>
                            </div>

                            {{-- ФИЛЬТРЫ ПО ТЕГАМ --}}
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <form action="{{ route('community') }}" method="get" class="d-flex gap-2 flex-wrap">
                                        <div>
                                            <label class="form-label d-block mb-1">Region</label>
                                            <select name="region" class="form-select" style="min-width:220px">
                                                <option value="">— All regions —</option>
                                                @foreach($regions as $t)
                                                    <option value="{{ $t->id }}" @selected((string)$t->id === request('region'))>
                                                        {{ $t->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="form-label d-block mb-1">Company</label>
                                            <select name="company" class="form-select" style="min-width:220px">
                                                <option value="">— All companies —</option>
                                                @foreach($companies as $t)
                                                    <option value="{{ $t->id }}" @selected((string)$t->id === request('company'))>
                                                        {{ $t->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        @if(request('title'))
                                            <input type="hidden" name="title" value="{{ request('title') }}">
                                        @endif

                                        <div class="align-self-end d-flex gap-2">
                                            <button type="submit" class="btn">Filter</button>
                                            @if(request()->hasAny(['region','company','title']))
                                                <a href="{{ route('community') }}" class="btn" style="background:#6c757d">Reset</a>
                                            @endif
                                        </div>
                                    </form>

                                    {{-- Плашки активных фильтров (опционально) --}}
                                    <div class="mt-2 d-flex gap-2 flex-wrap">
                                        @if(request('region'))
                                            <span class="badge bg-primary">
                  Region: {{ optional($regions->firstWhere('id', (int)request('region')))->title ?? request('region') }}
                  <a class="text-white ms-1" href="{{ route('community', request()->except('region')) }}">&times;</a>
                </span>
                                        @endif
                                        @if(request('company'))
                                            <span class="badge bg-secondary">
                  Company: {{ optional($companies->firstWhere('id', (int)request('company')))->title ?? request('company') }}
                  <a class="text-white ms-1" href="{{ route('community', request()->except('company')) }}">&times;</a>
                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="table-wrap">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>번호</th>
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
                                            <td>
                                                @isset($ad->region_id)
                                                    <div class="stick reg"><a href="{{ route('taglist', $ad->region_id) }}">{{ $ad->region->title }}</a></div>
                                                @endisset
                                                @isset($ad->company_id)
                                                    <div class="stick comp"><a href="{{ route('taglist', $ad->company_id) }}">{{ $ad->company->title }}</a></div>
                                                @endisset
                                            </td>
                                            <td>
                                                <h5><a href="{{ route('post', $ad->id) }}">{{ $ad->title }}</a></h5>
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
