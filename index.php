<?php
    if (isset($_GET['url'])) {
        $url = $_GET['url'];
    } else {
        $url = 'home';
    }
    if ($url == 'index') {
        $url = 'home';
    }
    
    $url = array_filter(explode("/", $url));

    $file = $url[0].".php";

    if (is_file($file)) {
        // echo "<script>window.location.replace('$file')</script>;";
        include_once $file;
    } else {
        echo "Página não encontrada";
    }
?>