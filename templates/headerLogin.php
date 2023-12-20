<?php
include_once("process/conn.php");
$msg = "";
if (isset($_SESSION["msg"])) {
    $msg = $_SESSION["msg"];
    $status = $_SESSION["status"];
    //limpar a msg
    $_SESSION["msg"] = "";
    $_SESSION["status"] = "";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzaria do João</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/pizzaLogo2.png" type="image/x-icon">
</head>
<body class="bodyLogin">
<?php
if ($msg != "") :
?>
    <div class="alert alert-<?= $status ?>">
        <p><?= $msg ?></p>
    </div>
<?php endif ?>