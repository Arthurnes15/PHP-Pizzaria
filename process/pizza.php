<?php
    include_once("conn.php");
    $method = $_SERVER['REQUEST_METHOD'];
    if($method === "GET"){
        $bordasQuery = $conn->query("SELECT * FROM bordas;"); //Fez a query
        $bordas = $bordasQuery -> fetchAll();
        $saboresQuery = $conn->query("SELECT * FROM sabores;"); //Fez a query
        $sabores = $saboresQuery -> fetchAll(); 
        $massasQuery = $conn->query("SELECT * FROM massas;"); //Fez a query
        $massas = $massasQuery -> fetchAll(); 
    } else if ($method === "POST"){
        $data = $_POST;
        $borda = $data["borda"];
        $massa = $data["massa"];
        $sabores = $data["sabores"];
      //Validação qtd de sabores
      if(count($sabores) >= 5) {
       $_SESSION["msg"] = "Selecione no máximo 4 sabores";
       $_SESSION["status"] = "warning";
      }else {
        $stmt = $conn->prepare("INSERT INTO pizzas(borda_id, massa_id) VALUES(:borda, :massa)");
        //Filtras os Inputs
        $stmt->bindParam(":borda", $borda, PDO::PARAM_INT);
        $stmt->bindParam(":massa", $massa, PDO::PARAM_INT);
        $stmt->execute();

        //resgatar o ultimo id da pizza
        $pizzaId = $conn->lastInsertId();
        
        $stmt = $conn->prepare("INSERT INTO pizza_sabor(pizza_id, sabor_id)VALUES (:pizza,:sabor)");

        //Repete até salvar todos os sabores
        foreach($sabores as $sabor){
          $stmt->bindParam(":pizza", $pizzaId, PDO::PARAM_INT);
          $stmt->bindParam(":sabor", $sabor, PDO::PARAM_INT);
          $stmt->execute();
        }
        //Criar pedido
        $stmt = $conn->prepare("INSERT INTO pedidos(pizza_id, status_id) VALUES(:pizza, :status)");
        $statusId = 1;
        $stmt->bindParam(":status", $statusId);
        $stmt->bindParam(":pizza", $pizzaId);
        $stmt->execute();
        //Exibir mensagem de sucesso
        $_SESSION["msg"] = "Pedido realizado com sucesso";
        $_SESSION["status"] = "success";
      }
      header("Location: ..");
}
?>