<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criação e Validação - Sistema HC</title>
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
            margin: 0;
            color: #333; /* Texto escuro para boa legibilidade */
        }

        .container {
            text-align: center;
            width: 100%;
        }

        .box {
            background: #ffffff; /* Caixa branca para contraste */
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
            padding: 30px;
            max-width: 500px;
            margin: 0 auto;
        }

        .logo {
            width: 120px;
            margin-bottom: 20px;
        }

        h1 {
            color: #004b49; /* Azul escuro institucional */
            margin-bottom: 20px;
            font-size: 32px;
            font-weight: bold;
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .option-button {
            background: #00796b; /* Verde institucional */
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 15px;
            font-size: 18px;
            cursor: pointer;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .option-button:hover {
            background-color: #004b49; /* Azul escuro no hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave no hover */
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: #00796b; /* Verde institucional */
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box">
            <a href="index.php"><img src="img/Runa.png" alt="Logo Runas" class="logo"></a> 
            <h1>Opções de Cadastro e Validação</h1>
            <div class="options">
                <a href="pre-cadastro-docente.php" class="option-button">Criar pré-cadastro de docente</a> 
                <a href="val-pre-cad-doc.php" class="option-button">Validar pré-cadastro docente</a> 
                <a href="pre-cadastro-discente.php" class="option-button">Criar pré-cadastro de discente</a> 
                <a href="val-pre-cad-disc.php" class="option-button">Validar pré-cadastro de discente</a> 
            </div>
            <a href="index.php" class="back-link">Voltar ao login</a> 
        </div>
    </div>
</body>
</html>