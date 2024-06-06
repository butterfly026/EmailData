@extends('layout')

@section('title', 'Access All Data')

@section('content')
    <style>
        .circle-num {
            border-radius: 50%;
            background: #3f3feb;
            color: white;
            width: 30px;
            min-width: 30px;
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

        .payment-option-row {
            display: flex;
            flex-direction: row;
            gap: 10px;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .payment-option {
            display: flex;
            padding: 20px 15px;
            background: #F2F2F2;
            border-radius: 15px;
            border: 1px solid #F5F5F5;
            justify-content: center;
            align-items: center;
            flex: 1;
            cursor: pointer;
        }
        .payment-option.active {
            /* background: linear-gradient(90deg, rgba(162,158,228,1) 0%, rgba(124,124,221,1) 35%, rgba(0,212,255,1) 100%); */
            background: #0069d9;
            color: white;
            border-width: 0px;
            -webkit-box-shadow: 10px 6px 20px -12px rgba(0,0,0,0.75);
            -moz-box-shadow: 10px 6px 20px -12px rgba(0,0,0,0.75);
            box-shadow: 10px 6px 20px -12px rgba(0,0,0,0.75);
        }
    </style>
    <link href="/css/bank-card.css" rel="stylesheet">
    <div class="row" style="margin-top: 80px; min-height: calc(100vh - 226px)">
        <div class="col-md-6" style="display: flex; align-items: center;">
            <div style="flex: 1;">
                <img loading="lazy" class="service-img-back" src="/images/deals.png" alt="portfolio">
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
                        <div class="p-6 bg-white sm:px-20 dark:bg-darkmode2" style="display: none;">
                            <div class="payment-option-row">
                                <div class="payment-option active" option="1">
                                    <h4>Full Access </h4>
                                </div>
                                <div class="payment-option" option="2">
                                    <h4>Trial (2 days) </h3>
                                </div>
                            </div>
                        </div>
                        @if ($PaymentOption == 1)
                        <div class="p-6 mt-4 bg-white sm:px-20 dark:bg-darkmode2 payment-detail" id="paymentDetail1" style="text-align: center;">
                            <h2 class="text-2xl font-bold text-gray-500 dark:text-darkmodetext">
                                Pay <span style="color: blue;">${{ $PayAmount }} per month</span> For Full Access
                            </h2>
                        </div>
                        @else
                        <div class="p-6 mt-4 bg-white sm:px-20 dark:bg-darkmode2 payment-detail"  id="paymentDetail2" style="text-align: center;">
                            <h2 class="text-2xl font-bold text-gray-500 dark:text-darkmodetext">
                                2 Day trial for <span style="color: blue;">${{ $TrialPayAmount }}</span>
                            </h2>
                        </div>
                        @endif
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
                        <div id="stripe-card-element" style="display: none"></div>
                        <div id="card-element"
                            style="margin-top: 10px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                            <!-- A Stripe Element will be inserted here. -->
                            <div class="card" style="display: none;">
                                <div class="card-front card-part" id="card-front">
                                    <img alt="" class="card-front-square card-square"
                                        src="/images/bank/sim-card-chip.png">
                                    <img alt="" class="card-front-square card-square"
                                        src="/images/bank/contactless-payment-white.png" />
                                    <img alt="" class="card-front-logo card-logo" src="/images/bank/22.svg">
                                    <p class="card-number" id="card-number">**** **** **** ****</p>
                                    <div class="card-space-75">
                                        <span class="card-label">Card holder</span>
                                        <p class="card-info" id="card-holder">Your name here</p>
                                    </div>
                                    <div class="card-space-25">
                                        <span class="card-label">Expires</span>
                                        <p class="card-info" id="card-expires-date">**/**</p>
                                    </div>
                                </div>

                                <div class="card-back card-part" id="card-back">
                                    <div class="card-black-line"></div>
                                    <div class="card-back-content">
                                        <div class="card-secret">
                                            <p class="card-secret--last" id="card-secret-cvc">***</p>
                                        </div>
                                        <img alt="" class="card-back-logo card-logo" src="/assets/logos/22.svg">
                                    </div>
                                </div>
                            </div>
                            <div style="width: 100%;">
                                <form class="card-form" style="display: flex;
                                flex-direction: column;
                                justify-content: flex-start;
                                align-items: center;">
                                    <div class="row">
                                        <span>Card holder</span>
                                        <input id="card-holder-input" placeholder="Card holder name" type="text">
                                    </div>
                                    <div class="row">
                                        <span>Card number</span>
                                        <input id="card-number-input" maxlength="19" minlength="19"
                                            placeholder="Card number" type="text">
                                    </div>
                                    <div class="row">
                                        <div class="col-50">
                                            <span>Expires </span>
                                            <input id="card-expires-date-input" max="1299" maxlength="7"
                                                minlength="7" placeholder="Expires" type="text">
                                        </div>
                                        <div class="col-50">
                                            <span>CVC </span>
                                            <input id="card-secret-cvc-input" max="999" maxlength="4"
                                                min="100" minlength="4" placeholder="CVC" type="text">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="flex items-center justify-end text-center" style="margin-top: 10px;">
                            <button id="btnPayout" class="btn btn-primary mt-4" style="padding: 15px 45px">
                                @if($PaymentOption == 1)
                                    {{ __('Pay Now') }} 
                                @else
                                {{ __('Pay $') .$TrialPayAmount . __(' Now') }} 
                                <span style="font-size: 14px;color: white;">{{ '(' }}then only ${{ $PayAmount }}/m{{ ')' }}</span>
                                @endif
                            </button>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>

    </div>
    {{-- <script type="text/javascript" src="https://js.stripe.com/v3/"></script> --}}
    <script type="text/javascript">
        let userEmail = "{{ Auth::user() ? Auth::user()->email : '' }}";
        let paymentOption =  "{{ $PaymentOption }}";
        // var stripe = Stripe('{{ $StripeKey }}');
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
        if (userEmail)
            $('#signup-form').hide();

        // Add an instance of the card Element into the `card-element` <div>.
        // card.mount('#card-element');

        const validateEmail = (email) => {
            return String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        };

        // $('.payment-option').on('click', function() {
        //     $('.payment-option').removeClass('active');
        //     $(this).addClass('active');
        //     paymentOption = $(this).attr('option');
        //     $('.payment-detail').hide();
        //     $('#paymentDetail' + paymentOption).show();
        // });

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

        function validateExpiration() {
            var today = new Date(); // gets the current date
            var today_mm = today.getMonth() + 1; // extracts the month portion
            var today_yy = today.getFullYear() % 100; // extracts the year portion and changes it from yyyy to yy format

            if (today_mm < 10) { // if today's month is less than 10
                today_mm = '0' + today_mm // prefix it with a '0' to make it 2 digits
            }
            var expiryDate = $('#card-expires-date-input').val().replace(/\s/g, '');
            var mm = expiryDate.substring(0, 2); // get the mm portion of the expiryDate (first two characters)
            var yy = expiryDate.substring(3); // get the yy portion of the expiryDate (from index 3 to end)

            if (yy > today_yy || (yy == today_yy && mm >= today_mm)) {
                result = true;
            } else {
                result = false;
            }
            return result;
        }

        function ValidateCreditCardNumber() {

            var ccNum = document.getElementById("card-number-input").value.replace(/\s/g, ''); // Remove spaces
            var visaRegEx = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
            var mastercardRegEx = /^(?:5[1-5][0-9]{14})$/;
            var amexpRegEx = /^(?:3[47][0-9]{13})$/;
            var discovRegEx = /^(?:6(?:011|5[0-9][0-9])[0-9]{12})$/;
            var isValid = false;

            if (visaRegEx.test(ccNum)) {
                isValid = true;
            } else if (mastercardRegEx.test(ccNum)) {
                isValid = true;
            } else if (amexpRegEx.test(ccNum)) {
                isValid = true;
            } else if (discovRegEx.test(ccNum)) {
                isValid = true;
            }
            return isValid;
        }

        function validateCardInfo() {
            if (!$('#card-holder-input').val()) {
                toastMessage('error', 'Please type your card holder name');
                $('#card-holder-input').focus();
                return false;
            }
            if (!$('#card-number-input').val()) {
                toastMessage('error', 'Please type card number');
                $('#card-number-input').focus();
                return false;
            } else if (!ValidateCreditCardNumber()) {
                toastMessage('error', 'Please provide a valid card number');
                $('#card-number-input').focus();
                return false;
            }
            if (!$('#card-expires-date-input').val()) {
                toastMessage('error', 'Please type card expiration');
                $('#card-expires-date-input').focus();
                return false;
            } else if (!validateExpiration()) {
                toastMessage('error', 'The expiry date needs to be greater than today.');
                $('#card-expires-date-input').focus();
                return false;
            }
            if (!$('#card-secret-cvc-input').val()) {
                toastMessage('error', 'Please type CVC');
                $('#card-secret-cvc-input').focus();
                return false;
            }
            return true;
        }

        async function payout() {
            if (!validateCardInfo()) {
                $('#preloader').hide();
                return;
            }
            var expiryDate = $('#card-expires-date-input').val().replace(/\s/g, '');
            var mm = expiryDate.substring(0, 2); // get the mm portion of the expiryDate (first two characters)
            var yy = expiryDate.substring(3);

            // stripe.createToken({
            //     number: $('#card-holder-input').val(),
            //     exp_month: mm,
            //     exp_year: yy,
            //     cvc: $('#card-secret-cvc-input').val(),
            // }).then(function(result) {
            //     if (result.error) {
            //         toastMessage('error', result.error.message);
            //     } else {
                    $.ajax({
                        url: "{{ route('api.payments.confirm_payout') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            user_email: userEmail,
                            card_number: $('#card-number-input').val().replace(/\s/g, ''),
                            expiration: $('#card-expires-date-input').val(),
                            holder_name: $('#card-holder-input').val(),
                            cvc: $('#card-secret-cvc-input').val(),
                            payment_option: paymentOption,
                            token: result.token,
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
            //     }
            // });


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

        async function initialize() {
            $('#preloader').show();
            $.ajax({
                url: "{{ route('api.payments.checkout') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(res) {
                    $('#preloader').hide();
                    
                    // elements = stripe.elements({
                    //     clientSecret: res.clientSecret,
                    //     appearance
                    // });

                    // const paymentElement = elements.create("card", paymentElementOptions);
                    // paymentElement.mount("#stripe-card-element");                    
                },
                error: function(msg) {
                    $('#preloader').hide();
                    console.log(msg);
                }
            });

        }
    </script>
    <script src="/js/bank-card.js"></script>
@endsection
