<?php
require('../config.php');

$method_type = strtolower( 'POST' );
$method = strtolower( $_SERVER['REQUEST_METHOD'] );

if( $method === $method_type ) {
    
    $name = filter_input( INPUT_POST, 'name' );
    $price = filter_input( INPUT_POST, 'price' );
    $quantities = filter_input( INPUT_POST, 'quantities' );

    if( $name && $price && $quantities ) {

        $sql = $pdo->prepare("INSERT INTO products (name, price, quantities) VALUES (:name, :price, :quantities)");
        $sql->bindValue(':name', $name);
        $sql->bindValue(':price', $price);
        $sql->bindValue(':quantities', $quantities);
        $sql->execute();

        $id = $pdo->lastInsertId();

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

require('../return.php');