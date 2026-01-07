@extends('layouts.app')

@section('title', '한인업소')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <div class="nav">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul>
                        <li><a href="{{ route('community') }}">문의</a></li>
                        <li><a href="{{ route('community_ads') }}">광고</a></li>
                        <li><a href="{{ route('community_law') }}" class="active">법률·의료</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="community">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-md-12">
                    <h1>법률·의료</h1>
{{--                    <div class="descr">--}}
{{--                        해외 알바 다나와 게시판은 각 숙소에서의 스태프(매니저, 아르바이트, 주방 아주머니 등)의 <br>--}}
{{--                        구민/구직 관련 정보를 교환하는 게시판으로, 민다에서는 정보교환의 온라인 공간을 제공할 뿐 중개에 관여하지 않으며, <br>--}}
{{--                        그에 따른 과실 또는 손해발생에 대해 일체 책임을 지지 않음을 알려드립니다.--}}
{{--                    </div>--}}
                    <div class="row aic">
                        <div class="col-md-8">
                            <form id="kind-form">
                                <div class="form-group">
                                    <input type="radio" id="kind_all" name="kind" value="all" checked>
                                    <label for="kind_all">전체</label>
                                </div>
                                <div class="form-group">
                                    <input type="radio" id="kind_law" name="kind" value="law">
                                    <label for="kind_law">변호사</label>
                                </div>
                                <div class="form-group">
                                    <input type="radio" id="kind_health" name="kind" value="health">
                                    <label for="kind_health">건강</label>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="search">
                                <form action="{{ route('community') }}" method="get">
                                    <input type="search" name="title" value="{{ request('title') }}"
                                           placeholder="찾다...">
                                    @if(request('region'))
                                        <input type="hidden" name="region" value="{{ request('region') }}">
                                    @endif
                                    @if(request('company'))
                                        <input type="hidden" name="company" value="{{ request('company') }}">
                                    @endif
                                    <button class="more"><img src="{{ route('index') }}/img/search.svg" alt=""></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div id="ads-wrapper"
                                 data-filter-url="{{ route('community_law.filter') }}"
                                 data-page-url="{{ route('community_law') }}">
                                @include('layouts._table', ['ads' => $ads])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12">
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const wrapper  = document.getElementById('ads-wrapper');
            const kindForm = document.getElementById('kind-form');

            if (!wrapper) return;

            const filterBase = wrapper.dataset.filterUrl; // разный для каждой страницы
            const pageBase   = wrapper.dataset.pageUrl;   // community / community/ads / community/laws

            function buildParams(overrides = {}) {
                const params = new URLSearchParams(window.location.search);

                // KIND (radio)
                let kindValue = null;
                const checkedKind = document.querySelector('input[name="kind"]:checked');
                if (checkedKind) kindValue = checkedKind.value;

                if ('kind' in overrides) {
                    kindValue = overrides.kind;
                }

                if (kindValue && kindValue !== 'all') {
                    params.set('kind', kindValue);
                } else {
                    params.delete('kind');
                }

                // здесь можно оставить PAGE, если хочешь ajax-пагинацию
                if ('page' in overrides) {
                    if (overrides.page) params.set('page', overrides.page);
                    else params.delete('page');
                }

                return params;
            }

            function loadWithParams(params) {
                const query      = params.toString();
                const filterUrl  = filterBase + (query ? '?' + query : '');
                const visibleUrl = pageBase   + (query ? '?' + query : '');

                fetch(filterUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.text())
                    .then(html => {
                        wrapper.innerHTML = html;
                        window.history.pushState({}, '', visibleUrl);
                    })
                    .catch(err => console.error(err));
            }

            // смена kind (전체 / 사고 / 팔고 и т.п.)
            if (kindForm) {
                kindForm.addEventListener('change', function (e) {
                    const input = e.target.closest('input[name="kind"]');
                    if (!input) return;

                    const params = buildParams({
                        kind: input.value,
                        page: null,
                    });

                    loadWithParams(params);
                });
            }

            // если хочешь оставить AJAX-пагинацию — этот блок можно не убирать
            document.addEventListener('click', function (e) {
                const link = e.target.closest('#ads-wrapper .pagination a');
                if (!link) return;

                e.preventDefault();

                const url  = new URL(link.href);
                const page = url.searchParams.get('page');

                const params = buildParams({ page });

                loadWithParams(params);
            });
        });
    </script>



@endsection
