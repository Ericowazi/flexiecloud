<?php
    include('../includes/session.php');
    include('../includes/general.php');

    if (isset($_POST['navigation'])) {
        
        $id = $_GET['navigation'];
        $nav = 0;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE nav_items SET nav_group=:nav_group WHERE id=:id");
            $stmt->execute(['nav_group'=>$nav, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Category removed from Navigation Bar Successfully";
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
        $_SESSION['error'] = "Something went wrong! TBH";
            redirect_to('category.php');
    }