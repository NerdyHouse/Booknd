@extends('layouts.app')

@section('content')

@component('components/header',['title' => 'Blog'])
@endcomponent

<!-- main section - search and sidebar -->
<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-8 left-col no-pad-small">

                <!-- was there a search? -->
                @isset($posts)

                    <!-- did the search have results? -->
                    @empty($posts)
                        Nothing to show!
                    @else
                    
                        @foreach($posts as $post)
                        <div class="bg-gray" style="padding: 25px;">
                            <a href="{{url('blog')}}/{{$post->slug}}"><h3 style="margin-bottom: 0;">{{$post->title}}</h3></a>
                            <p class="text-light" style="margin-bottom: 0;"><i class="fa fa-calendar"></i> Published {{date('F d, Y',strtotime($post->created_at))}}</p>
                        </div>
                        <div class="div-line"></div>
                        @endforeach
                    
                    @endempty

                @else
                    
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
