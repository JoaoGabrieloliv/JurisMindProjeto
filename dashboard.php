<?php
session_start();

// Verifica se o usuário fez login na página admin.php
if (!isset($_SESSION['is_admin_logged_in']) || $_SESSION['is_admin_logged_in'] !== true) {
    header("Location: admin.php"); // Redireciona para a página de login
    exit();
}

// Código da página do dashboard (exibir lista de usuários)
require 'db.php';

$stmt = $pdo->query("SELECT email, created_at FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Usuários Cadastrados</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
            color: #ff6600;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #ff6600;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Estilizando a tabela com bordas */
        table {
            border: 1px solid #ccc;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            table {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Usuários Cadastrados</h1>
    <table>
        <tr>
            <th>Email</th>
            <th>Data de Cadastro</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['created_at']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
