<?php
    // $ch = curl_init();
    $code = rand(1000, 9999); // random 4 digit code
    $_SESSION['code'] = $code;


    if (isset($_POST['number'])) {
        $number = $_POST['number'];

    // store code for later
    $data = array('key'         => 'SUA_CHAVE_KEY', 
                  'type'        => '9',
                  'number'      => $number,
                  'msg'         => 'Teste de envio.');

    curl_setopt($ch, CURLOPT_URL, 'http://api.smsdev.com.br/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $res    = curl_exec ($ch);
    $err    = curl_errno($ch);
    $errmsg = curl_error($ch);
    $header = curl_getinfo($ch);

    curl_close($ch);

       }  
        print_r($res); 
?>  
