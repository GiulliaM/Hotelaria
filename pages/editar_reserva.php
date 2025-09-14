<?php
session_start();
include '../sql/conexao.php';

// Verifica se o hóspede está logado
if (!isset($_SESSION['hospede_id'])) {
    header("Location: login.php");  
    exit();
}

if (isset($_GET['id'])) {
    $reserva_id = $_GET['id'];
    
    $conexao = new Conexao();
    $conn = $conexao->conectar();


    $sql = "SELECT * FROM Reserva WHERE reserva_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reserva_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reserva = $result->fetch_assoc();

    if (!$reserva) {
        echo "Reserva não encontrada.";
        exit();
    }
} else {
    echo "ID da reserva não fornecido.";
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_checkin = $_POST['data_checkin'];
    $data_checkout = $_POST['data_checkout'];

    $sql_update = "UPDATE Reserva SET data_checkin = ?, data_checkout = ? WHERE reserva_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssi", $data_checkin, $data_checkout, $reserva_id);
    
    if ($stmt_update->execute()) {
        echo "<script>alert('Reserva atualizada com sucesso!');</script>";
        echo "<script>window.location.href = 'reserva.php';</script>";  
    } else {
        echo "Erro ao atualizar a reserva.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva - Lotus Horizon</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1>Editar Reserva</h1>

<form action="editar_reserva.php?id=<?php echo $reserva['reserva_id']; ?>" method="POST">
    <label for="data_checkin">Data de Check-in:</label>
    <input type="date" id="data_checkin" name="data_checkin" value="<?php echo $reserva['data_checkin']; ?>" required>
    
    <label for="data_checkout">Data de Check-out:</label>
    <input type="date" id="data_checkout" name="data_checkout" value="<?php echo $reserva['data_checkout']; ?>" required>
    
    <button type="submit">Salvar Alterações</button>
</form>

</body>
</html>

<?php
$conexao->fechar();
?>
