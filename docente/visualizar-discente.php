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
        $discente_id = $discente["id"];

        // Soma total das horas das atividades do discente
        $sqlTotalHoras = "SELECT SUM(horas_atividade) AS total_horas FROM atividade WHERE discente_id = '$discente_id' and status = '2'";
        $resultTotalHoras = $DB->query($sqlTotalHoras);

        // Verifica o resultado e armazena o total
        if ($resultTotalHoras && $row = $resultTotalHoras->fetch_assoc()) {
            $horas_discente = $row['total_horas'] ?? 0; // Se null, define como 0
        } else {
            $horas_discente = 0; // Em caso de erro ou sem registros
        }

        $turma_id = $discente['turma'];
        // Consulta para obter o curso relacionado à turma
        $sql_turma = "SELECT curso FROM turma WHERE id = $turma_id";
        $resultTurma = $DB->query($sql_turma) or die("Falha na execução do MySQL: " . $DB->error);

        if ($resultTurma && $rowTurma = $resultTurma->fetch_assoc()) {
            $curso_id = $rowTurma['curso'];

            // Consulta para obter as horas necessárias do curso
            $sql_curso = "SELECT horas_necessarias FROM curso WHERE id = '$curso_id'";
            $resultCurso = $DB->query($sql_curso) or die("Falha na execução do MySQL: " . $DB->error);

            if ($resultCurso && $rowCurso = $resultCurso->fetch_assoc()) {
                $meta_horas = $rowCurso['horas_necessarias']; // Define a meta de horas
            } else {
                die("Não foi possível obter as horas necessárias para o curso.");
            }
        } else {
            die("Não foi possível obter o curso da turma.");
        }

        $progresso = min(100, ($horas_discente / $meta_horas) * 100); // Limita o progresso a 100%


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
    <title>Visualizar Discente - RUNAS</title>
    <link rel="stylesheet" href="styles/visualizar-discente.css">
</head>

<body>
    <header class="header">
        <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <div class="container">
        <div class="form-container">
            <h1>Editar Cadastro do Discente</h1>

            <div class="progress-container">
                <div class="progress-bar" style="width: <?php echo $progresso; ?>%;">
                    <div class="progress-info"><?php echo round($progresso, 2); ?>%</div>
                </div>
                <div class="progress-details">Horas totais completadas:
                    <?php echo $horas_discente; ?>/<?php echo $meta_horas; ?>
                </div>
            </div>

            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" placeholder="Nome Completo" value="<?php echo $discente['nome'] ?>"
                readonly>

            <label for="matricula">Número de Matrícula:</label>
            <input type="number" id="matricula" name="matricula" placeholder="Número de Matrícula"
                value="<?php echo $discente['matricula'] ?>" readonly>

            <label for="cpf">Número de CPF:</label>
            <input type="text" id="cpf" name="cpf" placeholder="Número de CPF" value="<?php echo $discente['cpf'] ?>"
                readonly>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $discente['email'] ?>"
                readonly>

            <label for="endereco">Endereço:</label>
            <input type="endereco" id="endereco" name="endereco" placeholder="Endereço"
                value="<?php echo $discente['endereco'] ?>" readonly>

            <label for="turno">Turno:</label>
            <input type="turno" id="turno" name="turno" placeholder="Turno" value="<?php echo $discente['turno'] ?>"
                readonly>

            <label for="turma">Turma:</label>
            <input type="turma" id="turma" name="turma" placeholder="Turma" value="<?php echo $discente['turma'] ?>"
                readonly>

            <label for="telefone">Número de Telefone (Opcional):</label>
            <input type="tel" id="telefone" name="telefone" placeholder="Número de Telefone"
                value="<?php echo $discente['telefone'] ?>" readonly>

            <a href="visualizar-discentes.php">Voltar</a>

        </div>
    </div>
</body>

</html>