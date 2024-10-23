async function fetchShowArtists(showId) {
    try {
      const response = await fetch(`http://localhost:21000/shows/${showId}`, { headers: { 'Origin': 'http://localhost:21000' }});
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      const data = await response.json();
  
      return data.show; // Adjust to return the show object
    }
    catch (error) {
      console.error('There has been a problem with your fetch operation:', error);
    }
  }