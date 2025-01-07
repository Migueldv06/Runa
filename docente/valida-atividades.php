<?php
include "../config.php";
include "protect-docente.php";

// Consulta as turmas cadastradas
$sql_atividades = "SELECT * FROM atividade ORDER BY data_upload DESC ";
$resultAtividades = $DB->query($sql_atividades);

// Verifica se o usuário foi encontrado
if ($resultAtividades->num_rows <= 0) {
    echo "Atividades no Sistema.";
    exit();
}
function StatusAtividade($atividade_status)
{
    switch ($atividade_status) {
        case 1:
            $result = "Pendente";
            return $result;
        case 2:
            $result = "Validada";
            return $result;
        case 3:
            $result = "Invalidada";
            return $result;
        default:
            $result = "";
            return $result;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Turma - RUNAS</title>
    <link rel="stylesheet" href="styles/valida-atividades.css">
</head>

<body>
    <header class="header">
        <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <!-- Uploads Recentes -->
    <div class="uploads-recentes">
        <h2>Atividades</h2>
        <ul>
            <?php
            while ($atividade = $resultAtividades->fetch_assoc()) {
                $atividade_status = $atividade['status'];
                $status = StatusAtividade($atividade_status);
                echo "<li>
                        <span>ID: {$atividade['id']}</span>
                        {$atividade['nome']} ({$atividade['categoria']}) - " . date("d/m/Y ", strtotime($atividade['data_upload'])) . "
                        Status: $status
                        <a href='valida-atividade.php?id={$atividade['id']}' style='color: #00796b; font-weight: bold; text-decoration: none;'>Selecionar</a>
                      </li>";
            }
            ?>
        </ul>
    </div>
</body>

</html>