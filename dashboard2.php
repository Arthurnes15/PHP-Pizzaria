<?php
    include_once("process/loginVerificado.php");
    include_once("templates/headerPedidosEntregues.php");
    include_once("process/pizzasEntregues.php");
?>
<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2> <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                  <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                </svg> Pedidos Entregues</h2>
            </div>
        <div class="col-md-12 table-container">
                    <table class="table table-striped">
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
                                        <button type="submit" class="delete-btn">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form> 
                                </td>
                                <td>
                                    <?php 
                                    if(isset($pizza["dataHora"]) && !empty($pizza["dataHora"])){
                                        echo date("d/m/Y \à\s H:i", strtotime($pizza["dataHora"]));
                                    }else{
                                        echo "Não disponível";
                                    }
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
<footer id="footerEntregues">
        <p>Pizzaria do João &copy; 2023</p>
</footer>