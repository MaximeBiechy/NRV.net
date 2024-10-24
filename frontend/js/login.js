'use strict';

async function login() {
    const username = document.querySelector('input[type="text"]').value;
    const password = document.querySelector('input[type="password"]').value;

    try {
        const response = await fetch('http://localhost:21000/signin', { method: 'POST',
            headers: {'Origin': 'http://localhost:21001','Authorization': 'Basic ' + btoa(username + ':' + password)} })
          ;

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();


        localStorage.setItem('authToken', data.token);
        localStorage.setItem('refreshToken', data.token_refresh);
        localStorage.setItem('email_user', data.email);
        localStorage.setItem('id_user', data.id);

        window.route({ getAttribute: () => '/' });

    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
       console.log("Application des styles :")
        const error_message = document.querySelector('#error_message');
        error_message.style.display = 'block';
    }
}
