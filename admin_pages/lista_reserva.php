<?php

include '../sql/conexao.php'; 


$conexao = new Conexao();
$conn = $conexao->conectar();


$sql = "SELECT r.reserva_id, h.nome AS hospede_nome, q.quarto_id, q.tipo AS quarto_tipo, r.data_checkin, r.data_checkout
        FROM Reserva r
        JOIN Hospede h ON r.hospede_id = h.hospede_id
        JOIN Quarto q ON r.quarto_id = q.quarto_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reservas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include 'navbar_admin.php'; ?>


        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <h2>Lista de Reservas</h2>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID da Reserva</th>
                                <th>Hóspede</th>
                                <th>ID do Quarto</th>
                                <th>Tipo de Quarto</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['reserva_id'] . "</td>";
                                    echo "<td>" . $row['hospede_nome'] . "</td>";
                                    echo "<td>" . $row['quarto_id'] . "</td>";  
                                    echo "<td>" . $row['quarto_tipo'] . "</td>"; 
                                    echo "<td>" . $row['data_checkin'] . "</td>";
                                    echo "<td>" . $row['data_checkout'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>Nenhuma reserva encontrada.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
