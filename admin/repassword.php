<?php 
    include('../includes/session.php');

    if (isset($_POST['password'])) {
        
        $id = $_SESSION['admin'];

        $password = $_POST['oldPassword'];
        $newpassword = $_POST['newPassword'];
        $repassword = $_POST['rePassword'];

        if ($newpassword != $repassword) {
            $_SESSION['error'] = "New password does not match!!";
            header('location: profile.php?profile=' . urlencode($id));
            exit;
        } 
        elseif (strlen($newpassword) < 7) {
            $_SESSION['error'] = "New password must have a minimum of 7 characters!!";
            header('location: profile.php?profile=' . urlencode($id));
            exit;
        }

        $stmt = $conn->prepare("SELECT password FROM users WHERE id=:id");
        $stmt->execute(['id'=>$id]);
        $row = $stmt->fetch();
        if (password_verify($password, $row['password'])) {
            $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);

            try {
                $stmt = $conn->prepare("UPDATE users SET password=:password WHERE id=:id");
                $stmt->execute(['password'=>$newpassword, 'id'=>$id]);

                if ($stmt) {
                    $_SESSION['success'] = "Password updated successfully!!";
                    header('location: profile.php?profile=' . urlencode($id));
                }
            } 
            catch (PDOException $e) {
                $_SESSION['error'] = $e->getMessage();
                header('location: profile.php?profile=' . urlencode($id));
            }
        }
        else {
            $_SESSION['error'] = "Incorrect old password!!";
            header('location: profile.php?profile=' . urlencode($id));
        }

    }
    else {
        $_SESSION['error'] = "Fill password inputs!!";
        header('location: profile.php?profile=' . urlencode($id));
    }