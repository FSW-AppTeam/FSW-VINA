import './bootstrap';

import * as bootstrap from 'bootstrap';
// import alert from "bootstrap/js/src/alert.js";

window.bootstrap = bootstrap;

const Livewire = window.Livewire;


// import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
// import Clipboard from '@ryangjchandler/alpine-clipboard'
// Alpine.plugin(Clipboard)
//
// Livewire.start();

//
// const resizeOps = () => {
//     // document.documentElement.style.setProperty("--vh", window.innerHeight * 0.01 + "px");
//
//     let body_window = document.getElementById('layout-wrapper');
//     body_window.style.setProperty("height",  window.innerHeight * 0.01 + "px");
//
//
//     // let vh = window.innerHeight * 0.01;
//     // document.documentElement.style.setProperty('--vh', `${vh}px`);
// };
//
// resizeOps();
// window.addEventListener("resize", resizeOps);



const appHeight = () => {
    const doc = document.documentElement
    doc.style.setProperty('--app-height', `${window.innerHeight}px`)
}
window.addEventListener('resize', appHeight)
appHeight();




let mobileDevice = false;
if (window.TouchEvent) {
    mobileDevice = true;
}

// document.addEventListener('touchstart', onDocumentTouchStart, false);

function onDocumentTouchStart(event) {
    if (event.touches[0]) {
        alert("touched");

        alert(event.touches[0].target.id);
        console.log(event.touches[0]);
    }
}


function eventHandler(e) {
    if( e.target == e.currentTarget ) {
        alert("error - browsers should never activate this!");
        return; //error - browsers should never activate this!
    }
}


document.addEventListener('livewire:initialized', (e) => {

    // addEventListener("touchend", (event) => {
    //     alert("touched")
    // }, false);

    // object.ontouchstart = myScript;


    // block answer buttons
    document.addEventListener('select-answer-block', (ev) => {
        ev.preventDefault();
        // let blockBtn = ev.currentTarget.activeElement;

        let blockBtn = ev.detail.event.target;


        if(blockBtn.firstElementChild !== null){
            blockBtn.firstElementChild.checked = true;

            const countryName = blockBtn.lastElementChild.innerText;

            const setAnswerButtonBlock = new CustomEvent("set-answer-block-answer-id", {
                detail: {
                    id: blockBtn.firstElementChild.id,
                    countryName: countryName
                },
            });

            dispatchEvent(setAnswerButtonBlock);
        }

        // document.removeEventListener('select-answer-block', ()=>{});
    });



    document.addEventListener('set-modal-flag', event => {
        // const options = {keyboard:false};
        const countryModal = new bootstrap.Modal(document.getElementById('countryModal'), {});
        countryModal.show();

        setTimeout(() => {
                let input = document.getElementById('countryDataList');
                input.value = '';
                input.focus();

                // input.dispatchEvent(new KeyboardEvent('keydown', {'key': 'ArrowDown'}));

                let btn = document.getElementById('country-set-btn');
                let countryVar = "";

                document.getElementById('countryDataList').addEventListener('input', function () {
                    const val = document.getElementById("countryDataList").value;
                    btn.disabled = !(val !== "" && val.length > 2);

                    countryVar = val;
                });

                btn.addEventListener('click', function (e) {
                    const setFlag = new CustomEvent("set-flag-from-js", {
                        detail: {
                            country: countryVar,
                        },
                    });

                    dispatchEvent(setFlag);

                    countryModal.hide();
                }, {once: true})
            }
            , 500);
    })


    const dwight_animation2 = (e) => {
        // const element = document.querySelector('.my-element');
        const element = e.currentTarget.activeElement;

        console.log(element);

        element.style.setProperty('--animate-duration', '1s');
        // element.style.setProperty('transform', 'translate3d(100%, 0, 0)');
        element.style.setProperty('--animate-transform', 'translate3d(100%, 0, 0)');

        element.classList.add('animate__animated', 'animate__backOutUp');

        element.addEventListener('animationend', () => {
            // alert('yes done! ');
        });
    }


    let shadowPositionX = -247;
    let index = 0;

    // Livewire.dispatchTo('dashboard', 'post-created', { postId: 2 })
    // let component = Livewire.first();

    document.addEventListener('set-block-btn-animation', (ev) => {
        let setSquareArea = document.querySelector('#set-square-area');
        if(setSquareArea === null) return; // wrong btn block pressed

        let squareTop = setSquareArea.getBoundingClientRect().top;
        let blockBtn = ev.currentTarget.activeElement;

        let blockBtnTop = blockBtn.getBoundingClientRect().top;
        let studentBtn = document.querySelector('[data-start-student]');
        let studentShadowList = document.querySelector('[data-student-list]');

        blockBtn.addEventListener('transitionend', (e) => {
            const setBlockBtn = new CustomEvent("set-answer-button-block", {
                detail: {
                    id: blockBtn.id,
                    val: blockBtn.textContent
                },
            });

            dispatchEvent(setBlockBtn);

            setTimeout(() => {
                let squareBtn = document.querySelector('[data-start-square]');

                if (studentBtn !== null || studentShadowList !== null) {
                   if(studentBtn !== null){
                       // animation to left
                       studentBtn.animate([
                           {opacity: 1, transform: `translate3d(10px, 0, 0) scaleX(1)`},
                           {opacity: 0, transform: `translate3d(-2000px, 0, 0) scaleX(2)`}
                       ], {duration: 800, easing: 'ease-in', fill: 'forwards'});
                   }

                    if(squareBtn !== null) {
                        squareBtn.animate([
                            {opacity: 1, transform: `translate3d(10px, 0, 0) scaleX(1)`},
                            {opacity: 0, transform: `translate3d(-2000px, 0, 0) scaleX(2)`}
                        ], {duration: 800, easing: 'ease-in', fill: 'forwards'});
                    }

                    if(studentShadowList !== null){
                        let shadowList = document.querySelectorAll('.student-shadow-flex');

                        shadowList[index].animate([
                            {opacity: 1, transform: `translate3d(10px, 0, 0) scaleX(1)`},
                            {opacity: 0, transform: `translate3d(-2000px, 0, 0) scaleX(2)`}
                        ], {duration: 800, easing: 'ease-in', fill: 'forwards'});

                        if(shadowList[(index + 1)] !== undefined){
                            shadowList[(index + 1)].animate([
                                {opacity: 1}
                            ], {duration: 300, easing: 'ease', fill: 'forwards', delay: 800});
                        }
                        studentShadowList.animate([
                            {transform: 'translateX(' + shadowPositionX + 'px)'}
                        ], {duration: 400, easing: 'ease', fill: 'forwards', delay: 500});

                        shadowPositionX -= 250;
                        index++;

                        if(studentBtn !== null){
                            // form step 22 relation question animations
                            studentBtn.animate([
                                {opacity: 0, transform: `translate3d(0, 0, 0) scaleX(1)`},
                                {opacity: 1, transform: `translate3d(0, 0, 0)`}
                            ], {duration: 500, easing: 'ease', fill: 'forwards', delay: 1000});
                        }
                    }
                }

                // last animation
                setTimeout(() => {
                    dispatchEvent(new Event('set-save-answer'));
                }, 100);

            }, 1200);

            // blockBtn.classList.add('animate__animated', 'animate__bounceOutLeft', 'animate_slow');
        }, {once: true});


        // answer buttons
        blockBtn.animate([
            {transform: `translateY(${(squareTop - blockBtnTop) - 5}px)`},
        ], {duration: 500, easing: 'ease-in', fill: 'forwards'});

        blockBtn.animate([
            {opacity: 0},
        ], {duration: 500, easing: 'ease', fill: 'forwards', delay: 400});

    });


    // callback from button
    document.addEventListener('set-square-animation', (e) => {
        let blockBtn = e.currentTarget.activeElement;

        blockBtn.animate([
            {opacity: 0}
        ], {duration: 1000, easing: 'ease-out', fill: 'forwards', delay: 100});

        const setBackBlockBtn = new CustomEvent("set-remove-selected-square", {
            detail: {
                id: blockBtn.id,
            },
        });

        dispatchEvent(setBackBlockBtn);
    });


});
