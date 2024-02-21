import './bootstrap';

import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;

const Livewire = window.Livewire;

// :hover fix ios
document.addEventListener("click", x=>0);

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

    let stepIndex = 1;
    let shadowPositionX = -90;
    let index = 0;

    document.addEventListener('set-step-id-up', () => {
        setTimeout(() => {
            let formQuestion22 = document.querySelector('#scope-form-step22');
            index = 0;
            shadowPositionX = -90;

            if(formQuestion22 !== null){
                shadowPositionX = -210;
            }
        }, 500);
    });

    document.addEventListener('set-step-id-down', () => {
        setTimeout(() => {
            let formQuestion22 = document.querySelector('#scope-form-step22');
            index = 0;
            shadowPositionX = -90;

            if(formQuestion22 !== null){
                shadowPositionX = -210;
            }
        }, 500);
    });


    document.addEventListener('set-block-btn-animation', (ev) => {
        ev.preventDefault();

        let setSquareArea = document.querySelector('#set-square-area');
        let formQuestion22 = document.querySelector('#scope-form-step22');

        if(setSquareArea === null) return; // wrong btn block pressed

        let squareTop = setSquareArea.getBoundingClientRect().top;
        let blockBtn =  ev.detail.event !== undefined ? ev.detail.event.target : null;
        let studentBtn = document.querySelector('[data-start-student]');
        let studentShadowList = document.querySelector('[data-student-list]');

        let setAnimationStudnetShadowListing = () => {
            setTimeout(() => {
                let squareBtn = document.querySelector('[data-start-square]');

                if (studentBtn !== null || studentShadowList !== null) {
                    if (studentBtn !== null) {
                        // animation to left
                        studentBtn.animate([
                            {opacity: 1, transform: `translate3d(10px, 0, 0) scaleX(1)`},
                            {opacity: 0, transform: `translate3d(-2000px, 0, 0) scaleX(2)`}
                        ], {duration: 800, easing: 'ease-in', fill: 'forwards'});
                    }

                    if (squareBtn !== null) {
                        squareBtn.animate([
                            {opacity: 1, transform: `translate3d(10px, 0, 0) scaleX(1)`},
                            {opacity: 0, transform: `translate3d(-2000px, 0, 0) scaleX(2)`}
                        ], {duration: 800, easing: 'ease-in', fill: 'forwards'});
                    }

                    if (studentShadowList !== null) {
                        let shadowList = document.querySelectorAll('.student-shadow-flex');

                        if (shadowList[index] !== undefined) {
                            shadowList[index].animate([
                                // {opacity: 1, transform: `translateX(-2000px)`},
                                {opacity: 0, transform: `translateX(-2000px)`}
                            ], {duration: 800, easing: 'ease-in', fill: 'forwards'});

                            if (shadowList[(index + 1)] !== undefined) {
                                shadowList[(index + 1)].animate([
                                    {opacity: 1}
                                ], {duration: 300, easing: 'ease', fill: 'forwards', delay: 800});
                            }
                        }

                        let studentShadowList = document.querySelector('[data-student-list]');

                        studentShadowList.animate([
                            {transform: 'translateX( ' + (shadowPositionX) + 'px)'}
                        ], {duration: 400, easing: 'ease-in', fill: 'forwards', delay: 300});


                        if (formQuestion22 !== null) {
                            shadowPositionX -= 210;
                            stepIndex++;
                        } else {
                            shadowPositionX -= 90;
                        }

                        index++;

                        if (studentBtn !== null) {
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
                    if (blockBtn !== null) {
                        dispatchEvent(new Event('set-save-answer'));

                        blockBtn.animate([
                            {opacity: 0, transform: `translateY(0)`},
                        ], {duration: 100, fill: 'forwards'});

                        blockBtn.animate([
                            {opacity: 1},
                        ], {duration: 100, easing: 'ease-in', fill: 'forwards', delay: 200});
                    }

                }, 100);

            }, 1200);
        }

        if(blockBtn !== null) {
            let blockBtnTop = blockBtn.getBoundingClientRect().top;
            blockBtn.style.setProperty('background-color', '#c2c0c0');

            blockBtn.addEventListener('transitionend', (e) => {
                const setBlockBtn = new CustomEvent("set-answer-button-block", {
                    detail: {
                        id: blockBtn.id,
                        val: blockBtn.textContent
                    },
                });

                dispatchEvent(setBlockBtn);

                setAnimationStudnetShadowListing();
            }, {once: true});
            // answer buttons block animation from of question 15
            blockBtn.animate([
                {transform: `translateY(${(squareTop - blockBtnTop) - 2}px)`},
            ], {duration: 400, easing: 'ease-in', fill: 'forwards'});

            blockBtn.animate([
                {opacity: 0},
            ], {duration: 200, easing: 'ease-in', fill: 'forwards', delay: 400});

        } else {
            // from question 18, when no answer is giving
            setAnimationStudnetShadowListing();
        }
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

    // Used in step 12
    document.addEventListener('start-friend-bounce', () => {
        //Timeout is nodig om de animatie eventlistner te laten werken. Let op, met deze methode kan je nog steeds niet de
        // "animationstart" afvangen.
        window.setTimeout(function() {
            dispatchEvent(new Event('set-show-shrink-true'))
            const shrink = document.getElementById('next-student')
            shrink.addEventListener('animationend', function(){
                dispatchEvent(new Event('set-save-answer'));
            }, true);

        }, 50);
    });

    // Used in step 14
    document.addEventListener('set-animation-flag-student', () => {
        window.setTimeout(function() {
            const moveLeft = document.getElementById('step-student-button-0')
            moveLeft.addEventListener('animationend', function(){
                dispatchEvent(new Event('set-save-answer'));
            }, true);

        }, 50);
    }, {once: false});

    window.setTimeout(function() {
        let slowanimation = document.querySelector('.animate__animated.animate__slow')

        if(slowanimation === null) return;

        slowanimation.addEventListener('animationend', function(){
            dispatchEvent(new Event('set-enable-next'));
        }, true);
    }, 50);
});
