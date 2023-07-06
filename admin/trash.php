<?php include('../includes/session.php'); ?>
<?php include('includes/navbar.php'); ?>
<!-- partial -->
<div class="content-wrapper">
    <form action="post_crud.php" method="post">
    <div class="row all-post">
        <div class="col-lg-12 grid-margin">
            <div class="card post-card">
                <?php //check if page is set
                    if (isset($_GET['page'])) : $page = $_GET['page'];  if(empty($page)): $page = 1; endif; //<-- set default page to 1 if no page is set, to avoid errors

                    //Check total count for the post/s
                    $countTotal = count_total('*', 'posts'); $count = count_total_w('*', 'posts', 'post_status', 0); $trash = count_total_w('*', 'posts', 'post_status', 1);
                ?>
                <!-- Filter start -->
                <div class="card-body">
                    <div class="add-new" style="margin-bottom:15px; margin-left: 5px;">
                        <a class="back" href="all-posts.php?page=1"><i class="ti-arrow-left"></i>&nbsp;go to posts</a>
                    </div>
                    <?php alert_message(); //success and error messages ?>
                    <div class="table-responsive view-category">

                        <!-- Table Header start -->
                        <div class="table-header">
                            <label for=""> 
                                <span>All (<?php echo $countTotal; ?>)</span> | <a disabled href="all-posts.php?page=1">Published (<?php echo $count; ?>)</a> | <a style="color: #f00404;" href="">Trash (<?php echo $trash; ?>)</a>
                            </label>
 
                            <?php if($trash > 0): //posts available in trash ?>
                            <div class="filter">
                                <?php $table = dbtable('*', 'nav_items'); ?>
                                <div class="dropdown">
                                    <button class="delete-button"><a class="btn btn-dark btn-sm deletebox" data-toggle="modal" data-id="" href="#deletepost">Delete</a></button>
                                    <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle filter-button" id="dropdownMenuIconButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                    if ($page==0 || $page<1) : $page_count = 0; //set pagination
                                    else : $postNo = page_item_number('*', 'posts', 'post_status', 1); $page_count = ($page*$postNo)-$postNo; endif;

                                    find_posts('*', 'posts', 'post_status', 1, 'id desc','APIF2', $page_count, $postNo); 
                                        
                                    //Only show pagination when the number of pages exceeds one e.g 2,3
                                    if($count > $postNo): pagination($page, '*',  'posts', 'post_status', 1, $postNo); endif;
                                    
                                    include('includes/modal.php');
                                 ?>
                            </tbody>
                        </table>
                        <?php else: echo '</div> <h4>Hurraayyy!!! You are trash freee</h4>'; endif; //posts available in trash end ?>
                    </div>
                </div>
                <!-- card-body End -->
                <?php else : on_page_errors('Trash page not set', 'trash', 'return to trash'); endif; ?>
            </div>
            <!-- Post-card End -->
        </div>
        <!-- Col-lg-12 End -->
    </div>
</div>

<?php include('includes/footer_content.php'); ?>


