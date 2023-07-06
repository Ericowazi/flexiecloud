<?php include('../includes/session.php'); ?>
<?php include('includes/navbar.php'); ?>
<!-- partial -->
<div class="content-wrapper">
    <div class="row category">
        <div class="col-lg-12 stretch-card">
            <div class="add-new">
                <a class="back" href="category.php"><i class="ti-arrow-left"></i>&nbsp;back</a>
            </div>
        </div>
        <div class="col-lg-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                        <h4 class="card-title">Add New Category</h4>
                        <p class="card-description">
                            Fill the<code>form</code>
                        </p>
                        <?php alert_message(); ?>
                    <div class="category-responsive">
                        <form action="category_crud.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Category Name*</label>
                                <input type="text" class="form-control" name="name" value="" placeholder="Enter category name" required>
                            </div>
                            <div class="form-group">
                                <label for="name">Description</label><br>
                                <label class="cat-label" for="name"><i class="ti-arrow-right"></i> 
                                    Max length 160 - Used for<code>Metatag Description</code> essential for SEO
                                </label>
                                <textarea class="form-control" name="description" id="description" placeholder="Enter Description here" cols="30" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <a class="btn btn-outline-dark float-right" href="category.php">Cancel</a>
                                <button style="margin-right: 20px;" class="btn btn-primary float-right" type="submit" name="category">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                        <h4 class="card-title">Recently Added</h4>
                        <p class="card-description">
                            Last <code>10 categories</code>
                        </p>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php sidebar_categories('id desc', 10); ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->

<?php include('includes/footer_content.php'); ?>


