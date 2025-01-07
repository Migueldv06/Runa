<?php
include "protect-discente.php";
include "../config.php";   // Inclui a conexão com o banco de dados

// Recupera o ID do usuário da sessão
$id = $_SESSION['id'];

// Consulta as turmas cadastradas
$sql_atividades = "SELECT id, nome, caminho_arquivo, categoria, horas_atividade, status, data_upload
                           FROM atividade 
                           WHERE discente_id = '$id' 
                           ORDER BY data_upload DESC";
$resultAtividades = $DB->query($sql_atividades);
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
    <title>Painel de Controle - RUNAS</title>
    <link rel="stylesheet" href="styles/verificar-atividades.css">
</head>

<body>
    <header class="header">
        <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
        <a href="../logout.php" class="logout-button">Sair</a>
    </header>
    <div class="container">

        <!-- Lado Central -->
        <div class="center-column">
            <!-- Atividades Recentes -->
            <div class="welcome-message">
                <h2>Atividades Enviadas</h2>
            </div>
            <div class="uploads-recentes">
                <ul>
                    <?php
                    if ($resultAtividades->num_rows > 0) {
                        while ($atividade = $resultAtividades->fetch_assoc()) {
                            $atividade_status = $atividade['status'];
                            $status = StatusAtividade($atividade_status);
                            echo "<li>
                                    <span>ID: {$atividade['id']}</span>
                                    {$atividade['nome']} ({$atividade['categoria']}) - " . date("d/m/Y", strtotime($atividade['data_upload'])) . " - Status: $status" . "
                                  </li>";
                        }
                    } else {
                        echo "<li>Nenhuma atividade enviada recentemente.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>