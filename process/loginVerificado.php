<?php
include_once("conn.php");
if (!isset($_SESSION["usuario"])) {
    $_SESSION["msg"] = "Você não está logado";
    $_SESSION["status"] = "danger";
    header("Location: ./loginForm.php");
    exit();
}
?>