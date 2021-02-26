<?php
require('../config.php');

$method_type = strtolower( 'GET' );
$method = strtolower( $_SERVER['REQUEST_METHOD'] );

if( $method === $method_type ) {
    
    $id = filter_input( INPUT_GET, 'id' );

    if( $id ) {
        
        $sql = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $sql->bindValue(':id', intval($id) );
        $sql->execute();

        if( $sql->rowCount() > 0 ) {
            $item = $sql->fetch( PDO::FETCH_ASSOC );
            
            $array['result'] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'quantities' => $item['quantities']
            ];
        } else {
            $array['error'] = 'ID inexistente';
        }
    } else {
        $array['error'] = 'ID não enviado';
    }
    
} else {
    $array['error'] = 'Método não permitido (apenas '.strtoupper($method_type).')';
}

require('../return.php');