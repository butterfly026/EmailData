@extends('layout')

@section('title', 'Verify Email')

@section('content')
<div class="container" style="height: calc(100vh - 147px); padding-top: 80px; display: flex; justify-content: center; align-items:center; flex-direction: column;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

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
