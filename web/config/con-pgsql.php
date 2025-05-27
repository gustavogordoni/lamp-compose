<?php

$server = 'birazn-ifsp-pgsql';
#$server = 'localhost';
#$server = 'postgres';
$db = 'postgres';
$user = 'postgres';
$pass = 'postdba';

try {
    $pdo = new PDO("pgsql:host=$server;dbname=$db;", $user, $pass);
} catch (PDOException $err) {
    $msg = $err->getMessage();
    echo "Erro ao conectar no banco de dados: $msg";
}
