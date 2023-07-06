<?php
    include('../includes/session.php');
    include('../includes/general.php');


    // USER ALL PAGE CRUD
    // **
    // **
    // Bulk activate on user-all 
    if (isset($_POST['usersactivate450'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select users before activating!";
            redirect_to('users.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=1, user_exit=0, user_type=0 WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Users activated successfully"; 
                redirect_to("users.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("users.php?page=1");
        }
    
        $pdo->close();

    // Bulk deactivate on user-all 
    elseif (isset($_POST['usersdeactivate450'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select users before deactivating!";
            redirect_to('users.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=0, user_exit=0, user_type=0 WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Users deactivated successfully"; 
                redirect_to("users.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("users.php?page=1");
        }
    
        $pdo->close(); 

    // Bulk trash - multiple users on user-all 
    elseif (isset($_POST['userstrash450'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select users before sending to trash!";
            redirect_to('users.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE users SET user_exit=1, user_status=2, user_type=2 WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Users sent to trash successfully"; 
                redirect_to("users.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("users.php?page=1");
        }
    
        $pdo->close();


    // ACTIVE PAGE CRUD
    // **
    // **
    // Bulk deactivate on user-all 
    elseif (isset($_POST['usersdeactivate451'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select users before deactivating!";
            redirect_to('users-active.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=0, user_exit=0, user_type=0 WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Users deactivated successfully"; 
                redirect_to("users-active.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("users-active.php?page=1");
        }
    
        $pdo->close(); 

    // Bulk trash - multiple users on user-all 
    elseif (isset($_POST['userstrash451'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select users before sending to trash!";
            redirect_to('users-active.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE users SET user_exit=1, user_status=2, user_type=2 WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Users sent to trash successfully"; 
                redirect_to("users-active.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("users-active.php?page=1");
        }
    
        $pdo->close();


    // INACTIVE PAGE CRUD
    // **
    // **
    // Bulk activate on user-all 
    elseif (isset($_POST['usersactivate452'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select users before activating!";
            redirect_to('users-inactive.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=1, user_exit=0, user_type=0 WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Users activated successfully"; 
                redirect_to("users-inactive.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("users-inactive.php?page=1");
        }
    
        $pdo->close();

    // Bulk trash - multiple users on user-all 
    elseif (isset($_POST['userstrash452'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select users before sending to trash!";
            redirect_to('users-inactive.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE users SET user_exit=1, user_status=2, user_type=2 WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Users sent to trash successfully"; 
                redirect_to("users-inactive.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("users-inactive.php?page=1");
        }
    
        $pdo->close();


    // ADMIN PAGE CRUD
    // **
    // **
    // Bulk activate on user-all 
    elseif (isset($_POST['usersactivate453'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select users before activating!";
            redirect_to('users-admins.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=1, user_exit=0, user_type=0 WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Admins activated successfully"; 
                redirect_to("users-admins.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("users-admins.php?page=1");
        }
    
        $pdo->close();

    // Bulk deactivate on user-all 
    elseif (isset($_POST['usersdeactivate453'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select users before deactivating!";
            redirect_to('users-admins.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=0, user_exit=0, user_type=0 WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Admins deactivated successfully"; 
                redirect_to("users-admins.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("users-admins.php?page=1");
        }
    
        $pdo->close(); 

    // Bulk trash - multiple users on user-all 
    elseif (isset($_POST['userstrash453'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select users before sending to trash!";
            redirect_to('users-admins.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE users SET user_exit=1, user_status=2, user_type=2 WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Admins sent to trash successfully"; 
                redirect_to("users-admins.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("users-admins.php?page=1");
        }
    
        $pdo->close();


    // TRASH PAGE CRUD
    // **
    // **
    // Bulk activate on user-all 
    elseif (isset($_POST['usersactivate454'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select users before activating!";
            redirect_to('users_trash.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=1, user_exit=0, user_type=0 WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Users activated successfully"; 
                redirect_to("users_trash.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("users_trash.php?page=1");
        }
    
        $pdo->close();

    // Bulk delete on trash page
    elseif (isset($_POST['usersdelete454'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select users before deleting!";
            redirect_to('users_trash.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("DELETE FROM users WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Users deleted successfully"; 
                redirect_to("users_trash.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("users_trash.php?page=1");
        }
    
        $pdo->close();
    
    else :
        $_SESSION['error'] = "Form must be set!"; 
        redirect_to("users.php?page=1");
    endif;

    // or
    // Default page for errors
    // else :  include('includes/navbar.php'); 
    //         on_page_errors('Something went wrong!', 'users', 'Return to users'); endif;