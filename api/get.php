<?php
// Conexão ao banco de dados e outras configurações
require('../config.php');

// Especificar o método que aceita essa pagina requisitada
$method_type = strtolower( 'GET' );

// Paga o método que foi requisitado
$method = strtolower( $_SERVER['REQUEST_METHOD'] );

// Verifica que o método enviado é o mesmo permitido
if( $method === $method_type ) {
    
    // Pega e valida o valor de ID se enviado
    $id = filter_input( INPUT_GET, 'id' );

    // Se tiver tudo certo com id prossegue
    if( $id ) {
        
        // Consulta o produto pelo ID
        $sql = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $sql->bindValue(':id', intval($id) );
        $sql->execute();

        // Verifica se achou
        if( $sql->rowCount() > 0 ) {

            // Faz o fetch com uso do 'ASSOC' para fazer a associação e evitar dados duplicado nos valores
            $item = $sql->fetch( PDO::FETCH_ASSOC );
            
            // Preenche o array de 'result'
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

// Resposta da requisição, seja 'error' ou 'result'
require('../return.php');