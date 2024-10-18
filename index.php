<?php
include "config.php";
if (isset($_POST["email"]) && isset($_POST["senha"])){
    if(strlen($_POST["email"]) == 0){
        echo "Preencha seu E-mail";
    } elseif (strlen($_POST["senha"]) == 0){
        echo "Preencha sua Senha";
    } else {
        $email = $DB->real_escape_string($_POST["email"]);
        $senha = $DB->real_escape_string($_POST["senha"]);

        $sql_code = "SELECT * FROM discente WHERE email='$email' AND senha='$senha'";
        $DB = $DB->query($sql_code) or die("falha na execução do mysql" - $DB->error);

        $quantidade = $DB->num_rows;

        if ($quantidade == 1){
            $usuario = $DB->fetch_assoc();

            if (isset($_SESSION)){
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: main-aluno.php");
        } else {
            echo "Falha ao logar , email ou senha errados";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema HC - Login</title>
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
