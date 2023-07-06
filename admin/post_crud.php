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
        $user = find_user(); $row = $user->fetch(); $author = $row['id']; //user id for author

        //photo upload
        if ( ! empty($_FILES['image']['name'])) :
            $file_name  = strtolower($_FILES['image']['name']);
            $file_ext = substr($file_name, strrpos($file_name, '.'));
            $prefix = 'img_'.md5(time()*rand(1, 9999));
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
    // Save draft on post-add.php
    elseif (isset($_POST['savedraft'])) {
        
        $title = checkInput($_POST['title']);
        $content = checkInput($_POST['content']);
        $excerpt = checkInput($_POST['excerpt']);
        $tags = checkInput($_POST['tags']);

        if (empty($_POST['checkbox'])) : $categories = 0; //Uncategorised
        else : $categories = implode(',', $_POST['checkbox']); endif;

        $now = datetime(); 
        $user = find_user(); $row = $user->fetch(); $author = $row['id']; //user id for author 
        $status = 1; //draft

        //photo upload
        if ( ! empty($_FILES['image']['name'])) :
            $file_name  = strtolower($_FILES['image']['name']);
            $file_ext = substr($file_name, strrpos($file_name, '.'));
            $prefix = 'img_'.md5(time()*rand(1, 9999));
            $filename = $prefix.$file_ext; 
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$filename);
        else: $filename = ''; endif;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("INSERT INTO posts(post_author,post_title,post_content,post_excerpt,post_meta,post_date,post_status,post_cat,image_file) VALUES(:author, :title, :content, :excerpt, :tags, :now, :pstatus, :categories, :image_file)");
            $stmt->execute(['author'=>$author, 'title'=>$title, 'content'=>$content, 'excerpt'=>$excerpt, 'tags'=>$tags, 'now'=>$now, 'pstatus'=>$status, 'categories'=>$categories, 'image_file'=>$filename]);

            if ($stmt) {
                $_SESSION['success'] = "Post saved as draft successfully";
                header('location: posts-draft.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-published.php?page=1');
        }

        $pdo->close();

    }
    // Update post, publish-now on post-edit.php
    elseif (isset($_POST['updatepost'])) {

        $id = $_GET['updatepost'];
        
        $title = checkInput($_POST['title']);
        $content = checkInput($_POST['content']);
        $excerpt = checkInput($_POST['excerpt']);
        $tags = checkInput($_POST['tags']);

        if (empty($_POST['checkbox'])) : $categories = 0; //Uncategorised
        else : $categories = implode(',', $_POST['checkbox']); endif;

        $now = datetime(); 
        $user = find_user(); $row = $user->fetch(); $author = $row['id']; //user id for author 
        $status = 0; //published

        //photo upload
        $filename = $_FILES['image']['name']; 
        $picture = dbtable_w('*', 'posts', 'id', $id); $data = $picture->fetch();
         
        if ( empty($_FILES['image']['name']) && empty($data['image_file'])) : $filename = '';
        elseif (empty($_FILES['image']['name']) && ! empty($data['image_file'])) : $filename = $data['image_file'];
        else :
            $file_name  = strtolower($_FILES['image']['name']);
            $file_ext = substr($file_name, strrpos($file_name, '.'));
            $prefix = 'img_'.md5(time()*rand(1, 9999));
            $filename = $prefix.$file_ext; 
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$filename); 
        endif; 

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE posts SET modified_by=:modified_by, post_title=:post_title, post_content=:post_content, post_excerpt=:post_excerpt, post_meta=:post_meta, post_modified=:post_modified, post_status=:post_status, post_cat=:post_cat, image_file=:image_file WHERE id=:id");
            $stmt->execute(['modified_by'=>$author, 'post_title'=>$title, 'post_content'=>$content, 'post_excerpt'=>$excerpt,'post_meta'=>$tags, 'post_modified'=>$now, 'post_status'=>$status, 'post_cat'=>$categories, 'image_file'=>$filename, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Post updated successfully";
                header('location: posts-published.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-published.php?page=1');
        }

        $pdo->close();

    }
    // Move to trash on post-edit.php
    elseif (isset($_POST['updatetrash'])) {

        $id = $_GET['updatepost'];
        
        $title = checkInput($_POST['title']);
        $content = checkInput($_POST['content']);
        $excerpt = checkInput($_POST['excerpt']);
        $tags = checkInput($_POST['tags']);

        if (empty($_POST['checkbox'])) : $categories = 0; //Uncategorised
        else : $categories = implode(',', $_POST['checkbox']); endif;

        $now = datetime(); 
        $user = find_user(); $row = $user->fetch(); $author = $row['id']; //user id for author 
        $status = 2; //Trash

        //photo upload
        $filename = $_FILES['image']['name']; 
        $picture = dbtable_w('*', 'posts', 'id', $id); $data = $picture->fetch();
         
        if ( empty($_FILES['image']['name']) && empty($data['image_file'])) : $filename = '';
        elseif (empty($_FILES['image']['name']) && ! empty($data['image_file'])) : $filename = $data['image_file'];
        else :
            $file_name  = strtolower($_FILES['image']['name']);
            $file_ext = substr($file_name, strrpos($file_name, '.'));
            $prefix = 'img_'.md5(time()*rand(1, 9999));
            $filename = $prefix.$file_ext; 
            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$filename); 
        endif; 

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE posts SET modified_by=:modified_by, post_title=:post_title, post_content=:post_content, post_excerpt=:post_excerpt, post_meta=:post_meta, post_modified=:post_modified, post_status=:post_status, post_cat=:post_cat, image_file=:image_file WHERE id=:id");
            $stmt->execute(['modified_by'=>$author, 'post_title'=>$title, 'post_content'=>$content, 'post_excerpt'=>$excerpt, 'post_meta'=>$tags, 'post_modified'=>$now, 'post_status'=>$status, 'post_cat'=>$categories, 'image_file'=>$filename, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Post moved to trash!";
                header('location: posts-published.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-published.php?page=1');
        } 

        $pdo->close();

    }

    // Trash button on posts-published.php
    elseif (isset($_POST['psingletrash'])) { 

        $id = $_GET['singlepost'];
        
        $status = 2;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE posts SET post_status=:post_status WHERE id=:id");
            $stmt->execute(['post_status'=>$status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Post moved to trash!";
                header('location: posts-published.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-published.php?page=1');
        }

        $pdo->close();

    }
    
    // Trash button on posts-draft.php
    elseif (isset($_POST['dsingletrash'])) { 

        $id = $_GET['singlepost'];
        
        $status = 2;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE posts SET post_status=:post_status WHERE id=:id");
            $stmt->execute(['post_status'=>$status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Post moved to trash!";
                header('location: posts-draft.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-draft.php?page=1');
        }

        $pdo->close();

    }
    
    // Draft button on posts-published.php
    elseif (isset($_POST['psingledraft'])) { 

        $id = $_GET['singlepost'];
        
        $status = 1;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE posts SET post_status=:post_status WHERE id=:id");
            $stmt->execute(['post_status'=>$status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Post moved to trash!";
                header('location: posts-published.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-published.php?page=1');
        }

        $pdo->close();

    }
    
    // Draft button on posts-trash.php
    elseif (isset($_POST['tsingledraft'])) { 

        $id = $_GET['singlepost'];
        
        $status = 1;

        $conn = $pdo->open();
  
        try {
            $stmt = $conn->prepare("UPDATE posts SET post_status=:post_status WHERE id=:id");
            $stmt->execute(['post_status'=>$status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Post moved to draft!";
                header('location: posts-trash.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-trash.php?page=1');
        }

        $pdo->close();

    }

    // Publish button on posts-draft.php
    elseif (isset($_REQUEST['dsinglepublish'])) { 

        $id = $_GET['singlepost'];

        $status = 0;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE posts SET post_status=:post_status WHERE id=:id");
            $stmt->execute(['post_status'=>$status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Post published successfully!";
                header('location: posts-draft.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-draft.php?page=1');
        }

        $pdo->close();

    }

    // Publish button on posts-trash.php
    elseif (isset($_REQUEST['tsinglepublish'])) { 

        $id = $_GET['singlepost'];

        $status = 0;

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("UPDATE posts SET post_status=:post_status WHERE id=:id");
            $stmt->execute(['post_status'=>$status, 'id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Post published successfully!";
                header('location: posts-trash.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-trash.php?page=1');
        }

        $pdo->close();

    }

    // Delete button on posts-trash.php
    elseif (isset($_REQUEST['tsingledelete'])) { 

        $id = $_GET['singlepost'];

        $conn = $pdo->open();

        try {
            $stmt = $conn->prepare("DELETE FROM posts WHERE id=:id");
            $stmt->execute(['id'=>$id]);

            if ($stmt) {
                $_SESSION['success'] = "Post deleted successfully!";
                header('location: posts-trash.php?page=1');
            }
                
        } 
        catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('location: posts-trash.php?page=1');
        }

        $pdo->close();

    }

    // if page is not set
    else {
        $_SESSION['error'] = "Form is not set!! Try again!";
        header('location: all-posts.php?page=1');
    }