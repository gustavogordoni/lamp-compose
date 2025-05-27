<?php

function listarUsuariosMysql()
{
    include 'con-mysql.php';
    $sql = 'SELECT * FROM aluno';
    $query = $pdo->prepare($sql);
    $query->execute();
    $rowCount = $query->rowCount();
    echo "<h1>$rowCount Alunos cadastrados</h1>";
    foreach ($query as $row) {
        $id = $row['id_Aluno'];
        $nome = $row['nomeAluno'];
        $email = $row['emailAluno'];
        echo "<p>$id - $nome - $email</p>";
    }
}

function listarUsuariosPgsql()
{
    include 'con-pgsql.php';
    $sql = 'SELECT * FROM aluno';
    $query = $pdo->prepare($sql);
    $query->execute();
    $rowCount = $query->rowCount();
    echo "<h1>$rowCount Alunos cadastrados</h1>";
    foreach ($query as $row) {
        $id = $row['id_aluno'];
        $nome = $row['nomealuno'];
        $email = $row['emailaluno'];
        echo "<p>$id - $nome - $email</p>";
    }
}
