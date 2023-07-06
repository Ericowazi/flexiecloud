<?php 
    include('includes/session.php');
    include('auth/validation.php');

    if (isset($_POST['login'])) {

        $conn = $pdo->open();

        $username = $_POST['Username'];
        $password = $_POST['Password'];

        $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE username=:username");
        $stmt->execute(['username'=>$username]);
        $row = $stmt->fetch();

        if ($row['numrows'] > 0) {
            if (password_verify($password, $row['password'])) {  
                if ($row['status']) {
                    $_SESSION['admin'] = $row['id'];
                }
                else {
                    $_SESSION['admin'] = $row['id'];
                }

            }
            else {
                $_SESSION['error'] = "Incorrect username / password! Try Again!";
                redirect_to('login.php');
            }

        }
        else {
            $_SESSION['error'] = "Incorrect username / password! Try Again!";
            redirect_to('login.php');
        }

        
        $pdo->close();
        redirect_to('login.php');

    }
    else {
        $_SESSION['error'] = "Something went wrong! Try Again!";
        redirect_to('login.php');
    }
