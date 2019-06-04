@extends('layouts.app')

@section('content')

@component('components/header',['title' => 'Terms & Conditions'])
@endcomponent

<!-- main section - search and sidebar -->
<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-8 left-col">

                <h1>Terms & Conditions</h1>
                <div>
                    <p>Terms & Conditions</p>
                </div>
            </div>

            <!-- right col -->
            <div class="col-md-4">
            </div>

        </div>
    </div>
</div>

@endsection