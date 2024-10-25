'use strict';

document.addEventListener('DOMContentLoaded', () => {
    // Attach event listeners to links when the page first loads
    attachLinkListeners();

    // Load the last visited route from localStorage on page load
    handleLocation(savedPath());
});

function savedPath() {
    return savedPath = localStorage.getItem('currentPath') || '/';
}

const route = (element) => {
    const path = element.getAttribute('url');
    if (path === '/showInfo'){
        localStorage.getItem('id_show');
    }

    localStorage.setItem('currentPath', path);
    handleLocation(path);
};

const routes = {
    404: "/component/404.html",
    "/": "/component/squelette.html",
    "/login": "/component/login.html",
    "/signup": "/component/signup.html",
    "/shows": "/component/shows.html",
    "/showInfo": "/component/showInfo.html",
    "/cart": "/component/cart.html",
    "/order": "/component/order.html",
    "/payment": "/component/payment.html",
    "/validate_order": "/component/validate_order.html",
    "/profile" : "/component/profile.html",
};

const handleLocation = async (path = "/") => {
    const route = routes[path] || routes[404];
    const html = await fetch(route).then((data) => data.text());
    document.getElementById("main-page").innerHTML = html;

    // Re-execute any scripts loaded with the HTML
    const scripts = document.querySelectorAll('.main-page-script');
    scripts.forEach((script) => {
        const newScript = document.createElement('script');
        newScript.textContent = script.textContent;
        if (script.src) {
            newScript.src = script.src;
        }
        document.body.appendChild(newScript);
        document.body.removeChild(newScript);

        if (localStorage.getItem('burgerOpen') === 'false') {
            document.querySelector('#menu').style.transform = 'translateX(100%)';
            document.querySelector('#burger').classList.remove('cross');
        }
    });

    // Reattach event listeners to any new `.way` links in the dynamically loaded content
    attachLinkListeners();
};

// Function to attach event listeners to all '.way' links
const attachLinkListeners = () => {
    const links = document.querySelectorAll('.way');
    links.forEach((link) => {
        link.removeEventListener('click', handleClick); // Avoid duplicate listeners
        link.addEventListener('click', handleClick);
    });
};

// Click event handler for the links
const handleClick = (event) => {
    event.preventDefault(); // Prevent default navigation
    route(event.target); // Call the route function with the clicked element
};




window.route = route;
attachLinkListeners();





