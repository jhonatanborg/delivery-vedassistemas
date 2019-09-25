<?php
include_once "backend/cliente.class.php";
include_once "backend/rotas.class.php";
$cliente = new Cliente();
$redirecionar = new Rotas();
if (isset($_SESSION['cliente_id'])) {
	$redirecionar->redirecionar($redirecionar->index);
}
?>
<!DOCTYPE html>

<html lang="pt-br">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Emporio Registrar</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<link href="assets/css/sb-admin-2.css" rel="stylesheet">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/img//favicon-32x32.png">

</head>

<body class="bg-gradient-danger">
	<nav class="navbar navbar-expand-sm bg-danger">
		<a class="navbar-brand" href="<?php echo $redirecionar->index ?>"><img whidht='35' height='35' src="assets/img/logo-inicio-vedas.png" alt=""></a>
	</nav>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

	<script>
		$(document).ready(function() {

			$("#cadastrar").click(function(e) {
				let nome = document.getElemenById('inputName').value
				if (nome.lenght <= 0) {
					e.preventDefault()
				}
			});
		});
	</script>
	<div class="container">
		<div class="card o-hidden border-0 shadow-lg my-5">
			<div class="card-body p-0">
				<div class="row">
					<div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
					<div class="col-lg-7">
						<div class="p-5">
							<div class="text-center">
								<h1 class="h4 text-gray-900 mb-4">Cria uma conta!</h1>
							</div>
							<!-- CADASTRAR CLIENTE -->
							<form class="user" method="POST" action="<?php echo $redirecionar->processaCliente ?>">
								<div class="form-group row">
									<div class="col-sm-6 mb-3 mb-sm-0">
										<input type="text" class="form-control " id="inputName" placeholder="Nome Completo" name="nome" required>
										<small class="text-muted"></small>
									</div>
									<div class="col-sm-6">
										<input type="tel" class="form-control " id="telefone" placeholder="Telefone" name="telefone" size="16" maxlength="15" value="" required>
									</div>
								</div>
								<div class="form-group">
									<input type="email" class="form-control " id="inputEmail" placeholder="Email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" name="email" required>
									<small class="text-muted"></small>

								</div>
								<div class="form-group">
									<input type="password" class="form-control" placeholder="Senha" name="senha" pattern=".{6,}" id="inputPassword" required title="Senha deve ser maior que 6 caracteres">
									<small class="text-muted"></small>

								</div>
								<div class="form-group">
									<input type="password" class="form-control" placeholder="Confirmar senha" pattern=".{6,}" required title="Senha deve ser maior que 6 caracteres">
								</div>
								<div class="form-group">
									<select required name="bairro" id="select" class="form-control">
										<!-- LISTAR BAIRROS  -->
										<option value="">Selecione o bairro</option>
										<?php
										$cliente->listarBairros();
										?>
									</select>

								</div>
								<div class="form-group row">
									<div class="col-sm-6 mb-3 mb-sm-0">
										<input type="text" class="form-control" placeholder="Rua" name="rua" required>
									</div>
									<div class="col-sm-6">
										<input type="text" class="form-control" placeholder="Número" name="numero" required>
									</div>

								</div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Complemento/opcional" name="complemento">
								</div>
								<input id="cadastrar" type="submit" class="btn btn-primary btn-block" name="sign-in" value="Cadastrar">
								<hr>
								<a href="" class="btn btn-primary btn-block">
									<i class="fab fa-facebook-f fa-fw"></i> Cadastrar com o Facebook
								</a>
							</form>
							<hr>
							<div class="text-center">
								<a class="small" href="<?php echo $redirecionar->login ?>">Já possui uma conta? Faça o
									login!</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="assets/js/validar-campos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>

</html>