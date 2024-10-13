// Копирование значения мейн тайтла для хеадера телефонного тайтла
const mainTitleElement = document.querySelector('.main-title');
if(mainTitleElement) {
    const mainTitleText = mainTitleElement.textContent;
    const mainTitlePhoneElement = document.querySelector('.main-title-phone');
    if(mainTitlePhoneElement) {
        mainTitlePhoneElement.textContent = mainTitleText;
    } 
} 

// бургер
const burger = document.querySelector('.burger');
const header = document.querySelector('.header');
const overlay = document.querySelector('.overlay')

function headerTransToggle(force) {
    header.classList.toggle('header_transition', force);
    overlay.classList.toggle('overlay_transition', force);
}

function toggleBurger() {
    if(!document.querySelector('.header_transition')) {
        const burgerActive = burger.classList.toggle('burger_active');
        header.classList.toggle('header_active', burgerActive);
        overlay.classList.toggle('overlay_active', burgerActive);

        headerTransToggle(true)
        setTimeout(() => headerTransToggle(false), 550);
    }
}

burger.addEventListener('click', toggleBurger);
overlay.addEventListener('click', toggleBurger);