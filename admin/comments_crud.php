<?php
include '../includes/session.php';
include '../auth/validation.php';
// include '../includes/general.php';
 
// Bulk Approve
if (isset($_POST['multiapprove'])) : 
    
    if (empty($_POST['checkbox'])) :
        $_SESSION['error'] = "Select comments before approving!";
        redirect_to('comments_unapproved.php?page=1');
    else: $id = implode("','", $_POST['checkbox']); endif; 

    $user = $_SESSION['admin'];
    $date = datetime();

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("UPDATE comments SET comment_status=1, date_approved=:date_approved, approved_by=:approved_by WHERE id in ('$id')");
        $stmt->execute(['date_approved'=>$date, 'approved_by'=>$user]);

        if ($stmt) : 
            $_SESSION['success'] = "Comments approved successfully";
            redirect_to("comments.php"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments.php");
    }

    $pdo->close();

// Bulk Unapprove 
elseif (isset($_POST['multiunapprove'])) : 

    if (empty($_POST['checkbox'])) : 
        $_SESSION['error'] = "Select comments before unapproving!";
        redirect_to('comments_approved.php?page=1');
    else: $id = implode("','", $_POST['checkbox']); endif; 

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("UPDATE comments SET comment_status=0 WHERE id in ('$id')");
        $stmt->execute();

        if ($stmt) : 
            $_SESSION['success'] = "Comments unapproved successfully";
            redirect_to("comments_approved.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments_approved.php?page=1");
    }

    $pdo->close();

// Bulk trash on comments_unapproved 
elseif (isset($_POST['multitrash'])) : 

    if (empty($_POST['checkbox'])) : 
        $_SESSION['error'] = "Select comments before moving to trash!";
        redirect_to('comments_unapproved.php?page=1');
    else: $id = implode("','", $_POST['checkbox']); endif; 

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("UPDATE comments SET comment_status=2 WHERE id in ('$id')");
        $stmt->execute();

        if ($stmt) : 
            $_SESSION['success'] = "Comments sent to trash successfully"; 
            redirect_to("comments_unapproved.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments_unapproved.php?page=1");
    }

    $pdo->close();

// Bulk trash on comments_approved
elseif (isset($_POST['multitrashapp'])) : 

    if (empty($_POST['checkbox'])) : 
        $_SESSION['error'] = "Select comments before moving to trash!";
        redirect_to('comments_approved.php?page=1');
    else: $id = implode("','", $_POST['checkbox']); endif; 

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("UPDATE comments SET comment_status=2 WHERE id in ('$id')");
        $stmt->execute();

        if ($stmt) : 
            $_SESSION['success'] = "Comments sent to trash successfully"; 
            redirect_to("comments_approved.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments_approved.php?page=1");
    }

    $pdo->close();

// Bulk trash of comments_mine
elseif (isset($_POST['replytrash'])) : 

    if (empty($_POST['checkbox'])) : 
        $_SESSION['error'] = "Select comments before moving to trash!";
        redirect_to('comments_mine.php?page=1');
    else: $id = implode("','", $_POST['checkbox']); endif; 

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("UPDATE comments SET comment_status=2,comment_type=2 WHERE id in ('$id')");
        $stmt->execute();

        if ($stmt) : 
            $_SESSION['success'] = "Comments reply sent to trash successfully"; 
            redirect_to("comments_mine.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments_mine.php?page=1");
    }

    $pdo->close();


// Bulk delete on comments_trash_can
elseif (isset($_POST['multidelete'])) : 

    if (empty($_POST['checkbox'])) : 
        $_SESSION['error'] = "Select comments before deleting!";
        redirect_to('comments_trash_can.php?page=1');
    else: $id = implode("','", $_POST['checkbox']); endif; 

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("DELETE FROM comments WHERE id in ('$id')");
        $stmt->execute();

        if ($stmt) : 
            $_SESSION['success'] = "Comments deleted successfully"; 
            redirect_to("comments_trash_can.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments__trash_can.php?page=1");
    }

    $pdo->close();

// Bulk delete on comments_mine
elseif (isset($_POST['replydelete'])) : 

    if (empty($_POST['checkbox'])) : 
        $_SESSION['error'] = "Select comments before deleting!";
        redirect_to('comments_mine.php?page=1');
    else: $id = implode("','", $_POST['checkbox']); endif; 

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("DELETE FROM comments WHERE id in ('$id')");
        $stmt->execute();

        if ($stmt) : 
            $_SESSION['success'] = "Comments reply deleted successfully"; 
            redirect_to("comments_mine.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments_mine.php?page=1");
    }

    $pdo->close();

// Default page for errors
else :  include('includes/navbar.php'); 
        on_page_errors('Something went wrong!', 'comments', 'Return to comments'); endif;

