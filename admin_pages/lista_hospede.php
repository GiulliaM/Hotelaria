<?php


class Conexao {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "hotel"; 

    public function conectar() {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        return $conn;
    }
}


class Hospede {
    private $id;
    private $nome;
    private $email;
    private $telefone;

    public function __construct($id, $nome, $email, $telefone) {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->telefone = $telefone;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelefone() {
        return $this->telefone;
    }
}


class HospedeRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function listarHospedes() {
        $sql = "SELECT hospede_id, nome, email, telefone FROM Hospede";
        $result = $this->conn->query($sql);

        $hospedes = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $hospedes[] = new Hospede($row['hospede_id'], $row['nome'], $row['email'], $row['telefone']);
            }
        }

        return $hospedes;
    }
}


class PaginaHospede {
    private $hospedes;

    public function __construct($hospedes) {
        $this->hospedes = $hospedes;
    }

    public function gerarPagina() {
        echo "<!DOCTYPE html>
        <html lang='pt-BR'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Lista de Hospedes</title>
            <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css'>
        </head>
        <body class='hold-transition sidebar-mini layout-fixed'>
            <div class='wrapper'>
                ";
        
        include 'navbar_admin.php'; 
        
        echo "<div class='content-wrapper'>
                <section class='content'>
                    <div class='container-fluid'>
                        <h2>Lista de Hospedes</h2>
                        <table class='table table-bordered table-striped'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                </tr>
                            </thead>
                            <tbody>";
        
        if (count($this->hospedes) > 0) {
            foreach ($this->hospedes as $hospede) {
                echo "<tr>
                        <td>" . $hospede->getId() . "</td>
                        <td>" . $hospede->getNome() . "</td>
                        <td>" . $hospede->getEmail() . "</td>
                        <td>" . $hospede->getTelefone() . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='text-center'>Nenhum hospede encontrado.</td></tr>";
        }

        echo "          </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js'></script>
    </body>
    </html>";
    }
}


$conexao = new Conexao();
$conn = $conexao->conectar();


$hospedeRepo = new HospedeRepository($conn);
$hospedes = $hospedeRepo->listarHospedes();


$pagina = new PaginaHospede($hospedes);
$pagina->gerarPagina();

?>
