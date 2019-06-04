@extends('layouts.app')

@section('content')

@component('components/bs-header',['title' => 'Bookshelf'])
@endcomponent

<div id="dashboard-main-section" class="page-main">
    
    <div class="page-content bg-gray">
    
        <!-- Main section -->
        <div class="site-contain row">

            <div class="col-md-8 no-pad-small">
                
                @if(count($myBooks))
                <div class="row dashboard-book-covers-display">
                    @for($i = 0; $i < 6; $i++)
                    @isset($myBooks[$i])
                    <div class="col-sm-2 col-xs-4 dashboard-book-single-cover">
                        @isset($myBooks[$i]->image)
                        <a href="{{url('book')}}/{{$myBooks[$i]->id}}">
                        <img class="img-responsive img-thumbnail center-block" src="{{$myBooks[$i]->image}}" />
                        </a>
                        @else
                        <a href="{{url('book')}}/{{$myBooks[$i]->id}}">
                        <div class="dashboard-book-single-cover-placeholder"></div>
                        </a>
                        @endisset
                    </div>
                    @endisset
                    @endfor
                </div>
                @endif
                
                <div class="panel panel-default">
                    <div class="panel-heading dashboard-section-header clearfix"><div class="pull-left"><span class="text-teal"><i class="fa fa-book"></i></span>&nbsp;<span class="text-light">My Bookshelf</span>&nbsp;<span class="extra-info">({{count($myBooks)}} books)</span></div><div class="pull-right"><a class="filter-btn" href="#" data-filter="all">ALL</a> &bull; <a class="filter-btn" href="#" data-filter=".read">READ</a> &bull; <a class="filter-btn" href="#" data-filter=".in">UNREAD</a> &bull; <a class="filter-btn" href="#" data-filter=".reading">READING</a> &bull; <a class="filter-btn" href="#" data-filter=".reviewed">REVIEWED</a></div></div>
                    <div class="panel-body my-bookshelf" id="bookshelf">
                        @if(count($myBooks))
                            @foreach($myBooks as $book)
                                @component('components/book',['class' => 'bookshelf-single-book', 'book' => $book, 'delete' => true])
                                @endcomponent
                            @endforeach
                        @else
                        <div class="text-center">
                            You have no books in your bookshelf.<br /><a href="{{url('/search/')}}">Search our system</a> and start adding some.
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4 no-pad-small">

                @if(count($friendRequests))
                <div class="panel panel-default">
                    <div class="panel-heading dashboard-section-header"><span class="text-blue"><i class="fa fa-user-plus"></i></span>&nbsp;<span class="text-light">Friend Requests</span>&nbsp;<span class="extra-info">({{count($friendRequests)}})</span></div>
                    <div class="panel-body friend-requests">
                        @foreach($friendRequests as $friendRequest)
                        <div id="pending-friend-{{$friendRequest->id}}" class="friend-block friend-request dashboard-user-block clearfix">
                            <a href="{{url('user')}}/{{$friendRequest->user->id}}" class="user-link pull-left">
                                <div class="user-img">
                                    @isset($friendRequest->user->avatar)
                                    <img class="img-responsive" src="{{$friendRequest->user->avatar}}" />
                                    @else
                                    <img class="img-responsive" src="{{asset('images/avatars/default-avatar.png')}}" />
                                    @endisset
                                </div>
                                <div class="user-name">
                                    {{$friendRequest->user->name}}
                                </div>
                            </a>
                            <div class="user-actions pull-right">
                                <a href="#" class="accept-friend-request" data-request="{{$friendRequest->id}}">Accept</a>
                                <span class="link-separator"></span>
                                <a href="#" class="delete-friend-request" data-request="{{$friendRequest->id}}">Delete</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="panel panel-default dashboard-section-header">
                    <div class="panel-heading"><span class="text-blue"><i class="fa fa-users"></i></span>&nbsp;<span class="text-light">My Friends</span>&nbsp;<span class="extra-info">({{count($friends)}})</span></div>
                    <div id="friends" class="panel-body friends">
                        @if(count($friends))
                            @foreach($friends as $friend)
                            <div id="active-friend-{{$friend->id}}" class="friend-block friend-active dashboard-user-block clearfix">
                                <a href="{{url('user')}}/{{$friend->id}}" class="user-link pull-left">
                                    <div class="user-img">
                                        @isset($friend->avatar)
                                        <img class="img-responsive" src="{{$friend->avatar}}" />
                                        @else
                                        <img class="img-responsive" src="{{asset('images/avatars/default-avatar.png')}}" />
                                        @endisset
                                    </div>
                                    <div class="user-name">
                                        {{$friend->name}}
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        @else
                        <div class="text-center no-friends-warning">
                            Oh No! You have no friends! How about <a href="{{url('/search/')}}">Searching for people you know?</a>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="panel panel-default dashboard-section-header">
                    <div class="panel-heading"><span class="text-orange"><i class="fa fa-star"></i></span>&nbsp;<span class="text-light">My Reviews</span>&nbsp;<span class="extra-info">({{count($reviews)}})</span></div>
                    <div id="friends" class="panel-body friends">
                        @if(count($reviews))
                            @foreach($reviews as $review)
                            <div class="review-block review dashboard-review-block" style="margin-bottom: 10px;">
                                <a href="#" class="user_book_review" data-book="{{$review->book->id}}">
                                    <div class="review-book-title margin-none"><strong>{{$review->book->title}}</strong></div>
                                    <div class="review-info">
                                        <div class="text-light review-label">Rating: {{$review->rating}} - </div>
                                        <div class="stars">
                                            <i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>
                                            <div class="user-stars" style="width:{{$review->rating * 20}}%"><i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i>&nbsp;<i class="fa fa-star"></i></div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        @else
                        <div class="text-center">
                            You haven't reviewed any books! How about <a href="{{url('/search/')}}">Searching for a book</a> and telling people what you thought?
                        </div>
                        @endif
                    </div>
                </div>
                
            </div>

        </div>
    
    </div>
    
</div>
@endsection
