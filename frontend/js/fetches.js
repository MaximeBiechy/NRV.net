console.log('fetches.js loaded');

// Récupérer l'ensemble des spectacles :
async function fetchShows() {
  try {
    const response = await fetch('http://localhost:21000/shows', { headers: { 'Origin': 'http://localhost' }});
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

// Récupérer les détails d'une soirée par son id :
async function fetchPartyById(id) {
  try {
    const response = await fetch(`http://localhost:21000/parties/${id}`, { mode: 'no-cors' });
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

// Récupérer l'ensemble des spectacles et les détails d'une soirée par l'id du spectacle :
async function fetchShowPartyById(showId) {
  try {
    const response = await fetch(`http://localhost:21000/shows/${showId}/party`, { mode: 'no-cors' });
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

//Page de test fetch :
const button_1 = document.querySelector('#shows');
const button_2 = document.querySelector('#party');
const button_3 = document.querySelector('#party_spectacles');

button_1.addEventListener('click', fetchShows);
button_2.addEventListener('click', () => fetchPartyById(1));
button_3.addEventListener('click', () => fetchShowPartyById(1));

//Tests Handlebars pour les spectacles (question 2) :

var template = Handlebars.compile(document.querySelector('.party').innerHTML);
console.log(template)
var filledTemplate = template(source);
document.querySelector('.party').innerHTML = filledTemplate;




