<?php
include "../config.php";
include "protect-docente.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $horas_necessarias = $_POST['horas_necessarias'];

    $sql = "INSERT INTO curso (nome, horas_necessarias) VALUES (?, ?)";
    $stmt = $DB->prepare($sql);
    $stmt->bind_param("si", $nome, $horas_necessarias);

    if ($stmt->execute()) {
        echo "<p>Curso criada com sucesso!</p>";
    } else {
        echo "<p>Erro na criação da Curso.</p>";
    }
    header("Location: main.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Curso - RUNAS</title>
    <link rel="stylesheet" href="styles/cria-curso.css">
</head>

<body>
    <header class="header">
        <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <div class="container">
        <div class="form-container">
            <h1>Criar Curso</h1>
            <form id="preCadastroForm" method="post">
                <label for="nome">Nome da Turma:</label>
                <input type="text" id="nome" name="nome" placeholder="Nome" required>
                <span class="error" id="nomeError"></span>

                <label for="horas_necessarias">Horas necessarias:</label>
                <input type="text" id="horas_necessarias" name="horas_necessarias" placeholder="horas_necessarias" required>
                <span class="error" id="horas_necessariasError"></span>

                <button type="submit" class="submit-button">Enviar</button>
                <a class="submit-button" href="main.php">Voltar</a>
            </form>
        </div>
    </div>
</body>

</html>