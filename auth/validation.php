<?php
    // redirect to
    function redirect_to($location){ header('location: ' . $location); exit; }

    // Email address verification, do not edit.
    function isEmail($email) {
        return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
    }

    //Check input
    function checkInput($var){
        $var = htmlspecialchars($var); $var = trim($var); $var = stripslashes($var);
        return $var;
    }

    // Check Input Errors on user registration
    function checkErrors($username, $email, $password, $repassword) {

        global $pdo;
        $conn = $pdo->open();

        // Check if username exists 
        $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE username=:username");
        $stmt->execute(['username'=>$username]);
        $row = $stmt->fetch();

        if ($row['numrows'] > 0) {
            $_SESSION['error'] = "Username already taken! Try Again!";
            redirect_to("register.php");
        } 
        // Username shouldn't be empty
        elseif (empty($username)) {
            $_SESSION['error'] = "Username cannot be empty!";
            redirect_to("register.php");
            exit;
        } 
        //Username should be at least 5 characters
        elseif (strlen($username) < 5) {
            $_SESSION['error'] = "Username should be at-least 5 characters!";
            redirect_to("register.php");
            exit;
        }  
        // Email cannot be empty
        elseif (empty($email)) {
            $_SESSION['error'] = "Email is required!";
            redirect_to("register.php");
            exit;
        } 
        // Email validation
        elseif (!isEmail($email)) {
            $_SESSION['error'] = "Please enter a valid email!";
            redirect_to("register.php");
            exit;
        }
        //Password is required
        elseif (empty($password)) {
            $_SESSION['error'] = "Password is required!";
            redirect_to("register.php");
            exit;
        } 
        // Password at least 7 characters
        elseif (strlen($password)<7) {
            $_SESSION['error'] = "Password must be at-least 7 characters";
            redirect_to("register.php");
            exit;
        } 
        // Password match
        elseif ($password !== $repassword) {
            $_SESSION['error'] = "Password do not match";
            redirect_to("register.php");
            exit;
        }

        $pdo->close();
    }

    // Check Input Errors on profile update
    function userErrors($phone, $bio) {
        $profile = $_SESSION['admin'];
        
        if (strlen($phone) < 9) {
            $_SESSION['error'] = "Enter a valid phone number!";
            redirect_to("edit-profile.php?profile=" . urlencode($profile));
        } 
        if (strlen($bio) > 500) {
            $_SESSION['error'] = "Bio too long. Max 500 characters!";
            redirect_to("edit-profile.php?profile=" . urlencode($profile));
        } 
    }

    // Add category validation
    function checkCatInput($name, $description, $redirect){
        if (strlen($name)>80) {
            $_SESSION['error'] = "Category name too long! Recommended 60 characters!";
            header('location: add-category.php');
        } 
        elseif (empty($name)) {
            $_SESSION['error'] = "Category name required!";
            header('location: add-category.php');
        }
        elseif (strlen($description)>160) {
            $_SESSION['error'] = "Category description too long!";
            header('location: add-category.php');
        }
    }



