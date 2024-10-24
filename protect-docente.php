<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    echo '<h2>Você não está logado!</h2>';
    echo '<p>Por favor, faça login para acessar esta página.</p>';
    echo '<a href="index.php" style="padding: 10px 20px; background-color: #00796b; color: white; border-radius: 5px; text-decoration: none;">Entrar</a>';
    exit();
}

// Verificar o tipo de usuário
if ($_SESSION['tipo'] != 'docente') {
    echo 'Você não tem permissão para acessar esta página.';
    exit();
}

?>