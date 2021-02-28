<?php
// Conexão ao banco de dados e outras configurações
require('../config.php');

// Especificar o método que aceita essa pagina requisitada
$method_type = strtolower( 'GET' );

// Paga o método que foi requisitado
$method = strtolower( $_SERVER['REQUEST_METHOD'] );

// Verifica que o método enviado é o mesmo permitido
if( $method === $method_type ) {
    
    // Pega todos os produtos
    $sql = $pdo->query("SELECT * FROM products");
    
    // Verifica se tem resultado
    if( $sql->rowCount() > 0 ) {

        // Faz o fetch com uso do 'ASSOC' para fazer a associação e evitar dados duplicado nos valores
        // Nesse caso usamos ALL porque o resultado pode ser mais que 1.
        $data = $sql->fetchAll( PDO::FETCH_ASSOC );
        
        // Loop para preencher 'result' do array de resposta
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

// Resposta da requisição, seja 'error' ou 'result'
require('../return.php');