@extends('layout')

@section('title', 'Do not sell my info')

@section('content')
    <main class="page-content" style="margin-top: 125px; margin-bottom: 150px;">
        <div class="display-flex" style=" gap: 40px;">
            <div style="flex: 1">
                <div id='content'></div>
            </div>
            <div  style="flex: 1; padding: 20px;">
                <div style="padding: 10px; background: #04e9ea; border: 1px solid #04e9ea; border-radius: 30px; color: white; text-align: center;">
                    <h3 class="text-center ">To opt-out, please enter your</h3>
                    <h3 class="text-center ">Business Email Address.</h3>
                    <div class="text-left">Work Email</div>
                    <div class="search-form" autocomplete="off" >
                        <input type="email" id="inputCriteria" class="search-field" value=""
                            name="criteria" />
                        {{-- <button type="submit" class="search-submit" id="btnSearch"><i class="fa fa-search"></i><span
                                class="screen-reader-text">Search</span></button> --}}
                    </div>
                    <button class="btn" style="color: white; background: black; border: 1px solid #black; border-radius: 10; margin-top: 10px; margin-bottom: 20px;">
                        Click here to opt out of Emaildata ->
                    </button>
                </div>
            </div>
        </div>
    </main>
    <script>
        let content = $.parseHTML("{{ $content }}");
        let htmltxt = '';
        content?.forEach(function(dt) {
            htmltxt += dt?.data;
        });
        $('#content').html(htmltxt);
    </script>
@endsection
