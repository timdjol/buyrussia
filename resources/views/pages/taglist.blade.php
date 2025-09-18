@extends('layouts.app')

@section('title', 'Posts')

@section('content')

    <div class="latest">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $request->tag->title }}</h2>
                </div>
            </div>
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-lg-3 col-md-4">
                        @include('layouts.card')
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
