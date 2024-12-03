<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifica se o email e senha são os credenciais de administrador
    if ($email === 'admin@admin.com' && $password === 'joganopeitodoteupai') {
        $_SESSION['is_admin_logged_in'] = true; // Define a sessão de autenticação
        header("Location: dashboard.php"); // Redireciona para o dashboard
        exit();
    } else {
        $error_message = "E-mail ou senha incorretos";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
            font-family: 'Poppins', sans-serif;
            position: relative;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ff6600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #ff6600;
            color: white;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #e65c00;
        }

        /* Estilizando a mensagem de erro */
        .error-message {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: #ff4d4d;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1000; /* Garante que esteja acima de outros elementos */
        }

        /* Exibir a mensagem de erro com animação */
        .error-message.show {
            opacity: 1;
            animation: fadeOut 3s forwards;
        }

        /* Animação para ocultar a mensagem após 3 segundos */
        @keyframes fadeOut {
            0%, 80% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <?php if (!empty($error_message)): ?>
        <div class="error-message show">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <div class="login-container">
        <h2>Login do Administrador</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
