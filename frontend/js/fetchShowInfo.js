'use strict';


async function fetchShowInfo(id) {
    try {
        const response = await fetch(`http://localhost:21000/shows/${id}/party`, { headers: { 'Origin': 'http://localhost:21001' }});
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        console.log(data);

        // Compile the Handlebars template
        var templateSource = document.querySelector('#templateShowInfo').innerHTML;
        var template = Handlebars.compile(templateSource);
        var filledTemplate = template(data);

        // Insert the filled template into the DOM
        document.querySelector('#showInfoContainer').innerHTML = filledTemplate;
    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
    }
}

this.localStorage.getItem('id_show', id);

            console.log(id);

fetchShowInfo(id);