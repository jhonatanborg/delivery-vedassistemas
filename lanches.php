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
<!DOCTYPE html5>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Massa e Cia</title>
    <link href="./assets/img/brand/logo-massa.png" rel="icon" type="image/png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/style.css">

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
    <nav class="navbar navbar-expand-lg navbar-dark bg-orange ">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $redirecionar->index ?>">Salsicha</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-inner-primary" aria-controls="nav-inner-primary" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav-inner-primary">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="<?php echo $redirecionar->index ?>">
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
    <button type='button' class='btn btn-block btn-success mb-3 d-none' id='sale' data-toggle='modal' data-target='#myModal'>Sacola<span id="qtd" class="ml-2 badge badge-pill badge-light"></span></button>
    <section class='section section-shaped section-sm'>
        <div class=" container col-sm-6">
            <br>
            <div class="container p-3 ">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-column">
                        <span class="font-weight-bold">Salsicha lanche</span>
                        <strong class="text-orange">Endereço</strong>
                        <span class="text-muted">Av. Itaubas, número 49</span>
                    </div>
                    <img src="assets/img/logo.png" class="w-20" alt="">
                </div>
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-column">
                        <strong class="text-orange">Tempo Espera</strong>
                        <span class="text-muted">40-50 minutos</span>
                    </div>
                    <div class="d-flex flex-column">
                        <strong class="text-orange">Celular</strong>
                        <span class="text-muted">66 9933 8479</span>
                    </div>
                </div>
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#mais-pedidos">Mais Pedidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#combos">Combos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " data-toggle="tab" href="#menu2">Bebidas</a>
                </li>
            </ul>
            <div class="tab-content">
                <form hidden id='carrinho'>
                    <input id="idProduto" type="text">
                    <input id="qtdProduto" type="text">
                    <button id="sendForm" type="submit"></button>
                </form>

                <div id="mais-pedidos" class="tab-pane active"><br>
                    <ul class="list-group">
                        <?php $produto->listarProdutosProntos('Lanches'); ?>
                    </ul>
                </div>
                <div id="combos" class=" tab-pane fade"><br>
                    <ul class="list-group">
                        <?php $produto->listarProdutosProntos('Combos'); ?>
                    </ul>
                </div>
                <div id="menu2" class=" tab-pane"><br>
                    <ul class="list-group">
                        <?php $produto->listarProdutosProntos('Bebidas'); ?>
                    </ul>
                </div>
            </div>
            <div class='modal' id='myModal' tabindex='-1' role='dialog' aria-hidden='true'>
                <div class='modal-dialog modal-full' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header bg-orange'>
                            <h5 class='modal-title text-white'>Sua sacola</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>×</span>
                            </button>
                        </div>
                        <div class='modal-body bg-light p-2' id='sacola'>
                            <div id="shopping-cart">
                                <?php
                                $obj = new stdClass();
                                $total = 0;
                                if (!empty($_SESSION['carrinho'])) {
                                    foreach ($_SESSION['carrinho'] as $key => $value) {
                                        $total += $value['valor'];
                                        foreach ($value as $key2 => $value2) {
                                            $obj->$key2 = $value2;
                                        }
                                        ?>
                                        <li class='list-group-item'>
                                            <div class="d-flex justify-content-between">
                                                <p><span id='#' class='text-orange'> <?php echo $obj->titulo; ?></span></p>
                                                <small onclick="removeForm('<?= $obj->id ?>')" id="removePedido<?= $obj->id ?>" class="font-weight-light text-danger">Remover</small>
                                            </div>
                                            <span id='#' class='text-muted'><?php echo $obj->descricao; ?></span>
                                            <div class="text-right">
                                                <span id='#' class='text-orange'>R$ <?php echo $obj->valor; ?></span>
                                            </div>
                                            <br>
                                        </li>
                                    <?php
                                        }
                                        ?>
                                    <div class="card p-3 mt-3">
                                        <div class="d-flex flex-row justify-content-between my-flex-container">
                                            <h6>Total:</h6>
                                            <h6>R$ <?php echo number_format(floatval($total), 2, ',', ' '); ?></h6>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                </li>
                            </div>
                        </div>
                        <form action='' method='post'>
                            <div class="modal-footer">
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Adicionar mais itens</button>
                                    <button type="submit" class="btn btn-danger color-white" name="finalizar-compra">Finalizar compra</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <form hidden id="removeForm">
                <input id="idRemove" type="text">
            </form>

            <script src="./assets/vendor/jquery/jquery.min.js"></script>
            <script src="./assets/vendor/popper/popper.min.js"></script>
            <script src="./assets/vendor/bootstrap/bootstrap.min.js"></script>
            <script src="./assets/vendor/headroom/headroom.min.js"></script>
            <script src="./assets/js/argon.js?v=1.0.1"></script>
            <script>
                document.getElementById('qtd').innerHTML = localStorage.getItem('quantidade')

                function addForm(idProduto, qtdProduto) {
                    // let ID = document.getElementById('idProduto').value = id
                    // let QTD = document.getElementById('qtdProduto').value = qtd
                    // console.log('Id: ' + idProduto + ' Qtd: ' + qtdProduto)
                    document.getElementById('sacola').innerHTML = ''
                    $.ajax({
                        url: "backend/produto.class.php",
                        method: "POST",
                        data: {
                            idProduto,
                            qtdProduto
                        },
                        success: function(response) {
                            var myJSON = JSON.parse(response);
                            myJSON.forEach(function(item) {
                                console.log(item);
                                document.getElementById('sacola').innerHTML += `
                            <li class='list-group-item'>
                            <div class="d-flex justify-content-between">
                                <p><span id='titulo' class=''>${item.titulo}</span></p>
                                <small
                                onclick="removeForm('${item.id}')"
                                id="removePedido${item.id}" class="font-weight-light text-danger">Remover</small>
                                </div>
                                <span id='descricao' class='text-muted'>${item.descricao}</span>
                                <div class="text-right">
                                <span id="descricao" class="text-orange">R$ ${item.valor}</span>
                                </div>
                            </li>`
                            });
                            localStorage.setItem("quantidade", myJSON.length);
                            document.getElementById('qtd').innerHTML = localStorage.getItem('quantidade')
                            localStorage.setItem("carrinho", "prenchido");
                            carrinho()
                        }
                    })

                }

                function removeForm(id) {
                    document.getElementById('idRemove').value = id
                    console.log(id)
                }

                function removePedido(idProdRemove) {
                    document.getElementById('removeForm').addEventListener('submit', e => {
                        e.preventDefault()
                        $.ajax({
                            url: "backend/pedidos.class.php",
                            method: "POST",
                            data: idProdRemove,
                            success: function(response) {
                                console.log(response)
                            }
                        })
                    })
                }
       

                function carrinho() {
                    var carrinho = window.localStorage.getItem('quantidade');
                    if (carrinho) {
                        var element = document.getElementById("sale");
                        element.classList.remove("d-none");
                    }
                }
                carrinho()
            </script>
</body>

</html>