<?php
include_once "cliente.class.php";
include_once "conexao.php";
include_once "rotas.class.php";
include_once "produto.class.php";
include_once "ingrediente.class.php";
// $redirecionar = new Rotas();
class Pedido
{
public $Macarrao;
public $Caldo;
public $SaborCaldo;
public $Massas;
public $Temperos;
public $Molhos;
public $Ingredientes;
public $Adicionais;
public $Bebidas;

function finalizarCompra($cliente_id, $endereco_id, $pedido_descricao, $pedido_qtde, $pedido_valorbruto, $taxa_entrega, $pedido_liquido, $pgto_id, $pedido_trocopara, $pedido_obs, $tempo_espera) {
            $conexao = new Conexao();
            $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
            $prepare = "INSERT INTO cad_pedido (cliente_id, endereco_id, pedido_descricao, pedido_qtde, pedido_valorbruto, taxa_entrega, pedido_liquido, status_id, pgto_id, pedido_troco, pedido_obs, pedido_espera) VALUES ('$cliente_id', '$endereco_id', '$pedido_descricao', '$pedido_qtde', '$pedido_valorbruto', '$taxa_entrega', '$pedido_liquido', '0', '$pgto_id', '$pedido_trocopara', '$pedido_obs', '$tempo_espera')";
             $execute = mysqli_query($conn, $prepare);
            //  return $conn->affected_rows;
            if ($conn->affected_rows > 0) {
                return 1;
            } else {
                return 0;
            }
            
        mysqli_close($conn);
}
function taxaDeEntrega($bairro_id)
{
            if (isset($_SESSION['pedido'])) {
            $conexao = new Conexao();
            $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
            $prepare = "SELECT bairro_taxa FROM cad_bairro WHERE bairro_id = '$bairro_id'";
            $execute = mysqli_query($conn, $prepare);
            if ($conn->affected_rows > 0) {
                while ($taxa = mysqli_fetch_assoc($execute)) {
                    return $taxa['bairro_taxa'];
                }
            } else {
                return 'Falha';
            }
}
mysqli_close($conn);
}

function fazerPedido($pedido)
{
if (empty($_SESSION['pedido'])) {
$_SESSION['pedido'] = [];
}
if (!isset($_SESSION['notificar-sacola'])) {
$_SESSION['notificar-sacola'] = 1;
}
array_push($_SESSION['pedido'], $pedido);
}

function listarItens($produto_id)
{
$valorPedido = 0;
$conexao = new Conexao();
$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
$tipos = new Tipo();
$prepare  = "SELECT produto_descricao, produto_valor,tipo_id FROM cad_produto WHERE produto_id = '$produto_id'
UNION
SELECT ingrediente_descricao, ingrediente_valor,tipo_id FROM cad_ingrediente WHERE ingrediente_id = '$produto_id'";
$execute = mysqli_query($conn, $prepare);
while ($produtos = mysqli_fetch_assoc($execute)) {
$descricao = $produtos['produto_descricao'];
$valor = $produtos['produto_valor'] . ',';
$tipo = $produtos['tipo_id'];
echo "";
if ($valor > 0) {
    $valor2 = floatval($valor);
    $valor3 = number_format($valor2, 2, ',', ' ');
    echo "<h6 class='local-pedido'>" . utf8_encode($descricao);
    echo " R$: $valor3</h6>";
} else {
    echo "<h6 class='local-pedido'>" . $descricao . '</h6>';
}
}
mysqli_close($conn);
}
function somarValores($produto_id)
{
$conexao = new Conexao();
$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
$tipos = new Tipo();
$prepare  = "SELECT produto_valor FROM cad_produto WHERE produto_id = '$produto_id'
UNION
SELECT ingrediente_valor FROM cad_ingrediente WHERE ingrediente_id = '$produto_id'";
$execute = mysqli_query($conn, $prepare);
while ($valor = mysqli_fetch_assoc($execute)) {
$valorProduto = $valor['produto_valor'];
return $valorProduto;
}
}
function removerPedido($numeroPedido)
{     // echo "<h2>$numeroPedido</h2>";
unset($_SESSION['pedido'][$numeroPedido]);
}
function cancelarPedidoCliente($cancelarpedido)
{     // echo "<h2>$numeroPedido</h2>";
unset($_SESSION['carrinho']);
}

function exibirSacola()
{
if (isset($_SESSION['pedido'])) {
$pedido = $_SESSION['pedido'];
$total = 0;

if ($_SESSION['pedido'] != null) {
    foreach ($pedido as $key => $value1) {
        $numeroPedido = intval($key) + 1;
        echo "
<form action='' method='post'>
<div class='card shadow border-0 p-3 mt-3'>
<div class='d-flex flex-row justify-content-between my-flex-container'>
<h6 class='text-default'>Pedido $numeroPedido </h6>
<input type='hidden' name='numeroPedido' value= '$key'>
<button type='submit' class='card-link reset-button'name='remover-pedido' id='remover'>Remover</button>
</div>
";
        foreach ($value1 as $keyItem => $itemValue) {
            if (is_array($itemValue)) {

                $count = count(array_filter($itemValue));
                echo "<span class='font-bold'>" . $keyItem . ':</span>';
                foreach ($itemValue as $key => $value2) {
                    // echo ' ' .$itemValue[$key].',';
                }
                foreach ($itemValue as $key2 => $value2) {
                    $this->listarItens($value2);
                    echo "
                ";
                    $somar = $this->somarValores($value2);
                    $total += $somar;
                }
            } else {
                $count = 0;
            }
        }
        echo "

</div>
</form>
";
    }
    echo "
<div class='card p-3 mt-3'>
<div class='d-flex flex-row justify-content-between my-flex-container'>
<h6>Total:<h6>
<h6> R$" . number_format(floatval($total), 2, ',', ' ') . "</h6>
</div>
</div>
<form action='' method='post'>
<div class='modal-footer p-1'>
<div class='d-flex justify-content-between'>
<button type='button' class='btn btn-secondary' data-dismiss='modal'>Adicionar mais itens</button>
<button type='submit' class='btn btn-danger color-white' name='finalizar-compra'>Finalizar compra</button>
</form>
</div>
</div>
";
}
}
}

function meuBairro($cliente_id)
{
$conexao = new Conexao();
$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
$prepare = "SELECT * FROM cad_endereco WHERE cliente_id = '$cliente_id'";
$execute = mysqli_query($conn, $prepare);
while ($enderecos = mysqli_fetch_assoc($execute)) {
$bairro_id = $enderecos['bairro_id'];
$prepare2 = "SELECT bairro_taxa FROM cad_bairro WHERE bairro_id = '$bairro_id'";
$execute2 = mysqli_query($conn, $prepare2);
while ($bairroDados = mysqli_fetch_assoc($execute2)) {
    $taxa = $bairroDados['bairro_taxa'];
}
}
return $taxa;
}

function finalizarPedido()
{
if (isset($_SESSION['pedido'])) {
$conexao = new Conexao();
$ingredientes = new Ingrediente();
$redirecionar = new Rotas();
$conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
$total = 0;
if ($_SESSION['pedido'] != null) {
    $cliente_id = $_SESSION['cliente_id'];
    $produtos = $_SESSION['pedido'];
    $taxa = $this->meuBairro($cliente_id);
    ?>
<div class='card shadow border-0 p-3 mt-3'>
    <?php
        foreach ($produtos as $key => $value) {
            $numeroPedido = intval($key) + 1;
            echo "

<div class='d-flex flex-row justify-content-between my-flex-container'>
<h6 class='text-default mt-3'>Pedido $numeroPedido </h6>

</div>
";
            foreach ($value as $keyItem => $itemValue) {
                if (is_array($itemValue)) {

                    $count = count(array_filter($itemValue));
                    echo "<span class='font-bold'>" . $keyItem . ':</span>';
                    foreach ($itemValue as $key => $value2) {
                        // echo ' ' .$itemValue[$key].',';
                    }
                    foreach ($itemValue as $key2 => $value2) {
                        $this->listarItens($value2);
                        echo "
        ";
                        $somar = $this->somarValores($value2);
                        $total += $somar;
                    }
                } else {
                    $count = 0;
                }
            }
        }
        echo "
        <div class='form-group mt-3'>
        <div class='d-flex justify-content-end'>
        <button type='submit' class='btn btn-secondary' name='cancelar-pedido'>Cancelar Pedido</button>
        </div>
        <br>
        <label>Escreva um comentário</label>
        <input type='textarea' class='form-control' name='pedido_obs' aria-describedby='helpId' placeholder='Ex: tirar alho, a parte, etc.'>
        </div>";
        echo "
        <div class='card mt-2'>
        <h6 class='text-danger' id='entregar'>
        <div class='d-flex flex-row justify-content-between my-flex-container'>
        <h6>Taxa de Entrega:</h6>
        <h6>R$" . number_format(floatval($taxa), 2, ',', ' ') . "</h6>
        </div>
        <div class='d-flex flex-row justify-content-between my-flex-container'>
        <h6>Valor do Pedido:</h6>
        <h6>R$" . number_format(floatval($total), 2, ',', ' ') . "</h6>
        </div>
        <h5 class='text-white' id='entregar'>
        <div class='d-flex flex-row justify-content-between my-flex-container'>
        <h6> Total:</h6>
        <h6>
        R$: " . number_format(floatval($total + $taxa), 2, ',', ' ') . "</h6>
        </div>
        </div>
        </div> ";
        $_SESSION['taxa-entrega'] = $taxa;
        $_SESSION['valor-liquido'] = $total;
        mysqli_close($conn);
    }
}
}
function verPedidos($cliente_id)
{
        $cliente = new Cliente();
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        $prepare = "SELECT * FROM cad_pedido WHERE cliente_id = '$cliente_id' AND NOT status_id = '4' ORDER BY pedido_dtinicio DESC";
        $execute = mysqli_query($conn, $prepare);
                while ($pedidos = mysqli_fetch_assoc($execute)) {
                    $pedido_dtinicio = $pedidos['pedido_dtinicio'];
                    $pedido_dtconfirmado = $pedidos['pedido_dtconfirmado'];
                    $descricao = json_decode($pedidos['pedido_descricao']);
                    $valorbruto = $pedidos['pedido_valorbruto'];
                    $taxa_entrega = $pedidos['taxa_entrega'];
                    $status = $pedidos['status_id'];
                    $pgto_id = $pedidos['pgto_id'];
                    $trocopara = $pedidos['pedido_trocopara'];
                    $obs = $pedidos['pedido_obs'];
                    $formaPag = $pedidos['pgto_id'];
                    $statusPedidoCliente = $pedidos['status_id'];
                    $statusPedido2 = '';
                    switch ($statusPedidoCliente) {
                        case 0:
                            $statusPedido2  = '<h5><span class="badge badge-pill badge-secondary">Aguardando Confirmação</span></h5>';
                            break;
                        case 1:
                            $statusPedido2  = '<h5><span class="badge badge-pill badge-primary">Pedido Recebido</span></h5>';
                            break;
                        case 2:
                            $statusPedido2  = '<h5><span class="badge badge-pill badge-warning"> Preparando Pedido</span></h5>';
                            break;
                        case 3:
                            $statusPedido2  = '<h5><span class="badge badge-pill badge-info">Saiu para entrega</span></h5>';
                            break;
                        case 5:
                            $statusPedido2  = '<h5><span class="badge badge-pill badge-danger">Cancelado</span></h5>';
                            break;
                        default:

                            break;
                    }
                    ?>
    <div class='d-flex justify-content-end'>
        <h4><?php echo $statusPedido2; ?></h4>
    </div>
    <?php
                    foreach ($descricao as $key => $value1) {
                        $numeroPedido = intval($key) + 1;

                        ?>
    <div class="card-body">
        <h6>Pedido <?php echo  $numeroPedido ?></h6>
        <?php
                            foreach ($value1 as $keyItem => $itemValue) {
                                if (is_array($itemValue)) {
                                    $count = count(array_filter($itemValue));
                                    echo "<span class='font-bold'>" . $keyItem . ':</span>';
                                    foreach ($itemValue as $key => $value2) {
                                        // echo ' ' .$itemValue[$key].',';
                                    }

                                    foreach ($itemValue as $key2 => $value2) {
                                        $this->listarItens($value2);
                                        // $somar = $this->somarValores($value2);
                                        // $total += $somar;

                                    }
                                } else {
                                    $count = 0;
                                }
                            }

                            echo "
                </div>
                ";

                            if (strlen($obs) > 0) {
                                echo "Obs: <h4 class='local-pedido'>$obs</h4>";
                            }
                        }

                        $valorPedido = $valorbruto - $taxa_entrega;

                        ?>
        <div class="card-body">
            <div class='d-flex flex-row justify-content-between my-flex-container'>
                <h6>Subtotal:</h6>
                <h6> R$ <?php echo number_format($valorPedido, 2, ',', ' ') ?></h6>
            </div>
            <div class='d-flex flex-row justify-content-between my-flex-container'>
                <h6>Taxa de entrega:</h6>
                <h6>R$ <?php echo number_format($taxa_entrega, 2, ',', ' ') ?></h6>
            </div>
            <div class='d-flex flex-row justify-content-between my-flex-container'>
                <h6>Total:</h6>
                <h6>R$ <?php echo number_format($valorbruto, 2, ',', ' ') ?></h6>
            </div>
            <?php
                            foreach (json_decode($pgto_id) as $key => $value) {
                                foreach ($value as $key2 => $value2) {
                                    switch ($value2) {
                                        case 1:
                                            echo "
                                <h6>Forma de pagamento</h6>
                                <h6>
                                Pagamento em dinheiro";
                                            if ($trocopara > 0) {
                                                echo ", troco para: R$:" . number_format($valorbruto, 2, ',', ' ') . "</h4>";
                                            }
                                            break;
                                        case 2:
                                            echo "<h4>Pagamento com cartão.</h4>";
                                            break;
                                        default:
                                            echo "Inválido";
                                            break;
                                    }
                                }
                            }

                            echo "
                <hr>
                <h6>Endereço de entrega</h6>
                <h6>";
                            $cliente->enderecoPadrao($pedidos['cliente_id']);
                            "</h6>";
                            echo "<hr>
                </div>";
                        }
        mysqli_close($conn);
    }
    function verPedidosResumo($cliente_id)
    {
    $cliente = new Cliente();
    $conexao = new Conexao();
    $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
    $prepare = "SELECT * FROM cad_pedido WHERE cliente_id = '$cliente_id' AND NOT status_id = '4' ORDER BY pedido_dtinicio DESC";
    $execute = mysqli_query($conn, $prepare);
    while ($pedidos = mysqli_fetch_assoc($execute)) {
        $pedido_id = $pedidos['pedido_id'];
        $pedido_dtinicio = $pedidos['pedido_dtinicio'];
        $pedido_dtconfirmado = $pedidos['pedido_dtconfirmado'];
        $descricao = json_decode($pedidos['pedido_descricao']);
        $valorbruto = $pedidos['pedido_valorbruto'];
        $taxa_entrega = $pedidos['taxa_entrega'];
        $status = $pedidos['status_id'];
        $pgto_id = $pedidos['pgto_id'];
        $trocopara = $pedidos['pedido_trocopara'];
        $obs = $pedidos['pedido_obs'];
        $formaPag = $pedidos['pgto_id'];
        $statusPedidoCliente = $pedidos['status_id'];
        $espera = $pedidos['pedido_espera'];

        $statusPedido2 = '';
        switch ($statusPedidoCliente) {
            case 0:
                $statusPedido2 = '<h5><span class="badge  badge-pill badge-secondary">Aguardando</span></h5>';
                break;
            case 1:
                $statusPedido2 = '<h5><span class="badge badge-pill badge-primary">Recebido</span></h5>';
                break;
            case 2:
                $statusPedido2 = '<h5><span class="badge badge-pill badge-warning">Preparando</span></h5>';
                break;
            case 3:
                $statusPedido2 = '<h5><span class="badge badge-pill badge-info">Saiu para entrega</span></h5>';
                break;
            case 4:
                $statusPedido2 = '<h5><span class="badge badge-pill badge-success">Pedido Entregue</span></h5>';
                break;
            case 5:
                $statusPedido2 = '<h5><span class="badge badge-pill badge-danger">Pedido Cancelado</span></h5>';
                break;
            default:
                echo "Inválido";
                break;
        }
        ?>
            <a href='' data-toggle='modal' data-target='#pedido-<?php echo $pedido_id ?>'>
                <div class='card shadow border mt-4 '>
                    <div class='d-flex flex-row'>
                        <div class='card-header'>
                            <h2 class='text-center'>
                                <b>
                                    <?php setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
                        date_default_timezone_set('America/Sao_Paulo');
                        echo strftime('%d', strtotime(date($pedido_dtinicio)));
                        ?>
                                </b>
                            </h2>
                            <div class='text-center'>
                                <h6><?php setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
                        date_default_timezone_set('America/Sao_Paulo');
                        echo strftime(' de %B', strtotime(date($pedido_dtinicio)));
                        ?></h6>
                            </div>
                        </div>
                        <div class='card-body'>
                            <span class="text-danger">Ver detalhes</span>
                            <h6 class='' role='alert'> <?= $espera ?></h6>
                            <h6 class=''>Valor total: <?php echo number_format($valorbruto, 2, ',', ' ') ?></h6>
                            <div class="d-flex justify-content-between align-items-center ">
                                <h6><?php echo $statusPedido2 ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <div class="modal fade" id="pedido-<?php echo $pedido_id ?>" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><?php echo $statusPedido2 ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php
                foreach ($descricao as $key => $value1) {
                    $numeroPedido = intval($key) + 1;
                    ?>
                            <div class="card-body">
                                <h6>Pedido <?php echo  $numeroPedido ?></h6>
                                <?php
                        foreach ($value1 as $keyItem => $itemValue) {
                            if (is_array($itemValue)) {
                                $count = count(array_filter($itemValue));
                                echo "<span class='font-bold'>" . $keyItem . ':</span>';
                                foreach ($itemValue as $key => $value2) {
                                    // echo ' ' .$itemValue[$key].',';
                                }
                                foreach ($itemValue as $key2 => $value2) {
                                    $this->listarItens($value2);
                                    // $somar = $this->somarValores($value2);
                                    // $total += $somar;
                                }
                            } else {
                                $count = 0;
                            }
                        }
                        if (strlen($obs) > 0) {
                            echo "Obs: <h6 class='local-pedido'>$obs</h6>";

                        }
                    }
                    $valorPedido = $valorbruto - $taxa_entrega;

                    ?>
                                <div class='d-flex flex-row justify-content-between my-flex-container'>
                                    <h6>Subtotal:</h6>
                                    <h6> R$ <?php echo number_format($valorPedido, 2, ',', ' ') ?></h6>
                                </div>
                                <div class='d-flex flex-row justify-content-between my-flex-container'>
                                    <h6>Taxa de entrega:</h6>
                                    <h6>R$ <?php echo number_format($taxa_entrega, 2, ',', ' ') ?></h6>
                                </div>
                                <div class='d-flex flex-row justify-content-between my-flex-container'>
                                    <h6>Total:</h6>
                                    <h6>R$ <?php echo number_format($valorbruto, 2, ',', ' ') ?></h6>
                                </div>
                                <?php
                    foreach (json_decode($pgto_id) as $key => $value) {
                        foreach ($value as $key2 => $value2) {
                            switch ($value2) {
                                case 1:
                                    echo "
                                    <h6>Forma de pagamento</h6>
                                    <h6>
                                    Pagamento em dinheiro";
                                    if ($trocopara > 0) {
                                        echo ", troco para: R$:" . number_format($valorbruto, 2, ',', ' ') . "</h4>";
                                    }
                                    break;
                                case 2:
                                    echo "<h6>Pagamento com cartão.</h6>";
                                    break;
                                default:
                                    echo "Inválido";
                                    break;
                            }
                        }
                    }
                    echo "<hr> <h6>Endereço de entrega</h6><h6>";
                    $cliente->enderecoPadrao($pedidos['cliente_id']);
                    "</h6>";
                    echo "<hr> <div class='alert alert-success p-3' role='alert'> $espera </div>";
                    ?>
                            </div>
                            <div class="modal-footer">
                                <button type="buton" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                                <div class="btn-group dropup">
                                    <button type="button" class="btn btn-danger " data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        Nos Avalie
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                        <div class="dropdown-divider"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
}
mysqli_close($conn);
}
    function verPedidosId($pedido_id)
    {
        $cliente = new Cliente();
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        $prepare = "SELECT * FROM cad_pedido WHERE pedido_id = '$pedido_id'";
        $execute = mysqli_query($conn, $prepare);
        while ($pedidos = mysqli_fetch_assoc($execute)) {
            $pedido_dtinicio = $pedidos['pedido_dtinicio'];
            $pedido_dtconfirmado = $pedidos['pedido_dtconfirmado'];
            $descricao = $pedidos['pedido_descricao'];
            $valorbruto = $pedidos['pedido_valorbruto'];
            $taxa_entrega = $pedidos['taxa_entrega'];
            $status = $pedidos['status_id'];
            $pgto_id = $pedidos['pgto_id'];
            $trocopara = $pedidos['pedido_trocopara'];
            $obs = $pedidos['pedido_obs'];
            $formaPag = $pedidos['pgto_id'];
            $produto_id = json_decode($descricao);
            $statusPedido = $pedidos['status_id'];
            $statusPedido2 = '';
            switch ($statusPedido) {
                case 0:
                    $statusPedido2  = 'Aguardando Confirmação';
                    break;
                case 1:
                    $statusPedido2  = 'Pedido Recebido';
                    break;
                case 2:
                    $statusPedido2  = ' Preparando Pedido';
                    break;
                case 3:
                    $statusPedido2  = 'Saiu para entrega';
                    break;
                case 4:
                    $statusPedido2  = 'Pedido Entregue';
                    break;
                case 5:
                    $statusPedido2  = 'Pedido Cancelado';
                    break;
                default:
                    echo "Inválido";
                    break;
            }
            ?>
            <h4><?php echo $statusPedido2; ?></h4>
            <div class='d-flex flex-row justify-content-between my-flex-container'>
                <h4>Cliente:</h4>
                <h4>
                    <?php echo $cliente->pesquisarNomeClienteId($pedidos['cliente_id']); ?>
                </h4>
            </div>
            <div class='d-flex flex-row justify-content-between my-flex-container'>
                <h4>Telefone:</h4>
                <h4><?php echo $cliente->pesquisarClienteTelefone($pedidos['cliente_id']); ?> </h4>
            </div>
            <hr>
            <?php
            foreach ($produto_id as $key => $value) {
                ?>
            <h4>Pedido <?php echo $key + 1 ?></h4>
            <h4 class='local-pedido' style="font-size:25px;">
                <?php
                    foreach ($value as $key2 => $value2) {
                        $this->listarItens($value2);
                    }
                    echo "<hr><hr>";
                }
                echo "</h4>";
                if (strlen($obs) > 0) {
                    echo "Obs: <h4 class='local-pedido'>$obs</h4>";
                }
                $valorPedido = $valorbruto - $taxa_entrega;
                echo "
                <div class='d-flex flex-row justify-content-between my-flex-container'>
                <h4>Subtotal:</h4>
                <h4> R$ $valorPedido</h4>
                </div>
                <div class='d-flex flex-row justify-content-between my-flex-container'>
                <h4>Taxa de entrega:</h4>
                <h4>R$$taxa_entrega</h4>
                </div>
                <div class='d-flex flex-row justify-content-between my-flex-container'>
                <h4>Total:</h4>
                <h4>R$$valorbruto</h4>
                </div>";
                foreach (json_decode($pgto_id) as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                        switch ($value2) {
                            case 1:
                                echo "
                <h4>Forma de pagamento</h4>
                <h4>
                Pagamento em dinheiro";
                                if ($trocopara > 0) {
                                    echo ", troco para: R$: $trocopara.</h4>";
                                }
                                break;
                            case 2:
                                echo "<h4>Pagamento com cartão.</h4>";
                                break;
                            default:
                                echo "Inválido";
                                break;
                        }
                    }
                }
                echo "
<hr>
<h4>Endereço de entrega</h4>
<h4>";
                $cliente->enderecoPadrao($pedidos['cliente_id']);
                "</h4>";
                echo "<hr>";
            }
            mysqli_close($conn);
        }
        function cancelarPedido($pedido_id)
        {
            $conexao = new Conexao();
            $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
            $prepare = "UPDATE cad_pedido SET status_id = 5 WHERE pedido_id = '$pedido_id'";
            $execute = mysqli_query($conn, $prepare);
            mysqli_close($conn);
        }
        function notificarNovoPedido()
        {
            $conexao = new Conexao();
            $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
            $prepare = "INSERT INTO notificacao (status_notificacao) VALUES ('1')";
            $execute = mysqli_query($conn, $prepare);
            mysqli_close($conn);
        }
        function apagarNotificacoes()
        {
            $conexao = new Conexao();
            $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
            $prepare = "DELETE FROM notificacao";
            $execute = mysqli_query($conn, $prepare);
            mysqli_close($conn);
        }
        function verNotificacao()
        {
            $conexao = new Conexao();
            $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
            $prepare = "SELECT * FROM notificacao";
            $execute = mysqli_query($conn, $prepare);
            while ($novoPedido = mysqli_fetch_assoc($execute)) {
                $notificacao = $conn->affected_rows;
                echo "data: {$notificacao}\n\n";
            }
            flush();
            mysqli_close($conn);
        }

        function tempodeEspera()
        {
            $conexao = new Conexao();
            $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
            $conexao = new Conexao();
            $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
            $prepare = "SELECT * FROM cad_pedido where (cad_pedido.pedido_dtinicio>=concat(CURRENT_DATE,' 05:00:00')) and (cad_pedido.pedido_dtinicio<cast(concat(cast(CURRENT_DATE()+1 as date),' 05:00:00') as datetime)) AND status_id != 5 AND status_id != 4 AND status_id != 6";
            $execute = mysqli_query($conn, $prepare);
            $conta_linhas = mysqli_num_rows($execute);
            switch ($conta_linhas) {
                case ($conta_linhas <= 4):
                    echo "Tempo de espera de 30-40 minuto";
                    break;
                case ($conta_linhas >= 5  and $conta_linhas <= 8):
                    echo "Tempo de espera de  40-50 minutos";
                    break;
                case ($conta_linhas >= 9  and $conta_linhas <= 12):
                    echo "Tempo de espera de 50-60 minutos";
                    break;
                case ($conta_linhas >= 13 and $conta_linhas <= 16):
                    echo "Tempo de espera de 60-70 minutos";
                    break;
                case ($conta_linhas >= 17 and $conta_linhas <= 20):
                    echo "Tempo de espera de  70-80 minutos";
                    break;
                case ($conta_linhas >= 21 and $conta_linhas <= 24):
                    echo "Tempo de espera de 90 minutos";
                    break;
                case ($conta_linhas >= 25):
                    echo "Você possui entre 50 e 60 minutos";
                    break;
                default:
                    echo "90 minutos";
                    break;
            }
        }
        function finalizarPedidoLanche()
    {
        if (isset($_SESSION['carrinho'])) 
        {
            $conexao = new Conexao();
            $ingredientes = new Ingrediente();
            $redirecionar = new Rotas();
            $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
            $total = 0;
            $cliente_id = $_SESSION['cliente_id'];
   
            $taxa = $this->meuBairro($cliente_id);
            if ($_SESSION['carrinho'] != null) {
                $obj = new stdClass();
                                if (!empty($_SESSION['carrinho'])) {
                                    ?>
                                    <ul class="list-group">
                                   <?php
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
                                    </ul>
                                   <?php
                                    echo "
                                    <div class='form-group mt-3'>
                                    <div class='d-flex justify-content-end'>
                                    <button id='cancelPedido' type='submit' class='btn btn-secondary' name='cancelar-pedido'>Cancelar Pedido</button>
                                    </div>
                                    <br>
                                    <label>Escreva um comentário</label>
                                    <input type='textarea' class='form-control' name='pedido_obs' aria-describedby='helpId' placeholder='Ex: tirar alho, a parte, etc.'>
                                    </div>";
                                    echo "
                                    <div class='card mt-2 p-3'>
                                    <h6 class='text-muted' id='entregar'>
                                    <div class='d-flex flex-row justify-content-between my-flex-container'>
                                    <h6>Taxa de Entrega:</h6>
                                    <h6>R$" . number_format(floatval($taxa), 2, ',', ' ') . "</h6>
                                    </div>
                                    <div class='d-flex flex-row justify-content-between my-flex-container'>
                                    <h6>Valor do Pedido:</h6>
                                    <h6>R$" . number_format(floatval($total), 2, ',', ' ') . "</h6>
                                    </div>
                                    <h5 class='text-orange' id='entregar'>
                                    <div class='d-flex flex-row justify-content-between my-flex-container'>
                                    <h6> Total:</h6>
                                    <h6>
                                    R$: " . number_format(floatval($total + $taxa), 2, ',', ' ') . "</h6>
                                    </div>
                                    </div>
                                    ";
                                    $_SESSION['taxa-entrega'] = $taxa;
                                    $_SESSION['valor-liquido'] = $total;
                                    mysqli_close($conn);
                                }
                
                }

            }
    }
    }
    // fecha a classe
    $pedido = new Pedido();
    //REMOVENDO O PEDIDO
    if (isset($_POST['remover-pedido'])) {
        if (isset($_POST['numeroPedido'])) {
            $numeroPedido = $_POST['numeroPedido'];
            $pedido->removerPedido($numeroPedido);
            $pagina = $_SERVER['PHP_SELF'];
            $redirecionar = new Rotas();
            $redirecionar->redirecionar($pagina);
        }
    }
    // FINALIZANDO A COMPRA
    if (isset($_POST['finalizar-compra'])) {
        $redirecionar = new Rotas();
        if (isset($_SESSION['cliente_id'])) {
            $bairro = $cliente->enderecoEntrega($_SESSION['cliente_id']);
            $redirecionar->redirecionar($redirecionar->finalizarCompra);
        } else {
            $redirecionar->redirecionar($redirecionar->login);
        }
    }
    if (isset($_POST['continuar-pedido'])) {
        if (isset($_POST['pedido_obs'])) {
            $_SESSION['pedido_obs'] = $_POST['pedido_obs'];
        }
        $redirecionar = new Rotas();
        $redirecionar->redirecionar($redirecionar->pagamento);
        // $this->finalizarCompra($cliente_id, $endereco_id, $pedido_descricao, $pedido_qtde, $pedido_trocopara, $pedido_obs, $pedido_valorbruto);
    }
    if (isset($_POST['confirmar-compra'])) {
        $pedido = new Pedido();
        $redirecionar = new Rotas();
        $cliente = new Cliente();
        if (isset($_SESSION['carrinho'])) {
            if (isset($_POST['pagamento'])) {
                $forma_pag = $_POST['pagamento'];
                if (empty($_SESSION['forma-pagamento'])) {
                    $_SESSION['forma-pagamento'] = [];
                }
                if (empty($pedido->pedido_descricao)) {
                    $pedido->pedido_descricao = [];
                }
                array_push($_SESSION['forma-pagamento'], $forma_pag);
                $produtos = $_SESSION['carrinho'];
                foreach ($produtos as $key => $value) {
                    array_push($pedido->pedido_descricao, $value);
                }
                  $cliente_id = $_SESSION['cliente_id'];
                  $endereco_id = $cliente->enderecoEntrega($cliente_id);
                  $pedido_descricao = json_encode($pedido->pedido_descricao);
                  $pedido_qtde = 1;
                  $pedido_liquido = $_SESSION['valor-liquido'];
                  $taxa_entrega = $_SESSION['taxa-entrega'];
                  $pedido_valor = $pedido_liquido + $taxa_entrega;
                  $desconto = 1;
                  $pedido_valorbruto = $pedido_valor - $desconto;
                  $pgto_id = json_encode($_SESSION['forma-pagamento']);

                  if (empty($_POST['trocopara'])) {
                    $pedido_trocopara = 0;
                  } else {
                    $pedido_trocopara = $_POST['trocopara'];
                  }
                  $tempo_espera = $_POST['tempo-espera'];
                  $pedido_obs = $_SESSION['pedido_obs'];

                if ($pedido->finalizarCompra($cliente_id, $endereco_id, $pedido_descricao, $pedido_qtde, $pedido_valorbruto, $taxa_entrega, $pedido_liquido, $pgto_id, $pedido_trocopara, $pedido_obs, $tempo_espera) >= 1) 
                
                {
                    $pedido->notificarNovoPedido();
                    unset($_SESSION['forma-pagamento']);
                    unset($_SESSION['pedido_obs']);
                    unset($_SESSION['carrrinho']);
                    unset($_SESSION['valor-liquido']);
                    unset($_SESSION['taxa-entrega']);
                    unset($_SESSION['code']);
                    echo '<script>alert("Você realizou seu pedido")</script>';
                    // $somar = 1;
                    // $_SESSION['notificacao'] += $somar;
                    $redirecionar->redirecionar($redirecionar->meusPedidos);
                } else {
                    echo '<script>alert("Algo saiu errado")</script>';
                }
            } else {
                echo '<script>alert("Selecione uma forma de pagamento")</script>';
                $redirecionar->redirecionar($redirecionar->pagamento);
                }
        }
    }
    if (isset($_POST['view'])) {
        if ($pedido->verNotificacao() > 0) {
            echo $pedido->verNotificacao();
        } else {
            echo 0;
        }
    }
    if (isset($_POST['adicionar-hora'])) {
        $abertura = $_POST['abertura'];
        $fechamento = $_POST['fechamento'];
        var_dump($abertura);
        var_dump($fechamento);
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        $prepare = "UPDATE cad_hrfuncionamento SET hr_abertura = '$abertura', hr_fechamento = '$fechamento'  WHERE hr_id = 1";
        $execute = mysqli_query($conn, $prepare);
        mysqli_close($conn);
        $redirecionar = new Rotas();
        $redirecionar->redirecionar($redirecionar->$minhaLoja);
    }

    if (isset($_POST['confirmar-caldo'])) {
        if (isset($_POST['produto-id'])) {
            $redirecionar = new Rotas();
            $pedido->Caldo = $_POST['produto-id'];
            $pedido->SaborCaldo = $_POST['caldo-sabor-id'];
            $pedido->Adicionais = $_POST['adicional-id'];
            $pedido->Bebidas = $_POST['bebida-id'];
            $pedidoJson = json_encode($pedido);
            // echo $pedidoJson;
            $pedido->fazerPedido($pedido);
            $redirecionar->redirecionar($redirecionar->pedidoCaldo);
        } else {
            $redirecionar->redirecionar($redirecionar->pedidoCaldo);
        }
    } else if (isset($_POST['confirmar-macarrao'])) {
        if (isset($_POST['produto-id'])) {
            $redirecionar = new Rotas();
            $pedido->Macarrao = $_POST['produto-id'];
            $pedido->Massas = $_POST['massa-id'];
            $pedido->Temperos = $_POST['tempero-id'];
            $pedido->Molhos = $_POST['molho-id'];
            $pedido->Ingredientes = $_POST['ingrediente-id'];
            // $pedido->Adicionais = $_POST['adicional-id'];
            $pedido->Bebidas = $_POST['bebida-id'];
            $pedidoJson = json_encode($pedido);
            $pedido->fazerPedido($pedido);
            $redirecionar->redirecionar($redirecionar->index);
        } else {
            $redirecionar->redirecionar($redirecionar->index);
        }
    }
    if (isset($_POST['cancelar-pedido'])) {
        $cancelarpedido = $_POST['cancelar-pedido'];
        $pedido->cancelarPedidoCliente($cancelarpedido);
        $redirecionar = new Rotas();
        $redirecionar->redirecionar($redirecionar->index);
    }
if (!empty($_POST['estrela'])) {
   echo $estrela = $_POST['estrela'];


}

if (isset($_POST['finalizar-compra'])) {
    $redirecionar = new Rotas();
    if (isset($_SESSION['cliente_id'])) {
        $bairro = $cliente->enderecoEntrega($_SESSION['cliente_id']);
        $redirecionar->redirecionar($redirecionar->finalizarCompra);
    } else {
        $redirecionar->redirecionar($redirecionar->login);
    }
}

if (isset($_POST['idProdRemove'])) {
    echo "deu certo";
   
}
?>