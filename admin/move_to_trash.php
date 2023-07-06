<?php 
    include('../includes/session.php');
    include('../auth/validation.php');

    if (isset($_POST['movetotrash'])) {
        
        $id = implode("','", $_POST['checkbox']);
        if (empty($id)) {
            $_SESSION['error'] = "Select post/s before moving to trash! Tbh!!";
            redirect_to('all-posts.php?page=1');
        }
        $status = 1;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE posts SET post_status=:post_status WHERE id=:id");
            $stmt->execute(['post_status'=>$status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Post moved to trash! TBH!!";
                header('location: all-posts.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: all-posts.php?page=1');
        }

        $pdo->close();

    }
    else {
        $_SESSION['error'] = "Form is not set! Tbh!!";
        redirect_to('all-posts.php?page=1');
    }