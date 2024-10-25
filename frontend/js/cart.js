console.log("Fichier cart.js chargé.")

var cart_button = document.querySelector('.fa-cart-shopping');

var id_user = localStorage.getItem('id_user');
var authToken = localStorage.getItem('authToken');

var ticket_party_routes = []
var ticket_dates = [];
var cart_id; //Potentiellement possible à passer en localstorage

//Cart status :
var statuses = {
  validate_status: 1,
  confirmation_status: 2,
  paid_status: 3
};

async function loadCart(user_id){
  console.log(localStorage.getItem('authToken'));
  try{
    const response = await fetch(`http://localhost:21000/users/${user_id}/cart`, { headers: {
        'Origin': 'http://localhost:21000',
        'Authorization': 'Bearer ' + localStorage.getItem('authToken')
    }});
    if(!response.ok){
      throw new Error('Network response was not ok');
    }

    const data = await response.json();
    console.log(data);


    for(let i = 0; i < data.cart.tickets.length; i++){
      ticket_party_routes.push(data.cart.tickets[i].links.party.href);
    }

    await getTicketDate();

    //Handlebars :
    var templateSource = document.querySelector('#cart_template').innerHTML;
    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);

    document.querySelector('#cart_template').innerHTML = filledTemplate;

    //Envoi en local storage :
    localStorage.setItem('id_cart', data.cart.id);

    //Suppression du loader :
    var loader = document.querySelector('.loader');
    loader.style.display = 'none';

    cart_empty = false;
  }
  catch(error){
    console.error('There has been a problem with your fetch operation:', error);

    if(localStorage.getItem('authToken') == null){
      window.route({ getAttribute: () => '/login' });
      console.log("Vous devez être connecté pour accéder à votre panier.");
    }
    else{
      var error_message = document.querySelector('.error_message');
      error_message.style.display = 'block';
      var loader = document.querySelector('.loader');
      loader.style.display = 'none';
      console.log("Erreur lors du chargement du panier.");
    }
  }
}


async function getTicketDate() {
  for (let i = 0; i < ticket_party_routes.length; i++) {
    try {
      const response = await fetch(`http://localhost:21000${ticket_party_routes[i]}`, { headers: { 'Origin': 'http://localhost:21000' } });
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }

      const data = await response.json();
      let party_date = new Date(data.party.date.date).toLocaleDateString('fr-FR', { weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric' });
      ticket_dates.push(party_date);

    } catch (error) {
      console.error('There has been a problem with your fetch operation:', error);
    }
  }

  const ticket_dates_placeholders = document.querySelectorAll('.cart_item_options_date');
  for (let i = 0; i < ticket_dates.length; i++) {
    if (ticket_dates_placeholders[i]) {
      ticket_dates_placeholders[i].innerHTML = ticket_dates[i];
    } else {
      console.error(`Element at index ${i} not found`);
    }
  }
}

function updateCart(id_cart, state){
  console.log("Panier en cours d'actualisation...");
  console.log('Statut : ' + state);

  let cart_status = statuses.validate_status;

  fetch(`http://localhost:21000/carts/${id_cart}/?state=${state}`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'Origin': 'http://localhost:21001',
      'Authorization': 'Bearer ' + localStorage.getItem('authToken')
    },
  })
  .then(response => response.json())
  .then(data => {
    console.log('Success:', data);
    console.log('Panier actualisé vers le statut : ' + cart_status);
  })
  .catch((error) => {
    console.error('Error:', error);
  });
}

  (async () => {
    await loadCart(localStorage.getItem('id_user'));

    let validate_button = document.querySelector('.validate_cart');
    validate_button.addEventListener('click', function(){
      console.log("Le bouton de validation a été cliqué !");
      updateCart(localStorage.getItem('id_cart'), statuses.validate_status);
      window.route({ getAttribute: () => '/order' });
    });
  })();





