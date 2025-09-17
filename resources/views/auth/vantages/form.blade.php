@extends('auth.layouts.master')

@isset($vantage)
    @section('title', 'Edit vantage ' . $vantage->title)
@else
    @section('title', 'Add vantage')
@endisset

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-9">
                    @isset($vantage)
                        <h1>Edit vantage {{ $vantage->title }}</h1>
                    @else
                        <h1>Add vantage</h1>
                    @endisset
                    <form enctype="multipart/form-data" method="post"
                          @isset($vantage)
                              action="{{ route('vantages.update', $vantage) }}"
                          @else
                              action="{{ route('vantages.store') }}"
                        @endisset
                    >
                        @isset($vantage)
                            @method('PUT')
                        @endisset

                        <div class="form-group">
                            <label for="">Title</label>
                            @include('auth.layouts.error', ['fieldname' => 'title'])
                            <input type="text" name="title" value="{{ old('title', isset($vantage) ?
                                    $vantage->title : null) }}">
                        </div>

                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'description'])
                            <label for="">Description</label>
                            <textarea name="description" id="editor" rows="3">{{ old('description', isset($vantage) ?
                            $vantage->description : null) }}</textarea>
                        </div>
                        <script
                            src="https://cdn.tiny.cloud/1/yxonqgmruy7kchzsv4uizqanbapq2uta96cs0p4y91ov9iod/tinymce/6/tinymce.min.js"
                            referrerpolicy="origin"></script>
                        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
                        <script>
                            ClassicEditor
                                .create(document.querySelector('#editor'), {
                                    ckfinder: {
                                        uploadUrl: `{{ route('uploadMedia').'?_token='.csrf_token() }}`
                                    }
                                })

                                .catch(error => {

                                });
                        </script>

                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'image'])
                            <label for="">Image</label>
                            @isset($vantage->image)
                                <img src="{{ Storage::url($vantage->image) }}" alt="" width="200px">
                            @endisset
                            <input type="file" name="image">
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
