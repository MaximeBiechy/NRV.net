console.log("Fichier addToCart.js chargé.")

var button = document.getElementById("add_to_cart");

async function addToCart(cart_id, ticket_id) {
    var id = button.getAttribute("data-id");
    console.log(id);

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

    var data = await response.json();

    if (data.success) {
      window.route({ getAttribute: () => '/cart' });
    }
    else {
        alert("Une erreur est survenue.");
    }
}

//ID party : a0b7566b-6fdd-4e34-bbab-41d882de9c07

console.log(localStorage.getItem("id_cart"));
console.log(button.getAttribute("data-id"));

button.addEventListener("click", function() {
    addToCart(localStorage.getItem("id_cart"), button.getAttribute("data-id"));
});

