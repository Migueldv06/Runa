<?php
include "config.php";   // Inclui a conexão com o banco de dados

// Processa o envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metodo = $_POST['validationSelect'];

    if ($metodo === "matricula") {
        $matricula = $DB->real_escape_string($_POST['matricula']);
        $cpf = $DB->real_escape_string($_POST['cpf']);

        $query = "SELECT * FROM discente WHERE matricula = '$matricula' AND cpf = '$cpf' AND status = '0'";
        $result = $DB->query($query) or die("Erro na consulta ao banco: " . $DB->error);
        if ($result->num_rows > 0) {
            $pre_cad_disc = $result->fetch_assoc();
            $id = $pre_cad_disc['id'];
            echo "<script>alert('Pré-cadastro encontrado! Por favor, complete as informações!'); window.location.href='complete-pre-cad-disc.php?id=$id';</script>";
        } else {
            // Pré-cadastro não encontrado
            echo "<script>alert('Nenhum pré-cadastro encontrado!'); window.location.reload();</script>";
        }
    } elseif ($metodo === "email") {
        $email = $DB->real_escape_string($_POST['email']);
        $cpf = $DB->real_escape_string($_POST['cpfEmail']);

        $query = "SELECT * FROM discente WHERE email = '$email' AND cpf = '$cpf' AND status = '0'";
        $result = $DB->query($query) or die("Erro na consulta ao banco: " . $DB->error);

        if ($result->num_rows > 0) {
            $pre_cad_disc = $result->fetch_assoc();
            $id = $pre_cad_disc['id'];
            echo "<script>alert('Pré-cadastro encontrado! Por favor, complete as informações!'); window.location.href='complete-pre-cad-disc.php?id=$id';</script>";
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
            flex-direction: column;
            flex: 1;
            margin: 20px;

            align-items: center;
        }

        .form-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
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
        .form-container input[type="email"],
        .form-container input[type="number"] {
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

        .form-container select {
            width: 200px;
            /* Ajuste do tamanho da caixa de seleção */
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #333;
            cursor: pointer;
        }

        select {
            width: 200px;
            text-size-adjust: 90px;
            font-size: 17px;
            display: flex;
        }
    </style>
</head>

<body>
    <header class="header">
        <a href="index.php"><img src="img/Runa.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

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

            <button id="botaoEnviar" type="submit" style="display: none;">Validar</button>
        </form>
    </div>

    <script>
        const validationSelect = document.getElementById('validationSelect');
        const matriculaFields = document.getElementById('matriculaFields');
        const emailFields = document.getElementById('emailFields');
        const botaoEnviar = document.getElementById('botaoEnviar');

        validationSelect.addEventListener('change', function () {
            const selectedValue = this.value;

            if (selectedValue === 'matricula') {
                matriculaFields.style.display = 'block';
                botaoEnviar.style.display = 'block';
                emailFields.style.display = 'none';
            } else if (selectedValue === 'email') {
                matriculaFields.style.display = 'none';
                botaoEnviar.style.display = 'block';
                emailFields.style.display = 'block';
            } else {
                matriculaFields.style.display = 'none';
                emailFields.style.display = 'none';
            }
        });

        function validateForm() {
            let valid = true;

            // Clear previous errors
            document.querySelectorAll('.error').forEach(e => e.textContent = '');

            // Check validation method
            const validationMethod = document.getElementById('validationSelect').value;
            if (!validationMethod) {
                alert('Por favor, selecione um método de validação.');
                valid = false;
            } else if (validationMethod === 'matricula') {
                // Validation for Número de Matrícula and CPF
                const matricula = document.getElementById('matricula').value.trim();
                const cpf = document.getElementById('cpf').value.trim();

                if (matricula === '') {
                    document.getElementById('matriculaError').textContent = 'O número de matrícula é obrigatório.';
                    valid = false;
                }

                if (cpf === '') {
                    document.getElementById('cpfError').textContent = 'O número de CPF é obrigatório.';
                    valid = false;
                } else if (!validateCPF(cpf)) {
                    document.getElementById('cpfError').textContent = 'O CPF fornecido não é válido.';
                    valid = false;
                }

            } else if (validationMethod === 'email') {
                // Validation for Email and CPF
                const email = document.getElementById('email').value.trim();
                const cpfEmail = document.getElementById('cpfEmail').value.trim();

                if (email === '') {
                    document.getElementById('emailError').textContent = 'O email é obrigatório.';
                    valid = false;
                } else if (!validateEmail(email)) {
                    document.getElementById('emailError').textContent = 'O email fornecido não é válido.';
                    valid = false;
                }

                if (cpfEmail === '') {
                    document.getElementById('cpfErrorEmail').textContent = 'O número de CPF é obrigatório.';
                    valid = false;
                } else if (!validateCPF(cpfEmail)) {
                    document.getElementById('cpfErrorEmail').textContent = 'O CPF fornecido não é válido.';
                    valid = false;
                }
            }

            return valid;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validateCPF(cpf) {
            // Basic CPF validation (length and number format)
            const re = /^\d{11}$/;
            return re.test(cpf);
        }
    </script>
</body>

</html>