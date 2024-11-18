<?php
include "../config.php";
include "protect-docente.php";

// Consulta as turmas cadastradas
$sql_atividades = "SELECT * FROM atividade ORDER BY data_upload DESC ";// Mostra até 5 atividades mais recentes
$resultAtividades = $DB->query($sql_atividades);

// Verifica se o usuário foi encontrado
if ($resultAtividades->num_rows <= 0) {
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
    </style>
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
                echo "<li>
                        <span>ID: {$atividade['id']}</span>
                        {$atividade['nome']} ({$atividade['categoria']}) - " . date("d/m/Y ", strtotime($atividade['data_upload'])) . "
                        Status: {$atividade['status']}
                        <a href='valida-atividade.php?id={$atividade['id']}' style='color: #00796b; font-weight: bold; text-decoration: none;'>Selecionar</a>
                      </li>";
            }
            ?>
        </ul>
    </div>
</body>

</html>