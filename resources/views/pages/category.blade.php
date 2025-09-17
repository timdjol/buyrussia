@extends('layouts.app')

@section('title', \App\Models\Category::where('id', $category)->first()->title)

@section('content')

    <div class="page search">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>{{ \App\Models\Category::where('id', $category)->first()->title }}</h1>
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