{{-- Login part --}}
<h4 class="login-form-header">Login</h4>
<form class="form-horizontal login-form" id="login-form" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <!-- <label for="email" class="col-md-4 control-label">E-Mail Address</label> -->

        <div class="col-md-8 col-md-offset-2">
            
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input placeholder="email address" id="login-email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>
    
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <!-- <label for="password" class="col-md-4 control-label">Password</label> -->

        <div class="col-md-8 col-md-offset-2">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-unlock"></i></span>
                <input placeholder="password" id="login-password" type="password" class="form-control" name="password" required>
            </div>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-8 col-md-offset-2">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8 col-md-offset-2 ">
            <button type="submit" class="btn btn-primary btn-blue btn-lg">
                Login <i class="fa fa-caret-right"></i>
            </button>
            <a href="{{url('/fbredirect')}}" class="btn btn-default btn-blue btn-lg fb-button-style-large"><i class="fa fa-facebook-square"></i> <span>Login with Facebook</span></a><br />
            <a class="btn btn-link" href="{{ route('password.request') }}">
                Forgot Your Password?
            </a>
        </div>
    </div>
</form>

<div class="div-line"></div>

{{-- Register part --}}
<h4 class="register-form-header">Create Account</h4>
<form class="form-horizontal" method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('rname') ? ' has-error' : '' }}">
       <!-- <label for="name" class="col-md-4 control-label">Name</label> -->

        <div class="col-md-8 col-md-offset-2">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input placeholder="your name" id="reg-name" type="text" class="form-control" name="rname" value="{{ old('rname') }}" required autofocus>
            </div>
            @if ($errors->has('rname'))
                <span class="help-block">
                    <strong>{{ $errors->first('rname') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('remail') ? ' has-error' : '' }}">
        <!-- <label for="email" class="col-md-4 control-label">E-Mail Address</label> -->

        <div class="col-md-8 col-md-offset-2">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input placeholder="email address" id="reg-email" type="email" class="form-control" name="remail" value="{{ old('remail') }}" required>
            </div>
            @if ($errors->has('remail'))
                <span class="help-block">
                    <strong>{{ $errors->first('remail') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('rpassword') ? ' has-error' : '' }}">
       <!-- <label for="password" class="col-md-4 control-label">Password</label> -->

        <div class="col-md-8 col-md-offset-2">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-unlock"></i></span>
                <input placeholder="password" id="reg-password" type="password" class="form-control" name="rpassword" required>
            </div>
            @if ($errors->has('rpassword'))
                <span class="help-block">
                    <strong>{{ $errors->first('rpassword') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <!-- <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label> -->

        <div class="col-md-8 col-md-offset-2">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-unlock"></i></span>
                <input placeholder="confirm password" id="reg-password-confirm" type="password" class="form-control" name="rpassword_confirmation" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8 col-md-offset-2">
            <button type="submit" class="btn btn-primary btn-blue btn-lg">
                Register <i class="fa fa-caret-right"></i>
            </button>
        </div>
    </div>
</form>