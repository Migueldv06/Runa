<?php
include "protect-docente.php";
include "../config.php";   // Inclui a conexão com o banco de dados

// Recupera o ID do usuário da sessão
$id = $_SESSION['id'];

// Consulta as informações do discente
$sqlDocente = "SELECT docente.nome AS nome_docente, docente.email, docente.matricula, curso.nome AS nome_curso, docente.endereco FROM docente INNER JOIN curso ON docente.curso = curso.id WHERE docente.id = '$id'";
$resultDocente = $DB->query($sqlDocente) or die("Falha na execução do MySQL: " . $DB->error);

// Verifica se o usuário foi encontrado
if ($resultDocente->num_rows > 0) {
    $docente = $resultDocente->fetch_assoc();  // Armazena os dados do usuário em um array
} else {
    echo "Usuário não encontrado.";
    exit();
}

// Consulta as turmas cadastradas
$sqlTurmas = "SELECT turma.id, turma.nome AS turma_nome, curso.nome AS curso_nome 
              FROM turma
              LEFT JOIN curso ON turma.curso = curso.id"; // Relacionando a tabela curso para mostrar o nome do curso
$resultTurmas = $DB->query($sqlTurmas) or die("Falha ao buscar turmas: " . $DB->error);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUNAS - Painel de Controle</title>
    <link rel="stylesheet" href="styles/main.css">
</head>

<body>
    <header class="header">
        <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
        <a href="../logout.php" class="logout-button">Sair</a>
    </header>

    <div class="main-content">
        <!-- Lado Esquerdo: PPC -->
        <div class="left-column">
            <div class="ppc">
                <h2>Projeto Pedagógico do Curso (PPC)</h2>
                <p>O Projeto Pedagógico do Curso (PPC) é um documento importante que define a estrutura do curso,
                    incluindo objetivos, disciplinas e outras informações relevantes.</p>
                <a href="ppc-regente.php">Baixar Documento PPC</a>
                <button>Alterar PPC</button>
            </div>

            <div class="ppc">
                <h2>Gerenciamento de Docentes</h2>
                <a onclick="window.location.href='pre-cadastro-discente.php';">Adicionar Novo Discente</a>
                <a onclick="window.location.href='visualizar-discentes.php';">Visualizar/Editar/Excluir Discentes</a>
            </div>
        </div>

        <!-- Lado Central -->
        <div class="center-column">
            <!-- Turmas Cadastradas -->
            <div class="turmas-cadastradas">
                <h2>Turmas Cadastradas</h2>
                <ul>
                    <?php if ($resultTurmas->num_rows > 0): ?>
                        <?php while ($turma = $resultTurmas->fetch_assoc()): ?>
                            <li>
                                <a href="edita-turma.php?edita_turma_id=<?php echo $turma['id']; ?>">
                                    <?php echo $turma['turma_nome'] . " - " . $turma['curso_nome']; ?>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <li>Nenhuma turma cadastrada.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Ações Rápidas -->
            <div class="actions-area">
                <h2>Ações em Atividades</h2>
                <a href="valida-atividades.php">Validar Atividades Complementares</a>
                <a href="cria-turma.php">Adicionar categorias de Atividades Complementares</a>
            </div>
            <div class="actions-area">
                <h2>Ações em Turmas e Cursos</h2>
                <a href="cria-turma.php">Adicionar uma Turma</a>
                <a href="edita-turma.php">Editar Turma</a>
                <button>Arquivar Turma</button>
                <a href="cria-curso.php">Adicionar um Curso</a>
                <a href="edita-curso.php">Editar Curso</a>
            </div>
        </div>

        <!-- Lado Direito: Dados Pessoais e Contato -->
        <div class="right-column">
            <div class="user-info">
                <h2>Dados Pessoais</h2>
                <p><strong>Nome:</strong> <?php echo $docente['nome_docente']; ?></p>
                <p><strong>Email:</strong> <?php echo $docente['email']; ?></p>
                <p><strong>Endereço:</strong> <?php echo $docente['endereco']; ?></p>
                <p><strong>Curso:</strong> <?php echo $docente['nome_curso']; ?></p>
                <p><strong>Número de Matrícula:</strong> <?php echo $docente['matricula']; ?></p>
                <a href="editar-dados.php" class="edit-link">Visualizar, Adicionar e/ou Editar Dados Pessoais</a>
            </div>

            <!-- Contato com a Coordenação -->
            <div class="contact-info">
                <h2>Contato com a Coordenação</h2>
                <p>Para qualquer dúvida ou informação adicional, entre em contato com a coordenação pelo e-mail <a
                        href="mailto:coordenacao@institutofederal.edu.br">coordenacao@institutofederal.edu.br</a> ou
                    pelo telefone (11) 1234-5678.</p>
            </div>
        </div>
    </div>
</body>

</html>