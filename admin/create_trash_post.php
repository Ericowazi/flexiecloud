<?php 
    include('../includes/session.php');
    include('../auth/validation.php');
    include('../includes/general.php');

    if (isset($_POST['trash'])) {
        
        $title = checkInput($_POST['title']);
        $content = checkInput($_POST['content']);
        $excerpt = checkInput($_POST['excerpt']);
        $tags = checkInput($_POST['tags']);
        $categories = implode(',', $_POST['checkbox']);
        if (empty($categories)) { $categories = 0; } //Uncategorised
        $now = datetime();

        //user id for author
        $user = find_user();
        $row = $user->fetch();
        $author = $row['id'];

        $status = 1;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("INSERT INTO posts(post_author, post_title, post_content, post_excerpt, post_meta, post_date, post_status, post_cat) 
            VALUES(:author, :title, :content, :excerpt, :tags, :now, :status, :categories)");
            $stmt->execute(['author'=>$author, 'title'=>$title, 'content'=>$content, 'excerpt'=>$excerpt, 'tags'=>$tags, 'now'=>$now, 'status'=>$status, 'categories'=>$categories]);

            if ($stmt) {
                $_SESSION['success'] = "Post published successfully";
                header('location: add-post.php');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: add-post.php');
        }

        $pdo->close();

    }
    else {
        $_SESSION['error'] = "Form is not set!! Try again!";
        header('location: add-post.php');
    }