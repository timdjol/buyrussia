@extends('auth.layouts.master')

@isset($post)
    @section('title', 'Edit ' . $post->title)
@else
    @section('title', 'Add')
@endisset

@section('content')

    <style>
        form select {
            height: 150px;
        }

        .cat-tree {
            padding-left: 0;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            max-height: 320px;
            overflow: auto;
        }

        .cat-node {
            margin: 0;
        }

        .node-row {
            display: grid;
            grid-template-columns: 28px 1fr;
            gap: 10px;
            align-items: center;
            padding: 8px 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .toggle, .toggle.placeholder {
            width: 28px;
            height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: transparent;
            cursor: pointer;
            padding: 0;
        }

        .toggle.placeholder {
            cursor: default;
            opacity: .35;
        }

        .children {
            margin: 0;
            padding-left: 0;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .select2-container--default .select2-selection--multiple {
            min-height: 50px;
            border: 1px solid #ced4da;
            border-radius: .375rem;
            padding: 4px;
        }

        .select2-container .select2-search__field {
            width: auto !important;
        }

        #map {
            width: 100%;
            height: 500px;
        }
        #categ3, #categ5, #categ8{
            display: none;
        }
    </style>


    <div class="page admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-md-10">
                    @isset($post)
                        <h1>Edit {{ $post->title }}</h1>
                    @else
                        <h1>Add</h1>
                    @endisset
                    <form enctype="multipart/form-data" method="post"
                          @isset($post)
                              action="{{ route('organizations.update', $post) }}"
                          @else
                              action="{{ route('organizations.store') }}"
                        @endisset
                    >
                        <input type="hidden" name="user_id" value="{{ \Illuminate\Support\Facades\Auth::id() }}">
                        @isset($post)
                            @method('PUT')
                        @endisset

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    @include('auth.layouts.error', ['fieldname' => 'title'])
                                    <label for="">Title</label>
                                    <input type="text" name="title" value="{{ old('title', isset($post) ?
                                    $post->title : null) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    @include('auth.layouts.error', ['fieldname' => 'category_id'])
                                    <label>Categories</label>

                                    <div class="mb-2 d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="expandAll">
                                            Expand all
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="collapseAll">
                                            Collapse all
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="selectAll">
                                            Select all
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light" id="clearAll">Clear</button>
                                    </div>

                                    <ul id="catTree" class="cat-tree list-unstyled">
                                        @foreach($roots as $cat)
                                            @include('auth.posts.cat_node', ['cat' => $cat, 'level' => 0, 'selected' => $selected])
                                        @endforeach
                                    </ul>
                                </div>
                                <script>
                                    (function () {
                                        const tree = document.getElementById('catTree');
                                        const showOnlySelectedToggle = document.getElementById('showOnlySelected');

                                        function liOf(el) {
                                            return el.closest('li[data-node]');
                                        }

                                        // ---------- toggler ----------
                                        document.addEventListener('click', function (e) {
                                            const btn = e.target.closest('.toggle[data-target]');
                                            if (!btn) return;
                                            const id = btn.getAttribute('data-target');
                                            const target = document.getElementById(id);
                                            const expanded = btn.getAttribute('aria-expanded') === 'true';
                                            btn.setAttribute('aria-expanded', (!expanded).toString());
                                            if (target) target.hidden = expanded;

                                            const icon = btn.querySelector('i');
                                            if (icon) {
                                                icon.classList.toggle('fa-plus', expanded);
                                                icon.classList.toggle('fa-minus', !expanded);
                                            }
                                        });

                                        function setAll(open) {
                                            document.querySelectorAll('.toggle[data-target]').forEach(btn => {
                                                const id = btn.getAttribute('data-target');
                                                const target = document.getElementById(id);
                                                btn.setAttribute('aria-expanded', open.toString());
                                                if (target) target.hidden = !open;
                                                const icon = btn.querySelector('i');
                                                if (icon) {
                                                    icon.classList.toggle('fa-plus', !open);
                                                    icon.classList.toggle('fa-minus', open);
                                                }
                                            });
                                        }

                                        // ---------- выбор веток ----------
                                        function setDescendants(li, checked) {
                                            li.querySelectorAll('input[type="checkbox"][name="category_id[]"]').forEach(cb => {
                                                cb.checked = checked;
                                                cb.indeterminate = false;
                                                const row = cb.closest('.node-row');
                                                row?.classList.toggle('selected', cb.checked);
                                            });
                                        }

                                        function updateAncestors(li) {
                                            while (li) {
                                                const parentLi = li.parentElement.closest('li[data-node]');
                                                if (!parentLi) break;

                                                const allKids = parentLi.querySelectorAll(':scope > ul.children > li[data-node] input[name="category_id[]"]');
                                                const checkedKids = parentLi.querySelectorAll(':scope > ul.children > li[data-node] input[name="category_id[]"]:checked');

                                                const parentCb = parentLi.querySelector(':scope > .node-row input[name="category_id[]"]');
                                                const parentRow = parentLi.querySelector(':scope > .node-row');

                                                if (parentCb) {
                                                    if (checkedKids.length === 0) {
                                                        parentCb.checked = false;
                                                        parentCb.indeterminate = false;
                                                    } else if (checkedKids.length === allKids.length) {
                                                        parentCb.checked = true;
                                                        parentCb.indeterminate = false;
                                                    } else {
                                                        parentCb.checked = false;
                                                        parentCb.indeterminate = true;
                                                    }
                                                    parentRow?.classList.toggle('selected', parentCb.checked);
                                                }
                                                li = parentLi;
                                            }
                                        }

                                        // ---------- фильтр "только отмеченные" ----------
                                        function isSelectedOrHasSelectedDesc(li) {
                                            const selfChecked = li.querySelector(':scope > .node-row input[name="category_id[]"]')?.checked;
                                            if (selfChecked) return true;
                                            return !!li.querySelector('ul.children input[name="category_id[]"]:checked');
                                        }

                                        function applyShowOnlySelected(show) {
                                            // Когда включаем фильтр — раскроем всё, чтобы было видно, что осталось
                                            if (show) setAll(true);

                                            // Рекурсивно пробежимся по всем узлам и скроем те, где нет выбранных ни у узла, ни у потомков
                                            tree?.querySelectorAll('li[data-node]').forEach(li => {
                                                li.hidden = show ? !isSelectedOrHasSelectedDesc(li) : false;
                                            });
                                        }

                                        showOnlySelectedToggle?.addEventListener('change', () => {
                                            applyShowOnlySelected(showOnlySelectedToggle.checked);
                                        });

                                        // ---------- обработка изменений чекбоксов ----------
                                        tree?.addEventListener('change', function (e) {
                                            const cb = e.target;
                                            if (cb.name !== 'category_id[]') return;

                                            const currentLi = liOf(cb);
                                            if (!currentLi) return;

                                            // Подсветка текущего ряда
                                            cb.closest('.node-row')?.classList.toggle('selected', cb.checked);

                                            // Применяем к потомкам и обновляем родителей
                                            setDescendants(currentLi, cb.checked);
                                            updateAncestors(currentLi);

                                            // Если включён фильтр — поддержим его актуальность
                                            if (showOnlySelectedToggle?.checked) {
                                                applyShowOnlySelected(true);
                                            }
                                        });

                                        // ---------- кнопки ----------
                                        document.getElementById('expandAll')?.addEventListener('click', () => setAll(true));
                                        document.getElementById('collapseAll')?.addEventListener('click', () => setAll(false));

                                        document.getElementById('selectAll')?.addEventListener('click', () => {
                                            tree?.querySelectorAll('input[name="category_id[]"]').forEach(cb => {
                                                cb.checked = true;
                                                cb.indeterminate = false;
                                                cb.closest('.node-row')?.classList.add('selected');
                                            });
                                            // при глобальном выборе предки и так станут "selected" в updateAncestors
                                            tree?.querySelectorAll('li[data-node]').forEach(li => updateAncestors(li));
                                            if (showOnlySelectedToggle?.checked) applyShowOnlySelected(true);
                                        });

                                        document.getElementById('clearAll')?.addEventListener('click', () => {
                                            tree?.querySelectorAll('input[name="category_id[]"]').forEach(cb => {
                                                cb.checked = false;
                                                cb.indeterminate = false;
                                                cb.closest('.node-row')?.classList.remove('selected');
                                            });
                                            if (showOnlySelectedToggle?.checked) applyShowOnlySelected(true);
                                        });

                                        // ---------- инициализация ----------
                                        // Подсветим выбранные, выставим indeterminate и раскроем ветки с выбранными
                                        function expandAncestors(li) {
                                            while (li) {
                                                const btn = li.querySelector(':scope > .node-row .toggle[data-target]');
                                                if (btn) {
                                                    const id = btn.getAttribute('data-target');
                                                    const target = document.getElementById(id);
                                                    btn.setAttribute('aria-expanded', 'true');
                                                    if (target) target.hidden = false;
                                                    const icon = btn.querySelector('i');
                                                    if (icon) {
                                                        icon.classList.remove('fa-plus');
                                                        icon.classList.add('fa-minus');
                                                    }
                                                }
                                                li = li.parentElement.closest('li[data-node]');
                                            }
                                        }

                                        tree?.querySelectorAll('input[name="category_id[]"]').forEach(cb => {
                                            cb.closest('.node-row')?.classList.toggle('selected', cb.checked);
                                            if (cb.checked) {
                                                expandAncestors(liOf(cb));
                                            }
                                        });
                                        // Выставим корректные индикаторы родителям
                                        tree?.querySelectorAll('input[name="category_id[]"]:checked').forEach(cb => {
                                            updateAncestors(liOf(cb));
                                        });

                                    })();
                                </script>

                            </div>
                        </div>

                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'description'])
                            <label for="">Description</label>
                            <textarea name="description" id="editor" rows="3">{{ old('description', isset($post) ?
                            $post->description : null) }}</textarea>
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
                                    },
                                    htmlSupport: {
                                        allow: [
                                            {name: 'iframe', attributes: true, classes: true, styles: true},
                                            {name: 'figure', classes: 'media', attributes: true, styles: true},
                                        ]
                                    },
                                })
                                .catch(error => {
                                });
                        </script>

                        <div class="form-group">
                            @include('auth.layouts.error', ['fieldname' => 'image'])
                            <label for="">Image</label>
                            @isset($post->image)
                                <img src="{{ Storage::url($post->image) }}" alt="" width="200px">
                            @endisset
                            <input type="file" name="image">
                        </div>

                        {{-- В шапку layout-а или прямо здесь, рядом с CKEditor --}}
                        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                                integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
                                crossorigin="anonymous"></script>
                        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
                              rel="stylesheet"/>
                        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    @include('auth.layouts.error', ['fieldname' => 'region_id'])
                                    <label for="region_id">Регион</label>
                                    <select id="region_id"
                                            name="region_id"
                                            class="form-control"
                                            data-type="region"
                                            data-endpoint="{{ route('tags.search', ['type' => 'region']) }}">
                                        @php
                                            $region = null;
                                            $regionIdOld = old('region_id', isset($post)? $post->region_id : null);
                                            if ($regionIdOld) {
                                                $region = \App\Models\Tag::find($regionIdOld);
                                            }
                                        @endphp
                                        @if($region)
                                            <option value="{{ $region->id }}" selected>
                                                {{ $region->title ?? $region->name }}
                                            </option>
                                        @endif
                                    </select>
                                    <small class="text-muted">Начните печатать, чтобы найти регион.</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    @include('auth.layouts.error', ['fieldname' => 'company_id'])
                                    <label for="company_id">Компания</label>
                                    <select id="company_id"
                                            name="company_id"
                                            data-type="company"
                                            class="form-control"
                                            data-endpoint="{{ route('tags.search', ['type' => 'company']) }}">
                                        @php
                                            $company = null;
                                            $companyIdOld = old('company_id', isset($post)? $post->company_id : null);
                                            if ($companyIdOld) {
                                                $company = \App\Models\Tag::find($companyIdOld);
                                            }
                                        @endphp
                                        @if($company)
                                            <option value="{{ $company->id }}" selected>
                                                {{ $company->title ?? $company->name }}
                                            </option>
                                        @endif
                                    </select>
                                    <small class="text-muted">Выберите компанию.</small>
                                </div>
                            </div>
                        </div>

                        <script>
                            (function () {
                                const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

                                function initAjaxCreatableSelect(selector) {
                                    const el = document.querySelector(selector);
                                    if (!el) return;

                                    const type = el.dataset.type;                 // "region" | "company"
                                    const endpoint = el.dataset.endpoint;         // tags.search с ?type=...
                                    const $el = $(el);

                                    $el.select2({
                                        width: '100%',
                                        placeholder: 'Выберите...',
                                        allowClear: true,
                                        tags: true,
                                        minimumInputLength: 1,

                                        createTag: function (params) {
                                            const term = (params.term || '').trim();
                                            if (!term) return null;
                                            return {
                                                id: '__new__:' + term,
                                                text: 'Создать: ' + term,
                                                newTag: true,
                                                realText: term
                                            };
                                        },

                                        insertTag: function (data, tag) {
                                            if (!tag.realText) return;
                                            const exists = (data || []).some(i => (i.text || '').toLowerCase() === tag.realText.toLowerCase());
                                            if (!exists) data.unshift(tag);
                                        },

                                        ajax: {
                                            url: endpoint,               // /auth/tags/search?type=region|company
                                            dataType: 'json',
                                            delay: 250,
                                            data: params => ({q: params.term || '', page: params.page || 1, type}), // на случай, если бэк фильтрует
                                            processResults: (data, params) => {
                                                params.page = params.page || 1;
                                                return {
                                                    results: (data.results || []).map(item => ({
                                                        id: item.id,
                                                        text: item.text
                                                    })),
                                                    pagination: {more: !!(data.pagination && data.pagination.more)}
                                                };
                                            },
                                            cache: true
                                        },

                                        templateSelection: function (d) {
                                            if (d.newTag && d.realText) d.text = d.realText;
                                            return d.text || d.id;
                                        }
                                    })
                                        .on('select2:select', async function (e) {
                                            const data = e.params.data;
                                            if (!data.newTag) return;

                                            try {
                                                const res = await fetch(@json(route('tags.store')), {
                                                    method: 'POST',
                                                    credentials: 'same-origin',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': csrf,
                                                        'Accept': 'application/json'
                                                    },
                                                    body: JSON.stringify({text: data.realText, type}) // <— отправляем type
                                                });

                                                const ctype = res.headers.get('content-type') || '';
                                                if (!res.ok) {
                                                    const msg = ctype.includes('application/json') ? JSON.stringify(await res.json()) : await res.text();
                                                    throw new Error(`HTTP ${res.status}: ${msg}`);
                                                }
                                                const payload = await res.json();

                                                // Подменяем временную опцию __new__:... на реальный id
                                                $el.find('option[value="' + data.id + '"]').remove();
                                                const option = new Option(payload.text, payload.id, true, true);
                                                $el.append(option).trigger('change');
                                            } catch (err) {
                                                console.error('Tag create error:', err);
                                                // убираем временное значение
                                                $el.val(null).trigger('change');
                                                alert('Не удалось создать тег. Смотрите консоль/Network.');
                                            }
                                        });
                                }

                                document.addEventListener('DOMContentLoaded', function () {
                                    initAjaxCreatableSelect('#region_id');
                                    initAjaxCreatableSelect('#company_id');
                                });
                            })();
                        </script>


                        <div class="col-md-12">
                            <label for="">Location</label>
                            <!-- Leaflet CSS/JS лучше вынести в layout, но это не обязательно -->
                            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
                            <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

                            <div id="map"></div>

                            <script>
                                // Безопасно получаем значения из Blade как строки и парсим в числа
                                const latFromServer = @json(old('lat', isset($post) ? $post->lat : null));
                                const lngFromServer = @json(old('lng', isset($post) ? $post->lng : null));

                                // Дефолтные координаты (Бишкек)
                                const DEFAULT_LAT = 42.8746;
                                const DEFAULT_LNG = 74.585902;

                                // Пытаемся привести к числам
                                let lat = Number.parseFloat(latFromServer);
                                let lng = Number.parseFloat(lngFromServer);

                                // Если не число — ставим дефолт
                                if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
                                    lat = DEFAULT_LAT;
                                    lng = DEFAULT_LNG;
                                }

                                const map = L.map('map').setView([lat, lng], 15);

                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                }).addTo(map);

                                let marker = null;

                                // Ставим маркер если координаты валидные
                                if (Number.isFinite(lat) && Number.isFinite(lng)) {
                                    marker = L.marker([lat, lng]).addTo(map)
                                        .bindPopup('Широта: ' + lat.toFixed(6) + '<br>Долгота: ' + lng.toFixed(6))
                                        .openPopup();
                                }

                                L.control.scale().addTo(map);

                                map.on('click', function (e) {
                                    const newLat = e.latlng.lat;
                                    const newLng = e.latlng.lng;
                                    if (marker) map.removeLayer(marker);

                                    // Обновляем инпуты (они у тебя с id="lat" и id="lng")
                                    const latInput = document.getElementById('lat');
                                    const lngInput = document.getElementById('lng');
                                    if (latInput) latInput.value = newLat.toFixed(6);
                                    if (lngInput) lngInput.value = newLng.toFixed(6);

                                    marker = L.marker([newLat, newLng]).addTo(map)
                                        .bindPopup('Широта: ' + newLat.toFixed(6) + '<br>Долгота: ' + newLng.toFixed(6))
                                        .openPopup();
                                });
                            </script>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Latitude</label>
                                    <input type="text" name="lat" id="lat" value="{{ old('lat', isset($post) ?
                                $post->lat : null) }}">
                                    @include('auth.layouts.error', ['fieldname' => 'lat'])
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Longitude</label>
                                    <input type="text" name="lng" id="lng" value="{{ old('lng', isset($post) ?
                                $post->lng : null) }}">
                                    @include('auth.layouts.error', ['fieldname' => 'lng'])
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" id="address" rows="3">{{ old('address', isset($post) ?
                                $post->address : null) }}</textarea>
                                </div>
                                @include('auth.layouts.error', ['fieldname' => 'address'])
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Time</label>
                                    <input type="text" name="graph" id="graph" value="{{ old('graph', isset($post) ?
                                $post->graph : null) }}">
                                </div>
                                @include('auth.layouts.error', ['fieldname' => 'graph'])
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Phone</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', isset($post) ?
                                $post->phone : null) }}">
                                </div>
                                @include('auth.layouts.error', ['fieldname' => 'phone'])
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">WebSite</label>
                                    <input type="text" name="url" id="url"
                                           value="{{ old('url', isset($post) ? $post->url : null) }}">
                                </div>
                                @include('auth.layouts.error', ['fieldname' => 'url'])
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Main information</label>
                                <textarea name="comment" rows="5">@isset($post)
                                        {{ $post->comment }}
                                    @endisset</textarea>
                                @include('auth.layouts.error', ['fieldname' => 'comment'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Images for slider</label>
                            <input type="file" name="images[]" multiple accept="image/*">
                            @include('auth.layouts.error', ['fieldname' => 'images'])
                            @include('auth.layouts.error', ['fieldname' => 'images.*'])
                        </div>

                        @isset($post)
                            @if(!empty($post->images))
                                @foreach(($post->images ?? []) as $path)
                                    <img src="{{ Storage::disk('public')->url($path) }}"
                                         alt="" style="height:120px;object-fit:cover;">
                                @endforeach

                            @endif
                        @endisset
                        @csrf
                        <button class="more">Send request</button>
                        <a href="{{url()->previous()}}" class="btn delete cancel">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
