<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle - Gestão de Docentes</title>
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

        .pre-cadastro, .docentes-turmas {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .pre-cadastro h2, .docentes-turmas h2 {
            color: #00796b;
            margin-bottom: 15px;
        }

        .pre-cadastro button, .docentes-turmas a {
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

        .pre-cadastro button {
            background-color: #00796b;
            color: #ffffff;
        }

        .pre-cadastro button:hover {
            background-color: #004b49;
        }

        .docentes-turmas a {
            background-color: #e0f2f1;
            color: #00796b;
            text-decoration: none;
            border: 1px solid #b2dfdb;
        }

        .docentes-turmas a:hover {
            background-color: #b2dfdb;
        }

        .docentes-turmas ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .docentes-turmas li {
            margin-bottom: 10px;
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
        <a href="index.php"><img src="img/logo-instituto-federal.png" alt="Logo Instituto Federal" class="logo"></a>
        <div class="title">Projeto RUNAS</div>
        <a href="index.php" class="logout-button">Sair</a>
    </header>
    
    <div class="main-content">
        <!-- Lado Esquerdo: Navegação -->
        <div class="left-column">
            <div class="pre-cadastro">
                <h2>Gerenciamento de Docentes</h2>
                <button onclick="window.location.href='pre-cadastro-docente.php';">Adicionar Novo Docente</button>
                <button onclick="window.location.href='alterar-docente.php';">Alterar Dados de Docente</button>
                <button onclick="window.location.href='excluir-docente.php';">Excluir Docente</button>
                <button onclick="window.location.href='visualizar-docentes.php';">Visualizar Docentes</button>
            </div>
        </div>

        <!-- Lado Central: Relação de Docentes e Turmas -->
        <div class="center-column">
            <div class="docentes-turmas">
                <h2>Docentes e suas Turmas de Referência</h2>
                <ul>
                    <li><a href="#">Prof. Ana Silva - Turma A - 2024/1</a></li>
                    <li><a href="#">Prof. João Oliveira - Turma B - 2024/1</a></li>
                    <li><a href="#">Prof. Maria Souza - Turma C - 2024/1</a></li>
                    <!-- Adicione mais docentes e turmas conforme necessário -->
                </ul>
            </div>
        </div>

        <!-- Lado Direito: Dados Pessoais e Contato -->
        <div class="right-column">
            <div class="user-info">
                <h2>Dados Pessoais</h2>
                <p><strong>Nome:</strong> Gabriel Correa</p>
                <p><strong>Email:</strong> ixekakaka@institutofederal.edu.br</p>
                <p><strong>Endereço:</strong> Rua Exemplo, 123, Curitobas, PR</p>
                <p><strong>Curso:</strong> Engenharia de Computação</p>
                <p><strong>Número de Matrícula:</strong> 2024123456</p>
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
