@extends('layouts.app')

@section('title', 'Create ad')

@section('content')

    <div class="page single">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-md-12">
                    <h1>Create ad</h1>
                    <form method="post" action="{{ route('storeAd') }}">
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
                        <a href="{{ route('community') }}" class="btn delete cancel">Cancel</a>
                    </form>
                </div>
                <div class="col-lg-2">
                    <div class="ban">
                        <img src="{{ route('index') }}/img/adv.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        form button.more {
            width: auto;
            height: auto;
            padding: 4px 20px;
        }
        form .cancel {
            padding: 9px 30px;
            margin-left: 10px;
        }
        form .delete {
            background-color: red;
            height: auto;
            color: #fff;
            width: auto;
            display: inline-block;
            padding: 8px 10px;
            border-radius: 5px;
            font-size: 14px;
            line-height: 1.2;
            text-decoration: none;
        }
    </style>

@endsection