<?php
    include('../includes/session.php');
    include('../includes/general.php');


    // SUBSCRIBERS ALL PAGE CRUD
    // **
    // **
    // Add subscriber on subscribers page 
    if (isset($_POST['addnewsubscriber'])) : 

        if(!empty($_POST['email'])) : $email = $_POST['email']; else: $_SESSION['error'] = "Email cannot be empty! TBH"; header("location: subscribers.php?page=1"); endif;
        $time = datetime();

        $conn = $pdo->open();
        try {
            $stmt = $conn->prepare("INSERT INTO subscribers(email, date_registered) VALUES(:email, :regtime)");
            $stmt->execute(['email'=>$email, 'regtime'=>$time]);

            if ($stmt) :
                $_SESSION['success'] = "Subscriber added successfully!";
                header("location: subscribers.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header("location: subscribers.php?page=1");
        }

        $pdo->close();
        
    // Bulk trash 
    elseif (isset($_POST['trash450'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select subscribers before sending to trash!";
            redirect_to('subscribers.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $sub_type = 1;
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE subscribers SET sub_type=:sub_type WHERE id in ('$id')");
            $stmt->execute(['sub_type'=>$sub_type]);
    
            if ($stmt) : 
                $_SESSION['success'] = "Subscribers sent to trash successfully"; 
                redirect_to("subscribers.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("subscribers.php?page=1");
        }
    
        $pdo->close();
        
    // Bulk spam 
    elseif (isset($_POST['spam450'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select subscribers before sending to spam!";
            redirect_to('subscribers.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $sub_type = 2;
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE subscribers SET sub_type=:sub_type WHERE id in ('$id')");
            $stmt->execute(['sub_type'=>$sub_type]);
    
            if ($stmt) : 
                $_SESSION['success'] = "Subscribers sent to spam successfully"; 
                redirect_to("subscribers.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("subscribers.php?page=1");
        }
    
        $pdo->close();


    // SUBSCRIBERS TRASH PAGE CRUD
    // **
    // **
    // Bulk restore 
    elseif (isset($_POST['restore451'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select subscribers before restore!";
            redirect_to('subscribers-trash.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $sub_type = 0;
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE subscribers SET sub_type=:sub_type WHERE id in ('$id')");
            $stmt->execute(['sub_type'=>$sub_type]);
    
            if ($stmt) : 
                $_SESSION['success'] = "Subscribers restored successfully"; 
                redirect_to("subscribers-trash.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("subscribers-trash.php?page=1");
        }
    
        $pdo->close();
        
    // Bulk delete 
    elseif (isset($_POST['delete451'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select subscribers before deleting!";
            redirect_to('subscribers-trash.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
        
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("DELETE FROM subscribers WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Subscribers deleted successfully"; 
                redirect_to("subscribers-trash.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("subscribers-trash.php?page=1");
        }
    
        $pdo->close();


    // SUBSCRIBERS SPAM PAGE CRUD
    // **
    // **
    // Bulk restore 
    elseif (isset($_POST['restore452'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select subscribers before restore!";
            redirect_to('subscribers-spam.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
    
        $sub_type = 0;
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("UPDATE subscribers SET sub_type=:sub_type WHERE id in ('$id')");
            $stmt->execute(['sub_type'=>$sub_type]);
    
            if ($stmt) : 
                $_SESSION['success'] = "Subscribers restored successfully"; 
                redirect_to("subscribers-spam.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("subscribers-spam.php?page=1");
        }
    
        $pdo->close();
        
    // Bulk delete 
    elseif (isset($_POST['delete452'])) : 
    
        if (empty($_POST['checkbox'])) : 
            $_SESSION['error'] = "Select subscribers before deleting!";
            redirect_to('subscribers-spam.php?page=1');
        else: $id = implode("','", $_POST['checkbox']); endif; 
        
        $conn = $pdo->open();
    
        try {
            $stmt = $conn->prepare("DELETE FROM subscribers WHERE id in ('$id')");
            $stmt->execute();
    
            if ($stmt) : 
                $_SESSION['success'] = "Subscribers deleted successfully"; 
                redirect_to("subscribers-spam.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect_to("subscribers-spam.php?page=1");
        }
    
        $pdo->close();


    // BAHESIAN PAGE CRUD
    // **
    // **
    // Add subscriber on subscribers page 
    elseif (isset($_POST['addbahesian'])) : 

        $prio_prob = $_POST['prio'];
        $odds = $_POST['odds'];
        $current_f = $_POST['currentf'];
        $q_likelihood = $_POST['qlike'];

        $dprio_prob = $_POST['dprio'];
        $dodds = $_POST['dodds'];
        $dcurrent_f = $_POST['dcurrentf'];
        $dq_likelihood = $_POST['dqlike'];

        $aprio_prob = $_POST['aprio'];
        $aodds = $_POST['aodds'];
        $acurrent_f = $_POST['acurrentf'];
        $aq_likelihood = $_POST['aqlike'];

        $conn = $pdo->open();
        try {
            $stmt = $conn->prepare("INSERT INTO bahesian(prio, odds,currentf,qlike, dprio, dodds,dcurrentf,dqlike,aprio, aodds,acurrentf,aqlike) 
            VALUES(:prio, :odds,:currentf,:qlike,:dprio, :dodds,:dcurrentf,:dqlike,:aprio, :aodds,:acurrentf,:aqlike)");
            $stmt->execute(['prio'=>$prio_prob, 'odds'=>$odds, 'currentf'=>$current_f, 'qlike'=>$q_likelihood, 'dprio'=>$dprio_prob, 'dodds'=>$dodds, 'dcurrentf'=>$dcurrent_f, 'dqlike'=>$dq_likelihood, 'aprio'=>$aprio_prob, 'aodds'=>$aodds, 'acurrentf'=>$acurrent_f, 'aqlike'=>$aq_likelihood]);

            if ($stmt) :
                $_SESSION['success'] = "Units added successfully!";
                header("location: newsletters.php?page=1"); endif;
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header("location: newsletters.php?page=1");
        }

    
    else :
        $_SESSION['error'] = "Form must be set! TBH"; 
        redirect_to("subscribers.php?page=1");
    endif;