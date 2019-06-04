@extends('layouts.app')

@section('content')

<!-- search section -->
<div id="search-header" class="bg-book">
    <div class="site-contain row padding-none">
        <div class="col-md-8">
            <h1 class="margin-none slab">Search Results</h1>
            @isset($query)
                <p class="header-subheader">Search Criteria: &ldquo;{{$query}}&rdquo;</p>
            @else
                <p class="header-subheader">Search our database!</p>
            @endisset
            <div id="book-search">
                @include('components/search')
            </div>
            <p class="header-search-addon-text">
                <!-- <i class="fa fa-caret-right text-blue"></i> Don't see what you're looking for? <a class="text-blue add-book" href="{{ url('/add-book') }}">Add a book to our system!</a>
            -->
            </p>
        </div>
    </div>
</div>

<!-- main section - search and sidebar -->
<div id="search-main-section" class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-8 left-col no-pad-small">

                <!-- was there a search? -->
                @isset($results)

                    <!-- did the search have results? -->
                    @empty($results)
                        <div id="search-results" class="search-results no-results text-center">
                        No Results Matched Your Search.<br />
                        Try <a class="add-book" href="{{ url('/add-book') }}">Adding a Book</a>!
                        </div>
                    @else

                    <div id="search-results" class="search-results">

                        <!-- Output tabbing -->
                        <ul class="search-result-tabs" role="tablist">
                            @foreach($results as $type => $collection)
                            <li role="presentation" @if($loop->first) class="active" @endif >
                                <a class="{{$type}}-tab-link" href="#{{$type}}-results" aria-controls="{{$type}}-results" role="tab" data-toggle="tab"><span>{{ucfirst($type)}}</span></a>
                            </li>
                            @endforeach
                        </ul>

                        <!-- output results -->
                        <div class="tab-content">

                        <!-- output books -->
                        @isset($results['books'])
                            <div role="tabpanel" class="tab-pane active" id="books-results">
                                {{-- results count output --}}
                                @if(isset($results['books']['total_count']))
                                    <div class="text-light">Found {{$results['books']['total_count']}} Books</div>
                                @endif
                                
                                {{-- Books from the local DB --}}
                                @isset($results['books']['local'])
                                    @foreach($results['books']['local'] as $book)
                                        @component('components/book',['class' => 'search-single-book', 'book' => $book])
                                        @endcomponent
                                    @endforeach
                                @endisset
                                
                                {{-- Books from openlib --}}
                                @isset($results['books']['openlib'])
                                    @foreach($results['books']['openlib']['docs'] as $book)
                                        @component('components/ol-book',['class' => 'search-single-book', 'book' => $book])
                                        @endcomponent
                                    @endforeach
                                @endisset
                                
                                {{-- handle paginating books --}}
                                @if(isset($results['books']['pages']))
                                @if($results['books']['pages'] > $results['books']['current_page'])
                                    <form method="post" action="{{ url('/search') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{$query}}" name="search_query" />
                                        <input type="hidden" value="{{$results['books']['current_page']}}" name="book_page" />
                                        @if($searchfor)
                                            @if(in_array('title',$searchfor))
                                                <input type="hidden" value="title" name="search_for[]" />
                                            @elseif(in_array('isbn',$searchfor))
                                                <input type="hidden" value="isbn" name="search_for[]" />
                                            @elseif(in_array('bauthor',$searchfor))
                                                <input type="hidden" value="bauthor" name="search_for[]" />
                                            @endif
                                        @endif
                                        <button style="width: 100%;" type="submit" class="btn btn-blue btn-lg text-center">More Books <i class="fa fa-caret-right"></i></button>
                                    </form>
                                @endif
                                @endif
                                
                            </div>
                        @endisset

                        <!-- output authors -->
                        @isset($results['authors'])
                        
                                @isset($results['books'])
                                    <div role="tabpanel" class="tab-pane" id="authors-results">
                                @else
                                    <div role="tabpanel" class="tab-pane active" id="authors-results">
                                @endif
                                <div class="text-light">Found {{count($results['authors'])}} Authors</div>
                                @foreach($results['authors'] as $author)
                                    @component('components/author',['author' => $author])
                                    @endcomponent
                                @endforeach
                            </div>
                        @endisset

                        <!-- output users -->
                        @isset($results['users'])
                        
                                @if(isset($results['books']) || isset($results['authors']))
                                    <div role="tabpanel" class="tab-pane" id="users-results">
                                @else
                                    <div role="tabpanel" class="tab-pane active" id="users-results">
                                @endif
                                <div class="text-light">Found {{count($results['users'])}} Users</div>
                                @foreach($results['users'] as $user)
                                    <div class="search-single-user user-block clearfix">
                                        <a class="user-link pull-left clearfix" href="{{url('/user/')}}/{{$user->id}}">
                                            <div class="user-img pull-left">
                                                @isset($user['avatar'])
                                                <img class="img-responsive" src="{{$user['avatar']}}" />
                                                @else
                                                <img class="img-responsive" src="{{ asset('images/avatars/default-avatar.png') }}" />
                                                @endisset
                                            </div>
                                            <div class="user-info pull-left">
                                                <h4 class="user-name margin-none">{{$user->name}}</h4>
                                                <p class="user-stats">
                                                    {{count($user->books)}} books in bookshelf - {{count($user->reviews)}} reviews on Booknd
                                                </p>
                                            </div>
                                        </a>
                                        @if(Auth::check())
                                        @if(Auth::id() !== $user->id)
                                            @isset($user['status'])
                                                @if($user['status'] === 'pending')
                                                <div class="pull-right">
                                                    <span class="friend-request-sent">Request Pending <i class="fa fa-check-circle-o"></i></span>
                                                </div>
                                                @else($user['status'] === 'active')
                                                <div class="pull-right">
                                                    <span class="friend-request-sent">You are friends <i class="fa fa-check-circle-o"></i></span>
                                                </div>
                                                @endif
                                            @else
                                            <div class="pull-right">
                                                <a href="#" class="user-friend-request btn btn-blue tool" data-user="{{$user->id}}">Send Friend Request<span class="working">&nbsp;<i class="fa fa-spinner fa-spin"></i></span></a>
                                            </div>
                                            @endisset
                                        @endif
                                        @endif
                                    </div>
                                    
                                @endforeach
                            </div>
                        @endisset

                        </div>

                    </div>

                    @endempty

                @else
                    <div id="search-results" class="search-results no-query text-center">
                        Search our database
                    </div>
                @endisset
            </div>

            <!-- right col -->
            <div class="col-md-4 no-pad-small">
                @include('components/catbox')
            </div>

        </div>
    </div>
</div>

@endsection
