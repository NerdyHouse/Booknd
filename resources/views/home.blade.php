@extends('layouts.app')

@section('content')

<!-- search section -->
<div id="home-search-section" class="bg-book text-center">
    <div class="site-contain">
        <h1 class="big-style margin-none text-blue">Millions of Books!</h1>
        <h2 class="big-style-sub margin-none text-blue">Search books, get recommendations, get reading</h2>
        <div id="home-book-search">
            @include('components/search')
        </div>
    </div>
</div>

<!-- mid section -->
<div id="home-mid-section" class="bg-gray">
    <div class="site-contain row">
        <div class="col-md-8 left-col">
            <h3>Finding a Good Book<br />Has Never Been Easier</h3>
            <p>By creating your <a href="{{ route('register') }}" class="register-link">FREE account</a>, you will be able to keep track of what you have read and what you want to read later, make friends and write reviews. Our system will recommend books based on you and your Booknd friends' reading tastes which you can easily purchase through direct links. The more you use our free service, the better the recommendations will get so you will never have to hunt for a good book again.</p>
            
            <div class="button-group">
                @if(Auth::guest())
                <a class="btn btn-default btn-blue btn-lg fb-button-style-large" href="{{url('/fbredirect')}}"><i class="fa fa-facebook-square"></i> <span>Login with Facebook</span></a><br />
                <a class="btn btn-default btn-blue btn-lg register-link" href="{{ route('register') }}">Sign up with email <i class="fa fa-angle-double-right"></i></a>
                @else
                <a class="btn btn-default btn-blue btn-lg" href="{{ route('dashboard') }}">My Bookshelf <i class="fa fa-angle-double-right"></i></a>
                @endif
            </div>
            
        </div>
        <div class="col-md-4 right-col">
            @include('components/catbox')
        </div>
    </div>
</div>

<!-- review Section / carousel -->
<div id="home-reviews-section">
    <div id="reviews-carousel" class="carousel slide" data-ride="carousel" data-interval="6000">
        <div class="reviews bg-library">
            
            <!-- reviews -->
            <div class="carousel-inner" role="listbox">
                
                @for($i = 0; $i < count($recentReviews); $i++)
                    <div class="item @if($i === 0) active @endif ">
                        <div class="row">
                            <div class="col-sm-2 review-book-img">
                                @isset($recentReviews[$i]->book->image)
                                <img class="img-responsive center-block" src="{{$recentReviews[$i]->book->image}}" />
                                @else
                                <img class="img-responsive center-block" src="{{asset('images/books/book-placeholder.png')}}" />
                                @endisset
                            </div>
                            <div class="col-sm-10 review-info clearfix">
                                <div class="pull-left stars-user clearfix">
                                    <div class="stars">
                                        <i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>
                                        <div class="user-stars" style="width:{{$recentReviews[$i]->rating * 20}}%"><i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i></div>
                                    </div>
                                    <div class="user-info">
                                        &nbsp;&nbsp;&nbsp;<i class="fa fa-user"></i> {{$recentReviews[$i]->user->name}}
                                    </div>
                                </div>
                                <div class="pull-left review">
                                    <p>&ldquo;{{str_limit($recentReviews[$i]->review,210,'...')}}&rdquo;</p>
                                    <a class="review-read-more-link text-blue" href="{{url('book')}}/{{$recentReviews[$i]->book->id}}">READ MORE <i class="fa fa-angle-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
                
            </div>
            
            <!-- Arrow Controls -->
            <a class="left carousel-control" href="#reviews-carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>
            </a>
            <a class="right carousel-control" href="#reviews-carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
            </a>
            
        </div>
        
        <!-- controls -->
        <div class="controls bg-blue">
            <ol class="carousel-indicators">
                @for($i = 0; $i < count($recentReviews); $i++)
                    <li data-target="#reviews-carousel" data-slide-to="{{$i}}" @if($i === 0) class="active" @endif></li>
                @endfor
            </ol>
        </div>
    </div>
</div>

<!-- bottom section -->
<div id="home-bottom-section">
    <div class="site-contain row">
        <div class="col-md-8 col-sm-12">
            <h3>New Books For Sale</h3>
            <p>
                Buy books at the best possible prices directly through Amazon!<br />
                Here are some recent titles to get you started...
            </p>
            
            <div id="home-books-slider" class="bg-gray">
                @foreach($recentBooks as $book)
                    @if($loop->index === 0)
                        <div class="row">
                    @endif
                    @if($loop->index === 6)
                        </div>
                    <div class="row">
                    @endif
                    <div class="col-sm-2 col-xs-4 home-sale-book">
                        <div class="home-sale-book-image">
                            @empty($book->image)
                                <img class="img-responsive center-block" src="{{ asset('images/books/book-placeholder.png') }}" />
                            @else
                                <img class="img-responsive center-block" src="{{ $book->image }}" />
                            @endempty
                        </div>
                        <div class="text-center">
                            <div class="home-sale-book-stars">
                                <i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>
                                <div class="user-stars" style="width:{{$book->reviews->avg('rating') * 20}}%"><i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i></div>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="http://www.amazon.com/dp/{{$book['isbn10']}}/?tag=bookndapp-20" class="home-sale-book-buy" target="_blank">Buy Now</a>
                        </div>
                    </div>
                @endforeach
                    </div>
            </div>
        </div>
        
        <div class="col-md-4 col-sm-12">
            <div id="home-new-authors">
            <h3 class="text-uppercase margin-none">NEW AUTHORS</h3>
            <div class="div-line" style="margin: 10px 0 15px;"></div>
            <div class="home-new-authors-container">
                @foreach($recentAuthors as $author)
                <a href="{{url('author')}}/{{$author->id}}" class="home-new-author bg-box clearfix">
                    <div class="home-new-author-image">
                        @empty($author->image)
                        <img class="img-responsive" src="{{ asset('images/books/book-placeholder.png') }}" />
                        @else
                        <img class="img-responsive" src="{{ $author->image }}" />
                        @endempty
                    </div>
                    <div class="home-new-author-info">
                        <div class="home-new-author-name">
                            {{$author->name}}
                        </div>
                        <div class="home-new-author-books">
                            {{count($author->books)}} Books <i class="fa fa-angle-double-right"></i>
                        </div>
                    </div>
                    <div class="home-new-author-arrow pull-right">
                        <i class="fa fa-angle-double-right"></i>
                    </div>
                </a>
                @endforeach
            </div>
            </div>
        </div>
    </div>
</div>

@endsection
