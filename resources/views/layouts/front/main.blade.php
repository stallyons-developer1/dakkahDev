<!DOCTYPE html>
<html lang="{{  str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Dakkah</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (Config::get('app.locale') == 'ar')
{{--        <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/main.css') }}">--}}
    @else
{{--        <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/css/main.css') }}">--}}
    @endif
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Almarai&display=swap">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bluebird/3.3.4/bluebird.min.js"></script>
    <script src="https://secure.gosell.io/js/sdk/tap.min.js"></script>
</head>
<script>
    var locale = "{{ Config::get('app.locale')}}";
    let dir ='ltr';
    if(locale == 'ar'){
        dir = 'rtl';
    }
</script>
<body>
<div id="front_app">
    <app-front></app-front>
</div>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>--}}
{{--<script>--}}
{{--    jQuery( document ).ready(function() {--}}
{{--        jQuery('.toggle-button').on('click', function(){--}}
{{--            jQuery('.toggle').slideToggle("medium");--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
<script>
    var info = {!! json_encode(session()->get('user')) !!}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

{{--<script type="text/javascript" src="https://js.stripe.com/v3/"></script>--}}

<script src="{{asset("/js/app.js")}}"></script>
<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
<script>
    jQuery( document ).ready(function() {
        jQuery('.toggle-button').on('click', function(){
            jQuery('.toggle').slideToggle("medium");
        });
    });
</script>
</body>
</html>
