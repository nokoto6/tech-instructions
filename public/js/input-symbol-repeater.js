const inputElement = document.getElementById('google_symbol_name');
const spanElement = document.getElementById('repeater');

function updateSpan() {
    spanElement.textContent = inputElement.value;
}

inputElement.addEventListener('input', updateSpan);