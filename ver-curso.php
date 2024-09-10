<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização e Edição de Cursos</title>
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
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
            width: 100%;
        }

        .container h1 {
            color: #00796b;
            margin-bottom: 20px;
            text-align: center;
        }

        .course-info {
            margin-bottom: 20px;
        }

        .course-info label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            color: #00796b;
        }

        .course-info p {
            font-size: 16px;
            margin-bottom: 15px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            color: #00796b;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #b2dfdb;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .form-group input:focus, .form-group textarea:focus {
            border-color: #00796b;
            outline: none;
        }

        .form-group textarea {
            resize: vertical;
            height: 100px;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .buttons button {
            background-color: #00796b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .buttons button:hover {
            background-color: #004b49;
        }

        .buttons a {
            display: inline-block;
            text-decoration: none;
            color: #00796b;
            background-color: #e0f2f1;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            line-height: 1;
            text-align: center;
            transition: background-color 0.3s;
        }

        .buttons a:hover {
            background-color: #b2dfdb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Visualização e Edição de Cursos</h1>
        
        <!-- Seção de Informações do Curso -->
        <div class="course-info">
            <label for="course-name">Nome do Curso:</label>
            <p id="course-name">Engenharia de Computação</p>
            <label for="course-code">Código do Curso:</label>
            <p id="course-code">EC123</p>
            <label for="course-description">Descrição:</label>
            <p id="course-description">Curso voltado para o desenvolvimento de habilidades em computação, programação e sistemas.</p>
        </div>
        
        <!-- Formulário de Edição de Curso -->
        <form action="processar-edicao-curso.php" method="post">
            <div class="form-group">
                <label for="edit-course-name">Nome do Curso:</label>
                <input type="text" id="edit-course-name" name="course_name" value="Engenharia de Computação" required>
            </div>
            <div class="form-group">
                <label for="edit-course-code">Código do Curso:</label>
                <input type="text" id="edit-course-code" name="course_code" value="EC123" required>
            </div>
            <div class="form-group">
                <label for="edit-course-description">Descrição:</label>
                <textarea id="edit-course-description" name="course_description" required>Curso voltado para o desenvolvimento de habilidades em computação, programação e sistemas.</textarea>
            </div>
            <div class="buttons">
                <button type="submit">Salvar Alterações</button>
                <a href="index.php">Voltar</a>
            </div>
        </form>
    </div>
</body>
</html>
