@extends('auth.layouts.master')

@isset($video)
    @section('title', 'Edit video')
@else
    @section('title', 'Add video')
@endisset

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-9">
                    @isset($video)
                        <h1>Edit video</h1>
                    @else
                        <h1>Add video</h1>
                    @endisset
                    <form method="post"
                          @isset($video)
                              action="{{ route('videos.update', $video) }}"
                          @else
                              action="{{ route('videos.store') }}"
                            @endisset
                    >
                        @isset($video)
                            @method('PUT')
                        @endisset

                        <div class="form-group">
                            <label for="">Link</label>
                            @include('auth.layouts.error', ['fieldname' => 'link'])
                            <input type="text" name="link" value="{{ old('link', isset($video) ?
                                    $video->link : null) }}">
                        </div>
                        @csrf
                        <button class="more">Send</button>
                        <a href="{{url()->previous()}}" class="btn delete cancel">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        form select {
            height: 150px;
        }
    </style>

@endsection
