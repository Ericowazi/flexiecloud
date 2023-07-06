<?php include 'functions.php'; get_header(); navbar(); ?>

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Blog</h2>
                <ol>
                    <li><a href="index.html">Home</a></li>
                    <li>Blog</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Blog Section ======= -->
    <section id="blog" class="blog">
        <div class="container">

            <div class="row">
                <?php  
                    $stmt = dbtable_wo('*', 'posts', 'post_status', 0, 'id desc');
                    foreach ($stmt as $row) {
                        //Get post author
                        $user = dbtable_w('*','users', 'id', $row['post_author']);
                        $author = $user->fetch(); 
                ?> 

                <div class="col-lg-4  col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                    <article class="entry">

                        <div class="entry-img">
                            <?php $img = (!empty($row['image_file'])) ? "../../admin/uploads/" . $row['image_file'] : "../../admin/uploads/default.jpg"; ?>
                            <img style="height: 260px;" src="<?php echo $img; ?>" alt="post image" class="img-fluid">
                        </div>

                        <h2 class="entry-title">
                            <a href="blog-single.php?id=<?php echo $row['id']; ?>"> <?php echo htmlentities($row['post_title']); ?> </a>
                        </h2>

                        <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center"><i class="icofont-user"></i> <a href="blog-single.php?id=<?php echo $row['id']; ?>"><?php echo $author['username']; ?></a></li>
                                <li class="d-flex align-items-center"><i class="icofont-wall-clock"></i> <a href="blog-single.php?id=<?php echo $row['id']; ?>"><time datetime="2020-01-01"><?php echo date('j F, Y', strtotime($row['post_date'])); ?></time></a></li>
                            </ul>
                        </div>

                        <div class="entry-content">
                            <p><?php echo html_entity_decode(str_limit($row['post_content'], 200)); ?></p>
                            <div class="read-more">
                            <a href="blog-single.php?id=<?php echo $row['id']; ?>">Read More</a>
                            </div>
                        </div>

                    </article><!-- End blog entry -->
                </div>
            <?php } //end foreach ?> 

            </div>

            <div class="blog-pagination" data-aos="fade-up">
                <ul class="justify-content-center">
                    <li class="disabled"><i class="icofont-rounded-left"></i></li>
                    <li><a href="#">1</a></li>
                    <li class="active"><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#"><i class="icofont-rounded-right"></i></a></li>
                </ul>
            </div>

        </div>
    </section><!-- End Blog Section -->

  </main><!-- End #main -->

<?php footer_content(); footer_files(); ?>