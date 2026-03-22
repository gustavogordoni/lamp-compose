<?php

function getMySQLInfo()
{
    include 'con-mysql.php';
    
    $version = $pdo->query("SELECT VERSION()")->fetchColumn();
    $databases = $pdo->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);
    $uptime = $pdo->query("SHOW STATUS LIKE 'Uptime'")->fetch(PDO::FETCH_ASSOC);
    $connections = $pdo->query("SHOW STATUS LIKE 'Threads_connected'")->fetch(PDO::FETCH_ASSOC);
    
    $output = '<div class="db-info mysql-info">';
    $output .= '<div class="info-card"><span class="label">Versão MySQL</span><span class="value">' . htmlspecialchars($version) . '</span></div>';
    $output .= '<div class="info-card"><span class="label">Banco Atual</span><span class="value">' . htmlspecialchars($pdo->query("SELECT DATABASE()")->fetchColumn()) . '</span></div>';
    $output .= '<div class="info-card"><span class="label">Uptime</span><span class="value">' . formatUptime($uptime['Value']) . '</span></div>';
    $output .= '<div class="info-card"><span class="label">Conexões Ativas</span><span class="value">' . htmlspecialchars($connections['Value']) . '</span></div>';
    $output .= '</div>';
    
    $output .= '<h2 class="section-title">Databases</h2>';
    $output .= '<div class="db-list">';
    foreach ($databases as $db) {
        if ($db !== 'information_schema' && $db !== 'performance_schema' && $db !== 'mysql' && $db !== 'sys') {
            $tables = $pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$db'")->fetchColumn();
            $size = $pdo->query("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) FROM information_schema.tables WHERE table_schema = '$db'")->fetchColumn();
            $output .= '<div class="db-item"><span class="db-name">' . htmlspecialchars($db) . '</span><span class="db-meta">' . $tables . ' tabelas | ' . $size . ' MB</span></div>';
        }
    }
    $output .= '</div>';
    
    $output .= '<h2 class="section-title">Configurações</h2>';
    $output .= '<div class="config-grid">';
    $configVars = ['max_connections', 'character_set_server', 'collation_server', 'innodb_buffer_pool_size'];
    foreach ($configVars as $var) {
        $result = $pdo->query("SHOW VARIABLES LIKE '$var'")->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $output .= '<div class="config-item"><span class="config-label">' . htmlspecialchars($var) . '</span><span class="config-value">' . htmlspecialchars($result['Value']) . '</span></div>';
        }
    }
    $output .= '</div>';
    
    return $output;
}

function getPgSQLInfo()
{
    include 'con-pgsql.php';
    
    $version = $pdo->query("SELECT version()")->fetchColumn();
    $databases = $pdo->query("SELECT datname FROM pg_database WHERE datistemplate = false")->fetchAll(PDO::FETCH_COLUMN);
    $uptime = $pdo->query("SELECT pg_postmaster_start_time()")->fetchColumn();
    $connections = $pdo->query("SELECT count(*) FROM pg_stat_activity WHERE state = 'active'")->fetchColumn();
    
    $output = '<div class="db-info pgsql-info">';
    $output .= '<div class="info-card"><span class="label">Versão PostgreSQL</span><span class="value">' . htmlspecialchars($version) . '</span></div>';
    $output .= '<div class="info-card"><span class="label">Banco Atual</span><span class="value">' . htmlspecialchars($pdo->query("SELECT current_database()")->fetchColumn()) . '</span></div>';
    $output .= '<div class="info-card"><span class="label">Início do Servidor</span><span class="value">' . formatDateTime($uptime) . '</span></div>';
    $output .= '<div class="info-card"><span class="label">Conexões Ativas</span><span class="value">' . htmlspecialchars($connections) . '</span></div>';
    $output .= '</div>';
    
    $output .= '<h2 class="section-title">Databases</h2>';
    $output .= '<div class="db-list">';
    foreach ($databases as $db) {
        $tables = $pdo->query("SELECT count(*) FROM information_schema.tables WHERE table_schema = 'public'")->fetchColumn();
        $size = $pdo->query("SELECT pg_size_pretty(pg_database_size('$db'))")->fetchColumn();
        $output .= '<div class="db-item"><span class="db-name">' . htmlspecialchars($db) . '</span><span class="db-meta">' . $tables . ' tabelas | ' . $size . '</span></div>';
    }
    $output .= '</div>';
    
    $output .= '<h2 class="section-title">Configurações</h2>';
    $output .= '<div class="config-grid">';
    $configVars = ['max_connections', 'server_version', 'datestyle', 'timezone'];
    foreach ($configVars as $var) {
        $result = $pdo->query("SHOW $var")->fetchColumn();
        if ($result) {
            $output .= '<div class="config-item"><span class="config-label">' . htmlspecialchars($var) . '</span><span class="config-value">' . htmlspecialchars($result) . '</span></div>';
        }
    }
    $output .= '</div>';
    
    return $output;
}

function formatUptime($seconds)
{
    $days = floor($seconds / 86400);
    $hours = floor(($seconds % 86400) / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    return "{$days}d {$hours}h {$minutes}m";
}

function formatDateTime($datetime)
{
    $dt = new DateTime($datetime);
    return $dt->format('d/m/Y H:i:s');
}
