<?php include('../includes/session.php'); ?>
<?php include('includes/navbar.php'); ?>
<!-- partial -->
<div class="content-wrapper">
    <?php $id = $_GET['post']; $table = dbtable_w('*', 'posts','id',$id); $data = $table->fetch(); ?> 
    <form action="post_crud.php?updatepost=<?= $data['id']; ?>" method="post" enctype="multipart/form-data">

    <div class="row add-post">
        <div class="add-new" style="margin-bottom:15px; margin-left: 10px;">
            <a class="back" href="posts-published.php?page=1"><i class="ti-arrow-left"></i>&nbsp;back</a>
        </div>

        <div class="col-lg-12 stretch-card">
            <div class="add-new-title">
                <label for="add-new-post">Edit Post</label>
            </div>
        </div>

        <div class="col-lg-8 grid-margin stretch-card">
            <div class="post-card">
                <?php alert_message(); ?>
                <div class="post-body">
                    <!-- Title Start -->
                    <div class="form-group">
                        <input type="text" class="form-control title" id="title" name="title" placeholder="Enter title here" required value="<?= $data['post_title']; ?>">
                    </div>
                    <!-- Body content Start -->
                    <div class="form-group">
                        <textarea class="form-control" name="content" id="editor1" cols="30" rows="30" placeholder="Enter content here"><?= $data['post_content']; ?></textarea>
                    </div>
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
                                        <textarea class="form-control" name="excerpt" id="excerpt" cols="30" rows="5" placeholder="Enter excerpt here"><?= $data['post_excerpt']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Excerpt End -->

                    <!-- Tags Start -->
                    <div class="card-group excerpt" id="accordion">
                        <div class="card">
                            <div class="card-heading">
                                <a data-toggle="collapse" data-parent="#accordion" href="#tags<?php ?>"> 
                                    <label for="">Tags <span style=""> <i class="ti-plus"></i> </span> </label>
                                </a>
                            </div>
                            <div id="tags" class="card-collapse collapse in">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="excerpt">Tags (Optional)</label>
                                        <br>
                                        <label class="cat-label" for="name"><i class="ti-arrow-right"></i> 
                                            Enter tags below<code>essention for SEO</code> separate tags with comma (,)
                                        </label>
                                        <textarea class="form-control" name="tags" id="tags" cols="30" rows="5" placeholder="Enter tags here - separate with a comma (,)"><?= $data['post_meta']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tags End -->
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
                            <button class="btn btn-outline-danger btn-sm trash" type="submit" name="updatetrash">Move to Trash</button>
                            <button class="btn btn-primary btn-sm float-right" type="submit" name="updatepost">Update Now</button>
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
                                                $stmt = dbtable_order('*', 'categories', 'id desc'); $no = 0;
                                                $post_cat = explode(",", $data['post_cat']);
                                                foreach ($stmt as $row) { $no++;
                                                    if ($row>0) { ?>
                                                        
                                                        <tr>    
                                                            <td> <input <?php foreach ($post_cat as $key=>$value) { $cate = trim($value); if ($row['cat_key']==$cate) { echo 'checked'; } } ?> name="checkbox[]" type="checkbox" value=" <?= $row['cat_key']; ?> "/> </td>  
                                                            <td> <?= $row['name'] ?></td>
                                                        </tr>

                                                    <?php }
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
                                <!-- <i class="ti-image"></i> <a href="#selectimage">Upload featured image</a> -->
                                <?php
                                    $picture = dbtable_w('*', 'posts', 'id', $id); $data = $picture->fetch();
                                    if ($data['image_file']) {
                                        echo '
                                            <img src="uploads/' . $data['image_file'] . '" alt="post-image" style="height: 130px; width: 100%; margin-bottom: 20px">
                                            <a data-toggle="modal" href="#imageupload"><i class="ti-image"></i> Change featured image</a>
                                        ';
                                        include('includes/modal.php');
                                    } 
                                    elseif (empty($data['image_file'])) {
                                        echo '
                                            <a data-toggle="modal" href="#imageupload"><i class="ti-image"></i> Choose featured image</a>
                                        ';
                                        include('includes/modal.php');
                                    } ?>
                                
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


