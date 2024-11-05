'use strict';

var config = 'http://localhost:21001';
var config2 = 'http://localhost:21000';

async function login() {
    const username = document.querySelector('input[type="text"]').value;
    const password = document.querySelector('input[type="password"]').value;

    try {
        const response = await fetch(config2+'/signin', { method: 'POST',
            headers: {'Origin': config,'Authorization': 'Basic ' + btoa(username + ':' + password)} })
          ;

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();


        localStorage.setItem('authToken', data.token);
        localStorage.setItem('refreshToken', data.token_refresh);
        localStorage.setItem('email_user', data.email);
        localStorage.setItem('id_user', data.id);

        document.querySelector('#navProfile').style.display = 'block';
        document.querySelector('#navLogin').style.display = 'none';

        window.route({ getAttribute: () => '/profile' });

    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
        const error_message = document.querySelector('#error_message');
        error_message.style.display = 'block';
    }
}
