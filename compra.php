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
    <title>Finalizar-compra</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
    a:hover {
        color: white;
    }
</style>

<<body  class="bg-light
 bg-light">
    <nav class="navbar navbar-expand-sm bg-danger">
        <a class="navbar-brand" href="<?php echo $redirecionar->index?>"><i class="fab fa-gratipay mr-2"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myModal"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler"><a href="#myModal" role="button" class="pedido-center" data-toggle="modal">Sacola</a>
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

    <div class="container col-md-4 mt-3 align-center">
        <h2 class="h1 text-gray-900 mb-1 mt-4">Finalize seu pedido</h2>
        <h3 class="mb-3 mt-2" id="entregar">Entregar em</h3>
        <div class="d-flex justify-content card">
            <div class="card">
                <div class="card-header d-flex-row-reverse">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <div class="float-right">
                        <a href="#" class="card-link" data-toggle="modal" data-target="#exampleModal">Mudar endereço</a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Função do endereço aqui -->
                    <h6 clas="local-pedido">Rua amendoeiras, 49 <br>Bairro: Setor Comercial, ao lado do 7 Express</h6>
                </div>
            </div>
        </div>
        <h3 class="mt-4" id="entregar">Pedido</h3>
        <?php $cliente->finalizarPedido(); ?>
        <div class="form-group mt-3">
            <label for="">Escreva um comentário</label>
            <input type="textarea" class="form-control" name="" id="" aria-describedby="helpId" placeholder="Ex: tirar alho, a parte ou etc.">
        </div>
        <div class="card mt-2">
            <h6 class="text-danger p-3" id="entregar">Taxa de Entrega: 3,00</h6>
            <div class="card-body bg-danger">
                <h5 class="text-white" id="entregar">Total:<span class="badge badge-light ml-2">R$:22,00</span></h5>
            </div>
        </div>
        <div class="text-right mt-4">
            <a id="pagamento" class="btn btn-danger" href="pagamento.php">Continuar</a>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Mudar endereço de entrega</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="d-flex flex-row mr-5">
                                    <h6 clas="local-pedido">Rua amendoeiras, 49 <br>Bairro: Setor Comercial, ao lado do
                                        7 Express</h6>

                                </div>
                                <div class="d-flex flex-row-reverse pt-1">
                                    <label class="checkbox">
                                        <input type="radio" name="produtoid[]" value="#">
                                        <span class="danger"></span>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="d-flex flex-row mr-5">
                                    <h6 clas="local-pedido">Rua amendoeiras, 49 <br>Bairro: Setor Comercial, ao lado do
                                        7 Express</h6>

                                </div>
                                <div class="d-flex flex-row-reverse pt-1">
                                    <label class="checkbox">
                                        <input type="radio" name="produtoid[]" value="#">
                                        <span class="danger"></span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm p-2 new-local" data-toggle="modal" data-target="#enderecomodal">
                    Adicionar novo endereço
                </button>
            </div>

        </div>
    </div>
    </div>
    <div class="mt-6 py-4"></div>

    <nav class="navbar navbar-expand-sm bg-danger bottom">
    </nav>
    <div class="modal fade" id="enderecomodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar novo endereço</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select name="bairro2" id="select" class="form-control" required>
                            <!-- LISTAR BAIRROS  -->
                            <option>Selecione o bairro</option>
                            <?php
                            $cliente->listarBairros();
                            ?>
                        </select>

                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control " placeholder="Rua" name="rua-nome2">
                        </div>
                        <div class="col-sm-6">
                            <input type="tel" class="form-control " placeholder="Numero" name="rua-nr2">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Complemento" name="complemento2">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="novo-endereco" class="btn btn-danger">Adicionar</button>
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