<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pré-Cadastro de Discente</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f0f4f8;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .container img.logo {
            width: 120px;
            margin-bottom: 20px;
        }

        .container h1 {
            color: #00796b;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            color: #00796b;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #b2dfdb;
            border-radius: 8px;
        }

        .form-group input:focus {
            border-color: #00796b;
            outline: none;
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
    <div class="container">
        <img src="img/logo-instituto-federal.png" alt="Logo Instituto Federal" class="logo">
        <h1>Pré-Cadastro de Discente</h1>
        <form action="processar-pre-cadastro-discente.php" method="post">
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
</body>

</html>
