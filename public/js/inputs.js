const inputs = document.querySelectorAll('.cute-input-text__input');

function checkInputs() { 
    inputs.forEach(input => {
        const label = input.previousElementSibling;

        label.classList.add('cute-input-text__label_active');
        if (input.value === '') { label.classList.remove('cute-input-text__label_active'); }
    });
}

inputs.forEach(input => {
    const label = input.previousElementSibling;
    
    input.addEventListener('focus', () => {
        label.classList.add('cute-input-text__label_active');
    });

    input.addEventListener('blur', () => {
        checkInputs(); // прокидываю на все инпуты, тк при автозаполнении возможно изменение сразу нескольких полей
    });

    input.addEventListener('change', () => {
        checkInputs();
    });
});

checkInputs();