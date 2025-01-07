<?php
include "config.php";   // Inclui a conexão com o banco de dados

// Processa o envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metodo = $_POST['validationSelect'];

    if ($metodo === "matricula") {
        $matricula = $DB->real_escape_string($_POST['matricula']);
        $cpf = $DB->real_escape_string($_POST['cpf']);

        $query = "SELECT * FROM docente WHERE matricula = '$matricula' AND cpf = '$cpf' AND status = '0'";
        $result = $DB->query($query) or die("Erro na consulta ao banco: " . $DB->error);
        if ($result->num_rows > 0) {
            $pre_cad_disc = $result->fetch_assoc();
            $id = $pre_cad_disc['id'];
            echo "<script>alert('Pré-cadastro encontrado! Por favor, complete as informações!'); window.location.href='complete-pre-cad-doc.php?id=$id';</script>";
        } else {
            // Pré-cadastro não encontrado
            echo "<script>alert('Nenhum pré-cadastro encontrado!'); window.location.reload();</script>";
        }
    } elseif ($metodo === "email") {
        $email = $DB->real_escape_string($_POST['email']);
        $cpf = $DB->real_escape_string($_POST['cpfEmail']);

        $query = "SELECT * FROM docente WHERE email = '$email' AND cpf = '$cpf' AND status = '0'";
        $result = $DB->query($query) or die("Erro na consulta ao banco: " . $DB->error);

        if ($result->num_rows > 0) {
            $pre_cad_disc = $result->fetch_assoc();
            $id = $pre_cad_disc['id'];
            echo "<script>alert('Pré-cadastro encontrado! Por favor, complete as informações!'); window.location.href='complete-pre-cad-doc.php?id=$id';</script>";
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
    <title>RUNAS - Validar Pré-Cadastro Docente</title>
    <link rel="stylesheet" href="styles/val-pre-cad-doc.css">
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
    </script>
</body>

</html>