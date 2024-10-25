console.log('fetchArtists.js loaded');

var loader = document.querySelector('.loader');
var currentPage = 1;
var displayPage = document.querySelector("#page");
var displayMaxPage = document.querySelector("#maxPage");
var maxPage = 14;
displayPage.innerHTML = currentPage;


async function fetchArtists(page) {
  try {
    const response = await fetch(`http://localhost:21000/artists?page=${page}`, { headers: { 'Origin': 'http://localhost:21001'}});
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }

    const data = await response.json();
    

    if (data.shows.length === 0) {
      console.log('No artists available');
      document.querySelector('#templateArtist').innerHTML = 'No artists available';
      loader.style.display = 'none';
      maxPage = currentPage;
    }


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
displayMaxPage.innerHTML = maxPage;
