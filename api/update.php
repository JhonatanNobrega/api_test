<?php
// Conexão ao banco de dados e outras configurações
require('../config.php');

// Especificar o método que aceita essa pagina requisitada
$method_type = strtolower( 'PUT' );

// Paga o método que foi requisitado
$method = strtolower( $_SERVER['REQUEST_METHOD'] );

// Verifica que o método enviado é o mesmo permitido
if( $method === $method_type ) {
    
    // Configuração para aceitar métodos como PUT/DELETE/OPTION que não são padrões como  GET/POST
    parse_str(file_get_contents('php://input'), $input);

    // PHP MENOR QUE 7.4
    //$id = (!empty($input['id'])) ? $input['id'] : null;

    // PHP 7.4+
    // Pegando valores da requisição
    $id = $input['id'] ?? null;
    $name = $input['name'] ?? null;
    $price = $input['price'] ?? null;
    $quantities = $input['quantities'] ?? null;

    // Fazendo o filtro basico. Nesse caso da variavel.
    $id = filter_var( $id );
    $name = filter_var( $name );
    $price = filter_var( $price );
    $quantities = filter_var( $quantities );

    // Verifica se foi recebido todos os dados necessarios
    if( $id && $name && $price && $quantities) {
        
        // Consulta o produto pelo id
        $sql = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $sql->bindValue(':id', intval($id) );
        $sql->execute();

        // Verifica existe esse produto a ser editado
        if( $sql->rowCount() > 0 ) {
            
            // Editando produto
            $sql = $pdo->prepare( "UPDATE products SET name = :name, price = :price, quantities = :quantities WHERE id = :id" );
            $sql->bindValue('id', $id);
            $sql->bindValue(':name', $name);
            $sql->bindValue(':price', $price);
            $sql->bindValue(':quantities', $quantities);
            $sql->execute();

            // Preparando array de resposta
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

// Resposta da requisição, seja 'error' ou 'result'
require('../return.php');