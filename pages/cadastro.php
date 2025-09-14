<?php

$host = 'localhost'; 
$dbname = 'Hotel'; 
$username = 'root'; 
$password = ''; 


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    echo "Conexão falhou: " . $e->getMessage();
    exit;
}

$erro = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];


    if (empty($nome) || empty($email) || empty($telefone) || empty($senha)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "O e-mail informado não é válido.";
    } elseif (!preg_match("/^\d{10,11}$/", $telefone)) {
        $erro = "O telefone deve conter entre 10 a 11 dígitos.";
    } else {

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);


        $sql = "INSERT INTO Hospede (nome, email, telefone, senha) VALUES (:nome, :email, :telefone, :senha)";
        $stmt = $conn->prepare($sql);


        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':senha', $senha_hash); 

        try {
            $stmt->execute();
            echo "<script>alert('Cadastro realizado com sucesso!');</script>";
            header('Location: login.php'); 
            exit();
        } catch (PDOException $e) {
            $erro = "Erro ao realizar o cadastro: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Lotus Horizon</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body class="hold-transition register-page">
    <div class="wrapper">
        <div class="register-box">
            <div class="register-logo">
                <a href="#"><b>Lotus Horizon</b></a>
            </div>

            <div class="card">
                <div class="card-body register-card-body">
                    <h4 class="login-box-msg">Cadastre-se</h4>


                    <?php if (!empty($erro)): ?>
                        <div class="alert alert-danger"><?php echo $erro; ?></div>
                    <?php endif; ?>

                    <form action="cadastro.php" method="POST">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="nome" placeholder="Nome Completo" value="<?php echo isset($nome) ? $nome : ''; ?>" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name="email" placeholder="E-mail" value="<?php echo isset($email) ? $email : ''; ?>" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="telefone" placeholder="Telefone" value="<?php echo isset($telefone) ? $telefone : ''; ?>" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="senha" placeholder="Senha" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                            </div>
                        </div>
                    </form>

                    <p class="mt-3 text-center">
                        <a href="login.php">Já tem uma conta? Faça login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
