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

  let new_date_dd_mm = new Date(data.party.date.date).toLocaleDateString('fr-FR', { weekday: 'short', day: '2-digit', month: '2-digit' });
  data.party.date.date = new_date_dd_mm;

  let new_begin_date_dd_mm = new Date(data.party.begin.date).toLocaleDateString('fr-FR', { weekday: 'long', day: '2-digit', month: '2-digit' });
  data.party.begin.date = new_begin_date_dd_mm;


  console.log(data.party.shows[0].images[0].self.href)
  fillPartyTemplate(data);

})();


fetchShows();
