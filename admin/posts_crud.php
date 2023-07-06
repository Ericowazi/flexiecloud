<?php
    include('../includes/session.php');
    include('../auth/validation.php');
    include('../includes/general.php');

    // ** PUBLISHED PAGE BULK ACTIONS
    // **
    // Draft button on published pages
    if (isset($_POST['pmultidraft'])) {

        if (isset($_POST['checkbox'])) : 
            $selected_ids = $_POST['checkbox'];
            foreach ($selected_ids as $select_id){
                $id = $select_id;
            }
        else :
                $_SESSION['error'] = "Select posts before moving to draft! TBH!!";
                redirect_to('posts-published.php?page=1');
        endif;
        
        // if (empty($_POST['checkbox'])) :
        //     $_SESSION['error'] = "Select posts before moving to draft! TBH!!";
        //     redirect_to('posts-published.php?page=1');
        // else : $id = implode("','", $_POST['checkbox']); endif; 
        
        $status = 1;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE posts SET post_status=:post_status WHERE id in ('$id')");
            $stmt->execute(['post_status'=>$status]);

            if ($stmt) {
                $_SESSION['success'] = "Posts moved to draft!";
                header('location: posts-published.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-published.php?page=1');
        }

        $pdo->close();

    }

    // Trash button on published pages
    elseif (isset($_POST['pmultitrash'])) {
        
        if (empty($_POST['checkbox'])) :
            $_SESSION['error'] = "Select posts before moving to trash! TBH!!";
            redirect_to('posts-published.php?page=1');
        else : $id = implode("','", $_POST['checkbox']); endif; 
        
        $status = 2;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE posts SET post_status=:post_status WHERE id in ('$id')");
            $stmt->execute(['post_status'=>$status]);

            if ($stmt) {
                $_SESSION['success'] = "Post moved to trash!";
                header('location: posts-published.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-published.php?page=1');
        }

        $pdo->close();

    }
    
    // ** DRAFT PAGE BULK ACTIONS
    // **
    // Publish button on draft pages
    if (isset($_POST['dmultipublish'])) {
        
        if (empty($_POST['checkbox'])) :
            $_SESSION['error'] = "Select posts before publishing! TBH!!";
            redirect_to('posts-draft.php?page=1');
        else : $id = implode("','", $_POST['checkbox']); endif; 
        
        $status = 0;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE posts SET post_status=:post_status WHERE id in ('$id')");
            $stmt->execute(['post_status'=>$status]);

            if ($stmt) {
                $_SESSION['success'] = "Posts published successfully!";
                header('location: posts-draft.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-draft.php?page=1');
        }

        $pdo->close();

    }

    // Trash button on draft pages
    elseif (isset($_POST['dmultitrash'])) {
        
        if (empty($_POST['checkbox'])) :
            $_SESSION['error'] = "Select posts before moving to trash! TBH!!";
            redirect_to('posts-draft.php?page=1');
        else : $id = implode("','", $_POST['checkbox']); endif; 
        
        $status = 2;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE posts SET post_status=:post_status WHERE id in ('$id')");
            $stmt->execute(['post_status'=>$status]);

            if ($stmt) {
                $_SESSION['success'] = "Post moved to trash!";
                header('location: posts-draft.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-published.php?page=1');
        }

        $pdo->close();

    }
    
    // ** TRASH PAGES BULK ACTIONS
    // **
    // Publish button on trash pages
    if (isset($_POST['tmultipublish'])) {
        
        if (empty($_POST['checkbox'])) :
            $_SESSION['error'] = "Select posts before publishing! TBH!!";
            redirect_to('posts-trash.php?page=1');
        else : $id = implode("','", $_POST['checkbox']); endif; 
        
        $status = 0;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE posts SET post_status=:post_status WHERE id in ('$id')");
            $stmt->execute(['post_status'=>$status]);

            if ($stmt) {
                $_SESSION['success'] = "Posts published successfully!";
                header('location: posts-trash.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-trash.php?page=1');
        }

        $pdo->close();

    }
    
    // Draft button on trash pages
    if (isset($_POST['tmultidraft'])) {
        
        if (empty($_POST['checkbox'])) :
            $_SESSION['error'] = "Select posts before moving to draft!";
            redirect_to('posts-trash.php?page=1');
        else : $id = implode("','", $_POST['checkbox']); endif; 
        
        $status = 1;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE posts SET post_status=:post_status WHERE id in ('$id')");
            $stmt->execute(['post_status'=>$status]);

            if ($stmt) {
                $_SESSION['success'] = "Posts moved to draft!";
                header('location: posts-trash.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-trash.php?page=1');
        }

        $pdo->close();

    }

    // Delete button on trash pages
    elseif (isset($_REQUEST['tmultidelete'])) { 
        
        if (empty($_POST['checkbox'])) :
            $_SESSION['error'] = "Select posts before deleting! TBH!!";
            redirect_to('posts-trash.php?page=1');
        else : $id = implode("','", $_POST['checkbox']); endif; 

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("DELETE FROM posts WHERE id in ('$id')");
            $stmt->execute();

            if ($stmt) {
                $_SESSION['success'] = "Posts deleted successfully!";
                header('location: posts-trash.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-trash.php?page=1');
        }

        $pdo->close();

    }