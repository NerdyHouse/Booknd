@extends('layouts.app')

@section('content')

@component('components/header',['title' => 'Books By '.$author->name])
@endcomponent

<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-8 left-col no-pad-small">
                
                <div class="author-info">
                    
                </div>
                
                <div class="author-book-list">
                    
                    @isset($books)
                    
                        <div class="results-pagination-links">
                        {{$books->links()}}
                        </div>
                    
                        @foreach($books as $book)
                            @component('components/book',['class' => 'search-single-book', 'book' => $book])
                            @endcomponent
                        @endforeach
                        
                        <div class="results-pagination-links">
                        {{$books->links()}}
                        </div>
                        
                    @endisset
                    
                </div>
                
            </div>

            <!-- right col -->
            <div class="col-md-4 no-pad-small">
                @include('components/authbox')
            </div>

        </div>
    </div>
</div>

@endsection