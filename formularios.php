<?php
session_start(); // Iniciar a sessão

// Verificar se há formulários pendentes
if (!isset($_SESSION['submittedForms']) || empty($_SESSION['submittedForms'])) {
    echo "Não há formulários pendentes.";
    exit;
}

// Inicializar a lista de formulários aceitos, se não existir
if (!isset($_SESSION['acceptedForms'])) {
    $_SESSION['acceptedForms'] = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $formId = $_POST['formId'];

    foreach ($_SESSION['submittedForms'] as $key => $form) {
        if ($form['id'] == $formId) {
            if ($action == 'aceitar') {
                $form['status'] = 'aceito';
                $_SESSION['acceptedForms'][] = $form; // Mover para a lista de aceitos
                unset($_SESSION['submittedForms'][$key]); // Remover dos pendentes
            } elseif ($action == 'recusar') {
                $form['status'] = 'recusado';
                unset($_SESSION['submittedForms'][$key]); // Apenas remover dos pendentes
            }
        }
    }

    header('Location: formularios.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulários Pendentes</title>
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

        .form-container {
            background-color: #fff;
            padding: 20px;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 20px auto;
        }

        .form-container h2 {
            margin-bottom: 10px;
        }

        .form-container p {
            margin-bottom: 10px;
        }

        .button-group {
            display: flex;
            gap: 10px;
        }

        .button-group button {
            padding: 10px 20px;
            background-color: #ff6600;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button-group button:hover {
            background-color: #e55d00;
        }

        /* Estilo para a imagem circular de perfil */
        .profile-pic {
            width: 80px; /* Tamanho da imagem */
            height: 80px;
            border-radius: 50%;
            border: 2px solid #ccc;
            background-color: #f4f4f4;
            display: block;
            margin: 10px auto;
            overflow: hidden;
        }

        .profile-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Estilo para os links de visualização do documento */
        .form-container a {
            color: #ff6600;
            text-decoration: none;
        }

        .form-container a:hover {
            text-decoration: underline;
        }

        .info {
            text-align: left;
        }
    </style>
</head>
<body>

<h1>Formulários Pendentes</h1>

<?php foreach ($_SESSION['submittedForms'] as $form) : ?>
    <div class="form-container">
        <!-- Título do formulário -->
        <h2>Formulário #<?php echo $form['id']; ?> - Status: <?php echo ucfirst($form['status']); ?></h2>

        <!-- Foto de Perfil abaixo do título -->
        <div class="profile-pic">
            <img src="<?php echo $form['profilePic']; ?>" alt="Foto de Perfil">
        </div>
        
        <!-- Informações do formulário abaixo da foto -->
        <div class="info">
            <p><strong>Nome:</strong> <?php echo $form['name']; ?></p>
            <p><strong>E-mail:</strong> <?php echo $form['email']; ?></p>
            <p><strong>Especialização:</strong> <?php echo $form['specialization']; ?></p>
            <p><strong>Documento:</strong> <a href="<?php echo $form['document']; ?>" target="_blank">Visualizar Documento</a></p>
        </div>
        
        <div class="button-group">
            <form action="formularios.php" method="POST">
                <input type="hidden" name="formId" value="<?php echo $form['id']; ?>">
                <button type="submit" name="action" value="aceitar">Aceitar</button>
                <button type="submit" name="action" value="recusar">Recusar</button>
            </form>
        </div>
    </div>
<?php endforeach; ?>

</body>
</html>
