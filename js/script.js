
console.log('JavaScript file is loaded');
'use strict';


// add eventListener on multiple elements

const addEventOnElements = function (elements, eventType, callback) {
    for (let i = 0, len = elements.length; i < len; i++) {
        elements[i].addEventListener(eventType, callback);
    }
}

// mobile navbar toggler
const navbar = document.querySelector("[data-navbar]");
const navTogglers = document.querySelectorAll("[data-nav-toggler]");
const toggleNav = () => navbar.classList.toggle("active");

addEventOnElements(navTogglers, "click", toggleNav);

// header animation
// when scrolldown to 100px header will be active

const header = document.querySelector("[data-header]");
window.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
        header.classList.add("active");
    } else {
        header.classList.remove("active");
    }
});

// Slider
const slider = document.querySelector("[data-slider]");
const sliderContainer = document.querySelector("[data-slider-container]");
const sliderPrevBtn = document.querySelector("[data-slider-prev]");
const sliderNextBtn = document.querySelector("[data-slider-next]");

let totalSliderVisibleItems = Number(getComputedStyle(slider).getPropertyValue("--slider-items"));

let totalSlidableItems = sliderContainer.childElementCount - totalSliderVisibleItems;
let currentSlidePos = 0;

const moveSliderItem = function () {
    sliderContainer.style.transform = `translateX(-${sliderContainer.children[currentSlidePos].offsetLeft}px)`;
}

// next slide
const slideNext = function () {
    const slideEnd = currentSlidePos >= totalSlidableItems ? currentSlidePos = 0 : currentSlidePos++;

    moveSliderItem();
}

sliderNextBtn.addEventListener('click', slideNext);

//prev slide
const slidePrev = function () {
    if (currentSlidePos <= 0) {
        currentSlidePos = totalSlidableItems;
    } else {
        currentSlidePos--;
    }

    moveSliderItem();
}

sliderPrevBtn.addEventListener('click', slidePrev);

//responsive
window.addEventListener('resize', function () {
    totalSliderVisibleItems = Number(getComputedStyle(slider).getPropertyValue("--slider-items"));

    totalSlidableItems = sliderContainer.childElementCount - totalSliderVisibleItems;

    moveSliderItem();
});

