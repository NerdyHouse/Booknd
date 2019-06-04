@extends('layouts.app')

@section('content')

<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">
            <div class="col-md-8 col-md-offset-2">
                @include('books/details')
            </div>
        </div>
    </div>
</div>
@endsection
