<?php
function db_connect()
{
    try {
        $dbhost = 'localhost'; // Alterado para localhost
        $dbname = 'u821650166_AreaMembros'; // Nome do banco
        $charset = 'utf8mb4'; // Conjunto de caracteres
        $username = 'u821650166_Henrique'; // Usuário do banco
        $password = 'Membros**251251'; // Senha do banco

        // Configura a string de conexão DSN
        $dsn = "mysql:host={$dbhost};dbname={$dbname};charset={$charset}";

        // Cria a conexão PDO
        $pdo = new PDO($dsn, $username, $password);

        // Configura o modo de erro para exceções
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;

    } catch (PDOException $e) {
        // Exibe mensagem de erro em caso de falha na conexão
        die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
    }
}
?>

?>