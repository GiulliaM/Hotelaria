<?php
session_start();
include '../sql/conexao.php'; 

if (isset($_SESSION['admin_id'])) {
    header('Location: admin_home.php'); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];


    $conexao = new Conexao();
    $conn = $conexao->conectar();


    $sql = "SELECT admin_id, nome, senha FROM Admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($admin_id, $nome, $senha_bd);
    $stmt->fetch();


    if ($stmt->num_rows > 0 && password_verify($senha, $senha_bd)) {

        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['admin_nome'] = $nome;

        header('Location: admin_home.php'); 
        exit();
    } else {
        $erro = "Email ou senha incorretos!";
    }


    $conexao->fechar();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Login</b> Administrador</a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Entre para acessar o painel administrativo</p>

                <?php if (isset($erro)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $erro; ?>
                    </div>
                <?php } ?>


                <form action="login_admin.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                </form>


                <p class="mt-2">
                    <a href="cadastro_admin.php" class="text-center">Ainda não tem uma conta? Cadastre-se</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
