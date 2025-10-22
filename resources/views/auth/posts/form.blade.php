@extends('auth.layouts.master')

@isset($post)
    @section('title', 'Edit post ' . $post->title)
@else
    @section('title', 'Add post')
@endisset

@section('content')

    <style>
        #categ9, #categ12{
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
                        <h1>Edit post {{ $post->title }}</h1>
                    @else
                        <h1>Add post</h1>
                    @endisset
                    <form enctype="multipart/form-data" method="post"
                          @isset($post)
                              action="{{ route('posts.update', $post) }}"
                          @else
                              action="{{ route('posts.store') }}"
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
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="expandAll">Expand all</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="collapseAll">Collapse all</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="selectAll">Select all</button>
                                        <button type="button" class="btn btn-sm btn-light" id="clearAll">Clear</button>
                                    </div>

                                    <ul id="catTree" class="cat-tree list-unstyled">
                                        @foreach($roots as $cat)
                                            @include('auth.posts.cat_node', ['cat' => $cat, 'level' => 0, 'selected' => $selected])
                                        @endforeach
                                    </ul>
                                </div>

                                <style>
                                    .cat-tree { padding-left: 0; background: #fff; border: 1px solid #e5e7eb; border-radius: 6px; max-height: 320px; overflow: auto; }
                                    .cat-node { margin: 0; }
                                    .node-row {
                                        display: grid;
                                        grid-template-columns: 28px 1fr;
                                        gap: 10px;
                                        align-items: center;
                                        padding: 8px 10px;
                                        border-bottom: 1px solid #f0f0f0;
                                    }
                                    .toggle, .toggle.placeholder {
                                        width: 28px; height: 28px;
                                        display: inline-flex; align-items: center; justify-content: center;
                                        border: none; background: transparent; cursor: pointer; padding: 0;
                                    }
                                    .toggle.placeholder { cursor: default; opacity: .35; }
                                    .children { margin: 0; padding-left: 0; }
                                    .checkbox-label { display: flex; align-items: center; gap: 10px; cursor: pointer; }
                                </style>

                                <script>
                                    (function(){
                                        const tree = document.getElementById('catTree');
                                        const showOnlySelectedToggle = document.getElementById('showOnlySelected');

                                        function liOf(el) { return el.closest('li[data-node]'); }

                                        // ---------- toggler ----------
                                        document.addEventListener('click', function(e){
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
                                        tree?.addEventListener('change', function(e){
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
                                                cb.checked = true; cb.indeterminate = false;
                                                cb.closest('.node-row')?.classList.add('selected');
                                            });
                                            // при глобальном выборе предки и так станут "selected" в updateAncestors
                                            tree?.querySelectorAll('li[data-node]').forEach(li => updateAncestors(li));
                                            if (showOnlySelectedToggle?.checked) applyShowOnlySelected(true);
                                        });

                                        document.getElementById('clearAll')?.addEventListener('click', () => {
                                            tree?.querySelectorAll('input[name="category_id[]"]').forEach(cb => {
                                                cb.checked = false; cb.indeterminate = false;
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
                                                    if (icon) { icon.classList.remove('fa-plus'); icon.classList.add('fa-minus'); }
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
                                            { name: 'iframe', attributes: true, classes: true, styles: true },
                                            { name: 'figure', classes: 'media', attributes: true, styles: true },
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

                        @csrf
                        <button class="more">Send request</button>
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
