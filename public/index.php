<?php

echo "<h1>Docker + PHP + .env funcionando</h1>";

$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

if (!$host || !$db || !$user) {
    die("<p>❌ Variáveis de ambiente não carregadas</p>");
}

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    echo "<p>✅ Conectado ao banco com sucesso!</p>";
} catch (PDOException $e) {
    echo "<p>❌ Erro: {$e->getMessage()}</p>";
}
