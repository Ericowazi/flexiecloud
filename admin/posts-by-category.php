<?php include('../includes/session.php'); 
include('includes/navbar.php'); 
if (isset($_GET['category'])) : $key = $_GET['category']; 
?>
<!-- partial -->
<div class="content-wrapper">
    <form action="delete_post.php" method="post">
    <div class="row all-post">
        <div class="col-lg-12 grid-margin">
            <div class="card post-card">
                <div class="card-body"> 
                    <?php get_posts_header(452); $table = dbtable('*', 'nav_items'); $tableCat = dbtable_w('*', 'nav_items', 'post_key', $key); $catName = $tableCat->fetch(); ?>
                    <div class="add-new" style="margin-bottom:15px; margin-left: 5px;">
                        <a class="back" href="all-posts.php?page=1"><i class="ti-arrow-left"></i>&nbsp;go to posts</a>
                    </div>
                    <h2 class=""><span style="font-size: .5em">Category: </span> <a style="color: #4B49AC; font-size: .5em" class="" href=""><?php echo $catName['name'];  ?></a></h2>
                    <?php alert_message(); ?>
                    <div class="table-responsive view-category">
                        <?php //Check total count for the category on filter 
                            $checktotal = count_total_like_order('*', 'posts', $key, 'post_cat', 'post_status', 0, 'id desc'); ?>
                        <!-- Table Header start -->
                        <div class="table-header">

                            <!-- Filter start -->
                            <div class="filter">
                                <div class="dropdown">
                                    <?php if($checktotal > 0): ?>
                                    <button class="delete-button"><a class="btn btn-dark btn-sm deletebox" data-toggle="modal" data-id="" href="#deletepost">Delete</a></button>
                                    <?php else: ?> 
                                    <button class="delete-button"  disabled="disabled"><a class="btn btn-inverse-secondary btn-sm deletebox" data-toggle="modal" data-id="" href="#deletepost">>>>></a></button> <?php endif; ?>
                                    <button type="button" class="btn btn-outline-light btn-sm dropdown-toggle filter-button" id="dropdownMenuIconButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Filter/Category
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton4">
                                        <?php foreach ($table as $value) { echo '<a class="dropdown-item" href="posts-by-category.php?category=' . $value['post_key'] . '">' . $value['name'] . '</a>'; } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Filter End -->
                        </div> 
                        <!-- Table Header End -->

                        <?php if ($checktotal > 0): //if there are post for the selected category proceed ?>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><input checked disabled type="checkbox" name="" id=""></th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $conn = $pdo->open();

                                    $stmt = $conn->prepare("SELECT * FROM posts WHERE post_cat LIKE '%$key%' AND post_status=0 ORDER BY id desc");
                                    $stmt->execute(); 
                                     
                                    foreach ($stmt as $row) { 
                                        $user = dbtable_w('*', 'users', 'id', $row['post_author']);
                                        $author = $user->fetch(); 
                                            echo ' 
                                                <tr><td>
                                                <input type="checkbox" name="checkbox[]" id="" value=" '. $row['id'] . '"></td>
                                                    <td class="post-title"><a style="" href=""> ' . $row['post_title'] . ' <br> <span><i class="ti-user"></i> '. $author['username'] .' </span></a></td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button" class="btn btn-outline-light btn-sm dropdown-toggle" id="dropdownMenuIconButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="ti-settings"></i>
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton4">
                                                                <a class="dropdown-item" href="edit-post.php?update='. $row['id'] .'">Edit</a>
                                                                <form action="update_post.php?movetotrash=' .  $row['id'] .'" method="post" enctype="multipart/form-data">
                                                                <a href="update_post.php?movetotrash='. $row['id'] .'">
                                                                <button class="dropdown-item" type="submit" name="movetotrash">
                                                                        Move to Trash
                                                                    </button></a>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade" id="deletepost">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Deleting...</h5>
                                                                        <button type="button" data-dismiss="modal" class="close" aria-label="close">
                                                                            <span arial-hidden="true"></span> &times;
                                                                        </button>
                                                                    </div>
                                                                        <div class="modal-body">
                                                                        Are you sure you want to delete?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button class="btn btn-primary btn-sm " type="submit" name="delete">Delete Now</button>
                                                                            <button class="btn btn-default btn-sm" type="button" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </form>
                                            '; 
                                    }

                                    $pdo->close();
                                
                                ?>
                            </tbody>
                        </table>
                        <?php else: echo '<h4> No post/s available for this category ! </h3>'; endif; ?>
                    </div>
                </div>
                <!-- card-body End -->
            </div>
            <!-- Post-card End -->
        </div>
        <!-- Col-lg-12 End -->
    </div>
</div>
<?php else : on_page_errors('Posts page not set', 'all-posts', 'return to posts'); endif; ?>

<?php include('includes/footer_content.php'); ?>


