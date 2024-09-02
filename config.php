<?php
$servername = "localhost";
$username = "Runa";
$password = "#Migueldv1";
$dbname = "sistema_hc";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
?>