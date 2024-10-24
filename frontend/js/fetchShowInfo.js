var loader = document.querySelector('.loader');

async function fetchShowInfo(id) {
    try {
        const response = await fetch(`http://localhost:21000/shows/${id}/party`, { headers: { 'Origin': 'http://localhost:21001' }});
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        for (let i = 0; i < data.party.length; i++) {
            data.party[i].date.date = new Date(data.party[i].date.date).toLocaleDateString('fr-FR', {
                weekday: 'short',
                day: '2-digit',
                month: '2-digit'
            });};

        // Compile the Handlebars template
        var templateSource = document.querySelector('#ShowInfo').innerHTML;

        var template = Handlebars.compile(templateSource);
        var filledTemplate = template(data);

        // Insert the filled template into the DOM
        document.querySelector('#ShowInfo').innerHTML = filledTemplate;

        loader.style.display = 'none';
        
    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
    }
}

fetchShowInfo(localStorage.getItem('id_show'));