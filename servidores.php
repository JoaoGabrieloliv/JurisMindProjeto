<?php
session_start(); // Iniciar a sessão

// Verificar se há servidores aceitos
if (!isset($_SESSION['acceptedForms']) || empty($_SESSION['acceptedForms'])) {
    echo "Não há servidores aceitos.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servidores Aceitos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 250px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .card h3 {
            margin: 10px 0;
            font-size: 18px;
            color: #333;
        }

        .card p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
        }

        .card .chat-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #ff6600;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .card .chat-button:hover {
            background-color: #e55d00;
        }
    </style>
</head>
<body>

<h1>Servidores Aceitos</h1>
<div class="card-container">
    <?php foreach ($_SESSION['acceptedForms'] as $form) : ?>
        <div class="card">
            <img src="<?php echo $form['profilePic']; ?>" alt="Foto de Perfil">
            <h3><?php echo $form['name']; ?></h3>
            <p><strong>E-mail:</strong> <?php echo $form['email']; ?></p>
            <p><strong>Especialização:</strong> <?php echo $form['specialization']; ?></p>
            <a href="chat.php?serverId=<?php echo $form['id']; ?>" class="chat-button">Iniciar Chat</a>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
