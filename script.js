// знаходимо всі значення параметрів get запиту
let params = window
.location
.search
.replace('?', '')
.split('&');
// створюємо масиви для значень фільтрів
let colours = [];
let sizes = [];
// за замовчуванням номер сторінки рівний 1
let page = 1;
for (let property in params) {
    let propertyName = decodeURIComponent(params[property]).split("=")[0];
    let propertyValue = decodeURIComponent(params[property]).split("=")[1];
    if(propertyName == "colour[]"){
        colours.push(propertyValue);
    }
    if(propertyName == "size[]"){
        if(propertyValue == "Over+size"){
            sizes.push("Over size");
        }
        sizes.push(propertyValue);
    }
    if(propertyName == "page"){
        page = propertyValue;
    }
}

// знаходимо елемент з дата-атрибутом data-page, який дорівнює номеру активної сторінки
// і присвоюємо йому стилі активного елемента
let activePage = document.querySelector(`[data-page="${page}"]`);
activePage.style.backgroundColor = "#C1C1C1";
activePage.style.fontWeight = "bold";

// знаходимо всі кнопки пагінації в документі
let paginationList = document.querySelectorAll(`[data-page]`);
// якщо кнопка пагінації лише одна, не показуємо її на сторінці
if(paginationList.length == 1){
    activePage.style.display = "none";
}











// шукаємо всі чекбокси з елементами списку кольорів і розмірів
// якщо значення чекбоксу входить в список вибраних фільтрів
// присвоюємо чекбоксу атрибут checked
let colourList = document.querySelectorAll('.colour_list>input[type="checkbox"]');
for (let item of colourList) {
    if(colours.includes(item.value)){
        item.checked = true;
    }   
}
let sizeList = document.querySelectorAll('.size_list>input[type="checkbox"]');
for (let item of sizeList) {
    if(sizes.includes(item.value)){
        item.checked = true;
    }   
}