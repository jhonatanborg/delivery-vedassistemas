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





<!doctype html>
<html lang="pt-br">

<head>
    <title>Title</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link type="text/css" href="css/argon.css?v=1.0.1" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body class=" bg-danger">

    <body>
        <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-danger ">
    <div class="container">
      <a class="navbar-brand" href="https://massaeciadelivery.com.br">Massa&Cia</a>
  </nav> -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="card bg-secondary shadow  border-0 mt-4">
                        <div class="card-header bg-white pb-2">
                            <div class=" text-center mb-2">
                                <img src="assets/img/brand/logo-massa.png" alt="" width="50%">
                            </div>

                        </div>
                        <form class="user" method="POST" action="<?php echo $redirecionar->processaCliente ?>">
                            <div class="card-body bg-white">
                                <h6 class="mt-2">Endereço para entrega</h6>
                                <div class="form-group">
                                    <select required name="user-bairro" id="select" class="form-control" required>
                                        <!-- LISTAR BAIRROS  -->
                                        <option value="">Selecione o bairro</option>
                                        <?php
                                        $cliente->listarBairros();
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" placeholder="Rua" name="user-rua" required>
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control form-control-lg" placeholder="Número da casa" name="user-numero" required>
                                </div>
                           
                            <div class="form-group mt-3">
                                <input type="text" class="form-control form-control-lg " placeholder="Complemento" name="user-complemento">
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="<?php echo $redirecionar->usuarioCadastro ?>" class="btn btn-secondary">Voltar</a>
                                <button type="submit"  name='send-adress' class="btn btn-danger mt-3">Finalizar</button>
                            </div>
                    </div>
                    </form>
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
        <script src="validar-campos.js"></script>
    </body>

</html>