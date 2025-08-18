<?php

$server = 'birazn-ifsp-pgsql';
#$server = 'localhost';
#$server = 'postgres';
$db = 'postgres';
$user = 'postgres';
$pass = 'postdba';

if (file_exists(__DIR__ . '/../.env')) {
    $env = parse_ini_file(__DIR__ . '/../.env', false, INI_SCANNER_RAW);
    $server = $env['POSTGRES_CONTAINER_NAME'] ?? $server;
    $db     = $env['POSTGRES_DB'] ?? $db;
    $user   = $env['POSTGRES_USER'] ?? $user;
    $pass   = $env['POSTGRES_PASSWORD'] ?? $pass;
}

try {
    $pdo = new PDO("pgsql:host=$server;dbname=$db;", $user, $pass);
} catch (PDOException $err) {
    $msg = $err->getMessage();
    echo "Erro ao conectar no banco de dados: $msg";
}
