@extends('auth.layouts.master')

@isset($page)
    @section('title', 'Edit page ' . $page->title)
@else
    @section('title', 'Add page')
@endisset

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    @isset($page)
                        <h1>Edit page {{ $page->title }}</h1>
                    @else
                        <h1>Add page</h1>
                    @endisset
                    <form enctype="multipart/form-data" method="post"
                          @isset($page)
                              action="{{ route('pages.update', $page) }}"
                          @else
                              action="{{ route('pages.store') }}"
                            @endisset
                    >
                        @isset($page)
                            @method('PUT')
                        @endisset
                            @include('auth.layouts.error', ['fieldname' => 'title'])
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" name="title" value="{{ old('title', isset($page) ?
                                    $page->title : null) }}" required>
                            </div>

                            @include('auth.layouts.error', ['fieldname' => 'description'])
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description" id="editor" rows="3">{{ old('description', isset($page) ?
                            $page->description : null) }}</textarea>
                            </div>
                            <script src="https://cdn.tiny.cloud/1/yxonqgmruy7kchzsv4uizqanbapq2uta96cs0p4y91ov9iod/tinymce/6/tinymce.min.js"
                                    referrerpolicy="origin"></script>
                            <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
                            <script>
                                ClassicEditor
                                    .create(document.querySelector('#editor'))
                                    .catch(error => {
                                        console.error(error);
                                    });
                            </script>
                        @csrf
                        <button class="more">Send</button>
                        <a href="{{url()->previous()}}" class="btn delete cancel">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
