@extends('layout')

@section('title', 'User Info')

@section('content')

    <main class="page-content" style="margin-top: 75px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9">
                    <div class="text-left iq-title-box pr-lg-5" style="margin-bottom: 5px;">
                        <h2 class="iq-title text-uppercase">Account Information</h2>
                        <p class="iq-line three"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 text-right">
                    <span>Email:</span>
                </div>
                <div class="col-6">
                    <span>{{ Auth::user()->email }}</span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6 text-right">
                    <span>Subscription Status:</span>
                </div>
                <div class="col-6 d-flex" style="align-items: center">
                    @if (Auth::user()->is_paid)
                        <span style="color: green">ACTIVATED</span>
                        <a class="btn-normal iq-button d-flex mx-4" style="align-items: center"
                            href="javascript:cancelSubscription()">
                            <i class="fa fa-key mr-2"></i>
                            <span>Cancel</span>
                        </a>
                    @else
                        <span style="color: red">INACTIVE</span>
                        <a class="btn-normal iq-button d-flex mx-4" style="align-items: center"
                            href="/payout">
                            <i class="fa fa-key mr-2"></i>
                            <span>Active</span>
                        </a>
                    @endif

                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6 text-right">
                    <span>Email Verified:</span>
                </div>
                <div class="col-6 d-flex" style="align-items: center;">
                    @if (Auth::user()->is_email_verified)
                        <span style="color: green">VERIFIED</span>
                    @else
                        <span style="color: red">NOT VERIFIED</span>
                        <br>
                        <a class="d-flex ml-2 instant-activate">
                            <i class="fa fa-envelope" style="margin-right: 3px;"></i>
                            <span>Verify By Email</span>
                        </a>
                    @endif

                </div>
            </div>
            @if (Auth::user()->is_paid && Auth::user()->expired_at >= now())
                <div class="row mt-2">
                    <div class="col-6 text-right">
                        <span>Next Payment:</span>
                    </div>
                    <div class="col-6 d-flex" style="align-items: center;">
                        {{ Auth::user()->expired_at }}
                    </div>
                </div>
                {{-- <div class="row text-center mt-3" style="justify-content: center">
                    <div class="col-6">
                        <a class="btn-normal iq-button d-flex" style="align-items: center"
                            href="/payout">
                            <i class="fa fa-money mr-2"></i>
                            <span>Pay For Next Month</span>
                        </a>
                    </div>
                </div> --}}
            @endif
        </div>
        <section id="sectionSrchResult" class="overview-block-ptb" style="padding: 10px 0px; min-height: calc(100vh - 223px);">
            <img src="images/fancybox/overlay-dot2.png" class="overlay-right-top-2" alt="#">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="text-left iq-title-box pr-lg-5" style="margin-bottom: 5px;">
                            <h2 class="iq-title text-uppercase">Payments History</h2>
                            <p class="iq-line three"></p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-sm-center">
                    <div class="col-sm-12">
                        <table style="z-index: 2; ">
                            <thead>
                                <tr style="background: white">                                    
                                    <th style="width: 200px;">Email</th>
                                    <th style="width: 200px;">Amount</th>
                                    <th style="min-width: 200px;">Paid At</th>
                                    <th style="min-width: 200px;">Next Payment</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyResult">
                                @foreach ($payments as $payment)
                                <tr style="height: 50px">                                    
                                    <td>{{ $payment->user_email }}</td>
                                    <td>${{ $payment->amount }}</td>
                                    <td>{{ $payment->paid_at }}</td>
                                    <td>{{ $payment->expired_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 text-center">
                        <ul class="page-numbers" id="pagination">
                         </ul>
                    </div>
                </div>
            </div>
            <img src="images/fancybox/overlay.png" class="overlay-left-bottom" alt="#" style="z-index: -1">
        </section>
    </main>
    <script>
        console.log("{{ route('api.payments.cancel_subscription') }}",44444)
        function cancelSubscription(){
            $('#preloader').show();
            let userEmail = "{{ Auth::user() ? Auth::user()->email : '' }}";
            $.ajax({
                url: "{{ route('api.payments.cancel_subscription') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    user_email: userEmail,
                },
                success: function(res) {
                    if(res === "cancelled"){
                        $('#preloader').hide();
                        location.reload();
                    }
                },
                error: function(msg) {
                    $('#preloader').hide();
                    toastMessage('error', msg.message ??
                        'An error occured while paying for full access');
                }
            });
        }
    </script>
@endsection
