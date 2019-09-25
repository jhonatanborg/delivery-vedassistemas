<?php
include_once "backend/produto.class.php";
include_once "backend/cliente.class.php";
include_once "backend/rotas.class.php";
include_once "backend/pedido.class.php";
$redirecionar = new Rotas();
$cliente = new Cliente();
$produtos = new Produto();
$pedido = new Pedido();
if (!isset($_SESSION['carrinho'])) {
	$redirecionar->redirecionar($redirecionar->index);
}
?>
<!doctype html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Massa e Cia</title>
	<link href="./assets/img/brand/logo-massa.png" rel="icon" type="image/png">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

	<link rel="stylesheet" href="./assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/style.css">

</head>

<body class="">
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
	<div class="container col-md-4 align-center">
		<h4 class="text-gray-900 ">Finalize seu pedido</h4>
		<h5 class="mb-3 mt-2" id="entregar">Entregar em</h5>
		<div class="d-flex justify-content card">
			<div class="card shadow border-0">
				<div class="card-header d-flex-row-reverse">
					<i class="fas fa-map-marker-alt mr-2"></i>
					<div class="float-right">
						<a href="#" class="card-link" data-toggle="modal" data-target="#exampleModal">Mudar endereço</a>
					</div>
				</div>
				<div class="card-body">
					<?php $cliente->enderecoPadrao($_SESSION['cliente_id']); ?>
				</div>
			</div>
		</div>
		<h5 class="mt-4" id="entregar">Pedido</h5>
		<form class='user' method='POST' action='backend/pedido.class.php'>
			<?php $pedido->finalizarPedidoLanche(); ?>
			<div class="text-right mt-4">
				<input type="hidden" name="number" value="<?php echo $cliente->pesquisarTelefone($_SESSION['cliente_id']) ?>">
				<button type="submit" id="pagamento" name="continuar-pedido" class="btn btn-orange">Continuar</button>
			</div>
		</form>
	</div>
	</div>
	<!-- Modal -->
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
					<form action="<?php echo $redirecionar->processaCliente ?>" method="POST">
						<?php $cliente->listarEnderecos($_SESSION['cliente_id']); ?>
						<button type="submit" name="alterar-entrega" class="btn btn-danger btn-xl mt-2 align-right">
							Salvar
						</button>
					</form>
				</div>
				<button type="button" class="btn btn-danger btn-sm p-2 new-local" data-toggle="modal" data-target="#enderecomodal">
					Adicionar novo endereço
				</button>
			</div>

		</div>
	</div>
	</div>
	<nav class="navbar navbar-expand-sm bg-orange bottom mt-4">
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
					<form action="<?php echo $redirecionar->processaCliente ?>" method="post">
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
				</form>
			</div>
		</div>
	</div>
	<div class='modal modal-fullscreen' id='myModal' tabindex='-1' role='dialog' aria-hidden='true'>
		<div class='modal-dialog' role='document'>
			<div class='modal-content  modal-full'>
				<div class='modal-header bg-danger'>
					<h6 class='modal-title text-white' id="modal-title-notification">Sua sacola</h6>
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

	<script>
		function cancelarPedido() {
			document.getElementById('cancelPedido').addEventListener('click', e => {
				localStorage.removeItem('quantidade')
			})
		}cancelarPedido()
	</script>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
	</script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
	</script>
</body>

</html>