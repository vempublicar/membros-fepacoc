<?php
// Configurações do banco de dados MySQL
define('DB_HOST', 'localhost'); // Endereço do servidor MySQL
define('DB_NAME', 'u821650166_members'); // Nome do banco de dados
define('DB_USER', 'u821650166_Members'); // Usuário do banco de dados
define('DB_PASS', 'Members**251251'); // Senha do banco de dados

class MySQLClient {
    private $pdo;

    public function __construct() {
        try {
            // Cria a conexão PDO com o MySQL
            $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    }

    /**
     * Lista todos os itens de uma tabela.
     *
     * @param string $tableName Nome da tabela.
     * @return array Resultados da consulta.
     */
    public function listItemsFromTable($tableName) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die("Erro ao listar itens da tabela: " . $e->getMessage());
        }
    }

    /**
     * Obtém um item da tabela pelo ID do usuário.
     *
     * @param string $tableName Nome da tabela.
     * @param int $userId ID do usuário.
     * @return array|null Resultado da consulta ou null se não encontrar.
     */
    public function getItemByUserId($tableName, $userId) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            die("Erro ao buscar item pelo user_id: " . $e->getMessage());
        }
    }

    // Outros métodos da classe, se houver
}

?>