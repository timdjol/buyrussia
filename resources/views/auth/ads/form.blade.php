@extends('auth.layouts.master')

@isset($ad)
    @section('title', 'Edit ad ' . $ad->title)
@else
    @section('title', 'Add ad')
@endisset

@section('content')

    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    @isset($ad)
                        <h1>Edit {{ $ad->title }}</h1>
                    @else
                        <h1>Add</h1>
                    @endisset
                    <form method="post"
                          @isset($ad)
                              action="{{ route('ads.update', $ad) }}"
                          @else
                              action="{{ route('ads.store') }}"
                            @endisset
                    >
                        @isset($ad)
                            @method('PUT')
                        @endisset
                        <input type="hidden" name="user_id" value="{{ \Illuminate\Support\Facades\Auth::id() }}">
                        @include('auth.layouts.error', ['fieldname' => 'title'])
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" value="{{ old('title', isset($ad) ?
                                    $ad->title : null) }}" required>
                        </div>
                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'category'])
                            <label for="">Category</label>
                            <select name="category">
                                @isset($ad)
                                    <option value="{{ $ad->category }}">{{ $ad->category }}</option>
                                @else
                                    <option value="">카테고리 선택</option>
                                    <option value="구인" {{ old('category') == '구인' ? 'selected' : '' }}>구인</option>
                                    <option value="구직" {{ old('category') == '구직' ? 'selected' : '' }}>구직</option>
                                @endisset
                            </select>
                        </div>
                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'description'])
                            <label for="">Description</label>
                            <textarea name="description" id="editor" rows="3">{{ old('description', isset($ad) ?
                            $ad->description : null) }}</textarea>
                        </div>
                        <script src="https://cdn.tiny.cloud/1/yxonqgmruy7kchzsv4uizqanbapq2uta96cs0p4y91ov9iod/tinymce/6/tinymce.min.js"
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

                        @csrf
                        <button class="more">Send</button>
                        <a href="{{url()->previous()}}" class="btn delete cancel">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
