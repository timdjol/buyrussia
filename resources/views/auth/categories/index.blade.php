@extends('auth.layouts.master')

@section('title', 'Categories')

@section('content')
    <div class="admin">
        <div class="container">
            <div class="row">
                <div class="col-md-2">@include('auth.layouts.sidebar')</div>
                <div class="col-md-10">
                    <div class="row aic mb-3">
                        <div class="col-md-8"><h1>Categories</h1></div>
                        <div class="col-md-4 d-flex gap-2 justify-content-end">
{{--                            <button type="button" class="btn btn-outline-secondary btn-sm" id="expandAll">Expand all</button>--}}
{{--                            <button type="button" class="btn btn-outline-secondary btn-sm" id="collapseAll">Collapse all</button>--}}
                            <a class="btn add" href="{{ route('categories.create') }}">
                                <i class="fa-solid fa-plus"></i> Add
                            </a>
                        </div>
                    </div>

                    @if($roots->isNotEmpty())
                        <ul class="cat-tree list-unstyled">
                            @foreach($roots as $cat)
                                @include('auth.categories.node', ['cat' => $cat, 'level' => 0])
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-danger">Categories not found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .cat-tree { padding-left: 0; }
        .cat-node { margin: 0; display: block}
        .node-row {
            display: flex;
            grid-template-columns: 28px 160px 1fr auto; /* toggle | image | title | actions */
            gap: 12px;
            align-items: center;
            padding: 8px 10px;
            border-bottom: 1px solid #eaeaea;
            background: #fff;
        }
        .node-row .title { font-weight: 500; }
        .node-row .muted { color: #888; }
        .toggle, .toggle.placeholder {
            width: 28px; height: 28px;
            display: inline-flex; align-items: center; justify-content: center;
            border: none; background: transparent; cursor: pointer; padding: 0;
        }
        .toggle.placeholder { cursor: default; opacity: 0.35; }
        .thumb img {
            width: 100%; max-width: 140px; height: 70px; object-fit: cover; border-radius: 6px;
            background: #f7f7f7;
        }
        .children { margin: 0; padding-left: 0; }
        .admin a.edit{
            padding: 7px 10px;
            margin-right: 5px;
        }
    </style>

    <script>
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
        document.getElementById('expandAll')?.addEventListener('click', () => setAll(true));
        document.getElementById('collapseAll')?.addEventListener('click', () => setAll(false));
    </script>
@endsection
