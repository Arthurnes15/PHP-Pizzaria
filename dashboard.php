<?php 
include_once("process/loginVerificado.php");
include_once("templates/header.php");
include_once("process/orders.php");
?>
<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2> <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-menu-down" viewBox="0 0 16 16">
                  <path d="M7.646.146a.5.5 0 0 1 .708 0L10.207 2H14a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h3.793L7.646.146zM1 7v3h14V7H1zm14-1V4a1 1 0 0 0-1-1h-3.793a1 1 0 0 1-.707-.293L8 1.207l-1.5 1.5A1 1 0 0 1 5.793 3H2a1 1 0 0 0-1 1v2h14zm0 5H1v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2zM2 4.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z" />
                </svg> Gerenciar Pedidos</h2>
            </div>
        <div class="col-md-12 table-container">
                    <table class="table table-striped table-dashboard">
                        <thead>
                            <tr>
                                <th scope="col"><span>Pedido</span>#</th>
                                <th scope="col">Borda</th>
                                <th scope="col">Massa</th>
                                <th scope="col">Sabores</th>
                                <th scope="col">Status</th>
                                <th scope="col">Ações</th>
                                <th scope="col">Data e Hora</th>
                                <th scope="col">Preço</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($pizzas as $pizza): ?>
                            <tr>
                                <td><?= $pizza["id"]?></td>
                                <td><?= $pizza["borda"]?></td>
                                <td><?= $pizza["massa"]?></td>
                                <td>
                                    <ul>
                                        <?php foreach($pizza["sabores"] as $sabor): ?>
                                            <li> <?= $sabor; ?></li>
                                            <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td>
                                    <form action="process/orders.php" method="POST" class="form-group uptade-form">
                                        <input type="hidden" name="type" value="update">
                                        <input type="hidden" name="id" value="<?= $pizza["id"]?>">
                                        <select class="form-control status-input" name="status">
                                        <?php foreach($status as $s): ?>
                                         <option value="<?= $s["id"] ?>" <?php echo ($s["id"] == $pizza["status"]) ? "selected" : ""; ?> ><?= $s["tipo"] ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="update-btn">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="process/orders.php" method="POST" >
                                        <input type="hidden" name="type" value="delete">
                                        <input type="hidden" name="id" value="<?=$pizza["id"] ?>"> <!--Substitui o Echo do PHP!-->
                                        <button type="submit" class="delete-btn" onclick="return excluir()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form> 
                                </td>
                                <td>
                                    <?php 
                                    if (isset($pizza["dataHora"]) && !empty($pizza["dataHora"])) {
                                        echo date("d/m/Y \à\s H:i", strtotime($pizza["dataHora"]));
                                    } else {
                                        echo "Não disponível";
                                    }
                                    ?>          
                                </td>
                                <td>
                                    <?php
                                        echo "R$ ", number_format($pizza["valorFinalPizzas"], 2);
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
   <?php
    include_once("templates/footer.php")
   ?>

<script>
    function excluir(){
        let confirma = confirm("Você deseja realmente apagar esse pedido?");
        if (confirma === true) { 
            return true;
        } 
        else {
            return false;
        }
    }
</script>