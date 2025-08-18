<?php

$server = 'birazn-ifsp-mysql'; // Se colocar localhost não irá conectar, pois o container está com o nome mrb-mysql
$user = 'root';
$pass = 'root';
$db = 'teste'; // Mude para o nome do seu banco

if (file_exists(__DIR__ . '/../.env')) {
    $env = parse_ini_file(__DIR__ . '/../.env', false, INI_SCANNER_RAW);
    $server = $env['MYSQL_CONTAINER_NAME'] ?? $server;
    $user   = 'root';
    $pass   = $env['MYSQL_ROOT_PASSWORD'] ?? $pass;
    $db     = $env['MYSQL_DATABASE'] ?? $db;
}

try {
    $pdo = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $err) {
    $msg = $err->getMessage();
    echo "Erro ao conectar no banco de dados: $msg";
}
