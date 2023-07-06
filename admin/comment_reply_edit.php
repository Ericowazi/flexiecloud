<?php include('../includes/session.php'); ?>
<?php include('includes/navbar.php'); ?>
<!-- partial -->
<div class="content-wrapper">
    <div class="row col-page-reply"> 
        <?php back_button('comments_mine.php?page=1'); 
        $id = $_GET['comment']; $stmt = dbtable_w('*', 'comments', 'id', $id); $row = $stmt->fetch(); ?>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                        <h4 class="card-title">Edit Reply</h4>
                        <?php alert_message(); ?>
                        <p class="card-description">
                            Reply <i class="ti-arrow-right"></i> <code><?php echo str_limit(htmlentities($row['comment_content']), 200) . "..."; ?></code>
                        </p>
                    <div class="col-page-responsive">
                        <form action="comment_crud.php?reply=<?= $row['id']; ?>" method="post" enctype="multipart/form-data"> 
                            <div class="form-group"> 
                                <textarea class="form-control" name="description" id="description" placeholder="Type reply here" cols="30" rows="10"><?= htmlentities($row['comment_content']); ?></textarea>
                            </div>
                            <div class="form-group buttons">
                                <button class="btn btn-primary float-right submit" type="submit" name="commentreply">Update Reply</button>
                                <a class="btn btn-outline-dark float-right cancel" href="comments_mine.php?page=1">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<!-- content-wrapper ends -->

<?php include('includes/footer_content.php'); ?>


