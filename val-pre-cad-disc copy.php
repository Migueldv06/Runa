<?php
include "config.php"; // Inclui a conexão com o banco de dados

// Processa o envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metodo = $_POST['validationSelect'];

    if ($metodo === "matricula") {
        $matricula = $DB->real_escape_string($_POST['matricula']);
        $cpf = $DB->real_escape_string($_POST['cpf']);

        $query = "SELECT * FROM discente WHERE matricula = '$matricula' AND cpf = '$cpf' AND status = '0'";
        $result = $DB->query($query) or die("Erro na consulta ao banco: " . $DB->error);

        if ($result->num_rows > 0) {
            echo "<script>alert('Pré-cadastro encontrado! Por favor, complete as informações!'); window.location.href='complete-pre-cad-disc.php';</script>";
        } else {
            echo "<script>alert('Nenhum pré-cadastro encontrado!'); window.location.reload();</script>";
        }
    } elseif ($metodo === "email") {
        $email = $DB->real_escape_string($_POST['email']);
        $cpf = $DB->real_escape_string($_POST['cpfEmail']);

        $query = "SELECT * FROM discente WHERE email = '$email' AND cpf = '$cpf' AND status = '0'";
        $result = $DB->query($query) or die("Erro na consulta ao banco: " . $DB->error);

        if ($result->num_rows > 0) {
            echo "<script>alert('Pré-cadastro encontrado! Por favor, complete as informações!'); window.location.href='complete-pre-cad-disc.php';</script>";
        } else {
            echo "<script>alert('Nenhum pré-cadastro encontrado!'); window.location.reload();</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Pré-Cadastro Discente - SiVAC</title>
    <style>
        /* Estilos simplificados */
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
            width: 90%;
            max-width: 500px;
        }

        .form-container h1 {
            color: #00796b;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #00796b;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #004d40;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Validar Pré-Cadastro Discente</h1>
        <form id="validarPreCadastroForm" method="post">
            <label for="validationSelect">Escolha o método de validação:</label>
            <select id="validationSelect" name="validationSelect" required>
                <option value="">Selecione um método</option>
                <option value="matricula">Número de Matrícula e CPF</option>
                <option value="email">Email e CPF</option>
            </select>

            <!-- Campos de Matrícula -->
            <div id="matriculaFields" style="display: none;">
                <label for="matricula">Número de Matrícula:</label>
                <input type="number" id="matricula" name="matricula" placeholder="Número de Matrícula">

                <label for="cpf">Número de CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="Número de CPF">
            </div>

            <!-- Campos de Email -->
            <div id="emailFields" style="display: none;">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Email">

                <label for="cpfEmail">Número de CPF:</label>
                <input type="text" id="cpfEmail" name="cpfEmail" placeholder="Número de CPF">
            </div>

            <button type="submit">Validar</button>
        </form>
    </div>

    <script>
        const validationSelect = document.getElementById('validationSelect');
        const matriculaFields = document.getElementById('matriculaFields');
        const emailFields = document.getElementById('emailFields');

        validationSelect.addEventListener('change', function () {
            const selectedValue = this.value;

            if (selectedValue === 'matricula') {
                matriculaFields.style.display = 'block';
                emailFields.style.display = 'none';
            } else if (selectedValue === 'email') {
                matriculaFields.style.display = 'none';
                emailFields.style.display = 'block';
            } else {
                matriculaFields.style.display = 'none';
                emailFields.style.display = 'none';
            }
        });
    </script>
</body>

</html>