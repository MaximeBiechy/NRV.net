var config = 'http://localhost:21001';
var config2 = 'http://localhost:21000';

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Login-display
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('authToken');
    if (token) {
        console.log('logged');
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

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//refresh token
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

async function refreshToken() {
    try {
        const response = await fetch(config2+'/refresh', {
            method: 'POST',
            headers: {
                'Origin': config,
                'Authorization': 'Bearer ' + localStorage.getItem('refreshToken'),
            },
        });
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        if (data.token_refresh){
        localStorage.setItem('authToken', data.token_refresh);
        document.querySelector('#navProfile').style.display = 'block';
        document.querySelector('#navLogin').style.display = 'none';
    }else{
        document.querySelector('#navProfile').style.display = 'none';
        document.querySelector('#navLogin').style.display = 'block';
    }
    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
    }
}

document.addEventListener('DOMContentLoaded', () => {
        refreshToken();
});
