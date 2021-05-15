<?php
    
    class userClass {
        /* User Login */
        public function userLogin($usernameLog, $password) {
            try{
                $db = getDB();
                $stmt = $db->prepare("SELECT id FROM datalogin WHERE username=:username AND password=:password"); 
                $stmt->bindParam("username", $usernameLog,PDO::PARAM_STR) ;
                $stmt->bindParam("password", $password,PDO::PARAM_STR) ;
                $stmt->execute();
                $count=$stmt->rowCount();
                $data=$stmt->fetch(PDO::FETCH_OBJ);
                $db = null;
                if($count) {
                    $_SESSION['id']=$data->id; // Storing user session value
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
            }
        }

        /* User Registration */
        public function userRegistration($username, $password) {
            try{
                $db = getDB();
                $st = $db->prepare("SELECT id FROM datalogin WHERE username=:username");
                $st->bindParam("username", $username,PDO::PARAM_STR);
                $st->execute();
                $count=$st->rowCount();
                if($count<1) {
                    $stmt = $db->prepare("INSERT INTO datalogin(username,password) VALUES (:username,:password)");
                    $stmt->bindParam("username", $username,PDO::PARAM_STR) ;
                    $stmt->bindParam("password", $password,PDO::PARAM_STR) ;
                    $stmt->execute();
                    $id=$db->lastInsertId(); // Last inserted row id
                    $data=$stmt->fetch(PDO::FETCH_OBJ);
                    $db = null;
                    $_SESSION['id']=$id;
                    return true;
                } else {
                    $db = null;
                    return false;
                }
            } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
            }
        }

        /* User Details */
        public function userDetails($id) {
            try{
                $db = getDB();
                $stmt = $db->prepare("SELECT username FROM datalogin WHERE id=:id"); 
                $stmt->bindParam("id", $id,PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_OBJ); //User data
                return $data;
            } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
            }
        }
    }
?>