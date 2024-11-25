let items = document.querySelectorAll('.slider .list .item');
let next = document.getElementById('next');
let prev = document.getElementById('prev');
let thumbnails = document.querySelectorAll('.thumbnail .item');

let countItem = items.length;
let itemActive = 0;


next.onclick = function() {
    itemActive = itemActive + 1;
    if(itemActive >= countItem) {
        itemActive = 0;
    }
    showSlider();
}
prev.onclick = function() {
    itemActive = itemActive - 1;
    if(itemActive < 0) {
        itemActive = countItem - 1;
    }
    showSlider();
}
let refreshInterval = setInterval(() =>{
    next.click();
}, 5000)

function showSlider() {
    let itemActiveOld = document.querySelectorAll('.slider .list .item.active');
    let thumbnailActiveOld = document.querySelectorAll('.thumbnail .item.active');
    
    itemActiveOld.forEach(item => item.classList.remove('active'));
    thumbnailActiveOld.forEach(item => item.classList.remove('active'));

    items[itemActive].classList.add('active');
    thumbnails[itemActive].classList.add('active');
    
    clearInterval(refreshInterval);
    refreshInterval = setInterval(() =>{
        next.click();
    }, 5000)
}

thumbnails.forEach((thumbnail, index) => {
    thumbnail.onclick = function() {
        itemActive = index;
        showSlider();
    }
});

window.addEventListener("scroll", function() {
    var header = document.querySelector("header");
    header.classList.toggle("sticky", window.scrollY > 0);
});
document.getElementById('search-input').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const carContainers = document.querySelectorAll('.toyota-container');

    carContainers.forEach(container => {
        const carName = container.getAttribute('data-car-name').toLowerCase();
        if (carName.includes(searchValue)) {
            container.style.display = '';
        } else {
            container.style.display = 'none';
        }
    });
});
// document.getElementById('filter-btn').addEventListener('click', function() {
//     const name = document.getElementById('search-name').value.toLowerCase();
//     const minPrice = parseFloat(document.getElementById('min-price').value) || 0;
//     const maxPrice = parseFloat(document.getElementById('max-price').value) || Infinity;

//     document.querySelectorAll('.car-item').forEach(item => {
//         const itemName = item.getAttribute('data-name').toLowerCase();
//         const itemPrice = parseFloat(item.getAttribute('data-price'));

//         if (itemName.includes(name) && itemPrice >= minPrice && itemPrice <= maxPrice) {
//             item.style.display = '';
//         } else {
//             item.style.display = 'none';
//         }
//     });
// });
