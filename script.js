//Carrossel do banner inicial//

const slides = document.querySelector('.slides');
const slideElements = document.querySelectorAll('.slide');
const totalSlides = slideElements.length;
let index = 0;

function showNextSlide() {
  index++;
  slides.style.transition = 'transform 0.5s ease-in-out';
  const slideWidth = slideElements[0].clientWidth;
  slides.style.transform = `translateX(-${index * slideWidth}px)`;

  if (index === totalSlides - 1) {
    setTimeout(() => {
      slides.style.transition = 'none';
      index = 0;
      slides.style.transform = `translateX(0px)`;
    }, 500);
  }
}

setInterval(showNextSlide, 9000);



window.addEventListener("scroll", function () {
  const header = document.getElementById("main-header");
  if (window.scrollY > 0) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});




//Carrossel do receitas mais vistas//
document.addEventListener("DOMContentLoaded", () => {

    const track = document.querySelector(".carrossel-track");
    const slides = document.querySelectorAll(".car-item");

    let index = 0;

    function moveCarousel() {
        index++;
        track.style.transition = "transform 0.6s ease-in-out";
        track.style.transform = `translateX(-${index * 100}%)`;

        // quando chegar no final → reseta sem animação
        if (index === slides.length) {
            setTimeout(() => {
                track.style.transition = "none";
                index = 0;
                track.style.transform = "translateX(0%)";
            }, 600);
        }
    }

    setInterval(moveCarousel, 6000);
});

/* */
window.onload = () => {
    const logado = localStorage.getItem("logado");

    const btnLogin = document.getElementById("btnLogin");
    const btnPerfil = document.getElementById("btnPerfil");

    if (logado === "true") {
        if (btnLogin) btnLogin.style.display = "none";
        if (btnPerfil) btnPerfil.style.display = "block";
    } else {
        if (btnLogin) btnLogin.style.display = "block";
        if (btnPerfil) btnPerfil.style.display = "none";
    }
};