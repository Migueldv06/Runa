<?php
include "protect-docente.php";
include "config.php";   // Inclui a conexão com o banco de dados

// Recupera o ID do usuário da sessão
$id = $_SESSION['id'];

// Consulta as informações do discente
$sql = "SELECT nome, email, matricula, curso, endereco FROM docente WHERE id = '$id'";
$result = $DB->query($sql) or die("Falha na execução do MySQL: " . $DB->error);

// Verifica se o usuário foi encontrado
if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();  // Armazena os dados do usuário em um array
} else {
    echo "Usuário não encontrado.";
    exit();
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
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        .main-content {
            display: flex;
            flex-direction: row;
            margin-top: 80px; /* Espaço para o cabeçalho fixo */
            padding: 20px;
            gap: 20px;
        }

        .left-column, .right-column {
            flex: 1;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .left-column {
            position: fixed;
            top: 80px;
            left: 20px;
            width: 300px;
        }

        .right-column {
            position: fixed;
            top: 80px;
            right: 20px;
            width: 300px;
        }

        .center-column {
            flex: 2;
            margin-left: 340px; /* Espaço para a coluna esquerda fixa */
            margin-right: 340px; /* Espaço para a coluna direita fixa */
        }

        .ppc {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .ppc h2 {
            color: #00796b;
            margin-bottom: 15px;
        }

        .ppc a, .ppc button {
            display: block;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            text-align: center;
            margin-top: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .ppc a {
            background-color: #00796b;
            color: #ffffff;
            text-decoration: none;
        }

        .ppc a:hover {
            background-color: #004b49;
        }

        .ppc button {
            background-color: #00796b;
            color: #ffffff;
            border: none;
        }

        .ppc button:hover {
            background-color: #004b49;
        }

        .user-info {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            position: sticky;
            top: 80px;
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

        .turmas-cadastradas, .actions-area, .contact-info {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .turmas-cadastradas h2, .actions-area h2, .contact-info h2 {
            color: #00796b;
            margin-bottom: 15px;
        }

        .turmas-cadastradas ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .turmas-cadastradas li {
            background: #e0f2f1;
            border: 1px solid #b2dfdb;
            border-radius: 8px;
            margin-bottom: 10px;
            padding: 10px;
        }

        .turmas-cadastradas a {
            display: block;
            color: #00796b;
            text-decoration: none;
        }

        .turmas-cadastradas a:hover {
            text-decoration: underline;
        }

        .actions-area button {
            display: block;
            width: 100%;
            background: #00796b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
            text-align: center;
            margin-top: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .actions-area button:hover {
            background-color: #004b49;
        }

        .contact-info p {
            font-size: 16px;
        }

        .contact-info a {
            color: #00796b;
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }

            .left-column, .right-column {
                position: static;
                width: 100%;
                margin: 0;
            }

            .center-column {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="index.php"><img src="img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
        <a href="logout.php" class="logout-button">Sair</a>
    </header>
    
    <div class="main-content">
        <!-- Lado Esquerdo: PPC -->
        <div class="left-column">
            <div class="ppc">
                <h2>Projeto Pedagógico do Curso (PPC)</h2>
                <p>O Projeto Pedagógico do Curso (PPC) é um documento importante que define a estrutura do curso, incluindo objetivos, disciplinas e outras informações relevantes.</p>
                <a href="docs/ppc-regente.pdf" download>Baixar Documento PPC</a>
                <button>Alterar PPC</button>
            </div>
        </div>

        <!-- Lado Central -->
        <div class="center-column">
            <!-- Turmas Cadastradas -->
            <div class="turmas-cadastradas">
                <h2>Turmas Cadastradas</h2>
                <ul>
                    <li><a href="#">Turma A - 2024/1</a></li>
                    <li><a href="#">Turma B - 2024/1</a></li>
                    <li><a href="#">Turma C - 2024/1</a></li>
                </ul>
            </div>

            <!-- Ações Rápidas -->
            <div class="actions-area">
                <h2>Ações</h2>
                <button>Adicionar Seções de Horas Complementares</button>
                <button>Alterar Nome de uma Turma</button>
                <button>Adicionar uma Turma</button>
                <button>Arquivar Turma</button>
            </div>
        </div>

        <!-- Lado Direito: Dados Pessoais e Contato -->
        <div class="right-column">
            <div class="user-info">
                <h2>Dados Pessoais</h2>
                <p><strong>Nome:</strong> <?php echo $usuario['nome']; ?></p>
                <p><strong>Email:</strong> <?php echo $usuario['email']; ?></p>
                <p><strong>Endereço:</strong> <?php echo $usuario['endereco']; ?></p>
                <p><strong>Curso:</strong> <?php echo $usuario['curso']; ?></p>
                <p><strong>Número de Matrícula:</strong> <?php echo $usuario['matricula']; ?></p>
                <a href="editar-dados.php" class="edit-link">Visualizar, Adicionar e/ou Editar Dados Pessoais</a>
            </div>

            <!-- Contato com a Coordenação -->
            <div class="contact-info">
                <h2>Contato com a Coordenação</h2>
                <p>Para qualquer dúvida ou informação adicional, entre em contato com a coordenação pelo e-mail <a href="mailto:coordenacao@institutofederal.edu.br">coordenacao@institutofederal.edu.br</a> ou pelo telefone (11) 1234-5678.</p>
            </div>
        </div>
    </div>
</body>
</html>
