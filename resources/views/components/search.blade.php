<form class="book-search-form" method="post" action="{{ url('/search') }}">
    {{ csrf_field() }}
    <div class="input-group input-group-lg">
        <input type="text" class="form-control search-query" value="@isset($query){{$query}}@endisset" name="search_query" placeholder="Search by title, author, isbn or Booknd user">
        <span class="input-group-btn">
            <button class="btn btn-default btn-orange" type="submit"><i class="fa fa-book"></i> SEARCH</button>
        </span>
    </div>
    <div class="input-group search-filters text-light">
        <span>Search for:&nbsp;&nbsp;</span>
        <label class="checkbox-inline">
            <input type="checkbox" name="search_for[]" value="title" checked="checked">title
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="search_for[]" value="isbn">ISBN
        </label>
        {{-- <label class="checkbox-inline">
            <input type="checkbox" name="search_for[]" value="bauthor">book author
        </label> --}}
        <label class="checkbox-inline">
            <input type="checkbox" name="search_for[]" value="author">authors
        </label>
        <label class="checkbox-inline">
            <input type="checkbox" name="search_for[]" value="user">users
        </label>
    </div>
</form>