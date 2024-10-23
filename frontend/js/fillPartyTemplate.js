function fillPartyTemplate(data) {
    var template = Handlebars.compile(document.querySelector('.party').innerHTML);
    var filledTemplate = template(data);
    document.querySelector('.party').innerHTML = filledTemplate;
}