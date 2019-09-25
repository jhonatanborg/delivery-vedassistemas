<?php
include_once "backend/rotas.class.php";
include_once "backend/cliente.class.php";
include_once "backend/pedido.class.php";
$redirecionar = new Rotas();
$cliente = new Cliente();
$pedido = new Pedido();
if (!isset($_SESSION['cliente_id'])) {
    $redirecionar->redirecionar($redirecionar->index);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Design System for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>Massa e Cia</title>
    <!-- Favicon -->
    <link href="./assets/img/brand/logo-massa.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="./assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="./assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Argon CSS -->
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
    <div class='modal ' id='myModal' tabindex='-1' role='dialog' aria-hidden='true'>
        <div class='modal-dialog modal-full' role='document'>
            <div class='modal-content'>
                <div class='modal-header bg-danger'>
                    <h5 class='modal-title text-white'>Sua sacola</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                    </button>
                </div>
                <div class='modal-body p-2' id='result'>
                    <?php $pedido->exibirSacola(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2"></div>
    <div class="container mt-5 col-md-4 mt-3 align-center">
        <div class="card bg-secondary shadow border-0 p-2">
            <h2>Monte seu Macarrão</h2>
            <p>Tá com fome?! Aproveite e peça um macarrão com seus ingredientes favoritos.</p>
            <p><a class="btn btn-danger" href="<?php echo $redirecionar->index ?>" role="button">Fazer pedido</a></p>
        </div>
        <h4 class="h4 text-gray-900 mb-4 mt-4">Meus pedidos</h4>

        <?php $pedido->verPedidosResumo($_SESSION['cliente_id']); ?>
        
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script>
        // $(function() {
        //     $('[data-toggle="popover"]').popover()
        // })
    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="popover"]').popover();
        });
        $(document).on('click.bs.dropdown.data-api', '#avaliacao', function(e) {
            e.stopPropagation();
        });
    </script>
</body>

</html>