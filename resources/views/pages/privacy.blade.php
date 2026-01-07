@extends('layouts.app')

@section('title', $page->title)

@section('content')

    <div class="page single">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <h1>{{ $page->title }}</h1>
                    {!! $page->description !!}
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
