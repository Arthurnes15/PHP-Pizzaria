    <?php
    include_once("conn.php");
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method === "GET") {
        $pedidoQuery = $conn->query("SELECT * FROM pedidos;");

        $pedidos = $pedidoQuery->fetchAll();
        $pizzas = [];

        //Montar a Pizza
        foreach ($pedidos as $pedido) {
            $pizza = [];

            //Definir um array para pizza
            $pizza["id"] = $pedido["pizza_id"];

            //Resgatando a pizza
            $pizzaQuery = $conn->prepare("SELECT * FROM pizzas WHERE id = :pizza_id");
            $pizzaQuery->bindParam(":pizza_id", $pizza["id"]);
            $pizzaQuery->execute();

            //TRAZENDO AS BORDAS E MASSAS VIA A PIZZA
            $pizzaData = $pizzaQuery->fetch(PDO::FETCH_ASSOC);

            //resGATANDO A BORDA 
            $bordaQuery = $conn->prepare("SELECT * FROM bordas WHERE  id = :borda_id");
            $bordaQuery->bindParam(":borda_id", $pizzaData["borda_id"]);
            $bordaQuery->execute();
            $borda = $bordaQuery->fetch(PDO::FETCH_ASSOC);
            $pizza["borda"] = $borda["tipo"];

            //Resgatando a massa
            $massaQuery = $conn->prepare("SELECT * FROM massas WHERE id = :massa_id");
            $massaQuery->bindParam(":massa_id", $pizzaData["massa_id"]);
            $massaQuery->execute();
            $massa = $massaQuery->fetch(PDO::FETCH_ASSOC);
            $pizza["massa"] = $massa["tipo"];

            $precoConsult = $conn->prepare("SELECT ps.sabor_id, s.preco
            FROM pizza_sabor AS ps
            JOIN sabores AS s ON ps.sabor_id = s.id WHERE ps.pizza_id = :pizza_id");
            $precoConsult->bindParam(":pizza_id", $pizza["id"]);
            $precoConsult->execute();
            if ($precoConsult) {
                $precosSabores = $precoConsult->fetchAll(PDO::FETCH_ASSOC);
                $precoFinal = 0;
                foreach ($precosSabores as $precoSabor) {
                    $precoFinal += $precoSabor["preco"];
                }
                    $numSabores = count($precosSabores);
                    if ($numSabores > 0) {
                        $precoFinal /= $numSabores;
                    }
                $pizza["valorFinalPizzas"] = $precoFinal;
            }
            //Resgatando os sabores
            $saboresQuery = $conn->prepare("SELECT * FROM pizza_sabor WHERE pizza_id = :pizza_id");
            $saboresQuery->bindParam(":pizza_id", $pizza["id"]);
            $saboresQuery->execute();
            $sabores = $saboresQuery->fetchAll(PDO::FETCH_ASSOC);
            $saboresDaPizza = [];
            $saborQuery = $conn->prepare("SELECT * FROM sabores WHERE id = :sabor_id");

            $pizza["dataHora"] = $pedido["dataHora"];

            foreach ($sabores as $sabor) {
                $saborQuery->bindParam(":sabor_id", $sabor["sabor_id"]);
                $saborQuery->execute();
                $saborPizza = $saborQuery->fetch(PDO::FETCH_ASSOC);
                array_push($saboresDaPizza, $saborPizza["nome"]);
            }
            $pizza["sabores"] = $saboresDaPizza;

            //Adiciona o status do pedido 
            $pizza["status"] = $pedido["status_id"];

            //Adiciona o array de pizza no arrary PIZZAS
            array_push($pizzas, $pizza);
        }
        $statusQuery = $conn->query("SELECT * FROM status;");
        $status = $statusQuery->fetchAll();
    } else if ($method === "POST") {
        $type = $_POST["type"];
        // Exclui  o pedido
        if ($type === "delete") {
            $pizzaId = $_POST["id"];
            $deleteQuery = $conn->prepare("DELETE FROM pedidos WHERE pizza_id = :pizza_id;");
            $deleteQuery->bindParam(":pizza_id", $pizzaId, PDO::PARAM_INT);
            $deleteQuery->execute();
            $_SESSION["msg"] = "Pedido removido com sucesso";
            $_SESSION["status"] = "danger";
        } else if ($type === "update") {
            $pizzaId = $_POST["id"];
            $statusId = $_POST["status"];
            $updateQuery = $conn->prepare("UPDATE pedidos SET status_id = :status_id WHERE pizza_id = :pizza_id;");
            $updateQuery->bindParam(":status_id", $statusId, PDO::PARAM_INT);
            $updateQuery->bindParam(":pizza_id", $pizzaId, PDO::PARAM_INT);

            $updateQuery->execute();
            $_SESSION["msg"] = "Pedido ATUALIZADO com sucesso";
            $_SESSION["status"] = "primary";
        }
        header("Location: ../dashboard.php");
    }
    ?>