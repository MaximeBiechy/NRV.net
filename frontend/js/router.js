'use strict';

document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('.way');
    links.forEach((link) => {
        link.addEventListener('click', (event) => route(event.currentTarget));
    });

    const savedPath = localStorage.getItem('currentPath') || '/';  
    handleLocation(savedPath);
});

const route = (element) => {
    const path = element.getAttribute('data-id'); 
    localStorage.setItem('currentPath', path); 
    handleLocation(path); 
};

const routes = {
    404: "/component/404.html",
    "/": "/component/squelette.html",
    "/login": "/component/login.html",
    "/shows": "/component/shows.html",
    "/showInfo": "/component/showInfo.html",
    "/cart": "/component/cart.html",
};

const handleLocation = async (path = "/") => {
    const route = routes[path] || routes[404];
    const html = await fetch(route).then((data) => data.text());
    document.getElementById("main-page").innerHTML = html;


    const scripts = document.querySelectorAll('.main-page-script');
    scripts.forEach((script) => {
        const newScript = document.createElement('script');
        newScript.textContent = script.textContent;
        if (script.src) {
            newScript.src = script.src;
        }
        document.body.appendChild(newScript);
        document.body.removeChild(newScript);
    });
};


window.route = route;
