'use strict';

if (!localStorage.getItem('id_user')) {
    window.route('/login');
}else{
    fetchUser(localStorage.getItem('id_user'));
}


async function fetchTickets(id_user) {
    const response_tickets = await fetch(`http://localhost:21000/users/${id_user}/sold_tickets`);
    if (!response_tickets.ok) {
        throw new Error('Network response was not ok');
    }
    const data = await response_tickets.json();
    let result = data;
    for (let i = 0; i < data.sold_tickets.length; i++) {
        const response_party = await fetch(`http://localhost:21000${(data.sold_tickets[i].links.party.href)}`);
        if (!response_party.ok) {
            throw new Error('Network response was not ok');
        }
        result.sold_tickets[i].party = await response_party.json();
    }

    if(data.length === 0) {
        document.querySelector('#templateTicket').innerHTML = 'Vous avez aucun billets';
        loader.style.display = 'none';
        return;
    }
    else {
        var templateSource = document.querySelector('#templateTicket').innerHTML;
        var template = Handlebars.compile(templateSource);
        var filledTemplate = template(result);
        document.querySelector('#templateTicket').innerHTML = filledTemplate;
        loader.style.display = 'none';
    }
}

