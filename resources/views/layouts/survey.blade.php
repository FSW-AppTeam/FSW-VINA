<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, maximum-scale=1, minimum-scale=1, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">{{-- Chrome --}}
    <meta name="apple-mobile-web-app-capable" content="yes">{{-- Safari --}}
    <title>Dualnets</title>

    <!-- Include Plausible.IO script for privacy friendly stats -->
    <script defer data-domain="<?= parse_url(env('APP_URL'), PHP_URL_HOST) ?>" src="https://plausible.io/js/plausible.js"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>

    </style>


    <!-- Scripts -->
    @vite(['resources/sass/app.scss'])
    @vite(['resources/js/app.js'])

    <!-- Tailwind -->
    @stack('styles')

</head>
<body>
    @bladedebug('<a href="/reset" class="skip-link">Reset</a>')
    @ribbon()
    <main class="module_container">
        @yield('content')
    </main>

@livewireScripts
<script>

    // First we get the viewport height and we multiple it by 1% to get a value for a vh unit
  let card =  document.getElementsByTagName('body');
    let vh = (window.innerHeight * 0.01);
    // // Then we set the value in the --vh custom property to the root of the document
    document.documentElement.style.setProperty('--vh', `${vh}px`);

    // Quick address bar hide on devices like the iPhone
    //---------------------------------------------------
    function quickHideAddressBar() {
        setTimeout(function() {
            if(window.pageYOffset !== 0) return;
            window.scrollTo(0, window.pageYOffset + 1);
        }, 100);
    }
</script>

</body>
</html>
