<?php
require('../config.php');

$method_type = strtolower( 'DELETE' );
$method = strtolower( $_SERVER['REQUEST_METHOD'] );

if( $method === $method_type ) {
    
    parse_str(file_get_contents('php://input'), $input);

    $id = $input['id'] ?? null;
    $id = filter_var( $id );

    if( $id ) {
        
        $sql = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $sql->bindValue(':id', intval($id) );
        $sql->execute();

        if( $sql->rowCount() > 0 ) {
            
            $sql = $pdo->prepare( "DELETE FROM products WHERE id = :id" );
            $sql->bindValue('id', $id);
            $sql->execute();

        } else {
            $array['error'] = 'ID inexistente';
        }
    } else {
        $array['error'] = 'Deve-se enviar o campo :id';
    }
    
} else {
    $array['error'] = 'Método não permitido (apenas '.strtoupper($method_type).')';
}

require('../return.php');