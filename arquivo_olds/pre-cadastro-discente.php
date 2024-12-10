<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : NULL;

    $nome = $DB->real_escape_string($nome);
    $matricula = $DB->real_escape_string($matricula);
    $cpf = $DB->real_escape_string($cpf);
    $email = $DB->real_escape_string($email);
    $telefone = $telefone ? $DB->real_escape_string($telefone) : NULL;

    $check_sql = "SELECT * FROM Discente WHERE cpf = '$cpf' OR matricula = '$matricula'";
    $result = $DB->query($check_sql);

    if ($result->num_rows > 0) {
        echo "CPF ou matrícula já cadastrados!";
    } else {
        $sql = "INSERT INTO Discente (nomeDiscente, matricula, cpf, email, telefone)
                VALUES ('$nome', '$matricula', '$cpf', '$email', '$telefone')";

        if ($DB->query($sql) === TRUE) {
            echo "Pré-cadastro realizado com sucesso!";
        } else {
            echo "Erro: " . $sql . "<br>" . $DB->error;
        }
    }

    // Fechar a conexão
    $DB->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pré-Cadastro Discente - SiVAC</title>
    <link rel="stylesheet" href="styles/pre-cadastro-discente.css">
</head>
<body>
    <header class="header">
        <a href="index.php"><img src="img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <div class="container">
        <div class="form-container">
            <h1>Pré-Cadastro de Discente</h1>
            <form id="preCadastroForm" method="POST" action="pre-cadastro-discente.php" onsubmit="return validateForm()">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" placeholder="Nome Completo" required>
                <span class="error" id="nomeError"></span>

                <label for="matricula">Número de Matrícula:</label>
                <input type="number" id="matricula" name="matricula" placeholder="Número de Matrícula" required>
                <span class="error" id="matriculaError"></span>

                <label for="cpf">Número de CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="Número de CPF" required>
                <span class="error" id="cpfError"></span>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <span class="error" id="emailError"></span>

                <label for="telefone">Número de Telefone (Opcional):</label>
                <input type="tel" id="telefone" name="telefone" placeholder="Número de Telefone">
                <span class="error" id="telefoneError"></span>

                <button type="submit">Submeter</button>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            let valid = true;

            // Clear previous errors
            document.querySelectorAll('.error').forEach(e => e.textContent = '');

            // Nome
            const nome = document.getElementById('nome').value.trim();
            if (nome === '') {
                document.getElementById('nomeError').textContent = 'O nome completo é obrigatório.';
                valid = false;
            }

            // Matrícula
            const matricula = document.getElementById('matricula').value.trim();
            if (matricula === '') {
                document.getElementById('matriculaError').textContent = 'O número de matrícula é obrigatório.';
                valid = false;
            }

            // CPF
            const cpf = document.getElementById('cpf').value.trim();
            if (cpf === '') {
                document.getElementById('cpfError').textContent = 'O número de CPF é obrigatório.';
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

            // Telefone (opcional)
            const telefone = document.getElementById('telefone').value.trim();
            if (telefone !== '' && !validatePhone(telefone)) {
                document.getElementById('telefoneError').textContent = 'O número de telefone fornecido não é válido.';
                valid = false;
            }

            return valid;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^\d{10,11}$/; // Exemplo de validação para números de telefone (10 ou 11 dígitos)
            return re.test(phone);
        }
    </script>
</body>
</html>
