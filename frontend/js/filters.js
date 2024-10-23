
const select_places = document.querySelector('#places');
const select_style = document.querySelector('#styles');
const calendar = document.querySelector('#calendar');

async function filterPlace(place) {
  try {
    const response = await fetch(`http://localhost:21000/shows?place=${place}`, { headers: { 'Origin': 'http://localhost' }});
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }

    const data = await response.json();
    console.log(data);

    for (let i = 0; i < data.shows.length; i++) {
      data.shows[i].date.date = new Date(data.shows[i].date.date).toLocaleDateString('fr-FR', { weekday: 'short', day: '2-digit', month: '2-digit' });
  }
    

    // Handlebars
    var templateSource = `
    <div class="container" id="templateShow">
      {{#if shows.length}}
      {{#each shows}}
      <article class="card">
      <img src="{{this.images.0.self.href}}" alt="1" class="card__img">
      <div class="card_head">
        <p><span class="bold">{{ this.date.date }}</span></p>
        <p class="place"></p>
      </div>
      <div class="card_body">
        <h3 class="card_title">{{ this.title }}</h3>
        <div class="card_tags">
        </div>
      </div>
      </article>
      {{/each}}
      {{else}}
      <p class="error-message">Aucun spectacle disponible pour le moment.</p>
      {{/if}}
    </div>
    `;
    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);

    document.querySelector('#templateShow').innerHTML = filledTemplate;
  } catch (error) {
    console.error('There has been a problem with your fetch operation:', error);
  }
}

async function filterStyle(style) {
  try {
    const response = await fetch(`http://localhost:21000/shows?style=${style}`, { headers: { 'Origin': 'http://localhost' }});
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }

    const data = await response.json();
    console.log(data);

    // Handlebars
    var templateSource = `
    <div class="container" id="templateShow">
      {{#if shows.length}}
      {{#each shows}}
      <article class="card">
      <img src="{{this.images.0.self.href}}" alt="1" class="card__img">
      <div class="card_head">
        <p><span class="bold">{{ this.date.date }}</span></p>
        <p class="place"></p>
      </div>
      <div class="card_body">
        <h3 class="card_title">{{ this.title }}</h3>
        <div class="card_tags">
        </div>
      </div>
      </article>
      {{/each}}
      {{else}}
      <p class="error-message">Aucun spectacle disponible pour le moment.</p>
      {{/if}}
    </div>
    `;


    var template = Handlebars.compile(templateSource);

    console.log(template);

    var filledTemplate = template(data);

    console.log(filledTemplate);

    document.querySelector('#templateShow').innerHTML = filledTemplate;

  } catch (error) {
    console.error('There has been a problem with your fetch operation:', error);
  }
}

async function filterDate(date) {
  console.log('Fonction FilterDate');
  try {
    const response = await fetch(`http://localhost:21000/shows?date=${date}`, { headers: { 'Origin': 'http://localhost' }});
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }

    const data = await response.json();
    console.log(data);

    // Handlebars
    var templateSource = `
    <div class="container" id="templateShow">
      {{#if shows.length}}
      {{#each shows}}
      <article class="card">
      <img src="{{this.images.0.self.href}}" alt="1" class="card__img">
      <div class="card_head">
        <p><span class="bold">{{ this.date.date }}</span></p>
        <p class="place"></p>
      </div>
      <div class="card_body">
        <h3 class="card_title">{{ this.title }}</h3>
        <div class="card_tags">
        </div>
      </div>
      </article>
      {{/each}}
      {{else}}
      <p class="error-message">Aucun spectacle disponible pour le moment.</p>
      {{/if}}
    </div>
    `;
    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);
    document.querySelector('#templateShow').innerHTML = filledTemplate;
  } catch (error) {
    console.error('There has been a problem with your fetch operation:', error);
  }
}

// Section des events :
function addChangeListener(element, callback) {
  element.addEventListener('change', function() {
    let current_value = element.value;
    console.log(current_value);
    callback(current_value);
  });
}

addChangeListener(select_places, filterPlace);
addChangeListener(select_style, filterStyle);
addChangeListener(calendar, filterDate);