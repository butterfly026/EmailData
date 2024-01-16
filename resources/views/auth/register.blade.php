<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up </title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Main css -->
    <link rel="stylesheet" href="/css/auth-signup-style.css">
    <link rel="stylesheet" type="text/css" href="/css/toastify.min.css">

</head>

<body>
    <div style="width: 100vw; height: 100vh; position: absolute; left: 0; top: 0; background: black; opacity: 0.66"></div>
    <div class="main">

        <section class="signup">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container">
                <div class="signup-content">
                    <div id="signup-form" class="signup-form">
                        @csrf
                        <h1 style="text-align: center;"><a href='/' style="text-decoration: blink;"> <strong
                            style="font-family:Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;color: #f05c42">Data
                            Company</strong> </a></h1>
                        <h2 class="form-title">Create account</h2>

                        <div class="form-group">
                            <input id="email" type="email" class="form-input @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" placeholder="Your E-mail" required
                                autocomplete="email" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" type="password"
                                class="form-input @error('password') is-invalid @enderror" name="password"
                                placeholder="Password" required autocomplete="new-password" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <input id="password-confirm" type="password" class="form-input" name="password_confirmation"
                                placeholder="Repeat your password" required autocomplete="new-password" />
                        </div>
                        <input type='text' value='1' hidden name='redirect' />

                        <div class="form-group">
                            <button name="submit" id="submit" class="form-submit" value="Sign up"
                                style="cursor: pointer">Sign Up </button>
                        </div>
                    </div>
                    <p class="loginhere">
                        Have already an account ? <a href="{{ route('auth.loginPage') }}" class="loginhere-link">Login
                            here</a>
                    </p>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="/js/jquery-min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script type="text/javascript" src="js/toastify.js"></script>
    <script src="/js/auth.js"></script>
    <script>
        const url = "{{ route('api.auth.signup') }}";
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
            if (!$('#password-confirm').val()) {
                toastMessage('error', 'Please type password to confirm');
                $('#password-confirm').focus();
                return;
            } else if ($('#password-confirm').val() != $('#password').val()) {
                toastMessage('error', 'Password does not matches!');
                $('#password-confirm').focus();
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
                        toastMessage('error', res.message ?? 'An error occured while changing password');
                    } else {
                        window.location.href = '/';
                    }
                },
                error: function(msg) {
                    toastMessage('error', msg.message ?? 'An error occured while changing password');
                }
            });
        })
    </script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
