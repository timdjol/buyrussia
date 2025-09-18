@extends('layouts.app')

@section('title', 'Home page')

@section('content')

    <div class="slider">
        <div class="owl-carousel owl-slider">
            @foreach($sliders as $slider)
                <div class="slider-item">
                    <a href="{{ $slider->link }}" target="_blank">
                        <img src="{{ Storage::url($slider->image) }}" alt="">
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="main">
        <div class="container">
            <div class="ban">
                @isset($contacts->ban)
                    <a href="{{ $contacts->link_ban }}" target="_blank">
                        <img src="{{ Storage::url($contacts->ban) }}" alt="">
                    </a>
                @endisset
                @isset($contacts->ban3)
                    <a href="{{ $contacts->link_ban3 }}" target="_blank">
                        <img src="{{ Storage::url($contacts->ban3) }}" alt="">
                    </a>
                @endisset
            </div>

            <div class="row">
                <div class="news">
                    <div class="row">
                        @foreach($news as $post)
                            <div class="col-lg-4 col-md-6">
                                <div class="news-item">
                                    <a href="{{ route('post', $post->id) }}">
                                        <div class="img"
                                             style="background-image: url({{ Storage::url($post->image) }})"></div>
                                    </a>
                                    <div class="text-wrap">
                                        <h5>{{ $post->title }}</h5>
                                        <div class="descr">{{Illuminate\Support\Str::limit(strip_tags
                                        ($post->description), 40)}}
                                        </div>
                                        <div class="wrap">
                                            <a href="{{ route('post', $post->id) }}">더 읽어보기</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-wrap">
                                <a href="{{ route('news') }}" class="more">더 많은 기사 보기</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="news journals">
                    <div class="row">
                        @foreach($journals as $post)
                            <div class="col-lg-4 col-md-6">
                                <div class="news-item">
                                    <a href="{{ route('post', $post->id) }}">
                                        <div class="img"
                                             style="background-image: url({{ Storage::url($post->image) }})"></div>
                                    </a>
                                    <div class="text-wrap">
                                        <h5>{{ $post->title }}</h5>
                                        <div class="descr">{{Illuminate\Support\Str::limit(strip_tags
                                        ($post->description), 40)}}
                                        </div>
                                        <div class="wrap">
                                            <a href="{{ route('post', $post->id) }}">더 읽어보기</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-wrap">
                                <a href="{{ route('journals') }}" class="more">더 많은 잡지 보기</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="listings d-xl-block d-lg-block d-none">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="listings-item">
                                <h4>에이전트 신설</h4>
                                <table>
                                    @foreach($agency as $post)
                                        <tr>
{{--                                            <td>--}}
{{--                                                <div class="tag" style="background-color:--}}
{{--                                                    @isset($post->tag_id)--}}
{{--                                                    @if($post->tag_id == 2)--}}
{{--                                                    #FF7675--}}
{{--                                                    @elseif($post->tag_id == 3)--}}
{{--                                                    #F9CA24--}}
{{--                                                    @elseif($post->tag_id == 4)--}}
{{--                                                    #BE2EDD--}}
{{--                                                    @elseif($post->tag_id == 5)--}}
{{--                                                    #6AB04C--}}
{{--                                                    @elseif($post->tag_id == 6)--}}
{{--                                                    #95AFC0--}}
{{--                                                    @elseif($post->tag_id == 7)--}}
{{--                                                    #FF7675--}}
{{--                                                    @else--}}
{{--                                                    #4c5655--}}
{{--                                                    @endif--}}
{{--                                                    @endisset--}}
{{--                                                    ">{{ $post->category->title ?? '' }}</div>--}}
{{--                                            </td>--}}
                                            <td>
                                                @isset($post->region_id)
                                                    <div class="stick reg">
                                                        <a href="{{ route('taglist', $post->region_id) }}">{{ $post->region->title }}</a>
                                                    </div>
                                                @endisset
                                                @isset($post->company_id)
                                                    <div class="stick comp">
                                                        <a href="{{ route('taglist', $post->company_id) }}">{{ $post->company->title }}</a>
                                                    </div>
                                                @endisset
                                            </td>
                                            <td><a href="{{ route('post', $post->id) }}">{{ $post->title }}</a>
                                            </td>
                                            <td>
                                                <div class="time">{{ $post->created_at->format('H:i') }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="listings-item">
                                <h4>공지 사항</h4>
{{--                                <h4>공지 사항(anons)</h4>--}}
                                <table>
                                    @foreach($advs as $post)
                                        <tr>
{{--                                            <td>--}}
{{--                                                <div class="tag" style="background-color:--}}
{{--                                                    @isset($post->tag_id)--}}
{{--                                                    @if($post->tag_id == 2)--}}
{{--                                                    #FF7675--}}
{{--                                                    @elseif($post->tag_id == 3)--}}
{{--                                                    #F9CA24--}}
{{--                                                    @elseif($post->tag_id == 4)--}}
{{--                                                    #BE2EDD--}}
{{--                                                    @elseif($post->tag_id == 5)--}}
{{--                                                    #6AB04C--}}
{{--                                                    @elseif($post->tag_id == 6)--}}
{{--                                                    #95AFC0--}}
{{--                                                    @elseif($post->tag_id == 7)--}}
{{--                                                    #FF7675--}}
{{--                                                    @else--}}
{{--                                                    #4c5655--}}
{{--                                                    @endif--}}
{{--                                                    @endisset--}}
{{--                                                    ">{{ $post->category ?? '' }}</div>--}}
{{--                                            </td>--}}
                                            <td>
                                                @isset($post->region_id)
                                                    <div class="stick reg">
                                                        <a href="{{ route('taglist', $post->region_id) }}">{{ $post->region->title }}</a>
                                                    </div>
                                                @endisset
                                                @isset($post->company_id)
                                                    <div class="stick comp">
                                                        <a href="{{ route('taglist', $post->company_id) }}">{{ $post->company->title }}</a>
                                                    </div>
                                                @endisset
                                            </td>
                                            <td><a href="{{ route('post', $post) }}">{{ $post->title }}</a></td>
                                            <td>
                                                <div class="time">{{ $post->created_at->format('H:i') }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="listings-item">
                                <h4>한국 비즈니스</h4>
{{--                                <h4>한국 비즈니스(business)</h4>--}}
                                <table>
                                    @foreach($business as $post)
                                        <tr>
{{--                                            <td>--}}
{{--                                                <div class="tag" style="background-color:--}}
{{--                                                    @isset($post->tag_id)--}}
{{--                                                    @if($post->tag_id == 2)--}}
{{--                                                    #FF7675--}}
{{--                                                    @elseif($post->tag_id == 3)--}}
{{--                                                    #F9CA24--}}
{{--                                                    @elseif($post->tag_id == 4)--}}
{{--                                                    #BE2EDD--}}
{{--                                                    @elseif($post->tag_id == 5)--}}
{{--                                                    #6AB04C--}}
{{--                                                    @elseif($post->tag_id == 6)--}}
{{--                                                    #95AFC0--}}
{{--                                                    @elseif($post->tag_id == 7)--}}
{{--                                                    #FF7675--}}
{{--                                                    @else--}}
{{--                                                    #4c5655--}}
{{--                                                    @endif--}}
{{--                                                    @endisset--}}
{{--                                                    ">{{ $post->tag->title ?? '' }}</div>--}}
{{--                                            </td>--}}
                                            <td>
                                                @isset($post->region_id)
                                                    <div class="stick reg">
                                                        <a href="{{ route('taglist', $post->region_id) }}">{{ $post->region->title }}</a>
                                                    </div>
                                                @endisset
                                                @isset($post->company_id)
                                                    <div class="stick comp">
                                                        <a href="{{ route('taglist', $post->company_id) }}">{{ $post->company->title }}</a>
                                                    </div>
                                                @endisset
                                            </td>
                                            <td><a href="{{ route('post', $post->id) }}">{{ $post->title }}</a>
                                            </td>
                                            <td>
                                                <div class="time">{{ $post->created_at->format('H:i') }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="listings d-xl-none d-lg-none d-block">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="tabs">
                                <li class="tab-link current" data-tab="tab-1">에이전트 신설</li>
                                <li class="tab-link" data-tab="tab-2">공지 사항</li>
                                <li class="tab-link" data-tab="tab-3">한국 비즈니스</li>
                            </ul>
                            <div class="tab-content listings-item current" id="tab-1">
                                <table>
                                    @foreach($agency as $post)
                                        <tr>
                                            <td>
                                                @isset($post->region_id)
                                                    <div class="stick reg"><a href="{{ route('taglist', $post->region_id) }}">{{ $post->region->title }}</a></div>
                                                @endisset
                                                @isset($post->company_id)
                                                    <div class="stick comp"><a href="{{ route('taglist', $post->company_id) }}">{{ $post->company->title }}</a></div>
                                                @endisset
                                            </td>
                                            <td><a href="{{ route('post', $post->id) }}">{{ $post->title }}</a>
                                            </td>
                                            <td>
                                                <div class="time">{{ $post->created_at->format('H:i') }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="tab-content listings-item" id="tab-2">
                                <table>
                                    @foreach($advs as $post)
                                        <tr>
                                            <td>
                                                @isset($post->region_id)
                                                    <div class="stick reg"><a href="{{ route('taglist', $post->region_id) }}">{{ $post->region->title }}</a></div>
                                                @endisset
                                                @isset($post->company_id)
                                                    <div class="stick comp"><a href="{{ route('taglist', $post->company_id) }}">{{ $post->company->title }}</a></div>
                                                @endisset
                                            </td>
                                            <td><a href="{{ route('post', $post) }}">{{ $post->title }}</a></td>
                                            <td>
                                                <div class="time">{{ $post->created_at->format('H:i') }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="tab-content listings-item" id="tab-3">
                                <table>
                                    @foreach($business as $post)
                                        <tr>
                                            <td>
                                                @isset($post->region_id)
                                                    <div class="stick reg"><a href="{{ route('taglist', $post->region_id) }}">{{ $post->region->title }}</a></div>
                                                @endisset
                                                @isset($post->company_id)
                                                    <div class="stick comp"><a href="{{ route('taglist', $post->company_id) }}">{{ $post->company->title }}</a></div>
                                                @endisset
                                            </td>
                                            <td><a href="{{ route('post', $post->id) }}">{{ $post->title }}</a>
                                            </td>
                                            <td>
                                                <div class="time">{{ $post->created_at->format('H:i') }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ban2">
                @isset($contacts->ban2)
                    <a href="{{ $contacts->link_ban2 }}" target="_blank">
                        <img src="{{ Storage::url($contacts->ban2) }}" alt="">
                    </a>
                @endisset
                @isset($contacts->ban4)
                    <a href="{{ $contacts->link_ban4 }}" target="_blank">
                        <img src="{{ Storage::url($contacts->ban4) }}" alt="">
                    </a>
                @endisset
            </div>
        </div>
    </div>

    <div class="vantages">
        <div class="container">
            <div class="row">
                @foreach($vantages as $vantage)
                    <div class="col-lg-3 col-md-6">
                        <div class="vantages-item">
                            <img src="{{ Storage::url($vantage->image) }}" alt="">
                            <h5>{{ $vantage->title }}</h5>
                            {!! $vantage->description !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="gallery">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs" data-loop="true"
                         data-autoplay="3000">
                        @foreach($videos as $video)
                            <a href="{{ $video->link }}"></a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bloggers">
        <div class="overlay"></div>
        <div class="owl-carousel owl-bloggers">
            @foreach($bloggers as $blogger)
                <div class="bloggers-item">
                    <a href="{{ $blogger->link }}" target="_blank">
                        <img src="{{ Storage::url($blogger->image) }}" alt="">
                    </a>
                </div>
            @endforeach
        </div>
    </div>

@endsection
