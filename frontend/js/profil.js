'use strict';

var loader = document.querySelector('.loader');

async function fetchTickets(id_user, token) {
    try {
        const response = await fetch(`http://localhost:21000/users/${id_user}/sold_tickets`, {
            headers: {
                'Authorization': `Bearer ${token}`,  // Correct the spelling
                'Origin': 'http://localhost:21001'
            }
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
       
        const data = await response.json(); 
        if (data.sold_tickets.length === 0) {
            document.querySelector('#templateTicket').innerHTML = 'Vous avez aucun billets';}
        let result = data;

        // Fetch additional party details
        for (let i = 0; i < data.sold_tickets.length; i++) {
            const response_party = await fetch(`http://localhost:21000${data.sold_tickets[i].links.party.href}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,  // Ensure token is sent again
                    'Origin': 'http://localhost:21000',
                }
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
            for (let i = 0; i < result.sold_tickets.length; i++) {
                result.sold_tickets[i].party.party.date.date = new Date(result.sold_tickets[i].party.party.date.date).toLocaleDateString('fr-FR', {
                    weekday: 'short',
                    day: '2-digit',
                    month: '2-digit'
                });
            }
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

document.querySelector('#name').innerHTML = localStorage.getItem('email_user');

fetchTickets(localStorage.getItem('id_user'), localStorage.getItem('authToken'));


async function printTickets() {
    var tickets = document.querySelectorAll('.ticket');
    if (tickets.length === 0) {
        alert("Vous n'avez pas de billets à imprimer");
        return;
    } else {
        tickets.forEach(ticket => {
            var printWindow = window.open('', '', 'height=400,width=600');
            printWindow.document.write('<html><head><title>Print Ticket</title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(ticket.outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
    }
}
