<?php
include "config.php";
session_start();
if (isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] == 'discente') {
        header("Location: discente/main.php");
        exit();
    } elseif ($_SESSION['tipo'] == 'docente') {
        header("Location: docente/main.php");
        exit();
    }
}
if (isset($_POST["email"]) && isset($_POST["senha"])) {
    if (strlen($_POST["email"]) == 0) {
        echo "Preencha seu E-mail";
    } elseif (strlen($_POST["senha"]) == 0) {
        echo "Preencha sua Senha";
    } else {
        $email = $DB->real_escape_string($_POST["email"]);
        $senha = $DB->real_escape_string($_POST["senha"]);

        // Verifica na tabela de discente
        $sql_code_discente = "SELECT * FROM discente WHERE email='$email' AND senha='$senha'";
        $result_discente = $DB->query($sql_code_discente) or die("falha na execução do mysql: " . $DB->error);

        // Verifica na tabela de docente
        $sql_code_docente = "SELECT * FROM docente WHERE email='$email' AND senha='$senha'";
        $result_docente = $DB->query($sql_code_docente) or die("falha na execução do mysql: " . $DB->error);

        if ($result_discente->num_rows == 1) {
            $usuario = $result_discente->fetch_assoc();
            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo'] = 'discente';

            header("Location: discente/main.php");
            exit();
        } elseif ($result_docente->num_rows == 1) {
            $usuario = $result_docente->fetch_assoc();
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo'] = 'docente';

            header("Location: docente/main.php"); // Redireciona para a tela de docentes
            exit(); // Para o script após o redirecionamento
        } else {
            echo "Falha ao logar, email ou senha errados";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>RUNAS - Login</title>
<link rel="stylesheet" href="styles/index.css">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <img src="img/Runa.png" alt="Logo Runas" class="logo">
            <h1>Login</h1>
            <p class="subtitle">Acesse sua conta ou <a href="criar-validar.php">crie uma nova</a></p>
            <form action="" method="post">
                <input type="text" name="email" id="email" placeholder="E-mail">
                <input type="password" name="senha" id="senha" placeholder="Senha">
                <button type="submit">Entrar</button>
                <a href="esqueci-senha.php">Esqueci minha senha</a>
            </form>
        </div>
    </div>
</body>

</html>