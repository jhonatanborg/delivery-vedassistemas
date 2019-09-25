<?php 
include_once "conexao.php";
include_once "tipo.class.php";
include_once "rotas.class.php";
class Produto {
    public $produto_id;
    public $produto_descricao;
    public $tipo_id;
    // public $produto_idsistema;
    public $produto_disponivel;
    public $produto_valor;

    function listarProdutosProntos($tipo_produto) {
        $redirecionar = new Rotas();
        $tipos = new Tipo();
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        switch ($tipo_produto) {
            case 'Lanches':
            $prepare  = "SELECT produto_id, produto_titulo, tipo_id, produto_descricao, produto_disponivel, produto_valor,
            CASE produto_disponivel 
            WHEN 0 THEN 'Disponivel'
            WHEN 1 THEN 'Indisponível'
            END AS disponibilidade
            FROM cad_produto WHERE tipo_id = '1'";
            $execute = mysqli_query($conn, $prepare);
            while ($produtos = mysqli_fetch_assoc($execute)) {
                $id = $produtos['produto_id'];
                $titulo = $produtos['produto_titulo'];
                $descricao = $produtos['produto_descricao'];
                $preco = $produtos['produto_valor'];
                $tipo_id = $produtos['tipo_id'];
                $disponivel = $produtos['produto_disponivel'];
                $disponibilidade = $produtos['disponibilidade'];
                $valor_formato = number_format($preco, 2, ',', ' ');
                ?>
                <li class='list-group-item'>
                <div class='d-flex flex-row'>
                    <div class='w-80'>
                        <img src='assets/img/example.png' alt=''>
                    </div>
                    <div class='d-flex flex-column'>
                        <div class='d-flex justify-content-between'>
                            <p class='ml-3'><b> <?=$titulo ?></b></p>
                            <p class='text-orange'><b>R$ <?=$valor_formato?></b></p>
                        </div>
                        <h6 class='ml-3 text-left'> <?=$descricao?></h6>
                    </div>
                </div>
                <div class='d-flex justify-content-end'>
                <div class='quantidade'>
                <input type='hidden' name='add-cart'>
                <input type='hidden' name='produto-id' value='<?=$id?>'>
                </div>
                    <button onclick="addForm('<?=$id?>', 1)" type='submit' class='btn btn-sm btn-orange align-text-bottom'>ADICIONAR</button>
                </div>
            </li>
            <?php
            }                  
                break;
            case 'Combos':
            $prepare  = "SELECT produto_id, produto_titulo, tipo_id, produto_descricao, produto_disponivel, produto_valor,
            CASE produto_disponivel 
            WHEN 0 THEN 'Disponivel'
            WHEN 1 THEN 'Indisponível'
            END AS disponibilidade
            FROM cad_produto WHERE tipo_id ='2'";
            $execute = mysqli_query($conn, $prepare);
            while ($produtos = mysqli_fetch_assoc($execute)) {
                $id = $produtos['produto_id'];
                $titulo = $produtos['produto_titulo'];
                $descricao = $produtos['produto_descricao'];
                $preco = $produtos['produto_valor'];
                $tipo_id = $produtos['tipo_id'];
                $disponivel = $produtos['produto_disponivel'];
                $disponibilidade = $produtos['disponibilidade'];
                $valor_formato = number_format($preco, 2, ',', ' ');
?>
                 <li class='list-group-item'>
                <div class='d-flex flex-row'>
                    <div class='w-80'>
                        <img src='assets/img/example.png' alt=''>
                    </div>
                    <div class='d-flex flex-column'>
                        <div class='d-flex justify-content-between'>
                            <p class='ml-3'><b> <?=$titulo ?></b></p>
                            <p class='text-orange'><b>R$ <?=$valor_formato?></b></p>
                        </div>
                        <h6 class='ml-3 text-left'> <?=$descricao?></h6>
                    </div>
                </div>
                <div class='d-flex justify-content-end'>
                <div class='quantidade'>
                <input type='hidden' name='add-cart'>
                <input type='hidden' name='produto-id' value='<?=$id?>'>
                </div>
                    <button onclick="addForm('<?=$id?>', 1)" type='submit' class='btn btn-sm btn-orange align-text-bottom'>ADICIONAR</button>
                </div>
            </li>
            <?php
            }
            break;
            case 'Bebidas':
            $prepare  = "SELECT produto_id, produto_titulo, tipo_id, produto_descricao, produto_disponivel, produto_valor,
            CASE produto_disponivel 
            WHEN 0 THEN 'Disponivel'
            WHEN 1 THEN 'Indisponível'
            END AS disponibilidade
            FROM cad_produto WHERE tipo_id ='3'";
            $execute = mysqli_query($conn, $prepare);
            while ($produtos = mysqli_fetch_assoc($execute)) {
                $id = $produtos['produto_id'];
                $titulo = $produtos['produto_titulo'];
                $descricao = $produtos['produto_descricao'];
                $preco = $produtos['produto_valor'];
                $tipo_id = $produtos['tipo_id'];
                $disponivel = $produtos['produto_disponivel'];
                $disponibilidade = $produtos['disponibilidade'];
                $valor_formato = number_format($preco, 2, ',', ' ');
?>
                 <li class='list-group-item'>
                <div class='d-flex flex-row'>
                    <div class='w-80'>
                        <img src='assets/img/example.png' alt=''>
                    </div>
                    <div class='d-flex flex-column'>
                        <div class='d-flex justify-content-between'>
                            <p class='ml-3'><b> <?=$titulo ?></b></p>
                            <p class='text-orange'><b>R$ <?=$valor_formato?></b></p>
                        </div>
                        <h6 class='ml-3 text-left'> <?=$descricao?></h6>
                    </div>
                </div>
                <div class='d-flex justify-content-end'>
                <div class='quantidade'>
                <input type='hidden' name='add-cart'>
                <input type='hidden' name='produto-id' value='<?=$id?>'>
                </div>
                    <button onclick="addForm('<?=$id?>', 1)" type='submit' class='btn btn-sm btn-orange align-text-bottom'>ADICIONAR</button>
                </div>
            </li>
            <?php
            }
            break;        
        }
        mysqli_close($conn);


    }

    
    
    function listarProdutosId($produto_id) {
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        $tipos = new Tipo();
        $prepare  = "SELECT * FROM cad_produto WHERE produto_id = '$produto_id'";
        $execute = mysqli_query($conn, $prepare);
        while ($produtos = mysqli_fetch_assoc($execute)) {
            $descricao = $produtos['produto_descricao'];
            $valor = $produtos['produto_valor'];
                echo $descricao.", ";
            }
            mysqli_close($conn);
    }

    function listarProdutosPedido($tabela, $tipo_id) {
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        if($tabela == 'cad_produto') {
            $prepare  = "SELECT * FROM cad_produto WHERE tipo_id = '$tipo_id' AND  produto_disponivel = 0 ";
        } else if ($tabela =='cad_ingrediente') {
            $prepare  = "SELECT * FROM cad_ingrediente WHERE tipo_id = '$tipo_id' AND  ingrediente_disponivel = 0 ";
        }
        $execute = mysqli_query($conn, $prepare);
        while ($produtos = mysqli_fetch_assoc($execute)) {
            if($tabela == 'cad_produto') {
                $id = $produtos['produto_id'];
                $descricao = $produtos['produto_descricao'];
                $preco = $produtos['produto_valor'];
                $tipo_id = $produtos['tipo_id'];
                $disponivel = $produtos['produto_disponivel'];
                ?>
                <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
                <li class="list-group-item list-group-item-action">
                <?php echo utf8_encode ($descricao);
                if ($preco > 0 ) {
                    echo ": R$".number_format($preco, 2, ',', ' ');
                }
                ?>
                <label class="checkbox">
                <input class="pobrigatorio" type="radio" required id="produto_id" name="produto-id[]" value="<?php echo $id ?>">
                <span class="danger"></span>
                </li>
                <?php
            } else if ($tabela == 'cad_ingrediente') {
                $id = $produtos['ingrediente_id'];
                $descricao = $produtos['ingrediente_descricao'];
                $preco = $produtos['ingrediente_valor'];
                $tipo_id = $produtos['tipo_id'];
                $disponivel = $produtos['ingrediente_disponivel'];
                ?>
                <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
                <li class="list-group-item list-group-item-action">
                <?php echo utf8_encode ($descricao);
                if ($preco > 0 ) {
                    echo ": R$".number_format($preco, 2, ',', ' ');
                }
                if ($tipo_id == '5') {
                ?>
                <label class="checkbox">
                <input required type="checkbox" id="macarrao" name="macarrao-id[]" value="<?php echo $id ?>">
                <span class="danger"></span>
                </li>
                <?php
                } else if ($tipo_id == '2') {
                ?>
                <label class="checkbox">
                <input class="molho" type="checkbox" id="molho" name="molho-id[]" value= "<?php echo $id ?>">
                <span class="danger"></span>
                </li>
                <?php
                } else if ($tipo_id == '1') {
                ?>
                <label class="checkbox">
                <input class="massa" type="checkbox" id="massa" name="massa-id[]" value="<?php echo $id ?>">
                <span class="danger"></span>
                </li>
                <?php
                } else if ($tipo_id == '6') {
                ?>
                <label class="checkbox">
                <input class="ingrediente" type="checkbox" id="ingrediente" name="ingrediente-id[]" value="<?php echo $id ?>">
                <span class="danger"></span>
                </li>
                <?php
                } else if ($tipo_id == '8') {
                ?>
                <label class="checkbox">
                <input class="caldoSabor" type="checkbox" id="caldoSabor" name="caldo-sabor-id[]" value="<?php echo $id ?>">
                <span class="danger"></span>
                </li>
                <?php
                } else if ($tipo_id == '9') {
                ?>
                <label class="checkbox">
                <input class="tempero" type="checkbox" id="tempero" name="tempero-id[]" value="<?php echo $id ?>">
                <span class="danger"></span>
                </li>
 
                <?php
                } else if ($tipo_id == '7') {
                ?>
                <label class="checkbox">
                <input class="ingrediente" type="checkbox" id="adicional" name="adicional-id[]" value="<?php echo $id ?>">
                <span class="danger"></span>
                </li>
                <?php
                } else if ($tipo_id == '13') {
                ?>
                <label class="checkbox">
                <input class="ingrediente" type="checkbox" id="bebidas" name="produtoid[]" value="<?php echo $id ?>">
                <span class="danger"></span>
                </li>
                    <?php 
                }
                else{
                ?>
                <label class="checkbox">
                <input type="checkbox" id="bebidas" name="bebida-id[]"value="<?php echo $id ?>">
                <span class="danger"></span>
                </li>
                <?php 
                }
            }
        }
        mysqli_close($conn);
    }
    function listarProdutosCart($produto_id, $quantidade) {
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        $tipos = new Tipo();
        $prepare  = "SELECT * FROM cad_produto WHERE produto_id = '$produto_id'";
        $execute = mysqli_query($conn, $prepare);
        $multidimensionalArray = [];
        //$produto_id = [];
        while ($produtos = mysqli_fetch_assoc($execute)) {
            $produto_id = $produtos['produto_id'];
            $produto_titulo = $produtos['produto_titulo'];
            $produto_descricao= $produtos['produto_descricao'];
            $produto_valor = $produtos['produto_valor'];

            $multidimensionalArray = array(
                
                0  => array(
                    'id' => $produto_id,
                    'titulo' => $produto_titulo,
                    'descricao' => $produto_descricao,
                    'valor' => $produto_valor,
                    'quantidade' => $quantidade

                )
            
            );
           
        return ($multidimensionalArray);
            }
            mysqli_close($conn);
    }
} 
$produto = new Produto();
if (isset($_POST['cad-prod'])) {
    $descricao = $_POST['prod-descricao'];
    $tipo = $_POST['prod-tipo'];
    $preco = $_POST['prod-preco'];
    $validar = $produto->cadastrarProduto($descricao, $tipo, $preco);
    if ($validar != 0) {
        $redirecionar = new Rotas();
        $redirecionar->redirecionar($redirecionar->cadastrarProdutos);
    } else {
        echo "Deu Errado";
    }
}
if (isset($_POST['disponivelProduto'])) {
    $produto_id = $_POST['produto'];
    $produto->alterarDisponibilidade($produto_id, 'cad_produto');
    $redirecionar = new Rotas();
    $redirecionar->redirecionar($redirecionar->cadastrarProdutos);
}
if(isset($_POST['idProduto'])){
     $produto_id = $_POST['idProduto'];
     $quantidade = $_POST['qtdProduto'];
     $validar = $produto->listarProdutosCart($produto_id, $quantidade);
     $qtd = 0;
     if(!empty($_SESSION["carrinho"])) {
       $result=  array_push($_SESSION["carrinho"],$validar[0]);
        foreach ($_SESSION["carrinho"] as $key => $value) {
            $qtd+= 1;
        }
        echo json_encode($_SESSION["carrinho"]);
    }
    else {
        $_SESSION["carrinho"] = $validar;
        $qtd += 1;
        echo json_encode($_SESSION["carrinho"]);
        $jsonQtd = array("Quantidade" => $qtd);  
    }
}
?> 