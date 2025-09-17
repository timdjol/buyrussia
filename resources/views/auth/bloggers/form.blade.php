@extends('auth.layouts.master')

@isset($blogger)
    @section('title', 'Edit blogger')
@else
    @section('title', 'Add blogger')
@endisset

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-9">
                    @isset($blogger)
                        <h1>Edit blogger</h1>
                    @else
                        <h1>Add blogger</h1>
                    @endisset
                    <form enctype="multipart/form-data" method="post"
                          @isset($blogger)
                              action="{{ route('bloggers.update', $blogger) }}"
                          @else
                              action="{{ route('bloggers.store') }}"
                            @endisset
                    >
                        @isset($blogger)
                            @method('PUT')
                        @endisset

                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'image'])
                            <label for="">Image</label>
                            @isset($blogger->image)
                                <img src="{{ Storage::url($blogger->image) }}" alt="" width="200px">
                            @endisset
                            <input type="file" name="image">
                        </div>

                        <div class="form-group">
                            <label for="">Link</label>
                            @include('auth.layouts.error', ['fieldname' => 'link'])
                            <input type="text" name="link" value="{{ old('link', isset($blogger) ?
                                    $blogger->link : null) }}">
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
