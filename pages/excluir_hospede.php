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

// Exclui os dados do hóspede
$sql_delete = "DELETE FROM Hospede WHERE hospede_id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $hospede_id);
$stmt_delete->execute();

// Finaliza a sessão e redireciona para a página de login
session_destroy();
header("Location: login.php");
exit();
?>

