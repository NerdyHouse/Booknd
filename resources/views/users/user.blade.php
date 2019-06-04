@extends('layouts.app')

@section('content')

@component('components/header',['title' => $user->name])
@endcomponent

<div id="dashboard-main-section" class="page-main">
    
    <div class="page-content bg-gray">
    
        <!-- Main section -->
        <div class="site-contain row">
            
            <div class="col-md-4 col-md-push-8 no-pad-small">

                <div class="user-profile-info bg-box">
                    <div class="row">
                        <div class="col-xs-4 user-image">
                            @isset($user->avatar)
                            <img class="img-responsive" src="{{$user->avatar}}" />
                            @else
                            <img class="img-responsive" src="{{asset('images/avatars/default-avatar.png')}}" />
                            @endisset
                        </div>
                        <div class="col-xs-8 user-info">
                            <h4 class="text-light">{{$user->name}}</h4>
                            <p class="user-stats">User since {{date('F, Y',strtotime($user->created_at))}}</p>
                            <div class="div-line"></div>
                            <div class="user-actions">
                                @if($status['friends'])
                                    @if($status['status'] === 'pending')
                                        <span class="friend-request-sent">Request Pending <i class="fa fa-check-circle-o"></i></span>
                                    @else($status['status'] === 'active')
                                        <span class="friend-request-sent">You are friends <i class="fa fa-check-circle-o"></i></span>
                                    @endif
                                @else
                                    <a href="#" class="user-friend-request btn btn-blue tool" data-user="{{$user->id}}">Send Friend Request<span class="working">&nbsp;<i class="fa fa-spinner fa-spin"></i></span></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <div class="col-md-8 col-md-pull-4 no-pad-small">
                
                <div class="panel panel-default">
                    <div class="panel-heading dashboard-section-header clearfix"><div class="pull-left"><span class="text-teal"><i class="fa fa-book"></i></span>&nbsp;<span class="text-light">{{$user->name}}'s Bookshelf</span>&nbsp;<span class="extra-info">({{count($books)}} books)</span></div><div class="pull-right"><a class="filter-btn" href="#" data-filter="all">ALL</a> &bull; <a class="filter-btn" href="#" data-filter=".read">READ</a> &bull; <a class="filter-btn" href="#" data-filter=".in">UNREAD</a> &bull; <a class="filter-btn" href="#" data-filter=".reading">READING</a> &bull; <a class="filter-btn" href="#" data-filter=".reviewed">REVIEWED</a></div></div>
                    <div class="panel-body my-bookshelf" id="bookshelf">
                        @if(count($books))
                            @foreach($books as $book)
                                @component('components/book',['class' => 'bookshelf-single-book', 'book' => $book])
                                @endcomponent
                            @endforeach
                        @else
                        <div class="text-center">
                            {{$user->name}} has no books in their bookshelf.
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    
    </div>
    
</div>
@endsection
