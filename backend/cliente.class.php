<?php
include_once "conexao.php";
include_once "rotas.class.php";

class Cliente
{
	// public $cliente_id;
	public $cliente_nome;
	public $cliente_telefone;
	public $cliente_email;
	public $cliente_senha;

	public function cadastrarCliente($cliente_nome, $cliente_telefone, $cliente_email, $cliente_senha)
	{
		if ($cliente_senha == '') {
			$_SESSION['complete-cadastro'] = 1;
		}
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "INSERT INTO cad_cliente (cliente_nome, cliente_telefone, cliente_email, cliente_senha) VALUES ('$cliente_nome', '$cliente_telefone', '$cliente_email', '$cliente_senha') ";
		$execute = mysqli_query($conn, $prepare);
		if ($execute) {
			return true;
		} else {
			return false;
		}
		mysqli_close($conn);
	}

	public function cadastrarEndereco($cliente_id, $bairro_id, $endereco_logradouro, $endereco_nr, $endereco_complemento)
	{
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "INSERT INTO cad_endereco (cliente_id, bairro_id, endereco_tipo, endereco_logradouro, endereco_nr, endereco_complemento) VALUES ('$cliente_id', '$bairro_id', '0', '$endereco_logradouro', '$endereco_nr', '$endereco_complemento')";
		$execute = mysqli_query($conn, $prepare);
		if ($execute) {
			return true;
		} else {
			return false;
		}
		mysqli_close($conn);
	}
	public function cadastrarEnderecoFacebook($cliente_id, $bairro_id, $endereco_logradouro, $endereco_nr, $endereco_complemento, $cliente_telefone)
	{
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "INSERT INTO cad_endereco (cliente_id, bairro_id, endereco_tipo, endereco_logradouro, endereco_nr, endereco_complemento) VALUES ('$cliente_id', '$bairro_id', '0', '$endereco_logradouro', '$endereco_nr', '$endereco_complemento')";
		$execute = mysqli_query($conn, $prepare);
		if ($execute) {
			$prepare = "UPDATE cad_cliente
           SET cliente_telefone = '$cliente_telefone' WHERE cliente_id = '$cliente_id'";
			$execute = mysqli_query($conn, $prepare);
			return 1;
		} else {
			return 0;
		}

		mysqli_close($conn);
	}

	public function pesquisarCliente($cliente_email)
	{
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "SELECT * FROM cad_cliente WHERE cliente_email = '$cliente_email'";
		$execute = mysqli_query($conn, $prepare);
		while ($cliente = mysqli_fetch_assoc($execute)) {
			return $cliente['cliente_id'];
		}
		mysqli_close($conn);
	}

	public function pesquisarClienteTelefone($cliente_id)
	{
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "SELECT cliente_telefone FROM cad_cliente WHERE cliente_id = '$cliente_id'";
		$execute = mysqli_query($conn, $prepare);
		while ($cliente = mysqli_fetch_assoc($execute)) {
			$telefone = $cliente['cliente_telefone'];
			$telefone1 = str_replace('(', ' ', $telefone);
			return $telefone1;
		}
		mysqli_close($conn);
	}

	public function pesquisarNomeCliente($cliente_email)
	{
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "SELECT cliente_nome FROM cad_cliente WHERE cliente_email = '$cliente_email'";
		$execute = mysqli_query($conn, $prepare);
		while ($cliente = mysqli_fetch_assoc($execute)) {
			return $cliente['cliente_nome'];
		}
		mysqli_close($conn);
	}

	public function pesquisarNomeClienteId($cliente_id)
	{
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "SELECT cliente_nome FROM cad_cliente WHERE cliente_id = '$cliente_id'";
		$execute = mysqli_query($conn, $prepare);
		while ($cliente = mysqli_fetch_assoc($execute)) {
			return $cliente['cliente_nome'];
		}
		mysqli_close($conn);
	}
	public function pesquisarTelefone($cliente_id)
	{
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "SELECT cliente_telefone FROM cad_cliente WHERE cliente_id = '$cliente_id'";
		$execute = mysqli_query($conn, $prepare);
		while ($cliente = mysqli_fetch_assoc($execute)) {
			$telefone = $cliente['cliente_telefone'];
			$result = str_replace('(', "", $telefone);
			$result2 = str_replace(')', "", $result);
			$result3 = str_replace(' ', "", $result2);
			$result4 = str_replace('-', "", $result3);
			return $result4;
		}
		mysqli_close($conn);
	}

	public function fazerLogin($cliente_email, $cliente_senha)
	{
		$redirecionar = new Rotas();
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "SELECT * FROM cad_cliente WHERE cliente_email = '$cliente_email' AND cliente_senha = '$cliente_senha'";
		mysqli_query($conn, $prepare);
		if ($conn->affected_rows == 1) {
			return 1;
		} else {
			return 0;
		}
		mysqli_close($conn);
	}

	function fazerLoginFacebook($cliente_email, $cliente_nome)
	{
		$login = 'facebooklogin';
		$_SESSION['facebooklogin'] = $login;
		$_SESSION['cliente_email'] = $cliente_email;
		$primeiroNome = explode(" ", $cliente_nome);
		//pegar primeiro nome
		$_SESSION['cliente_nome'] = $primeiroNome[0];
		$cliente_telefone = 'telefone';
		$cliente_senha = '';
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "SELECT * FROM cad_cliente WHERE cliente_email = '$cliente_email'";
		mysqli_query($conn, $prepare);
		if ($conn->affected_rows == 1) {
			$_SESSION['cliente_id'] = $this->pesquisarCliente($cliente_email);
			echo 1;
			// if (isset($_SESSION['facebooklogin'])) {
			//     unset($_SESSION['facebooklogin']);
			// }

		} else {
			$this->cadastrarCliente($cliente_nome, $cliente_telefone, $cliente_email, $cliente_senha);
			$_SESSION['cliente_id'] = $this->pesquisarCliente($cliente_email);
			echo 2;
			//$this->fazerLoginFacebook($cliente_email, $cliente_id, $cliente_nome);
		}
		mysqli_close($conn);
	}

	public function listarBairros()
	{
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "SELECT * FROM cad_bairro ORDER BY bairro_nome";
		$execute = mysqli_query($conn, $prepare);
		while ($bairros = mysqli_fetch_assoc($execute)) {
			echo '<option value=' . $bairros['bairro_id'] . '>' . utf8_encode($bairros['bairro_nome']) . '</option>';
		}
		mysqli_close($conn);
	}

	function logout()
	{
		if (isset($_SESSION['cliente_id'])) {
			session_unset();
			$redirecionar = new Rotas();
			$redirecionar->redirecionar($redirecionar->index);
		}
	}

	public function verificarLogado()
	{
		$redirecionar = new Rotas();
		if (isset($_SESSION['cliente_id'])) {
			?>


		<li class="nav-item">
			<a class="nav-link">Olá, <?php echo $_SESSION['cliente_nome']; ?>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?php echo $redirecionar->meusPedidos ?>">Pedidos
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="<?php echo $redirecionar->meuPerfil ?>">Editar Dados
			</a>
		</li>
		<li class="nav-item">
			<form action="<?php $redirecionar->processaCliente ?>" method="post">
				<input type="submit" class="nav-link" name="logout" value="Sair" style="border:0px; background:none;">
			</form>
		</li>
	<?php
	} else {
		?>
		<a class="nav-link" href="<?php echo $redirecionar->login ?>"><img src="" whidht='27' height='27' alt="" class="mr-2"> Entrar<span class="sr-only">(current)</span></a>
	<?php
	}
}

function enderecoPadrao($cliente_id)
{
	$conexao = new Conexao();
	$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
	$prepare = "SELECT * FROM cad_endereco WHERE cliente_id = '$cliente_id' AND endereco_tipo = '0'";
	$execute = mysqli_query($conn, $prepare);
	while ($enderecos = mysqli_fetch_assoc($execute)) {
		$bairro_id = $enderecos['bairro_id'];
		$rua = $enderecos['endereco_logradouro'];
		$numero = $enderecos['endereco_nr'];
		$complemento = $enderecos['endereco_complemento'];
		$prepare2 = "SELECT * FROM cad_bairro WHERE bairro_id = '$bairro_id'";
		$execute2 = mysqli_query($conn, $prepare2);
		while ($bairroDados = mysqli_fetch_assoc($execute2)) {
			$bairro = $bairroDados['bairro_nome'];
			$taxa = $bairroDados['bairro_taxa'];
		}
	}
	if ($complemento == '' || $complemento == null) {
		?>
		<h6> <?php echo "$rua, Nº:$numero, Bairro: $bairro" ?></h6>
	<?php
	} else {
		?>
		<h6> <?php echo "$rua, Nº:$numero, Bairro: $bairro, $complemento" ?></h6>
	<?php
	}
	mysqli_close($conn);
}

function enderecoEntrega($cliente_id)
{
	$conexao = new Conexao();
	$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
	$prepare = "SELECT * FROM cad_endereco WHERE cliente_id = '$cliente_id' AND endereco_tipo = '0'";
	$execute = mysqli_query($conn, $prepare);
	while ($enderecos = mysqli_fetch_assoc($execute)) {
		$endereco_id = $enderecos['endereco_id'];
		if ($enderecos['bairro_id'] == 1) {
			return 0;
		} else {
			return $endereco_id;
		}
	}
	mysqli_close($conn);
}

function listarEnderecos($cliente_id)
{
	$conexao = new Conexao();
	$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
	$prepare = "SELECT * FROM cad_endereco WHERE cliente_id = '$cliente_id'";
	$execute = mysqli_query($conn, $prepare);
	while ($enderecos = mysqli_fetch_assoc($execute)) {
		$endereco_id = $enderecos['endereco_id'];
		$bairro_id = $enderecos['bairro_id'];
		$rua = $enderecos['endereco_logradouro'];
		$numero = $enderecos['endereco_nr'];
		$complemento = $enderecos['endereco_complemento'];
		$prepare2 = "SELECT * FROM cad_bairro WHERE bairro_id = '$bairro_id'";
		$execute2 = mysqli_query($conn, $prepare2);
		while ($bairroDados = mysqli_fetch_assoc($execute2)) {
			$bairro = $bairroDados['bairro_nome'];
			$taxa = $bairroDados['bairro_taxa'];

			?>
			<div class='card mt-1'>
				<div class='card-body'>
					<div class='d-flex'>
						<?php if ($complemento == '' || $complemento == null) { ?>
							<div class='d-flex flex-row mr-5'>
								<h6 class='local-pedido'> <?php echo "$rua, Nº:$numero, Bairro: $bairro" ?></h6>
							</div>
						<?php } else { ?>
							<div class='d-flex flex-row mr-5'>
								<h6 class='local-pedido'> <?php echo "$rua, Nº:$numero, Bairro: $bairro, $complemento" ?>
								</h6>
							</div>
						<?php } ?>
						<div class='d-flex flex-row-reverse pt-1'>
							<label class='checkbox'>
								<input type='radio' name='endereco-1' value="<?php echo $endereco_id ?>" required>
								<span class='danger'></span>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
	}
	?>
	<?php
	mysqli_close($conn);
}

function listarTodosDados($cliente_id)
{
	$conexao = new Conexao();
	$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
	$prepare = "SELECT cad_cliente.cliente_nome, cad_cliente.cliente_telefone, cad_cliente.cliente_email, cad_cliente.cliente_senha, cad_endereco.bairro_id, cad_endereco.endereco_tipo, cad_endereco.endereco_logradouro, cad_endereco.endereco_nr, cad_endereco.endereco_complemento,
                CASE cad_endereco.endereco_tipo
                WHEN 0 THEN 'Endereço Principal'
                WHEN 1 THEN 'Outro Endereço'
                END AS enderecoTipo
                FROM cad_cliente, cad_endereco WHERE cad_cliente.cliente_id = '$cliente_id' AND cad_endereco.cliente_id = '$cliente_id' AND cad_endereco.endereco_tipo = '0'";
	$execute = mysqli_query($conn, $prepare);
	while ($dados = mysqli_fetch_assoc($execute)) {
		$nome = $dados['cliente_nome'];
		$telefone = $dados['cliente_telefone'];
		$email = $dados['cliente_email'];
		$senha = $dados['cliente_senha'];
		$bairro_id = $dados['bairro_id'];
		$enderecoTipo = $dados['enderecoTipo'];
		$endereco_tipo = $dados['endereco_tipo'];
		$rua = $dados['endereco_logradouro'];
		$numero = $dados['endereco_nr'];
		$complemento = $dados['endereco_complemento'];
		//pegar bairro
		if ($bairro_id == '' || $bairro_id == null) {
			return 0;
		} else {
			$prepare2 = "SELECT * FROM cad_bairro WHERE bairro_id = '$bairro_id'";
			$execute2 = mysqli_query($conn, $prepare2);
			while ($bairroDados = mysqli_fetch_assoc($execute2)) {
				$bairro = $bairroDados['bairro_nome'];
				$taxa = $bairroDados['bairro_taxa'];
			}
		}
	}
	if ($conn->affected_rows <= 0) {
		$nome = '';
		$telefone = '';
		$email = '';
		$senha = '';
		$bairro_id = '';
		$enderecoTipo = '';
		$endereco_tipo = '';
		$rua = '';
		$numero = '';
		$complemento = '';
		$bairro = '';
		$taxa = '';
		echo "<script>alert('Você não possui endereço principal cadastrado')</script>";
	}
	?>
	<!-- Dados perfil -->
	<div class="form-group">
		<label for="">Nome</label>
		<input type="text" class="form-control " placeholder="Digite seu nome" value="<?php echo $nome ?>" name="cliente-nome">
	</div>
	<?php if ($telefone == 'telefone' || $telefone == '') { ?>
		<div class="form-group">
			<label for="">Telefone</label>
			<input type="text" class="form-control " placeholder=" Digite seu telefone" name="cliente-telefone">
		</div>
	<?php } else { ?>
		<div class="form-group">
			<label for="">Telefone</label>
			<input type="tel" class="form-control " id="telefone" placeholder="Digite telefone" size="16" maxlength="15" value="<?php echo $telefone ?>" name="cliente-telefone">
		</div>
	<?php } ?>
	<?php if ($senha == '') { ?>
		<!-- verificar se entrou com facebook -->
		<!-- NÃO EXIBE NADA SE A SENHA ESTIVER VAZIA -->
		<div class="form-group">
			<label for="">E-mail</label>
			<input type="email" class="form-control " value="<?php echo $email ?>" name="cliente-email">
		</div>
		<!-- readonly="true" -->
	<?php } else { ?>
		<div class="form-group">
			<label for="">E-mail</label>
			<input type="email" class="form-control " value="<?php echo $email ?>" name="cliente-email">
		</div>
		<div class="form-group">
			<label for="">Senha</label>
			<input id="senha1" type="password" class="form-control" value="<?php echo $senha ?>" name="cliente-senha">
		</div>
		<div class="form-group">
			<label for="">Confirmar Senha</label>

			<input id="senha2" type="password" class="form-control" placeholder="Confirmar senha" name="cliente-senha2">
		</div>
	<?php } ?>
	<!-- Dados perfil -->
	</div>

	<div class="p-3 card">
		<h4 class="h4 text-gray-900 mb-1">Endereço de entrega</h4>
		<div class="d-flex justify-content-start">
			<button type="button" class="btn btn-danger btn-sm p-2 mb-2" data-toggle="modal" data-target="#exampleModal">
				Meus endereços
			</button>
		</div>

		<!-- Endereço -->
		<div class="form-group">
			<select name="bairro" id="select" class="form-control" required>
				<!-- LISTAR BAIRROS  -->
				<option value="<?php echo $bairro_id ?>"><?php echo $bairro ?></option>
				<?php
				$cliente = new Cliente();
				$cliente->listarBairros();
				?>
			</select>
		</div>

		<div class="form-group row">
			<?php if ($rua == 'logradouro' || $rua == '') { ?>
				<div class="col-sm-6 mb-3 mb-sm-0">
					<input required type="text" class="form-control " placeholder="Logradouro" name="rua-nome">
				</div>
			<?php } else { ?>
				<div class="col-sm-6 mb-3 mb-sm-0">
					<input type="text" class="form-control " value="<?php echo $rua ?>" name="rua-nome">
				</div>
			<?php }
			if ($numero == 0 || $numero == '') { ?>
				<div class="col-sm-6">
					<input required type="tel" class="form-control " placeholder="Número" name="rua-nr">
				</div>
			<?php } else { ?>
				<div class="col-sm-6">
					<input type="tel" class="form-control " value="<?php echo $numero ?>" name="rua-nr">
				</div>
			<?php } ?>
		</div>
		<?php if ($complemento == '') { ?>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Complemento(opcional)" name="complemento">
			</div>
		<?php } else { ?>
			<div class="form-group">
				<input type="text" class="form-control" value="<?php echo $complemento ?>" name="complemento">
			</div>
		<?php } ?>
		<input type="submit" class="btn btn-danger btn-block" name="editar-dados" onClick="validarSenha()" value="Salvar">

		<!-- Endereço -->
		<?php
		mysqli_close($conn);
	}

	function atualizarDados($cliente_id, $nome, $telefone, $email, $senha, $bairro_id, $endereco_tipo, $logradouro, $endereco_nr, $complemento)
	{
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "UPDATE cad_cliente, cad_endereco SET cad_cliente.cliente_nome = '$nome', cad_cliente.cliente_telefone = '$telefone', cad_cliente.cliente_email = '$email', cad_cliente.cliente_senha = '$senha', cad_endereco.bairro_id = '$bairro_id', cad_endereco.endereco_tipo = '$endereco_tipo', cad_endereco.endereco_logradouro = '$logradouro', cad_endereco.endereco_nr = '$endereco_nr', cad_endereco.endereco_complemento = '$complemento' WHERE cad_cliente.cliente_id = '$cliente_id' AND cad_endereco.cliente_id = '$cliente_id'";
		$execute = mysqli_query($conn, $prepare);
		if ($conn->affected_rows != 0) {
			$redirecionar = new Rotas();
			echo "<script> alert('Alterado com sucesso')</script>";
			if ($_SESSION['pedido'] != null) {
				$redirecionar->redirecionar($redirecionar->finalizarCompra);
			}
			$redirecionar->redirecionar($redirecionar->meuPerfil);
		} else {
			return 0;
		}
		mysqli_close($conn);
	}

	function novoEndereco($cliente_id, $bairro_id, $logradouro, $numero, $complemento)
	{
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "INSERT INTO cad_endereco (cliente_id, bairro_id, endereco_tipo, endereco_logradouro, endereco_nr, endereco_complemento) VALUES ('$cliente_id', '$bairro_id', 1, '$logradouro', '$numero', '$complemento')";
		$execute = mysqli_query($conn, $prepare);
		if ($conn->affected_rows != 0) {
			return 1;
		} else {
			return 0;
		}
		mysqli_close($conn);
	}

	function alterarEnderecoPrincipal($endereco_id, $cliente_id)
	{
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "UPDATE cad_endereco SET endereco_tipo = 1 WHERE cliente_id = '$cliente_id'";
		$execute = mysqli_query($conn, $prepare);
		$prepare2 = "UPDATE cad_endereco SET endereco_tipo = 0 WHERE endereco_id = '$endereco_id'";
		$execute2 = mysqli_query($conn, $prepare2);
		if ($conn->affected_rows != 0) {
			return 1;
		} else {
			return 0;
		}
		mysqli_close($conn);
	}

	function deletarEndereco($endereco_id)
	{
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "DELETE FROM cad_endereco WHERE endereco_id = '$endereco_id' AND NOT endereco_tipo = 0";
		$execute = mysqli_query($conn, $prepare);
		if ($conn->affected_rows > 0) {
			return 1;
		} else {
			return 0;
		}
		mysqli_close($conn);
	}
	function listarClientes()
	{
		$conexao = new Conexao();
		$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
		$prepare = "SELECT * FROM cad_cliente";
		$execute = mysqli_query($conn, $prepare);
		while ($clientes = mysqli_fetch_assoc($execute)) {
			echo $clientes['cliente_id'] . '<br>';
			echo $clientes['cliente_nome'] . '<br>';
			echo $clientes['cliente_telefone'] . '<br>';
			echo $clientes['cliente_email'] . '<br>';
		}
		mysqli_close($conn);
	}
	public function codeDesbloqueio()
	{
		$data = date("l");
		$code = md5($data);
		$resultado = substr($code, -4); 
		echo $resultado;
	}
} // fecha a classe
$cliente = new Cliente();
// CADASTRANDO CLIENTE
if (isset($_POST['sign-in'])) {
	$cliente_nome = $_POST['nome'];
	$cliente_telefone = $_POST['telefone'];
	$cliente_email = $_POST['email'];
	$cliente_senha = $_POST['senha'];
	$bairro = $_POST['bairro'];
	$rua = $_POST['rua'];
	$numero = $_POST['numero'];
	$complemento = $_POST['complemento'];
	$validar = $cliente->cadastrarCliente($cliente_nome, $cliente_telefone, $cliente_email, $cliente_senha);
	if ($validar) {
		$cliente_id = $cliente->pesquisarCliente($cliente_email);
		$cliente->cadastrarEndereco($cliente_id, $bairro, $rua, $numero, $complemento);
		$_SESSION['cliente_id'] = $cliente_id;
		// pegar primeiro nome
		$primeiroNome = explode(" ", $cliente_nome);
		//pegar primeiro nome
		$_SESSION['cliente_nome'] = $primeiroNome[0];
		$redirecionar = new Rotas();
		if (isset($_SESSION['pedido'])) {
			$redirecionar->redirecionar($redirecionar->finalizarCompra);
		} else {
			$redirecionar->redirecionar($redirecionar->index);
		}
	} else {
		echo "Erro";
	}
}

//FAZENDO LOGIN
if (isset($_POST['login'])) {
	$cliente_email = $_POST['email'];
	$cliente_senha = $_POST['senha'];
	$validar = $cliente->fazerLogin($cliente_email, $cliente_senha);
	$redirecionar = new Rotas();
	if ($validar == 1) {
		$cliente_id = $cliente->pesquisarCliente($cliente_email);
		$cliente_nome = $cliente->pesquisarNomeCliente($cliente_email);
		$_SESSION['cliente_id'] = $cliente_id;
		// pegar primeiro nome
		$primeiroNome = explode(" ", $cliente_nome);
		//pegar primeiro nome
		$_SESSION['cliente_nome'] = $primeiroNome[0];
		if (isset($_SESSION['pedido'])) {
			$redirecionar->redirecionar($redirecionar->finalizarCompra);
		} else {
			$redirecionar->redirecionar($redirecionar->index);
		}
	} else if ($validar == 0) {
		$_SESSION['erro-login'] = 1;
		$redirecionar->redirecionar($redirecionar->login);
	}
}

//FAZENDO LOGOUT
if (isset($_POST['logout'])) {
	$cliente->logout();
}

//EDITAR DADOS
if (isset($_POST['editar-dados'])) {
	$cliente_id = $_SESSION['cliente_id'];
	$nome = $_POST['cliente-nome'];
	$telefone = $_POST['cliente-telefone'];
	$email = $_POST['cliente-email'];
	$senha = $_POST['cliente-senha'];
	$senha2 = $_POST['cliente-senha2'];
	$bairro_id = $_POST['bairro'];
	$logradouro = $_POST['rua-nome'];
	$endereco_nr = $_POST['rua-nr'];
	$complemento = $_POST['complemento'];
	if ($senha == $senha2) {
		$cliente->atualizarDados($cliente_id, $nome, $telefone, $email, $senha, $bairro_id, 0, $logradouro, $endereco_nr, $complemento);
	}
}

if (isset($_POST['novo-enderecoPerfil'])) {
	$cliente_id = $_SESSION['cliente_id'];
	$bairro_id = $_POST['bairro2'];
	$logradouro = $_POST['rua-nome2'];
	$endereco_nr = $_POST['rua-nr2'];
	$complemento = $_POST['complemento2'];
	$redirecionar = new Rotas();
	if ($cliente->novoEndereco($cliente_id, $bairro_id, $logradouro, $endereco_nr, $complemento) == 1) {
		echo "<script> alert('Endereço adicionado com sucesso')</script>";
		$redirecionar->redirecionar($redirecionar->meuPerfil);
	}
}

if (isset($_POST['novo-endereco'])) {
	$cliente_id = $_SESSION['cliente_id'];
	$bairro_id = $_POST['bairro2'];
	$logradouro = $_POST['rua-nome2'];
	$endereco_nr = $_POST['rua-nr2'];
	$complemento = $_POST['complemento2'];
	$redirecionar = new Rotas();
	if ($cliente->novoEndereco($cliente_id, $bairro_id, $logradouro, $endereco_nr, $complemento) == 1) {
		echo "<script> alert('Endereço adicionado com sucesso')</script>";
		if ($_SESSION['pedido'] != null) {
			$redirecionar->redirecionar($redirecionar->finalizarCompra);
		} else {
			$redirecionar->redirecionar($redirecionar->index);
		}
	}
}
if (isset($_POST['cadastrar-endereco-facebook'])) {
	$cliente_id = $_SESSION['cliente_id'];
	$bairro_id = $_POST['bairro2'];
	$logradouro = $_POST['rua-nome2'];
	$endereco_nr = $_POST['rua-nr2'];
	$complemento = $_POST['complemento2'];
	$telefone = $_POST['telefone'];
	$redirecionar = new Rotas();
	if ($cliente->cadastrarEnderecoFacebook($cliente_id, $bairro_id, $logradouro, $endereco_nr, $complemento, $telefone) == 1) {
		echo "<script> alert('Endereço adicionado com sucesso')</script>";
		if ($_SESSION['pedido'] != null) {
			$redirecionar->redirecionar($redirecionar->finalizarCompra);
		} else {
			$redirecionar->redirecionar($redirecionar->meuPerfil);
		}
		unset($_SESSION['facebooklogin']);
	}
}
if (isset($_POST['alterar-entregaPerfil'])) {
	if (isset($_SESSION['cliente_id'])) {
		$endereco_id = $_POST['endereco-1'];
		$redirecionar = new Rotas();
		if ($cliente->alterarEnderecoPrincipal($endereco_id, $_SESSION['cliente_id']) == 1) {
			echo "<script> alert('Endereço alterado com sucesso')</script>";
			if ($_SESSION['pedido'] != null) {
				$redirecionar->redirecionar($redirecionar->finalizarCompra);
			} else {
				$redirecionar->redirecionar($redirecionar->meuPerfil);
			}
		} else {
			echo "<script> alert('Não foi possível, tente novamente')</script>";
			$redirecionar->redirecionar($redirecionar->meuPerfil);
		}
	}
}
if (isset($_POST['alterar-entrega'])) {
	if (isset($_SESSION['cliente_id'])) {
		$endereco_id = $_POST['endereco-1'];
		$redirecionar = new Rotas();
		if ($cliente->alterarEnderecoPrincipal($endereco_id, $_SESSION['cliente_id']) == 1) {
			echo "<script> alert('Salvo com sucesso')</script>";
			$redirecionar->redirecionar($redirecionar->finalizarCompra);
		} else {
			echo "<script> alert('Não foi possível, tente novamente')</script>";
			$redirecionar->redirecionar($redirecionar->finalizarCompra);
		}
	}
}
if (isset($_POST['deletar-enderecoPerfil'])) {
	if (isset($_SESSION['cliente_id'])) {
		$redirecionar = new Rotas();
		$endereco_id = $_POST['endereco-1'];
		if ($cliente->deletarEndereco($endereco_id) > 0) {
			echo "<script>alert('Deletado com sucesso')</script>";
			$redirecionar->redirecionar($redirecionar->meuPerfil);
		} else {
			echo "<script>alert('Não é possível deletar o endereço principal')</script>";
			$redirecionar->redirecionar($redirecionar->meuPerfil);
		}
	}
}
//LOGIN FACEBOOK
if (isset($_POST['cliente_id'])) {
	$cliente_nome = $_POST['nome'];
	$cliente_email = $_POST['email'];
	$cliente->fazerLoginFacebook($cliente_email, $cliente_nome);
}
if (isset($_POST['validar-numero'])) {
	if (isset($_POST['number-tel'])) {
		$ch = curl_init();
		$code = rand(1000, 9999); // random 4 digit code
		$_SESSION['code'] = $code;
		if (isset($_POST['number-tel'])) {
			$number = $_POST['number-tel'];
			$_SESSION['tel-user'] = $_POST['number-tel'];
			// store code for later
			$data = array(
				'key'       => 'OD0X0R9SDSSBWXZGYVG8CYXA',
				'type'        => '9',
				'number'      => $number,
				'msg'         => 'Confirme seu pedido no Massa&Cia com o código: ' . $code
			);

			curl_setopt($ch, CURLOPT_URL, 'http://api.smsdev.com.br/send');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$res    = curl_exec($ch);
			$err    = curl_errno($ch);
			$errmsg = curl_error($ch);
			$header = curl_getinfo($ch);

			curl_close($ch);
			$redirecionar = new Rotas();
			$redirecionar->redirecionar($redirecionar->validarCodigo);
		}
	}
}
if (isset($_POST['code-confirm'])) {
	$data = date("l");
	$code = md5($data);
	$resultado = substr($code, -4); 
	if ($_SESSION['code'] == $_POST['code-confirm']) {
		$redirecionar = new Rotas();
		if ($_SESSION['facebooklogin']){
		$redirecionar->redirecionar($redirecionar->usuarioEndereco);
		unset($_SESSION['code']);
		};
		$redirecionar->redirecionar($redirecionar->usuarioCadastro);
		unset($_SESSION['code']);
	} if ($resultado == $_POST['code-confirm']) {
		$redirecionar = new Rotas();
		if ($_SESSION['facebooklogin']){
		$redirecionar->redirecionar($redirecionar->usuarioEndereco);
		unset($_SESSION['code']);
		};
		$redirecionar->redirecionar($redirecionar->usuarioCadastro);
		unset($_SESSION['code']);
	} else {
		$redirecionar = new Rotas();
		$redirecionar->redirecionar($redirecionar->validarCodigo);
	}
}
 
if (isset($_POST['send-user'])) {
	$redirecionar = new Rotas();
	$cliente_nome = $_POST['name-user'];
	$cliente_email = $_POST['email-user'];
	$cliente_senha = $_POST['password-user'];
	$cliente_telefone = ($_SESSION['tel-user']);
	$primeiroNome = explode(" ", $cliente_nome);
	//pegar primeiro nome
	$_SESSION['cliente_nome'] = $primeiroNome[0];
	$validar = $cliente->cadastrarCliente($cliente_nome, $cliente_telefone, $cliente_email, $cliente_senha);
	if ($validar) {
		$cliente_id = $cliente->pesquisarCliente($cliente_email);
		$_SESSION['cliente_id'] = $cliente_id;
		$redirecionar->redirecionar($redirecionar->usuarioEndereco);
	} else {
		$redirecionar->redirecionar($redirecionar->usuarioCadastro);
	}
}
if (isset($_POST['send-adress'])) {
	$redirecionar = new Rotas();
	$cliente_id = $_SESSION['cliente_id'];
	$bairro_id = $_POST['user-bairro'];
	$endereco_logradouro = $_POST['user-rua'];
	$endereco_nr = $_POST['user-numero'];
	$endereco_complemento = $_POST['user-complemento'];
	$cliente_telefone = $_SESSION['tel-user'];
	if ($cliente->cadastrarEnderecoFacebook($cliente_id, $bairro_id, $endereco_logradouro, $endereco_nr, $endereco_complemento,$cliente_telefone) == 1) {
		if ($_SESSION['pedido'] != null) {
			$redirecionar->redirecionar($redirecionar->finalizarCompra);
		} else {
			$redirecionar->redirecionar($redirecionar->index);
		}
	}
}
?>