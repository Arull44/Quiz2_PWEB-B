<?php

    include("app/_config.php");
    include('userClass.php');

    $user = new userClass();

    $errorMsgReg='';
    $errorMsgLogin='';

    // Encrypt cookie
    function encryptCookie($value) {

        $key = hex2bin(openssl_random_pseudo_bytes(4));

        $cipher = "aes-256-cbc";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
    
        $ciphertext = openssl_encrypt($value, $cipher, $key, 0, $iv);

        return( base64_encode($ciphertext . '::' . $iv. '::' .$key) );
    }

    // Decrypt cookie
    function decryptCookie($ciphertext) {
        $cipher = "aes-256-cbc";

        list($encrypted_data, $iv,$key) = explode('::', base64_decode($ciphertext));
        return openssl_decrypt($encrypted_data, $cipher, $key, 0, $iv);

    }

    // Check if $_SESSION or $_COOKIE already set
    if( isset($_SESSION['id']) ){
        $url=BASE_URL."dashboard.php";
        header("Location: $url");
        exit;
    } else if( isset($_COOKIE['rememberme'] )){
        // Decrypt cookie variable value
        $userid = decryptCookie($_COOKIE['rememberme']);

        // Fetch records
        $db = getDB();
        $stmt = $db->prepare("SELECT count(*) as cntUser FROM datalogin WHERE id=:id");
        $stmt->bindValue(':id', (int)$userid, PDO::PARAM_INT);
        $stmt->execute(); 
        $count = $stmt->fetchColumn();

        if( $count > 0 ){
            $_SESSION['id'] = $userid; 
            $url=BASE_URL."dashboard.php";
            header("Location: $url");
            exit;
        }
    }

     /* Login Form */
     if (!empty($_POST['loginSubmit'])) {
        $usernameLog=$_POST['usernameLog'];
        $password=$_POST['password'];
        if(strlen(trim($usernameLog))>1 && strlen(trim($password))>1 ) {

            if( isset($_POST['rememberme']) ){
                // Set cookie variables
                $value = encryptCookie($usernameLog, $password);

                setcookie ("rememberme",$value,time()+ (3600)); 
            }
            $id=$user->userLogin($usernameLog,$password);
            if($id) {
                $url=BASE_URL.'dashboard.php';
                header("Location: $url"); // Page redirecting to dashboard.php    
            } else {
                $errorMsgLogin="Username atau password salah";
            }
        } else {
            $errorMsgLogin="Data harus terisi semua";
        }
    } 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        body {
            background-color:grey;
        }

        .errorMsg{
            color: #cc0000;
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="register.php">REGISTER</a>
                    <a class="navbar-brand" href="http://localhost/websiteB/dataLogin/">LOGIN</a>
                </div>
            </div>
        </nav>
    </div>

    <div class="container mb-4">
        <div class="container py-5">
            <div class="card shadow mb-4 mt-4">
                <div class="card-header py-3">
                    <h2 class="text-dark">Login</h2>
                    <form action="" method="POST" class="mb-5" name="login">
                        <input type="text" class="form-control mb-1"  name="usernameLog" placeholder="Username">
                        <br>
                        <input type="password" class="form-control mb-1" name="password" placeholder="Password">
                        <div class="errorMsg"><?php echo $errorMsgLogin; ?></div>
                        <div>
                            <input type="checkbox" name="rememberme" value="1" />&nbsp;Remember Me
                        </div>
                        <input type="submit" class="btn btn-primary mt-3" name="loginSubmit" value="Login">
                    </form>			
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>