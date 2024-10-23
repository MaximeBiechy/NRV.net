var loader = document.querySelector('.loader');

async function fetchShows() {
  try {
    const response = await fetch(`http://localhost:21000/shows/${id}/`, { headers: { 'Origin': 'http://localhost' }});
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const data = await response.json();

    var templateSource = document.querySelector('#ShowInfo').innerHTML;
    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);
    document.querySelector('#ShowInfo').innerHTML = filledTemplate;

    loader.style.display = 'none';
  }
  catch (error) {
    console.error('There has been a problem with your fetch operation:', error);
  }
}

fetchShows();
