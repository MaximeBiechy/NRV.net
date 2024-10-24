console.log("Fichier cart.js chargé.")

let cart_button = document.querySelector('.fa-cart-shopping');

const id_user = localStorage.getItem('id_user');
const authToken = localStorage.getItem('authToken');

let ticket_party_routes = []
let ticket_dates = [];

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
  console.log("Fonction getTicketDate appelée.")
  console.log(ticket_party_routes[0]);
  console.log(ticket_party_routes[1]);
  for(let i = 0; i < ticket_party_routes.length; i++){
    try{
      const response = await fetch(`http://localhost:21000${ticket_party_routes[i]}`, { headers: { 'Origin': 'http://localhost:21000'}});
      if(!response.ok){
        throw new Error('Network response was not ok');
      }

      const data = await response.json();
      console.log(data)
      let party_date = new Date(data.party.date.date).toLocaleDateString('fr-FR', { weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric' });
      ticket_dates.push(party_date);
      console.log(ticket_dates);

    }
    catch(error){
      console.error('There has been a problem with your fetch operation:', error);
    }
  }
  for(let i = 0; i < ticket_dates.length; i++){
    console.log(ticket_dates[i]);
    const ticket_dates_placeholders = document.querySelectorAll('.cart_item_options_date')
    ticket_dates_placeholders[i].innerHTML = ticket_dates[i];
  }
}

loadCart('669d5162-84b0-4edc-b043-3ccfa71eb0a9');
