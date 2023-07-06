<?php 
    include('../includes/session.php');
    include('../includes/general.php');

    if (isset($_POST['delete'])) { 
        
        $id = $_GET['delete'];

        $conn = $pdo->open();
        try {
            $stmt = $conn->prepare("DELETE FROM nav_items WHERE id=:id");
            $stmt->execute(['id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Category deleted successfully";
                redirect_to('category.php');
            }
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to('category.php');
        }

        $pdo->close(); 
    }
    else {
        $_SESSION['error'] = "Something went wrong!! TBH!!";
        redirect_to('category.php');
    }