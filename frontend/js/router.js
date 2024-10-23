'use strict';   


// const route = (event) => {
//     event = event || window.event;
//     event.preventDefault();
//     window.history.pushState({}, "", event.target.href);
//     handleLocation();
// }

const routes ={
    404: "/component/404.html",
    "/": "/component/squelette.html",
    "/login": "/component/login.html",
    "/shows": "/component/shows.html",
    "/showInfo": "/component/showInfo.html",
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

window.addEventListener('load', handleLocation);
window.onpopstate = handleLocation;
// window.route = route;
window.route = (event) => {
    event = event || window.event;
    event.preventDefault();
    window.history.pushState({}, "", event.target.href);
    handleLocation();
};

handleLocation();



