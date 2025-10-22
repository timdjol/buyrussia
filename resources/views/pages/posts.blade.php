@extends('layouts.app')

@section('title', $category)

@section('content')

    <style>
        .listnews-item .text-wrap .stick{
            margin-bottom: 10px;
        }
        .listnews-item .text-wrap .stick a{
            color: #fff;
            font-size: 12px;
            text-transform: none;
        }
    </style>

    <div class="page search">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ $category }}</h1>
                </div>
            </div>
            <div class="row">
                @if($posts->isNotEmpty())
                    @foreach($posts as $post)
                        <div class="col-lg-3 col-md-6">
                            @include('layouts.card')
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-danger">Posts not found</div>
                @endif
            </div>
        </div>
    </div>

@endsection
