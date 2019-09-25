<?php 
include_once "conexao.php";
include_once "rotas.class.php";
include_once "tipo.class.php";
include_once "produto.class.php";
class Ingrediente {
    public $ingrediente_id;
    public $tipo_id;
    public $ingrediente_descricao;
    // public $ingrediente_idsistema;
    public $ingrediente_disponivel;
    public $ingrediente_valor;

    function cadastraringrediente($ingrediente_descricao, $tipo_id, $ingrediente_valor) {
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        mysqli_query($conn, "set names 'utf8'");
        if ($ingrediente_valor <= 0 && $ingrediente_valor == '') {
            $ingrediente_valor = 0;
        }
        $prepare = "INSERT INTO cad_ingrediente (ingrediente_descricao, tipo_id, ingrediente_disponivel, ingrediente_valor) VALUES ('$ingrediente_descricao', '$tipo_id', '0', '$ingrediente_valor')";
        $execute = mysqli_query($conn, $prepare);
        // print_r($conn->affected_rows);
        if ($conn->affected_rows > 0) {
            return 1;
        } else {
            return 0;
        }
        mysqli_close($conn);
    }

    function listarIngredientesId($ingrediente_id) {
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        $tipos = new Tipo();
        $prepare  = "SELECT * FROM cad_ingrediente WHERE ingrediente_id = '$ingrediente_id'";
        $execute = mysqli_query($conn, $prepare);
        while ($ingredientes = mysqli_fetch_assoc($execute)) {
            $descricao = $ingredientes['ingrediente_descricao'];
            $valor = $ingredientes['ingrediente_valor'];
                echo $descricao.", ";
            }
            mysqli_close($conn);
    }

    function listarIngredientes() {
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        $tipos = new Tipo();
        $redirecionar = new Rotas();
        $prepare  = "SELECT ingrediente_id, tipo_id, ingrediente_descricao, ingrediente_disponivel, ingrediente_valor,
        CASE ingrediente_disponivel 
        WHEN 0 THEN 'Disponivel'
        WHEN 1 THEN 'Indisponível'
        END AS disponibilidade
        FROM cad_ingrediente";
        $execute = mysqli_query($conn, $prepare);
        while ($ingredientes = mysqli_fetch_assoc($execute)) {
            $id = $ingredientes['ingrediente_id'];
            $tipo_id = $ingredientes['tipo_id'];
            $descricao = $ingredientes['ingrediente_descricao'];
            $disponivel = $ingredientes['ingrediente_disponivel'];
            $disponibilidade = $ingredientes['disponibilidade'];
            $valor = $ingredientes['ingrediente_valor'];
            
            ?>
            <tr>
                <td><?php echo $id ?></td>
                <td><?php echo utf8_encode($descricao) ?></td>
                <td>R$<?php echo $valor ?></td>
                <td><?php $tipos->tipoNome($tipo_id) ?></td>
                <?php
                switch ($disponibilidade) {
                    case 'Disponivel':
                        ?>
                        <td><span class='badge badge-pill badge-success'><?php echo $disponibilidade ?><span></td>
                        <?php
                        break;
                    case 'Indisponível':
                        ?>
                        <td><span class='badge badge-pill badge-danger'><?php echo $disponibilidade ?><span></td>
                        <?php
                        break;
                    default:
                        # code...
                        break;
                }
                ?>
                 <td>
                <!-- ALTERAR DISPONIBILIDADE -->
                <form action="<?php echo $redirecionar->cadastrarIngrediente ?>" method="post">
                <input type="hidden" name="ingrediente" value="<?= $id ?>">
                <button type="submit" name="disponivelIngrediente" class="fas fa-sync-alt mr-3"></button>   
                </form>
               
            </td>
                
            </tr>
            <?php 
            }
            mysqli_close($conn);
            }
} // fecha a classe

$ingrediente = new Ingrediente();
$produtos = new Produto();
if (isset($_POST['cad-ingrediente'])) {
    $descricao = $_POST['ingr-descricao'];
    $preco = $_POST['ingr-preco'];
    $tipo = $_POST['ingr-tipo'];
    $validar = $ingrediente->cadastraringrediente($descricao, $tipo, $preco);
    if ($validar > 0) {
        $redirecionar = new Rotas();
        $redirecionar->redirecionar($redirecionar->cadastrarIngrediente);
    } else {
        echo "Deu Errado";
    }
}

if (isset($_POST['disponivelIngrediente'])) {
    $produto_id = $_POST['ingrediente'];
    $produtos->alterarDisponibilidade($produto_id, 'cad_ingrediente');
    $redirecionar = new Rotas();
    $redirecionar->redirecionar($redirecionar->cadastrarIngrediente);
}

?> 