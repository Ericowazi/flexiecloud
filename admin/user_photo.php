<?php 
    include('../includes/session.php');

    if (isset($_POST['upload'])) {

        $id = $_SESSION['admin']; 

        if (empty($_FILES['image']['name'])) {
            $_SESSION['error'] = "Choose photo before uploading!";
            header('location: profile.php?profile=' . urlencode($id));
            exit;
        }
        else {
            $file_name  = strtolower($_FILES['image']['name']);
            $file_ext = substr($file_name, strrpos($file_name, '.'));
            $prefix = 'img_'.md5(time()*rand(1, 9999));
            $filename = $prefix.$file_ext; 
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$filename); 

            $conn = $pdo->open();

            try {
                $stmt = $conn->prepare("UPDATE users SET photo=:photo WHERE id=:id");
                $stmt->execute(['photo'=>$filename, 'id'=>$id]);

                if ($stmt) {
                    $_SESSION['success'] = "Profile picture updated successfully";
                    header('location: profile.php?profile=' . urlencode($id));
                }
            } 
            catch (PDOException $e) {
                $_SESSION['error'] = $e->getMessage();
            }

            $pdo->close();
        }

    }
    else {
        $_SESSION['error'] = "Choose photo before uploading!!!!!";
        header('location: profile.php?profile=' . urlencode($id));
    }