@extends('layout')

@section('title', 'Access All Data')

@section('content')
    <style>
        .circle-num {
            border-radius: 50%;
            background: #3f3feb;
            color: white;
            width: 30px;
            height: 30px;
            font-size: 20px;
            margin-right: 10px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .service-detail {
            font-size: 20px;
            color: #292929;
            font-weight: 600;
        }

        .service-detail-item {
            display: flex;
            margin-bottom: 20px;
        }

        .service-img-back {
            visibility: visible;
            position: absolute;
            opacity: 0.2;
            bottom: 0px;
            z-index: -1;
        }
        .form-group {
            height: 65px;
        }
        input:focus {
            outline: 0;
            border-color: hsla(210, 96%, 45%, 50%) !important;
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.03), 0px 3px 6px rgba(0, 0, 0, 0.02), 0 0 0 3px hsla(210, 96%, 45%, 25%), 0 1px 1px 0 rgba(0, 0, 0, 0.08) !important;
        }
    </style>
    <div class="row" style="margin-top: 80px; min-height: calc(100vh - 226px)">
        <div class="col-md-6" style="display: flex; align-items: center;">
            <div style="flex: 1;">
                <img loading="lazy" class="service-img-back" src="images/deals.png" alt="portfolio">
                <h1 style="margin-bottom: 10px;">Unlimited Searches & Downloads Every Month (28,000+ leads)</h1>
                <div>
                    <div class="service-detail-item">
                        <span class="circle-num">1</span>
                        <div class="service-detail">Find and convert the most accurate leads in B2B.</div>
                    </div>
                    <div class="service-detail-item">
                        <span class="circle-num">2</span>
                        <div class="service-detail">Designed by Marketers for Marketers</div>
                    </div>
                    <div class="service-detail-item">
                        <span class="circle-num">3</span>
                        <div class="service-detail">Unlimited Access & Downloads Each Month</div>
                    </div>
                    <div class="service-detail-item">
                        <span class="circle-num">4</span>
                        <div class="service-detail">Updated With New Leads Every Week</div>
                    </div>
                    <div class="service-detail-item">
                        <span class="circle-num">5</span>
                        <div class="service-detail">Every Lead Is Verified</div>
                    </div>
                    <div class="service-detail-item">
                        <span class="circle-num">6</span>
                        <div class="service-detail">No More Credits</div>
                    </div>
                    <div class="service-detail-item">
                        <span class="circle-num">7</span>
                        <div class="service-detail">Unlimited Searches & Downloads</div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6" style="display: flex; align-items: center;">
            <div class="py-12" style="flex: 1">
                <meta name="csrf-token" content="{{ csrf_token() }}" />
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg dark:bg-darkmode2">
                        <div class="p-6 bg-white sm:px-20 dark:bg-darkmode2">
                            <h2 class="text-2xl font-bold text-gray-500 dark:text-darkmodetext">
                                Pay <span style="color: blue;">${{ $PayAmount }} per month</span> For Full Access
                            </h2>
                        </div>
                        <div id="signup-form" class="signup-form">
                            <div class="form-group">
                                <span>Email</span>
                                <input id="email" type="text" class="form-input" style="height: 44.39px"
                                    name="email" placeholder="Your E-mail" required autocomplete="email" />
                            </div>
                            <div class="form-group" style="margin-top: 10px;">
                                <span>Password</span>
                                <input id="password" type="password" class="form-input" name="password"
                                    style="height: 44.39px" placeholder="Password" required autocomplete="new-password" />
                            </div>
                            <div class="form-group" style="margin-top: 10px;">
                                <span>Confirm Password</span>
                                <input id="password-confirm" type="password" class="form-input" name="password_confirmation"
                                    style="height: 44.39px" placeholder="Repeat your password" required
                                    autocomplete="new-password" />
                            </div>
                        </div>

                        <div id="card-element" style="margin-top: 10px;">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>
                        <div class="flex items-center justify-end text-center" style="margin-top: 10px;">
                            <button id="btnPayout" class="btn btn-primary mt-4" style="padding: 15px 45px">
                                {{ __('Pay Now') }}
                            </button>
                        </div>
                    </div>
                    <br>

                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        var stripe = Stripe('{{ $StripeKey }}');
        // var stripe = Stripe('{{ $SecretKey }}');
        var elements = stripe.elements();
        let userEmail = "{{ Auth::user() ? Auth::user()->email : '' }}";

        var style = {
            base: {
                // Add your base input styles here. For example:
                fontSize: '16px',
                color: "#32325d",
            },
            fields: {
                billingDetails: {
                    name: 'never',
                    email: 'never',
                }
            }
        };
        const items = [{
            id: "xl-tshirt"
        }];
        let hasError = false;
        async function initialize() {
            if (userEmail)
                $('#signup-form').hide();
            $('#preloader').show();
            $.ajax({
                url: "{{ route('api.payments.checkout') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(res) {
                    $('#preloader').hide();
                    const appearance = {
                        theme: 'stripe',

                        variables: {
                            colorPrimary: '#0570de',
                            colorBackground: '#ffffff',
                            colorText: '#30313d',
                            colorDanger: '#df1b41',
                            fontFamily: 'Ideal Sans, system-ui, sans-serif',
                            spacingUnit: '4px',
                            borderRadius: '4px',
                            gridRowSpacing: '10px',
                            // See all possible variables below
                        },
                        rules: {
                            ".Label": {
                                marginTop: '7px'
                            }
                        }
                    };
                    elements = stripe.elements({
                        clientSecret: res.clientSecret,
                        appearance
                    });
                    const paymentElementOptions = {
                        layout: "tabs",
                        paymentMethodOrder: ['card'],
                        wallets: {
                            googlePay: 'never'
                        }
                    };

                    const paymentElement = elements.create("payment", paymentElementOptions);
                    paymentElement.mount("#card-element");
                    paymentElement.on('change', function(event) { 
                        console.log(event);                       
                        hasError = !event.complete;
                    });
                },
                error: function(msg) {
                    $('#preloader').hide();
                    console.log(msg);
                }
            });

        }
        initialize();


        // Add an instance of the card Element into the `card-element` <div>.
        // card.mount('#card-element');

        const validateEmail = (email) => {
            return String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        };

        function validateSignup() {
            if (!$('#email').val()) {
                toastMessage('error', 'Please type your email address');
                $('#email').focus();
                return false;
            } else if (!validateEmail($('#email').val())) {
                toastMessage('error', 'Please type valid email address');
                $('#email').focus();
                return false;
            }
            if (!$('#password').val()) {
                toastMessage('error', 'Please type password');
                $('#password').focus();
                return false;
            }
            if (!$('#password-confirm').val()) {
                toastMessage('error', 'Please type password to confirm');
                $('#password-confirm').focus();
                return false;
            } else if ($('#password-confirm').val() != $('#password').val()) {
                toastMessage('error', 'Password does not matches!');
                $('#password-confirm').focus();
                return false;
            }
            return true;
        }

        async function payout() {
            // const {
            //     error
            // } = await stripe.confirmPayment({
            //     elements,
            //     confirmParams: {
            //         // Make sure to change this to your payment completion page
            //         return_url: "{{ route('payments.paySuccess') }}",
            //         receipt_email: userEmail ?? '',
            //     },
            // });
            if(hasError) return;
            let jsonStr = JSON.stringify({
                        elements,
                        confirmParams: {
                            // Make sure to change this to your payment completion page
                            return_url: "{{ route('payments.paySuccess') }}",
                            receipt_email: userEmail ?? '',
                        },
                    });
            let jsonDt = JSON.parse(jsonStr);
            $.ajax({
                url: "{{ route('api.payments.send_payment_email') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    user_email: userEmail,
                    data: jsonDt
                },
                success: function(res) {
                    $('#preloader').hide();
                    if (res.code) {
                        toastMessage('error', res.message ??
                            'An error occured while paying for full access');
                    } else {
                        toastMessage('success', 
                            'Please verify your payment in your mail box. We have sent an email to your email address!',
                            20000);
                    }
                },
                error: function(msg) {
                    $('#preloader').hide();
                    toastMessage('error', msg.message ??
                        'An error occured while paying for full access');
                }
            });
            
        }
        $('#btnPayout').click(async function(e) {
            if (!userEmail && !validateSignup()) return;
            $('#preloader').show();
            if (!userEmail) {
                $.ajax({
                    url: "{{ route('api.auth.signup') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: $('#email').val(),
                        password: $('#password').val()
                    },
                    success: function(res) {
                        $('#preloader').hide();
                        if (res.code) {
                            toastMessage('error', res.message ??
                                'An error occured while signing up new user');
                        } else {
                            userEmail = $('#email').val();
                            payout();
                        }
                    },
                    error: function(msg) {
                        $('#preloader').hide();
                        toastMessage('error', msg.message ??
                            'An error occured while signing up new user');
                    }
                });
            } else {
                payout();
            }
        });
    </script>
@endsection
