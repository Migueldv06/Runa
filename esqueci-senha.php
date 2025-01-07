<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUNAS - Esqueci a Senha</title>
    <link rel="stylesheet" href="styles/esqueci-senha.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <a href="index.php"><img src="img/Runa.png" alt="Logo Runas" class="logo"></a>
            <h1>Esqueci a Senha</h1>
            <p>Para redefinir sua senha, insira o e-mail associado à sua conta. Você receberá um link para criar uma nova senha.</p>
            <form action="enviar-link-de-redefinicao.php" method="post">
                <input type="email" name="email" id="email" placeholder="E-mail" required>
                <button type="submit">Enviar Link de Redefinição</button>
                <a href="index.php">Voltar para o Login</a>
            </form>
        </div>
    </div>
</body>
</html>
