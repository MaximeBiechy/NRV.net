console.log('fetches.js loaded');

// Récupérer l'ensemble des spectacles :
async function fetchShows() {
  try {
    const response = await fetch('http://localhost:21000/shows', { mode: 'no-cors' });
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
//const button_1 = document.querySelector('#shows');
//const button_2 = document.querySelector('#party');
//const button_3 = document.querySelector('#party_spectacles');

//button_1.addEventListener('click', fetchShows);
//button_2.addEventListener('click', () => fetchPartyById(1));
//button_3.addEventListener('click', () => fetchShowPartyById(1));

//Tests Handlebars pour les spectacles (question 2) :

//Source JSON :
const source = {
  "type": "ressource",
  "locale": "fr-FR",
  "party": {
    "id": "4733bc12-7524-4a5c-bb0b-b72e25e05dc0",
    "name": "Birthday Bash",
    "theme": "Anniversaire",
    "prices": 30,
    "date": {
      "date": "2024-12-25 20:00:00.000000",
      "timezone_type": 3,
      "timezone": "UTC"
    },
    "begin": {
      "date": "2024-12-25 21:00:00.000000",
      "timezone_type": 3,
      "timezone": "UTC"
    },
    "shows": [
      {
        "id": "5f7fad72-1051-4488-8768-7b2ea49c8517",
        "title": "Daft Punk Show",
        "date": {
          "date": "2024-12-31 22:00:00.000000",
          "timezone_type": 3,
          "timezone": "UTC"
        },
        "images": [
          {
            "self": {
              "href": "/images/daftpunk.jpg"
            }
          }
        ],
        "artists": [
          {
            "id": "25555ec1-2359-4487-b87f-d69d10742ea6",
            "name": "Daft Punk",
            "style": "Electro",
            "image": {
              "self": {
                "href": "default.jpg"
              }
            }
          }
        ],
        "links": {
          "self": {
            "href": "/shows/5f7fad72-1051-4488-8768-7b2ea49c8517/"
          }
        }
      },
      {
        "id": "9cda9997-6324-4159-8862-fc643b0880de",
        "title": "Phoenix Live",
        "date": {
          "date": "2024-11-15 20:00:00.000000",
          "timezone_type": 3,
          "timezone": "UTC"
        },
        "images": [],
        "artists": [
          {
            "id": "5916ce53-2e82-4d7c-8ba5-2cc2f40ac9c8",
            "name": "Phoenix",
            "style": "Rock",
            "image": {
              "self": {
                "href": "default.jpg"
              }
            }
          }
        ],
        "links": {
          "self": {
            "href": "/shows/9cda9997-6324-4159-8862-fc643b0880de/"
          }
        }
      }
    ],
    "links": {
      "self": {
        "href": "/parties/4733bc12-7524-4a5c-bb0b-b72e25e05dc0/"
      }
    }
  }
}

console.log(new Date(source.party.date.date).toLocaleDateString('fr-FR', { weekday: 'short', day: '2-digit', month: '2-digit' }));
console.log(new Date(source.party.date.date).toLocaleDateString('fr-FR', { weekday: 'short', day: '2-digit', month: '2-digit' }));
let new_date = new Date(source.party.date.date).toLocaleDateString('fr-FR', { weekday: 'short', day: '2-digit', month: '2-digit' });
source.party.date.date = new_date;

////////////TESTS HANDLEBARS////////////
console.log('Détails de la soirée :')
console.log(source.party.name); //Nom de la soirée
console.log (source.party.theme); //Thème de la soirée
console.log(new Date(source.party.date.date).toLocaleDateString('fr-FR', { weekday: 'short', day: '2-digit', month: '2-digit' }));

console.log(source.party.prices);
//Manque lieu

console.log('Liste des spectacles :')
console.log(source.party.shows[0].title); //Titre du spectacle
console.log(new Date(source.party.shows[0].date.date).toLocaleDateString('fr-FR', { weekday: 'short', day: '2-digit', month: '2-digit' }));
console.log(source.party.shows[0].artists[0].name); //Nom de l'artiste
console.log(source.party.shows[0].artists[0].style); //Style de l'artiste
console.log(source.party.shows[0].images[0].self.href); //Image du spectacle
console.log(source.party.shows[0].links.self.href); //Lien du spectacle

var template = Handlebars.compile(document.querySelector('.party').innerHTML);
console.log(template)
var filledTemplate = template(source);
document.querySelector('.party').innerHTML = filledTemplate;




