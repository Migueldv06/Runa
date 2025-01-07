<?php
include "../config.php";
include "protect-discente.php";

$id = $_SESSION['id'];
$sql = "SELECT * FROM discente WHERE id='$id'";
$result = $DB->query($sql) or die("Falha na execução do MySQL: " . $DB->error);

$sqlTurmas = "SELECT * FROM turma";
$resultTurmas = $DB->query($sqlTurmas) or die("Falha na execução do MySQL: " . $DB->error);

// Verifica se o usuário foi encontrado
if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();  // Armazena os dados do usuário em um array
} else {
    echo "Usuário não encontrado.";
    exit();
}

// Processa a atualização do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $turno = $_POST['turno'];
    $turma = $_POST['turma'];
    $telefone = $_POST['telefone'];

    // Query para atualizar os dados do usuário no banco de dados
    $updateSql = "UPDATE discente SET nome=?, matricula=?, cpf=?, email=?, endereco=?, turno=?, turma=?, telefone=? WHERE id=?";
    $stmt = $DB->prepare($updateSql);
    $stmt->bind_param("sissssssi", $nome, $matricula, $cpf, $email, $endereco, $turno, $turma, $telefone, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Dados Atualizados com sucesso!'); window.location.href='main.php';</script>";
    } else {
        echo "<script>alert('Erro na Atualização de dados!'); window.location.href='main.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cadastro do Discente - RUNAS</title>
    <link rel="stylesheet" href="styles/editar-dados.css">
</head>

<body>
    <header class="header">
        <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <div class="container">
        <div class="form-container">
            <h1>Editar Cadastro do Discente</h1>
            <form id="preCadastroForm" method="post">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" placeholder="Nome Completo"
                    value="<?php echo $usuario['nome'] ?>" required>
                <span class="error" id="nomeError"></span>

                <label for="matricula">Número de Matrícula:</label>
                <input type="number" id="matricula" name="matricula" placeholder="Número de Matrícula"
                    value="<?php echo $usuario['matricula'] ?>" required>
                <span class="error" id="matriculaError"></span>

                <label for="cpf">Número de CPF:</label>
                <input type="number" id="cpf" name="cpf" placeholder="Número de CPF"
                    value="<?php echo $usuario['cpf'] ?>" required>
                <span class="error" id="cpfError"></span>

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" placeholder="Email" value="<?php echo $usuario['email'] ?>"
                    required>
                <span class="error" id="emailError"></span>

                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" placeholder="Endereço"
                    value="<?php echo $usuario['endereco'] ?>">
                <span class="error" id="enderecoError"></span>

                <label for="turno">Turno:</label>
                <input type="text" id="turno" name="turno" placeholder="Turno" value="<?php echo $usuario['turno'] ?>">
                <span class="error" id="turnoError"></span>

                <label for="turma">Turma:</label>
                <select type="select" id="turma" name="turma" required>
                    <option value="">Selecione uma Turma</option>
                    <?php
                    while ($row = $resultTurmas->fetch_assoc()) {
                        if ($row['id'] == $usuario['turma']) {
                            echo '<option value="' . $row["id"] . '" selected>' . $row["nome"] . '</option>';
                        } else {
                            echo '<option value="' . $row["id"] . '">' . $row["nome"] . '</option>';
                        }
                    }
                    ?>
                </select>
                <span class="error" id="turmaError"></span>

                <label for="telefone">Número de Telefone (Opcional):</label>
                <input type="number" id="telefone" name="telefone" placeholder="Número de Telefone"
                    value="<?php echo $usuario['telefone'] ?>">
                <span class="error" id="telefoneError"></span>

                <button type="submit" class="submit-button">Enviar</button>
                <a class="submit-button" href="main.php">Voltar</a>
            </form>
        </div>
    </div>
</body>

</html>