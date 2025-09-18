@php
    /** @var \Illuminate\Database\Eloquent\Model $cat */
    $level   = $level ?? 0;
    $pad     = $level * 16;
    $inputId = 'cat-'.$cat->id;

    $hasChildren = $cat->children->isNotEmpty();

    // НОРМАЛИЗАЦИЯ ВХОДОВ
    $selectedList = is_array($selected ?? null) ? array_map('intval', $selected) : [];
    $selId        = isset($selectedCategoryId) ? (int) $selectedCategoryId : null;
    $single       = !is_null($selId); // true => radio (one-to-many), false => checkbox[] (many-to-many)

    $isChecked = $single
        ? ($selId === (int) $cat->id)
        : in_array((int) $cat->id, $selectedList, true);
@endphp

<li class="cat-node" data-node="{{ $cat->id }}">
    <div class="node-row" style="padding-left: {{ $pad }}px">
        @if($hasChildren)
            <button type="button" class="toggle" aria-expanded="false"
                    aria-controls="children-{{ $cat->id }}" data-target="children-{{ $cat->id }}">
                <i class="fa-solid fa-plus"></i>
            </button>
        @else
            <span class="toggle placeholder"><i class="fa-solid fa-circle"></i></span>
        @endif

        <label class="checkbox-label" for="{{ $inputId }}">
            @if($single)
                <input id="{{ $inputId }}" type="checkbox" name="category_id"
                       value="{{ $cat->id }}" {{ $isChecked ? 'checked' : '' }}>
            @else
                <input id="{{ $inputId }}" type="checkbox" name="category_id[]"
                       value="{{ $cat->id }}" {{ $isChecked ? 'checked' : '' }}>
            @endif
            <span>{{ $cat->title }}</span>
            @if($hasChildren)
                <span class="text-muted">({{ $cat->children->count() }})</span>
            @endif
        </label>
    </div>

    @if($hasChildren)
        <ul id="children-{{ $cat->id }}" class="children" hidden>
            @foreach($cat->children->sortBy('title') as $child)
                @include('auth.posts.cat_node', [
                    'cat' => $child,
                    'level' => $level + 1,
                    'selected' => $selectedList,
                    'selectedCategoryId' => $selId,
                ])
            @endforeach
        </ul>
    @endif
</li>
