<?php
    include('../includes/session.php');
    include('../auth/validation.php');

    if (isset($_POST['addcategory451'])) {

        $redirect = 'category-add.php';

        $name = checkInput($_POST['catname']);
        $slug = checkInput($_POST['catslug']);
        $parentcat = checkInput($_POST['parentcat']);
        $description = checkInput($_POST['description']);

        $set = 'abcdefghijklmnopqrstuvwxyz';
        $key = substr(str_shuffle($set), 0, 11);
        

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("INSERT INTO categories(name,slug,description,parent_cat,cat_key) VALUES(:name,:slug,:description,:parent_cat,:cat_key)");
            $stmt->execute(['name'=>$name, 'slug'=>$slug, 'description'=>$description, 'parent_cat'=>$parentcat, 'cat_key'=>$key]);

            if ($stmt) {
                $_SESSION['success'] = "Category added successfully!";
                header('location: category-all.php?page=1');
            }
        } 
        catch (PDOException $e) { 
            $_SESSION['error'] = $e->getMessage();
            header('location: ' . $redirect);
        }

        $pdo->close();

    }
    elseif (isset($_POST['update452'])) {

        $catkey = $_GET['category']; //$catkey = trim($catkey2);

        $name = checkInput($_POST['catname']);
        $slug = checkInput($_POST['catslug']);
        $parentcat = checkInput($_POST['parentcat']);
        $description = checkInput($_POST['description']);
 
        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE categories SET name=:name, slug=:slug, description=:description, parent_cat=:parent_cat WHERE cat_key LIKE '%$catkey%'");
            $stmt->execute(['name'=>$name, 'slug'=>$slug, 'parent_cat'=>$parentcat, 'description'=>$description]);

            if ($stmt) {
                $_SESSION['success'] = "Category updated successfully!";
                header('location: category-all.php?page=1');
            }
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: category-edit.php?category=' . urlencode($catkey));
        }

        $pdo->close();

    }
    elseif (isset($_POST['delete450'])) { 
        
        $id = $_GET['category'];

        $conn = $pdo->open();
        try {
            $stmt = $conn->prepare("DELETE FROM categories WHERE id=:id");
            $stmt->execute(['id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Category deleted successfully";
                header('location: category-all.php?page=1');
            }
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: category-all.php?page=1');
        }

        $pdo->close(); 
    }
    elseif (isset($_POST['multidelete450'])) { 

        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select categories before deleting!";
            header('location: category-all.php?page=1'); exit;
        else : $id = implode("','", $_POST['checkbox']); endif; 

        $conn = $pdo->open();
        try {
            $stmt = $conn->prepare("DELETE FROM categories WHERE id in ('$id')");
            $stmt->execute();

            if ($stmt) {
                $_SESSION['success'] = "Categories deleted successfully";
                header('location: category-all.php?page=1');
            }
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: category-all.php?page=1');
        }

        $pdo->close(); 
    }
    else {
        $_SESSION['error'] = "Something went wrong! Try again!";
        redirect_to('category-all.php?page=1');
    }

?>