<?php
include "../config.php";
include "protect-docente.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Consulta a atividade e o nome do discente
    $sql = "SELECT * FROM discente WHERE id = ?";
    $stmt = $DB->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $discente = $result->fetch_assoc();
    } else {
        echo "<script>alert('Usuario não encontrado'); window.location.href='index.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Usuario invalido'); window.location.href='index.php';</script>";
    exit;
}


// Processa a atualização do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $turno = $_POST['turno'];
    $turma = $_POST['turma'];
    $telefone = $_POST['telefone'];

    // Query para atualizar os dados do usuário no banco de dados
    $updateSql = "UPDATE discente SET nome=?, matricula=?, cpf=?, email=?, endereco=?, turno=?, turma=?, telefone=? WHERE id=?";
    $stmt = $DB->prepare($updateSql);
    $stmt->bind_param("sissssssi", $nome, $matricula, $cpf, $email, $endereco, $turno, $turma, $telefone, $id);

    if ($stmt->execute()) {
        echo "<p>Dados atualizados com sucesso!</p>";
        // Atualiza os dados exibidos sem recarregar a página
        header("Refresh:0");
    } else {
        echo "<p>Erro ao atualizar os dados.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cadastro do Discente - RUNAS</title>
    <link rel="stylesheet" href="styles/editar-discente.css">
</head>

<body>
    <header class="header">
        <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <div class="container">
        <div class="form-container">
            <h1>Editar Cadastro do Discente</h1>
            <form id="preCadastroForm" onsubmit="return validateForm()" method="post">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" placeholder="Nome Completo" value="<?php echo $discente['nome'] ?>" required>
                <span class="error" id="nomeError"></span>

                <label for="matricula">Número de Matrícula:</label>
                <input type="number" id="matricula" name="matricula" placeholder="Número de Matrícula" value="<?php echo $discente['matricula'] ?>" required>
                <span class="error" id="matriculaError"></span>

                <label for="cpf">Número de CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="Número de CPF" value="<?php echo $discente['cpf'] ?>" required>
                <span class="error" id="cpfError"></span>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $discente['email'] ?>" required>
                <span class="error" id="emailError"></span>

                <label for="endereco">Endereço:</label>
                <input type="endereco" id="endereco" name="endereco" placeholder="Endereço" value="<?php echo $discente['endereco'] ?>">
                <span class="error" id="enderecoError"></span>

                <label for="turno">Turno:</label>
                <input type="turno" id="turno" name="turno" placeholder="Turno" value="<?php echo $discente['turno'] ?>">
                <span class="error" id="turnoError"></span>

                <label for="turma">Turma:</label>
                <input type="turma" id="turma" name="turma" placeholder="Turma" value="<?php echo $discente['turma'] ?>">
                <span class="error" id="turmaError"></span>

                <label for="telefone">Número de Telefone (Opcional):</label>
                <input type="tel" id="telefone" name="telefone" placeholder="Número de Telefone" value="<?php echo $discente['telefone'] ?>">
                <span class="error" id="telefoneError"></span>

                <button type="submit">Submeter</button>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            let valid = true;

            // Clear previous errors
            document.querySelectorAll('.error').forEach(e => e.textContent = '');

            // Nome
            const nome = document.getElementById('nome').value.trim();
            if (nome === '') {
                document.getElementById('nomeError').textContent = 'O nome completo é obrigatório.';
                valid = false;
            }

            // Matrícula
            const matricula = document.getElementById('matricula').value.trim();
            if (matricula === '') {
                document.getElementById('matriculaError').textContent = 'O número de matrícula é obrigatório.';
                valid = false;
            }

            // CPF
            const cpf = document.getElementById('cpf').value.trim();
            if (cpf === '') {
                document.getElementById('cpfError').textContent = 'O número de CPF é obrigatório.';
                valid = false;
            }

            // Email
            const email = document.getElementById('email').value.trim();
            if (email === '') {
                document.getElementById('emailError').textContent = 'O email é obrigatório.';
                valid = false;
            } else if (!validateEmail(email)) {
                document.getElementById('emailError').textContent = 'O email fornecido não é válido.';
                valid = false;
            }

            // Telefone (opcional)
            const telefone = document.getElementById('telefone').value.trim();
            if (telefone !== '' && !validatePhone(telefone)) {
                document.getElementById('telefoneError').textContent = 'O número de telefone fornecido não é válido.';
                valid = false;
            }

            return valid;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^\d{10,11}$/; // Exemplo de validação para números de telefone (10 ou 11 dígitos)
            return re.test(phone);
        }
    </script>
</body>

</html>