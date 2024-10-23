
var loader = document.querySelector('.loader');

async function fetchArtists() {
    try {
      const response = await fetch('http://localhost:21000/artists', { headers: { 'Origin': 'http://localhost' }});
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      const data = await response.json();
      var template = Handlebars.compile(document.querySelector('.artists').innerHTML);
      var filledTemplate = template(data);
      document.querySelector('.artists').innerHTML = filledTemplate;
  
        loader.style.display = 'none';
  
    }
    catch (error) {
      console.error('There has been a problem with your fetch operation:', error);
    }
  }
  

  fetchArtists();