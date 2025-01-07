<?php
include "../config.php";
include "protect-docente.php";

// Consulta as turmas cadastradas
$sql_discente = "SELECT * FROM discente ORDER BY id DESC ";
$resultDiscente = $DB->query($sql_discente);

// Verifica se o usuário foi encontrado
if ($resultDiscente->num_rows <= 0) {
    echo "Atividades no Sistema.";
    exit();
}

function HorasDiscente($id_discente)
{
    global $DB;

    $sql = "SELECT * FROM discente WHERE id = ?";
    $stmt = $DB->prepare($sql);
    $stmt->bind_param("i", $id_discente);
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

        return [
            'horas_discente' => $horas_discente,
            'meta_horas' => $meta_horas,
            'progresso' => $progresso
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Turma - RUNAS</title>
    <link rel="stylesheet" href="styles/visualizar-discentes.css">
</head>

<body>
    <header class="header">
        <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <!-- Uploads Recentes -->
    <div class="uploads-recentes">
        <h2>Discentes</h2>
        <ul>
            <?php
            while ($discente = $resultDiscente->fetch_assoc()) {
                $id_discente = $discente['id'];
                $progress_data = HorasDiscente($id_discente);
                $horas_discente = $progress_data['horas_discente'];
                    $meta_horas = $progress_data['meta_horas'];
                    $progresso = round($progress_data['progresso'],2);
                echo "<li>
                        <span>ID: {$discente['id']}</span>
                        {$discente['nome']} - " . "
                        <a href='visualizar-discente.php?id={$discente['id']}' style='color: #00796b; font-weight: bold; text-decoration: none;'>Visualizar</a> - 
                        <a href='editar-discente.php?id={$discente['id']}' style='color: #00796b; font-weight: bold; text-decoration: none;'>Editar</a> - 
                        <a href='excluir-discente.php?id={$discente['id']}' style='color: #00796b; font-weight: bold; text-decoration: none;'>Excluir</a>
                        <div class=\"progress-container\">
                        <div class='progress-container'>
                            <div class='progress-bar' style='width: {$progresso}%;'></div>
                            <div class='progress-details'>Progresso: {$horas_discente}/{$meta_horas} horas ({$progresso}%)</div>
                        </div>
                      </li>";
            }
            ?>
        </ul>
    </div>
</body>

</html>