<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>dwight </title>
</head>

<style>

    body {
        background-color: #2e54a6;
    }

    .module {
        height: 100vh; /* Use vh as a fallback for browsers that do not support Custom Properties */
        height: calc(var(--vh, 1vh) * 100);
        margin: 0;
        padding: 0;
        width: 100%;
    }

    .footer {
        position: absolute;
        bottom: 15px;
    }

    .module__item {
        align-items: center;
        display: flex;
        height: 20%;
        justify-content: center;
    }

    .module__item:nth-child(odd) {
        background-color: #fff;
        color: #F73859;
    }

    .module__item:nth-child(even) {
        background-color: #F73859;
        color: #F1D08A;
    }


</style>



<body>
{{--<div id="wrapper">--}}

{{--    <div class="content">content here </div>--}}

{{--    <div id="footer">--}}
{{--        footer here--}}
{{--    </div>--}}

{{--</div>--}}




<div class="module">
    <form>
        <input type="text">
    </form>
{{--    <div class="module__item">20%</div>--}}
{{--    <div class="module__item">40%</div>--}}
{{--    <div class="module__item">60%</div>--}}
{{--    <div class="module__item">80%</div>--}}
{{--    <div class="module__item">100%</div>--}}

</div>




<script>

    // First we get the viewport height and we multiple it by 1% to get a value for a vh unit
    let vh = (window.innerHeight * 0.01) + 1;
    // Then we set the value in the --vh custom property to the root of the document
    document.documentElement.style.setProperty('--vh', `${vh}px`);
    //
    // window.addEventListener("load",function() {
    //     setTimeout(function() {
    //         window.scrollTo(0, 1);
    //     }, 100);
    // });
    //
    // window.addEventListener('resize', () => {
    //     // We execute the same script as before
    //     let vh = window.innerHeight * 0.01;
    //     document.documentElement.style.setProperty('--vh', `${vh}px`);
    // });
    //

    // // Check that the current page can be scrolled first. Pad content if necessary.
    // if(document.documentElement.scrollHeight <= document.documentElement.clientHeight) {
    //     // Extend body height to overflow and cause scrolling
    //     bodyTag = document.getElementsByTagName('body')[0];
    //     bodyTag.style.height = document.documentElement.clientWidth / screen.width * screen.height + 'px'; // Viewport height at fullscreen
    //
    // }

    // Quick address bar hide on devices like the iPhone
    //---------------------------------------------------
    function quickHideAddressBar() {
        setTimeout(function() {
            if(window.pageYOffset !== 0) return;
            window.scrollTo(0, window.pageYOffset + 1);
        }, 100);
    }

    quickHideAddressBar();
</script>


</body>
</html>
