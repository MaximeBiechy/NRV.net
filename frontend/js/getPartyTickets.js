console.log("Fichier getPartyTickets.js chargé.");

let tickets = [];

async function getPartyTickets(party_id) {
  console.log(party_id);
  try {
    const response = await fetch(`http://localhost:21000/parties/${party_id}/tickets`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Origin": "http://localhost:21000"
      }
    });

    const data = await response.json();
    console.log(data);



    for (let i = 0; i < data.party.tickets.length; i++) {
      tickets.push(data.party.tickets[i].id);

      // Formatage des prix :
      data.party.tickets[i].price = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(data.party.tickets[i].price);
    }

    // Compile the Handlebars template
    console.log("On compile le template");
    var templateSource = document.querySelector(".tickets").innerHTML;
    console.log(templateSource);

    var template = await Handlebars.compile(templateSource);

    var filledTemplate = template(data);
    console.log(filledTemplate);

    document.querySelector(".tickets").innerHTML = filledTemplate;

    // Ajout attribute :
    var tickets_price = document.querySelectorAll(".ticket_price");
    for (let i = 0; i < tickets_price.length; i++) {
      console.log("Ajout à l'item " + i + " de l'attribut data-id avec la valeur " + tickets[i]);
      tickets_price[i].setAttribute("data-id", tickets[i]);
      console.log(tickets_price[i]);
    }


    // Event listeners :

      const price_buttons = document.querySelectorAll(".add_to_cart");
      console.log(price_buttons);
      for (let i = 0; i < price_buttons.length; i++) {
        console.log(price_buttons[i]);
        price_buttons[i].addEventListener("click", function () {
          console.log("Ajout du ticket " + tickets[i] + " au panier.");
          addToCart(localStorage.getItem("cart_id"), price_buttons[i].getAttribute("data-id"));
          window.route({ getAttribute: () => '/cart' });
        });
      }

      //On enlève le loader :
      document.querySelector(".loader").style.display = "none";


    console.log("Fini !")

    return tickets;

  }
  catch (error) {
    console.log("Une erreur est survenue lors de la récupération des tickets : " + error);
  }
}

console.log(getPartyTickets("a0b7566b-6fdd-4e34-bbab-41d882de9c07"));

