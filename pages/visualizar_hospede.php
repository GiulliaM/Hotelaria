<?php
session_start();
include '../sql/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['hospede_id'])) {
    header("Location: login.php"); 
    exit();
}

$hospede_id = $_SESSION['hospede_id'];


$conexao = new Conexao();
$conn = $conexao->conectar();


$sql = "SELECT nome, email, telefone FROM Hospede WHERE hospede_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hospede_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($nome, $email, $telefone);
$stmt->fetch();


$conexao->fechar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados Pessoais - Lotus Horizon</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="hold-transition layout-top-nav">


<?php include '..\includes\navbar.php'; ?>

<div class="wrapper">

    <div class="content-wrapper">
        <div class="container-fluid">
            <h1 class="text-center">Meus Dados Pessoais</h1>


            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?php echo $nome; ?> - Perfil</h3>
                </div>
                <div class="card-body">
                    <p><strong>Nome:</strong> <?php echo $nome; ?></p>
                    <p><strong>Email:</strong> <?php echo $email; ?></p>
                    <p><strong>Telefone:</strong> <?php echo $telefone; ?></p>


                    <a href="editar_hospede.php" class="btn btn-primary">Editar</a>
                    <a href="excluir_hospede.php" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir sua conta?')">Excluir Conta</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include '..\includes\footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
