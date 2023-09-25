import './bootstrap';


import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;

const Livewire = window.Livewire;

// import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
// import Clipboard from '@ryangjchandler/alpine-clipboard'
// Alpine.plugin(Clipboard)
//
// Livewire.start();

document.addEventListener('livewire:initialized', (e) => {
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

    // Livewire.dispatchTo('dashboard', 'post-created', { postId: 2 })
    // let component = Livewire.first();

    let selectedBlockBtn;


    document.addEventListener('set-block-btn-animation', (ev) => {
        let setSquareArea = document.querySelector('#set-square-area');

        if(setSquareArea === null) return; // wrong btn block pressed

        let squareTop = setSquareArea.getBoundingClientRect().top;

        let blockBtn = ev.currentTarget.activeElement;
        selectedBlockBtn = blockBtn;

        let blockBtnTop = blockBtn.getBoundingClientRect().top;
        let studentBtn = document.querySelector('[data-start-student]');

        blockBtn.addEventListener('transitionend', (e) => {
            // element.classList.remove('my-element2');
            // element.classList.add('animate__animated', 'animate__bounceOutLeft');

            const setBlockBtn = new CustomEvent("set-answer-button-block", {
                detail: {
                    id: blockBtn.id,
                    val: blockBtn.textContent
                },
            });

            dispatchEvent(setBlockBtn);

            setTimeout(()=>{
                let squareBtn = document.querySelector('[data-start-square]');

                if(studentBtn !== null) {
                    // animation to left
                    studentBtn.animate([
                        {opacity: 1, transform: `translate3d(10px, 0, 0) scaleX(1)`},
                        {opacity: 0, transform: `translate3d(-2000px, 0, 0) scaleX(2)`}
                    ], {duration: 800, easing: 'ease-in', fill: 'forwards'});

                    squareBtn.animate([
                        {opacity: 1, transform: `translate3d(10px, 0, 0) scaleX(1)`},
                        {opacity: 0, transform: `translate3d(-2000px, 0, 0) scaleX(2)`}
                    ], {duration: 800, easing: 'ease-in', fill: 'forwards'});
                }

                setTimeout(() => {
                    dispatchEvent(new Event('set-save-answer'))
                } , 300);

            }, 1200);

            // blockBtn.classList.add('animate__animated', 'animate__bounceOutLeft', 'animate_slow');
        }, {once: true});


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



