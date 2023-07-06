<?php
    include('../includes/session.php');
    include('../auth/validation.php');

    if (isset($_POST['category'])) {

        $name = checkInput($_POST['name']);
        $description = checkInput($_POST['description']);
        
        $set = 'abcdefghijklmnopqrstuvwxyz';
        $code = substr(str_shuffle($set), 0, 12);
        $key = $code;

        checkCategory($name, $description);
        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("INSERT INTO nav_items(name,slug,post_key) VALUES(:name,:slug,:post_key)");
            $stmt->execute(['name'=>$name, 'slug'=>$description, 'post_key'=>$key]);

            if ($stmt) {
                $_SESSION['success'] = "Category added successfully!";
                redirect_to('add-category.php');
            }
        } 
        catch (PDOException $e) { 
            $_SESSION['error'] = $e->getMessage();
            redirect_to('add-category.php');
        }

        $pdo->close();

    }
    elseif (isset($_POST['update'])) {

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
    elseif (isset($_POST['delete'])) { 
        
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
    elseif (isset($_POST['navigation'])) {
        
        $id = $_GET['navigation'];
        $nav = 1;
        
        $stmt = $conn->prepare("SELECT * FROM nav_items WHERE id=:id");
        $stmt->execute(['id'=>$id]);
        $row = $stmt->fetch();
        if ($row['nav_group']==$nav) {
            $_SESSION['error'] = "Category already added to navigation bar! TBH";
            redirect_to('category.php');
        }
        else {

            $conn = $pdo->open();

            try {
                $stmt = $conn->prepare("UPDATE nav_items SET nav_group=:nav_group WHERE id=:id");
                $stmt->execute(['nav_group'=>$nav, 'id'=>$id]);

                if ($stmt) {
                    $_SESSION['success'] = "Category added to Navigation Bar Successfully";
                    redirect_to('category.php');
                }
            } 
            catch (PDOException $e) {
                $_SESSION['error'] = $e->getMessage();
                redirect_to('category.php');
            }

            $pdo->close();
        }
    }
    elseif (isset($_POST['removenav'])) {
        
        $id = $_GET['category'];
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
        $_SESSION['error'] = "Something went wrong! Try again!";
        redirect_to('add-category.php');
    }

?>