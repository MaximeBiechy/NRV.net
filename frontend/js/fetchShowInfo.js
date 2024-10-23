var loader = document.querySelector('.loader');

async function fetchShowInfo(id) {
    try {
      const response = await fetch(`http://localhost:21000/shows/${id}/party`, { headers: { 'Origin': 'http://localhost:21001' }});
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
  

  window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const showId = urlParams.get('id');
    if (showId) {
      fetchShowInfo(showId);
    }
  }