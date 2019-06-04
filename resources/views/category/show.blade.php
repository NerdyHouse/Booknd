@extends('layouts.app')

@section('content')

@component('components/header',['title' => $category->name.' Books'])
@endcomponent

<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">
        
            <div class="col-md-8 left-col">
                
                <div class="books-list">
                    
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
                
                </div>
                
            </div>

            <div class="col-md-4">
                @include('components/catbox')
            </div>
            
        </div>
    </div>
</div>
@endsection
