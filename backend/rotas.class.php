<?php
session_start();
class Rotas
{
	public $path = '\\jhonatanborg';
	public $indexAdm = '/massaecia/adm/index.php';
	// public $indexUser = '/index.php';
	public $processaTelefone = '/massaecia/backend/telefone.class.php';
	public $processaProduto = '/massaecia/backend/produto.class.php';
	public $processaIngrediente = '/massaecia/backend/ingrediente.class.php';
	public $processaTipo = '/massaecia/backend/tipo.class.php';
	public $processaCliente = '/massaecia/backend/cliente.class.php';
	public $index = '/massaecia'; //index da pagina principal
	public $finalizarCompra = '/massaecia/finalizar-compra.php';
	public $login = '/massaecia/fazer-login.php';
	public $cadastrar = '/massaecia/cadastrar.php';
	public $processaPedido = '/massaecia/backend/pedido.class.php';
	public $pedidoCaldo = '/massaecia/pedido-caldo.php';
	public $pedidoMacarrao = '/massaecia/pedido-macarrao.php';
	public $pedidoLanche = '/massaecia/lanches.php';
	public $homeMassa = '/massaecia/home-massa.php';
	public $usuarioCadastro = '/massaecia/usuario-cadastro.php';
	public $validarNumero = '/massaecia/confirmacao.php';
	public $validarCodigo = '/massaecia/confirmar-codigo.php';
	public $usuarioEndereco = '/massaecia/completar-dados.php';
	public $meuPerfil = '/massaecia/meu-perfil.php';
	public $pagamento = '/massaecia/pagamento.php';
	public $meusPedidos = '/massaecia/meus-pedidos.php';
	public $cadastrarProdutos = '/massaecia/adm/cadastrar-produto.php';
	public $cadastrarIngrediente = '/massaecia/adm/cadastrar-ingrediente.php';
	public $cadastrarTipo = '/massaecia/adm/cadastrar-tipo.php';
	public $iconEntrar = '/massaecia/assets/img/enter.png';
	public $iconProfile = '/massaecia/assets/img/profile.png';
	function redirecionar($local)
	{
		echo "<script>window.location.replace('$local')</script>;";
	}
}
