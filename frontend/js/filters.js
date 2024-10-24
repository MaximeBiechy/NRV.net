'use strict';

var select_places = document.querySelector("#places");
var select_style = document.querySelector("#styles");
var calendar = document.querySelector("#calendar");

// Template for rendering shows (can be reused)
const templateSource = `
<div class="container" id="templateShow">
  {{#if shows.length}}
  {{#each shows}}
  <div class="way" url="/showInfo">
    <article class="card" data-id="{{this.id}}">
      <img src="{{this.images.0.self.href}}" alt="1" class="card_img">
      <div class="card_head">
        <p><span class="bold">{{this.date.date}}</span></p>
      </div>
      <div class="card_body">
        <h3 class="card_title">{{this.title}}</h3>
      </div>
    </article>
  </div>
  {{/each}}
  {{else}}
  <p class="error-message">Aucun spectacle disponible pour le moment.</p>
  {{/if}}
</div>
`;
const template = Handlebars.compile(templateSource);

// Function to fetch and display filtered shows
async function fetchFilteredShows(url) {
  try {
    const response = await fetch(url, { headers: { Origin: "http://localhost" } });
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();

    // Format the date for each show
    for (let i = 0; i < data.shows.length; i++) {
      data.shows[i].date.date = new Date(data.shows[i].date.date).toLocaleDateString('fr-FR', {
        weekday: 'short',
        day: '2-digit',
        month: '2-digit',
      });
    }

    // Render the filtered shows using Handlebars
    const filledTemplate = template(data);
    document.querySelector("#templateShow").innerHTML = filledTemplate;

    // Reattach event listeners to the newly rendered show cards
    attachCardListeners();

  } catch (error) {
    console.error("There has been a problem with your fetch operation:", error);
  }
}

// Event listeners for filters
async function filterPlace(place) {
  const placeValue = place === "default" ? "" : place;
  await fetchFilteredShows(`http://localhost:21000/shows?place=${placeValue}`);
}

async function filterStyle(style) {
  const styleValue = style === "default" ? "" : style;
  await fetchFilteredShows(`http://localhost:21000/shows?style=${styleValue}`);
}

async function filterDate(date) {
  const dateValue = date === "default" ? "" : date;
  await fetchFilteredShows(`http://localhost:21000/shows?date=${dateValue}`);
}

// Function to fetch and populate places dropdown
async function getPlaces() {
  try {
    const response = await fetch("http://localhost:21000/places", {
      headers: { Origin: "http://localhost:21001" },
    });
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();

    // Populate the places dropdown
    const templateSource = `
      <option value="default">-- Lieux --</option>
      {{#each places}}
      <option value="{{this.name}}">{{this.name}}</option>
      {{/each}}
    `;
    const template = Handlebars.compile(templateSource);
    const filledTemplate = template(data);
    document.querySelector("#places").innerHTML = filledTemplate;

  } catch (error) {
    console.error("There has been a problem with your fetch operation:", error);
  }
}

// Function to fetch and populate styles dropdown
async function getStyles() {
  try {
    const response = await fetch("http://localhost:21000/styles", {
      headers: { Origin: "http://localhost:21001" },
    });
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();

    // Populate the styles dropdown
    const templateSource = `
      <option value="default">-- Styles --</option>
      {{#each styles}}
      <option value="{{this}}">{{this}}</option>
      {{/each}}
    `;
    const template = Handlebars.compile(templateSource);
    const filledTemplate = template(data);
    document.querySelector("#styles").innerHTML = filledTemplate;

  } catch (error) {
    console.error("There has been a problem with your fetch operation:", error);
  }
}

// Attach event listeners to each card
function attachCardListeners() {
  document.querySelectorAll('.way').forEach(card => {
    card.addEventListener('click', function () {
      const id = this.querySelector('.card').getAttribute('data-id');
      localStorage.setItem('id_show', id); // Store id_show in localStorage
      window.route(this); // Trigger navigation to /showInfo route
    });
  });
}

// Event listener helper
function addChangeListener(element, callback) {
  element.addEventListener("change", function () {
    const current_value = element.value;
    callback(current_value);
  });
  document.querySelectorAll('.way').forEach(card => {
    card.addEventListener('click', function (event) {
        const id = this.querySelector('.card').getAttribute('data-id');
        localStorage.setItem('id_show', id); // Store id_show in localStorage
        window.route(this); // Trigger navigation to /showInfo route
    });
});
}

// Initialize data and attach listeners
getPlaces();
getStyles();
addChangeListener(select_places, filterPlace);
addChangeListener(select_style, filterStyle);
addChangeListener(calendar, filterDate);
