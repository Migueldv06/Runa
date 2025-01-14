<?php
include "../config.php";
include "protect-docente.php";

$id = $_SESSION['id'];
$sql = "SELECT * FROM docente WHERE id='$id'";
$result = $DB->query($sql) or die("Falha na execução do MySQL: " . $DB->error);

// Verifica se o usuário foi encontrado
if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();  // Armazena os dados do usuário em um array
} else {
    echo "Usuário não encontrado.";
    exit();
}

// Processa a atualização do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $matricula = $_POST['matricula'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $curso = $_POST['curso'];
    $telefone = $_POST['telefone'];

    // Query para atualizar os dados do usuário no banco de dados
    $updateSql = "UPDATE docente SET nome=?, matricula=?, cpf=?, email=?, endereco=?, curso=?, telefone=? WHERE id=?";
    $stmt = $DB->prepare($updateSql);
    $stmt->bind_param("sisssssi", $nome, $matricula, $cpf, $email, $endereco, $curso, $telefone, $id);

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
    <title>Editar Cadastro do Docente - RUNAS</title>
    <link rel="stylesheet" href="styles/editar-dados.css">
</head>
<body>
    <header class="header">
        <a href="../index.php"><img src="../img/Runa-noname.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <div class="container">
        <div class="form-container">
            <h1>Editar Cadastro do Docente</h1>
            <form id="preCadastroForm" onsubmit="return validateForm()" method="post">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" placeholder="Nome Completo" value="<?php echo $usuario['nome'] ?>" required>
                <span class="error" id="nomeError"></span>

                <label for="matricula">Número de Matrícula:</label>
                <input type="number" id="matricula" name="matricula" placeholder="Número de Matrícula" value="<?php echo $usuario['matricula'] ?>" required>
                <span class="error" id="matriculaError"></span>

                <label for="cpf">Número de CPF:</label>
                <input type="text" id="cpf" name="cpf" placeholder="Número de CPF" value="<?php echo $usuario['cpf'] ?>" required>
                <span class="error" id="cpfError"></span>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $usuario['email'] ?>" required>
                <span class="error" id="emailError"></span>

                <label for="endereco">Endereço:</label>
                <input type="endereco" id="endereco" name="endereco" placeholder="Endereço" value="<?php echo $usuario['endereco'] ?>">
                <span class="error" id="enderecoError"></span>

                <label for="curso">Curso:</label>
                <input type="curso" id="curso" name="curso" placeholder="curso" value="<?php echo $usuario['curso'] ?>">
                <span class="error" id="cursoError"></span>

                <label for="telefone">Número de Telefone (Opcional):</label>
                <input type="tel" id="telefone" name="telefone" placeholder="Número de Telefone" value="<?php echo $usuario['telefone'] ?>">
                <span class="error" id="telefoneError"></span>

                <button type="submit" class="submit-button">Enviar</button>
                <a class="submit-button" href="main.php">Voltar</a>
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
