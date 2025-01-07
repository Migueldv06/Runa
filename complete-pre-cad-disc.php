<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_GET['id'];
    $status = 1;

    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $turno = $_POST['turno'];
    $turma = $_POST['turma'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];
    $confSenha = $_POST['confSenha'];

    if ($senha === $confSenha) {
        $updateSql = "UPDATE discente SET nome=?, matricula=?, cpf=?, email=?, endereco=?, turno=?, turma=?, telefone=?, senha=?, status=? WHERE id=?";
        $stmt = $DB->prepare($updateSql);
        $stmt->bind_param("sissssssssi", $nome, $matricula, $cpf, $email, $endereco, $turno, $turma, $telefone, $senha, $status, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Atualização de cadastro concluida!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Erro na atualização de cadastro!');</script>";
        }
    } else {
        echo "<script>alert('As senhas não são iguais!');</script>";
    }
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Consulta a atividade e o nome do discente
    $sql = "SELECT * FROM discente WHERE id = ?";
    $stmt = $DB->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $discente = $result->fetch_assoc();
    } else {
        echo "<script>alert('Usuario não encontrado'); window.location.href='index.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Usuario invalido'); window.location.href='index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cadastro do Discente - RUNAS</title>
    <link rel="stylesheet" href="styles/complete-pre-cad-disc.css">
</head>

<body>
    <header class="header">
        <a href="index.php"><img src="img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <div class="container">
        <div class="form-container">
            <h1>Editar Cadastro do Discente</h1>
            <form id="preCadastroForm" onsubmit="return validateForm()" method="post">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" placeholder="Nome Completo"
                    value="<?php echo $discente['nome'] ?>" required>
                <span class="error" id="nomeError"></span>

                <label for="matricula">Número de Matrícula:</label>
                <input type="number" id="matricula" name="matricula" placeholder="Número de Matrícula"
                    value="<?php echo $discente['matricula'] ?>" required>
                <span class="error" id="matriculaError"></span>

                <label for="cpf">Número de CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="Número de CPF"
                    value="<?php echo $discente['cpf'] ?>" required>
                <span class="error" id="cpfError"></span>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $discente['email'] ?>"
                    required>
                <span class="error" id="emailError"></span>

                <label for="endereco">Endereço:</label>
                <input type="endereco" id="endereco" name="endereco" placeholder="Endereço"
                    value="<?php echo $discente['endereco'] ?>">
                <span class="error" id="enderecoError"></span>

                <label for="turno">Turno:</label>
                <input type="turno" id="turno" name="turno" placeholder="Turno"
                    value="<?php echo $discente['turno'] ?>">
                <span class="error" id="turnoError"></span>

                <label for="turma">Turma:</label>
                <input type="turma" id="turma" name="turma" placeholder="Turma"
                    value="<?php echo $discente['turma'] ?>">
                <span class="error" id="turmaError"></span>

                <label for="telefone">Número de Telefone (Opcional):</label>
                <input type="tel" id="telefone" name="telefone" placeholder="Número de Telefone"
                    value="<?php echo $discente['telefone'] ?>">
                <span class="error" id="telefoneError"></span>

                <label for="senha">Senha:</label>
                <input type="senha" id="senha" name="senha" placeholder="senha">
                <span class="error" id="senhaError"></span>

                <label for="confSenha">Repita a Senha:</label>
                <input type="confSenha" id="confSenha" name="confSenha" placeholder="repita a senha">
                <span class="error" id="confSenhaError"></span>

                <button type="submit">Submeter</button>
            </form>
        </div>
    </div>
</body>

</html>