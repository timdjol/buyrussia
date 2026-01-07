<div class="listnews-item">
    <a href="{{ route('post', $post->id) }}">
        <div class="img" style="background-image: url({{ Storage::url($post->image) }})"></div>
    </a>
    <div class="text-wrap">
        @isset($post->region_id)
            <div class="stick reg">
                <a href="{{ route('taglist', $post->region_id) }}">{{ $post->region->title }}</a>
            </div>
        @endisset
        @isset($post->company_id)
            <div class="stick comp">
                <a href="{{ route('post', $post->id) }}">{{ $post->company->title }}</a>
            </div>
        @endisset
        <h5>{{ $post->title }}</h5>
        <div class="text-wrap">
            <ul>
                @isset($post->address)
                    <li>{{ $post->address }}</li>
                @endisset
                @isset($post->graph)
                    <li>{{ $post->graph }}</li>
                @endisset
                @isset($post->address)
                    <li>{{ $post->phone }}</li>
                @endisset
                @isset($post->url)
                    <li><a href="{{ $post->url }}" target="_blank">{{ $post->url }}</a></li>
                @endisset
            </ul>
        </div>
        <div class="btn-wrap">
            <a href="{{ route('post', $post->id) }}">더 읽어보기</a>
        </div>
    </div>
</div>
