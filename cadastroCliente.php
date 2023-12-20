<?php
include("templates/headerCliente.php");
include_once("process/conn.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $type = $_POST["type"];
    $novoUsuario = $_POST["novo_usuario"];
    $novoEmail = $_POST["novo_email"];
    $novaSenha = $_POST["nova_senha"];
    $novoEndereco = $_POST["novo_endereço"];

    if ($type == "cadastrarCliente") {
        $cadastroQuery = $conn->prepare("INSERT INTO usuarios(nome, email, senha, endereco) VALUES(:nome_usuario, :email_usuario, :senha_usuario, :endereco_usuario )");
        $cadastroQuery->bindParam(":nome_usuario", $novoUsuario);
        $cadastroQuery->bindParam(":email_usuario", $novoEmail);
        $cadastroQuery->bindParam(":senha_usuario", $novaSenha);
        $cadastroQuery->bindParam(":endereco_usuario", $novoEndereco);
        $cadastroQuery->execute();

        if ($cadastroQuery) {
            $_SESSION["msg"] = "Novo usuário cadastrado!";
            $_SESSION["status"] = "success";
            header("Location: loginForm.php");
            exit();
        }
    }
}
?>
    <main class="container mainCliente">
        <form action="" method="POST">
            <div class="h1ImgLogin">
                <img src="img/pizzaIcon.png" alt="">
                <h1 class="h1Login">Cadastro de Clientes</h1>
            </div><br>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-workspace" viewBox="0 0 16 16">
                <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z" />
            </svg>
            <label for="nome">Nome de Usuário:</label> <br>
            <input type="text" class="form-control" name="novo_usuario" placeholder="Digite seu nome" required> <br>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
            </svg>
            <label for="email">E-mail:</label><br>
            <input type="email" name="novo_email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Digite seu e-mail" required><br>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z" />
                <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
            </svg>
            <label for="senha">Senha:</label><br>
            <input type="password" name="nova_senha" class="form-control" id="exampleInputPassword1" placeholder="Digite uma senha:" required><br>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
            <label for="endereço">Endereço (Rua, Número e Bairro):</label><br>
            <input type="text" class="form-control" placeholder="Digite seu endereço" name="novo_endereço" required> <br>
            <button type="submit" class="btn btnCadastroCliente" name="type" value="cadastrarCliente">Cadastrar</button>
        </form>
    </main>
</body>
</html>