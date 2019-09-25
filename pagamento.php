<?php
include_once "backend/produto.class.php";
include_once "backend/pedido.class.php";
include_once "backend/cliente.class.php";
include_once "backend/rotas.class.php";
$redirecionar = new Rotas();
$cliente = new Cliente();
$pedido = new Pedido();
$produtos = new Produto();
if (isset($_SESSION['forma-pagamento'])) {
    unset($_SESSION['forma-pagamento']);
}
if (!isset($_SESSION['carrinho'])) {
    $redirecionar->redirecionar($redirecionar->index);
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Design System for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>Massa e Cia</title>
    <link href="./assets/img/brand/logo-massa.png" rel="icon" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="./assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="./assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link type="text/css" href="./assets/css/argon.css?v=1.0.1" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.flextabs.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>


<body class="">
<nav class="navbar navbar-expand-lg navbar-dark bg-orange ">
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
    <div class="mt-6 py-4"></div>
    <div class="container col-md-4 align-center">
        <div class="card shadow p-3">
            <h4 class="text-gray-900 mb-1 ml-3">Pagamento</h4>
            <h5 id="entregar" class="ml-3">Pague na hora da entrega</h5>

            <form action="<?php echo $redirecionar->processaPedido ?>" method="POST">
                <div class="form-group">
                    <li class="list-group-item">
                        Dinheiro
                        <label class="checkbox">
                            <input id="pagamento1" type="checkbox" name="pagamento[]" class="form-control" value="1">
                            <span class="danger"></span>
                    </li>
                    <li class="list-group-item">
                        Cartão - Crédito
                        <label class="checkbox">
                            <input id="pagamento2" type="checkbox" name="pagamento[]" class="form-control" value="2">
                            <span class="danger"></span>
                    </li>
                    <li class="list-group-item">
                        Cartão - Débito
                        <label class="checkbox">
                            <input id="pagamento2" type="checkbox" name="pagamento[]" class="form-control" value="3">
                            <span class="danger"></span>
                    </li>
                </div>
                <div class="form-group ml-3">
                    <label class="mb-1">Troco para:
                        <input type="text" disabled id="pagamentoT" data-mask="#.##0,00" data-mask-reverse="true" class="form-control" placeholder="R$ 0,00" name='trocopara'>
                        <small id="erroPagamento" class="text-danger">
                            <!-- Valor menor que o Total da compra -->
                        </small>
                </div>
                <?php
                $desconto = 1;
                $taxa = $_SESSION['taxa-entrega'];
                $liquido = $_SESSION['valor-liquido'];
                $totalbruto = $taxa + $liquido;
                $total = $totalbruto - $desconto;
                ?>
                <div class="p-3">
                    <div class='d-flex flex-row justify-content-between my-flex-container'>
                        <h6>Subtotal:</h6>
                        <h6 class="local-pedido">R$ <?php echo number_format(floatval($liquido), 2, ',', ' '); ?></h6>
                    </div>
                    <div class='d-flex flex-row justify-content-between my-flex-container'>
                        <h6>Taxa de entrega:</h6>
                        <h6 class="local-pedido">R$ <?php echo number_format(floatval($taxa), 2, ',', ' '); ?></h6>
                    </div>
                    <div class='d-flex flex-row justify-content-between my-flex-container'>
                        <h6>Desconto pedido online:</h6>
                        <h6 id="valor-total" class="local-pedido">R$ 1,00</h6>
                    </div>
                    <div class='d-flex flex-row justify-content-between my-flex-container'>
                        <h6>Valor Total</h6>
                        <h6 id="valor-total" class="local-pedido">R$ <?php echo number_format(floatval($totalbruto), 2, ',', ' '); ?></h6>
                    </div>

                    <div class='d-flex flex-row justify-content-between my-flex-container'>
                        <h6>Pedido com desconto:</h6>
                        <h6 id="valor-total">R$ <?php echo number_format(floatval($total), 2, ',', ' '); ?></h6>
                        <input type="hidden" id="valorFinal" value="<?php echo number_format(floatval($total), 2, ',', ' '); ?>">
                    </div>
                    <div class="alert alert-success p-3" role="alert">
                        <?php $pedido->tempodeEspera(); ?>
                    </div>
                    <input type="hidden" name='tempo-espera' value="<?php $pedido->tempodeEspera(); ?>">
                    <div class="text-right mt-4">
                        <button type="submit" name="confirmar-compra" class="btn btn-danger">Finalizar pedido</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    <div class="mt-6 py-4"></div>
    <nav class="navbar navbar-expand-sm bg-danger bottom">
    </nav>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

    <script src="assets/js/validar-campos.js"></script>
    <script src="assets/js/jquery.mask.js"></script>
    <script>
        document.getElementById('pagamento1').onchange = function() {
            document.getElementById('pagamentoT').disabled = !this.checked;
            document.getElementById("confirmar-compra").addEventListener("click", function(event) {
                let valorTotal = document.getElementById("valorFinal").value
                let trocoPara = document.getElementById("pagamentoT").value
                let valorTotal2 = parseFloat(valorTotal)
                let trocoPara2 = parseFloat(trocoPara)
                if (document.getElementById('pagamentoT').disabled == false) {
                    if (trocoPara2 < valorTotal2) {
                        event.preventDefault()
                        let mensagem = document.getElementById("erroPagamento")
                        mensagem.innerHTML = 'Valor menor que o Total da compra'
                    }
                }
            })
        };
    </script>
</body>

</html>