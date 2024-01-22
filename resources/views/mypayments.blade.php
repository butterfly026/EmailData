@extends('layout')

@section('title', 'Payment History')

@section('content')

    <main class="page-content" style="margin-top: 75px;">
        
        <section id="sectionSrchResult" class="overview-block-ptb" style="padding: 10px 0px; min-height: calc(100vh - 223px);">
            <img src="images/fancybox/overlay-dot2.png" class="overlay-right-top-2" alt="#">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="text-left iq-title-box pr-lg-5" style="margin-bottom: 5px;">
                            <h2 class="iq-title text-uppercase">Payments Data</h2>
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
                                    <th style="min-width: 200px;">Expired At</th>
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
    </script>
@endsection
