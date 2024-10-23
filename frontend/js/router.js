'use strict';   

let hasReloaded = false;

const route = (event) => {
    event = event || window.event;
    event.preventDefault();
    window.history.pushState({}, "", event.target.href);
    handleLocation();
}

const routes ={
    404: "/component/404.html",
    "/": "/component/squelette.html",
    "/Login": "/component/login.html",
    "/Shows": "/component/shows.html",
    "/showInfo": "/component/showInfo.html",
}

if (window.hasReloaded){
    
}

const handleLocation =async () => {
    const path = window.location.pathname;
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

window.onpopstate = handleLocation;
window.route = route;

handleLocation();



