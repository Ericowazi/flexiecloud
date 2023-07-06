<?php
    include('../includes/session.php');
    include('../includes/general.php');

    // USERS ALL PAGE CRUD
    // **
    // **
    // Activate single user on users all page
    if (isset($_POST['useractivate450'])) :

        $id = $_GET['user'];
        
        $user_status = 1;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=:user_status, user_exit=0, user_type=0 WHERE id=:id");
            $stmt->execute(['user_status'=>$user_status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "User activated successfully!";
                header('location: users.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users.php?page=1');
        }

        $pdo->close();
    
    // DeActivate single user all on users all page
    elseif (isset($_POST['userdeactivate450'])) : 

        $id = $_GET['user'];
        
        $user_status = 0;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=:user_status, user_exit=0, user_type=0 WHERE id=:id");
            $stmt->execute(['user_status'=>$user_status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "User deactivated successfully!";
                header('location: users.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users.php?page=1');
        }

        $pdo->close();


    // Single trash user on user-all 
    elseif (isset($_POST['usertrash450'])) : 

        $id = $_GET['user'];
        
        $user_exit = 1;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE users SET user_exit=:user_exit, user_status=2, user_type=2 WHERE id=:id");
            $stmt->execute(['user_exit'=>$user_exit, 'id'=>$id]);
        
            if ($stmt) : 
                $_SESSION['success'] = "User sent to trash successfully";
                header('location: users.php?page=1'); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users.php?page=1');
        }
    
        $pdo->close();


    // Single make user admin on user-all 
    elseif (isset($_POST['useradmin450'])) : 

        $id = $_GET['user'];
        
        $user_level = 3;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE users SET user_level=:user_level WHERE id=:id");
            $stmt->execute(['user_level'=>$user_level, 'id'=>$id]);
        
            if ($stmt) : 
                $_SESSION['success'] = "User promoted to administrator";
                header('location: users.php?page=1'); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users.php?page=1');
        }
    
        $pdo->close();




    // ACTIVE PAGE CRUD
    // **
    // **
    // DeActivate single user all on users all page
    elseif (isset($_POST['userdeactivate451'])) : 

        $id = $_GET['user'];
        
        $user_status = 0;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=:user_status, user_exit=0, user_type=0 WHERE id=:id");
            $stmt->execute(['user_status'=>$user_status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "User deactivated successfully!";
                header('location: users-active.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-active.php?page=1');
        }

        $pdo->close();


    // Single trash user on user-all 
    elseif (isset($_POST['usertrash451'])) : 

        $id = $_GET['user'];
        
        $user_exit = 1;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE users SET user_exit=:user_exit, user_status=2, user_type=2 WHERE id=:id");
            $stmt->execute(['user_exit'=>$user_exit, 'id'=>$id]);
        
            if ($stmt) : 
                $_SESSION['success'] = "User sent to trash successfully";
                header('location: users-active.php?page=1'); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-active.php?page=1');
        }
    
        $pdo->close();


    // Make user administrator on user-all 
    elseif (isset($_POST['useradmin451'])) : 

        $id = $_GET['user'];
        
        $user_level = 3;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE users SET user_level=:user_level WHERE id=:id");
            $stmt->execute(['user_level'=>$user_level, 'id'=>$id]);
        
            if ($stmt) : 
                $_SESSION['success'] = "User promoted to administrator";
                header('location: users-active.php?page=1'); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-active.php?page=1');
        }
    
        $pdo->close();




    // ADMIN PAGE CRUD
    // **
    // **
    // Activate single user on users all page
    elseif (isset($_POST['useractivate453'])) :

        $id = $_GET['user'];
        
        $user_status = 1;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=:user_status, user_exit=0, user_type=0 WHERE id=:id");
            $stmt->execute(['user_status'=>$user_status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Admin activated successfully!";
                header('location: users-admins.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-admins.php?page=1');
        }

        $pdo->close();


    // DeActivate single admin all on admin page
    elseif (isset($_POST['userdeactivate453'])) : 

        $id = $_GET['user'];
        
        $user_status = 0;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=:user_status, user_exit=0, user_type=0 WHERE id=:id");
            $stmt->execute(['user_status'=>$user_status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Admin deactivated successfully!";
                header('location: users-admins.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-admins.php?page=1');
        }

        $pdo->close();


    // Single trash admin on admin 
    elseif (isset($_POST['usertrash453'])) : 

        $id = $_GET['user'];
        
        $user_exit = 1;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE users SET user_exit=:user_exit, user_status=2, user_type=2 WHERE id=:id");
            $stmt->execute(['user_exit'=>$user_exit, 'id'=>$id]);
        
            if ($stmt) : 
                $_SESSION['success'] = "Admin sent to trash successfully";
                header('location: users-admins.php?page=1'); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-admins.php?page=1');
        }
    
        $pdo->close();


    // Demote admin to user  
    elseif (isset($_POST['singleUser'])) : 

        $id = $_GET['user'];
        
        $user_level = 0;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE users SET user_level=:user_level WHERE id=:id");
            $stmt->execute(['user_level'=>$user_level, 'id'=>$id]);
        
            if ($stmt) : 
                $_SESSION['success'] = "Admin demoted to user successfully";
                header('location: users-admins.php?page=1'); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-admins.php?page=1');
        }
    
        $pdo->close();


    // Change admin to manager  
    elseif (isset($_POST['singleManager'])) : 

        $id = $_GET['user'];
        
        $user_level = 2;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE users SET user_level=:user_level WHERE id=:id");
            $stmt->execute(['user_level'=>$user_level, 'id'=>$id]);
        
            if ($stmt) : 
                $_SESSION['success'] = "Admin role changed to manager";
                header('location: users-admins.php?page=1'); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-admins.php?page=1');
        }
    
        $pdo->close();


    // Change admin role administrator 
    elseif (isset($_POST['singleAdministrator'])) : 

        $id = $_GET['user'];
        
        $user_level = 3;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE users SET user_level=:user_level WHERE id=:id");
            $stmt->execute(['user_level'=>$user_level, 'id'=>$id]);
        
            if ($stmt) : 
                $_SESSION['success'] = "Admin role changed to administrator";
                header('location: users-admins.php?page=1'); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-admins.php?page=1');
        }
    
        $pdo->close();


    // Change admin to Editor  
    elseif (isset($_POST['singleEditor'])) : 

        $id = $_GET['user'];
        
        $user_level = 4;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE users SET user_level=:user_level WHERE id=:id");
            $stmt->execute(['user_level'=>$user_level, 'id'=>$id]);
        
            if ($stmt) : 
                $_SESSION['success'] = "Admin role changed to Editor";
                header('location: users-admins.php?page=1'); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-admins.php?page=1');
        }
    
        $pdo->close();


    // Change admin to contributor  
    elseif (isset($_POST['singleContributor'])) : 

        $id = $_GET['user'];
        
        $user_level = 5;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE users SET user_level=:user_level WHERE id=:id");
            $stmt->execute(['user_level'=>$user_level, 'id'=>$id]);
        
            if ($stmt) : 
                $_SESSION['success'] = "Admin role changed to Contributor";
                header('location: users-admins.php?page=1'); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-admins.php?page=1');
        }
    
        $pdo->close();


    // Change admin to Author  
    elseif (isset($_POST['singleAuthor'])) : 

        $id = $_GET['user'];
        
        $user_level = 6;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE users SET user_level=:user_level WHERE id=:id");
            $stmt->execute(['user_level'=>$user_level, 'id'=>$id]);
        
            if ($stmt) : 
                $_SESSION['success'] = "Admin role changed to author";
                header('location: users-admins.php?page=1'); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-admins.php?page=1');
        }
    
        $pdo->close();




    // INACTIVE PAGE CRUD
    // **
    // **
    // Activate single user on inactive page
    elseif (isset($_POST['useractivate452'])) :

        $id = $_GET['user'];
        
        $user_status = 1;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=:user_status, user_exit=0, user_type=0 WHERE id=:id");
            $stmt->execute(['user_status'=>$user_status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "User activated successfully!";
                header('location: users-inactive.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-inactive.php?page=1');
        }

        $pdo->close();


    // Single trash user on user-all 
    elseif (isset($_POST['usertrash452'])) : 

        $id = $_GET['user'];
        
        $user_exit = 1;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE users SET user_exit=:user_exit, user_status=2, user_type=2 WHERE id=:id");
            $stmt->execute(['user_exit'=>$user_exit, 'id'=>$id]);
        
            if ($stmt) : 
                $_SESSION['success'] = "User sent to trash successfully";
                header('location: users-inactive.php?page=1'); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users-inactive.php?page=1');
        }
    
        $pdo->close();

        


    // TRASH PAGE CRUD
    // **
    // **
    // Activate single user on users all page
    elseif (isset($_POST['useractivate454'])) :

        $id = $_GET['user'];
        
        $user_status = 1;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE users SET user_status=:user_status, user_exit=0, user_type=0 WHERE id=:id");
            $stmt->execute(['user_status'=>$user_status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "User activated successfully!";
                header('location: users_trash.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users_trash.php?page=1');
        }

        $pdo->close();

    // Delete single user 
    elseif (isset($_POST['userdelete454'])) :

        $id = $_GET['user'];

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("DELETE FROM users WHERE id=:id");
            $stmt->execute(['id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "User deleted successfully!";
                header('location: users_trash.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: users_trash.php?page=1');
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


