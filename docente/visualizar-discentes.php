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
    <title>Criar Turma - SiVAC</title>
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
            while ($discente = $resultDiscente->fetch_assoc()) {;
                echo "<li>
                        <span>ID: {$discente['id']}</span>
                        {$discente['nome']} - " . "
                        <a href='alterar-discente.php?id={$discente['id']}' style='color: #00796b; font-weight: bold; text-decoration: none;'>Alterar</a>
                      </li>";
            }
            ?>
        </ul>
    </div>
</body>

</html>