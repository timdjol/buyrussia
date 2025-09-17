@php
    /** @var \App\Models\Category $cat */
    $hasChildren = $cat->children->isNotEmpty();
    $pad = $level * 16; // px
@endphp

<li class="cat-node" data-id="{{ $cat->id }}">
    <div class="node-row" style="padding-left: {{ $pad }}px">
        {{-- Toggler --}}
        @if($hasChildren)
            <button type="button"
                    class="toggle"
                    aria-expanded="false"
                    aria-controls="children-{{ $cat->id }}"
                    data-target="children-{{ $cat->id }}">
                <i class="fa-solid fa-plus"></i>
            </button>
        @else
            <span class="toggle placeholder">
                <i class="fa-solid fa-circle"></i>
            </span>
        @endif

        <div class="title">
            {{ $cat->id }}
        </div>

        {{-- Image --}}
        <div class="thumb">
            @isset($cat->image)
                <img src="{{ Storage::url($cat->image) }}" alt="">
            @else
                <img src="data:image/svg+xml;utf8,
                    <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 160 80'>
                        <rect width='160' height='80' fill='%23f2f2f2'/>
                        <text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' fill='%23999' font-size='12'>no image</text>
                    </svg>">
            @endisset
        </div>

        {{-- Title --}}
        <div class="title">
            {{ $cat->title }}
            @if($hasChildren)
                <span class="muted">({{ $cat->children->count() }})</span>
            @endif
        </div>

        {{-- Actions --}}
        <div class="actions">
            <form action="{{ route('categories.destroy', $cat) }}" method="post" class="d-inline">
                <a class="btn edit" href="{{ route('categories.edit', $cat) }}">
                    <i class="fa-regular fa-pen-to-square"></i>
                </a>
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Do you want to delete this?');" class="btn delete">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
    </div>

    {{-- Children --}}
    @if($hasChildren)
        <ul id="children-{{ $cat->id }}" class="children" hidden>
            @foreach($cat->children->sortBy('title') as $child)
                @include('auth.categories.node', ['cat' => $child, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif
</li>
