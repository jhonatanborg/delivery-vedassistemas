<?php
  include_once "backend/rotas.class.php";
  $redirecionar = new Rotas();
  if(isset($_SESSION['cliente_id'])) {
    $redirecionar->redirecionar($redirecionar->index);
  }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  
  <title>Login</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
  <link href="assets/css/sb-admin-2.css" rel="stylesheet">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/img//favicon-32x32.png">

</head>

<body class="bg-gradient-danger">
<nav class="navbar navbar-expand-sm bg-danger">
    <a class="navbar-brand" href="<?php echo $redirecionar->index?>"><img whidht='35' height='35'
                    src="assets/img/logo-inicio-vedas.png" alt=""></a>
</nav>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '724535324616424',
      cookie     : true,
      xfbml      : true,
      version    : 'v3.2'
    });
      
    FB.AppEvents.logPageView();   
      
  };
  
  function checkLoginState() {
FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
});
}

function statusChangeCallback(response) {
                console.log(response);
                if (response.status === 'connected') {
                    FB.api(
                      "/me", {fields: 'name, email'},
                      function (response) {
                        console.log(response);
                        let cliente_id = response.id;
                        let nome = response.name;
                        let email = response.email;
                        $.ajax({
                        url: "backend/cliente.class.php",
                        type: "POST",
                        data: {cliente_id, nome, email},
                        dataType: "text"
                        }).done(function(resposta) {
                            console.log(resposta);
                            if (resposta == 1) {
                                window.location.href = "<?php echo $redirecionar->index ?>";
                            } else if (resposta == 2) {
                                window.location.href = "<?php echo $redirecionar->validarNumero ?>";
                                console.log('LOGADO');
                            }
                        }).fail(function(jqXHR, textStatus ) {
                            console.log("Request failed: " + textStatus);
                        }).always(function() {
                            console.log("completou");
                        });
                        //window.location.href = "../../index.php";
                      }
                    ), {scope: 'email'};
                } else {
                    // The person is not logged into your app or we are unable to tell.
                    document.getElementById('status').innerHTML = 'Algum erro ocorreu ' +
                      'into this app.';
                }
            }

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.2&appId=496569017544450&autoLogAppEvents=1"></script>
<div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Faça o login antes</h1>
                  </div>
                  <form class="user" action="<?php echo $redirecionar->processaCliente?>" method="POST">
                    <div class="form-group">
                      <input type="email" name="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="Digite seu email" required>
                    </div>
                    <div class="form-group">
                      <input type="password" name="senha" class="form-control" id="exampleInputPassword" placeholder="Senha" required>
                    </div>
                    
                <?php 
                  if (isset($_SESSION['erro-login'])) {
                ?>
                <div class="alert alert-danger" role="alert">
                  Login ou senha inválidos
                </div>
              <?php 
                unset($_SESSION['erro-login']);
              } 
              ?>
                <div class="form-group">
                  <div class="custom-control custom-checkbox small">
                    <input type="checkbox" class="custom-control-input" id="customCheck">
                    <label class="custom-control-label" for="customCheck">Lembrar - me</label>
                  </div>
                </div>
                <button class="btn btn-primary btn-block" type="submit" name="login">Login</button>
                
                <hr>
                </form>
              
                <div class="fb-login-button" data-size="large" data-button-type="login_with" data-auto-logout-link="false" data-use-continue-as="false"scope="public_profile,email" onlogin="checkLoginState();">Entrar com Facebook</div>
              
                <div id="status"></div>
                <div id="mensagem"></div>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="#">Esqueceu a senha?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="<?php echo $redirecionar->validarNumero ?>">Crie uma conta. É grátis!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
</script>
</html>
