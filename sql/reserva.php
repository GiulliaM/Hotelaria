<?php
include 'conexao.php';

if (isset($_GET['excluir']) && isset($_GET['id'])) {
    $reserva_id = $_GET['id'];

    // Cria a conexão com o banco de dados
    $conexao = new Conexao();
    $conn = $conexao->conectar();

    // Exclui a reserva
    $sql_delete = "DELETE FROM Reserva WHERE reserva_id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $reserva_id);

    if ($stmt->execute()) {
        echo "<script>alert('Reserva excluída com sucesso!');</script>";
        echo "<script>window.location.href = '../pages/reserva.php';</script>";  // Redireciona de volta para a página de reservas
    } else {
        echo "<script>alert('Erro ao excluir a reserva.');</script>";
        echo "<script>window.location.href = '../pages/reserva.php';</script>";
    }

    $conexao->fechar();
}
?>
