<style>
    .btn-send {
        display: flex;
        align-items: center;
        gap: 10px;
        border-radius: 5px !important;
        text-align: center;
        padding: 10px 20px;
        margin-top: 10px;
    }
</style>
<!-- Contact Start -->
<div style="padding: 20px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <img width="100%" src="/images/contactus.jpg"/>
                {{-- <iframe class="w-100 contact-ifream"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1330.4631958602688!2d-99.13687703295636!3d19.40729862672674!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1fee70844e593%3A0xd82bd61ef50e13b8!2zSm9zw6kgUGXDs24gQ29udHJlcmFzIDE1NSwgQWxnYXLDrW4sIEN1YXVodMOpbW9jLCAwNjg4MCBDaXVkYWQgZGUgTcOpeGljbywgQ0RNWCwgTWV4aWNv!5e0!3m2!1sen!2sru!4v1708091318741!5m2!1sen!2sru"
                    allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
            </div>
            <div class="col-lg-6 col-md-12">
                <div class=" text-left iq-title-box iq-title-default iq-title-box-2">
                    <div class="iq-title-icon">
                    </div>
                    <h2 class="iq-title">
                        Contact With US </h2>

                    <p class="iq-title-desc">It is a long established fact that a reader will be distracted</p>
                </div>
                <div role="form" class="wpcf7" lang="en-US" dir="ltr">
                    <div class="screen-reader-response"></div>
                    <form class="wpcf7-form">
                        <div class=row>
                            <div class="col-lg-6">
                                <span class="wpcf7-form-control-wrap first-name">
                                    <input type="text" value="" size="40" id="txtFName"
                                        class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                        aria-required="true" aria-invalid="false" placeholder="First Name" />
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <span class="wpcf7-form-control-wrap last-name">
                                    <input type="text" value="" size="40"  id="txtLName"
                                        class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required"
                                        aria-required="true" aria-invalid="false" placeholder="Last Name" />
                                </span>
                            </div>
                            <div class="col-lg-12">
                                <span class="wpcf7-form-control-wrap your-email">
                                    <input type="email" value="" size="40"
                                        class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email"
                                        aria-required="true"  id="txtEmail" aria-invalid="false" placeholder="Email Address" />
                                </span>
                            </div>
                            <div class="col-lg-12">
                                <p> <span class="wpcf7-form-control-wrap your-message">
                                        <textarea cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" aria-invalid="false"
                                            placeholder="Message" id="txtMsg"></textarea>
                                    </span>
                                </p>
                            </div>
                            <div class="col-lg-12 text-center" style="display: flex; justify-content: center;">
                                <a class="iq-button btn-radius btn-send" id="btnSend"><i class="fa fa-send"></i><span
                                        class="">Send</span></a>
                            </div>
                        </div>
                        <div class="wpcf7-response-output wpcf7-display-none"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Contact End -->

{{-- <section class="light-gray-bg overview-block-pb iq-pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-4  col-md-6">
                <div class="iq-process iq-process-step-style-2 text-center">

                    <div class="iq-process-step">

                        <div class="iq-step-content">
                            <i aria-hidden="true" class="ion ion-ios-location"></i>
                        </div>
                        <div class="iq-step-text-area">
                            <h4 class="iq-step-title">Location</h4>
                            <span class="iq-step-desc">Address of Email Data</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4  col-md-6">
                <div class="iq-process iq-process-step-style-2 text-center">
                    <div class="iq-process-step">
                        <div class="iq-step-content">
                            <i aria-hidden="true" class="ion ion-ios-email"></i>
                        </div>
                        <div class="iq-step-text-area">
                            <h4 class="iq-step-title">Email</h4>
                            <p>support@emaildata.co
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4  col-md-6">
                <div class="iq-process iq-process-step-style-2 text-center">
                    <div class="iq-process-step">
                        <div class="iq-step-content">
                            <i aria-hidden="true" class="ion ion-ios-telephone"></i>
                        </div>
                        <div class="iq-step-text-area">
                            <h4 class="iq-step-title">Phone</h4>
                            <span class="iq-step-desc">+1 234 567 1234</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script type="text/javascript">
    (function() {
        emailjs.init({
            publicKey: "minTsIvFe1Q0OTadK",
        });
        $('#btnSend').click(() => {
            var templateParams = {
                to_name: 'Support Team',
                from_name: $('#txtFName').val() + ' ' + $('#txtLName').val(),
                message: $('#txtMsg').val(),
                reply_to: $('#txtEmail').val()
            };

            emailjs.send('service_fjm1f4o', 'template_ynmozrh', templateParams).then(
                (response) => {
                    console.log('SUCCESS!', response.status, response.text);
                },
                (error) => {
                    console.log('FAILED...', error);
                },
            );
        })

    })();
</script>
