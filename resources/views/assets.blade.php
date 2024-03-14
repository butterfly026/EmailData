<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="You can find any marketing data" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="og:site_name" content="Email Data" />
    <meta name="og:title" content="EMAIL DATA" />
    <meta name="og:url" content="https://emaildata.co/" />
    <meta name="og:image" content="https://emaildata.co/images/deals.png" />
    <meta name="og:type" content="website" />
    <meta name="og:image:type" content="image/jpeg" />
    <title>@yield('title') - Email Data</title>
    <link rel="stylesheet" href="/css/typography.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="/images/favicon.ico" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <!-- Typography CSS -->
    <!-- Style CSS -->
    <link rel='stylesheet' href='/css/phifi-style.css' />
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="/css/responsive.css">

    <link rel="stylesheet" type="text/css" href="/css/toastify.min.css">


    <script src="/js/jquery-3.4.1.js"></script>
    <!-- jQuery  for scroll me js -->
    <script src='/js/jquery-min.js'></script>
    <!-- popper  -->
    <script src="/js/popper.min.js"></script>
    <!--  bootstrap -->
    <script src="/js/bootstrap.min.js"></script>
    <!-- Appear JavaScript -->
    <script src="/js/appear.js"></script>
    <!-- Jquery-migrate JavaScript -->
    <script src='/js/jquery-migrate.min.js'></script>
    <!-- countdownTimer JavaScript -->
    <script src='/js/jQuery.countdownTimer.min.js'></script>
    <!-- Owl.carousel JavaScript -->
    <script src='/js/owl.carousel.min.js'></script>
    <!-- Countdown JavaScript -->
    <script src='/js/countdown.js'></script>
    <!-- Jquery.countTo JavaScript -->
    <script src='/js/jquery.countTo.js'></script>
    <!-- Magnific-popup JavaScript -->
    <script src='/js/jquery.magnific-popup.min.js'></script>
    <!-- Wow JavaScript -->
    <script src='/js/wow.min.js'></script>
    <!-- Wow Toast -->
    <script type="text/javascript" src="js/toastify.js"></script>
    <!--  Custom JavaScript -->
    <script src="/js/custom.js"></script>
    <script>
        const toastMessage = (type, msg, duration = 3000) => {
            Toastify({
                text: msg,
                duration: duration,
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
    </script>
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '722563953413096');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=722563953413096&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
</head>