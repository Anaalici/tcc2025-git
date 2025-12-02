// Banco de dados simples
window.receitas = {
    bolocenoura: {
        id: "bolocenoura",
        titulo: "Bolo de Cenoura",
        imagem: "imgCategorias/bolocenoua.webp",
        tempo: "40 min",
        dificuldade: "Fácil",
        utensilios: [
            { nome: "Liquidificador", imagem: "imgCategorias/itens/liquidificador.jpg" },
            { nome: "Forma", imagem: "imgCategorias/itens/forma.webp" },
              { nome: "Espátula", imagem: "imgCategorias/itens/espatula.webp" },
                { nome: "Tigela", imagem: "imgCategorias/itens/tigela.webp" },
                  { nome: "Peneira", imagem: "imgCategorias/itens/peneira.jpg" }
            
        ],
        ingredientes: ["3 cenouras","1 xícara de óleo", "2 e 1/2 xícaras de farinha", "3 ovos", "2 xícara de açúcar", "1 colher (sopa) de fermento em pó", "1 colher (sopa) de manteiga", "3 colheres (sopa) de cacau ou chocolate em pó", "1 xícara de sçucar", "1/2 xícara de leite"],
        preparo: ["No liquidificador, bata cenouras, ovos e óleo até ficar bem lisinho.", "Em uma tigela, coloque açúcar e farinha peneirada.", "Despeje a mistura do liquidificador sobre os secos e mexa com calma até ficar homogêneo.", "Adicione o fermento e misture levemente.", "Transfira para uma forma untada e enfarinhada.", "Asse em forno pré-aquecido a 180 °C por cerca de 35 a 45 minutos.", "Misture os ingredientes da cobertura em uma panelinha.", "Leve ao fogo baixo mexendo até começar a engrossar", "Jogue sobre o bolo ainda quente."],
        comentarios: []
    },


    frango: {
        id: "frango",
        titulo: "Frango Crocante",
        imagem: "img/frango.jpg",
        ingredientes: ["500g de frango", "Farinha", "Ovos", "Temperos"],
        preparo: ["Empane o frango.", "Frite até dourar."],
        comentarios: []
    },

    strogonoff: {
        id: "strogonoff",
        titulo: "Strogonoff de Frango",
        imagem: "img/strogonoff.jpg",
        ingredientes: ["Frango", "Creme de leite", "Ketchup", "Mostarda"],
        preparo: ["Refogue o frango.", "Adicione os molhos."],
        comentarios: []
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
