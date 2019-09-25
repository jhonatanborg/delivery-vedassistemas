<?php
include_once "backend/cliente.class.php";
include_once "backend/rotas.class.php";
include_once "backend/pedido.class.php";
$pedido = new Pedido();
$redirecionar = new Rotas();
$cliente = new Cliente();
// print_r ($_SESSION['pedido']);
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    <title>Home</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-danger">
        <a class="navbar-brand" href="<?php echo $redirecionar->index ?>"><i class="fab fa-gratipay mr-2"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myModal" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler"><a href="#myModal" role="button" class="pedido-center" data-toggle="modal">Sacola</a>
                </i></span>
        </button>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Promoções<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <!-- Pessoa não logada -->
                    <?php $cliente->verificarLogado(); ?>
                    <!-- Pessoa não logada -->
                </li>
                <li class="nav-item active">
                    <a href="#myModal" role="button" class="nav-link" data-toggle="modal">Sacola</a>
                </li>


            </ul>
        </div>
    </nav>
    <div class='modal' id='myModal' tabindex='-1' role='dialog' aria-hidden='true'>
        <div class='modal-dialog modal-full' role='document'>
            <div class='modal-content'>
                <div class='modal-header bg-danger'>
                    <h5 class='modal-title'>Sacola</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                    </button>
                </div>
                <div class='modal-body' id='result'>
                    <?php $pedido->exibirSacola(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container col-md-4 mt-3 align-center">
        <div class="card p-2">
            <h2>Monte seu Macarrão</h2>
            <p>Tá com fome?! Aproveite e peça um macarrão com seus ingredientes favoritos.</p>
            <p><a class="btn btn-danger" href="<?php echo $redirecionar->pedidoMacarrao ?>" role="button">Fazer pedido</a></p>
        </div>
        <h2 class="h1 text-gray-900 mb-1 mt-4">Seus pedidos</h2>
        <h3 class="mt-4" id="entregar">Pedido</h3>
        <div class="card p-1">
            <h6 class="cart-pack">Macarrão 500 gramas R$ 20,00, massa Pene, molho Sugo,<br>
                Azeitona, Presunto, Milho, Ervilha, Palmito</h6>
            <a href="#" class="card-link">Remover</a>
        </div>

        <div class="card p-1">
            <h6 class="cart-pack">Macarrão 500 gramas R$ 20,00, massa Pene, molho Sugo,<br>
                Azeitona, Presunto, Milho, Ervilha, Palmito</h6>
            <a href="#" class="card-link">Remover</a>
        </div>
    </div>
    <nav class="navbar navbar-expand-sm bg-danger fixed-bottom">
    </nav>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous">
    </script>
    <script>
        function alerta() {

        }
    </script>
</body>

</html>