@extends('auth.layouts.master')

@isset($slider)
    @section('title', 'Edit slider')
@else
    @section('title', 'Add slider')
@endisset

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-9">
                    @isset($slider)
                        <h1>Edit slider</h1>
                    @else
                        <h1>Add slider</h1>
                    @endisset
                    <form enctype="multipart/form-data" method="post"
                          @isset($slider)
                              action="{{ route('sliders.update', $slider) }}"
                          @else
                              action="{{ route('sliders.store') }}"
                            @endisset
                    >
                        @isset($slider)
                            @method('PUT')
                        @endisset

                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'image'])
                            <label for="">Image</label>
                            @isset($slider->image)
                                <img src="{{ Storage::url($slider->image) }}" alt="" width="200px">
                            @endisset
                            <input type="file" name="image">
                        </div>

                        <div class="form-group">
                            <label for="">Link</label>
                            @include('auth.layouts.error', ['fieldname' => 'link'])
                            <input type="text" name="link" value="{{ old('link', isset($slider) ?
                                    $slider->link : null) }}">
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
