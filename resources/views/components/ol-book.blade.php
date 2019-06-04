<div class="{{$class}} book-block">
    <div class="row">

        <div class="col-xs-2 book-image-container">
            @isset($book['cover_i'])
                <img class="img-responsive center-block" src="https://covers.openlibrary.org/b/id/{{$book['cover_i']}}-M.jpg" />
            @else
                <img class="img-responsive center-block" src="{{ asset('images/books/book-placeholder.png') }}" />
            @endisset
        </div>

        <div class="col-xs-10 book-info-container">
            <h4>@isset($book['title_suggest']){{$book['title_suggest']}}@endisset</h4>
            <p class="book-author-info">
            @isset($book['author_name'])
                @if(is_array($book['author_name']))
                    By&nbsp;
                    @foreach($book['author_name'] as $authorName)
                        {{$authorName}},&nbsp;
                    @endforeach
                @else
                    By {{$book['author_name']}}
                @endif
            @endisset
            @isset($book['first_publish_year'])
                &nbsp; - first published {{$book['first_publish_year']}}
            @endisset
            </p>

            <div class="row">

                <div class="col-xs-8 reviews-info-wrapper">
                    <div class="reviews-info">
                        <p class="reviews-text">
                            There are 0 Booknd reviews for this title
                        </p>
                        <br />
                        <p class="reviews-text line-2">
                            0 friends have reviewed &bull; 0 friends have in bookshelf
                        </p>
                    </div>
                    <div class="div-line darker book-block-div"></div>
                </div>

                <div class="col-xs-4 book-tools-wrapper">
                    <div class="book-tools clearfix">
                        <a href="{{ url('/add-book') }}?bookid={{str_replace('/works/','',$book['key'])}}" class="openlib_book_add tool btn btn-teal">Add to Shelf <i class="fa fa-book"></i></a>
                        <a href="http://www.amazon.com/dp/{{App\Library\Helpers::isbn13_to_10($book['isbn'][0])}}/?tag=bookndapp-20" class="openlib_book_buy tool btn btn-dark-teal" target="_blank">Buy Book <i class="fa fa-caret-right"></i></a>
                    </div>
                </div>

            </div>

        </div>


    </div>
</div>