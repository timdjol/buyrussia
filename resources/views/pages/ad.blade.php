@extends('layouts.app')

@section('title', $ad->title)

@section('content')

    <div class="page single">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="date">{{ $ad->created_at->format('d M Y') }}</div>
                    <h1>{{ $ad->title }}</h1>
                    {!! $ad->description !!}
                </div>
                <div class="col-lg-2">
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