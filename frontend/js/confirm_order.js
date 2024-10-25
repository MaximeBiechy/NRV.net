async function validateOrder(){

  await loadCart(localStorage.getItem('id_user'));

  const validate_order_button = document.querySelector('.validate_order');
  validate_order_button.addEventListener('click', function(){
    updateCart(localStorage.getItem('id_cart'), statuses.confirmation_status);
    window.route({ getAttribute: () => '/payment' });
  });
}

validateOrder();
