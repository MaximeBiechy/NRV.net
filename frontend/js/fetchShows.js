'use strict';

var config = 'http://localhost:21001';
var config2 = 'http://localhost:21000';

console.log('fetchShows.js loaded');

var loader = document.querySelector('.loader');

async function fetchShows() {
    try {
        const response = await fetch(config2+'/shows', { headers: { 'Origin': config } });
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        if (data.length === 0) {
            document.querySelector('#templateShow').innerHTML = 'No shows available';
            loader.style.display = 'none';
            return;
        } else {
            // Format the date for each show
            for (let i = 0; i < data.shows.length; i++) {
                data.shows[i].date.date = new Date(data.shows[i].date.date).toLocaleDateString('fr-FR', {
                    weekday: 'short',
                    day: '2-digit',
                    month: '2-digit'
                });
            }

            // Handlebars template compilation
            var templateSource = document.querySelector('#templateShow').innerHTML;
            var template = Handlebars.compile(templateSource);
            var filledTemplate = template(data);

            // Add event listeners after rendering the template
            document.querySelector('#templateShow').innerHTML = filledTemplate;

            // Attach click event to each card or way
            document.querySelectorAll('.way').forEach(card => {
                card.addEventListener('click', function (event) {
                    const id = this.querySelector('.card').getAttribute('data-id');
                    localStorage.setItem('id_show', id); // Store id_show in localStorage
                    window.route(this); // Trigger navigation to /showInfo route
                });
            });

            loader.style.display = 'none';
        }
    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
    }
}

fetchShows();
