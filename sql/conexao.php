<?php
class Conexao {
    private $host = 'localhost';      // Host do banco de dados
    private $usuario = 'root';        // Usuário do banco de dados
    private $senha = '';              // Senha do banco de dados
    private $dbname = 'Hotel';        // Nome do banco de dados
    private $conn;                    // Instância da conexão

    public function __construct() {
        $this->conn = null;  // Inicia a conexão como null
    }

    // Método para realizar a conexão com o banco de dados
    public function conectar() {
        try {
            $this->conn = new mysqli($this->host, $this->usuario, $this->senha, $this->dbname);
            // Verifica se a conexão falhou
            if ($this->conn->connect_error) {
                throw new Exception("Falha na conexão: " . $this->conn->connect_error);
            }
            return $this->conn;  // Retorna a instância da conexão
        } catch (Exception $e) {
            echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
            exit();  // Encerra o script caso não consiga conectar ao banco
        }
    }

    // Método para fechar a conexão
    public function fechar() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
