'use strict';

var select_places = document.querySelector("#places");
var select_style = document.querySelector("#styles");
var calendar = document.querySelector("#calendar");

async function filterPlace(place) {
  if (place === "default") {
    place = "";
  }

  try {
    const response = await fetch(
      `http://localhost:21000/shows?place=${place}`,
      { headers: { Origin: "http://localhost" } }
    );
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();
   

    for (let i = 0; i < data.shows.length; i++) {
      data.shows[i].date.date = new Date(
        data.shows[i].date.date
      ).toLocaleDateString("fr-FR", {
        weekday: "short",
        day: "2-digit",
        month: "2-digit",
      });
    }

    // Handlebars
    var templateSource = `
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
      {{/if}}
  </div>
    `;
    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);

    document.querySelector("#templateShow").innerHTML = filledTemplate;

  } catch (error) {
    console.error("There has been a problem with your fetch operation:", error);
  }
}

async function filterStyle(style) {
  if (style === "default") {
    style = "";
  }
  try {
    const response = await fetch(
      `http://localhost:21000/shows?style=${style}`,
      { headers: { Origin: "http://localhost" } }
    );
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();
   
    for (let i = 0; i < data.shows.length; i++) {
      data.shows[i].date.date = new Date(
        data.shows[i].date.date
      ).toLocaleDateString("fr-FR", {
        weekday: "short",
        day: "2-digit",
        month: "2-digit",
      });
    }

    // Handlebars
    var templateSource = `
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
      {{/if}}
  </div>
    `;

    var template = Handlebars.compile(templateSource);

    var filledTemplate = template(data);

    document.querySelector("#templateShow").innerHTML = filledTemplate;
  } catch (error) {
    console.error("There has been a problem with your fetch operation:", error);
  }
}

async function filterDate(date) {

  if (date === "default") {
    date = "";
  }
  try {
    const response = await fetch(`http://localhost:21000/shows?date=${date}`, {
      headers: { Origin: "http://localhost" },
    });
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();
   
    for (let i = 0; i < data.shows.length; i++) {
      data.shows[i].date.date = new Date(
        data.shows[i].date.date
      ).toLocaleDateString("fr-FR", {
        weekday: "short",
        day: "2-digit",
        month: "2-digit",
      });
    }
    // Handlebars
    var templateSource = `
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
      {{/if}}
  </div>
    `;
    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);
    document.querySelector("#templateShow").innerHTML = filledTemplate;

  
  } catch (error) {
    console.error("There has been a problem with your fetch operation:", error);
  }
}

async function getPlaces() {
  try {
    const response = await fetch("http://localhost:21000/places", {
      headers: { Origin: "http://localhost:21001" },
    });
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();
   

    // Handlebars
    var templateSource = `
    <option value="default">-- Lieux --</option>
    {{#each places}}
    <option value="{{this.name}}">{{this.name}}</option>
    {{/each}}
    `;
    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);

    document.querySelector("#places").innerHTML = filledTemplate;
  } catch (error) {
    console.error("There has been a problem with your fetch operation:", error);
  }
}

async function getStyles() {
  try {
    const response = await fetch("http://localhost:21000/styles", {
      headers: { Origin: "http://localhost:21001" },
    });
    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();
    

    // Handlebars
    var templateSource = `
    <option value="default">-- Styles --</option>
    {{#each styles}}
    <option value="{{this}}">{{this}}</option>
    {{/each}}
    `;
    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);

    document.querySelector("#styles").innerHTML = filledTemplate;
  } catch (error) {
    console.error("There has been a problem with your fetch operation:", error);
  }
}

// Event listener helper
function addChangeListener(element, callback) {
  element.addEventListener("change", function () {
      let current_value = element.value;
      callback(current_value);
  });
}

// Initialize data and attach listeners
getPlaces();
getStyles();
addChangeListener(select_places, filterPlace);
addChangeListener(select_style, filterStyle);
addChangeListener(calendar, filterDate);

