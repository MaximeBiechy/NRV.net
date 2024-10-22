//loader
  var loader = document.querySelector('.loader');

// Récupérer l'ensemble des spectacles :
async function fetchShows() {
  try {
    const response = await fetch('http://localhost:21000/shows', { headers: { 'Origin': 'http://localhost' }});
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const data = await response.json();
      var template = Handlebars.compile(document.querySelector('.shows').innerHTML);
      var filledTemplate = template(data);
      document.querySelector('.shows').innerHTML = filledTemplate;


  }
  catch (error) {
    console.error('There has been a problem with your fetch operation:', error);
  }
}

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

// Récupérer les détails d'une soirée par son id :
async function fetchPartyById(id) {
  try {
    const response = await fetch(`http://localhost:21000/parties/${id}`,{ headers: { 'Origin': 'http://localhost' }});
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const data = await response.json();
    console.log(data);
    return data;
  }
  catch (error) {
    console.error('There has been a problem with your fetch operation:', error);
  }
}

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

//Vadim : Handlebars pour les soirées (question 2) :
function fillPartyTemplate(data) {
  var template = Handlebars.compile(document.querySelector('.party').innerHTML);
  var filledTemplate = template(data);
  document.querySelector('.party').innerHTML = filledTemplate;
}

(async () => {
  const data = await fetchPartyById('a0b7566b-6fdd-4e34-bbab-41d882de9c07');
  let new_date = new Date(data.party.date.date).toLocaleDateString('fr-FR', { weekday: 'short', day: '2-digit', month: '2-digit' });
  data.party.date.date = new_date;
  fillPartyTemplate(data);
})();
// Fonction pour ajouter des gestionnaires d'événements aux cartes de spectacle


fetchShows();
fetchArtists();

async function fetchShowInfo(id) {
  console.log('Fetching show info for show with id:', id);
  try {
    const response = await fetch(`http://localhost:21000/shows/${id}/party/`, { headers: { 'Origin': 'http://localhost' }});
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const data = await response.json();
    console.log(data);

    var templateSource = document.querySelector('.showInfo').innerHTML;
    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);
    document.querySelector('.showInfo').innerHTML = filledTemplate;
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
  } else {
    console.log('No show id found in URL');
  }
}




