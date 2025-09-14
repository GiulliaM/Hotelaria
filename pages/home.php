<?php


session_start(); 
if (!isset($_SESSION['hospede_id'])) {
    echo "Você precisa estar logado para fazer uma reserva!";
    exit();
}


$hospede_id = $_SESSION['hospede_id']; 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="..\css/css_home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>

<body>


    <?php include '..\includes\navbar.php'; ?>

<div class="intro-section" data-aos="fade-up">
    <img src="..\assets\logo1.png" alt="Logo Lotus Horizon" class="logo"> <!-- Substitua pelo caminho correto da sua logo -->
    <div class="intro-text">
        <h2>Bem-vindo ao Lotus Horizon</h2>
        <p>Experimente o melhor em hospitalidade, conforto e elegância. Nossa missão é proporcionar momentos inesquecíveis durante sua estadia.</p>
    </div>
</div>


    <div class="main-content" data-aos="fade-up">
        <div class="container">
            <div id="home" class="intro">
                <h1>Desfrute de uma experiência inesquecível</h1>
                <p>Com conforto e qualidade em cada detalhe.</p>
            </div>

            <div id="gallery" class="gallery">
                <img src="..\assets/academia.jpg" alt="academia">
                <img src="..\assets/piscina.jpg" alt="piscina">
                <img src="..\assets/paisagem7.jpg" alt="paisagem7">
                <img src="..\assets/paisagem3.jpg" alt="paisagem3">
                <img src="..\assets/paisagem6.jpg" alt="paisagem6">
            </div>

            <div id="rooms" class="rooms">
                <div class="card">
                    <img src="..\assets/quarto.jpg" alt="Quarto Simples">
                    <h3>Quarto Simples</h3>
                    <p>Acomodação ideal para uma pessoa, com TV, Wi-Fi e banheiro privativo.</p>
                    <p><strong>Preço: R$150/noite</strong></p>
                </div>
                <div class="card">
                    <img src="..\assets/quarto2.jpg" alt="Quarto Duplo">
                    <h3>Quarto Duplo</h3>
                    <p>Perfeito para dois hóspedes, com TV, Wi-Fi, frigobar e vista para o mar.</p>
                    <p><strong>Preço: R$250/noite</strong></p>
                </div>
                <div class="card">
                    <img src="..\assets/quarto3.jpg" alt="Suíte Luxo">
                    <h3>Suíte Luxo</h3>
                    <p>Quarto espaçoso com cama king size, banheira de hidromassagem e varanda.</p>
                    <p><strong>Preço: R$500/noite</strong></p>
                </div>
            </div>

            <div class="button-container">
                <a href="reserva.php">Faça sua Reserva</a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
        <?php include '..\includes/footer.php'; ?>
</body>
</html>
