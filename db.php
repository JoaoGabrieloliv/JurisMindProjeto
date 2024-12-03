<?php
$host = 'localhost';
$db = 'u249175890_advogado_virtu';
$user = 'u249175890_usuario';
$password = 'Usuario12345$';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
