@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                <div class="card-body">
                    <form  action="{{ route('register') }}" method="post">
                        @if ($errors->any())
                            <div class="alert text-center alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @csrf

                        <div class="row pt-5">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="usr" style="font-weight: bold;">Username:</label>

                                    <input type="text" name="name" class="form-control" id="name" required>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="usr" style="font-weight: bold;">Email Address:</label>

                                    <input type="text" @error('email') is-invalid @enderror  name="email" class="form-control" id="email" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="usr" style="font-weight: bold;">Password:</label>

                                    <input type="password" name="password" class="form-control" id="password" required>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="usr" style="font-weight: bold;">Confirm Password:</label>

                                    <input type="password" name="password_confirmation" class="form-control" id="confirm_password" required>

                                </div>

                            </div>

                        </div>


                        <button type="submit" class="btn btn-success d-block mx-auto pl-5 pr-5 mb-4">Continue</button>

                        <div>
                            <p>Already have an Account? <a href="{{route('login')}}"> Sign In</a> </p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
