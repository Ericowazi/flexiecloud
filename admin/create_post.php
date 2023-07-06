<?php 
    include('../includes/session.php');
    include('../auth/validation.php');
    include('../includes/general.php');

    if (isset($_POST['addpost'])) {
        
        $title = checkInput($_POST['title']);
        $content = checkInput($_POST['content']);
        $excerpt = checkInput($_POST['excerpt']);
        $tags = checkInput($_POST['tags']);
        if (empty($_POST['checkbox'])) : $categories = 0; //Uncategorised
        else : $categories = implode(',', $_POST['checkbox']); endif;
        $now = datetime();

        //user id for author
        $user = find_user(); $row = $user->fetch(); $author = $row['id']; 
 
        if ( ! empty($_FILES['image']['name'])) :
        $file_name  = strtolower($_FILES['image']['name']);
        $file_ext = substr($file_name, strrpos($file_name, '.'));
        $prefix = 'neo_'.md5(time()*rand(1, 9999));
        $filename = $prefix.$file_ext; 
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$filename);
        else: $filename = ''; endif;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("INSERT INTO posts(post_author,post_title,post_content,post_excerpt,post_meta,post_date,post_cat,image_file) VALUES(:author, :title, :content, :excerpt, :tags, :now, :categories, :image_file)");
            $stmt->execute(['author'=>$author, 'title'=>$title, 'content'=>$content, 'excerpt'=>$excerpt, 'tags'=>$tags, 'now'=>$now, 'categories'=>$categories, 'image_file'=>$filename]);

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
    elseif (isset($_POST['trash'])) {
        
        $title = checkInput($_POST['title']);
        $content = checkInput($_POST['content']);
        $excerpt = checkInput($_POST['excerpt']);
        $tags = checkInput($_POST['tags']);
        $categories = implode(',', $_POST['checkbox']);
        if (empty($_POST['checkbox'])) : $categories = 0; //Uncategorised
        else : $categories = implode(',', $_POST['checkbox']); endif;
        $now = datetime();

        //user id for author
        $user = find_user();
        $row = $user->fetch();
        $author = $row['id'];

        $status = 1;
        
        $filename = $_FILES['image']['name'];

        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$filename);

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("INSERT INTO posts(post_author, post_title, post_content, post_excerpt, post_meta, post_date, post_status, post_cat, image_file) VALUES(:author, :title, :content, :excerpt, :tags, :now, :status, :categories, :image_file)");
            $stmt->execute(['author'=>$author, 'title'=>$title, 'content'=>$content, 'excerpt'=>$excerpt, 'tags'=>$tags, 'now'=>$now, 'status'=>$status, 'categories'=>$categories, 'image_file'=>$filename]);

            if ($stmt) {
                $_SESSION['success'] = "Post moved to trash! TBH!! ";
                header('location: all-posts.php');
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