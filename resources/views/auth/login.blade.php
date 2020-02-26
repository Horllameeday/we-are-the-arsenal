@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="container pt-4 pb-5">
                            @if ($errors->any())
                                <div class="alert text-center alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="row pt-5">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="usr" style="font-weight: bold;">Email:</label>
                                        <input type="text" name="email" class="form-control" id="usr" placeholder="Your Email Address" required>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="usr" style="font-weight: bold;">Password:</label>
                                        <input type="password" name="password" class="form-control" id="usr" placeholder="Your Password" minlength="8" maxlength="21" required>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="remember" value="remember" id="check-me"> Remember me
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-4"><a href="#" class="forget-password">Forgot Password?</a> | <a href="{{route('register')}}">Sign Up</a> </div>

                            </div>
                            <button type="submit" class="btn btn-success d-block mx-auto pl-5 pr-5 mb-4">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
