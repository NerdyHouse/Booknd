@extends('layouts.app')

@section('content')

@component('components/header',['title' => 'About'])
@endcomponent

<!-- main section - search and sidebar -->
<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-8 left-col no-pad-small">

                <h3>Who Are We?</h3>
                <div style="padding-bottom: 30px;">
                    <p>Welcome, BookndApp is the virtual bookshelf on the web that connects friends, networks, and people across the board on what’s being read. Think about a time when you visit a friend’s apartment or home for the first time when you go into their living room and see a bookshelf. While waiting if you are anything like the bookndapp network you walk over and browse what they are reading to get a preview of their interests.</p>
                    <p>This is where BookndApp was born to bring this interest on the web. Now you can see all the books your friends are reading and browse along with reading reviews on their favorite books. This allows us all to find our next read, expand to new genres or just get to know your friends on a more intellectual level. With BookndApp you can share your reading habits, review your favorite books and also with a click of the mouse share and recommend a book you finished and loved.</p>
                    <p>
                    <a class="register-link" href="{{url('register')}}">Sign up and join the BookndApp network</a> and add your favorite books! Welcome and excited to see what your next book will be!
                    </p>
                </div>
                
                <h3>Why Booknd&hellip; App</h3>
                <div style="padding-bottom: 30px;">
                    <p>
                    Our vision is to eventually build on this website and build an app which our booknd community can use from the convenience of their mobile phone.
                    </p>
                </div>
                
                <h3>Why is it Free?</h3>
                <div>
                    <p>
                    BookndApp is supported through revenues generated from Amazon Affiliate links and any marketing done on our site. Amazon Affiliate links cost you nothing and don’t change the price of items bought through Amazon. Lastly, we will never share our user’s information. Any emails you may receive from us are from us and not a 3 rd party.
                    </p>
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
