@extends('layouts.app')

@section('content')

@component('components/header',['title' => 'Select Your Edition'])
@endcomponent

<!-- main section - search and sidebar -->
<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-8 left-col no-pad-small">
                
                <!-- was there a search? -->
                @isset($results)

                    <div id="search-results" class="search-results">
                       
                        @foreach($results as $book)
                        <div class="book-block">
                            <div class="row">

                                <div class="col-xs-2 book-image-container">
                                    @isset($book['image'])
                                        <img class="img-responsive" src="{{$book['image']}}" />
                                    @else
                                        <img class="img-responsive" src="{{ asset('images/books/book-placeholder.png') }}" />
                                    @endisset
                                </div>

                                <div class="col-xs-10 book-info-container">
                                    <h4>{{$book['title']}}</h4>
                                    <p class="book-author-info">By {{$book['author']}} - published {{$book['year']}}</p>
                                    
                                    <div class="row">
                                        <div class="col-xs-8">
                                            <div class="div-line darker book-block-div"></div>
                                        </div>
                                        <div class="col-xs-4">
                                            <div class="book-tools clearfix">
                                                <a href="{{ url('/add-book') }}?bookid={{$book['olid']}}&single=true" class="openlib_book_add tool btn btn-teal">Select Edition <i class="fa fa-book"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        @endforeach
                        
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
