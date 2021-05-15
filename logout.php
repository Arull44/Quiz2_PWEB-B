<?php
    include('app/_config.php');
    unset($_SESSION['id']);
    $session_id='';
    session_destroy(); // destroy session
    
    // Remove cookie variables
    setcookie ("rememberme","", time() - (3600) );

    if(empty($session_id) && empty($_SESSION['id']) ) {
        $url=BASE_URL;
        header("Location: $url");
    }

?>