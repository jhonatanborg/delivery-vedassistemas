<?php
include_once "rotas.class.php";
include_once "conexao.php";
class Tipo {
    public $tipo_id;
    public $tipo_descricao;

    public function cadastrarTipo($tipo_descricao) {
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        mysqli_query($conn, "set names 'utf8'");
        $prepare = "INSERT INTO cad_tipo (tipo_descricao) VALUES ('$tipo_descricao')";
        $execute = mysqli_query($conn, $prepare);
            if ($conn->affected_rows > 0) {
                return 1;
            } else {
                return 0;
            }
        mysqli_close($conn);
    }

    public function listarTipos() {
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        $prepare  = "SELECT * FROM cad_tipo";
        $execute = mysqli_query($conn, $prepare);
        while ($tipos = mysqli_fetch_assoc($execute)) {
        echo '<option value='.$tipos['tipo_id'].'>' . utf8_encode($tipos['tipo_descricao']) . '</option>';
        }
        mysqli_close($conn);
    }

    function tipoNome($tipo_id) {
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        $prepare  = "SELECT * FROM cad_tipo WHERE tipo_id = '$tipo_id'";
        $execute = mysqli_query($conn, $prepare);
        while ($tipos = mysqli_fetch_assoc($execute)) {
        echo utf8_encode($tipos['tipo_descricao']);
        }
        mysqli_close($conn);
    }

    function listarTiposTabela() {
        $conexao = new Conexao();
        $conn = new mysqli($conexao->host, $conexao->usuario, $conexao->senha, $conexao->bd);
        $prepare  = "SELECT * FROM cad_tipo";
        $execute = mysqli_query($conn, $prepare);
        while ($tipos = mysqli_fetch_assoc($execute)) {
        $id = $tipos['tipo_id'];
        $descricao = $tipos['tipo_descricao'];
        ?>
        <tr>
        <td><?php echo $id ?></td>
        <td><?php echo utf8_encode($descricao) ?>
        </td>
        </tr>
        <?php
        }
        // echo $_SERVER["REQUEST_URI"]; 
        mysqli_close($conn);
    }
}

$tipo = new Tipo();

if (isset($_POST['cad-tipo'])) {
    $tipo_descricao = $_POST['tipo-descricao'];
    $validar = $tipo->cadastrarTipo($tipo_descricao);
    if ($validar > 0) {
        $redirecionar = new Rotas();
        $redirecionar->redirecionar($redirecionar->cadastrarTipo);
    } else {
        echo "DEU ERRO";
    }
}

?>