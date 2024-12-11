<?php
include "../config.php";
include "protect-docente.php";

// Carregar todas as turmas
$sql_turmas = "SELECT id, nome FROM turma";
$result_turmas = $DB->query($sql_turmas) or die("Falha na execução do MySQL: " . $DB->error);

// Carregar cursos
$query_cursos = "SELECT id, nome FROM curso";
$result_cursos = $DB->query($query_cursos) or die("Falha ao carregar cursos: " . $DB->error);

// Atualizar turma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['turma_id'])) {
    $nome = $_POST['nome'];
    $curso = intval($_POST['curso']);
    $turma_id = intval($_POST['turma_id']);

    $sql = "UPDATE turma SET nome = ?, curso = ? WHERE id = ?";
    $stmt = $DB->prepare($sql);
    $stmt->bind_param("sii", $nome, $curso, $turma_id);

    if ($stmt->execute()) {
        echo "<script>alert('Turma atualizada com sucesso!'); window.location.href='main.php';</script>";
    } else {
        echo "<script>alert('Erro na atualização da turma.');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['turma_id'])) {
    $turma_id = intval($_GET['turma_id']);

    $query = "
        SELECT turma.id, turma.nome, curso.nome AS curso_nome, curso.id AS curso_id
        FROM turma 
        JOIN curso ON turma.curso = curso.id 
        WHERE turma.id = ?
    ";
    $stmt = $DB->prepare($query);
    $stmt->bind_param("i", $turma_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $turma = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'id' => $turma['id'],
            'nome' => $turma['nome'],
            'curso' => $turma['curso_id']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Turma - SiVAC</title>
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

        .form-container input[type="text"],
        .form-container select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #333;
        }

        .submit-button {
            background: #00796b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 15px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .submit-button:hover {
            background-color: #004b49;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            <h1>Editar Turma</h1>
            <form id="EditaTurmaForm" method="post">
                <select id="turmas" name="turmas" onchange="carregaturma(this.value)" required>
                    <option value="">Selecione uma turma</option>
                    <?php
                    while ($row = $result_turmas->fetch_assoc()) {
                        echo '<option value="' . $row["id"] . '">' . $row["nome"] . '</option>';
                    }
                    ?>
                </select>

                <div id="campos" style="display: none;">
                    <label for="nome">Nome da Turma:</label>
                    <input type="text" id="nome" name="nome" placeholder="Nome" required>

                    <label for="cursos">Curso:</label>
                    <select id="cursos" name="curso" required>
                        <option value="">Selecione um Curso</option>
                        <?php
                        while ($row = $result_cursos->fetch_assoc()) {
                            echo '<option value="' . $row["id"] . '">' . $row["nome"] . '</option>';
                        }
                        ?>
                    </select>

                    <input type="hidden" id="turma_id" name="turma_id">
                    <button type="submit" class="submit-button">Enviar</button>
                    <a class="submit-button" href="main.php">Voltar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function carregaturma(turma_id) {
            if (turma_id) {
                fetch("?turma_id=" + turma_id)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById("campos").style.display = "block";
                            document.getElementById("nome").value = data.nome;
                            document.getElementById("cursos").value = data.curso;
                            document.getElementById("turma_id").value = data.id;
                        } else {
                            alert("Erro ao carregar dados da turma.");
                        }
                    })
                    .catch(error => console.error("Erro:", error));
            } else {
                document.getElementById("campos").style.display = "none";
            }
        }
    </script>
</body>

</html>