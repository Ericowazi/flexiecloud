<?php
include '../includes/session.php';
include '../auth/validation.php';
include '../includes/general.php';

// Submit comment
if(isset($_POST['submitcomment'])) : $id = $_GET['comment'];

    $name = checkInput($_POST['name']);
    $email = $_POST['email'];
    $website = checkInput($_POST['website']);
    $comment = checkInput($_POST['comment']);
    $post_id = $id;
    $date = datetime();

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("INSERT INTO comments(comment_author,author_email,author_url,comment_content,post_id,comment_date) VALUES(:author,:email,:link,:content,:post_id,:todate)");
        $stmt->execute(['author'=>$name, 'email'=>$email, 'link'=>$website, 'content'=>$comment, 'post_id'=>$post_id, 'todate'=>$date]);

        if ($stmt) : 
            $_SESSION['success'] = "Comment sent successfully";
            redirect_to("../sailor/blog-single.php?id=" . urlencode($id)); endif;

    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("../sailor/blog-single.php?id=" . urlencode($id)); }

    $pdo->close();

// Submit comment reply
elseif(isset($_POST['sendreply'])) : $id = $_GET['id'];
   
    $reply = checkInput($_POST['description']);
    $comment_status = 3; 
    $comment_id = $id; 
    $comment_type = 1; 
    $date = datetime(); 

    $postTable = dbtable_w('*', 'comments', 'id', $id); $compost = $postTable->fetch();
    $post_id = $compost['post_id'];

    //get admin info
    $table = find_user(); $user = $table->fetch(); 
    $author = $user['username']; 

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("INSERT INTO comments(comment_author,comment_content,comment_date,comment_status,comment_type,post_id,comment_id) VALUES(:author, :content, :todate,:comment_status, :comment_type, :post_id, :comment_id)");
        $stmt->execute(['author'=>$author, 'content'=>$reply, 'todate'=>$date, 'comment_status'=>$comment_status, 'comment_type'=>$comment_type, 'post_id'=>$post_id, 'comment_id'=>$comment_id]);

        if ($stmt) : 
            $_SESSION['success'] = "Reply sent successfully";
            redirect_to("comments_approved.php?page=1"); endif;

    } 

    catch (PDOException $e) { 
        $_SESSION['error'] = $e->getMessage();  
        redirect_to("comments_approved.php?page=1"); }

    $pdo->close();

// Submit comment reply
elseif(isset($_POST['commentreply'])) : $id = $_GET['reply'];
   
    $reply = checkInput($_POST['description']); 
    $date = datetime();  

    //get admin info
    $table = find_user(); $user = $table->fetch(); 
    $author = $user['id']; 

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("UPDATE comments SET comment_content=:comment_content, date_approved=:date_approved, approved_by=:approved_by WHERE id=:id");
        $stmt->execute(['comment_content'=>$reply, 'date_approved'=>$date, 'approved_by'=>$author, 'id'=>$id]);

        if ($stmt) : 
            $_SESSION['success'] = "Reply editted successfully";
            redirect_to("comments_mine.php?page=1"); endif;

    } 

    catch (PDOException $e) { 
        $_SESSION['error'] = $e->getMessage();  
        redirect_to("comments_mine.php?page=1"); } 

    $pdo->close();

// Single Approve
elseif (isset($_POST['singleapprove'])) : $id = $_GET['id'];

    $user = $_SESSION['admin'];
    $date = datetime();

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("UPDATE comments SET comment_status=1, date_approved=:date_approved, approved_by=:approved_by WHERE id=:id");
        $stmt->execute(['date_approved'=>$date, 'approved_by'=>$user, 'id'=>$id]);

        if ($stmt) : 
            $_SESSION['success'] = "Comment approved successfully";
            redirect_to("comments.php"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments.php");
    }

    $pdo->close();

// Single Restore on comments_trash_can
elseif (isset($_POST['singlerestore'])) : $id = $_GET['id'];

    $user = $_SESSION['admin'];
    $date = datetime();

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("UPDATE comments SET comment_status=1, date_approved=:date_approved, approved_by=:approved_by WHERE id=:id");
        $stmt->execute(['date_approved'=>$date, 'approved_by'=>$user, 'id'=>$id]);

        if ($stmt) : 
            $_SESSION['success'] = "Comment restored successfully";
            redirect_to("comments_trash_can.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments_trash_can.php?page=1");
    }

    $pdo->close();

// Single Restore for reply comments on comments_trash_can
elseif (isset($_POST['replyrestore'])) : $id = $_GET['id'];

    $user = $_SESSION['admin'];
    $date = datetime();

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("UPDATE comments SET comment_status=3,comment_type=1, date_approved=:date_approved, approved_by=:approved_by WHERE id=:id");
        $stmt->execute(['date_approved'=>$date, 'approved_by'=>$user, 'id'=>$id]);

        if ($stmt) : 
            $_SESSION['success'] = "Comment reply restored successfully";
            redirect_to("comments_trash_can.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments_trash_can.php?page=1");
    }

    $pdo->close();

// Single Unapprove
elseif (isset($_POST['singleunapprove'])) : $id = $_GET['id'];

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("UPDATE comments SET comment_status=0 WHERE id=:id");
        $stmt->execute(['id'=>$id]);

        if ($stmt) : 
            $_SESSION['success'] = "Comment unapproved successfully";
            redirect_to("comments_approved.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments_approved.php?page=1");
    }

    $pdo->close();

// Single trash on comments_unapproved
elseif (isset($_POST['singletrash'])) : $id = $_GET['id'];

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("UPDATE comments SET comment_status=2 WHERE id=:id");
        $stmt->execute(['id'=>$id]);

        if ($stmt) : 
            $_SESSION['success'] = "Comment sent to trash successfully"; 
            redirect_to("comments_unapproved.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments_unapproved.php?page=1");
    }

    $pdo->close();

// Single trash on comments_approved
elseif (isset($_POST['singletrashapp'])) : $id = $_GET['id'];

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("UPDATE comments SET comment_status=2 WHERE id=:id");
        $stmt->execute(['id'=>$id]);

        if ($stmt) : 
            $_SESSION['success'] = "Comment sent to trash successfully"; 
            redirect_to("comments_approved.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments_approved.php?page=1");
    }

    $pdo->close();

// Single trash of comments_mine
elseif (isset($_POST['singletrashmine'])) : $id = $_GET['id'];

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("UPDATE comments SET comment_status=2,comment_type=2 WHERE id=:id");
        $stmt->execute(['id'=>$id]);

        if ($stmt) : 
            $_SESSION['success'] = "Comment reply sent to trash successfully"; 
            redirect_to("comments_mine.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments_mine.php?page=1");
    }

    $pdo->close();

// Single delete on comments_trash_can
elseif (isset($_POST['singledelete'])) : $id = $_GET['id'];

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("DELETE FROM comments WHERE id=:id");
        $stmt->execute(['id'=>$id]);

        if ($stmt) : 
            $_SESSION['success'] = "Comment deleted successfully"; 
            redirect_to("comments_trash_can.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments__trash_can.php?page=1");
    }

    $pdo->close();

// Single delete on comments_mine
elseif (isset($_POST['singleminedelete'])) : $id = $_GET['id'];

    $conn = $pdo->open();

    try {
        $stmt = $conn->prepare("DELETE FROM comments WHERE id=:id");
        $stmt->execute(['id'=>$id]);

        if ($stmt) : 
            $_SESSION['success'] = "Comment reply deleted successfully"; 
            redirect_to("comments_mine.php?page=1"); endif;
    } 
    catch (PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
        redirect_to("comments_mine.php?page=1");
    }

    $pdo->close();

else :  include('includes/navbar.php'); 
        on_page_errors('Something went wrong!', 'comments', 'Return to comments'); endif;











