console.log("Fichier cart.js chargé.")

let cart_button = document.querySelector('.fa-cart-shopping');

const id_user = localStorage.getItem('id_user');
const authToken = localStorage.getItem('authToken');

let ticket_party_routes = []
let ticket_dates = [];
let cart_id; //Potentiellement possible à passer en localstorage

//Cart status :
const statuses = {
  validate_status: 1,
  confirmation_status: 2,
  payment_status: 3
};

async function loadCart(user_id){
  try{
    const response = await fetch(`http://localhost:21000/users/${user_id}/cart`, { headers: { 'Origin': 'http://localhost:21000'}});
    if(!response.ok){
      throw new Error('Network response was not ok');
    }

    const data = await response.json();
    console.log(data);


    for(let i = 0; i < data.cart.tickets.length; i++){
      ticket_party_routes.push(data.cart.tickets[i].links.party.href);
      console.log("ça push !")
    }
    console.log(ticket_party_routes);

    getTicketDate();

    //Handlebars :
    var templateSource = document.querySelector('#cart_template').innerHTML;
    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);

    document.querySelector('#cart_template').innerHTML = filledTemplate;

  }
  catch(error){
    console.error('There has been a problem with your fetch operation:', error);
  }
}

async function getTicketDate(){
  for(let i = 0; i < ticket_party_routes.length; i++){
    try{
      const response = await fetch(`http://localhost:21000${ticket_party_routes[i]}`, { headers: { 'Origin': 'http://localhost:21000'}});
      if(!response.ok){
        throw new Error('Network response was not ok');
      }

      const data = await response.json();
      let party_date = new Date(data.party.date.date).toLocaleDateString('fr-FR', { weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric' });
      ticket_dates.push(party_date);

    }
    catch(error){
      console.error('There has been a problem with your fetch operation:', error);
    }
  }
  for(let i = 0; i < ticket_dates.length; i++){
    const ticket_dates_placeholders = document.querySelectorAll('.cart_item_options_date')
    ticket_dates_placeholders[i].innerHTML = ticket_dates[i];
  }

  //loader.style.display = "none";
}

function updateCart(id_cart, state){
  console.log("Panier en cours d'actualisation...");
  console.log('Statut : ' + state);

  let cart_status = statuses.validate_status;

  fetch(`http://localhost:21000/carts/${id_cart}/?state=${state}`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'Origin': 'http://localhost:21001'
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
  await loadCart('669d5162-84b0-4edc-b043-3ccfa71eb0a9');

  let validate_button = document.querySelector('.validate_order');
  validate_button.addEventListener('click', function(){
    console.log("Le bouton de validation a été cliqué !");
    updateCart('d85544dd-c85b-4f9b-a600-52f91388d6d0', statuses.validate_status);
    window.route({ getAttribute: () => '/payment' });
  });
})();

//Fonction de vérification du paiement (state 2) :
function checkPayment() {
  console.log("Vérification du paiement en cours...");

  // Get input values
  const num_cb = document.querySelector('input[name="cb_number"]').value;
  const date_exp = document.querySelector('input[name="expiration_date"]').value;
  const cvc = document.querySelector('input[name="cvc_number"]').value;

  // Expected values
  const expectedPaymentDetails = {
    num_cb: "1111 1111 1111 1111",
    date_exp: "2025",
    code: "200"
  };

  // Compare input values with expected values
  if (num_cb === expectedPaymentDetails.num_cb &&
    date_exp === expectedPaymentDetails.date_exp &&
    code === expectedPaymentDetails.code) {
    console.log("Paiement validé !");
    // Proceed with further actions, e.g., updating the cart status
  }
  else {
    console.log("Paiement refusé. Veuillez vérifier vos informations.");
  }
}

const validate_button = document.querySelector('.validate_order');
console.log(validate_button);
(async () => {
  await checkPayment();

  let validate_button = document.querySelector('.validate_order');
  validate_button.addEventListener('click', function(){
    console.log("Le bouton de validation du paiement a été cliqué !");
    updateCart('d85544dd-c85b-4f9b-a600-52f91388d6d0', statuses.validate_status);
    window.route({ getAttribute: () => '/validate_order' });
  });
})();


