<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema HC - Login</title>
    <link rel="shortcut icon" href="img/nome-da-imagem.extrensao">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f0f4f8; /* Fundo claro e profissional */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333; /* Texto escuro para boa legibilidade */
        }

        .login-container {
            text-align: center;
            width: 100%;
        }

        .login-box {
            background: #ffffff; /* Caixa branca para contraste */
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
            padding: 30px;
            max-width: 400px;
            margin: 0 auto;
        }

        .logo {
            width: 120px;
            margin-bottom: 20px;
        }

        .login-box h1 {
            color: #004b49; /* Azul escuro institucional */
            margin-bottom: 20px;
            font-size: 32px;
            font-weight: bold;
        }

        .subtitle {
            color: #00796b; /* Verde escuro institucional */
            margin-bottom: 30px;
            font-size: 16px;
        }

        .subtitle a {
            color: #004b49; /* Azul escuro institucional para links */
            text-decoration: none;
            font-weight: bold;
        }

        .subtitle a:hover {
            text-decoration: underline;
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd; /* Borda suave */
            border-radius: 8px;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #333;
        }

        .login-box button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            background-color: #00796b; /* Verde institucional */
            color: #ffffff;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .login-box button:hover {
            background-color: #004b49; /* Azul escuro no hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave no hover */
        }

        .login-box a {
            display: inline-block;
            margin-top: 20px;
            color: #00796b; /* Verde institucional */
            text-decoration: none;
            font-size: 14px;
        }

        .login-box a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <img src="img/Runa.png" alt="Logo Runas" class="logo">
            <h1>Login</h1>
            <p class="subtitle">Acesse sua conta ou <a href="criar-validar.php">crie uma nova</a></p>
            <form action="" method="post">
                <input type="text" name="username" id="username" placeholder="Usuário">
                <input type="password" name="password" id="password" placeholder="Senha">
                <button type="submit">Entrar</button>
                <a href="esqueci-senha.php">Esqueci minha senha</a>
            </form>
        </div>
    </div>
</body>
</html>
