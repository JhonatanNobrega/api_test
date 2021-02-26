<?php

header("Access-Control-Allow-Origin: https://resttesttest.com");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-Type: application/json");

echo json_encode($array);
exit;