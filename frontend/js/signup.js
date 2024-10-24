'use strict';

function signup() {
    const password = document.querySelector('input[type="password"]').value;
    const confirmPassword = document.querySelector('input[id="confirm"]').value;

    if (password === confirmPassword) {
        async function login() {
            const username = document.querySelector('input[type="text"]').value;

            try {
                const response = await fetch('http://localhost:21000/signup', {
                    method: 'POST',
                    headers: {
                        'Origin': 'http://localhost:21001',
                        'Authorization': 'Basic ' + btoa(username + ':' + password)
                    }
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                localStorage.setItem('authToken', data.token);
                localStorage.setItem('refreshToken', data.token_refresh);
                localStorage.setItem('email_user', data.email);
                localStorage.setItem('id_user', data.id);

                alert('You are now logged in');

            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        }

        login();
    } else {
        alert('Passwords do not match');
    }
}