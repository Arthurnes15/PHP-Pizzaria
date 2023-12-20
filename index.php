<?php
include_once("process/loginVerificado.php");
include_once("templates/header.php");
include_once("process/pizza.php");
?>
    <div id="main-banner">
        <h1>Faça seu pedido</h1>
    </div>
    <div id="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2> <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-journal-arrow-up" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M8 11a.5.5 0 0 0 .5-.5V6.707l1.146 1.147a.5.5 0 0 0 .708-.708l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L7.5 6.707V10.5a.5.5 0 0 0 .5.5z" />
                  <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                  <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                </svg> Monte sua pizza:</h2>
                    <form action="process/pizza.php" method="POST" id="pizza-form">
                        <div class="form-group">
                            <label for="borda">Borda:</label>
                            <select name="borda" id="borda" class="form-control form-select">
                                <?php foreach($bordas as $borda):?>
                                    <option value="<?php echo $borda['id']?>"><?php echo $borda['tipo']?></option>
                                    <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="massa">Massa:</label>
                            <select name="massa" id="massa" class="form-control form-select">
                            <?php foreach($massas as $massa):?>
                                    <option value="<?php echo $massa['id']?>"><?php echo $massa['tipo']?></option>
                                    <?php endforeach;?>
                            </select>
                        </div>  
                        <div class="form-group">
                            <label for="sabores">Sabores: (Máximo 4)</label><br>
                                <?php foreach($sabores as $sabor):?>
                                    <input type="checkbox" multiple name="sabores[]" id="sabores" value="<?php echo $sabor['id'] ?>">
                                    <label for="sabores<?php echo $sabor['id']?>"> <?php echo $sabor['nome'], " | R$ ", $sabor['preco'], ",00" ; ?></label><br>
                                <?php endforeach ;?>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btnPedido" value="Fazer Pedido">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!---BOOT JS--->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <?php
    include_once('templates/footer.php')
    ?>
</body>
</html>