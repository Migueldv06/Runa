<?php
include "../config.php";
include "protect-docente.php";

$sql = "SELECT id, nome FROM curso";
$result = $DB->query($sql) or die("Falha na execução do MySQL: " . $DB->error);

// Verifica se o usuário foi encontrado
if ($result->num_rows <= 0) {
    echo "Sem Curso no sistema.";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $curso = intval($_POST['curso']);

    // Inserir os dados no banco de dados
    $sql = "INSERT INTO turma (nome, curso) VALUES (?, ?)";
    $stmt = $DB->prepare($sql);
    $stmt->bind_param("si", $nome, $curso);

    if ($stmt->execute()) {
        echo "<p>Turma criada com sucesso!</p>";
    } else {
        echo "<p>Erro na criação da turma.</p>";
    }
    header("Location: main.php");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Turma - SiVAC</title>
    <link rel="stylesheet" href="styles/cria-turma.css">
</head>

<body>
    <header class="header">
        <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <div class="container">
        <div class="form-container">
            <h1>Criar Turma</h1>
            <form id="preCadastroForm" onsubmit="return validateForm()" method="post">
                <label for="nome">Nome da Turma:</label>
                <input type="nome" id="nome" name="nome" placeholder="Nome" value="" required>
                <span class="error" id="nomeError"></span>

                <label for="curso">Curso:</label>
                <select id="curso" name="curso" required>
                    <option value="">Selecione um curso</option>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row["id"] . '">' . $row["nome"] . '</option>';
                    }
                    ?>
                </select>
                <span class="error" id="cursoError"></span>

                <button type="submit" class="submit-button">Enviar</button>
                <a class="submit-button" href="main.php">Voltar</a>
            </form>
        </div>
    </div>
</body>

</html>