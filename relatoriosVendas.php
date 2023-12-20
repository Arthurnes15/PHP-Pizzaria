<?php
include_once("process/conn.php");
$consultMedVends = $conn->prepare("SELECT 
DATE_FORMAT(dataHora, '%Y-%m') AS mêsVendas,
SUM(
    (SELECT SUM(sabores.preco) / COUNT(pizza_sabor.sabor_id)
    FROM pizza_sabor
    JOIN sabores ON pizza_sabor.sabor_id = sabores.id
    WHERE pizza_sabor.pizza_id = pizzas.id)
) AS valorMedMes
FROM pedidos
JOIN pizzas ON pedidos.pizza_id = pizzas.id
GROUP BY mêsVendas");
$consultMedVends->execute();        
$medVendas = $consultMedVends->fetchAll(PDO::FETCH_ASSOC);

// Consulta os sabores escolhidos com sua respectiva quantidade, em ordem decrescente.

$consultSaborsVends = $conn->prepare("SELECT s.nome AS saboresVendidos, 
COUNT(ps.sabor_id) AS quantidadeSaboresVendidos 
FROM pizza_sabor AS ps 
JOIN sabores AS s ON ps.sabor_id = s.id 
GROUP BY ps.sabor_id
ORDER BY quantidadeSaboresVendidos DESC;");
$consultSaborsVends->execute();
$numVendas  = $consultSaborsVends->fetchAll(PDO::FETCH_ASSOC);

// Consulta de quais tipos de pizzas mais saem, se for de 1 sabor, 2 sabores, 3 sabores ou mais.

$maioriaPizzas = $conn->prepare("SELECT 
qtdSabores,
COUNT(*) AS total_pizzas
FROM (
SELECT 
    CASE
        WHEN COUNT(DISTINCT sabor_id) = 1 THEN '1 sabor'
        WHEN COUNT(DISTINCT sabor_id) = 2 THEN '2 sabores'
        WHEN COUNT(DISTINCT sabor_id) = 3 THEN '3 sabores'
        WHEN COUNT(DISTINCT sabor_id) = 4 THEN '4 sabores'
    END AS qtdSabores,
    pizza_id
FROM pizza_sabor
GROUP BY pizza_id
) AS pizzas_agrupadas
GROUP BY qtdSabores;");
$maioriaPizzas->execute();
$tiposPizzasFeitos = $maioriaPizzas->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzaria do João</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!---BOOTSTRAP--->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!--- font awesome--->
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/pizzaLogo2.png" type="image/x-icon">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg" id="idNavRelat">
            <div class="container-fluid">
                <img src="img/pizzaLogo2.png" alt="pizzaLogo" height="100px">
                <a class="navbar-brand text-light" href="index.php" id="h1Header">Pizzaria do João</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active text-light " aria-current="page" href="index.php"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-journal-arrow-up" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 11a.5.5 0 0 0 .5-.5V6.707l1.146 1.147a.5.5 0 0 0 .708-.708l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L7.5 6.707V10.5a.5.5 0 0 0 .5.5z" />
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                                </svg> Pedidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-light " href="dashboard.php"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-menu-down" viewBox="0 0 16 16">
                                    <path d="M7.646.146a.5.5 0 0 1 .708 0L10.207 2H14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h3.793L7.646.146zM1 7v3h14V7H1zm14-1V4a1 1 0 0 0-1-1h-3.793a1 1 0 0 1-.707-.293L8 1.207l-1.5 1.5A1 1 0 0 1 5.793 3H2a1 1 0 0 0-1 1v2h14zm0 5H1v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2zM2 4.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z" />
                                </svg> Controle dos pedidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-light " href="cadastroSabor.php"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                </svg> Cadastrar Sabores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-light " href="dashboard2.php"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                                </svg> Pedidos entregues</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-light " href="relatoriosVendas.php"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-newspaper" viewBox="0 0 16 16">
                                    <path d="M0 2.5A1.5 1.5 0 0 1 1.5 1h11A1.5 1.5 0 0 1 14 2.5v10.528c0 .3-.05.654-.238.972h.738a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 1 1 0v9a1.5 1.5 0 0 1-1.5 1.5H1.497A1.497 1.497 0 0 1 0 13.5zM12 14c.37 0 .654-.211.853-.441.092-.106.147-.279.147-.531V2.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v11c0 .278.223.5.497.5z" />
                                    <path d="M2 3h10v2H2zm0 3h4v3H2zm0 4h4v1H2zm0 2h4v1H2zm5-6h2v1H7zm3 0h2v1h-2zM7 8h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2z" />
                                </svg> Relatórios</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div id="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1> <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-newspaper" viewBox="0 0 16 16">
                  <path d="M0 2.5A1.5 1.5 0 0 1 1.5 1h11A1.5 1.5 0 0 1 14 2.5v10.528c0 .3-.05.654-.238.972h.738a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 1 1 0v9a1.5 1.5 0 0 1-1.5 1.5H1.497A1.497 1.497 0 0 1 0 13.5zM12 14c.37 0 .654-.211.853-.441.092-.106.147-.279.147-.531V2.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v11c0 .278.223.5.497.5z" />
                  <path d="M2 3h10v2H2zm0 3h4v3H2zm0 4h4v1H2zm0 2h4v1H2zm5-6h2v1H7zm3 0h2v1h-2zM7 8h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2z" />
                </svg> Relatórios</h1>
                </div>
                <div class="col-md-12 table-container">
                    <h2>Sabores mais vendidos</h2>
                    <table class="table table-striped table-relat">
                        <thead>
                            <tr>
                                <th scope="col">Sabores mais vendidos</th>
                                <th scope="col">Quantidade dos sabores vendidos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($numVendas as $valorVenda) : ?>
                                <tr>
                                    <td>
                                        <?= $valorVenda["saboresVendidos"]; ?>
                                    </td>
                                    <td>
                                        <?= $valorVenda["quantidadeSaboresVendidos"]; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="col-md-12 table-container">
                        <h2>Tipos dos sabores</h2>
                        <table class="table table-striped table-relat">
                            <thead>
                                <tr>
                                    <th scope="col">Quantidade de Sabores</th>
                                    <th scope="col">Total de Pizzas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tiposPizzasFeitos as $tiposSabores) : ?>
                                    <tr>
                                        <td>
                                            <?= $tiposSabores["total_pizzas"]; ?>
                                        </td>
                                        <td>
                                            <?= $tiposSabores["qtdSabores"]; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="col-md-12 table-container">
                        <h2>Média dos sabores por mês</h2>
                        <table class="table table-striped table-relat">
                            <thead>
                                <tr>
                                    <th scope="col">Mês</th>
                                    <th scope="col">Média das vendas das pizzas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($medVendas as $med) : ?>
                                    <tr>
                                        <td>
                                            <?= $med["mêsVendas"]; ?>
                                        </td>
                                        <td>
                                            <?= number_format($med["valorMedMes"], 2); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
</body>
</html>