var loader = document.querySelector('.loader');
loader.style.display = 'none';

async function validatePayment(cart_id) {
  console.log(`http://localhost:21000/carts/${cart_id}/?state=${statuses.paid_status}`);
  try {
    const response = await fetch(`http://localhost:21000/carts/${cart_id}/?state=${statuses.paid_status}`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'Origin': 'http://localhost:21001',
        'Authorization': 'Bearer ' + localStorage.getItem('authToken')
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

  } catch (error) {
    console.error('There has been a problem with your fetch operation:', error);

    const error_message = document.querySelector('.error_message');
    error_message.style.display = 'block';
  }
}

const validate_order_button = document.querySelector('.validate_payment');
validate_order_button.addEventListener('click', function(){
  validatePayment(localStorage.getItem('id_cart'));
  window.route({ getAttribute: () => '/validate_order' });
});

//Espacement automatique des chiffres de la carte bancaire :
document.getElementById('cb_number').addEventListener('input', function (e) {
  let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
  let formattedValue = value.match(/.{1,4}/g)?.join(' ') || '';
  e.target.value = formattedValue;
});

//Slash automatique pour la date d'expiration :
document.getElementById('expiration_date').addEventListener('input', function (e) {
  let value = e.target.value.replace(/\D/g, '');
  if (value.length > 2) {
    value = value.slice(0, 2) + '/' + value.slice(2, 4);
  }
  e.target.value = value;
});
