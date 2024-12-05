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
    <title>Painel de Controle - SiVAC</title>
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
            position: relative;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
            height: 80px;
        }

        .logo {
            width: 60px;
        }

        .title {
            font-size: 24px;
            color: #00796b;
            margin-left: 20px;
        }

        .logout-button {
            background: #00796b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 16px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .logout-button:hover {
            background-color: #004b49;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container {
            display: flex;
            flex: 1;
            margin-top: 80px;
            /* Espaço para o cabeçalho fixo */
            padding: 20px;
        }

        .left-column,
        .right-column {
            flex: 1;
            padding: 20px;
        }

        .left-column {
            margin-right: 20px;
        }

        .right-column {
            margin-left: 20px;
        }

        .center-column {
            flex: 2;
        }

        .user-info,
        .ppc {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .user-info img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .user-info h2 {
            margin-bottom: 10px;
            color: #00796b;
            font-size: 24px;
        }

        .user-info p {
            margin-bottom: 8px;
            font-size: 16px;
        }

        .user-info .edit-link {
            display: inline-block;
            margin-top: 10px;
            color: #00796b;
            text-decoration: none;
            font-size: 14px;
        }

        .user-info .edit-link:hover {
            text-decoration: underline;
        }

        .uploads-recentes,
        .verificacao,
        .contact-info {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .uploads-recentes h2,
        .verificacao h2,
        .contact-info h2 {
            color: #00796b;
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: bold;
        }

        .uploads-recentes ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .uploads-recentes li {
            background: #e0f2f1;
            border: 1px solid #b2dfdb;
            border-radius: 8px;
            margin-bottom: 10px;
            padding: 10px;
        }

        .uploads-recentes li span {
            display: block;
            color: #00796b;
            font-weight: bold;
        }

        .verificacao p {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .progress-container {
            background: #e0f2f1;
            border-radius: 8px;
            overflow: hidden;
            margin: 10px 0;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            height: 30px;
            /* Barra mais quadrada */
            background: #00796b;
            width: 60%;
            /* Exemplo de progresso, pode ser ajustado dinamicamente */
            transition: width 0.3s;
            position: relative;
            border-radius: 4px;
            /* Bordas levemente arredondadas */
        }

        .progress-info {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
        }

        .progress-details {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-top: 5px;
        }

        .download-button {
            display: inline-block;
            background: #00796b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 16px;
            text-decoration: none;
            text-align: center;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .download-button:hover {
            background-color: #004b49;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .welcome-message {
            text-align: center;
            margin: 20px 0;
            font-size: 20px;
            font-weight: bold;
            color: #00796b;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left-column,
            .right-column {
                margin: 0;
                margin-bottom: 20px;
            }
        }
    </style>
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