var loader = document.querySelector('.loader');

async function fetchShowInfo(id) {
    console.log('Fetching show info for show with id:', id);
    try {
      const response = await fetch(`http://localhost:21000/shows/${id}/party`, { headers: { 'Origin': 'http://localhost' }});
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      const data = await response.json();
      console.log(data);
      // let new_date = new Date(data.party.date.date).toLocaleDateString('fr-FR', { weekday: 'short', day: '2-digit', month: '2-digit' });
      // data.party.date.date = new_date;
      var templateSource = document.querySelector('.showInfo').innerHTML;
      var template = Handlebars.compile(templateSource);
      var filledTemplate = template(data);
      document.querySelector('.showInfo').innerHTML = filledTemplate;
  
      loader.style.display = 'none';
    }
    catch (error) {
      console.error('There has been a problem with your fetch operation:', error);
    }
  }
  

  window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const showId = urlParams.get('id');
    if (showId) {
      console.log('Show id found in URL:', showId);
      fetchShowInfo(showId);
    }
  }