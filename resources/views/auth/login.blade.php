<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/auth-signin-style.css">
    <link rel="stylesheet" type="text/css" href="/css/toastify.min.css">

    <title>Login </title>
</head>

<body>


    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background: #efdd83; display: flex; align-items: center; justify-content: center">
            <img src="images/login_back2.png" style="width: 95%; visibility:visible">
        </div>
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7">
                        <h3> Login to
                            <a href='/' style="text-decoration: blink"> <strong
                                style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;color: #f05c42">Email Data</strong> </a>
                        </h3>

                        <div>
                            @csrf
                            <div class="form-group first">
                                <label for="email" class="col-md-6 col-form-label"
                                    style="color: #f05c42">{{ __('E-Mail Address') }}</label>

                                <input id="email" type="email"
                                    class="form-control  @error('email') is-invalid @enderror"
                                    placeholder="Enter E-mail" name="email" value="{{ old('email') }}" required
                                    autocomplete="email" autofocus>

                            </div>
                            <div class="form-group last mb-3">
                                <label for="password" class="col-md-4 col-form-label"
                                    style="color: #f05c42">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="Enter Password" required autocomplete="current-password">

                            </div>

                            {{-- <div class="d-flex mb-5 align-items-center">
                                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                                    <input type="checkbox" checked="checked" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }} />
                                    <div class="control__indicator"></div>
                                </label>
                                <span class="ml-auto">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="forgot-pass">Forgot
                                            Password</a>
                                </span>
                                @endif
                            </div> --}}
                            <Button id="submit" value="Log In" class="btn btn-block btn-primary">Sign In</Button>

                        </div>
                        <br><br>
                        <h6 style="text-align: center"> <span style="color: grey"> You don't have an
                                account?</span><a href="{{ route('auth.signupPage') }}"> <span
                                    style="color: blue"><b>SIGN UP</b></span> </a></h6>
                    </div>
                </div>
            </div>
        </div>


    </div>



    <script src="/js/jquery-min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/toastify.js"></script>
    <script src="/js/main.js"></script>
    <script>
        const url = "{{ route('api.auth.login') }}";
        const validateEmail = (email) => {
            return String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        };
        const toastMessage = (type, msg) => {
            Toastify({
                text: msg,
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "center", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: type == 'warning' ? "#ff9966" : type == 'error' ? '#CC3300' : '#428bca',
                },
                onClick: function() {} // Callback after click
            }).showToast();
        }
        $('#password').on('keydown', function(e) {
            if (e.keyCode == 13) {
                $('#submit').trigger('click');
            }
        });
        $('#email').on('keydown', function(e) {
            if (e.keyCode == 13) {
                $('#submit').trigger('click');
            }
        });
        $('#submit').click(function() {
            if (!$('#email').val()) {
                toastMessage('error', 'Please type your email address');
                $('#email').focus();
                return;
            } else if (!validateEmail($('#email').val())) {
                toastMessage('error', 'Please type valid email address');
                $('#email').focus();
                return;
            }
            if (!$('#password').val()) {
                toastMessage('error', 'Please type password');
                $('#password').focus();
                return;
            }
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    email: $('#email').val(),
                    password: $('#password').val()
                },
                success: function(res) {
                    if(res.code) {
                        toastMessage('error', res.message ?? 'An error occured while logging in');
                    } else {
                        if(res.user?.user_type == 0)
                            window.location.href = '/home';
                        else if (res.user?.user_type == 1)
                            window.location.href = '/admin_panel';
                        else
                            toastMessage('error', 'Not valid user');
                    }
                },
                error: function(msg) {
                    toastMessage('error', msg.message ?? 'An error occured while logging in');
                }
            });
        })
    </script>
</body>

</html>
