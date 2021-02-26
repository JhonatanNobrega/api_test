<?php
require('../config.php');

$method_type = strtolower( 'GET' );
$method = strtolower( $_SERVER['REQUEST_METHOD'] );

if( $method === $method_type ) {
    
    $sql = $pdo->query("SELECT * FROM products");
    
    if( $sql->rowCount() > 0 ) {
        $data = $sql->fetchAll( PDO::FETCH_ASSOC );
        
        foreach( $data as $item ) {
            $array['result'][] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'quantities' => $item['quantities']
            ];
        }
    }

} else {
    $array['error'] = 'Método não permitido (apenas '.strtoupper($method_type).')';
}

require('../return.php');