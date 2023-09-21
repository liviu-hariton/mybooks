<nav class="nav nav-pills nav-fill mb-5">
    @foreach($filters as $key => $label)
        <a class="nav-link {{ request('filter') == $key ? 'active' : '' }}" aria-current="page" href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}">{{ $label }}</a>
    @endforeach
</nav>
