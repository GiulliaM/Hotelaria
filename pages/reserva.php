<?php
session_start();
include '../sql/conexao.php';

// Verifica se o hóspede está logado
if (!isset($_SESSION['hospede_id'])) {
    header("Location: login.php");  
    exit();
}

$hospede_id = $_SESSION['hospede_id'];
$conexao = new Conexao();
$conn = $conexao->conectar();


$sql = "SELECT r.reserva_id, r.quarto_id, r.data_checkin, r.data_checkout, q.tipo AS nome_quarto 
        FROM Reserva r 
        JOIN Quarto q ON r.quarto_id = q.quarto_id
        WHERE r.hospede_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hospede_id);
$stmt->execute();
$result = $stmt->get_result();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quarto_id = $_POST['quarto_id'];
    $data_checkin = $_POST['data_checkin'];
    $data_checkout = $_POST['data_checkout'];


    if (isset($_POST['reserva_id'])) {

        $sql_reserva = "UPDATE Reserva SET quarto_id = ?, data_checkin = ?, data_checkout = ? WHERE reserva_id = ?";
        $stmt_reserva = $conn->prepare($sql_reserva);
        $stmt_reserva->bind_param("issi", $quarto_id, $data_checkin, $data_checkout, $_POST['reserva_id']);

        if ($stmt_reserva->execute()) {
            echo "<script>alert('Reserva atualizada com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao atualizar reserva. Tente novamente.');</script>";
        }
    } else {

        $sql_reserva = "INSERT INTO Reserva (hospede_id, quarto_id, data_checkin, data_checkout) VALUES (?, ?, ?, ?)";
        $stmt_reserva = $conn->prepare($sql_reserva);
        $stmt_reserva->bind_param("iiss", $hospede_id, $quarto_id, $data_checkin, $data_checkout);

        if ($stmt_reserva->execute()) {
            echo "<script>alert('Reserva realizada com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao realizar reserva. Tente novamente.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Reservas - Lotus Horizon</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body class="hold-transition layout-top-nav">


<?php include '..\includes\navbar.php'; ?>

<div class="wrapper">

    <div class="content-wrapper">
        <div class="container-fluid">
            <h1 class="text-center">Minhas Reservas</h1>


            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><?php echo isset($_GET['id']) ? 'Editar Reserva' : 'Cadastrar Nova Reserva'; ?></h3>
                </div>
                <div class="card-body">
                    <?php

                    if (isset($_GET['id'])) {
                        $reserva_id = $_GET['id'];
                        $sql_reserva = "SELECT * FROM Reserva WHERE reserva_id = ?";
                        $stmt_reserva = $conn->prepare($sql_reserva);
                        $stmt_reserva->bind_param("i", $reserva_id);
                        $stmt_reserva->execute();
                        $reserva_result = $stmt_reserva->get_result();
                        $reserva = $reserva_result->fetch_assoc();
                    }
                    ?>

                    <form action="" method="POST">
                        <?php if (isset($reserva)) { ?>
                            <input type="hidden" name="reserva_id" value="<?php echo $reserva['reserva_id']; ?>">
                        <?php } ?>

                        <div class="form-group">
                            <label for="quarto_id">Escolha o Quarto</label>
                            <select name="quarto_id" id="quarto_id" class="form-control">
                            <option >Selecione o tipo de quarto</option>
                                <option value="1" <?php echo (isset($reserva) && $reserva['quarto_id'] == 1) ? 'selected' : ''; ?>>Quarto Simples</option>
                                <option value="2" <?php echo (isset($reserva) && $reserva['quarto_id'] == 2) ? 'selected' : ''; ?>>Quarto Duplo</option>
                                <option value="3" <?php echo (isset($reserva) && $reserva['quarto_id'] == 3) ? 'selected' : ''; ?>>Suíte Luxo</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="data_checkin">Data de Check-in</label>
                            <input type="date" name="data_checkin" id="data_checkin" class="form-control" value="<?php echo isset($reserva) ? $reserva['data_checkin'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="data_checkout">Data de Check-out</label>
                            <input type="date" name="data_checkout" id="data_checkout" class="form-control" value="<?php echo isset($reserva) ? $reserva['data_checkout'] : ''; ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
                    </form>
                </div>
            </div>


            <h3>Suas Reservas Atuais</h3>
            <?php if ($result->num_rows > 0) { ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID da Reserva</th>
                            <th>Quarto</th>
                            <th>Data Check-in</th>
                            <th>Data Check-out</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($reserva = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $reserva['reserva_id']; ?></td>
                                <td><?php echo $reserva['nome_quarto']; ?></td>
                                <td><?php echo $reserva['data_checkin']; ?></td>
                                <td><?php echo $reserva['data_checkout']; ?></td>
                                <td>
                                    <a href="?id=<?php echo $reserva['reserva_id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <a href="../sql/reserva.php?excluir=true&id=<?php echo $reserva['reserva_id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta reserva?')" class="btn btn-danger btn-sm">Excluir</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>Você ainda não tem reservas.</p>
            <?php } ?>
        </div>
    </div>
</div>


<?php include '..\includes\footer.php'; ?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>

<?php
$conexao->fechar();
?>
