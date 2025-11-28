// Banco de dados simples
window.receitas = {
    bolocenoura: {
        id: "bolocenoura",
        titulo: "Bolo de Cenoura",
        imagem: "img/bolocenoura.jpg",
        tempo: "40 min",
        dificuldade: "Fácil",
        utensilios: [
            { nome: "Liquidificador", imagem: "img/liquidificador.jpg" },
            { nome: "Forma", imagem: "img/forma.jpg" }
        ],
        ingredientes: ["3 cenouras", "2 xícaras de farinha", "3 ovos", "1 xícara de açúcar"],
        preparo: ["Bata tudo no liquidificador.", "Asse por 40 minutos a 180°C."]
    },


    frango: {
        id: "frango",
        titulo: "Frango Crocante",
        imagem: "img/frango.jpg",
        ingredientes: ["500g de frango", "Farinha", "Ovos", "Temperos"],
        preparo: ["Empane o frango.", "Frite até dourar."]
    },

    strogonoff: {
        id: "strogonoff",
        titulo: "Strogonoff de Frango",
        imagem: "img/strogonoff.jpg",
        ingredientes: ["Frango", "Creme de leite", "Ketchup", "Mostarda"],
        preparo: ["Refogue o frango.", "Adicione os molhos."]
    }
};

// Montar carrossel
const lista = document.getElementById("listaReceitas");
Object.values(window.receitas).forEach(r => {
    const div = document.createElement("div");
    div.className = "card";
    div.innerHTML = `
    <img src="${r.imagem}" />
    <h3>${r.titulo}</h3>
    <button onclick="abrirReceita('${r.id}')">Ver Receita</button>
  `;
    lista.appendChild(div);
});

function abrirReceita(id) {
    const receita = window.receitas[id];
    if (!receita) return;

    document.getElementById("conteudoReceita").style.display = "block";
    document.getElementById("titulo").textContent = receita.titulo;
    document.getElementById("imagem").src = receita.imagem;

    const ing = document.getElementById("ingredientes");
    ing.innerHTML = "";
    receita.ingredientes.forEach(i => {
        const li = document.createElement("li");
        li.textContent = i;
        ing.appendChild(li);
    });

    const prep = document.getElementById("preparo");
    prep.innerHTML = "";
    receita.preparo.forEach(p => {
        const li = document.createElement("li");
        li.textContent = p;
        prep.appendChild(li);
    });
}
