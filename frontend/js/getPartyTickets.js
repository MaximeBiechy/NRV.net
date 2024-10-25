console.log("Fichier getPartyTickets.js chargé.");

let tickets = [];

document.addEventListener("DOMContentLoaded", async () => {
  console.log("Dom chargé");
  await getPartyTickets("a0b7566b-6fdd-4e34-bbab-41d882de9c07");
  console.log("coucou je passe");
  addEventListenersToButtons();
});

async function getPartyTickets(party_id){
  console.log(party_id);
  try{
    const response = await fetch(`http://localhost:21000/parties/${party_id}/tickets`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Origin": "http://localhost:21000"
      }
    });

    const data = await response.json();
    console.log(data)

    for(let i = 0; i < data.party.tickets.length; i++){
      tickets.push(data.party.tickets[i].id);
      console.log(tickets)
    }

    // Compile the Handlebars template
    var templateSource = document.querySelector(".tickets").innerHTML;
    console.log(templateSource);

    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);
    console.log(filledTemplate);
    document.querySelector(".tickets").innerHTML = filledTemplate;

    //Ajout attribute :
    var tickets_price = document.querySelectorAll(".ticket_price");
    for(let i = 0; i < tickets_price.length; i++){
      tickets_price[i].setAttribute("data-id", tickets[i]);
    }

    return tickets;
  }
  catch(error){
    console.log("Une erreur est survenue lors de la récupération des tickets : " + error);
  }
}

//ID party : a0b7566b-6fdd-4e34-bbab-41d882de9c07
(async () => {
  await getPartyTickets("a0b7566b-6fdd-4e34-bbab-41d882de9c07");
  console.log("coucou je passe")
  addEventListenersToButtons();
})();

function addEventListenersToButtons() {
  var ticket_prices = document.querySelectorAll(".ticket_price");
  var buttons = document.querySelectorAll(".add_to_cart");
  console.log(buttons);
  for (let i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener("click", function() {
      console.log("coucou");
      // addToCart(localStorage.getItem("cart_id"), ticket_prices[i].getAttribute("data-id"));
    });
  }
}
