
// Какой-то чужеродный код для селекта
var x, i, j, l, ll, selElmnt, a, b, c;

x = document.getElementsByClassName("custom-select");
l = x.length;

for (i = 0; i < l; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    ll = selElmnt.length;

    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);

    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    
    for (j = 0; j < ll; j++) {
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function(e) {
            var y, i, k, s, h, sl, yl;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            sl = s.length;
            h = this.parentNode.previousSibling;
            
            for (i = 0; i < sl; i++) {
                if (s.options[i].innerHTML == this.innerHTML) {
                    s.selectedIndex = i;
                    h.innerHTML = this.innerHTML;
                    y = this.parentNode.getElementsByClassName("same-as-selected");
                    yl = y.length;
                    for (k = 0; k < yl; k++) {
                    y[k].removeAttribute("class");
                    }
                    this.setAttribute("class", "same-as-selected");
                    break;
                }
            }

            h.click();
        });
        
        b.appendChild(c);
    }
    
    x[i].appendChild(b);
    
    a.addEventListener("click", function(e) {
        e.stopPropagation();
        closeAllSelect(this);
        this.nextSibling.classList.toggle("select-hide");
        this.classList.toggle("select-arrow-active");
    });
}

function closeAllSelect(elmnt) {
    var x, y, i, xl, yl, arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    xl = x.length;
    yl = y.length;
    
    for (i = 0; i < yl; i++) {
        if (elmnt == y[i]) {
            arrNo.push(i)
        } else {
            y[i].classList.remove("select-arrow-active");
        }
    }
    
    for (i = 0; i < xl; i++) {
        if (arrNo.indexOf(i)) {
            x[i].classList.add("select-hide");
        }
    }
}

document.addEventListener("click", closeAllSelect); 

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

    if(!toggle) { offSelect(); }
}

const urlParams = new URLSearchParams(window.location.search);
const category = urlParams.get('category');

if(category) {
    hiddenSelect.selectedIndex = category-1;
    
    let selElmnt = x[0].getElementsByTagName("select")[0];
    selectSelected.textContent=selElmnt[category-1].text;

    toggleSearchOption();
} else {
    offSelect();
}

searchGear.addEventListener('click', toggleSearchOption);


