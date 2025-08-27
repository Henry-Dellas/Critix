<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - DataMind</title>
    <style>
        body { 
            margin: 0; 
            font-family: Arial, sans-serif; 
            background: #f6f6f6; 
            color: #222; 
        }
        
        .topo { 
            display: grid; 
            grid-template-columns: 1fr auto 1fr; 
            align-items: center; 
            gap: 16px; 
            padding: 14px 18px; 
            background: #2e8b57; 
            color: #fff; 
        }
        
        .brand { 
            font-size: 1.8rem; 
            font-weight: bold; 
        }
        
        .brand span { 
            color: #a8e6cf; 
        }
        
        .abas { 
            display: flex; 
            gap: 24px; 
            justify-content: center; 
        }
        
        .aba { 
            color: #e8f7ef; 
            text-decoration: none; 
            padding: 8px 2px; 
            border-bottom: 3px solid transparent; 
        }
        
        .aba.ativo { 
            color: #fff; 
            border-color: #1a2; 
        }
        
        .acoes { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            justify-content: flex-end; 
        }
        
        .busca { 
            background: #fff; 
            border-radius: 20px; 
            padding: 6px 10px; 
            display: flex; 
            align-items: center; 
            gap: 6px; 
            min-width: 240px; 
        }
        
        .busca input { 
            border: none; 
            outline: none; 
            background: transparent; 
            width: 100%; 
        }
        
        .avatar { 
            width: 34px; 
            height: 34px; 
            background: #fff; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: #2e8b57; 
        }
        
        .hero {
            background: linear-gradient(rgba(152, 196, 162, 0.84), rgba(58, 145, 76, 0.6)), 
                        url('https://images.unsplash.com/photo-1489599851395-36c5c192ac69?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        
        .hero-content {
            max-width: 800px;
            padding: 0 20px;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #fff;
        }
        
        .hero p {
            font-size: 1.2rem;
            color: #e8f7ef;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            color: #2e8b57;
        }
        
        .section-title h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: #a8e6cf;
        }
        
        .about-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
            margin-bottom: 40px;
        }
        
        .about-text {
            flex: 1;
            min-width: 300px;
            line-height: 1.6;
            text-align: justified;
        }
        
        .about-image {
            flex: 1;
            min-width: 300px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,.08);
        }
        
        .about-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.5s ease;
        }
        
        .about-image img:hover {
            transform: scale(1.05);
        }
        
        .mission-vision {
            background-color: #e8f7ef;
            padding: 50px 0;
        }
        
        .mv-container {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }
        
        .mv-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,.08);
            flex: 1;
            min-width: 300px;
            max-width: 500px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .mv-card:hover {
            transform: translateY(-5px);
        }
        
        .mv-card i {
            font-size: 2.5rem;
            color: #2e8b57;
            margin-bottom: 1rem;
        }
        
        .mv-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #2e8b57;
        }
        
        .values {
            padding: 50px 0;
        }
        
        .values-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }
        
        .value-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            flex: 1;
            min-width: 250px;
            max-width: 350px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .value-card:hover {
            transform: translateY(-5px);
        }
        
        .value-card i {
            font-size: 2rem;
            color: #2e8b57;
            margin-bottom: 1rem;
        }
        
        .value-card h3 {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #2e8b57;
        }
        
        .team {
            background-color: #e8f7ef;
            padding: 50px 0;
        }
        
        .team-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
             grid-template-columns: repeat(3, 1fr);
        }
        
        .team-member {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,.08);
            width: 200px;
            transition: transform 0.3s ease;
        }
        
        .team-member:hover {
            transform: translateY(-5px);
        }
        
        .team-img {
            height: 200px;
            overflow: hidden;
        }
        
        .team-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .team-member:hover .team-img img {
            transform: scale(1.1);
        }
        
        .team-info {
            padding: 1.2rem;
            text-align: center;
        }
        
        .team-info h3 {
            margin-bottom: 0.5rem;
            color: #2e8b57;
            font-size: 1.1rem;
        }
        
        .team-info p {
            color: #2e8b57;
            font-style: italic;
            font-size: 0.9rem;
        }
        
        .cta {
            text-align: center;
            padding: 50px 0;
            background: #2e8b57;
            color: white;
        }
        
        .cta h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .cta p {
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto 2rem;
            color: #e8f7ef;
        }
        
        .btn {
            display: inline-block;
            background-color: #a8e6cf;
            color: #2e8b57;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            background-color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        footer {
            background-color: #2e8b57;
            color: white;
            padding: 3rem 0;
            text-align: center;
        }
        
        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-section {
            flex: 1;
            min-width: 250px;
        }
        
        .footer-section h3 {
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
            color: #a8e6cf;
        }
        
        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: #a8e6cf;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        
        .footer-links a {
            color: #e8f7ef;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #a8e6cf;
        }
        
        .social-icons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1rem;
        }
        
        .social-icons a {
            color: #2e8b57;
            background-color: #a8e6cf;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background-color: #fff;
            transform: translateY(-3px);
        }
        
        .copyright {
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #a8e6cf;
        }
        
        @media (max-width: 768px) {
            .topo {
                grid-template-columns: 1fr;
                justify-items: center;
                text-align: center;
                gap: 10px;
            }
            
            .abas {
                order: 3;
                width: 100%;
                justify-content: space-around;
                gap: 10px;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="topo">
        <div class="brand">Data<span>Mind</span></div>
        
        <nav class="abas">
           <a class="aba " href="index.php">Filmes</a>
            <a class="aba" href="series.php">Séries</a>
            <a class="aba" href="livros.php">Livros</a>
            <a href="sobre.php" class="aba ativo">Sobre Nós</a>
        </nav>
        
        <div class="acoes">
            <div class="busca">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Pesquisar...">
            </div>
            <div class="avatar">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Sobre a DataMind</h1>
            <p>Conectando amantes de filmes, séries e livros através de avaliações comunitárias</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="about">
        <div class="container">
            <div class="section-title">
                <h2>Nossa História</h2>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <p>A DataMind nasceu em 2025 da paixão de um grupo de amigos por cinema, séries e literatura. Percebemos que faltava uma plataforma onde entusiastas pudessem compartilhar suas opiniões e descobrir novas obras através de recomendações confiáveis.</p>
                    <p>Começamos com nosso pequeno grupo de amigos conversando sobre assuntos geeks e criando nossas criticas, então percebemos que há muitas críticas que não concordamos e algumas até mesmo acabamos nos recusando de assistir por conta dessas criticas. </p>
                    <p>No nosso TCC, nossa missão agora é democratizar o acesso à crítica cultural, permitindo que todas as vozes sejam ouvidas e valorizadas. Acreditamos que cada pessoa tem uma perspectiva única para compartilhar.</p>
                </div>
                <div class="about-image">
                    <img src="https://i.pinimg.com/736x/26/48/45/2648458cfd4e7cf5d07ead4435609898.jpg" alt="Equipe DataMind">
                </div>
            </div>
        </div>
    </section>

    <!-- Mission and Vision -->
    <section class="mission-vision">
        <div class="container">
            <div class="section-title">
                <h2>Missão e Visão</h2>
            </div>
            <div class="mv-container">
                <div class="mv-card">
                    <i class="fas fa-bullseye"></i>
                    <h3>Missão</h3>
                    <p>Conectar entusiastas de cinema, séries e livros através de uma plataforma colaborativa onde possam compartilhar avaliações, descobrir novas obras e formar uma comunidade baseada no respeito às diversidades de opinião.</p>
                </div>
                <div class="mv-card">
                    <i class="fas fa-eye"></i>
                    <h3>Visão</h3>
                    <p>Ser a principal referência em recomendações de entretenimento cultural na América Latina, reconhecida pela qualidade das discussões e pela diversidade de perspectivas em nossa comunidade.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="values">
        <div class="container">
            <div class="section-title">
                <h2>Nossos Valores</h2>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <i class="fas fa-users"></i>
                    <h3>Comunidade</h3>
                    <p>Valorizamos cada membro de nossa comunidade e acreditamos que a diversidade de opiniões enriquece a experiência cultural de todos.</p>
                </div>
                <div class="value-card">
                    <i class="fas fa-star"></i>
                    <h3>Qualidade</h3>
                    <p>Buscamos sempre excelência em nossas avaliações e incentivamos conteúdos bem fundamentados e reflexivos.</p>
                </div>
                <div class="value-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Transparência</h3>
                    <p>Mantemos processos claros e honestos em nossas avaliações, sem influência de interesses comerciais ou patrocínios.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section class="team">
        <div class="container">
            <div class="section-title">
                <h2>Nosso Time</h2>
            </div>
            <div class="team-grid">
                <div class="team-member">
                    <div class="team-img">
                        <img src="imagens/grupo/bianca.jpg" alt="Fundador">
                    </div>
                    <div class="team-info">
                        <h3>Bianca Vaccani Ticianelli</h3>
                        <p>Programador e Designer</p>
                    </div>
                </div>
                <div class="team-member">
                    <div class="team-img">
                        <img src="imagens/grupo/guilherme.jpg" alt="Head de Conteúdo">
                    </div>
                    <div class="team-info">
                        <h3>Guilherme Ambrosio Scarpim Ribeiro</h3>
                        <p>Escritor e Pesquisador</p>
                    </div>
                </div>
                <div class="team-member">
                    <div class="team-img">
                        <img src="imagens/grupo/henrique.jpg" alt="CTO">
                    </div>
                    <div class="team-info">
                        <h3>Henrique Della Rovere Santos</h3>
                        <p>Programador e Escritor</p>
                    </div>
                </div>
                <div class="team-member">
                    <div class="team-img">
                        <img src="imagens/grupo/julia.jpg"  alt="Community Manager">
                    </div>
                    <div class="team-info">
                        <h3>Julia Avelino Serra Manelichi</h3>
                        <p>Escritora e Pesquisadora</p>
                        
                    </div>
                </div>
                <div class="team-member">
                    <div class="team-img">
                        <img src="imagens/grupo/lucas.jpg"  alt="CTO">
                    </div>
                    <div class="team-info">
                        <h3>Lucas Cardoso Claudino</h3>
                        <p>Programador e Escritor</p>
                    </div>
                </div>
                <div class="team-member">
                    <div class="team-img">
                        <img src="imagens/grupo/raul.jpg" alt="CTO">
                    </div>
                    <div class="team-info">
                        <h3>Raul Alves Bueno</h3>
                        <p>Escritor e Pesquisador</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>DataMind</h3>
                    <p>Sua plataforma de reviews comunitários de filmes, séries e livros.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Contato</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-envelope"></i> contato@datamind.com</li>
                        <li><i class="fas fa-phone"></i> (11) 9999-9999</li>
                        <li><i class="fas fa-map-marker-alt"></i> São Paulo, Brasil</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2023 DataMind - Todos os direitos reservados</p>
            </div>
        </div>
    </footer>
</body>
</html>