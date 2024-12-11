<?php
include "../config.php";
include "protect-docente.php";

// Carregar cursos
$query_cursos = "SELECT id, nome FROM curso";
$result_cursos = $DB->query($query_cursos) or die("Falha ao carregar cursos: " . $DB->error);

// Atualizar turma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['curso_id'])) {
    $nome = $_POST['nome'];
    $horas_necessarias = $_POST['horas_necessarias'];
    $curso_id = intval($_POST['curso_id']);

    $sql = "UPDATE curso SET nome = ?, horas_necessarias = ? WHERE id = ?";
    $stmt = $DB->prepare($sql);
    $stmt->bind_param("ssi", $nome, $horas_necessarias, $curso_id);

    if ($stmt->execute()) {
        echo "<script>alert('Curso atualizado com sucesso!'); window.location.href='main.php';</script>";
    } else {
        echo "<script>alert('Erro na atualização do Curso.');</script>";
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['curso_id'])) {
    $curso_id = intval($_GET['curso_id']);

    $query = "SELECT * FROM curso WHERE id = ?";
    $stmt = $DB->prepare($query);
    $stmt->bind_param("i", $curso_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $curso = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'id' => $curso['id'],
            'nome' => $curso['nome'],
            'horas_necessarias' => $curso['horas_necessarias'],
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
    <link rel="stylesheet" href="styles/edita-curso.css">
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
                <select id="cursos" name="cursos" onchange="carregacurso(this.value)" required>
                    <option value="">Selecione um curso</option>
                    <?php
                    while ($row = $result_cursos->fetch_assoc()) {
                        echo '<option value="' . $row["id"] . '">' . $row["nome"] . '</option>';
                    }
                    ?>
                </select>

                <div id="campos" style="display: none;">
                    <label for="nome">Nome do Curso:</label>
                    <input type="text" id="nome" name="nome" placeholder="Nome" required>

                    <label for="horas_necessarias">Horas necessarias:</label>
                    <input type="text" id="horas_necessarias" name="horas_necessarias" placeholder="horas necessarias"
                        required>

                    <input type="hidden" id="curso_id" name="curso_id">
                    <button type="submit" class="submit-button">Enviar</button>
                    <a class="submit-button" href="main.php">Voltar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function carregacurso(curso_id) {
            if (curso_id) {
                fetch("?curso_id=" + curso_id)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById("campos").style.display = "block";
                            document.getElementById("nome").value = data.nome;
                            document.getElementById("horas_necessarias").value = data.horas_necessarias;
                            document.getElementById("curso_id").value = data.id;
                        } else {
                            alert("Erro ao carregar dados do curso.");
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