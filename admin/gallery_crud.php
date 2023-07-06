<?php
    include('../includes/session.php');
    include('../includes/general.php');


    // GALLERY PAGE CRUD
    // **
    // **

    if (isset($_POST['uploadphoto'])) {

        if (empty($_FILES['image']['name'])) {
            $_SESSION['error'] = "Choose photo before uploading!";
            header('location: gallery.php?page=1');
            exit;
        }
        else {
            $file_name  = strtolower($_FILES['image']['name']);
            $file_ext = substr($file_name, strrpos($file_name, '.'));
            $prefix = 'img_'.md5(time()*rand(1, 9999));
            $filename = $prefix.$file_ext; 
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$filename); 

            $code = generate_custom_code(12345678900, 11);

            $conn = $pdo->open();

            try {
                $stmt = $conn->prepare("INSERT INTO gallery(file_name, file_code) VALUES(:photo, :code)");
                $stmt->execute(['photo'=>$filename, 'code'=>$code]);

                if ($stmt) {
                    $_SESSION['success'] = "Photo uploaded successfully";
                    header('location: gallery.php?page=1');
                }
            } 
            catch (PDOException $e) {
                $_SESSION['error'] = $e->getMessage();
                header('location: gallery.php?page=1');
            }

            $pdo->close();
        }

    }
        
    // Delete 
    elseif (isset($_POST['deletephoto'])) {
    
        $id = $_GET['photo']; 
        
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("DELETE FROM gallery WHERE id=:id");
            $stmt->execute(['id'=>$id]);
    
            if ($stmt) : 
                $_SESSION['success'] = "Photo deleted successfully"; 
                redirect_to("gallery.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("gallery.php?page=1");
        }
    
        $pdo->close();
    }
    else {
        $_SESSION['error'] = "Form must be set Champ!!!!!";
        header('location: gallery.php?page=1');
    }