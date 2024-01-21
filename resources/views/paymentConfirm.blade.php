@extends('layout')

@section('title', 'Confirm Payment')

@section('content')
    <div class="container"
        style="height: calc(100vh - 147px); padding-top: 80px; display: flex; justify-content: center; align-items:center; flex-direction: column;">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body"
                        style="display: flex; flex-direction: column; justify-content:center; align-items: center;">
                        @if (empty($errMsg))
                            <img src="/images/verification_email.png" style="height: 300px">
                            <div class="alert alert-success" role="alert">
                                Thank you for paying <span>${{ $PayAmount }}</span> for EmailData, you can fully access marketing leads.
                                {{ __('') }}
                            </div>
                        @else
                            <img src="/images/error.png" style="height: 200px">
                            <div class="alert alert-warning" role="alert">
                                {{ $errMsg }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">        
        var elements = JSON.parse('{{ $PayElements }}');
        var userEmail = '{{ $UserEmail }}';
        const items = [{
            id: "xl-tshirt"
        }];
        let hasError = false;
        
        async function payout() {
            const {
                error
            } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    // Make sure to change this to your payment completion page
                    //return_url: "{{ route('payments.paySuccess') }}",
                    receipt_email: userEmail ?? '',
                },
            });
        }

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
                    payout();
                },
                error: function(msg) {
                    $('#preloader').hide();
                    console.log(msg);
                }
            });

        }
        initialize();

        
    </script>
@endsection
