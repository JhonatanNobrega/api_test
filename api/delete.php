<?php
// Conexão ao banco de dados e outras configurações
require('../config.php');

// Especificar o método que aceita essa pagina requisitada
$method_type = strtolower( 'DELETE' );

// Paga o método que foi requisitado
$method = strtolower( $_SERVER['REQUEST_METHOD'] );

// Verifica que o método enviado é o mesmo permitido
if( $method === $method_type ) {
    
    // Configuração para aceitar métodos como PUT/DELETE/OPTION que não são padrões como  GET/POST
    parse_str(file_get_contents('php://input'), $input);

    // Pega o id se foi enviado
    $id = $input['id'] ?? null;

    // Valida o id assim como o recebido direto do input, mas nesse caso é da variavel
    $id = filter_var( $id );

    // Vefica se o id é válido
    if( $id ) {
        
        // Consulta para saber se ID existe
        $sql = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $sql->bindValue(':id', intval($id) );
        $sql->execute();

        // Se existir vai fazer o processo para deletar
        if( $sql->rowCount() > 0 ) {
            
            // Processo para deletar
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

// Resposta da requisição, seja 'error' ou 'result'
require('../return.php');