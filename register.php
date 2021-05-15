<?php

    include("app/_config.php");
    include('userClass.php');

    $user = new userClass();

    $errorMsgReg='';

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
    function decryptCookie( $ciphertext ) {
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
    /* Signup Form */
    if (!empty($_POST['signupSubmit'])) {
        $username=$_POST['usernameReg'];
        $password=$_POST['passwordReg'];
        /* Regular expression check */
        $username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
        $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);

        if($username_check && $password_check>0) {
            $id=$user->userRegistration($username,$password);
            if($id) {
                if( isset($_POST['rememberme']) ){
                    // Set cookie variables
                    $value = encryptCookie($usernameReg, $passwordReg);
    
                    setcookie ("rememberme",$value,time()+ (3600)); 
                }
                $url=BASE_URL.'dashboard.php';
                header("Location: $url"); // Page redirecting to dashboard.php 
            } else {
                $errorMsgReg="Username atau password sudah ada";
            }
        }  else {
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
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        body {
            background-image: url("coding.png");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: scroll;
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
                    <a class="navbar-brand" href="http://localhost/websiteB/dataLogin/Quiz2_PWEB-B/">LOGIN</a>
                </div>
            </div>
        </nav>
    </div>
    <div class="container mb-4">
        <div class="container py-5">
            <div class="card shadow mb-4 mt-4">
                <div class="card-header py-3">
                    <h2 class="text-dark">Registrasi</h2>
                    <form action="" method="POST" class="mb-5" name="signup">
                        <input type="text" class="form-control mb-1" name="usernameReg" placeholder="Username">
                        <br>
                        <input type="password" class="form-control mb-1" name="passwordReg" placeholder="Password">
                        <div class="errorMsg"><?php echo $errorMsgReg; ?></div>
                        <div>
                            <input type="checkbox" name="rememberme" value="1" />&nbsp;Remember Me
                        </div>
                        <input type="submit" class="btn btn-primary mt-3" name="signupSubmit" value="Sign Up">
                    </form>			
                </div>
            </div>
        </div>
    </div>
</body>
</html>