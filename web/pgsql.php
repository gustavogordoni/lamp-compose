<?php

include 'config/con-pgsql.php';
include 'config/fn.php';

$timezones = array(
    'SP' => 'America/Sao_Paulo',
    'BA' => 'America/Bahia'
);

date_default_timezone_set($timezones['SP']);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docker PHP + Apache + MySQL + PostgreSQL</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="buttons-container">
        <a href="index.php"><button>PHP Info</button></a>
        <a href="./mysql.php"><button>PDO MySQL</button></a>
    </div>

    <section>
        <div onclick="handleGoToMysql()" class="pgsql-bg">
            <h1>PostgreSQL - <?= date('d/m/Y H:i:s') ?></h1>
            <div class="success-banner">
                <span class="checkmark">&#10003;</span>
                <span>Conexão estabelecida com sucesso!</span>
            </div>
            <span><?= getPgSQLInfo() ?></span>
        </div>
    </section>

    <script>
        const handleGoToMysql = () => {
            window.location.href = 'mysql.php'
        }
    </script>

</body>

</html>
