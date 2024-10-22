function fillTemplate() {
    var data = {
        artists: [
            {
                id: 1,
                image: './images/default.jpg',
                date: '2021-12-12',
                name: 'Artist One'
            },
            {
                id: 2,
                image: './images/default.jpg',
                date: '2022-01-15',
                name: 'Artist Two'
            },
            {
                id: 3,
                image: './images/default.jpg',
                date: '2022-02-20',
                name: 'Artist Three'
            }
        ]
    };
    var template = Handlebars.compile(document.getElementById('artist-template').innerHTML);
    var filledTemplate = template(data);
    document.getElementById('output').innerHTML = filledTemplate;
}

fillTemplate();
console.log('après fillTemplate');