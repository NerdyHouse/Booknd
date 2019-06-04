@extends('layouts.admin')

@section('content')

@component('components/header',['title' => 'Users'])
@endcomponent

<!-- main section - search and sidebar -->
<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-12">
                
                @foreach($users as $user)
                <div style="padding: 5px 0;">
                    &bull; <a href="{{url('user')}}/{{$user->id}}" target="_blank">{{$user->name}} - {{$user->email}} - {{count($user->books)}} Books</a>
                </div>
                @endforeach
                
            </div>

        </div>
    </div>
</div>

@endsection