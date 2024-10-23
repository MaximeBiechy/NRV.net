async function fetchShowInfo(id) {
    try {
        const response = await fetch(`http://localhost:21000/shows/${id}/party`, { headers: { 'Origin': 'http://localhost:21001' }});
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        // Compile the Handlebars template
        var templateSource = document.querySelector('#ShowInfo').innerHTML;

        var template = Handlebars.compile(templateSource);
        var filledTemplate = template(data);

        // Insert the filled template into the DOM
        document.querySelector('#ShowInfo').innerHTML = filledTemplate;
    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
    }
}

fetchShowInfo(localStorage.getItem('id_show'));
localStorage.removeItem('id_show');