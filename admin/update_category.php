<?php
    include('../includes/session.php');
    include('../auth/validation.php');

    if (isset($_POST['update'])) {

        $id = $_GET['category'];

        $name = checkInput($_POST['name']);
        $description = checkInput($_POST['description']);

        if (strlen($name)>80) { $_SESSION['error'] = "Category name too long! Recommended 60 characters!"; redirect_to('edit-category.php?category=' . urlencode($id)); } 
        elseif (strlen($name)>160) { $_SESSION['error'] = "Category description too long!"; redirect_to('edit-category.php?category=' . urlencode($id)); }
 
        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE nav_items SET name=:name, slug=:slug WHERE id=:id");
            $stmt->execute(['name'=>$name, 'slug'=>$description, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Category added successfully!";
                redirect_to('category.php');
            }
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to('edit-category.php?category=' . urlencode($id));
        }

        $pdo->close();

    }
    else {
        $_SESSION['error'] = "Set add category form first!";
        redirect_to('edit-category.php?category=' . urlencode($id));
    }

?>