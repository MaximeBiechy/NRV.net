/////////////////////////////////////////////
//Fonction validation paiement :
/////////////////////////////////////////////
async function validatePayment(cart_id) {
  console.log(document.querySelector('.validate_payment'))
  try {
    const response = await fetch(`http://localhost:21000/carts/${cart_id}/?state=${statuses.paid_status}`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'Origin': 'http://localhost:21001'
      },
      body: JSON.stringify({
        "num_cb": document.getElementById('cb_number').value,
        "date_exp": document.getElementById('expiration_date').value,
        "code": document.getElementById('cvc_number').value
      })
    });
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const data = await response.json();
    console.log("Traitement du paiement : ", data);

  } catch (error) {
    console.error('There has been a problem with your fetch operation:', error);
  }
}

const validate_order_button = document.querySelector('.validate_payment');
validate_order_button.addEventListener('click', function(){
  validatePayment(localStorage.getItem('id_user'));
  updateCart(localStorage.getItem('id_user'), statuses.paid_status);
  window.route({ getAttribute: () => '/validate_order' });
});
