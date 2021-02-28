<?php
// Conexão ao banco de dados e outras configurações
require('../config.php');

// Preenche array 'result' / exemplo basico
$array['result'] = [
    'pong' => true
];

// Resposta da requisição, seja 'error' ou 'result'
require('../return.php');