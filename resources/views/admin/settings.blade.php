@extends('admin.layout')

@section('title', 'Home')

@section('content')
    <link rel="stylesheet" href="css/summernote-bs5.min.css" />

    <main class="page-content" style="margin-top: 75px; margin-bottom: 150px;">

        <section id="sectionSrchResult" class="overview-block-ptb" style="padding: 10px 0px; min-height: 300px;">
            <img src="images/fancybox/overlay-dot2.png" class="overlay-right-top-2" alt="#">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="text-left iq-title-box pr-lg-5" style="margin-bottom: 5px;">
                            <h2 class="iq-title text-uppercase">Settings</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-sm-center" style=" min-height: 300px;">
                    <div class="col-sm-12">
                        <form class='container' autocomplete="off">
                            <div class='row'>
                                <div class='col-12'>
                                    <div class="search-form display-flex admin-search-form">
                                        <span class="form-label" style="width: 300px;">Stripe Secret Key:&nbsp;</span>
                                        <input type="text" class="search-field" value="" role="presentation"
                                            autocomplete="off" name="stripe_secret_key" />
                                    </div>
                                </div>
                                <div class='col-12'>
                                    <div class="search-form display-flex admin-search-form">
                                        <span class="form-label" style="width: 300px;">Stripe API Key:&nbsp;</span>
                                        <input type="text" class="search-field" value="" role="presentation"
                                            autocomplete="off" name="stripe_api_key" />
                                    </div>
                                </div>
                                
                                <div class='col-12'>
                                    <div class="search-form display-flex admin-search-form">
                                        <span class="form-label" style="width: 300px;">Web Hook Key:&nbsp;</span>
                                        <input type="text" class="search-field" value="" role="presentation"
                                            autocomplete="off" name="web_hook_secret" />
                                    </div>
                                </div>
                                <div class='col-12'>
                                    <div class="search-form display-flex admin-search-form">
                                        <span class="form-label" style="width: 300px;">Full Access Pay
                                            Amount($):&nbsp;</span>
                                        <input type="number" class="search-field" value="" role="presentation"
                                            autocomplete="off" name="pay_amount" />
                                    </div>
                                </div>
                                <div class='col-12'>
                                    <div class="search-form display-flex admin-search-form">
                                        <span class="form-label" style="width: 300px;">Maximum reach number:&nbsp;</span>
                                        <input type="number" class="search-field" value="" role="presentation"
                                            autocomplete="off" name="max_free_num" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="popular-searches btn-container text-left"
                                        style="margin-top: 20px; margin-bottom: 0px;">
                                        <a class="iq-button btn-radius display-flex" href="javascript:saveSetting()">
                                            <i class="fa fa-save mr-2" aria-hidden="true" style="font-size: 25px;"></i>
                                            <span>Save</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <img src="images/fancybox/overlay.png" class="overlay-left-bottom" alt="#" style="z-index: -1">
        </section>

        <section id="sectionSrchResult" class="overview-block-ptb" style="padding: 10px 0px; min-height: 300px;">
            <img src="images/fancybox/overlay-dot2.png" class="overlay-right-top-2" alt="#">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="text-left iq-title-box pr-lg-5" style="margin-bottom: 5px;">
                            <h2 class="iq-title text-uppercase">Privacy Policy</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-sm-center" style=" min-height: 300px;">
                    <div class="col-sm-12">
                        <form class='container' autocomplete="off">
                            <div class="form-group">
                                <textarea id="privacy_policy" name="body"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="popular-searches btn-container text-left"
                                        style="margin-top: 5px; margin-bottom: 0px;">
                                        <a class="iq-button btn-radius display-flex" href="javascript:setTemsPolicy('privacy_policy')">
                                            <i class="fa fa-save mr-2" aria-hidden="true" style="font-size: 25px;"></i>
                                            <span>Save</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <img src="images/fancybox/overlay.png" class="overlay-left-bottom" alt="#" style="z-index: -1">
        </section>

        <section id="sectionSrchResult" class="overview-block-ptb" style="padding: 10px 0px; min-height: 300px;">
            <img src="images/fancybox/overlay-dot2.png" class="overlay-right-top-2" alt="#">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="text-left iq-title-box pr-lg-5" style="margin-bottom: 5px;">
                            <h2 class="iq-title text-uppercase">Terms</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-sm-center" style=" min-height: 300px;">
                    <div class="col-sm-12">
                        <form class='container' autocomplete="off">
                            <div class="form-group">
                                <textarea id="terms" name="body"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="popular-searches btn-container text-left"
                                        style="margin-top: 5px; margin-bottom: 0px;">
                                        <a class="iq-button btn-radius display-flex" href="javascript:setTemsPolicy('terms')">
                                            <i class="fa fa-save mr-2" aria-hidden="true" style="font-size: 25px;"></i>
                                            <span>Save</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <img src="images/fancybox/overlay.png" class="overlay-left-bottom" alt="#" style="z-index: -1">
        </section>

        <section id="sectionSrchResult" class="overview-block-ptb" style="padding: 10px 0px; min-height: 300px;">
            <img src="images/fancybox/overlay-dot2.png" class="overlay-right-top-2" alt="#">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="text-left iq-title-box pr-lg-5" style="margin-bottom: 5px;">
                            <h2 class="iq-title text-uppercase">Don't Sell My Info</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-sm-center" style=" min-height: 300px;">
                    <div class="col-sm-12">
                        <form class='container' autocomplete="off">
                            <div class="form-group">
                                <textarea id="dont_sell_info" name="body"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="popular-searches btn-container text-left"
                                        style="margin-top: 5px; margin-bottom: 0px;">
                                        <a class="iq-button btn-radius display-flex" href="javascript:setTemsPolicy('dont_sell_info')">
                                            <i class="fa fa-save mr-2" aria-hidden="true" style="font-size: 25px;"></i>
                                            <span>Save</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <img src="images/fancybox/overlay.png" class="overlay-left-bottom" alt="#" style="z-index: -1">
        </section>

        <div id="deleteModal" tabindex="-1" aria-hidden="true" class="modal fade">
            <div class="modal-dialog" size="lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Warning</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h3 style="text-align: center" id='emailWarning'>Are you sure to delete?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger">Yes</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>


    </main>
    <script src="js/summernote-bs5.min.js"></script>

    <script>
        const getUrl = "{{ route('api.admin.getSetting') }}";
        const setUrl = "{{ route('api.admin.saveSetting') }}";
        let lastQuery = '';
        let curPage = 1;
        let delEmail = '';

        function getSetting() {
            $('#preloader').show();
            $.ajax({
                url: getUrl,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    key: 'payments',
                },
                success: function(res) {
                    $('#preloader').hide();
                    if (!res.code) {
                        const value = JSON.parse(res.value);
                        $('input[name="stripe_secret_key"]').val(value.stripe_secret_key ?? '');
                        $('input[name="stripe_api_key"]').val(value.stripe_api_key ?? '');
                        $('input[name="web_hook_secret"]').val(value.web_hook_secret ?? '');
                        $('input[name="pay_amount"]').val(value.pay_amount ?? 0);
                        $('input[name="max_free_num"]').val(value.max_free_num ?? 1);
                    } else {
                        toastMessage('error', res.message ?? 'An error occured while searching data');
                    }

                },
                error: function(msg) {
                    $('#preloader').hide();
                    toastMessage('error', msg.message ?? 'An error occured while getting settings');
                    console.log(msg);
                }
            });
        }

        function saveSetting() {
            $('#preloader').show();
            $.ajax({
                url: setUrl,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    key: 'payments',
                    value: JSON.stringify({
                        stripe_secret_key: $('input[name="stripe_secret_key"]').val(),
                        stripe_api_key: $('input[name="stripe_api_key"]').val(),
                        web_hook_secret: $('input[name="web_hook_secret"]').val(),
                        pay_amount: $('input[name="pay_amount"]').val(),
                        max_free_num: $('input[name="max_free_num"]').val(),
                    })
                },
                success: function(res) {
                    $('#preloader').hide();
                    console.log(res);
                    if (!res.code) {
                        toastMessage('success', 'Saved settings successfully!');
                    } else {
                        toastMessage('error', res.message ?? 'An error occured while searching data');
                    }

                },
                error: function(msg) {
                    $('#preloader').hide();
                    toastMessage('error', msg.message ?? 'An error occured while getting settings');
                    console.log(msg);
                }
            });
        }

        function getTermsPolicy(key) {
            $('#preloader').show();
            $.ajax({
                url: getUrl,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    key: key,
                },
                success: function(res) {
                    $('#preloader').hide();
                    if (!res.code && res.value) {
                        const value = JSON.parse(res.value);
                        $('#' + key).summernote('code', value.content ?? '');
                    } else {
                        toastMessage('error', res.message ?? 'An error occured while searching data');
                    }

                },
                error: function(msg) {
                    $('#preloader').hide();
                    toastMessage('error', msg.message ?? 'An error occured while getting settings');
                    console.log(msg);
                }
            });
        }

        function setTemsPolicy(key) {
            $('#preloader').show();
            $.ajax({
                url: setUrl,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    key: key,
                    value: JSON.stringify({
                        content: $('#' + key).summernote('code'),
                    })
                },
                success: function(res) {
                    $('#preloader').hide();
                    console.log(res);
                    if (!res.code) {
                        toastMessage('success', 'Saved settings successfully!');
                    } else {
                        toastMessage('error', res.message ?? 'An error occured while searching data');
                    }

                },
                error: function(msg) {
                    $('#preloader').hide();
                    toastMessage('error', msg.message ?? 'An error occured while getting settings');
                    console.log(msg);
                }
            });
        }

        $('form').on('keypress', function(e) {
            var key = e.charCode || e.keyCode || 0;
            if (key == 13) {
                e.preventDefault();
            }
        });

        getSetting();

        $(document).ready(function() {
            $('#privacy_policy').summernote({
                height: 300,
            });
            $('#terms').summernote({
                height: 300,
            });
            $('#dont_sell_info').summernote({
                height: 300,
            });
            getTermsPolicy('privacy_policy');
            getTermsPolicy('terms');
            getTermsPolicy('dont_sell_info');
        });
    </script>
@endsection
