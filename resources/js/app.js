import './bootstrap';

import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;

const Livewire = window.Livewire;

// :hover fix ios
document.addEventListener("click", x=>0);



//
// // First we get the viewport height and we multiple it by 1% to get a value for a vh unit
// let vh = (window.innerHeight * 0.01) + 1;
// // Then we set the value in the --vh custom property to the root of the document
// document.documentElement.style.setProperty('--vh', `${vh}px`);
//
// // Quick address bar hide on devices like the iPhone
// //---------------------------------------------------
// function quickHideAddressBar() {
//     setTimeout(function() {
//         if(window.pageYOffset !== 0) return;
//         window.scrollTo(0, window.pageYOffset + 1);
//     }, 100);
// }
//
// quickHideAddressBar();




const appHeight = () => {
    const doc = document.documentElement
    doc.style.setProperty('--app-height', `${window.innerHeight}px`);
}
window.addEventListener('resize', appHeight);
appHeight();



let mobileDevice = false;
if (window.TouchEvent) {
    mobileDevice = true;
}

/* iOS re-orientation fix */
// if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) {
//     /* iOS hides Safari address bar */
//     window.addEventListener("load",function() {
//         setTimeout(function() {
//             window.scrollTo(0, 1);
//         }, 1000);
//     });
// }

// document.addEventListener('touchstart', onDocumentTouchStart, false);

function onDocumentTouchStart(event) {
    if (event.touches[0]) {
        // alert('resize touchstart');

        // alert(event.touches[0].target.id);
        // console.log(event.touches[0]);
    }
}

document.addEventListener('livewire:initialized', (e) => {

    // block answer buttons
    document.addEventListener('select-answer-block', (ev) => {
        ev.preventDefault();
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
            ,500);
    })


    // Flag animation question 14
    let shadowPositionXFlag = -90;
    let indexFlag = 0;

    document.addEventListener('set-animation-flag-student', (ev) => {
        let studentShadowList = document.querySelector('[data-student-list]');
        let shadowList = document.querySelectorAll('.student-shadow-flex');

        shadowList[indexFlag].animate([
            {opacity: 1, transform: `translate3d(10px, 0, 0) scaleX(1)`},
            {opacity: 0, transform: `translate3d(-2000px, 0, 0) scaleX(2)`}
        ], {duration: 800, easing: 'ease-in', fill: 'forwards'});

        if(shadowList[(indexFlag + 1)] !== undefined){
            shadowList[(indexFlag + 1)].animate([
                {opacity: 1}
            ], {duration: 300, easing: 'ease', fill: 'forwards', delay: 800});
        }

        studentShadowList.animate([
            {transform: 'translateX(' + shadowPositionXFlag + 'px)'}
        ], {duration: 400, easing: 'ease', fill: 'forwards', delay: 500});

        shadowPositionXFlag -= 90;
        indexFlag++;
    });
    // end Flag animation question 14


    let shadowPositionX = -200;
    let index = 0;

    // Livewire.dispatchTo('dashboard', 'post-created', { postId: 2 })
    // let component = Livewire.first();

    document.addEventListener('set-block-btn-animation', (ev) => {
        ev.preventDefault();

        let setSquareArea = document.querySelector('#set-square-area');
        if(setSquareArea === null) return; // wrong btn block pressed

        let squareTop = setSquareArea.getBoundingClientRect().top;
        let blockBtn = ev.detail.event.target;
        let blockBtnTop = blockBtn.getBoundingClientRect().top;
        let studentBtn = document.querySelector('[data-start-student]');
        let studentShadowList = document.querySelector('[data-student-list]');

        blockBtn.style.setProperty('background-color', '#c2c0c0');

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
                            {opacity: 1, transform: `translate3d(10px, 0, 0) `},
                            {opacity: 0, transform: `translate3d(-2000px, 0, 0) `}
                        ], {duration: 800, easing: 'ease-in', fill: 'forwards'});

                        if(shadowList[(index + 1)] !== undefined){
                            shadowList[(index + 1)].animate([
                                {opacity: 1}
                            ], {duration: 300, easing: 'ease', fill: 'forwards', delay: 800});
                        }

                        studentShadowList.animate([
                            {transform: 'translateX(' + shadowPositionX + 'px)'}
                        ], {duration: 400, easing: 'ease', fill: 'forwards', delay: 500});

                        shadowPositionX -= 208;
                        index++;

                        if(studentBtn !== null){
                            // form step 22 relation question animations
                            studentBtn.animate([
                                {opacity: 0, transform: `translate3d(0, 0, 0)`},
                                {opacity: 1, transform: `translate3d(0, 0, 0)`}
                            ], {duration: 500, easing: 'ease', fill: 'forwards', delay: 1000});
                        }
                    }
                }

                // animation used in step 15 and more
                setTimeout(() => {
                    dispatchEvent(new Event('set-save-answer'));

                    if(blockBtn !== null) {
                        blockBtn.animate([
                            {opacity: 0, transform: `translateY(0)`},
                        ], {duration: 100, fill: 'forwards'});

                        blockBtn.animate([
                            {opacity: 1},
                        ], {duration: 100, easing: 'ease-in', fill: 'forwards', delay: 200});
                    }

                }, 100);

            }, 1200);

            // blockBtn.classList.add('animate__animated', 'animate__bounceOutLeft', 'animate_slow');
        }, {once: true});


        // answer buttonsblock animation from of question 15
        blockBtn.animate([
            {transform: `translateY(${(squareTop - blockBtnTop) - 2 }px)`},
        ], {duration: 400, easing: 'ease-in', fill: 'forwards'});

        blockBtn.animate([
            {opacity: 0},
        ], {duration: 200, easing: 'ease-in', fill: 'forwards', delay: 400});

    });


    // callback from button
    document.addEventListener('set-square-animation', (e) => {
        e.preventDefault();

        let blockBtn = e.detail.event.target;

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
