<?php
$servername = "localhost";
$username = "runas";
$password = "#Migueldv1";
$dbname = "runas";

// Criar conexão
$DB = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($DB->connect_error) {
    die("Conexão falhou: " . $DB->connect_error);
}
?>
