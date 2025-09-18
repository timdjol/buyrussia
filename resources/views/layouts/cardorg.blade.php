<div class="listnews-item">
    <a href="{{ route('post', $post->id) }}">
        <div class="img" style="background-image: url({{ Storage::url($post->image) }})"></div>
    </a>
    <div class="text-wrap">
{{--        <div class="tag">{{ $post->tag->title ?? '' }}</div>--}}
        <h5>{{ $post->title }}</h5>
        <p style="font-size: 14px">{{Illuminate\Support\Str::limit(strip_tags($post->description), 100)}}</p>
        <div class="btn-wrap">
            <a href="{{ route('post', $post->id) }}">더 읽어보기</a>
        </div>
    </div>
</div>
