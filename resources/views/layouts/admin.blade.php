<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Booknd') }}</title>
    
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome-4.7.0/css/font-awesome.min.css') }}" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet/less" type="text/css" href="{{ asset('less/app.less') }}" />
    <script src="{{ asset('less/less.js') }}" type="text/javascript"></script>
    
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
</head>
<body>
    
    {{-- Login / Register modal --}}
    @if(Auth::guest())
    <div id="login-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="login-message col-xs-8 col-md-offset-2"></div>
                    </div>
                    @component('components/login-reg')
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
    @endif
    
    
    {{-- Review modal --}}
    @if(Auth::check())
    <div id="review-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">Reviewing <span class="review-book-title"></span></h5>
                </div>
                <div class="modal-body">
                    <div id="review-error" class="alert alert-danger"></div>
                    <div id="review-success" class="alert alert-success"></div>
                    <form id="book-review-form" method="post" action="{{ url('/search') }}">
                          {{ csrf_field() }}
                          <input type="hidden" id="book-review-rating" name="book-review-rating" />
                          <input type="hidden" id="book-review-book" name="book-review-book" />
                          <div id="book-review-stars-selector">
                              <span class="star" data-rating="1"><i class="fa fa-star"></i></span>
                              <span class="star" data-rating="2"><i class="fa fa-star"></i></span>
                              <span class="star" data-rating="3"><i class="fa fa-star"></i></span>
                              <span class="star" data-rating="4"><i class="fa fa-star"></i></span>
                              <span class="star" data-rating="5"><i class="fa fa-star"></i></span>
                          </div>
                          <div class="form-group">
                              <textarea placeholder="Review this book..." class="form-control" id="book-review-text" name="book-review-text" rows="7"></textarea>
                          </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="book-review-save">Save Review</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endif
    
    <div id="app">
        
        <div id="book_messages" class="fixed"></div>
        
        <!-- top bar / nav -->
        <div id="top-bar" class="container-fluid padding-none bg-teal">
            <div class="site-contain clearfix">
                
                <!-- site nav -->
                <nav class="navbar navbar-static-top">
                    <div class="navbar-header">
                        
                        @if(Auth::check())
                        <div id="mobile-user-controls" class="pull-right">
                            <div class="user-avatar-mobile nav-avatar">
                                <a href="{{url('/dashboard/')}}">
                                @isset(Auth::user()->avatar)
                                <img class="img-responsive" src="{{Auth::user()->avatar}}" />
                                @else
                                <img class="img-responsive" src="{{ asset('images/avatars/default-avatar.png') }}" />
                                @endisset
                                </a>
                                @if(count(Auth::user()->unreadNotifications) > 0)
                                <span class="badge mobile-notifications">{{count(Auth::user()->unreadNotifications)}}</span>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        <!-- Collapsed Hamburger -->
                        <button id="nav-toggle" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        
                        <a class="topbar-logo navbar-brand" href="{{ url('/') }}">
                            <img class="img-responsive" id="booknd-logo" src="{{ asset('images/logos/bookmark-logo.png') }}" title="{{ config('app.name', 'Booknd') }}" />
                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul id="page-nav" class="nav navbar-nav">
                            @if (Auth::guest())
                                <li class="login-link mobile-nav-link"><a href="{{ route('login') }}">Login</a></li>
                                <li class="register-link mobile-nav-link"><a href="{{ route('register') }}">Register</a></li>
                                <li class="fb-login-link fb-button-style mobile-nav-link ul-nav-link clearfix"><a href="{{url('/fbredirect')}}" class="pull-right"><i class="fa fa-facebook"></i> Facebook Login</a></li>
                            @else
                                <li class="mobile-nav-link ul-nav-link"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                            @endif
                            <li><a href="{{ url('/about/') }}">About</a></li>
                            <li><a href="{{ url('/blog/') }}">Blog</a></li>
                            <li><a href="{{ url('/search/') }}">Search</a></li>
                            <li><a href="{{ url('/contact/') }}">Contact</a></li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul id="user-nav" class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                                <li class="login-link"><a href="{{ route('login') }}">Login</a></li>
                                <li class="register-link"><a href="{{ route('register') }}">Register</a></li>
                                <li class="fb-login-link fb-button-style"><a href="{{url('/fbredirect')}}"><i class="fa fa-facebook-square"></i> <span>Facebook Login</span></a></li>
                            @else
                                <li class="user-notifications nav-notifications dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <span><i class="fa fa-bell"></i></span>
                                        @if(count(Auth::user()->unreadNotifications) > 0)
                                        <span class="badge">{{count(Auth::user()->unreadNotifications)}}</span>
                                        @endif
                                    </a>
                                    
                                    <ul class="dropdown-menu" role="menu">
                                        @foreach(Auth::user()->unreadNotifications as $notification)
                                            @if($notification->type === 'App\Notifications\FriendRequest')
                                                <li><a class="notification-link" href="{{ url('/user') }}/{{$notification->data['user_id']}}" data-notification="{{$notification->id}}"><i class="fa fa-paper-plane"></i> {{$notification->data['name']}} sent you a friend request</a></li>
                                            @elseif($notification->type === 'App\Notifications\AcceptRequest')
                                                <li><a class="notification-link" href="{{ url('/user') }}/{{$notification->data['user_id']}}" data-notification="{{$notification->id}}"><i class="fa fa-smile-o"></i> {{$notification->data['name']}} accepted your friend request</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="user-avatar-sm nav-avatar">
                                    @isset(Auth::user()->avatar)
                                    <img class="img-responsive" src="{{Auth::user()->avatar}}" />
                                    @else
                                    <img class="img-responsive" src="{{ asset('images/avatars/default-avatar.png') }}" />
                                    @endisset
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <strong>{{ Auth::user()->name }}</strong> <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ url('/dashboard/') }}">Bookshelf</a></li>
                                        @if(Auth::user()->hasRole('admin'))
                                        <li><a href="{{ url('/admin/') }}">Admin Panel</a></li>
                                        @endif
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </nav>
                <!-- // .SITE NAV -->
                
            </div>
        </div>
        <!-- // .TOP BAR -->

        @yield('content')
        
        <!-- Footer -->
        <div id="booknd-footer">
            <div class="footer-books"></div>
            <footer class="footer bg-gray">
                <div class="site-contain">
                    <div class="footer-social text-center">
                        <span class="social-icon fb-icon"><a href="#"><i class="fa fa-facebook-square"></i></a></span>
                        <span class="social-icon twitter-icon"><a href="#"><i class="fa fa-twitter-square"></i></a></span>
                        <span class="social-icon google-icon"><a href="#"><i class="fa fa-google-plus-square"></i></a></span>
                        <span class="social-icon instagram-icon"><a href="#"><i class="fa fa-instagram"></i></a></span>
                    </div>
                    <div class="footer-text text-center">
                        &COPY;@php echo date('Y'); @endphp Booknd &nbsp;-&nbsp; <a href="{{ url('/about/') }}">About</a> &nbsp;&bull;&nbsp; <a href="{{ url('/terms/') }}">Terms &amp; Conditions</a> &nbsp;&bull;&nbsp; <a href="{{ url('/privacy/') }}">Privacy</a> &nbsp;&bull;&nbsp; <a href="{{ url('/blog/') }}">Blog</a> &nbsp;&bull;&nbsp; <a href="{{ url('/contact/') }}">Contact</a>
                    </div>
                </div>
            </footer>
        </div>
        <!-- // .FOOTER -->
        
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace( 'pbody' );
        });
    </script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <script src="{{ asset('js/app.js') }}"></script>
    <meta name="_token" content="{!! csrf_token() !!}" />
    @if (Auth::check())
    <script src="{{ asset('js/dashboard.js') }}"></script>
    @endif
    @if(Auth::guest())
    <script src="{{ asset('js/guest.js') }}"></script>
    
    @if($errors->has('email') || $errors->has('password') || $errors->has('rname') || $errors->has('remail') || $errors->has('rpassword'))
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#login-modal').modal('show');
        });
    </script>
    @endif
    
    @endif
    {{-- Global scripts always available --}}
    <script src="{{ asset('js/booknd.js') }}"></script>
</body>
</html>
