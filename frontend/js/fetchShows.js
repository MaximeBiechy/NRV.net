var loader = document.querySelector('.loader');

async function fetchShows() {
    try {
        const response = await fetch('http://localhost:21000/shows', { headers: { 'Origin': 'http://localhost' }});
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        if (data.length === 0) {
            document.querySelector('#templateShow').innerHTML = 'No shows available';
            loader.style.display = 'none';
            return;
        }
        else{

        for (let i = 0; i < data.length; i++) {
            console.log(i);
            data[i].date.date = new Date(data[i].date.date).toLocaleDateString();
        }


        var templateSource = document.querySelector('#templateShow').innerHTML;
        var template = Handlebars.compile(templateSource);
        var filledTemplate = template(data);

        document.querySelector('#templateShow').innerHTML = filledTemplate;

        loader.style.display = 'none';}
    }
    catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
    }
}

fetchShows();
