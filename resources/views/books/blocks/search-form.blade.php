<div class="row mt-5">
    <div class="col-12">
        <form method="GET" name="f-search" id="f-search" action="{{ route('books.index') }}">
            @if(request('filter'))
                <input type="hidden" name="filter" value="{{ request('filter') }}">
            @endif

            <div class="input-group mb-3">
                <input type="text" name="title" id="src-title" value="{{ request('title') }}" class="form-control form-control-lg" placeholder="Search a book by title" aria-label="Search a book by title" aria-describedby="go-search">
                <button class="btn btn-secondary" type="submit" id="go-search">Go</button>
                <span class="input-group-text"><a href="{{ route('books.index') }}" class="text-warning-emphasis"><i class="fa fa-refresh"></i></a></span>
            </div>
        </form>
    </div>
</div>
