@extends('layout')

@section('title', 'Privacy Policy')

@section('content')
    <main class="page-content" style="margin-top: 75px; margin-bottom: 150px;">
        <div id='content'></div>
    </main>
    <script>
        let content = $.parseHTML("{{ $content }}");
        let htmltxt = '';
        content?.forEach(function(dt) {
            htmltxt += dt?.data;
        })
        $('#content').html(htmltxt);
    </script>
@endsection
