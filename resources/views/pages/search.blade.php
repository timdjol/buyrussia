@extends('layouts.app')

@section('title', 'Search')

@section('content')

    <div class="page search">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Search</h1>
                </div>
            </div>
            <div class="row">
                @if($search->isNotEmpty())
                    @foreach($search as $post)
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