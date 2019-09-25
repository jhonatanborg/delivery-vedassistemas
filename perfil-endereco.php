<?php
include_once "backend/produto.class.php";
include_once "backend/cliente.class.php";
include_once "backend/rotas.class.php";
$redirecionar = new Rotas();
$cliente = new Cliente();
$produtos = new Produto();
?>
<!doctype html>
<html lang="pt-br">

<head>
<link rel="icon" type="image/png" sizes="32x32" href="assets/img//favicon-32x32.png">
    <title>Meu Perfil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
    a {
        color: white;
    }
</style>

<body  class="bg-light
 bg-light">
    <nav class="navbar navbar-expand-sm bg-danger">
        <a class="navbar-brand" href="<?php echo $redirecionar->index?>"><i class="fab fa-gratipay mr-2"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myModal"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler"><a href="#myModal" role="button" class="pedido-center" data-toggle="modal"><img src="assets/img/shopping-bag.png" whidht='25' height='25'alt="" class="mr-2">Sacola
                    </a>
                </i></span>
        </button>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link ml-2" href="#"><img src="assets/img/discount.png" whidht='27' height='27'alt="" class="mr-2">Promoções</a>
                </li>     
                <li class="nav-item active">
                </li>
                <li class="nav-item dropdown">
                    <!-- Pessoa não logada -->
                    <?php $cliente->verificarLogado(); ?>
                    <!-- Pessoa não logada -->
                </li>
                <li class="nav-item active">
                    <a href="#myModal" role="button" class="nav-link" data-toggle="modal"><img src="assets/img/shopping-bag.png" whidht='25' height='25'alt="" class="mr-2">Sacola</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class='modal' id='myModal' tabindex='-1' role='dialog' aria-hidden='true'>
        <div class='modal-dialog modal-full' role='document'>
            <div class='modal-content'>
                <div class='modal-header bg-danger'>
                    <h5 class='modal-title'>Sua sacola</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                    </button>
                </div>
                <div class='modal-body bg-light p-2' id='result'>
                    <?php $pedido->exibirSacola(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class=" container col-md-4 mt-3 align-center">
        <div class="p-3">
            <div class="row">
                <h4 class="h4 text-gray-900 mb-4">Editar dados</h4> 
                <!-- COLOCAR AQUI -->
            </div>
            <form action="<?php $redirecionar->processaCliente ?>" method="post">
                <?php $cliente->listarTodosDados($_SESSION['cliente_id']); ?>

                </form>
            </form>
            <a class="btn btn-primary mt-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                Adicionar novo endereço
            </a>
            <div class="collapse mt-2" id="collapseExample">
                <div class="card card-body">
                    <div class="form-group">
                        <select name="bairro" id="select" class="form-control" required>
                            <!-- LISTAR BAIRROS  -->
                            <option>Selecione o bairro</option>
                            <?php
                            $cliente->listarBairros();
                            ?>
                        </select>

                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control " id="exampleFirstName" placeholder="Rua" name="rua-nome">
                        </div>
                        <div class="col-sm-6">
                            <input type="tel" class="form-control " id="exampleLastName" placeholder="Numero" name="rua-nr">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputPassword" placeholder="Complemento" name="complemento">
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html> 