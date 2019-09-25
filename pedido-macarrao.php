<?php
include_once "backend/produto.class.php";
include_once "backend/cliente.class.php";
include_once "backend/rotas.class.php";
include_once "backend/pedido.class.php";
$pedido = new Pedido();
$redirecionar = new Rotas();
$produtos = new Produto();
$cliente = new Cliente();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Massa e Cia</title>
    <link href="./assets/img/brand/logo-massa.png" rel="icon" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="./assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="./assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link type="text/css" href="./assets/css/argon.css?v=1.0.1" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.flextabs.css">
    <link rel="stylesheet" href="assets/css/styles.css">

</head>

<body>
    <style>
        .modal-dialog {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            max-width: none;
        }

        .modal-content {
            height: auto;
            min-height: 100%;
            border-radius: 0;
            border: none;
        }

        .modal-open {
            padding-right: 0px !important;
        }
    </style>
  <nav class="navbar navbar-expand-lg navbar-dark bg-danger ">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $redirecionar->index ?>" ><img whidht='35' height='35' src="assets/img/logo-inicio-vedas.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-inner-primary" aria-controls="nav-inner-primary" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav-inner-primary">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="<?php echo $redirecionar->index ?>">
                                <img src="./assets/img/brand/logo-massa.png">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-inner-primary" aria-controls="nav-inner-primary" aria-expanded="false" aria-label="Toggle navigation">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav ml-lg-auto">
                    <!-- Pessoa não logada -->
                    <?php $cliente->verificarLogado(); ?>
                    <!-- Pessoa não logada -->
                </ul>
            </div>
        </div>
    </nav>
    <?php
    if (!empty($_SESSION['pedido'])) {
        echo "
    <button type='button' class='btn btn-block btn-success mb-3 fixed-bottom' data-toggle='modal' data-target='#myModal'><span class='btn-inner--icon'><i class='ni ni-bag-17'></i></span> <span class='btn-inner--text'>Sacola</span></button>
    <section class='section section-shaped section-sm'>
    ";
    }
    ?>
    <div class="container pt-sm-md">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-header bg-white pb-3">
                        <div class="text-muted text-center mb-3">
                            <img src="./assets/img/brand/logo-massa.png" alt="" width="50%">
                        </div>
                    </div>
                    <div class="card-body  bg-white px-lg-5 py-lg-5">
                        <h6>Escolha quantos ingredientes você quiser, faça combinações incriveis.</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <div class="container">
        <div id="montar-prato" data-ft style="display: none;" class="mt-1">
            <nav class="nav-pedido">
                <a href="#bobr" class="active">Escolha o Tamanho</a>
                <a href="#mangust" class=""><span>Escolha a Massa</span></a>
                <a href="#mangust" class=""><span>Escolha o tempero</span></a>
                <a href="#kenguru" class="">Escolha o molho</a>
                <a href="#irbis" class=""><span>Escolha os ingredientes</span></a>
                <!-- <a href="#nosorog" class="">Adicionais</a> -->
                <a href="#nosorog" class="">Bebidas</a>
            </nav>
            <div class="mb-4">
                <div>
                    <form id="fazerPedido" action="<?php echo $redirecionar->processaPedido ?>" method="POST">
                        <!-- Modal -->
                        <ul class="list-group list-group-flush">
                            <!-- LISTAR TAMANHO DO PRODUTO -->
                            <?php $produtos->listarProdutosPedido('cad_produto', '5'); ?>
                        </ul>
                </div>
                <div>
                    <ul class="list-group list-group-flush">
                        <!-- LISTAR A MASSA -->
                        <?php $produtos->listarProdutosPedido('cad_ingrediente', '1'); ?>
                </div>
                <div>
                    <ul class="list-group list-group-flush">
                        <!-- LISTAR ADICIONAIS -->
                        <?php $produtos->listarProdutosPedido('cad_ingrediente', '9'); ?>
                    </ul>
                </div>
                <div>
                    <ul class="list-group list-group-flush">
                        <!-- LISTAR O MOLHO -->
                        <?php $produtos->listarProdutosPedido('cad_ingrediente', '2'); ?>
                    </ul>
                </div>
                <div>
                    <ul class="list-group list-group-flush">
                        <!-- LISTAR INGREDIENTES DO MACARRAO -->
                        <?php $produtos->listarProdutosPedido('cad_ingrediente', '6'); ?>
                    </ul>
                </div>
                <!-- <div>
                        <ul class="list-group list-group-flush">
                            LISTAR ADICIONAIS
                            <?php $produtos->listarProdutosPedido('cad_ingrediente', '7'); ?>
                        </ul>
                    </div> -->
                <div>
                    <ul class="list-group list-group-flush">
                        <a href="#" class='text-dark' data-toggle="modal" data-target="#refrigerante" style="text-decoration:none">
                            <li class="list-group-item list-group-item-action">
                                Refrigerantes
                                <span class="danger"></span>
                            </li>
                        </a>
                    </ul>
                </div>
                <div class="d-flex justify-content-end">
                    <button id="confirmar_pedido" type="submit" name="confirmar-macarrao" class="btn btn-danger mt-3">Confirmar pedido</button>
                </div>
            </div>
            <div class="modal fade" id="refrigerante" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark">Refrigerante</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body corpo-modal">
                            <div>
                                <ul class="list-group list-group-flush">
                                    <?php $produtos->listarProdutosPedido('cad_ingrediente', '10'); ?>
                                </ul>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    <div class='modal' id='myModal' tabindex='-1' role='dialog' aria-hidden='true'>
        <div class='modal-dialog modal-full' role='document'>
            <div class='modal-content'>
                <div class='modal-header bg-danger'>
                    <h5 class='modal-title text-white'>Sua sacola</h5>
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
    <footer id="myFooter">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="text-white">Siga nosso Instagram</h6>
                    <a href="https://www.instagram.com/massaeciasinop/" class="twitter"><i class="fab fa-instagram"></i> <span>@massaeciasinop</span></a>
                    <button type="button" class="btn btn-default">Nos Avalie</button>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>© 2019 Copyright Vedas Sistemas </p>
        </div>
    </footer>
    <script src="./assets/vendor/jquery/jquery.min.js"></script>
    <script src="./assets/vendor/popper/popper.min.js"></script>
    <script src="./assets/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="./assets/vendor/headroom/headroom.min.js"></script>
    <script src="./assets/js/argon.js?v=1.0.1"></script>
    <script src="assets/js/jquery.flextabs.js"></script>
    <script src="assets/js/demo.js"></script>
    <script>
        document.getElementById("confirmar_pedido").addEventListener("click", function(event) {
            function valida() {
                var x = document.getElementsByClassName("massa")
                var i = 0;
                var c = new Array();
                a = 0;
                for (i = 0; i <= x.length - 1; i++) {
                    if (x[i].type == "checkbox") {
                        c[a] = x[i];
                        a++;
                    }
                }
                i = 0;
                var checked = false;
                for (i = 0; i <= c.length - 1; i++) {
                    if (c[i].checked == true) {
                        checked = true;
                        break;
                    }
                }
                if (!checked) {
                    event.preventDefault()
                    alert("Escolha a massa");
                }
            }
            valida()
        })
    </script>
    <script>
        document.getElementById("confirmar_pedido").addEventListener("click", function(event) {
            function valida() {
                var x = document.getElementsByClassName("molho")
                var i = 0;
                var c = new Array();
                a = 0;
                for (i = 0; i <= x.length - 1; i++) {
                    if (x[i].type == "checkbox") {
                        c[a] = x[i];
                        a++;
                    }
                }
                i = 0;
                var checked = false;
                for (i = 0; i <= c.length - 1; i++) {
                    if (c[i].checked == true) {
                        checked = true;
                        break;
                    }
                }
                if (!checked) {
                    event.preventDefault()
                    alert("Escolha o molho");
                }
            }
            valida()
        })
    </script>
    <script>
        $('.molho').on('change', function() {
            if ($('.molho:checked').length > 2) {
                this.checked = false;
            }
        });
        $('.massa').on('change', function() {
            if ($('.massa:checked').length > 1) {
                this.checked = false;
            }
        });
    </script>
    <script>
        $('.local-pedido').text(function(_, txt) {
            return txt.slice(0, );
        });
    </script>
    <?php
    if (!empty($_SESSION['pedido'])) {
        echo "<script>
        $('#myModal').modal('show');
         </script>
                  ";
    } ?>
</body>

</html>