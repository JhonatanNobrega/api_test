<?php 

// Controle de acesso. Neste caso * é todos.
header("Access-Control-Allow-Origin: *");

// Tipos de requisições aceitas
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Resposta da requisição será do tipo json
header("Content-Type: application/json");

try {
    // Definindo conexão ao banco de dados MySQL
    $db_host = 'localhost';
    $db_name = 'api_test';
    $db_user = 'root';
    $db_pass = '';

    // Criação da classe do PDO para consultas
    $pdo = new PDO("mysql:dbname=".$db_name.";host=".$db_host, $db_user, $db_pass);
} catch ( PDOException $e ) {
    // Exibir mensagem relacionada a erro ao conectar ao banco
    die($e->getMessage());
}

    // Definindo array padrão de reposta
    $array = [
        'error' => '',
        'result' => []
    ];