<?php
session_start(); // Garantir que a sessão seja iniciada corretamente

// Simulação de armazenamento de dados (substitua isso por um banco de dados em um ambiente real)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coletando os dados enviados no formulário
    $name = $_POST['name'];
    $email = $_POST['email'];
    $specialization = $_POST['specialization'];
    $profilePic = $_FILES['profilePic']; // Arquivo de imagem
    $document = $_FILES['document']; // Arquivo de documento
    $password = $_POST['password'];

    // Criando uma entrada para o formulário enviado
    $form = [
        'id' => count($_SESSION['submittedForms'] ?? []) + 1,  // Incrementa o ID para o novo formulário
        'name' => $name,
        'email' => $email,
        'specialization' => $specialization,
        'profilePic' => 'uploads/' . $profilePic['name'], // Caminho de onde a foto será salva
        'document' => 'uploads/' . $document['name'], // Caminho do documento
        'status' => 'pendente', // Status inicial do formulário
    ];

    // Movendo os arquivos para o diretório "uploads"
    move_uploaded_file($profilePic['tmp_name'], 'uploads/' . $profilePic['name']);
    move_uploaded_file($document['tmp_name'], 'uploads/' . $document['name']);

    // Garantir que a variável de sessão existe
    if (!isset($_SESSION['submittedForms'])) {
        $_SESSION['submittedForms'] = [];
    }

    // Adicionando o formulário à "base de dados" (aqui simula-se uma variável)
    $_SESSION['submittedForms'][] = $form;

    // Redirecionando para a página de formulários pendentes
    header('Location: formularios.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Servidor Público</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: #141E30;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
            padding: 20px;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            height: auto;
            overflow-y: auto;
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 30px;
            color: #333;
        }

        .input-group {
            width: 100%;
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            font-size: 1.1em;
            color: #333;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"],
        input[type="password"],
        textarea {
            width: 100%;
            padding: 15px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1em;
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        .profile-pic-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 2px solid #ccc;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .profile-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-submit {
            background-color: #ff6600;
            border: none;
            padding: 15px 0;
            color: white;
            width: 100%;
            font-size: 1.2em;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .btn-submit:hover {
            background-color: #e55d00;
        }

        .back-link {
            margin-top: 20px;
            font-size: 1em;
            color: #666;
        }

        .back-link a {
            color: #ff6600;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .form-container {
                padding: 30px;
                width: 100%;
            }

            input[type="text"],
            input[type="email"],
            input[type="file"],
            input[type="password"],
            textarea {
                padding: 12px;
            }

            .btn-submit {
                padding: 12px 0;
                font-size: 1em;
            }

            h1 {
                font-size: 1.8em;
            }
        }

        /* Estilos para o campo de upload de documentos */
        .input-group input[type="file"] {
            padding: 20px;
            border: 2px dashed #ccc;
            background-color: #f9f9f9;
            width: 100%;
            font-size: 1em;
            cursor: pointer;
            text-align: center;
        }

        .input-group input[type="file"]:hover {
            border-color: #ff6600;
            background-color: #ff66001a;
        }

        .input-group .file-label {
            display: block;
            font-size: 1em;
            color: #333;
            margin-bottom: 5px;
        }

        /* Adicionando scrollbar no container caso o conteúdo ultrapasse a altura da tela */
        .form-container {
            max-height: 90vh; /* Limita a altura do formulário para a altura da tela */
            overflow-y: auto; /* Habilita a rolagem se necessário */
        }

        /* A área de upload do documento ficará mais destacada */
        .file-upload-container {
            width: 100%;
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border: 2px dashed #ccc;
            border-radius: 5px;
            font-size: 1em;
            position: relative;
        }

        /* Botão de Upload de Arquivo Customizado */
        .file-upload-container input[type="file"] {
            display: none;
        }

        /* Botão de Upload de Arquivo Customizado */
        .file-upload-container .upload-btn {
            display: inline-block;
            background-color: #ff6600;
            color: white;
            padding: 10px 20px; /* Reduzindo o padding para um botão menor */
            font-size: 1em; /* Ajustando o tamanho da fonte */
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
            margin-top: 10px; /* Ajuste da margem */
        }
        
        .file-upload-container .upload-btn:hover {
            background-color: #e55d00;
        }


        /* Exibição do nome do arquivo após o upload */
        .file-upload-container .file-name {
            margin-top: 15px;
            color: #333;
            font-size: 1em;
            display: none; /* Inicialmente escondido */
        }

        /* Exibição do nome do arquivo após o upload */
        .file-upload-container .file-name.visible {
            display: block;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Cadastro de Servidor Público</h1>

    <form action="cadastro-servidor.php" method="POST" enctype="multipart/form-data">
        <div class="input-group">
            <label for="name">Nome Completo:</label>
            <input type="text" id="name" name="name" placeholder="Seu nome completo" required>
        </div>

        <div class="input-group">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="Seu e-mail" required>
        </div>

        <div class="input-group">
            <label for="specialization">Especialização:</label>
            <input type="text" id="specialization" name="specialization" placeholder="Sua especialização" required>
        </div>

        <div class="profile-pic-container">
            <label for="profilePic" class="profile-pic">
                <input type="file" id="profilePic" name="profilePic" accept="image/*" style="display:none;" required>
                <img src="https://via.placeholder.com/120" alt="Foto de Perfil" id="profilePicPreview">
            </label>
        </div>

        <div class="file-upload-container">
            <label for="document" class="file-label">Comprovante de Habilidade (PDF ou Imagem):</label>
            <input type="file" id="document" name="document" accept="application/pdf, image/*" required>
            <label for="document" class="upload-btn">Escolher Arquivo</label>
            <div class="file-name" id="fileName"></div>
        </div>

        <div class="input-group">
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" placeholder="Crie uma senha" required>
        </div>

        <div class="input-group">
            <label for="confirm-password">Confirme a Senha:</label>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirme a senha" required>
        </div>

        <button type="submit" class="btn-submit">Cadastrar</button>
    </form>

    <div class="back-link">
        <p><a href="/cadastro/index.html">Voltar ao cadastro normal</a></p>
    </div>
</div>

<script>
    // Função para exibir a prévia da foto de perfil
    document.getElementById('profilePic').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('profilePicPreview').src = e.target.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    });

    // Função para exibir o nome do arquivo do documento
    document.getElementById('document').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const fileNameElement = document.getElementById('fileName');
        if (file) {
            fileNameElement.textContent = file.name;
            fileNameElement.classList.add('visible');
        }
    });
</script>

</body>
</html>
