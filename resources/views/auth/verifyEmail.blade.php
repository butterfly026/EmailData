@extends('layout')

@section('title', 'Verify Email')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (empty($errMsg))
                        <div class="alert alert-success" role="alert">
                            {{ __('You are verified with your email address. Pleas Login with your account!') }}
                        </div>
                    @else 
                        <div class="alert alert-success" role="alert">
                            {{ $errMsg }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
