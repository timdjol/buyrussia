@php
    /** @var \App\Models\Category $cat */
    $hasChildren = $cat->children->isNotEmpty();
    $pad = $level * 16; // px
    $inputId = 'cat-'.$cat->id;
@endphp

<li class="cat-node" data-node="{{ $cat->id }}">
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
            <span class="toggle placeholder"><i class="fa-solid fa-circle"></i></span>
        @endif

        {{-- Checkbox + title --}}
        <label class="checkbox-label" for="{{ $inputId }}">
            <input type="checkbox" name="category_id[]" value="{{ $cat->id }}"
                {{ in_array($cat->id, $selected ?? [], true) ? 'checked' : '' }}>

            <span>{{ $cat->title }}</span>
            @if($hasChildren)
                <span class="text-muted">({{ $cat->children->count() }})</span>
            @endif
        </label>
    </div>

    {{-- Children --}}
    @if($hasChildren)
        <ul id="children-{{ $cat->id }}" class="children" hidden>
            @foreach($cat->children->sortBy('title') as $child)
                @include('auth.posts.cat_node', ['cat' => $child, 'level' => $level + 1, 'selected' => $selected])
            @endforeach
        </ul>
    @endif
</li>
