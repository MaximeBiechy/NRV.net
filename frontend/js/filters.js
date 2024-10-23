//<!>: Filtres uniquement dédiés à la route des spectacles.//

//Faire une fonction si default & default alors tout récupérer.

const select_places = document.querySelector('#places');
const select_style = document.querySelector('#styles');
const calendar = document.querySelector('#calendar');

async function filterPlace(place){
  try{
    const response = await fetch(`http://localhost:21000/shows?place=${place}`, { headers: { 'Origin': 'http://localhost' }});
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }

    const data = await response.json();
    console.log(data);

    //Handlebars
    var templateSource = document.querySelector('.card').innerHTML;
    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);
    document.querySelector('.card').innerHTML = filledTemplate;
  }
  catch(error){
    console.error('There has been a problem with your fetch operation:', error);
  }
}

async function filterStyle(style){
  try{
    const response = await fetch(`http://localhost:21000/shows?style=${style}`, { headers: { 'Origin': 'http://localhost' }});
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }

    const data = await response.json();
    console.log(data);

    //Handlebars
    var templateSource = document.querySelector('.card').innerHTML;
    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);
    document.querySelector('.card').innerHTML = filledTemplate;
  }
  catch(error){
    console.error('There has been a problem with your fetch operation:', error);
  }
}

async function filterDate(date){
  try{
    const response = await fetch(`http://localhost:21000/shows?date=${date}`, { headers: { 'Origin': 'http://localhost' }});
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }

    const data = await response.json();
    console.log(data);

    //Handlebars
    var templateSource = document.querySelector('.card').innerHTML;
    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);
    document.querySelector('.card').innerHTML = filledTemplate;
  }
  catch(error){
    console.error('There has been a problem with your fetch operation:', error);
  }
}

//Section des events :
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