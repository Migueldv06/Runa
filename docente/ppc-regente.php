<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPC Vigente - Instituto Federal</title>
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
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
            position: relative;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 80px; /* Tamanho menor da logomarca */
        }

        .container {
            width: 100%;
            max-width: 800px;
            padding: 20px;
        }

        .box {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 0 auto;
        }

        h1 {
            color: #004b49;
            margin-bottom: 20px;
            font-size: 32px;
            font-weight: bold;
        }

        .content {
            text-align: left;
        }

        .content p {
            font-size: 16px;
            color: #004b49;
            margin-bottom: 10px;
        }

        .download-button {
            display: inline-block;
            background: #00796b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 16px;
            text-decoration: none;
            text-align: center;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .download-button:hover {
            background-color: #004b49;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: #00796b;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
    <div class="container">
        <div class="box">
            <h1>PPC Vigente</h1>
            <div class="content">
                <p>O Projeto Pedagógico do Curso (PPC) é um documento importante que define a estrutura do curso, incluindo objetivos, disciplinas, e outras informações relevantes.</p>
                <p>Para visualizar o PPC atual, consulte o documento disponibilizado.</p>
                <p>Se precisar fazer alterações ou enviar novos documentos, entre em contato com a coordenação.</p>
                <a href="docs/ppc-regente.pdf" class="download-button" download>Baixar Documento PPC</a>
            </div>
            <a href="main.php" class="back-link">Voltar</a>
        </div>
    </div>
</body>
</html>