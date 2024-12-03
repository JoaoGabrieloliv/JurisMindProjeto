<?php
// Conexão ao banco de dados
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->execute([$email, $password]);
        header("Location: /principal/index.html"); // Redireciona após cadastro
        exit();
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>
