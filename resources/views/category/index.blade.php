@extends('layouts.app')

@section('content')

@component('components/header',['title' => 'Book Genres'])
@endcomponent

<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <div class="col-md-8 left-col no-pad-small">
                
                <div class="category-list">
                    
                    <div class="results-pagination-links">
                    {{$categories->links()}}
                    </div>
                    
                    @foreach ($categories as $category)
                    <div class="single-category">
                        <a class="big-link" href="{{ url('/category/') }}/{{ $category->id }}">{{$category->name}} <span class="smallify">- ({{count($category->books)}} Books)</span></a>
                    </div>
                    @endforeach
                    
                    <div class="results-pagination-links">
                    {{$categories->links()}}
                    </div>
                    
                </div>
                
            </div>

            <div class="col-md-4 no-pad-small">
                @include('components/catbox')
            </div>

        </div>
    </div>
</div>

@endsection