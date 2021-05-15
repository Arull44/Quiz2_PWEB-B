<?php
    if(!empty($_SESSION['id'])) {
        $session_id=$_SESSION['id'];
        include('userClass.php');
        $userClass = new userClass();
    } if(empty($session_id)) {
        $url=BASE_URL;
        header("Location: $url");
    }
?>
