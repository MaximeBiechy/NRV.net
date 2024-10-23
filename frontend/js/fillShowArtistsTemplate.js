
function fillShowArtistsTemplate(data) {
    var template = Handlebars.compile(document.querySelector('.artists').innerHTML);
    var filledTemplate = template(data);
    document.querySelector('.artists').innerHTML = filledTemplate;
  }
  
  (async () => {
    const data = await fetchShowArtists('05cf1397-1bf3-4227-aa5a-063c6b3e14e8');
    fillShowArtistsTemplate(data);
  })();
  
  