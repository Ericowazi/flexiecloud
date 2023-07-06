<?php include('../includes/session.php'); ?>
<?php include('includes/navbar.php'); ?>
<!-- partial -->
<div class="content-wrapper">
    <form action="update_post.php" method="post" enctype="multipart/form-data">
    <div class="row add-post">
        <div class="col-lg-12 stretch-card">
            <div class="add-new-title">
                <label for="add-new-post">Add New Post</label>
            </div>
        </div>
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="post-card">
                <?php alert_message(); ?>
                <div class="post-body">
                    <!-- Title Start -->
                    <div class="form-group">
                        <input type="text" class="form-control title" id="title" name="title" placeholder="Enter title here" required>
                    </div>
                    <!-- Body content Start -->
                    <div class="form-group">
                        <textarea class="form-control" name="content" id="editor1" cols="30" rows="30" placeholder="Enter content here"></textarea>
                    </div>

                    <!-- Tags Start -->
                    <div class="card-group excerpt" id="accordion">
                        <div class="card">
                            <div class="card-heading">
                                <a data-toggle="collapse" data-parent="#accordion" href="#tags<?php ?>"> 
                                    <label for="">Tags <span style=""> <i class="ti-plus"></i> </span> </label>
                                </a>
                            </div>
                            <div id="tags" class="card-collapse collapsed in">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="excerpt">Tags (Optional)</label>
                                        <br>
                                        <label class="cat-label" for="name"><i class="ti-arrow-right"></i> 
                                            Enter tags below<code>essential for SEO</code> separate tags with comma (,)
                                        </label>
                                        <textarea class="form-control" name="tags" id="tags" cols="30" rows="5" placeholder="Enter tags here - separate with a comma (,)"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tags End -->
                    
                    <!-- Excerpt Start -->
                    <div class="card-group excerpt" id="accordion">
                        <div class="card">
                            <div class="card-heading">
                                <a data-toggle="collapse" data-parent="#accordion" href="#excerpt<?php ?>"> 
                                    <label for="">Excerpt <span style=""> <i class="ti-plus"></i> </span> </label>
                                </a>
                            </div>
                            <div id="excerpt" class="card-collapse collapse in">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="excerpt">Excerpt (Optional)</label>
                                        <br>
                                        <label class="cat-label" for="name"><i class="ti-arrow-right"></i> 
                                            Max length 160 - Used for<code>Metatag Description</code> essention for SEO
                                        </label>
                                        <textarea class="form-control" name="excerpt" id="excerpt" cols="30" rows="5" placeholder="Enter excerpt here"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Excerpt End -->
                </div>
            </div>
            <!-- Post-card End -->
        </div>
        <!-- col-lg-8 End -->

        <div class="col-lg-4 grid-margin add-new-sidebar">
            <!-- Publish Start -->
            <div class="card-group publish" id="accordion">
                <div class="card">
                    <div class="card-heading">
                        <a data-toggle="collapse" data-parent="#accordion" href="#menu<?php ?>"> 
                            <label for="">Publish</label>
                        </a>
                    </div>
                    <div id="menu" class="card-collapse collapsed in">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Publish</label>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-inverse-danger btn-sm" type="submit" name="trash">Move to Trash</button>
                            <button class="btn btn-primary btn-sm float-right" type="submit" name="addpost">Publish Now</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Publish End -->
            
            <!-- Categories Start -->
            <div class="card-group categories" id="accordion">
                <div class="card">
                    <div class="card-heading">
                        <a data-toggle="collapse" data-parent="#accordion" href="#menu<?php ?>"> 
                            <label for="">Categories</label>
                        </a>
                    </div>
                    <div id="menu" class="card-collapse collapsed in">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">*Select category / categories</label>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <?php  
                                                $stmt = dbtable_order('*', 'nav_items', 'id desc'); 
                                                foreach ($stmt as $row) { 
                                                    if ($row>0) {
                                                        echo '  <tr><td> <input name="checkbox[]" type="checkbox" value=" ' . $row['post_key'] . ' "/> </td><td> ' . $row['name'] . '</td></tr>';
                                                    } 
                                                    else {
                                                        echo '<tr><td colspan="2"> No category added yet!</td></tr>';
                                                    }
                                                } 
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Categories End -->

            <!-- Image Start -->
            <div class="card-group excerpt" id="accordion">
                <div class="card">
                    <div class="card-heading">
                        <a data-toggle="collapse" data-parent="#accordion" href="#tags<?php ?>"> 
                            <label for="">Featured Image <span style=""> <i class="ti-plus"></i> </span> </label>
                        </a>
                    </div>
                    <div id="tags" class="card-collapse collapsed in">
                        <div class="card-body">
                            <div class="form-group">
                                <a data-toggle="modal" href="#imageupload"><i class="ti-image"></i> Choose featured image</a>
                                <?php include('includes/modal.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Image End -->
        </div>
        <!-- Col-lg-4 End -->
        </form>
    </div>
    <!-- row End -->
</div>
<!-- content-wrapper ends -->

<?php include('includes/footer_content.php'); ?>


