'use strict';

async function login() {
    const username = document.querySelector('input[type="text"]').value;
    const password = document.querySelector('input[type="password"]').value;

    try {
        const response = await fetch('http://localhost:21000/signin', { method: 'POST', headers: {'Origin': 'http://localhost:5500'},
            body: JSON.stringify({ email: username, password: password })
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        console.log(data);

        
        localStorage.setItem('authToken', data.token);

    
        window.location.href = '/frontend/';
    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
    }
}