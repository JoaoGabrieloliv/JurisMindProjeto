<?php
// Conexão ao banco de dados
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifica o usuário pelo email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; // Armazena o ID do usuário na sessão
        header("Location: /principal/index.html"); // Redireciona para o pagina principal
        exit();
    } else {
        // Armazena a mensagem de erro na sessão
        $_SESSION['error_message'] = "E-mail ou senha incorretos";
        // Redireciona de volta para a página de login
        header("Location: /login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Advogado Virtual</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Firebase SDKs -->
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.6.10/firebase-firestore.js"></script>
    <!-- Configuração do Firebase -->
    <script src="firebaseConfig.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #141E30;
            
        }

        /* Fundo com partículas */
        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            min-width: 100vw;
            min-height: 100vh;
            z-index: -1; /* Mantém o fundo abaixo do conteúdo */
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9); 
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
            animation: fadeIn 1s ease-in-out; 
        }

        img {
            width: 180px; 
            margin-bottom: 10px;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 30px;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1em;
            font-family: 'Poppins', sans-serif;
        }

        .btn-login {
            background-color: #ff6600;
            border: none;
            padding: 15px 0;
            color: white;
            width: 100%;
            font-size: 1.2em;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .btn-login:hover {
            background-color: #e55d00;
        }

        .register-section {
            margin-top: 20px;
            font-size: 1em;
            color: #666;
        }

        .register-section a {
            color: #ff6600;
            text-decoration: none;
            font-weight: bold;
        }

        .register-section a:hover {
            text-decoration: underline;
        }

        /* Animação de fade-in */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .error-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #ffdddd; /* Fundo vermelho claro */
            color: #d8000c; /* Texto vermelho escuro */
            border: 1px solid #d8000c; /* Borda vermelha */
            border-radius: 5px; /* Bordas arredondadas */
            padding: 10px 20px; /* Espaçamento interno */
            z-index: 1000; /* Coloca a mensagem acima de outros elementos */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Sombra sutil */
            animation: fadeIn 0.5s; /* Animação de aparecimento */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
    </style>
</head>

<body>

<?php
session_start();

// Verifica se existe uma mensagem de erro na sessão
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
// Limpa a mensagem de erro da sessão após exibí-la
unset($_SESSION['error_message']);
?>

<?php if ($error_message): ?>
    <div class="error-message"><?php echo $error_message; ?></div>
<?php endif; ?>

<div id="particles-js"></div>

<div class="login-container">
    <img src="/images/logo_direito-removebg-preview.png" alt="Logo Advogado Virtual">
    <h1>Bem-vindo</h1>

   
    <form action="/login.php" method="POST">
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="password" placeholder="Senha" required>
        <button type="submit" class="btn-login">Entrar</button>
    </form>
    

    
    <div class="register-section">
        <p>Não tem uma conta? <a href="/cadastro/index.html">Crie uma agora</a></p>
    </div>
</div>

<!-- Script para o fundo com partículas -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
    particlesJS("particles-js", {
        "particles": {
            "number": {
                "value": 80,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": "#ffffff"
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                },
                "polygon": {
                    "nb_sides": 5
                }
            },
            "opacity": {
                "value": 0.5,
                "random": false,
                "anim": {
                    "enable": false,
                    "speed": 1,
                    "opacity_min": 0.1,
                    "sync": false
                }
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {
                    "enable": false,
                    "speed": 40,
                    "size_min": 0.1,
                    "sync": false
                }
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#ffffff",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 6,
                "direction": "none",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 1200
                }
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "repulse"
                },
                "onclick": {
                    "enable": true,
                    "mode": "push"
                },
                "resize": true
            },
            "modes": {
                "grab": {
                    "distance": 400,
                    "line_linked": {
                        "opacity": 1
                    }
                },
                "bubble": {
                    "distance": 400,
                    "size": 40,
                    "duration": 2,
                    "opacity": 8,
                    "speed": 3
                },
                "repulse": {
                    "distance": 200,
                    "duration": 0.4
                },
                "push": {
                    "particles_nb": 4
                },
                "remove": {
                    "particles_nb": 2
                }
            }
        },
        "retina_detect": true
    });
</script>

<script>
    // Espera 5 segundos (5000 milissegundos) e depois remove a mensagem de erro
    setTimeout(function() {
        var errorMessage = document.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.style.transition = "opacity 0.5s ease"; // Adiciona uma transição suave
            errorMessage.style.opacity = "0"; // Faz a mensagem desaparecer
            setTimeout(function() {
                errorMessage.remove(); // Remove a mensagem do DOM
            }, 500); // Espera o tempo da transição antes de remover
        }
    }, 3000);
</script>


</body>
</html>
