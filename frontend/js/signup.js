'use strict';
var config = 'http://localhost:21001';
var config2 = 'http://localhost:21000';

// const { log } = require("handlebars");

const error_message = document.querySelector('#error_message');

function signup() {
    const password = document.querySelector('input[type="password"]').value;
    const confirmPassword = document.querySelector('input[id="confirm"]').value;

    if (password === confirmPassword) {
        async function login() {
            const username = document.querySelector('input[type="text"]').value;

            try {
                const response = await fetch(config2+'/signup', {
                    method: 'POST',
                    headers: {
                        'Origin': config,
                        'Authorization': 'Basic ' + btoa(username + ':' + password)
                    }
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                console.log(data);

                localStorage.setItem('authToken', data.token);
                localStorage.setItem('refreshToken', data.token_refresh);
                localStorage.setItem('email_user', data.email);
                localStorage.setItem('id_user', data.id);
                alert('Inscription réussie ! Maintenant connectez-vous !');
                document.querySelector('#navProfile').style.display = 'block';
                document.querySelector('#navLogin').style.display = 'none';
                window.route({ getAttribute: () => '/login' });

            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
                const error_message = document.querySelector('#error_message');
                error_message.style.display = 'block';
            }
        }

        login();
    } else {
        error_message.innerHTML = 'Les mots de passe ne correspondent pas.';
        error_message.style.display = 'block';
    }
}
