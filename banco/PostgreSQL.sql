-- Criar tabelas
CREATE TABLE filmes (
    id SERIAL PRIMARY KEY,
    tipo VARCHAR(10) NOT NULL DEFAULT 'filme',
    titulo VARCHAR(150) NOT NULL,
    imagem VARCHAR(100),
    descricao TEXT,
    detalhes TEXT,
    nota NUMERIC(3,1),
    genero VARCHAR(50),
    autor VARCHAR(100),
    ano INTEGER
);

CREATE TABLE livros (
    id SERIAL PRIMARY KEY,
    tipo VARCHAR(10) NOT NULL DEFAULT 'livro',
    titulo VARCHAR(150) NOT NULL,
    imagem VARCHAR(100),
    descricao TEXT,
    detalhes TEXT,
    nota NUMERIC(3,1),
    genero VARCHAR(50),
    autor VARCHAR(100),
    ano INTEGER,
    paginas INTEGER
);

CREATE TABLE series (
    id SERIAL PRIMARY KEY,
    tipo VARCHAR(10) NOT NULL DEFAULT 'serie',
    titulo VARCHAR(150) NOT NULL,
    imagem VARCHAR(100),
    descricao TEXT,
    detalhes TEXT,
    nota NUMERIC(3,1),
    genero VARCHAR(50),
    autor VARCHAR(100),
    ano INTEGER,
    temporadas INTEGER
);

-- Inserir dados
INSERT INTO filmes (id, tipo, titulo, imagem, descricao, detalhes, nota, genero, autor, ano) VALUES
(1, 'filme', 'Um Lugar Chamado Notting Hill', 'nottinghill.jpg', 'Comédia romântica clássica.', 'Um dono de livraria se apaixona por uma atriz famosa.', 4.0, 'Comédia Romântica', 'Roger Michell', 1999),
(2, 'filme', 'Orgulho e Preconceito (2005)', 'orgulho.jpg', 'Romance de época baseado no clássico de Jane Austen.', 'Elizabeth Bennet enfrenta questões de moral, educação e casamento.', 4.5, 'Drama/Romance', 'Joe Wright', 2005),
(3, 'filme', 'Interestelar', 'interstellar.png', 'Viagem espacial para salvar a humanidade.', 'Uma equipe de astronautas viaja por um buraco de minhoca em busca de um novo lar.', 5.0, 'Ficção Científica', 'Christopher Nolan', 2014),
(4, 'filme', 'Como Perder Um Homem em 10 Dias', 'como_perder_homem_10.jpg', 'Jogo amoroso com consequências inesperadas.', 'Uma jornalista e um publicitário entram em um relacionamento com objetivos ocultos.', 3.5, 'Comédia Romântica', 'Donald Petrie', 2003),
(5, 'filme', 'Star Wars III: A Vingança dos Sith', 'SW_vinganca_sith.jpg', 'A queda de Anakin Skywalker.', 'O jovem Jedi é seduzido pelo lado sombrio da Força e se torna Darth Vader.', 4.7, 'Ficção Científica', 'George Lucas', 2005),
(6, 'filme', 'Conclave', 'conclave.jpg', 'Drama político dentro do Vaticano.', 'Cardeais se reúnem para eleger o novo Papa.', 4.2, 'Drama Político', 'Edward Bennett', 2017),
(7, 'filme', 'O Poderoso Chefão', 'poderoso_chefao.jpg', 'Clássico do cinema sobre a família Corleone.', 'Michael Corleone assume os negócios da família após atentado contra o pai.', 4.9, 'Drama/Crime', 'Francis Ford Coppola', 1972),
(8, 'filme', 'Clube da Luta', 'clube_luta.jpg', 'Drama psicológico sobre insatisfação com a vida moderna.', 'Um homem deprimido forma um clube secreto de combate como terapia radical.', 4.8, 'Drama/Psicológico', 'David Fincher', 1999),
(9, 'filme', 'O Senhor dos Anéis: O Retorno do Rei', 'sda_retorno_rei.jpg', 'Episódio final da trilogia do Anel.', 'Frodo e Sam chegam a Mordor enquanto Aragorn lidera as forças do bem.', 5.0, 'Fantasia/Aventura', 'Peter Jackson', 2003),
(10, 'filme', 'Parasita', 'parasita.jpg', 'Thriller social sobre desigualdade.', 'Uma família pobre infiltra-se na casa de uma família rica.', 4.7, 'Thriller/Drama', 'Bong Joon-ho', 2019);

INSERT INTO livros (id, tipo, titulo, imagem, descricao, detalhes, nota, genero, autor, ano, paginas) VALUES
(11, 'livro', 'Orgulho e Preconceito', 'orgulholivro.jpeg', 'Clássico romance de Jane Austen.', 'Elizabeth Bennet e a sociedade inglesa do séc. XIX.', 4.8, 'Romance de Época', 'Jane Austen', 1813, 240),
(12, 'livro', 'O Conclave', 'conclavelivro.jpeg', 'Thriller político sobre a eleição papal.', 'Intrigas e segredos no Vaticano durante a eleição do novo Papa.', 4.6, 'Suspense', 'Robert Harris', 2016, 320),
(13, 'livro', 'Persuasão', 'persuasao.jpeg', 'Clássico de Jane Austen sobre segundas chances.', 'Anne Elliot reencontra um amor do passado.', 4.6, 'Romance de Época', 'Jane Austen', 1817, 250),
(14, 'livro', '1984', '1984.jpg', 'Distopia sobre vigilância totalitária.', 'Winston Smith desafia o regime opressivo do Grande Irmão.', 4.7, 'Distopia/Ficção Científica', 'George Orwell', 1949, 328),
(15, 'livro', 'O Apanhador no Campo de Centeio', 'apanhador_centeio.jpg', 'Clássico sobre adolescência e alienação.', 'Holden Caulfield narra suas experiências em Nova York.', 4.3, 'Literatura/Ficção', 'J.D. Salinger', 1951, 234),
(16, 'livro', 'Cem Anos de Solidão', 'cem_anos_solidao.jpg', 'Realismo mágico sobre a família Buendía.', 'Saga multigeracional na cidade imaginária de Macondo.', 4.8, 'Realismo Mágico', 'Gabriel García Márquez', 1967, 417),
(17, 'livro', 'O Pequeno Príncipe', 'pequeno_principe.jpg', 'Fábula filosófica sobre amizade e amor.', 'Um piloto conhece um príncipe de outro planeta no deserto.', 4.9, 'Fábula/Filosofia', 'Antoine de Saint-Exupéry', 1943, 96),
(18, 'livro', 'Dom Quixote', 'dom_quixote.jpg', 'Clássico sobre um fidalgo que se torna cavaleiro andante.', 'Dom Quixote e Sancho Pança em aventuras imaginárias.', 4.5, 'Romance/Aventura', 'Miguel de Cervantes', 1605, 863),
(19, 'livro', 'Crime e Castigo', 'crime_castigo.jpg', 'Drama psicológico sobre culpa e redenção.', 'Estudante comete assassinato e lida com as consequências.', 4.6, 'Drama/Psicológico', 'Fiódor Dostoiévski', 1866, 551),
(20, 'livro', 'A Revolução dos Bichos', 'revolucao_bichos.jpg', 'Alegoria política sobre poder e corrupção.', 'Animais se rebelam contra humanos mas acabam reproduzindo desigualdades.', 4.7, 'Sátira/Política', 'George Orwell', 1945, 152);

INSERT INTO series (id, tipo, titulo, imagem, descricao, detalhes, nota, genero, autor, ano, temporadas) VALUES
(21, 'serie', 'Anne with an E', 'anne_gables.jpg', 'Adaptação de ''Anne de Green Gables''.', 'A jornada de Anne Shirley, uma órfã imaginativa.', 4.8, 'Drama', 'Moira Walley-Beckett', 2017, 3),
(22, 'serie', 'Balada de Amor ao Vento', 'balada_amor.jpg', 'Drama romântico baseado em best-seller.', 'Amor proibido entre famílias rivais.', 4.5, 'Romance/Drama', 'Carlos Saura', 2020, 2),
(23, 'serie', 'Breaking Bad', 'breaking_bad.jpg', 'Drama sobre um professor que vira produtor de metanfetamina.', 'Walter White usa seus conhecimentos de química para produzir drogas após diagnóstico de câncer.', 4.9, 'Drama/Crime', 'Vince Gilligan', 2008, 5),
(24, 'serie', 'Game of Thrones', 'game_thrones.jpg', 'Drama político em mundo de fantasia medieval.', 'Famílias nobres lutam pelo controle do Trono de Ferro.', 4.7, 'Fantasia/Drama', 'David Benioff e D.B. Weiss', 2011, 8),
(25, 'serie', 'Stranger Things', 'stranger_things.jpg', 'Mistério e ficção científica nos anos 80.', 'Crianças enfrentam criaturas de uma dimensão paralela.', 4.6, 'Ficção Científica/Mistério', 'Duffer Brothers', 2016, 4),
(26, 'serie', 'The Crown', 'the_crown.jpg', 'Drama histórico sobre a rainha Elizabeth II.', 'A vida e reinado da monarca britânica.', 4.5, 'Drama/Histórico', 'Peter Morgan', 2016, 5),
(27, 'serie', 'Friends', 'friends.jpg', 'Comédia sobre um grupo de amigos em Nova York.', 'Seis amigos enfrentam os altos e baixos da vida adulta.', 4.8, 'Comédia', 'David Crane e Marta Kauffman', 1994, 10),
(28, 'serie', 'The Mandalorian', 'mandalorian.jpg', 'Aventura no universo Star Wars.', 'Caçador de recompensas protege uma criança misteriosa.', 4.7, 'Ficção Científica/Aventura', 'Jon Favreau', 2019, 3),
(29, 'serie', 'The Witcher', 'witcher.jpg', 'Fantasia sombria baseada nos livros.', 'Geralt de Rívia, um bruxo caçador de monstros.', 4.4, 'Fantasia/Ação', 'Lauren Schmidt Hissrich', 2019, 3),
(30, 'serie', 'Black Mirror', 'black_mirror.jpg', 'Antologia sobre tecnologia e sociedade.', 'Episódios independentes exploram o lado sombrio da tecnologia.', 4.6, 'Ficção Científica/Distopia', 'Charlie Brooker', 2011, 6);

-- Criar tabelas para categorias
CREATE TABLE categorias (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

CREATE TABLE categoria_item (
    categoria_id INTEGER REFERENCES categorias(id),
    item_id INTEGER,
    tipo_item VARCHAR(10), -- 'filme', 'livro' ou 'serie'
    PRIMARY KEY (categoria_id, item_id, tipo_item)
);

-- Inserir categorias
INSERT INTO categorias (nome) VALUES
('For You'),
('Recomendados'),
('Séries');

-- Inserir relações para categorias
INSERT INTO categoria_item (categoria_id, item_id, tipo_item)
SELECT 1, id, 'filme' FROM filmes;

INSERT INTO categoria_item (categoria_id, item_id, tipo_item)
SELECT 1, id, 'livro' FROM livros;

INSERT INTO categoria_item (categoria_id, item_id, tipo_item)
SELECT 1, id, 'serie' FROM series;

INSERT INTO categoria_item (categoria_id, item_id, tipo_item) VALUES
(2, 1, 'filme'),
(2, 30, 'serie');