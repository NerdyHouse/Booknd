@extends('layouts.app')

@section('content')

@component('components/header',['title' => 'Browse Authors'])
@endcomponent

<!-- main section - search and sidebar -->
<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-8 left-col no-pad-small">
                
                @isset($authors)
                <div class="authors-list">
                    
                    <div class="results-pagination-links">
                    {{$authors->links()}}
                    </div>
                    
                    @foreach($authors as $author)
                        @component('components/author',['author' => $author])
                        @endcomponent
                    @endforeach
                    
                    <div class="results-pagination-links">
                    {{$authors->links()}}
                    </div>
                    
                </div>
                @endisset
                
            </div>

            <!-- right col -->
            <div class="col-md-4 no-pad-small">
                @include('components/authbox')
            </div>

        </div>
    </div>
</div>

@endsection