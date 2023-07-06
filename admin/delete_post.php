<?php
    include('../includes/session.php');
    include('../auth/validation.php');

    if (isset($_POST['delete'])) {
        
        if (empty($_POST['checkbox'])) {
            $_SESSION['error'] = "Select post/s before deleting! Tbh!!";
            redirect_to('trash.php?page=1');
        } else{
            $postID = implode("','", $_POST['checkbox']);
        } 

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("DELETE FROM posts WHERE id in ('$postID')");
            $stmt->execute();
    
            if ($stmt) {
                $_SESSION['success'] = "Post/s deleted successfully!";
                redirect_to('all-posts.php?page=1');
            }
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to('all-posts.php?page=1');
        }

        $pdo->close();

    }
    else {
        $_SESSION['error'] = "Form is not set! Tbh!!";
        redirect_to('all-posts.php?page=1');
    }