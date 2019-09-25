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
    <title>Empório do caldo</title>
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
    <div class="row mb-3">
			<div class="col-md-4 mt-3">
				<div class="card bg-secondary shadow border-0 p-3">
					<h2>Monte seu Macarrão</h2>
					<p>Tá com fome?! Aproveite e peça um macarrão com seus ingredientes favoritos.</p>
					<p><a class="btn btn-danger" href="<?php echo $redirecionar->pedidoMacarrao ?>" role="button">Fazer pedido</a></p>
				</div>
			</div>
			<div class="col-md-4  mt-3">
				<div class="card bg-secondary shadow border-0 p-3">
					<h2>Monte seu caldo agora</h2>
					<p>Com a volta do frio nada melhor do que saborear um delicioso caldo para se aquecer. </p>
					<p><a class="btn btn-danger" href="<?php echo $redirecionar->pedidoCaldo ?>" role="button">Fazer pedido</a></p>
				</div>
			</div>
			<div class="col-md-4  mt-3">
				<div class="card bg-secondary shadow border-0 p-3">
					<h2>Promoções! Cupons</h2>
					<p>Em breve! Aproveite nossas promoções e saiba como ganhar ainda mais desconto</p>
					<p><a class="btn btn-danger" href="#" role="button">Ver mais detalhes</a></p>
				</div>
			</div>
		</div>
    </div>
    </section>
    
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
                    <a href="https://www.instagram.com/emporiodocaldosinop/" class="twitter"><i class="fab fa-instagram"></i> <span>@emporiodocaldosinop</span></a>
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