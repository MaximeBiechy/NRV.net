
  // Récupérer les détails d'une soirée par son id :
  async function fetchPartyById(id) {
    try {
      const response = await fetch(`http://localhost:21000/parties/${id}`, { mode: 'no-cors' });
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      const data = await response.json();
      console.log(data);
    } catch (error) {
      console.error('There has been a problem with your fetch operation:', error);
    }
    return data;
  }

function fillTemplate(data) {

    var datas = data;
    var template = Handlebars.compile(document.getElementById('artist-template').innerHTML);
    var filledTemplate = template(data);
    document.getElementById('output').innerHTML = filledTemplate;
}

fillTemplate(data);
