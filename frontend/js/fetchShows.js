'use strict';

var loader = document.querySelector('.loader');

async function fetchShows() {
    try {
        const response = await fetch('http://localhost:21000/shows', {headers: {'Origin': 'http://localhost:21001'}});
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        if (data.length === 0) {
            document.querySelector('#templateShow').innerHTML = 'No shows available';
            loader.style.display = 'none';
            return;
        } else {
            for (let i = 0; i < data.shows.length; i++) {
                data.shows[i].date.date = new Date(data.shows[i].date.date).toLocaleDateString('fr-FR', { weekday: 'short', day: '2-digit', month: '2-digit' });
            }
            var templateSource = document.querySelector('#templateShow').innerHTML;
            var template = Handlebars.compile(templateSource);
            var filledTemplate = template(data);

            addEventListener('click', function (event) {
                if (event.target.classList.contains('card')) {
                    const id = event.target.getAttribute('data-id');
                    this.localStorage.setItem('id_show', id);
                }
            });

            document.querySelector('#templateShow').innerHTML = filledTemplate;

            loader.style.display = 'none';
        }
    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
    }
}

fetchShows();
