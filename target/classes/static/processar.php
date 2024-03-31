<?php

// Definições de conexão (replace with your actual credentials)
$host = "localhost";
$database = "mydb";
$username = "root";
$password = "";

// Estabelecer a conexão
try {
    $mysqli = new mysqli($host, $username, $password, $database);
} catch (mysqli_sql_exception $e) {
    echo "Erro ao conectar à base de dados: " . $e->getMessage();
    exit;
}

// Função para obter dados do formulário com validação básica
function getValidatedFormData() {
    $data = [
        'despacho' => filter_input(INPUT_POST, 'despacho', FILTER_SANITIZE_STRING),
        'situacao' => filter_input(INPUT_POST, 'situacao', FILTER_SANITIZE_STRING),
        // ... (add validation and filtering for other fields) ...
    ];

    // Basic validation example (replace with more robust checks)
    if (empty($data['despacho']) || empty($data['situacao'])) {
        throw new Exception("Campos 'Despacho' e 'Situacao' são obrigatórios.");
    }

    return $data;
}

try {
    // Obter dados do formulário validados
    $data = getValidatedFormData();

    // Preparar a consulta SQL (consider using prepared statements for security)
    $sql = "INSERT INTO requests (despacho, situacao, nome, codigo, curso, ano, contacto, email, pedido, justificativa, data)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);

    // Vincular os valores aos parâmetros da consulta
    $stmt->bind_param("sssssssssssss", $data['despacho'], $data['situacao'], $_POST['nome'], $_POST['codigo'], $_POST['curso'],
                        $_POST['ano'], $_POST['contacto'], $_POST['email'], $_POST['pedido'], $_POST['justificativa'], $_POST['data']);

    // Executar a consulta
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        echo "<p>Requerimento enviado com sucesso!</p>";
    } else {
        echo "<p>Erro ao enviar o requerimento: " . $stmt->error . "</p>";
    }

    // Fechar a conexão (consider using a finally block for guaranteed execution)
    $stmt->close();
    $mysqli->close();
} catch (Exception $e) {
    echo "<p>Erro: " . $e->getMessage() . "</p>";
}

?>
