@extends('layouts.app')

@section('title', $post->title)

@section('content')

    <div class="page single">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    @isset($post->region_id)
                        <div class="stick reg">
                            <a href="{{ route('taglist', $post->region_id) }}">{{ $post->region->title }}</a>
                        </div>
                    @endisset
                    @isset($post->company_id)
                        <div class="stick comp">
                            <a href="{{ route('taglist', $post->company_id) }}">{{ $post->company->title }}</a>
                        </div>
                    @endisset
                    @if($post->images != null)
                        <style>
                            .loc {
                                padding: 20px;
                                background-color: #f5f5f5;
                                margin-bottom: 15px;
                            }

                            .loc .address {
                                background-color: #fff;
                                padding: 10px;
                                margin-bottom: 15px;
                            }

                            #mapid {
                                height: 280px;
                            }

                        </style>
                        <div class="row loc">
                            <div class="col-md-7">
                                <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs" data-loop="true"
                                     data-autoplay="3000">
                                    <img src="{{ Storage::url($post->image) }}" alt="">
                                    @foreach($post->images as $img)
                                        <img src="{{ Storage::url($img) }}" alt="">
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div id="map" style="height: 300px; margin-bottom: 15px"> <!-- Контейнер карты -->
                                    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
                                    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                                    <script>
                                        // Безопасно получаем значения из Blade как строки и парсим в числа
                                        const latFromServer = @json(old('lat', isset($post) ? $post->lat : null));
                                        const lngFromServer = @json(old('lng', isset($post) ? $post->lng : null));

                                        // Дефолтные координаты (Бишкек)
                                        const DEFAULT_LAT = {{ $post->lat }};
                                        const DEFAULT_LNG = {{ $post->lng }};

                                        // Пытаемся привести к числам
                                        let lat = Number.parseFloat(latFromServer);
                                        let lng = Number.parseFloat(lngFromServer);

                                        // Если не число — ставим дефолт
                                        if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
                                            lat = {{ $post->lat }};
                                            lng = {{ $post->lng }};
                                        }

                                        const map = L.map('map').setView([lat, lng], 15);

                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);

                                        let marker = null;

                                        // Ставим маркер если координаты валидные
                                        if (Number.isFinite(lat) && Number.isFinite(lng)) {
                                            marker = L.marker([lat, lng]).addTo(map)
                                                .bindPopup('Широта: ' + lat.toFixed(6) + '<br>Долгота: ' + lng.toFixed(6))
                                                .openPopup();
                                        }

                                        L.control.scale().addTo(map);

                                    </script>
                                </div>
                                @isset($post->address)
                                    <div class="address">Address: {{ $post->address }}</div>
                                @endisset
                                @isset($post->graph)
                                    <div class="address">Time: {{ $post->graph }}</div>
                                @endisset
                                @isset($post->phone)
                                    <div class="address">Phone: <a href="tel:{{ $post->phone }}">{{ $post->phone }}</a>
                                    </div>
                                @endisset
                                @isset($post->url)
                                    <div class="address">Url: <a href="{{ $post->url }}"
                                                                 target="_blank">{{ $post->url }}</a></div>
                                @endisset
                            </div>
                        </div>
                    @else
                        <img src="{{ Storage::url($post->image) }}" alt="">
                    @endif
                    @isset($post->comment)
                        <style>
                            .comment .circle img {
                                border-radius: 100%;
                                object-fit: cover;
                                width: 100px;
                                height: 100px;
                            }

                            .comment {
                                padding: 20px;
                                border: 1px solid #ddd;
                                margin-bottom: 15px;
                            }

                            .comment .date {
                                font-size: 12px;
                                opacity: .6;
                                display: block;
                                text-align: right;
                            }


                        </style>
                        <div class="comment">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="circle">
                                        <img src="{{ Storage::url($post->image) }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="date">{{ $post->created_at->format('d M Y') }}</div>
                                    {{ $post->comment }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="date">{{ $post->created_at->format('d M Y') }}</div>
                    @endisset
                    <h1>{{ $post->title }}</h1>
                    <style>
                        iframe {
                            width: 100%;
                            aspect-ratio: 16 / 9;
                            height: auto;
                            border: 0;
                        }
                    </style>

                    <script>
                        (function () {
                            function toYoutubeEmbed(url) {
                                try {
                                    const u = new URL(url);
                                    const host = u.hostname.replace(/^www\./, '').toLowerCase();

                                    if (host === 'youtu.be') {
                                        const id = u.pathname.replace(/^\/+/, '');
                                        return id ? 'https://www.youtube.com/embed/' + id : null;
                                    }
                                    if (host === 'youtube.com' || host === 'm.youtube.com') {
                                        const p = u.pathname;
                                        if (p === '/watch') {
                                            const id = u.searchParams.get('v');
                                            return id ? 'https://www.youtube.com/embed/' + id : null;
                                        }
                                        if (p.startsWith('/shorts/')) {
                                            const id = p.split('/')[2];
                                            return id ? 'https://www.youtube.com/embed/' + id : null;
                                        }
                                        if (p.startsWith('/embed/')) {
                                            return url; // уже embed
                                        }
                                    }
                                } catch (e) {
                                }
                                return null;
                            }

                            function hydrateEmbeds(root) {
                                // Ищем и <oembed url="...">, и <div data-oembed-url="...">
                                const nodes = root.querySelectorAll('oembed[url], [data-oembed-url]');
                                nodes.forEach(function (el) {
                                    const url = el.getAttribute('url') || el.getAttribute('data-oembed-url');
                                    if (!url) return;

                                    const embed = toYoutubeEmbed(url);
                                    if (!embed) return;

                                    const iframe = document.createElement('iframe');
                                    iframe.src = embed;
                                    iframe.loading = 'lazy';
                                    iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
                                    iframe.allowFullscreen = true;
                                    iframe.referrerPolicy = 'strict-origin-when-cross-origin';

                                    const figure = el.closest('figure.media');
                                    (figure || el).replaceWith(iframe);
                                });
                            }

                            function run() {
                                const root = document.getElementById('post-content') || document;
                                hydrateEmbeds(root);
                            }

                            // 1) Обычная загрузка
                            if (document.readyState === 'loading') {
                                document.addEventListener('DOMContentLoaded', run);
                            } else {
                                run();
                            }
                            // 2) Турболинки / Inertia / Livewire — запускаем на их событиях
                            document.addEventListener('turbolinks:load', run);
                            document.addEventListener('turbo:load', run);
                            document.addEventListener('livewire:navigated', run);
                        })();
                    </script>
                    {!! $post->description !!}
                    <div class="comment">
                        @auth
                            <div class="row">
                                <div class="col-md-2">
                                    {!! Avatar::create($user->name)->setDimension(100, 100)->setFontSize(60)->toSvg() !!}
                                    <small>{{ $user->name }}</small>
                                </div>
                                <div class="col-md-10">
                                    @if(session()->has('success'))
                                        <p class="alert alert-success">{{ session()->get('success') }}</p>
                                    @endif
                                    @if(session()->has('warning'))
                                        <p class="alert alert-warning">{{ session()->get('warning') }}</p>
                                    @endif
                                    <form action="{{ route('storeComment') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <label for="">귀하의 의견</label>
                                        @include('auth.layouts.error', ['fieldname' => 'description'])
                                        <textarea name="description" id="editor" rows="3"></textarea>
                                        <button class="more" style="margin-top: 10px">보내다</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">댓글을 남기려면 <a href="{{ route('register') }}">로그인</a>해야 합니다.
                            </div>
                        @endauth
                        @foreach($comments as $comment)
                            <div class="row comment-item">
                                <div class="col-md-2">
                                    {!! Avatar::create($comment->user->name)->setDimension(50, 50)->setFontSize(30)
                                    ->toSvg()
                                     !!}
                                    <small>{{ $comment->user->name }}</small>
                                </div>
                                <div class="col-md-10">
                                    <p>{{ $comment->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-2">
                    @isset($contacts->ban)
                        <div class="ban">
                            <a href="{{ $contacts->link_ban }}" target="_blank">
                                <img src="{{ Storage::url($contacts->ban) }}" alt="">
                            </a>
                        </div>
                    @endisset
                    @isset($contacts->ban2)
                        <div class="ban">
                            <a href="{{ $contacts->link_ban2 }}" target="_blank">
                                <img src="{{ Storage::url($contacts->ban2) }}" alt="">
                            </a>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>

    <div class="listnews related">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>관련된</h2>
                </div>
            </div>
            <div class="row">
                @foreach($related as $post)
                    <div class="col-lg-3 col-md-4">
                        <div class="listnews-item">
                            <a href="{{ route('post', $post->id) }}">
                                <div class="img" style="background-image: url({{ $post->image_url }})"></div>
                            </a>
                            <div class="text-wrap">
{{--                                <div class="tag">{{ $post->tag->title ?? '' }}</div>--}}
                                <h5>{{ $post->title }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
