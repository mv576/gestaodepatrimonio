<?php
// Exibir todos os erros (para desenvolvimento)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configura o cabeçalho para sempre retornar JSON
header('Content-Type: application/json');

// Configurações de conexão ao banco de dados
$servername = "localhost";
$username = "root"; // Usuário padrão do MySQL
$password = ""; // Senha padrão do MySQL (em branco no XAMPP)
$dbname = "banco_patrimonio"; // Substitua pelo nome do seu banco de dados

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    echo json_encode(["error" => "Falha na conexão: " . $conn->connect_error]);
    exit();
}

// Verificar se a chave "chapa" foi enviada na URL
if (isset($_GET['chapa'])) {
    $chapa = $conn->real_escape_string($_GET['chapa']); // Proteção contra injeção de SQL

    // Prepara e executa a consulta SQL
    $sql = "SELECT * FROM bd WHERE chapa = '$chapa'";

    $result = $conn->query($sql);

    // Verifica se houve resultados
    if ($result === false) {
        // Log de erro no SQL
        echo json_encode(["error" => "Erro no SQL: " . $conn->error]);
        exit();
    }

    if ($result->num_rows > 0) {
        // Retorna os dados em formato JSON
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Chapa não encontrada"]);
    }
} else {
    echo json_encode(["error" => "Nenhuma chapa fornecida"]);
}

// Fecha a conexão
$conn->close();
?>
