window.categorias = {
    japonesa: [
        {
            id: 'sushi-salmao', nome: 'Sushi de Salmão', dificuldade: 'Fácil', tempo: '30 min', imagem: 'imgCategorias/sushi.jpg',
            utensilios: [
                { nome: 'Esteira de bambu', img: 'imgCategorias/itens/esteiraBambu.jpg' },
                { nome: 'Faca afiada', img: 'imgCategorias/itens/faca.jpg' },
                { nome: 'Tigela para arroz', img: 'imgCategorias/itens/tigela.webp' },
                { nome: 'Colher de arroz', img: 'imgCategorias/itens/colher.webp' }
            ],
            ingredientes: [
                "2 folhas de alga",
                "300g de arroz",
                "3 colheres (chá) de açúcar",
                "2 postas de salmão sem pele",
                "3 colheres (chá) de sal",
                "3 colheres de vinagre branco"
            ],
            preparo: [
                "Cozinhe o arroz até ficar grudento.",
                "Tempere o arroz com vinagre, sal e açúcar.",
                "Corte o salmão em tiras finas.",
                "Espalhe o arroz sobre a alga e coloque o salmão.",
                "Enrole e corte em rodelas."
            ]
        },
        {
            id: 'temaki-frito', nome: 'Temaki Frito', dificuldade: 'Médio', tempo: '60 min', imagem: 'imgCategorias/temaki.webp',
            utensilios: [{ nome: 'Panela', img: 'imgCategorias/itens/panela.jpg' }, { nome: 'Faca', img: 'imgCategorias/itens/faca.jpg' }],
            ingredientes: ["Arroz japonês", "Alga nori", "Peixe", "Massa para tempurá"],
            preparo: ["Enrole o temaki.", "Passe na massa de tempurá.", "Frite rapidamente em óleo quente.", "Sirva."]
        },
        { id: 'gyoza', nome: 'Gyoza', dificuldade: 'Médio', tempo: '40 min', imagem: 'imgCategorias/gyoza.jpg' },
        { id: 'ramen', nome: 'Ramen', dificuldade: 'Fácil', tempo: '40 min', imagem: 'imgCategorias/ramen.jpg' },
        { id: 'tempura', nome: 'Tempurá', dificuldade: 'Médio', tempo: '40 min', imagem: 'imgCategorias/tempura.jpg' },
        { id: 'onigiri', nome: 'Onigiri', dificuldade: 'Fácil', tempo: '15 min', imagem: 'imgCategorias/onigiri.jpg' },
        { id: 'yakitori', nome: 'Yakitori', dificuldade: 'Fácil', tempo: '35 min', imagem: 'imgCategorias/espeto.jpg' },
        { id: 'takoyaki', nome: 'Takoyaki', dificuldade: 'Médio', tempo: '50 min', imagem: 'imgCategorias/takoyaki.avif' },
        { id: 'sashimi', nome: 'Sashimi', dificuldade: 'Médio', tempo: '20 min', imagem: 'imgCategorias/sashimi.jpg' },
        { id: 'kareRaisu', nome: 'Kare Raisu', dificuldade: 'Fácil', tempo: '40 min', imagem: 'imgCategorias/kare.jpg' },
        { id: 'tonkatsu', nome: 'Tonkatsu', dificuldade: 'Médio', tempo: '50 min', imagem: 'imgCategorias/tonkatsu.jpg' },
        { id: 'hotroll', nome: 'Hot Roll', dificuldade: 'Médio', tempo: '45 min', imagem: 'imgCategorias/hotroll.jpg' },
        { id: 'yakisoba', nome: 'Yakisoba', dificuldade: 'Fácil', tempo: '30 min', imagem: 'imgCategorias/yakisoba.webp' },
        { id: 'gyudon', nome: 'Gyudon', dificuldade: 'Fácil', tempo: '25 min', imagem: 'imgCategorias/gyudon.jpg' },
        { id: 'sunomono', nome: 'Sunomono', dificuldade: 'Fácil', tempo: '15 min', imagem: 'imgCategorias/sonomono.jpg' },
        { id: 'harumaki', nome: 'Harumaki', dificuldade: 'Fácil', tempo: '40 min', imagem: 'imgCategorias/harumaki.jpg' },
        { id: 'karaage', nome: 'Karaage', dificuldade: 'Médio', tempo: '45 min', imagem: 'imgCategorias/karaage.jpg' },
        { id: 'sopaMisso', nome: 'Sopa de Missô', dificuldade: 'Fácil', tempo: '15 min', imagem: 'imgCategorias/sopaMisso.jpg' }
    ],

    vegana: [
        {
            id: 'vegan-strogonoff',
            nome: 'Strogonoff Vegano',
            dificuldade: 'Fácil',
            tempo: '25 min',
            imagem: 'imgCategorias/strogonoffvegano.jpg',
            utensilios: [{ nome: 'Panela', img: 'imgCategoriasVeg/panela.jpg' }],
            ingredientes: ["Cogumelos", "Creme vegetal", "Mostarda", "Arroz"],
            preparo: ["Refogue os cogumelos.", "Adicione creme vegetal e tempere.", "Sirva com arroz."]
        },
        {
            id: 'vegan-burger',
            nome: 'Hambúrguer Vegano',
            dificuldade: 'Médio',
            tempo: '40 min',
            imagem: 'imgCategorias/hamburguervagn.jpg',
            utensilios: [{ nome: 'Frigideira', img: 'imgCategoriasVeg/frigideira.jpg' }],
            ingredientes: ["Grão-de-bico", "Aveia", "Temperos", "Pão vegano"],
            preparo: ["Processe os ingredientes.", "Modele os hambúrgueres.", "Frite ou asse até dourar.", "Monte no pão."]
        },
        {
            id: 'vegan-panqueca',
            nome: 'Panqueca Vegana',
            dificuldade: 'Fácil',
            tempo: '20 min',
            imagem: 'imgCategorias/panquecavegana.jpg',
            utensilios: [{ nome: 'Frigideira', img: 'imgCategoriasVeg/frigideira.jpg' }],
            ingredientes: ["Farinha", "Leite vegetal", "Fermento", "Adoçante"],
            preparo: ["Misture os ingredientes até ficar homogêneo.", "Cozinhe em frigideira quente.", "Sirva com frutas ou melado."]
        },
        {
            id: 'vegan-salad-bowl',
            nome: 'Salad Bowl Proteico',
            dificuldade: 'Fácil',
            tempo: '15 min',
            imagem: 'imgCategorias/saladavegana.jpg',
            utensilios: [{ nome: 'Tigela', img: 'imgCategoriasVeg/tigela.jpg' }],
            ingredientes: ["Folhas verdes", "Quinoa", "Grão-de-bico", "Molho tahine"],
            preparo: ["Cozinhe a quinoa.", "Misture os ingredientes.", "Tempere e sirva."]
        },
        {
            id: 'vegan-espaguete',
            nome: 'Espaguete ao Molho de Tomate e Tofu',
            dificuldade: 'Médio',
            tempo: '35 min',
            imagem: 'imgCategorias/espaguete.jpg',
            utensilios: [{ nome: 'Panela', img: 'imgCategoriasVeg/panela.jpg' }],
            ingredientes: ["Espaguete", "Tomates", "Tofu", "Alho", "Manjericão"],
            preparo: ["Cozinhe a massa.", "Refogue o molho com tofu.", "Misture e sirva."]
        },
        {
            id: 'vegan-bolinhos',
            nome: 'Bolinhos de Grão-de-Bico',
            dificuldade: 'Médio',
            tempo: '30 min',
            imagem: 'imgCategorias/bolinhovagano.jpg',
            utensilios: [{ nome: 'Assadeira', img: 'imgCategoriasVeg/assadeira.jpg' }],
            ingredientes: ["Grão-de-bico", "Farinha", "Temperos"],
            preparo: ["Amasse o grão-de-bico.", "Modele e asse ou frite.", "Sirva com molho."]
        },
            {
            id: 'vegan-pizza',
            nome: 'Pizza Vegana',
            dificuldade: 'Médio',
            tempo: '50 min',
            imagem: 'imgCategorias/pizzavegana.jpg',
            utensilios: [{ nome: 'Assadeira', img: 'imgCategoriasVeg/assadeira.jpg' }],
            ingredientes: ["Grão-de-bico", "Farinha", "Temperos"],
            preparo: ["Amasse o grão-de-bico.", "Modele e asse ou frite.", "Sirva com molho."]
        }
    ],

    massadoce: [
        {
            id: 'boloChocolate',
            nome: 'Bolo de Chocolate com Morango',
            dificuldade: 'Médio',
            tempo: '20 min',
            imagem: 'imgCategorias/boloChoco.webp   ',
            utensilios: [{ nome: 'Assadeira', img: 'imgCategoriasVeg/assadeira.jpg' }],
            ingredientes: ["Grão-de-bico", "Farinha", "Temperos"],
            preparo: ["Amasse o grão-de-bico.", "Modele e asse ou frite.", "Sirva com molho."]
        },

        {
            id: 'boloCenoura',
            nome: 'Bolo de Cenoura',
            dificuldade: 'Médio',
            tempo: '20 min',
            imagem: 'imgCategorias/boloCenoura.jpg',
            utensilios: [{ nome: 'Assadeira', img: 'imgCategoriasVeg/assadeira.jpg' }],
            ingredientes: ["Grão-de-bico", "Farinha", "Temperos"],
            preparo: ["Amasse o grão-de-bico.", "Modele e asse ou frite.", "Sirva com molho."]
        },

                {
            id: 'tortaLimao',
            nome: 'Torta de Limão',
            dificuldade: 'Médio',
            tempo: '20 min',
            imagem: 'imgCategorias/tortaLimoa.jpg',
            utensilios: [{ nome: 'Assadeira', img: 'imgCategoriasVeg/assadeira.jpg' }],
            ingredientes: ["Grão-de-bico", "Farinha", "Temperos"],
            preparo: ["Amasse o grão-de-bico.", "Modele e asse ou frite.", "Sirva com molho."]
        },

                        {
            id: 'tortaMorango',
            nome: 'Torta de Morango',
            dificuldade: 'Médio',
            tempo: '20 min',
            imagem: 'imgCategorias/tortaMorango.jpg',
            utensilios: [{ nome: 'Assadeira', img: 'imgCategoriasVeg/assadeira.jpg' }],
            ingredientes: ["Grão-de-bico", "Farinha", "Temperos"],
            preparo: ["Amasse o grão-de-bico.", "Modele e asse ou frite.", "Sirva com molho."]
        }
        
    ],

    lanches: [
        {
            id: 'pizza',
            nome: 'Pizza de Frango',
            dificuldade: 'Médio',
            tempo: '20 min',
            imagem: 'imgCategorias/pizaz.jpg',
            utensilios: [{ nome: 'Assadeira', img: 'imgCategoriasVeg/assadeira.jpg' }],
            ingredientes: ["Grão-de-bico", "Farinha", "Temperos"],
            preparo: ["Amasse o grão-de-bico.", "Modele e asse ou frite.", "Sirva com molho."]
        },

        {
            id: 'lanche',
            nome: 'Lanche Natural',
            dificuldade: 'Médio',
            tempo: '20 min',
            imagem: 'imgCategorias/lanche.jpg',
            utensilios: [{ nome: 'Assadeira', img: 'imgCategoriasVeg/assadeira.jpg' }],
            ingredientes: ["Grão-de-bico", "Farinha", "Temperos"],
            preparo: ["Amasse o grão-de-bico.", "Modele e asse ou frite.", "Sirva com molho."]
        },
                {
            id: 'lanche',
            nome: 'Pão de Queijo',
            dificuldade: 'Médio',
            tempo: '20 min',
            imagem: 'imgCategorias/paoq.webp',
            utensilios: [{ nome: 'Assadeira', img: 'imgCategoriasVeg/assadeira.jpg' }],
            ingredientes: ["Grão-de-bico", "Farinha", "Temperos"],
            preparo: ["Amasse o grão-de-bico.", "Modele e asse ou frite.", "Sirva com molho."]
        },

                {
            id: 'lanche',
            nome: 'Pão Recheado',
            dificuldade: 'Médio',
            tempo: '20 min',
            imagem: 'imgCategorias/paoRech.jpg',
            utensilios: [{ nome: 'Assadeira', img: 'imgCategoriasVeg/assadeira.jpg' }],
            ingredientes: ["Grão-de-bico", "Farinha", "Temperos"],
            preparo: ["Amasse o grão-de-bico.", "Modele e asse ou frite.", "Sirva com molho."]
        },

                {
            id: 'lanche',
            nome: 'Coxinha de Frango',
            dificuldade: 'Médio',
            tempo: '20 min',
            imagem: 'imgCategorias/coximh.webp',
            utensilios: [{ nome: 'Assadeira', img: 'imgCategoriasVeg/assadeira.jpg' }],
            ingredientes: ["Grão-de-bico", "Farinha", "Temperos"],
            preparo: ["Amasse o grão-de-bico.", "Modele e asse ou frite.", "Sirva com molho."]
        }
    ],

    bovino: [
        {
            id: 'salGrosso',
            nome: 'Sal Grosso',
            dificuldade: 'finaização',
            tempo: 'médio',    
            imagem: 'imgCategorias/salgrosso.webp',
            
        },
        
                {
            id: 'pimentaReino',
            nome: 'Pimenta do Reino ',
            dificuldade: 'cozimento',
            tempo: 'médio',
            imagem: 'imgCategorias/pimenta.webp',
        },

                {
            id: 'salGrosso',
            nome: 'cominho',
            dificuldade: 'marinada',
            tempo: 'marcante',
            imagem: 'imgCategorias/cominho.webp',
        },

                {
            id: 'alecrim',
            nome: 'Alecrim',
            dificuldade: 'cozimento',
            tempo: 'médio',
            imagem: 'imgCategorias/alecrim.jpg',
        },

                {
            id: 'salGrosso',
            nome: 'Páprica',
            dificuldade: 'marinada',
            tempo: 'suave',
            imagem: 'imgCategorias/papricac.webp',
        },

                {
            id: 'salGrosso',
            nome: 'Alho Triturado',
            dificuldade: 'refogado',
            tempo: 'forte',
            imagem: 'imgCategorias/alho.webp',
        },

                {
            id: 'salGrosso',
            nome: 'Chimichurri',
            dificuldade: 'finalização',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',
        }
    ],

    aves: [
        {
            id: 'salGrosso',
            nome: 'Cúrcuma',
            dificuldade: 'cozimento',
            tempo: 'suave',
            imagem: 'imgCategorias/chimi.webp',   
        },

                {
            id: 'salGrosso',
            nome: 'Lemon Pepper',
            dificuldade: 'finalização',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        },

                {
            id: 'salGrosso',
            nome: 'Páprica Doce',
            dificuldade: 'marinada',
            tempo: 'suave',
            imagem: 'imgCategorias/chimi.webp',   
        },

                {
            id: 'salGrosso',
            nome: 'Alho em pó',
            dificuldade: 'empanado',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        },

                {
            id: 'salGrosso',
            nome: 'Tomilho',
            dificuldade: 'cozimento',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        },

                {
            id: 'salGrosso',
            nome: 'Curry',
            dificuldade: 'cozimento',
            tempo: 'forte',
            imagem: 'imgCategorias/chimi.webp',   
        },

                {
            id: 'salGrosso',
            nome: 'Orégano',
            dificuldade: 'finalização',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        }
    ],

    peixe: [
                        {
            id: 'salGrosso',
            nome: 'Limão',
            dificuldade: 'marinada',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        },

                        {
            id: 'salGrosso',
            nome: 'Alho',
            dificuldade: 'marinada',
            tempo: 'forte',
            imagem: 'imgCategorias/chimi.webp',   
        },

                        {
            id: 'salGrosso',
            nome: 'Coentro',
            dificuldade: 'finalização',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        },


                        {
            id: 'salGrosso',
            nome: 'Pimenta do Reino',
            dificuldade: 'finalização',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        },

                        {
            id: 'salGrosso',
            nome: 'Páprica Defumada',
            dificuldade: 'marinada',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        },

            {
            id: 'salGrosso',
            nome: 'Gengibre',
            dificuldade: 'marinada',
            tempo: 'forte',
            imagem: 'imgCategorias/chimi.webp',   
        },

                        {
            id: 'salGrosso',
            nome: 'Ervas Finas',
            dificuldade: 'finalização',
            tempo: 'suave   ',
            imagem: 'imgCategorias/chimi.webp',   
        }
    ],

    saladas: [
        
            {
            id: 'salGrosso',
            nome: 'Azeite de Oliva',
            dificuldade: 'finalização',
            tempo: 'suave',
            imagem: 'imgCategorias/chimi.webp',   
        },

        
            {
            id: 'salGrosso',
            nome: 'Vinagre Balsâmico',
            dificuldade: 'finalização',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        },

        
            {
            id: 'salGrosso',
            nome: 'Limão',
            dificuldade: 'finalização',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        },

        
            {
            id: 'salGrosso',
            nome: 'Orégano',
            dificuldade: 'finalização',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        },

        
            {
            id: 'salGrosso',
            nome: 'Mostarda',
            dificuldade: 'molhos',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        },

        
            {
            id: 'salGrosso',
            nome: 'Pimenta do Reino',
            dificuldade: 'finalização',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        },

        
            {
            id: 'salGrosso',
            nome: 'Sal rosa',
            dificuldade: 'finalização',
            tempo: 'médio',
            imagem: 'imgCategorias/chimi.webp',   
        }
    ]
};
