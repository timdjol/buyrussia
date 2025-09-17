@php($pad = str_repeat('— ', $level))
<label class="checkbox-item">
    <input type="checkbox" name="category_id[]"
           value="{{ $cat->id }}" {{ in_array($cat->id, $selected, true) ? 'checked' : '' }}>
    <span>{{ $pad }}{{ $cat->title }}</span>
</label>
@if($cat->children->isNotEmpty())
    @foreach($cat->children as $child)
        @include('auth.posts.checkbox', ['cat' => $child, 'level' => $level + 1, 'selected' => $selected])
    @endforeach
@endif
