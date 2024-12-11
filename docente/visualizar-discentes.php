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
            while ($discente = $resultDiscente->fetch_assoc()) {
                echo "<li>
                        <span>ID: {$discente['id']}</span>
                        {$discente['nome']} - " . "
                        <a href='visualizar-discente.php?id={$discente['id']}' style='color: #00796b; font-weight: bold; text-decoration: none;'>Visualizar</a>
                        <a href='editar-discente.php?id={$discente['id']}' style='color: #00796b; font-weight: bold; text-decoration: none;'>Editar</a>
                        <a href='excluir-discente.php?id={$discente['id']}' style='color: #00796b; font-weight: bold; text-decoration: none;'>Excluir</a>
                      </li>";
            }
            ?>
        </ul>
    </div>
</body>

</html>