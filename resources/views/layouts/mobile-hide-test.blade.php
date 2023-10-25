<!--
Author: <Anthony Sychev> (hello at dm211 dot com | a.sychev at jfranc dot studio)
Buy me a coffe: https://www.buymeacoffee.com/twooneone
Untitled-1 (c) 2022
Created:  2022-01-25 20:06:02
Desc: Attach some dom element on the bottom of screen as absolute, triggered to move on resize address bar.
-->

<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <style>
        :root {
            --webkit-footer-gap: 80px;
        }

        html,
        body {
            padding: 0;
            margin: 0;
        }

        .wrapper {
            position: relative;
            display: block;
            width: 100%;
            height: 102vh;
            border: 1px purple dashed;
        }

        .container {
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            border: 1px green dashed;
            background-color: red;
        }

        @supports (-webkit-touch-callout: none) {
            .on-footer {
                position: absolute;
                bottom: 0;
                transition: padding 100ms;
                padding-bottom: calc(100vh - var(--webkit-footer-gap) + 2%);
            }

            .webkit-gap {
                position: fixed;
                top: 0;
                bottom: 0;

                display: block;
                width: 100%;
                height: 100%;
                z-index: -1;
            }
        }
    </style>
</head>

<body>
<div class="webkit-gap"></div>
<div class="wrapper">
    <div class="container">
        <div> iPhone Sample gap "absolute" content on resize footer address bar.</div>

        <div class="on-footer">Footer content with 2% gap from bottom.</div>
    </div>
</div>
</body>

<script>
    new ResizeObserver((entries) => {
        entries.forEach((entry) => {
            const windowFullHeight = parseFloat(window.outerHeight);
            document.documentElement.style.setProperty("--webkit-footer-gap", `${entry.contentRect.height}px`);
        });
    }).observe(document.querySelector(".webkit-gap"));



    // window.addEventListener("load",function() {
    //     setTimeout(function() {
    //         window.scrollTo(0, 1);
    //     }, 2000);
    // });




    // Quick address bar hide on devices like the iPhone
    //---------------------------------------------------
    function quickHideAddressBar() {
        setTimeout(function() {
            if(window.pageYOffset !== 0) return;
            window.scrollTo(0, window.pageYOffset + 1);

        }, 1000);
    }

    quickHideAddressBar();


    // window.onresize = function() {
    //     document.body.height = window.innerHeight;
    // };
    // window.onresize(); // called to initially set the height.

</script>

</html>
