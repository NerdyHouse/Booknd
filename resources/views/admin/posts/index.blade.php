@extends('layouts.admin')

@section('content')

@component('components/header',['title' => 'Admin Section'])
@endcomponent

<!-- main section - search and sidebar -->
<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-8 left-col">

                <h3>Blog Admin</h3>
                
                <div><a class="btn btn-blue btn-lg" href="{{url('admin/posts/new')}}">NEW POST</a></div>
                
                <div class="div-line" style="margin-top: 25px; margin-bottom: 15px;"></div>
                
                @if(session()->has('saved'))
                <div class="alert alert-success" role="alert">Your post was created!</div>
                @endif
                @if(session()->has('updated'))
                <div class="alert alert-success" role="alert">Your post was updated!</div>
                @endif
                
                @empty($posts)
                <p>No posts</p>
                @else
                <div>
                    @foreach($posts as $post)
                    <div style="padding: 10px 0;">
                        <a href="{{url('admin/posts')}}/{{$post->id}}"><h4>{{$post->title}} - {{$post->created_at}}</h4></a>
                    </div>
                    @endforeach
                </div>
                @endempty
            </div>

            <!-- right col -->
            <div class="col-md-4">
            </div>

        </div>
    </div>
</div>

@endsection
