//create a show navbar function

var id = null;
var pos = 1;
var oppacity = 1;

function fadeOut(id) {
    console.log("fadeOut: " + id);
    var element = document.getElementById(id);
    oppacity = 1;
    element.style.opacity = oppacity;
    element.style.display = "block";
    var interval = setInterval(function() {
        oppacity -= 0.1;
        element.style.opacity = oppacity;
        if (oppacity <= 0) {
            clearInterval(interval);
            element.style.display = "none";
        }
    }, 50);
}

function fadeIn(id) {
    console.log("fadeIn: " + id);
    var element = document.getElementById(id);
    oppacity = 0;
    element.style.opacity = oppacity;
    element.style.display = "block";
    var interval = setInterval(function() {
        oppacity += 0.1;
        element.style.opacity = oppacity;
        if (oppacity >= 1) {
            clearInterval(interval);
        }
    }, 50);
}

function showNavbar() {
    var navbar = document.getElementById("navbar");
    if (navbar.style.display != "block") {
        fadeOut("menu-btn");
        fadeIn("navbar");
    } else {
        fadeIn("menu-btn");
        fadeOut("navbar");
    }
}




console.log("loaded!");


