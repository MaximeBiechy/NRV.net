var config = 'http://localhost:21001';
var config2 = 'http://localhost:21000';



var loader = document.querySelector('.loader');
var currentPage = 1;
var displayPage = document.querySelector("#page");
var displayMaxPage = document.querySelector("#maxPage");
var maxPage = 1;
displayPage.innerHTML = currentPage;
var nbImages = 0;

async function  nbArtists() {
  try {
    const response = await fetch(config2+'/artists', { headers: { 'Origin': config}});
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    const data = await response.json();
    maxPage = Math.ceil(data.shows.length / nbImages);
    displayMaxPage.innerHTML = maxPage;
  }
  catch (error) {
    console.error('There has been a problem with your fetch operation:', error);
  }
}


async function fetchArtists(page) {
  try {
    const response = await fetch(config2+`/artists?page=${page}`, { headers: { 'Origin': config}});
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }

    const data = await response.json();
    nbImages = data.shows.length;


    var templateSource = ` 
    <div class="container" id="templateArtist">
          {{#each shows}}
          <article class="card">
            <img
              src="/images/{{this.image.self.href}}"
              alt="1"
              class="card_img"
            />
            <div class="card_body">
              <h3 class="card_title">{{this.name}}</h3>
              <div class="card_tags">
                <p class="tag {{this.style}}">{{this.style}}</p>
              </div>
            </div>
          </article>
          {{/each}}
        </div>`;

    var template = Handlebars.compile(templateSource);
    var filledTemplate = template(data);

    document.querySelector('#templateArtist').innerHTML = filledTemplate;   
    loader.style.display = 'none';
  }
  catch (error) {
    console.error('There has been a problem with your fetch operation:', error);
  }
}

document.getElementById('prev').addEventListener('click', function() {
  if (currentPage > 1) {
    displayPage.innerHTML = currentPage - 1;
    currentPage--;
    fetchArtists(currentPage);
  }
});

document.getElementById('next').addEventListener('click', function() {
 if (currentPage < maxPage){
  displayPage.innerHTML = currentPage + 1;
  currentPage++;
  fetchArtists(currentPage);}
});

fetchArtists(currentPage);
nbArtists();
displayMaxPage.innerHTML = maxPage;
