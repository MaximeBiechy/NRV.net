var config = 'http://localhost:21001';
var config2 = 'http://localhost:21000';

var id_user = localStorage.getItem('id_user');
var authToken = localStorage.getItem('authToken');

var ticket_party_routes = []
var ticket_dates = [];
var cart_id; //Potentiellement possible à passer en localstorage

//Cart status :
var statuses = {
  cart_status: 0,
  validate_status: 1,
  confirmation_status: 2,
  paid_status: 3
};

var ticket_ids = [];

async function loadCart(user_id){
  try{
    const response = await fetch(config2+`/users/${user_id}/cart`, { headers: {
        'Origin': config,
        'Authorization': 'Bearer ' + localStorage.getItem('authToken')
    }});
    if(!response.ok){
      throw new Error('Network response was not ok');
    }

    const data = await response.json();
    console.log(data)


    for(let i = 0; i < data.cart.tickets.length; i++){
      ticket_party_routes.push(data.cart.tickets[i].links.party.href);
    }

    for(let i = 0; i < data.cart.tickets.length; i++){
      ticket_ids.push(data.cart.tickets[i].id);
      console.log(ticket_ids);
    }

    await getTicketDate();

    //Formatage des montants :
      for(let i = 0; i < data.cart.tickets.length; i++){
        data.cart.tickets[i].price = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(data.cart.tickets[i].price);
      }


      data.cart.price_HT = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(data.cart.price_HT);
      data.cart.tva = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(data.cart.tva);
      data.cart.total_price = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(data.cart.total_price);

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

    console.error("Erreur lors de la récupération du panier :" + error)

    if(localStorage.getItem('authToken') == null){
      window.route({ getAttribute: () => '/login' });
    }
    else{
      var error_message = document.querySelector('.error_message');
      error_message.style.display = 'block';
      var loader = document.querySelector('.loader');
      loader.style.display = 'none';
    }
  }
}

async function getTicketDate() {
  for (let i = 0; i < ticket_party_routes.length; i++) {
    try {
      const response = await fetch(config2+`${ticket_party_routes[i]}`, { headers: { 'Origin': config } });
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
      // console.error(`Element at index ${i} not found`);
    }
  }
}

function updateCart(id_cart, state){

  let cart_status = statuses.validate_status;

  fetch(config2+`/carts/${id_cart}/?state=${state}`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'Origin': config,
      'Authorization': 'Bearer ' + localStorage.getItem('authToken')
    },
  })
  .then(response => response.json())
  .then(data => {

  })
  .catch((error) => {
    console.error('Error:', error);
  });
}

async function deleteTicket(id_cart, ticket_id){
  console.log(config2+`/carts/${id_cart}/?state=0/`);
  console.log('ticket_id', ticket_id);
  console.log('id_cart', localStorage.getItem('id_cart'));

  try{
    const response = await fetch(config2+`/carts/${id_cart}/?state=0`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'Origin': config,
        'Authorization': 'Bearer ' + localStorage.getItem('authToken')
      },
      body: JSON.stringify({
        "ticket_id": ticket_id,
        "quantity": 0
      })
    });

    if(!response.ok){
      throw new Error('Network response was not ok');
    }

    const data = await response.json();
    console.log(data);
  }
  catch(error){
    console.error('Error:', error);
  }
}









  /*for(let i = 0; i < delete_button.length; i++){
    delete_button[i].addEventListener('click', function(){
      console.log("click")
      deleteTicket(localStorage.getItem('id_cart'), "25679b20-65f8-4455-97f8-a717fefd581d");
      window.route({ getAttribute: () => '/cart' });
    });
  }*/









  (async () => {
    await loadCart(localStorage.getItem('id_user'));

    let validate_button = document.querySelector('.validate_cart');
    if(validate_button){
      validate_button.addEventListener('click', function(){
        updateCart(localStorage.getItem('id_cart'), statuses.validate_status);
        window.route({ getAttribute: () => '/order' });
      });
    }
    var delete_button = document.getElementsByClassName('cart_item_delete');
    console.log(delete_button)

    Array.from(delete_button).forEach(function(element) {
      console.log(element)
      element.addEventListener('click', function(){
        const index = Array.from(delete_button).indexOf(event.target);
        console.log(ticket_ids[index]);
        deleteTicket(localStorage.getItem('id_cart'), ticket_ids[index]);
        window.route({ getAttribute: () => '/cart' });
      });
    });

    var cart_items = document.querySelectorAll('.cart_item');
    console.log(cart_items);

  })();








