<?php
session_start(); // Iniciar a sessão

// Verifica se o usuário está logado e se é um admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php"); // Redireciona para o login se não estiver logado
    exit();
}

include '../sql/conexao.php';

// Cria a conexão com o banco de dados
$conexao = new Conexao();
$conn = $conexao->conectar();

// Total de reservas
$sql_reservas = "SELECT COUNT(*) FROM Reserva";
$result_reservas = $conn->query($sql_reservas);
$total_reservas = $result_reservas->fetch_row()[0];

// Total de usuários
$sql_usuarios = "SELECT COUNT(*) FROM Hospede";
$result_usuarios = $conn->query($sql_usuarios);
$total_usuarios = $result_usuarios->fetch_row()[0];

// Listar reservas
$sql_lista_reservas = "SELECT r.reserva_id, h.nome AS hospede, q.numero AS quarto, r.data_checkin, r.data_checkout 
                        FROM Reserva r 
                        JOIN Hospede h ON r.hospede_id = h.hospede_id
                        JOIN Quarto q ON r.quarto_id = q.quarto_id";
$result_reservas_lista = $conn->query($sql_lista_reservas);

// Listar usuários
$sql_lista_usuarios = "SELECT hospede_id, nome, email, telefone FROM Hospede";
$result_usuarios_lista = $conn->query($sql_lista_usuarios);

// Fecha a conexão
$conexao->fechar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração - Lotus Horizon</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar_admin.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Total de Reservas -->
            <div class="col-lg-6 col-12">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php echo $total_reservas; ?></h3>
                        <p>Total de Reservas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <a href="reservas_admin.php" class="small-box-footer">Ver todas as reservas <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            
            <!-- Total de Usuários -->
            <div class="col-lg-6 col-12">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?php echo $total_usuarios; ?></h3>
                        <p>Total de Usuários</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="usuarios_admin.php" class="small-box-footer">Ver todos os usuários <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

       


    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>
