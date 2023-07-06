<?php include('../includes/session.php'); ?>
<?php include('includes/navbar.php'); ?>
<!-- partial -->
<div class="content-wrapper"> 
    <div class="row category">
        <div class="col-lg-12 stretch-card">
            <div class="add-new">
                <a class="btn btn-primary btn-sm" href="add-category.php">Add New Category</a>
            </div>
        </div>
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                        <h4 class="card-title">All Categories</h4>
                        <p class="card-description">
                            Arranged in descending<code>order</code>
                        </p>
                        <?php alert_message(); ?>
                    <div class="table-responsive view-category">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th> 
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-outline-light btn-sm dropdown-toggle" id="dropdownMenuIconButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="ti-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton4"> 
                                                <a class="dropdown-item" data-toggle="modal" data-id="" href="#deletecategory">Delete</a>
                                                <form action="add_to_nav.php?navigation=' . $row['id'] . '" method="post" enctype="multipart/form-data">
                                                    <a class="dropdown-item" href="add_to_nav.php?navigation=' . $row['id'] . '">
                                                        <button type="submit" class="" name="navigation">Add to Navigation Bar</button>
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="deletecategory">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Deleting... </h5>
                                                        <button type="button" data-dismiss="modal" class="close" aria-label="close">
                                                            <span arial-hidden="true"></span> &times;
                                                        </button>
                                                    </div>
                                                    <form action="category_crud.php?delete=' . $row['id'] .'" method="post">
                                                        <div class="modal-body">
                                                        Are you sure you want to delete?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-primary btn-sm " type="submit" name="delete">Delete Now</button>
                                                            <button class="btn btn-default btn-sm" type="button" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> 
                                    </th>
                                    <th>Category</th>
                                    <th>Action</th>
                                    <!-- <th>Status</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php all_categories('id desc'); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 grid-margin">
            <div class="card">
                <div class="card-body">
                        <h4 class="card-title">Navigation Bar Categories</h4>
                        <p class="card-description">
                            What is this?<code>Find out...</code>
                        </p>
                    <div class="table-responsive">
                        <?php $navs = count_total_w('*', 'nav_items', 'nav_group', 1); if ($navs > 0) : ?>
                        <table class="table table-hover">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php navigation_categories('id desc'); ?>
                        </tbody>
                        </table>
                        <?php else : echo '<p style="font-size: 1em;">No navigation bar categories added</p>'; endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<!-- content-wrapper ends -->

<?php include('includes/footer_content.php'); ?>


