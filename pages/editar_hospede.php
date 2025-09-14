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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novo_nome = $_POST['nome'];
    $novo_email = $_POST['email'];
    $novo_telefone = $_POST['telefone'];


    $sql_update = "UPDATE Hospede SET nome = ?, email = ?, telefone = ? WHERE hospede_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $novo_nome, $novo_email, $novo_telefone, $hospede_id);
    $stmt_update->execute();

    header("Location: visualizar_hospede.php");
    exit();
}


$conexao->fechar();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dados Pessoais - Lotus Horizon</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="hold-transition layout-top-nav">


<?php include '..\includes\navbar.php'; ?>

<div class="wrapper">

    <div class="content-wrapper">
        <div class="container-fluid">
            <h1 class="text-center">Editar Meus Dados Pessoais</h1>


            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Atualize suas informações</h3>
                </div>
                <form action="editar_hospede.php" method="POST">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo $telefone; ?>" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Salvar alterações</button>
                        <a href="visualizar_hospede.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
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
