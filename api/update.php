<?php
require('../config.php');

$method_type = strtolower( 'PUT' );
$method = strtolower( $_SERVER['REQUEST_METHOD'] );

if( $method === $method_type ) {
    
    parse_str(file_get_contents('php://input'), $input);

    // PHP MENOR QUE 7.4
    //$id = (!empty($input['id'])) ? $input['id'] : null;

    // PHP 7.4+
    $id = $input['id'] ?? null;
    $name = $input['name'] ?? null;
    $price = $input['price'] ?? null;
    $quantities = $input['quantities'] ?? null;

    $id = filter_var( $id );
    $name = filter_var( $name );
    $price = filter_var( $price );
    $quantities = filter_var( $quantities );

    if( $id && $name && $price && $quantities) {
        
        $sql = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $sql->bindValue(':id', intval($id) );
        $sql->execute();

        if( $sql->rowCount() > 0 ) {
            
            $sql = $pdo->prepare( "UPDATE products SET name = :name, price = :price, quantities = :quantities WHERE id = :id" );
            $sql->bindValue('id', $id);
            $sql->bindValue(':name', $name);
            $sql->bindValue(':price', $price);
            $sql->bindValue(':quantities', $quantities);
            $sql->execute();

            $array['result'] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantities' => $quantities
            ];

        } else {
            $array['error'] = 'ID inexistente';
        }
    } else {
        $array['error'] = 'Deve-se enviar os campos :id :name :price :quantities';
    }
    
} else {
    $array['error'] = 'Método não permitido (apenas '.strtoupper($method_type).')';
}

require('../return.php');