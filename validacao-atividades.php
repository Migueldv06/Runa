<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validação de Atividades Complementares - Instituto Federal</title>
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
            max-width: 600px;
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

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            color: #004b49;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #333;
        }

        .form-group textarea {
            resize: vertical;
        }

        .form-group input[type="file"] {
            border: none;
        }

        .submit-button {
            background: #00796b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 15px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .submit-button:hover {
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
    <a href="index.php"><img src="img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
    <div class="container">
        <div class="box">
            <h1>Validação de Atividades Complementares</h1>
            <form action="#" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="atividade">ID da Atividade</label>
                    <input type="text" id="atividade" name="atividade" placeholder="ID da Atividade" required>
                </div>
                <div class="form-group">
                    <label for="categoria">Categoria da Atividade</label>
                    <select id="categoria" name="categoria" required>
                        <option value="" disabled selected>Selecione a Categoria</option>
                        <option value="palestra">Palestra</option>
                        <option value="workshop">Workshop</option>
                        <option value="curso">Curso</option>
                        <option value="seminario">Seminário</option>
                        <option value="outros">Outros</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="certificado">Upload do Certificado</label>
                    <input type="file" id="certificado" name="certificado" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>
                <button type="submit" class="submit-button">Validar</button>
            </form>
            <a href="main.php" class="back-link">Voltar</a>
        </div>
    </div>
</body>
</html>
