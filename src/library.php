<?php

session_start();

/*Please be aware that some variables are just for the test. You need to change them according 
to your records, tables and som on. Even the mail link has to be inserted by yourself.
*/
/*
By hounaar
https://github.com/hounaar/
*/

function signup($name,$id,$email,$password,$repeat_password,$tablename){
        include_once "connection.php";
        $name = mysqli_real_escape_string($connection,$_POST['name']);
        $id = mysqli_real_escape_string($connection,$_POST['id']);
        $email = mysqli_real_escape_string($connection,$_POST['email']);
        $password = mysqli_real_escape_string($connection,$_POST['password']);
        $repeat_password = mysqli_real_escape_string($connection,$_POST['repeat_password']);
        $date = date('Y-m-d H:i:s');

        if(!empty($id) || !empty($email) || !empty($password) || !empty($repeat_password)){
            if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                if($password === $repeat_password){
                    $id_checker = $connection->query("SELECT id FROM $tablename WHERE id = '{$id}'");
                    if($id_checker->num_rows>0){
                        echo "Username already exists";
                    }
                    else {
                        $newpass = md5($password);
                        $query = $connection->query("INSERT INTO $tablename VALUES ('{$name}','{$id}',
                        '{$email}','{$newpass}',{'$date'}");
                        if($query){
                            $selector = $connection->query(
                                "SELECT * FROM $tablename WHERE id = '{$id}'"
                            );
                            if($selector->num_rows>0){
                                while($row = $selector->fetch_assoc()) {
                                    $_SESSION['id'] = $row['id'];
                                    echo "success";
                            }
                        } else {
                            echo "Something went wrong. Try again later";
                        }
                    }  
                }
                } else {
                    echo "Passwords do not match";
                }
            } else {
                echo "Youe email is not valid";
            }
        } else {
            echo "ALl fields are required";
        }
    }

function selector($id,$password,$tablename){
    include_once "connection.php";
    $id = mysqli_real_escape_string($connection,$_POST['id']);
    $password = mysqli_real_escape_string($connection,$_POST['password']);
    if(!empty($id) || !empty($password)){
        $id_checker = $connection->query("SELECT id FROM $tablename WHERE id = '{$id}'");
        if($id_checker->num_rows>0){
            echo "Username already exists";
        } else {
            $newpass = md5($password);
            $selector = $connection->query("SELECT * FROM $tablename WHERE 
            id = '{$id}' AND password = '{$newpass}'
            ");
            if($selector->num_rows>0){
                while($row = $selector->fetch_assoc()){
                    $_SESSION['id'] = $row['id'];
                    echo "success";
                }
            }else {
                echo "The username not found. You need to register with this username";
            }

        }
    } else {
        echo "You need to enter your info first";
    }

}

function update($name,$id,$email,$tablename){
    if(!isset($_SESSION['id'])){
        header(""); /* header to the main location*/
    } else {
        include_once "connection.php";
        $name = mysqli_real_escape_string($connection,$_POST['name']);
        $id = mysqli_real_escape_string($connection,$_POST['id']);
        $email = mysqli_real_escape_string($connection,$_POST['email']);

        if(!empty($name) || !empty($_SESSION['id']) || !empty($email)){
            if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                $update_name_email = $connection->query(
                    "UPDATE $tablename SET name = '$name'
                    AND email = '$email' WHERE id = '{$_SESSION['id']}'
                    ");
                if($update_name_email){
                    echo "All records updated";
                } else {
                    echo "Something went wrong";
                }
                $update_id = $connection->query(
                    "UPDATE $tablename SET id = '{$id}'
                    WHERE id = '{$_SESSION['id']}'
                    "
                );
                if($update_id){
                    $_SESSION['id'] = $id;
                    echo "Username updated";
                } else {
                    echo "Something went wrong";
                }


            } else {
                echo "Your email is not valid";
            }
        } else {
            echo "You need to enter all the required information";
        }
    }
}

function mail_for_change_password($user_email){
    include_once "connection.php";
    $user_email = mysqli_real_escape_string($connection,$_POST['$user_email']);
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


    $message1 = '<html>
    <body style="direction:ltr;">
    <div class="container" style="color:black !important;">
    <p style="font-size:40px;">Dear User/p><br/>
    <p style="font-size:25px;">Click on the link below to change your password.</p>
    <a href="">Confirm</a> 
    </div>
    </body>
    </html>';
    /* You need to set the current link yourself*/

    mail($user_email,"Change Password",$message1,$headers);


}

function change_password($new_pass,$repeat_new_pass,$tablename){
    include_once "connection.php";
    if(!isset($_SESSION['id'])){
    } else {
        $new_pass = mysqli_real_escape_string($connection,$_POST['password']);
        $repeat_new_pass = mysqli_real_escape_string($connection,$_POST['repeat_new_pass']);
    
        if(!empty($id) || $empty($new_pass) || empty($repeat_new_pass)){
          if($new_pass == $repeat_new_pass){
            $enc_pass = md5($new_pass);
            $id = $_SESSION['id'];
            $updator = $connection->query(
                "UPDATE $tablename SET pass = '{$enc_pass}' WHERE id = '{$id}'"
            );
            if($updator){
                echo "Password updated";
            } else {
                echo "Something went wrong, Password not updated";
            }
          } else {
            echo "Passwords are not matched";
          }
        } else {
            echo "You need to enter all information first";
        }
    }
    
   

}

function logout(){
    if(isset($_SESSION['id'])){
        include_once "connection.php";
        $logout = mysqli_real_escape_string($connection,$_GET['logout']);
        if(isset($logout)){
            session_unset();
            session_destroy();
            header("");
        } else {
            header("");
        }
    } else {
        header("");    
    }
}

function delete_account($tablename){
    if(!isset($_SESSION['id'])){
        header("");
    } else {
        include_once "connection.php";
        $id = $_SESSION['id'];
        $query = $connection->query(
            "DELETE FROM $tablename WHERE id = '{$id}'"
        );
        if($query){
            echo "The account has been deleted";
            session_unset();
            session_destroy();
            header("");        
        } else {
            echo "Something went wrong";
        }
    }
}
    


?>