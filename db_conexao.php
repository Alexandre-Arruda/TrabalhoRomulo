<?php
// db_conexao.php

$host = 'localhost';
$db_name = 'loja_perifericos';
$username = 'root'; // Usuário padrão do XAMPP
$password = ''; // Senha padrão do XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Em produção, não exiba detalhes do erro ao usuário
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>