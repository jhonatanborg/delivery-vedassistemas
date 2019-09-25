<?php
include_once "backend/produto.class.php";
include_once "backend/cliente.class.php";
include_once "backend/rotas.class.php";
include_once "backend/pedido.class.php";
$pedido = new Pedido();
$redirecionar = new Rotas();
$produtos = new Produto();
$cliente = new Cliente();
?>
<!doctype html>
<html lang="pt-br">

<head>
  <title>Title</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link type="text/css" href="css/argon.css?v=1.0.1" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body class="bg-danger">
  <div class="container ">
    <div class="row justify-content-center">
      <div class="col-lg-4">
        <div class="card bg-secondary shadow  border-0 mt-4">
          <div class="card-header bg-white pb-2">
            <div class=" text-center mb-2">
              <img src="assets/img/brand/logo-massa.png" alt="" width="50%">
            </div>
            <h6 class="mt-4">Escolha quantos ingredientes você quiser, faça combinações incriveis.</h6>
          </div>
          <div class="card-body bg-white py-lg-5 pt-5">
            <label for="">Enviamos um código de verificação para o seguinte número <b><?php echo ($_SESSION['tel-user'])?></b></label>
            <form action="<?php echo $redirecionar->processaCliente ?>" method="POST" id='insert-form'>
              <input type="text" id="code" class="form-control form-control-lg mt-3" placeholder="Insira o código" 
              name="code-confirm"   onKeyPress="if(this.value.length==4) return false;" min="0" value="">
              <small>O código possui 4 digitos</small>
              <small id='erro-code' class="form-text text-danger"></small>

              <div class="d-flex justify-content-between mt-3">
                <a href="<?php echo $redirecionar->validarNumero ?>" class="btn btn-secondary mt-3">Editar número</a>
                <button type="submit" name='send-code' class="btn btn-danger mt-3">Próximo</button>
            </form>
          </div>
        </div>
      </div>
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="validar-campos.js"></script>

  <script>
    // function valida(){
    //   campo = $("#code");
    //   if(campo.val().match(/^(<?php echo $_SESSION['code'] ?>)$/))
    //   {

    //   } else {
    //     event.preventDefault()
    //     let mensagem = document.getElementById("erro-code")
    //     mensagem.innerHTML = 'Código inválido'
    //     campo.addClass('is-invalid');  


    //   }
    // }

    function validar() {
      document.getElementById('insert-form').addEventListener("click", function(event) {
        event.preventDefault()
        let codigo = $('#code').val()
        if (codigo == "<?php echo $_SESSION['code'] ?>") {
          event.currentTarget.submit()
        } else {
          $('#code').addClass('is-invalid')
        }
      })

    }
  </script>

</body>

</html>