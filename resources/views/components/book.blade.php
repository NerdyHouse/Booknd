<div class="{{$class}} book-block @isset($book->status) {{$book->status}} @else in @endisset @isset($book->my_review) reviewed @endisset">
    
    {{-- Should only be available from within the dashboard --}}
    @isset($delete)
        @if($delete)
            <a href="#" class="user_book_remove" data-book="{{$book->id}}"><i class="fa fa-remove"></i></a>
        @endif
    @endisset
    
    <div class="row">
        <div class="col-xs-2 book-image-container">
        {{-- image --}}
            <a href="{{url('book')}}/{{$book->id}}">
                @empty($book->image)
                <img class="img-responsive center-block" src="{{ asset('images/books/book-placeholder.png') }}" />
                @else
                <img class="img-responsive center-block" src="{{ $book->image }}" />
                @endempty
            </a>
        </div>
        
        <div class="col-xs-10 book-info-container">
            <a href="{{url('book')}}/{{$book->id}}">
                <h4 class="text-default">{{$book->title}}</h4>
            </a>
            <p class="book-author-info">
                @isset($book->author->id)
                by <a href="{{url('/author/')}}/{{$book->author->id}}">{{$book->author->name}}</a>
                @endisset
                - published {{$book->publish}}
            </p>

            <div class="row">
                <div class="col-xs-8 reviews-info-wrapper">
                    <div class="reviews-info">
                        <div class="stars">
                            <i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>
                            <div class="user-stars" style="width:{{$book->reviews->avg('rating') * 20}}%"><i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i></div>
                        </div>
                        <p class="reviews-text">
                        {{$book->reviews->avg('rating')}} average rating
                        </p><br />
                        <p class="reviews-text line-2">
                        {{$book->reviews->count()}} users have reviewed &bull; {{count($book->bookshelfs)}} users have in bookshelf
                        </p>
                    </div>
                    <div class="div-line darker book-block-div"></div>
                    <div class="sharing-tools">
                        <p class="sharing-label">Share:&nbsp;</p>
                        <div class="sharing-icons">
                            <a href="{{url('book')}}/{{$book->id}}" class="fb"><i class="fa fa-facebook-square"></i></a>
                            <a href="{{url('book')}}/{{$book->id}}" class="tw"><i class="fa fa-twitter-square"></i></a>
                            <a href="{{url('book')}}/{{$book->id}}" class="gp"><i class="fa fa-google-plus-square"></i></a>
                            <!-- <a href="#" class="ig"><i class="fa fa-instagram"></i></a> -->
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-4 book-tools-wrapper">
                    
                    <div class="book-tools clearfix">
                        
                    @if(Auth::check())
                        {{-- Handle the bookshelf tools --}}
                        @isset($book->status)
                            @component('components/bsswitch',['id' => $book->id, 'status' => $book->status])
                            @endcomponent
                        @else
                            <a href="#" class="user_book_add tool btn btn-teal" data-book="{{$book->id}}">Add to Shelf <i class="fa fa-book"></i></a>
                        @endif

                        <a href="http://www.amazon.com/dp/{{$book['isbn10']}}/?tag=bookndapp-20" class="user_book_buy tool btn btn-dark-teal" target="_blank">Buy Book <i class="fa fa-caret-right"></i></a>

                        {{-- Handle the review tools --}}
                        @isset($book->my_review)
                        <div class="pull-right">
                        <a href="#" class="user_book_review" data-book="{{$book->id}}">
                            <span class="label">Your Rating:</span>
                            <div class="stars">
                                <i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>
                                <div class="user-stars" style="width:{{$book->my_review->rating * 20}}%"><i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i></div>
                            </div>
                        </a>
                        </div>
                        @else
                            <a href="#" class="user_book_review tool btn btn-blue" data-book="{{$book->id}}">Review Book <i class="fa fa-caret-right"></i></a>
                        @endisset

                    @else
                        {{-- If the user is not logged in we do this --}}
                        <a href="#" class="user_book_add guest btn btn-teal tool" data-book="{{$book->id}}">Add to Shelf <i class="fa fa-book"></i></a>
                        <a href="http://www.amazon.com/dp/{{$book['isbn10']}}/?tag=bookndapp-20" class="user_book_buy guest btn btn-dark-teal tool" target="_blank">Buy Book<i class="fa fa-caret-right"></i></a>
                        <a href="#" class="user_book_review guest btn btn-blue tool">Review Book <i class="fa fa-caret-right"></i></a>
                    @endif
                    </div>
                    
                </div>
         
            </div>
        </div>
    </div>
</div>