console.log("Fichier addToCart.js chargé.")



async function addToCart(cart_id, ticket_id) {
    var response = await fetch(`https://localhost:21000/carts/${cart_id}/ticket`, {
        method: "PATCH",
        headers: {
            "Authorization": "Bearer " + localStorage.getItem("authToken"),
            "Content-Type": "application/json",
            "Origin": "http://localhost:21000"
        },
        body: {
          "ticket_id": ticket_id
        }
    });

    const data = await response.json();
    console.log(data)

    if (data.success) {
      window.route({ getAttribute: () => '/cart' });
    }
    else {
        alert("Une erreur est survenue.");
    }
}


// var button = document.getElementById("add_to_cart");
// var ticketPrice = document.querySelectorAll('.ticket_price');
// var id = "";

// for (let i = 0; i < ticketPrice.length; i++) {
//   ticketPrice[i].addEventListener("click", getCartId);
// }
