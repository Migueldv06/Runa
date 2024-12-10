<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pré-Cadastro Docente - SiVAC</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background: #f0f4f8;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #333;
        }

        .header {
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 80px;
            z-index: 1000;
        }

        .logo {
            width: 60px;
        }

        .title {
            font-size: 24px;
            color: #00796b;
            margin-left: 20px;
        }

        .container {
            display: flex;
            flex: 1;
            flex-direction: column;
            margin: 20px;
            text-align: center;
        }
        .container h1 {
            color: #00796b;
            margin-bottom: 20px;
        }
        .container img.logo {
            width: 120px;
            margin-bottom: 20px;
        }

        .form-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .form-container h1 {
            color: #00796b;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container input[type="email"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #333;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            background-color: #00796b;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #004d40;
        }

        .form-container .optional {
            font-size: 14px;
            color: #666;
        }

        .form-container .error {
            color: red;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 15px;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .buttons button {
            background-color: #00796b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .buttons button:hover {
            background-color: #004b49;
        }

        .buttons a {
            display: inline-block;
            text-decoration: none;
            color: #00796b;
            background-color: #e0f2f1;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            line-height: 1;
            text-align: center;
            transition: background-color 0.3s;
        }

        .buttons a:hover {
            background-color: #b2dfdb;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="index.php"><img src="img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <div class="container">
        <div class="form-container">
        <img src="img/Runa.png" alt="Logo Instituto Runas" class="logo">
        <h1>Pré-Cadastro de Docente</h1>
        <form action="processar-pre-cadastro.php" method="post">
            <div class="form-group">
                <label for="matricula">Número de Matrícula:</label>
                <input type="text" id="matricula" name="matricula" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="buttons">
                <button type="submit">Cadastrar</button>
                <a href="index.php">Voltar</a>
            </div>
        </form>
        </div>
    </div>

    <script>
        function validateForm() {
            let valid = true;

            // Clear previous errors
            document.querySelectorAll('.error').forEach(e => e.textContent = '');

            // Matrícula
            const matricula = document.getElementById('matricula').value.trim();
            if (matricula === '') {
                document.getElementById('matriculaError').textContent = 'O número de matrícula é obrigatório.';
                valid = false;
            }

            // Email
            const email = document.getElementById('email').value.trim();
            if (email === '') {
                document.getElementById('emailError').textContent = 'O email é obrigatório.';
                valid = false;
            } else if (!validateEmail(email)) {
                document.getElementById('emailError').textContent = 'O email fornecido não é válido.';
                valid = false;
            }

            return valid;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    </script>
</body>
</html>
