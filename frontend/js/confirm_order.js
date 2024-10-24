/////////////////////////////////////////////
//Fonction validation commande :
/////////////////////////////////////////////

console.log("Fichier confirm_order.js chargé");

async function validateOrder(){
  console.log("Le bouton de validation de commande a été cliqué !");

  await loadCart(localStorage.getItem('id_user'));

  const validate_order_button = document.querySelector('.validate_order');
  validate_order_button.addEventListener('click', function(){
    updateCart(localStorage.getItem('id_user'), statuses.confirmation_status);
    window.route({ getAttribute: () => '/payment' });
  });
}

validateOrder();
