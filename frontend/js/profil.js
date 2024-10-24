'use strict';

async function fetchTickets(id_user, token) {
    console.log('Fetching tickets for user:', id_user);
    console.log('Token:', token);
    try {
        const response = await fetch(`http://localhost:21000/users/${id_user}/sold_tickets`, {
            headers: {
                'Authorization': `Bearer ${token}`,  // Correct the spelling
                'Origin': 'http://localhost:21001',
                // 'mode': 'no-cors',  // Remove mode: 'no-cors'
            }
            // Remove mode: 'no-cors', if possible
        });

        // Log the full response for debugging
        console.log(response);

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        let result = data;
        console.log(data);

        // Fetch additional party details
        for (let i = 0; i < data.sold_tickets.length; i++) {
            const response_party = await fetch(`http://localhost:21000${data.sold_tickets[i].links.party.href}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,  // Ensure token is sent again
                    'Origin': 'http://localhost:21000',
                    // 'mode': 'no-cors', 
                }
                // Remove mode: 'no-cors'
            });

            if (!response_party.ok) {
                throw new Error('Network response was not ok');
            }
            result.sold_tickets[i].party = await response_party.json();
        }

        if (data.length === 0) {
            document.querySelector('#templateTicket').innerHTML = 'Vous avez aucun billets';
            loader.style.display = 'none';
            return;
        } else {
            var templateSource = document.querySelector('#templateTicket').innerHTML;
            var template = Handlebars.compile(templateSource);
            var filledTemplate = template(result);
            document.querySelector('#templateTicket').innerHTML = filledTemplate;
            loader.style.display = 'none';
        }

    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
    }
}

// Check for user and token in localStorage
if (!localStorage.getItem('id_user')) {
    window.route('/login');
} else {
    fetchTickets(localStorage.getItem('id_user'), localStorage.getItem('authToken'));
}
