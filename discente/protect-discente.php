<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SESSION['tipo'] != 'discente') {
    header("Location: ../index.php");
    exit();
}

?>