@extends('layouts.app')

@section('content')

@component('components/header',['title' => $post->title])
@endcomponent

<!-- main section - search and sidebar -->
<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-8 left-col no-pad-small">
                <div>
                    <div class="blog-share">
                        
                    </div>
                    <p>{!! $post->body !!}</p>
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
