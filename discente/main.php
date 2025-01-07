<?php
include "protect-discente.php";
include "../config.php";   // Inclui a conexão com o banco de dados

// Recupera o ID do usuário da sessão
$id = $_SESSION['id'];

// Consulta as informações do discente
$sqlDiscente = "SELECT discente.nome AS nome_discente, discente.email, discente.matricula, discente.turma, turma.nome AS nome_turma, discente.turno, discente.endereco FROM discente INNER JOIN turma ON discente.turma = turma.id WHERE discente.id = '$id'";
$resultDiscente = $DB->query($sqlDiscente) or die("Falha na execução do MySQL: " . $DB->error);

// Verifica se o usuário foi encontrado
if ($resultDiscente->num_rows >= 0) {
    $discente = $resultDiscente->fetch_assoc();  // Armazena os dados do usuário em um array
    list($primeiro_nome, $sobre_nome) = explode(" ", $discente["nome_discente"], 2);
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
    <title>Painel de Controle - RUNAS</title>
    <link rel="stylesheet" href="styles/main.css">
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
                <a href="ppc-regente.php" class="download-button">Baixar Documento PPC</a>
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
                <h2>Enviar Atividades Complementares</h2>
                <p>Envie novas atividades complementares por <a href="enviar-atividades.php">aqui</a></p>
                <!-- Adicione informações ou links para verificar o andamento -->
            </div>
            <!-- Verificação de Atividades -->
            <div class="verificacao">
                <h2>Verificar Andamento de Avaliação de Atividades Complementares</h2>
                <p>Confira o status das suas atividades complementares e acompanhe o andamento da validação por <a
                        href="verificar-atividades.php">aqui</a></p>
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
                <p><strong>Nome:</strong> <?php echo $discente['nome_discente']; ?></p>
                <p><strong>Email:</strong> <?php echo $discente['email']; ?></p>
                <p><strong>Endereço:</strong> <?php echo $discente['endereco']; ?></p>
                <p><strong>Turma:</strong> <?php echo $discente['nome_turma']; ?></p>
                <p><strong>Turno:</strong> <?php echo $discente['turno']; ?></p>
                <p><strong>Número de Matrícula:</strong> <?php echo $discente['matricula']; ?></p>
                <a href="editar-dados.php" class="edit-link">Visualizar, Adicionar e/ou Editar Dados Pessoais</a>
            </div>
        </div>
    </div>
</body>

</html>