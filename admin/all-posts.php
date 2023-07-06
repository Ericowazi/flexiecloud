<?php include('../includes/session.php'); ?>
<?php include('includes/navbar.php'); ?> 
<!-- partial -->
<div class="content-wrapper">
    <form action="post_crud.php" method="post">
    <div class="row all-post">
        <div class="col-lg-12 grid-margin">
            <div class="card post-card">
                <?php //page must be set
                    if (isset($_GET['page'])) : $page = $_GET['page']; if(empty($page)): $page = 1; endif;//<-- set default page to 1 if no page is set, to avoid errors 

                    if ($page==0 || $page<1) : $page_count = 0; 
                    else : $postNo = page_item_number('*', 'posts', 'post_status', 0); $page_count = ($page*$postNo)-$postNo; endif; 
                ?>
                <!-- Card-body start -->
                <div class="card-body">
                    <h2 class=""><span>Posts </span>&nbsp;&nbsp;<a class="btn btn-primary btn-sm" href="add-post.php">Add New</a></h2>
                    <?php alert_message(); get_posts_header(450); 
                    get_posts('*', 'posts', 'post_status=0', 'id desc', $page_count, $postNo, 'post_status', 0, 450, 'Published'); ?>  
                </div>
                <!-- card-body End -->
                <?php else : on_page_errors('Posts page not set', 'all-posts', 'return to posts'); endif; ?>
            </div>
            <!-- Post-card End -->
        </div>
        <!-- Col-lg-12 End -->
    </div>
</div>
 
<?php include('includes/footer_content.php'); ?>


