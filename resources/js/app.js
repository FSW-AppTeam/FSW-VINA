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
        console.log('select-answer-block')
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

    document.addEventListener('set-modal-othercountry', event => {
        // const options = {keyboard:false};
        const countryModal = new bootstrap.Modal(document.getElementById('countryModal'), {});
        countryModal.show();
        setTimeout(() => {
                let input = document.getElementById('searchCountry');
                input.value = '';
                input.focus();

                let btn = document.getElementById('country-set-btn');

                btn.addEventListener('click', function (e) {
                    countryModal.hide();
                }, {once: true})
            }
            ,500);
    })

    document.addEventListener('animate-shrink', (ev) => {
        console.log('animate-shrink')
        // answer buttons block animation from of question 15
        window.setTimeout(function() {
            dispatchEvent(new Event('set-show-shrink-true'));
        }, 50);
        window.setTimeout(function() {
            dispatchEvent(new Event('set-sub-step-up'));
        }, 2200);
    }, {once: false});

    document.addEventListener('block-btn-move-up-animation', (ev) => {
        console.log('block-btn-move-up-animation')
        ev.preventDefault();
        dispatchEvent(new Event('set-loading-true'));
        let setSquareArea = document.querySelector('#set-square-area');
        if(setSquareArea === null) return; // wrong btn block pressed

        let squareTop = setSquareArea.getBoundingClientRect().top;
        let blockBtn =  ev.detail.event !== undefined ? ev.detail.event.target : null;

        let blockBtnTop = blockBtn.getBoundingClientRect().top;
        blockBtn.style.setProperty('background-color', '#c2c0c0');

        // answer buttons block animation from of question 15
        blockBtn.animate([
            {transform: `translateY(${(squareTop - blockBtnTop) - 2}px)`},
        ], {duration: 400, easing: 'ease-in', fill: 'forwards'});

        blockBtn.animate([
            {opacity: 0},
        ], {duration: 900, easing: 'ease-in', fill: 'forwards', delay: 400});

        window.setTimeout(function() {
            blockBtn.animate([
                {transform: `translate3d(-2000px, ${(squareTop - blockBtnTop) - 2}px, 0) scaleX(1)`}
            ], {duration: 800, easing: 'ease-in', fill: 'forwards'});

            let subjectBtn = document.querySelector('#step-student-button-subject');
            if(subjectBtn !== null) {
                subjectBtn.animate([
                    {transform: `translateX(-2000px)`}
                ], {duration: 800, easing: 'ease-in', fill: 'forwards'});
            }
        }, 500);

        window.setTimeout(function() {
            // this sets the answer and call the save.
            dispatchEvent(new CustomEvent('set-answer-button-block', {
                detail: {
                    id: blockBtn.id,
                    val: blockBtn.textContent
                },
            }));
        }, 2000);
    }, {once: false});

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

    document.addEventListener('top-of-page', () => {
        document.getElementById('layout-wrapper')
            .scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});

    });

    // Used in the StudentSelected and
    document.addEventListener('start-friend-bounce', function() {
        console.log('start-friend-bounce')
        // TODO for some reason I cant get this working with the following:
        // const bounce = document.getElementById('start-friend-bounce')
        // bounce.addEventListener('transitionend', function(){
        //     console.log('animationend')
        // }, false);
        // Therefor I'm using only the timeout function.
        window.setTimeout(function() {
            let subjectBtn = document.querySelector('#start-friend-bounce-all');
            if(subjectBtn !== null) {
                subjectBtn.animate([
                    {transform: `translateX(-2000px)`}
                ], {duration: 800, easing: 'ease-in', fill: 'forwards'});
            }

        }, 50);
        window.setTimeout(function() {
            dispatchEvent(new Event('set-show-shrink-true'))
        }, 1200);
        window.setTimeout(function() {
            dispatchEvent(new Event('set-sub-step-up'));
        }, 1700);
    });

    // Used in question id 14
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
            dispatchEvent(new Event('set-loading-false'));
        }, true);
    }, 50);
});
