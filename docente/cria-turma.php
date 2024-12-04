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
            flex: 1;
            flex-direction: column;
            margin: 20px;
        }

        .form-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
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

        .form-container input[type="nome"],
        .form-container select[id="curso"] {
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
    </style>
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

                <button type="submit">Submeter</button>
                <a href="main.php">Voltar</a>
            </form>
        </div>
    </div>
</body>

</html>