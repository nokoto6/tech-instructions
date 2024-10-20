// Шестеренка поиска
const searchGear = document.querySelector('.search-categories-button__container');
const selectContainer = document.querySelector('.select-container');
const selectSelected = document.querySelector('.select-selected');
const hiddenSelect = document.querySelector('.hidden-select');

function offSelect() {
    selectSelected.textContent="Не выбрано";
    hiddenSelect.selectedIndex = -1;
}

function searchTransToggle(toggle) {
    selectContainer.classList.toggle('select-container_transition', toggle);
}

function toggleSearchOption() {
    const toggle = searchGear.classList.toggle('search-categories-button__container_active');
    selectContainer.classList.toggle('select-container_active', toggle);

    if(toggle) {
        searchTransToggle(false)
    } else {
        searchTransToggle(true)
        setTimeout(() => searchTransToggle(false), 250);
    }

    if(!toggle) { 
        offSelect(); 
        if (form) { form.submit(); } 
    }
}

const urlParams = new URLSearchParams(window.location.search);
const category = urlParams.get('category');

if(category) {
    hiddenSelect.selectedIndex = category-1;
    
    const templateText = document.querySelector('.categoryTemplate').content.textContent;
    console.log(templateText);

    selectSelected.textContent=templateText;

    toggleSearchOption();
} else {
    offSelect();
}

searchGear.addEventListener('click', toggleSearchOption);
