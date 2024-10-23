// Récupérer l'ensemble des spectacles et les détails d'une soirée par l'id du spectacle :
async function fetchShowPartyById(showId) {
    try {
      const response = await fetch(`http://localhost:21000/shows/${showId}/party`, { headers: { 'Origin': 'http://localhost' }});
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      const data = await response.json();
      console.log(data);
    }
    catch (error) {
      console.error('There has been a problem with your fetch operation:', error);
    }
  }
  