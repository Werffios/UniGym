import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

function setSvgFill() {
    const svg = document.getElementById("my-svg");
    if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
        svg.style.fill = "white";
    } else {
        svg.style.fill = "black";
    }
}
setSvgFill(); // para establecer el valor de fill al cargar la página
window.matchMedia("(prefers-color-scheme: dark)").addListener(setSvgFill); // para actualizar el valor de fill cuando cambie el modo
