<?php
include "protect-discente.php";
include "../config.php";   // Inclui a conexão com o banco de dados

// Recupera o ID do usuário da sessão
$id = $_SESSION['id'];

// Consulta as informações do discente
$sqlDiscente = "SELECT nome, email, matricula, turma, turno, endereco FROM discente WHERE id = '$id'";
$resultDiscenteDiscente = $DB->query($sqlDiscente) or die("Falha na execução do MySQL: " . $DB->error);

// Verifica se o usuário foi encontrado
if ($resultDiscenteDiscente->num_rows >= 0) {
    $discente = $resultDiscenteDiscente->fetch_assoc();  // Armazena os dados do usuário em um array
    list($primeiro_nome, $sobre_nome) = explode(" ", $discente["nome"],2);
} else {
    echo "Usuário não encontrado.";
    exit();
}

// Consulta as turmas cadastradas
$sql_atividades = "SELECT id, nome, categoria, data_upload 
                           FROM atividade 
                           WHERE discente_id = '$id' 
                           ORDER BY data_upload DESC 
                           LIMIT 5"; // Mostra até 5 atividades mais recentes
$resultAtividades = $DB->query($sql_atividades);

// Soma total das horas das atividades do discente
$sqlTotalHoras = "SELECT SUM(horas_atividade) AS total_horas FROM atividade WHERE discente_id = '$id' and status = '2'";
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
    $curso_id = $rowTurma['curso']; // Obtém o ID do curso

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
        <!-- Lado Esquerdo: Download do PPC -->
        <div class="left-column">
            <div class="ppc">
                <h2>Projeto Pedagógico do Curso (PPC)</h2>
                <p>O Projeto Pedagógico do Curso (PPC) é um documento importante que define a estrutura do curso,
                    incluindo objetivos, disciplinas e outras informações relevantes.</p>
                <p>Para visualizar o PPC atual, consulte o documento disponibilizado.</p>
                <p>Se precisar fazer alterações ou enviar novos documentos, entre em contato com a coordenação.</p>
                <a href="docs/ppc-regente.pdf" class="download-button" download>Baixar Documento PPC</a>
            </div>
        </div>

        <!-- Lado Central -->
        <div class="center-column">
            <!-- Mensagem de Boas-Vindas -->
            <div class="welcome-message">
                Bem-vindo, <?php echo $primeiro_nome; ?>!
            </div>

            <!-- Barra de Progresso -->
            <div class="progress-container">
                <div class="progress-bar" style="width: <?php echo $progresso; ?>%;">
                    <div class="progress-info"><?php echo round($progresso, 2); ?>%</div>
                </div>
                <div class="progress-details">Horas totais completadas:
                    <?php echo $horas_discente; ?>/<?php echo $meta_horas; ?>
                </div>
            </div>

            <div class="welcome-message">
                <a href="enviar-atividades.php" class="download-button">Enviar Atividades Complementares</a>
            </div>

            <!-- Uploads Recentes -->
            <div class="uploads-recentes">
                <h2>Uploads Recentes</h2>
                <ul>
                    <?php
                    if ($resultAtividades->num_rows > 0) {
                        while ($atividade = $resultAtividades->fetch_assoc()) {
                            echo "<li>
                                    <span>ID: {$atividade['id']}</span>
                                    {$atividade['nome']} ({$atividade['categoria']}) - " . date("d/m/Y", strtotime($atividade['data_upload'])) . "
                                  </li>";
                        }
                    } else {
                        echo "<li>Nenhuma atividade enviada recentemente.</li>";
                    }
                    ?>
                </ul>
            </div>

            <!-- Verificação de Atividades -->
            <div class="verificacao">
                <h2>Verificar Andamento de Avaliação de Atividades Complementares</h2>
                <p>Confira o status das suas atividades complementares e acompanhe o andamento da validação.</p>
                <!-- Adicione informações ou links para verificar o andamento -->
            </div>
            <!-- Verificação de Atividades -->
            <div class="verificacao">
                <h2>Verificar Andamento de Avaliação de Atividades Complementares</h2>
                <p>Confira o status das suas atividades complementares e acompanhe o andamento da validação.</p>
                <!-- Adicione informações ou links para verificar o andamento -->
            </div>
            <!-- Contato com a Coordenação -->
            <div class="contact-info">
                <h2>Contato com a Coordenação</h2>
                <p>Para qualquer dúvida ou informação adicional, entre em contato com a coordenação pelo e-mail <a
                        href="mailto:coordenacao@institutofederal.edu.br">coordenacao@institutofederal.edu.br</a> ou
                    pelo telefone (11) 1234-5678.</p>
            </div>
        </div>

        <!-- Lado Direito: Dados Pessoais -->
        <div class="right-column">
            <div class="user-info">
                <h2>Dados Pessoais</h2>
                <p><strong>Nome:</strong> <?php echo $discente['nome']; ?></p>
                <p><strong>Email:</strong> <?php echo $discente['email']; ?></p>
                <p><strong>Endereço:</strong> <?php echo $discente['endereco']; ?></p>
                <p><strong>Turma:</strong> <?php echo $discente['turma']; ?></p>
                <p><strong>Turno:</strong> <?php echo $discente['turno']; ?></p>
                <p><strong>Número de Matrícula:</strong> <?php echo $discente['matricula']; ?></p>
                <a href="editar-dados.php" class="edit-link">Visualizar, Adicionar e/ou Editar Dados Pessoais</a>
            </div>
        </div>
    </div>
</body>

</html>