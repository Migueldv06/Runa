<?php
include "../config.php";
include "protect-docente.php";

$sqlTurma = "SELECT * FROM turma";
$resultTurma = $DB->query($sqlTurma) or die("Falha na execução do MySQL: " . $DB->error);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $matricula = $_POST['matricula'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $turno = $_POST['turno'];
    $turma = intval($_POST['turma']);

    // Inserir os dados no banco de dados
    $sql = "INSERT INTO discente (nome, cpf, matricula, email, telefone, turno, turma) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $DB->prepare($sql);
    $stmt->bind_param("siisssi", $nome, $cpf, $matricula, $email, $telefone, $turno, $turma);

    if ($stmt->execute()) {
        echo "<script>alert('Pre Cadastro de Discente criado com sucesso!'); window.location.href='main.php';</script>";
    } else {
        echo "<script>alert('Erro no Pre Cadastro de Discente!'); window.location.href='main.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Pre Cadastro Discente - RUNAS</title>
    <link rel="stylesheet" href="styles/pre-cadastro-discente.css">
</head>

<body>
    <header class="header">
        <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <div class="container">
        <div class="form-container">
            <h1>Criar Pre Cadastro de Discente</h1>
            <form id="preCadastroForm" method="post">
                <label for="nome">Nome do Discente:</label>
                <input type="text" id="nome" name="nome" placeholder="Nome" value="" required>
                <span class="error" id="nomeError"></span>

                <label for="cpf">CPF</label>
                <input type="number" id="cpf" name="cpf" placeholder="CPF do Discente" required>
                <span class="error" id="cpfError"></span>

                <label for="matricula">Matricula</label>
                <input type="number" id="matricula" name="matricula" placeholder="Matricula do Discente" required>
                <span class="error" id="matriculaError"></span>

                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Email do Discente" required>
                <span class="error" id="emailError"></span>

                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" placeholder="Telefone do Discente" required>
                <span class="error" id="telefoneError"></span>

                <label for="turno">Turno</label>
                <input type="text" id="turno" name="turno" placeholder="Turno do Discente" required>
                <span class="error" id="turnoError"></span>

                <label for="turma">Turma:</label>
                <select id="turma" name="turma" required>
                    <option value="">Selecione uma Turma</option>
                    <?php
                    while ($row = $resultTurma->fetch_assoc()) {
                        echo '<option value="' . $row["id"] . '">' . $row["nome"] . '</option>';
                    }
                    ?>
                </select>
                <span class="error" id="turmaError"></span>

                <button type="submit" class="submit-button">Enviar</button>
                <a class="submit-button" href="main.php">Voltar</a>
            </form>
        </div>
    </div>
</body>

</html>