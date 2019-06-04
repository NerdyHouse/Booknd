@extends('layouts.book')

@section('content')

@component('components/header',['title' => $book->title])
@endcomponent

<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-8 left-col no-pad-small">
                
                {{-- Book info --}}
                
                <div class="book-block">
                
                    <div class="row">
                        <div class="col-xs-2 book-image-container">
                        {{-- image --}}
                            @empty($book->image)
                            <img class="img-responsive center-block" src="{{ asset('images/books/book-placeholder.png') }}" />
                            @else
                            <img class="img-responsive center-block" src="{{ $book->image }}" />
                            @endempty
                        </div>
                        
                        <div class="col-xs-10 book-info-container">
                            <a href="{{url('book')}}/{{$book->id}}">
                                <h4 class="text-default">{{$book->title}}</h4>
                            </a>
                            <p class="book-author-info">
                                by <a href="{{url('/author/')}}/{{$book->author->id}}">{{$book->author->name}}</a> - published {{$book->publish}}<br /><br />
                                <span style="font-weight: 400;">isbn 10: {{$book->isbn10}}</span><br />
                                <span style="font-weight: 400;">isbn 13: {{$book->isbn13}}</span>
                            </p>
                            
                            <div class="row">
                                <div class="col-xs-8 reviews-info-wrapper">
                                    <div class="reviews-info">
                                        <div class="stars">
                                            <i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>
                                            <div class="user-stars" style="width:{{$book->reviews->avg('rating') * 20}}%"><i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i></div>
                                        </div>
                                        <p class="reviews-text">
                                        {{$book->reviews->avg('rating')}} average rating - {{$book->reviews->count()}} total ratings
                                        </p><br />
                                        <p class="reviews-text line-2">
                                        0 friends have reviewed &bull; 0 friends have in bookshelf
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
                
                {{-- Book Reviews --}}
                <div class="row single-book-reviews" style="margin-top: 30px">
                    <div class="col-md-12">
                        
                        <h4>Reviews of {{$book->title}}</h4>
                        <div class="div-line"></div>
                        
                        @if(count($reviews))
                            @foreach($reviews as $review)
                            <div class="single-book-review">
                                <div class="stars-wrapper">
                                    <div class="stars">
                                        <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                        <div class="user-stars" style="width: {{$review->rating * 20}}%;">
                                            <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="single-book-review-user"> - <a href="{{url('user')}}/{{$review->user->id}}">{{$review->user->name}}</a></div>
                                </div>
                                <div>{{$review->review}}</div>
                            </div>
                            @endforeach
                            
                            <div class="results-pagination-links">
                            {{$reviews->links()}}
                            </div>
                        @else
                            <div style="margin-top: 20px">
                                <i class="fa fa-caret-right text-teal"></i> No reviews! <a href="#" data-book="{{$book->id}}" class="user_book_review">Be the first to review this book!</a>
                            </div>
                        @endif
                    </div>
                </div>
                
                
            </div>

            <!-- right col -->
            <div class="col-md-4 no-pad-small">
                @include('components/catbox')
            </div>

        </div>
    </div>
</div>

@endsection