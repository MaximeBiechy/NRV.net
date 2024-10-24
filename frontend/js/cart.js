console.log("Fichier cart.js chargé.")

let cart_button = document.querySelector('.fa-cart-shopping');

const id_user = localStorage.getItem('id_user');
const authToken = localStorage.getItem('authToken');

async function loadCart(user_id){
  try{
    const response = await fetch(`http://localhost:21000/users/${user_id}/cart`, { headers: { 'Origin': 'http://localhost:21001'}});
    if(!response.ok){
      throw new Error('Network response was not ok');
    }

    const data = await response.json();
    console.log(data);

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

loadCart('669d5162-84b0-4edc-b043-3ccfa71eb0a9');
