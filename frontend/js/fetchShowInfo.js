var loader = document.querySelector(".loader");

async function fetchShowInfo(id) {
  try {
    const response = await fetch(`http://localhost:21000/shows/${id}/party`, {
      headers: { Origin: "http://localhost:21001" },
    });
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }
    const data = await response.json();

    for (let i = 0; i < data.party.length; i++) {
      data.party[i].date.date = new Date(
        data.party[i].date.date
      ).toLocaleDateString("fr-FR", {
        weekday: "short",
        day: "2-digit",
        month: "2-digit",
      });
      data.party[i].begin.date = new Date(
        data.party[i].begin.date
      ).toLocaleTimeString("fr-FR", {
        hour: "2-digit",
        minute: "2-digit",
      });
      for (let j = 0; j < data.party[i].shows.length; j++){
      data.party[i].shows[j].date.date= new Date(data.party[i].shows[j].date.date).toLocaleDateString('fr-FR', {
              weekday: 'short',
              day: '2-digit',
              month: '2-digit'});}
    }

    for (let i =0;i<data.party.length;i++){

        const data_gauge = await fetch(`http://localhost:21000/parties/${data.party[0].id}/gauge`, {
            headers: {
                'Origin': 'http://localhost:21000'
            }
        });
        if (!data_gauge.ok) {
          throw new Error('Network response was not ok');
      }
      const gauge = await data_gauge.json();

      data.party[i].gauge = gauge;

    }
    // Compile the Handlebars template
    var templateSource = document.querySelector("#ShowInfo").innerHTML;

    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);

    // Insert the filled template into the DOM
    document.querySelector("#ShowInfo").innerHTML = filledTemplate;

    loader.style.display = "none";

  } catch (error) {
    console.error("There has been a problem with your fetch operation:", error);
  }};




(async () => {
  await fetchShowInfo(localStorage.getItem("id_show"));
})();


/////////////////////////////////
//tickets infos
/////////////////////////////////


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

    for(let i = 0; i < data.party.tickets.length; i++){
      tickets.push(data.party.tickets[i].id);
    }

    // Compile the Handlebars template
    var templateSource = document.querySelector(".tickets").innerHTML;

    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);
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
  addEventListenersToButtons();
})();

function addEventListenersToButtons() {
  var ticket_prices = document.querySelectorAll(".ticket_price");
  var buttons = document.querySelectorAll(".add_to_cart");
  console.log(buttons);
  for (let i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener("click", function() {
      // addToCart(localStorage.getItem("cart_id"), ticket_prices[i].getAttribute("data-id"));
    });
  }
}
