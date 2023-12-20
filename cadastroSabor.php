<?php
include_once("process/loginVerificado.php");
include_once("process/conn.php");
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $type = $_POST["type"];
  $novoSabor = $_POST["novo_sabor"];
  $precoNovoSabor = $_POST["novo_preco"];
  if ($type == "cadastrar") {
    $cadastroQuery = $conn->prepare("INSERT INTO sabores(nome, preco) VALUES (:nome_sabor, :preco_sabor)");
    $cadastroQuery->bindParam(":nome_sabor", $novoSabor);
    $cadastroQuery->bindParam(":preco_sabor", $precoNovoSabor);
    $cadastroQuery->execute();
    if ($cadastroQuery) {
      $_SESSION["msg"] = "Novo sabor cadastrado";
      $_SESSION["status"] = "success";
      header("Location: index.php");
      exit();
    }
  }
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

<body class="bodyCadastro">
  <header>
    <nav class="navbar navbar-expand-lg" id="navCadastro">
      <div class="container-fluid">
        <img src="img/pizzaLogo2.png" alt="pizzaLogo" height="100px">
        <a class="navbar-brand text-light" href="index.php" id="h1Header">Pizzaria do João</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active text-light" aria-current="page" href="index.php"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-journal-arrow-up" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M8 11a.5.5 0 0 0 .5-.5V6.707l1.146 1.147a.5.5 0 0 0 .708-.708l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L7.5 6.707V10.5a.5.5 0 0 0 .5.5z" />
                  <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                  <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                </svg> Pedidos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-light" href="dashboard.php"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-menu-down" viewBox="0 0 16 16">
                  <path d="M7.646.146a.5.5 0 0 1 .708 0L10.207 2H14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h3.793L7.646.146zM1 7v3h14V7H1zm14-1V4a1 1 0 0 0-1-1h-3.793a1 1 0 0 1-.707-.293L8 1.207l-1.5 1.5A1 1 0 0 1 5.793 3H2a1 1 0 0 0-1 1v2h14zm0 5H1v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2zM2 4.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z" />
                </svg> Controle dos pedidos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-light" href="cadastroSabor.php"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                  <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                  <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                </svg> Cadastrar Sabores</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active text-light" href="dashboard2.php"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
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
  <main class="container mainCadastro">
    <form action="" method="POST">
      <div class="h1ImgLogin">
        <img src="img/sabor.png" alt="saborPizza">
        <h1 class="h1Login">Cadastrar Sabores</h1>
      </div><br>
      <label for="sabor">Novo Sabor:</label><br>
      <input class="form-control form-control-lg" required type="text" name="novo_sabor" placeholder="Digite o novo sabor" aria-label=".form-control-lg example"><br>
      <label for="">Preço do novo sabor:</label>
      <input type="number" name="novo_preco" required id="novoPreço" class="form-control form-control-lg" placeholder="Digite o novo preço"><br>
      <button type="submit" name="type" value="cadastrar" class="btn btnCadastro">Cadastrar</button>
    </form>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>