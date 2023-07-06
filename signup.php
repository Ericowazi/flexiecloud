<?php
    include('includes/session.php');
    include('auth/validation.php');  
    include('includes/general.php');

    if (isset($_POST['signup'])) {

        $username =  checkInput($_POST['Username']);
        $password =  checkInput($_POST['Password']);
        $repassword =  checkInput($_POST['rePassword']);
        $email = $_POST['Email'];

        // Check input 
        checkErrors($username, $email, $password, $repassword);

        date_default_timezone_set("Africa/Nairobi");
        $current_time = time();
        $now = date("Y-m-d H:i:s",$current_time);

        // Get code
        $code = generate_code();

        // Default admin status
        $status = 0;
        
        // Encrypt password
        $password = password_hash($password, PASSWORD_DEFAULT);

        $conn = $pdo->open();

        try {

            $stmt = $conn->prepare("INSERT INTO users(username,password,email,user_registered,activation_key,user_status) VALUES(:username, :password, :email, :now, :code, :status)");
            $stmt->execute(['username'=>$username, 'password'=>$password, 'email'=>$email, 'now'=>$now, 'code'=>$code, 'status'=>$status,]);
            if ($stmt) {
                $_SESSION['success'] = "Account created successfuly!" . "<br>" . "Login to proceed!";
                redirect_to("login.php");
            }
            else {
                $_SESSION['error'] = "Something went wrong! Try Again!";
                redirect_to("register.php");
            }
        } catch (PDOException $e) {
            echo "There is some problem in connection! " . $e->getMessage();
        }
        
        $pdo->close();
    }
    else {
        $_SESSION['error'] = "Fill up signup form first!";
        redirect_to("register.php");
    }

