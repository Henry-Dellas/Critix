<?php
// Array global com TODOS os itens (filmes, livros e séries)
$todosItens = [
    // Filmes (IDs 1-30)
    1 => [
        "tipo" => "filme",
        "titulo" => "Um Lugar Chamado Notting Hill",
        "imagem" => "nottinghill.jpg",
        "descricao" => "Comédia romântica clássica.",
        "detalhes" => "Um dono de livraria se apaixona por uma atriz famosa.",
        "nota" => 4,
        "genero" => "Comédia Romântica",
        "autor" => "Roger Michell",
        "ano" => 1999
    ],
    2 => [
        "tipo" => "filme",
        "titulo" => "Orgulho e Preconceito (2005)",
        "imagem" => "orgulho.jpg",
        "descricao" => "Romance de época baseado no clássico de Jane Austen.",
        "detalhes" => "Elizabeth Bennet enfrenta questões de moral, educação e casamento.",
        "nota" => 4.5,
        "genero" => "Drama/Romance",
        "autor" => "Joe Wright",
        "ano" => 2005
    ],
    3 => [
        "tipo" => "filme",
        "titulo" => "Interestelar",
        "imagem" => "interstellar.png",
        "descricao" => "Viagem espacial para salvar a humanidade.",
        "detalhes" => "Uma equipe de astronautas viaja por um buraco de minhoca em busca de um novo lar.",
        "nota" => 5,
        "genero" => "Ficção Científica",
        "autor" => "Christopher Nolan",
        "ano" => 2014
    ],
    4 => [
        "tipo" => "filme",
        "titulo" => "Como Perder Um Homem em 10 Dias",
        "imagem" => "como_perder_homem_10.jpg",
        "descricao" => "Jogo amoroso com consequências inesperadas.",
        "detalhes" => "Uma jornalista e um publicitário entram em um relacionamento com objetivos ocultos.",
        "nota" => 3.5,
        "genero" => "Comédia Romântica",
        "autor" => "Donald Petrie",
        "ano" => 2003
    ],
    5 => [
        "tipo" => "filme",
        "titulo" => "Star Wars III: A Vingança dos Sith",
        "imagem" => "SW_vinganca_sith.jpg",
        "descricao" => "A queda de Anakin Skywalker.",
        "detalhes" => "O jovem Jedi é seduzido pelo lado sombrio da Força e se torna Darth Vader.",
        "nota" => 4.7,
        "genero" => "Ficção Científica",
        "autor" => "George Lucas",
        "ano" => 2005
    ],
    6 => [
        "tipo" => "filme",
        "titulo" => "Conclave",
        "imagem" => "conclave.jpg",
        "descricao" => "Drama político dentro do Vaticano.",
        "detalhes" => "Cardeais se reúnem para eleger o novo Papa.",
        "nota" => 4.2,
        "genero" => "Drama Político",
        "autor" => "Edward Bennett",
        "ano" => 2017
    ],
    7 => [
        "tipo" => "filme",
        "titulo" => "O Poderoso Chefão",
        "imagem" => "poderoso_chefao.jpg",
        "descricao" => "Clássico do cinema sobre a família Corleone.",
        "detalhes" => "Michael Corleone assume os negócios da família após atentado contra o pai.",
        "nota" => 4.9,
        "genero" => "Drama/Crime",
        "autor" => "Francis Ford Coppola",
        "ano" => 1972
    ],
    8 => [
        "tipo" => "filme",
        "titulo" => "Clube da Luta",
        "imagem" => "clube_luta.jpg",
        "descricao" => "Drama psicológico sobre insatisfação com a vida moderna.",
        "detalhes" => "Um homem deprimido forma um clube secreto de combate como terapia radical.",
        "nota" => 4.8,
        "genero" => "Drama/Psicológico",
        "autor" => "David Fincher",
        "ano" => 1999
    ],
    9 => [
        "tipo" => "filme",
        "titulo" => "O Senhor dos Anéis: O Retorno do Rei",
        "imagem" => "sda_retorno_rei.jpg",
        "descricao" => "Episódio final da trilogia do Anel.",
        "detalhes" => "Frodo e Sam chegam a Mordor enquanto Aragorn lidera as forças do bem.",
        "nota" => 5,
        "genero" => "Fantasia/Aventura",
        "autor" => "Peter Jackson",
        "ano" => 2003
    ],
    10 => [
        "tipo" => "filme",
        "titulo" => "Parasita",
        "imagem" => "parasita.jpg",
        "descricao" => "Thriller social sobre desigualdade.",
        "detalhes" => "Uma família pobre infiltra-se na casa de uma família rica.",
        "nota" => 4.7,
        "genero" => "Thriller/Drama",
        "autor" => "Bong Joon-ho",
        "ano" => 2019
    ],
    
    // Livros (IDs 11-20)
    11 => [
        "tipo" => "livro",
        "titulo" => "Orgulho e Preconceito",
        "imagem" => "orgulholivro.jpeg",
        "descricao" => "Clássico romance de Jane Austen.",
        "detalhes" => "Elizabeth Bennet e a sociedade inglesa do séc. XIX.",
        "nota" => 4.8,
        "genero" => "Romance de Época",
        "autor" => "Jane Austen",
        "ano" => 1813,
        "paginas" => 240
    ],
    12 => [
        "tipo" => "livro",
        "titulo" => "O Conclave",
        "imagem" => "conclavelivro.jpeg",
        "descricao" => "Thriller político sobre a eleição papal.",
        "detalhes" => "Intrigas e segredos no Vaticano durante a eleição do novo Papa.",
        "nota" => 4.6,
        "genero" => "Suspense",
        "autor" => "Robert Harris",
        "ano" => 2016,
        "paginas" => 320
    ],
    13 => [
        "tipo" => "livro",
        "titulo" => "Persuasão",
        "imagem" => "persuasao.jpeg",
        "descricao" => "Clássico de Jane Austen sobre segundas chances.",
        "detalhes" => "Anne Elliot reencontra um amor do passado.",
        "nota" => 4.6,
        "genero" => "Romance de Época",
        "autor" => "Jane Austen",
        "ano" => 1817,
        "paginas" => 250
    ],
    14 => [
        "tipo" => "livro",
        "titulo" => "1984",
        "imagem" => "1984.jpg",
        "descricao" => "Distopia sobre vigilância totalitária.",
        "detalhes" => "Winston Smith desafia o regime opressivo do Grande Irmão.",
        "nota" => 4.7,
        "genero" => "Distopia/Ficção Científica",
        "autor" => "George Orwell",
        "ano" => 1949,
        "paginas" => 328
    ],
    15 => [
        "tipo" => "livro",
        "titulo" => "O Apanhador no Campo de Centeio",
        "imagem" => "apanhador_centeio.jpg",
        "descricao" => "Clássico sobre adolescência e alienação.",
        "detalhes" => "Holden Caulfield narra suas experiências em Nova York.",
        "nota" => 4.3,
        "genero" => "Literatura/Ficção",
        "autor" => "J.D. Salinger",
        "ano" => 1951,
        "paginas" => 234
    ],
    16 => [
        "tipo" => "livro",
        "titulo" => "Cem Anos de Solidão",
        "imagem" => "cem_anos_solidao.jpg",
        "descricao" => "Realismo mágico sobre a família Buendía.",
        "detalhes" => "Saga multigeracional na cidade imaginária de Macondo.",
        "nota" => 4.8,
        "genero" => "Realismo Mágico",
        "autor" => "Gabriel García Márquez",
        "ano" => 1967,
        "paginas" => 417
    ],
    17 => [
        "tipo" => "livro",
        "titulo" => "O Pequeno Príncipe",
        "imagem" => "pequeno_principe.jpg",
        "descricao" => "Fábula filosófica sobre amizade e amor.",
        "detalhes" => "Um piloto conhece um príncipe de outro planeta no deserto.",
        "nota" => 4.9,
        "genero" => "Fábula/Filosofia",
        "autor" => "Antoine de Saint-Exupéry",
        "ano" => 1943,
        "paginas" => 96
    ],
    18 => [
        "tipo" => "livro",
        "titulo" => "Dom Quixote",
        "imagem" => "dom_quixote.jpg",
        "descricao" => "Clássico sobre um fidalgo que se torna cavaleiro andante.",
        "detalhes" => "Dom Quixote e Sancho Pança em aventuras imaginárias.",
        "nota" => 4.5,
        "genero" => "Romance/Aventura",
        "autor" => "Miguel de Cervantes",
        "ano" => 1605,
        "paginas" => 863
    ],
    19 => [
        "tipo" => "livro",
        "titulo" => "Crime e Castigo",
        "imagem" => "crime_castigo.jpg",
        "descricao" => "Drama psicológico sobre culpa e redenção.",
        "detalhes" => "Estudante comete assassinato e lida com as consequências.",
        "nota" => 4.6,
        "genero" => "Drama/Psicológico",
        "autor" => "Fiódor Dostoiévski",
        "ano" => 1866,
        "paginas" => 551
    ],
    20 => [
        "tipo" => "livro",
        "titulo" => "A Revolução dos Bichos",
        "imagem" => "revolucao_bichos.jpg",
        "descricao" => "Alegoria política sobre poder e corrupção.",
        "detalhes" => "Animais se rebelam contra humanos mas acabam reproduzindo desigualdades.",
        "nota" => 4.7,
        "genero" => "Sátira/Política",
        "autor" => "George Orwell",
        "ano" => 1945,
        "paginas" => 152
    ],
    
    // Séries (IDs 21-30)
    21 => [
        "tipo" => "serie",
        "titulo" => "Anne with an E",
        "imagem" => "anne_gables.jpg",
        "descricao" => "Adaptação de 'Anne de Green Gables'.",
        "detalhes" => "A jornada de Anne Shirley, uma órfã imaginativa.",
        "nota" => 4.8,
        "genero" => "Drama",
        "autor" => "Moira Walley-Beckett",
        "ano" => 2017,
        "temporadas" => 3
    ],
    22 => [
        "tipo" => "serie",
        "titulo" => "Balada de Amor ao Vento",
        "imagem" => "balada_amor.jpg",
        "descricao" => "Drama romântico baseado em best-seller.",
        "detalhes" => "Amor proibido entre famílias rivais.",
        "nota" => 4.5,
        "genero" => "Romance/Drama",
        "autor" => "Carlos Saura",
        "ano" => 2020,
        "temporadas" => 2
    ],
    23 => [
        "tipo" => "serie",
        "titulo" => "Breaking Bad",
        "imagem" => "breaking_bad.jpg",
        "descricao" => "Drama sobre um professor que vira produtor de metanfetamina.",
        "detalhes" => "Walter White usa seus conhecimentos de química para produzir drogas após diagnóstico de câncer.",
        "nota" => 4.9,
        "genero" => "Drama/Crime",
        "autor" => "Vince Gilligan",
        "ano" => 2008,
        "temporadas" => 5
    ],
    24 => [
        "tipo" => "serie",
        "titulo" => "Game of Thrones",
        "imagem" => "game_thrones.jpg",
        "descricao" => "Drama político em mundo de fantasia medieval.",
        "detalhes" => "Famílias nobres lutam pelo controle do Trono de Ferro.",
        "nota" => 4.7,
        "genero" => "Fantasia/Drama",
        "autor" => "David Benioff e D.B. Weiss",
        "ano" => 2011,
        "temporadas" => 8
    ],
    25 => [
        "tipo" => "serie",
        "titulo" => "Stranger Things",
        "imagem" => "stranger_things.jpg",
        "descricao" => "Mistério e ficção científica nos anos 80.",
        "detalhes" => "Crianças enfrentam criaturas de uma dimensão paralela.",
        "nota" => 4.6,
        "genero" => "Ficção Científica/Mistério",
        "autor" => "Duffer Brothers",
        "ano" => 2016,
        "temporadas" => 4
    ],
    26 => [
        "tipo" => "serie",
        "titulo" => "The Crown",
        "imagem" => "the_crown.jpg",
        "descricao" => "Drama histórico sobre a rainha Elizabeth II.",
        "detalhes" => "A vida e reinado da monarca britânica.",
        "nota" => 4.5,
        "genero" => "Drama/Histórico",
        "autor" => "Peter Morgan",
        "ano" => 2016,
        "temporadas" => 5
    ],
    27 => [
        "tipo" => "serie",
        "titulo" => "Friends",
        "imagem" => "friends.jpg",
        "descricao" => "Comédia sobre um grupo de amigos em Nova York.",
        "detalhes" => "Seis amigos enfrentam os altos e baixos da vida adulta.",
        "nota" => 4.8,
        "genero" => "Comédia",
        "autor" => "David Crane e Marta Kauffman",
        "ano" => 1994,
        "temporadas" => 10
    ],
    28 => [
        "tipo" => "serie",
        "titulo" => "The Mandalorian",
        "imagem" => "mandalorian.jpg",
        "descricao" => "Aventura no universo Star Wars.",
        "detalhes" => "Caçador de recompensas protege uma criança misteriosa.",
        "nota" => 4.7,
        "genero" => "Ficção Científica/Aventura",
        "autor" => "Jon Favreau",
        "ano" => 2019,
        "temporadas" => 3
    ],
    29 => [
        "tipo" => "serie",
        "titulo" => "The Witcher",
        "imagem" => "witcher.jpg",
        "descricao" => "Fantasia sombria baseada nos livros.",
        "detalhes" => "Geralt de Rívia, um bruxo caçador de monstros.",
        "nota" => 4.4,
        "genero" => "Fantasia/Ação",
        "autor" => "Lauren Schmidt Hissrich",
        "ano" => 2019,
        "temporadas" => 3
    ],
    30 => [
        "tipo" => "serie",
        "titulo" => "Black Mirror",
        "imagem" => "black_mirror.jpg",
        "descricao" => "Antologia sobre tecnologia e sociedade.",
        "detalhes" => "Episódios independentes exploram o lado sombrio da tecnologia.",
        "nota" => 4.6,
        "genero" => "Ficção Científica/Distopia",
        "autor" => "Charlie Brooker",
        "ano" => 2011,
        "temporadas" => 6
    ]
];


$categorias = [
    "For You" => [
        1 => $todosItens[1], 
        2 => $todosItens[2], 
        3 => $todosItens[3],
        4 => $todosItens[4], 
        5 => $todosItens[5],
        6 => $todosItens[6],
        7 => $todosItens[7],
        8 => $todosItens[8],
        9 => $todosItens[9],
        10 => $todosItens[10],
        11 => $todosItens[11],
        12 => $todosItens[12],
        13 => $todosItens[13],
        14 => $todosItens[14],
        15 => $todosItens[15],
        16 => $todosItens[16],
        17 => $todosItens[17],
        18 => $todosItens[18],
        19 => $todosItens[19],
        20 => $todosItens[20],
        21 => $todosItens[21],
        22 => $todosItens[22],
        23 => $todosItens[23],
        24 => $todosItens[24],
        25 => $todosItens[25],
        26 => $todosItens[26],
        27 => $todosItens[27],
        28 => $todosItens[28],
        29 => $todosItens[29],
        30 => $todosItens[30],
    ],
    "Recomendados" => [
        1 => $todosItens[1],
        30 => $todosItens[30],
    ],
    "Séries" => [
        
    ],
    
];

// Função auxiliar para encontrar em quais categorias um item aparece
function encontrarCategoriasItem($id, $categorias) {
    $cats = [];
    foreach ($categorias as $nomeCat => $itens) {
        if (isset($itens[$id])) {
            $cats[] = $nomeCat;
        }
    }
    return $cats;
}
?>