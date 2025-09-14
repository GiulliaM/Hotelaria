<?php
include '../sql/conexao.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    echo "Você precisa estar logado para editar seu cadastro.";
    exit();
}

$admin_id = $_SESSION['admin_id']; 

$conexao = new Conexao();
$conn = $conexao->conectar();


$sql = "SELECT nome, email, senha FROM Admin WHERE admin_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

if (!$admin) {
    echo "Administrador não encontrado.";
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['senha'];


    $update_sql = "UPDATE Admin SET nome = ?, email = ?, senha = ? WHERE admin_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssi", $nome, $email, $telefone, $admin_id);
    
    if ($update_stmt->execute()) {
        echo "Dados atualizados com sucesso!";
        header("Location: admin_home.php"); 
    } else {
        echo "Erro ao atualizar os dados.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cadastro do Administrador</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include 'navbar_admin.php'; ?>


        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <h2>Editar Cadastro</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $admin['nome']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $admin['email']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telefone">Senha</label>
                            <input type="text" class="form-control" id="senha" name="senha" value="<?php echo $admin['senha']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Atualizar Cadastro</button>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
