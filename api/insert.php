<?php
// Conexão ao banco de dados e outras configurações
require('../config.php');

// Especificar o método que aceita essa pagina requisitada
$method_type = strtolower( 'POST' );

// Paga o método que foi requisitado
$method = strtolower( $_SERVER['REQUEST_METHOD'] );

// Verifica que o método enviado é o mesmo permitido
if( $method === $method_type ) {
    
    // Pegando os valores preciso para inserção
    $name = filter_input( INPUT_POST, 'name' );
    $price = filter_input( INPUT_POST, 'price' );
    $quantities = filter_input( INPUT_POST, 'quantities' );

    // Verifica se recebeu todos os items necessario
    if( $name && $price && $quantities ) {

        // Cria o novo produto no banco de dados
        $sql = $pdo->prepare("INSERT INTO products (name, price, quantities) VALUES (:name, :price, :quantities)");
        $sql->bindValue(':name', $name);
        $sql->bindValue(':price', $price);
        $sql->bindValue(':quantities', $quantities);
        $sql->execute();

        // Pega o ultimo ID inserido
        $id = $pdo->lastInsertId();

        // Preenche o arrar 'result' com os dados recebido e id inserido
        $array['result'] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'quantities' => $quantities
        ];

    } else {
        $array['error'] = 'Deve-se enviar os campos :name :price :quantities';
    }

} else {
    $array['error'] = 'Método não permitido (apenas '.strtoupper($method_type).')';
}

// Resposta da requisição, seja 'error' ou 'result'
require('../return.php');