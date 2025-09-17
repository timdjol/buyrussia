@php($pad = str_repeat('— ', $level ?? 0))
<tr>
    <td>{{ $cat->id }}</td>
    <td>
        @isset($cat->image)
            <img src="{{ Storage::url($cat->image) }}" width="150">
        @endisset
    </td>
    <td>{{ $pad }}{{ $cat->title }}</td>
    <td>
        <form action="{{ route('categories.destroy', $cat) }}" method="post">
            <ul>
                <li>
                    <a class="btn edit" href="{{ route('categories.edit', $cat) }}">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                </li>
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Do you want to delete this?');" class="btn delete">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </ul>
        </form>
    </td>
</tr>

@if($cat->children->isNotEmpty())
    @foreach($cat->children->sortBy('title') as $child)
        @include('auth.categories.row', ['cat' => $child, 'level' => ($level ?? 0) + 1])
    @endforeach
@endif
