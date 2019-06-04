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

                <div><a class="btn btn-blue btn-lg" href="{{url('admin/posts')}}">BLOG POSTS</a></div><br />
                <div><a class="btn btn-blue btn-lg" href="{{url('admin/users')}}">USERS</a></div>
            </div>

            <!-- right col -->
            <div class="col-md-4">
            </div>

        </div>
    </div>
</div>

@endsection
