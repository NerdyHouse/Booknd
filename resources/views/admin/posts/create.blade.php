@extends('layouts.admin')

@section('content')

@component('components/header',['title' => 'Admin Section'])
@endcomponent

<!-- main section - search and sidebar -->
<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-12 left-col">

                <h1>New Post</h1>
                <a class="btn btn-blue" href="{{url('admin/posts')}}"><i class="fa fa-caret-left"></i> Back to posts</a>
                    <div style="margin-top: 25px;">
                    <form id="create-post" action="{{url('admin/posts/new')}}" method="post">
                        {{ csrf_field() }}
                        
                        <div class="row">
                            <div class="col-md-12">
                                <label class="label text-light" for="ptitle">Title <span class="text-danger">*</span></label>
                                @if($errors->has('ptitle'))
                                <div style="margin-bottom: 5px;"><span class="label label-danger">{{$errors->first('ptitle')}}</span></div>
                                @endif
                                <input type="text" class="form-control input-lg" name="ptitle" value="{{old('ptitle')}}" />
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-12">
                                <label class="label text-light" for="pbody">Post Content <span class="text-danger">*</span></label>
                                @if($errors->has('pbody'))
                                <div style="margin-bottom: 5px;"><span class="label label-danger">{{$errors->first('pbody')}}</span></div>
                                @endif
                                <textarea name="pbody" id="pbody" rows="10" cols="80">{{old('pbody')}}</textarea>
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-blue btn-lg">Publish Post</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
