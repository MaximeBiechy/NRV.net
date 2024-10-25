////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Login-display
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('authToken');
    if (token) {
        document.querySelector('#navProfile').style.display = 'block';
        document.querySelector('#navLogin').style.display = 'none';
    } else {
        document.querySelector('#navProfile').style.display = 'none';
        document.querySelector('#navLogin').style.display = 'block';
    }
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//burger menu
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

localStorage.setItem('burgerOpen', 'false');
var burgerOpen = localStorage.getItem('burgerOpen');


const burger = document.querySelector('#burger');
const menu = document.querySelector('#menu');

burger.addEventListener('click', () => {
    if (menu.style.transform === 'translateX(0%)') {
        burgerOpen = localStorage.setItem('burgerOpen', 'true');
        menu.style.transform = 'translateX(100%)';
        burger.classList.remove('cross');

    } else {
        burgerOpen = localStorage.setItem('burgerOpen', 'false');
        menu.style.transform = 'translateX(0%)';
        burger.classList.add('cross');
    }
});

