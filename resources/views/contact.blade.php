@extends('layouts.app')

@section('content')

@component('components/header',['title' => 'Contact Us'])
@endcomponent

<!-- main section - search and sidebar -->
<div class="page-main">
    <div class="page-content">
        <div class="site-contain row">

            <!-- left col -->
            <div class="col-md-8 left-col no-pad-small">
                
                <h3><i class="fa fa-caret-right text-teal"></i> Send Us Your Questions</h3>
                <p>If you have any questions or problems while using Booknd send us a message and we will get back to you as soon as possible. We will never share your information with third-parties.</p>
                
                @isset($success)
                <div class="alert alert-success"><i class="fa fa-check-circle"></i> Your message has been sent! We will get back to you soon.</div>
                @endisset
                
                <div class="contact-form-wrapper">
                    <form id="contact-form" action="{{url('contact')}}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12">
                                <label class="label text-light" for="cname">Your Name <span class="text-danger">*</span></label>
                                @if($errors->has('cname'))
                                <div style="margin-bottom: 5px;"><span class="label label-danger">{{$errors->first('cname')}}</span></div>
                                @endif
                                <input type="text" class="form-control" name="cname" value="{{old('cname')}}" />
                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-12">
                                <label class="label text-light" for="cemail">Your Email <span class="text-danger">*</span></label>
                                @if($errors->has('cemail'))
                                <div style="margin-bottom: 5px;"><span class="label label-danger">{{$errors->first('cemail')}}</span></div>
                                @endif
                                <input type="email" class="form-control" name="cemail" value="{{old('cemail')}}" />
                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-md-12">
                                <label class="label text-light" for="cmessage">Your Message <span class="text-danger">*</span></label>
                                @if($errors->has('cmessage'))
                                <div style="margin-bottom: 5px;"><span class="label label-danger">{{$errors->first('cmessage')}}</span></div>
                                @endif
                                <textarea class="form-control" name="cmessage" rows="8" value="{{old('cmessage')}}"></textarea>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 15px; margin-bottom: 15px;">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-blue btn-lg">
                                    <i class="fa fa-paper-plane"></i> SEND MESSAGE
                                </button>
                            </div>
                        </div>
                    </form>
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