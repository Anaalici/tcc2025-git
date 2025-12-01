// Carrossel do banner inicial - (MANTIDO FORA DO DOMContentLoaded, COMO ESTAVA)
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

// Evento de Scroll para o Header
window.addEventListener("scroll", function () {
  const header = document.getElementById("main-header");
  if (window.scrollY > 0) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});

// Checagem de Login (window.onload)
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

// Objeto de Receitas (MANTIDO, PODE SER REMOVIDO SE USAR RECEITASDATA.JS)
const receitas = [
    // ... seu array de receitas ...
];


// --- LÓGICA PRINCIPAL (Carrossel Vistas, Busca e NOVO TOGGLE) ---
document.addEventListener("DOMContentLoaded", () => {

    // Carrossel do receitas mais vistas (MANTIDO)
    const track = document.querySelector(".carrossel-track");
    const slidesCar = document.querySelectorAll(".car-item");

    if (track && slidesCar.length > 0) {
        let indexCar = 0;

        function moveCarousel() {
            indexCar++;
            track.style.transition = "transform 0.6s ease-in-out";
            track.style.transform = `translateX(-${indexCar * 100}%)`;

            if (indexCar === slidesCar.length) {
                setTimeout(() => {
                    track.style.transition = "none";
                    indexCar = 0;
                    track.style.transform = "translateX(0%)";
                }, 600);
            }
        }
        setInterval(moveCarousel, 6000);
    }


    // Lógica de Busca (MANTIDA)
    const inputPesquisa = document.getElementById("meuInput");
    const btnPesquisar = document.querySelector(".botaoEnviar");

    if (btnPesquisar && inputPesquisa) {
        btnPesquisar.addEventListener("click", (e) => {
            e.preventDefault();
            const termo = inputPesquisa.value.trim();
            
            if (termo) {
                window.location.href = `receitasC.html?search=${encodeURIComponent(termo)}`;
            } else {
                window.location.href = `receitasC.html`;
            }
        });
    }
    
    
    // --- NOVO CÓDIGO: LÓGICA DO TOGGLE DE DESLIZAR ---
    const toggleElement = document.getElementById('page-toggle');

    if (toggleElement) {
        toggleElement.addEventListener('click', function() {
            // CRÍTICO: Alterna a classe que o CSS usa para aplicar o 'transform: translateX'
            this.classList.toggle('utensils-view-active'); 

            const isUtensilsActive = this.classList.contains('utensils-view-active');
            
            // Seleciona os containers de estado (ícones)
            const recipesState = toggleElement.querySelector('[data-view="recipes"]');
            const utensilsState = toggleElement.querySelector('[data-view="utensils"]');


            if (isUtensilsActive) {
                // ESTADO ATIVADO: MODO UTENSÍLIOS
                
                // Troca visual dos ícones
                recipesState.classList.remove('active');
                utensilsState.classList.add('active');

window.location.href = 'temperos.html';


            } else {
                // ESTADO DESATIVADO: MODO RECEITAS
                
                // Troca visual dos ícones
                utensilsState.classList.remove('active');
                recipesState.classList.add('active');
                
                // LÓGICA DE NAVEGAÇÃO: Adicione o redirecionamento aqui
                 window.location.href = 'index.html';
            }
        });
    }
});