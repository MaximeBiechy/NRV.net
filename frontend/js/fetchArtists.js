var loader = document.querySelector('.loader');

async function fetchArtists() {
    try {
      const response = await fetch('http://localhost:21000/artists', { headers: { 'Origin': 'http://localhost:5500'}});
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
    
      const data = await response.json();
      console.log(data);
      var templateSource = document.querySelector('#templateArtist').innerHTML;
      var template = Handlebars.compile(templateSource);
      var filledTemplate = template(data);
      
      document.querySelector('#templateArtist').innerHTML = filledTemplate;   


  
    }
    catch (error) {
      console.error('There has been a problem with your fetch operation:', error);
    }
}

fetchArtists();