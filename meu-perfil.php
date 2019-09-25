<?php
//include_once "backend/produto.class.php";
include_once "backend/cliente.class.php";
include_once "backend/rotas.class.php";
include_once "backend/pedido.class.php";
$redirecionar = new Rotas();
$cliente = new Cliente();
// $produtos = new Produto();
$pedido = new Pedido();
if (!isset($_SESSION['cliente_id'])) {
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
    <!-- Favicon -->
    <link href="./assets/img/brand/logo-massa.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="./assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="./assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link type="text/css" href="./assets/css/argon.css?v=1.0.1" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.flextabs.css">
    <link rel="stylesheet" href="assets/css/styles.css">

</head>
<style>
a {
    color: white;
}
</style>

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
            <a class="navbar-brand" href="<?php echo $redirecionar->index ?>"><img whidht='35' height='35'
                    src="assets/img/logo-inicio-vedas.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-inner-primary"
                aria-controls="nav-inner-primary" aria-expanded="false" aria-label="Toggle navigation">
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
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#nav-inner-primary" aria-controls="nav-inner-primary" aria-expanded="false"
                                aria-label="Toggle navigation">
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
		echo"
    <button type='button' class='btn btn-block btn-success mb-3 fixed-bottom' data-toggle='modal' data-target='#myModal'><span class='btn-inner--icon'><i class='ni ni-bag-17'></i></span> <span class='btn-inner--text'>Sacola</span></button>
    <section class='section section-shaped section-sm'>
    ";
    }
    ?>
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
    <div class=" container col-md-4 mt-2 align-center">
        <div class="p-3 card mb-2">
            <h4 class="h4 text-gray-900 mb-4">Editar dados</h4>
            <!-- COLOCAR AQUI -->
            <form id="FormDados" action="<?php $redirecionar->processaCliente ?>" method="post">
                <?php
                if (isset($_SESSION['cliente_email'])) {
                    $id = $cliente->pesquisarCliente($_SESSION['cliente_email']);
                    $cliente->listarTodosDados($id);
                    $_SESSION['cliente_id'] = $id;
                } else {
                    $cliente->listarTodosDados($_SESSION['cliente_id']);
                }
                ?>

                <!-- Colar na cliente Class -->
            </form>
        </div>
    </div>
    <footer id="myFooter">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="text-white">Siga nosso Instagram</h6>
                    <a href="https://www.instagram.com/emporiodocaldosinop/" class="twitter"><i
                            class="fab fa-instagram"></i> <span>@emporiodocaldosinop</span></a>
                    <button type="button" class="btn btn-default">Nos Avalie</button>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>© 2019 Copyright Vedas Sistemas </p>
        </div>
    </footer>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Mudar endereço de entrega</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo $redirecionar->processaCliente ?>" method="POST">
                        <?php $cliente->listarEnderecos($_SESSION['cliente_id']); ?>
                        <button type="submit" name="alterar-entregaPerfil"
                            class="btn btn-danger btn-xl mt-2 align-right">
                            Salvar
                        </button>
                        <button type="submit" name="deletar-enderecoPerfil"
                            class="btn btn-danger btn-xl mt-2 align-right">
                            Deletar
                        </button>
                    </form>
                </div>
                <button type="button" class="btn btn-danger btn-sm p-2 new-local" data-toggle="modal"
                    data-target="#enderecomodal">
                    Adicionar novo endereço
                </button>
            </div>

        </div>
    </div>
    </div>
    <div class="modal fade" id="enderecomodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar novo endereço</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo $redirecionar->processaCliente ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="bairro2" class="form-control" required>
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
                        <button type="submit" name="novo-enderecoPerfil" class="btn btn-danger">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cadastrar-endereco" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Completar Dados</h5>
                </div>
                <form action="<?php echo $redirecionar->processaCliente ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="tel" class="form-control " id="telefone" placeholder="Telefone" name="telefone"
                                size="16" maxlength="15" value="" required>
                        </div>
                        <div class="form-group">
                            <select name="bairro2" class="form-control" required>
                                <!-- LISTAR BAIRROS  -->
                                <option>Selecione o bairro</option>
                                <?php
                                    $cliente->listarBairros();
                                    ?>
                            </select>

                        </div>
                        <div class="form-group row">

                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control " placeholder="Rua" name="rua-nome2" required>
                            </div>
                            <div class="col-sm-6">
                                <input type="tel" class="form-control " placeholder="Numero" name="rua-nr2" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Complemento" name="complemento2"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="cadastrar-endereco-facebook"
                            class="btn btn-danger">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
    function validarSenha() {
        senha1 = document.getElementById('senha1').value;
        senha2 = document.getElementById('senha2').value;
        if (senha1 != senha2) {
            alert("SENHAS DIFERENTES!\nFAVOR DIGITAR SENHAS IGUAIS");
        } else {
            document.FormDados.submit();
        }
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="assets/js/validar-campos.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <?php
        // if (!empty($_SESSION['facebooklogin'])) {
        // //     echo "<script>
        // // $('#cadastrar-endereco').modal('show');                 
        // //  </script>
        // //    ";
        // } ?>
</body>

</html>