<?php
include "../config.php";
include "protect-docente.php";

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


// Processa a atualização do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $deleteSql = "DELETE FROM discente WHERE id=?";
    $stmt = $DB->prepare($deleteSql);
    $stmt->bind_param("i",$id);

    if ($stmt->execute()) {
        echo "<script>alert('Discente excluido'); window.location.href='visualizar-discentes.php';</script>";
    } else {
        echo "<p>Erro ao excluir os dados.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Cadastro do Discente - RUNAS</title>
    <link rel="stylesheet" href="styles/excluir-discente.css">
</head>

<body>
    <header class="header">
        <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <div class="container">
        <div class="form-container">
            <h1>Confirme exclusão</h1>
            <form id="preCadastroForm" onsubmit="return validateForm()" method="post">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" placeholder="Nome Completo" value="<?php echo $discente['nome'] ?>" readonly>
                <span class="error" id="nomeError"></span>

                <label for="email">Email:</label>
                <input type="text" id="email" name="email" placeholder="email" value="<?php echo $discente['email'] ?>" readonly>
                <span class="error" id="emailError"></span>

                <label for="id">Id:</label>
                <input type="text" id="id" name="id" placeholder="id" value="<?php echo $discente['id'] ?>" readonly>
                <span class="error" id="idError"></span>

                <button type="submit">Excluir</button>
                <a href="visualizar-discentes.php">Voltar</a>
            </form>
        </div>
    </div>
</body>

</html>