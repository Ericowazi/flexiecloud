<?php
    include('../includes/session.php');
    include('../auth/validation.php');

    if (isset($_POST['profile'])) {

        $profile = $_SESSION['admin'];
        
        $firstname =  checkInput($_POST['Firstname']);
        $secondname =  checkInput($_POST['Secondname']);
        $phone =  checkInput($_POST['Phone']);
        $country =  checkInput($_POST['Country']);
        $city =  checkInput($_POST['City']);
        $bio =  checkInput($_POST['Bio']);

        // Check input 
        userErrors($phone, $bio);

        $conn = $pdo->open();

        try {

            $stmt = $conn->prepare("UPDATE users SET  firstName=:firstname, secondName=:secondname, phone=:phone, country=:country, city=:city, bio=:bio WHERE id=:id");
            $stmt->execute(['firstname'=>$firstname, 'secondname'=>$secondname, 'phone'=>$phone, 'country'=>$country, 'city'=>$city, 'bio'=>$bio, 'id'=>$profile]);
            if ($stmt) {
                $_SESSION['success'] = "Profile updated successfuly!";
                redirect_to("profile.php?profile=" . urlencode($profile));
            }
            else {
                $_SESSION['error'] = "Something went wrong! Try Again!";
                redirect_to("profile.php?profile=" . urlencode($profile));
            }
        } catch (PDOException $e) {
            echo "There is some problem in connection! " . $e->getMessage();
        }
        
        $pdo->close();
    }
    else {
        $_SESSION['error'] = "Fill up signup form first!";
        redirect_to("edit-profile.php?profile=" . urlencode($profile));
    }

