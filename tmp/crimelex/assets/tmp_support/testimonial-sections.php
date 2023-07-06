<?php 
include "../../includes/general.php";?>

<!-- ======= Testimonials Section ======= -->
<section id="testimonials" class="testimonials section-bg">
    <div class="container">
        
        <div class="section-title" data-aos="fade-left">
            <h2>News Update</h2>
        </div>

        <div class="row">
            <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
                <div class="owl-carousel testimonials-carousel"><?php 
                
                    $stmt = dbtable_condition('*', 'posts',' WHERE post_status=0 ORDER BY id desc LIMIT ' . 3);
                    foreach ($stmt as $row) {
                    //Get post author
                    $user = dbtable_w('*','users', 'id', $row['post_author']);
                    $author = $user->fetch(); 

                    ?> <div class="testimonial-item">
                        <p>
                            <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                            <?= html_entity_decode(str_limit($row['post_content'], 200)); ?>
                        </p>

                        <?php $img = (!empty($row['image_file'])) ? "../../admin/uploads/" . $row['image_file'] : "../../admin/uploads/default.jpg"; ?>
                        <img src="<?= $img; ?>" class="testimonial-img" alt="">
                        
                        <h3><?= htmlspecialchars_decode(str_limit($row['post_content'], 70)); ?> ...</h3>

                        <h4>
                            <?php echo $author['username']; ?>
                            <time datetime="2020-01-01"><?php echo date('j F, Y', strtotime($row['post_date'])); ?></time>
                        </h4>
                    </div>

                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
</section><!-- End Testimonials Section -->

