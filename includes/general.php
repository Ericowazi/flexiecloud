<?php 

    // ===================================================================================
    // @EN
    // GENERAL FUNCTIONS
    //
    // 

    // Page Redirect_to function
    if ( ! function_exists('redirect_to')) {
        function redirect_to($location) { header('location: ' . $location); exit; }
    }
    
    // Success && error message function
    if ( ! function_exists('alert_message')) {
        function alert_message(){
            if(isset($_SESSION['success'])){ 
                echo '
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <span><i class="ti-check"></i>Success</span>
                        <p>'.$_SESSION['success'].'</p>
                    </div>
                ';  

                unset($_SESSION['success']); 
            } 
            elseif(isset($_SESSION['error'])){
                echo '
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <span><i class="ti-alert"></i>Error</span>
                        <p>'.$_SESSION['error'].'</p>
                    </div>
                ';  
                
                unset($_SESSION['error']); 
            } 
        }
    } 

    // Datetime function
    if ( ! function_exists('datetime')) {
        function datetime() { 
            date_default_timezone_set('Africa/Nairobi');
            $current_time = time();
            $datetime = date('Y-m-d H:i:s', $current_time);

            return $datetime;
        }
    }

    //Function to upload photos
    // *Not in use for now*
    // *If file name empty on edit post page, previously uploaded filename doesnt remain the same 
    // *..instead an empty string is sent to dB as in first condition
    if ( ! function_exists('photo_upload')) {
        function photo_upload($file){ 

            $picture = dbtable_w('*', 'posts', 'id', $id); $data = $picture->fetch();
             
            if ( empty($file) && empty($data['image_file'])) : $filename = '';
            elseif (empty($file) && ! empty($data['image_file'])) : $filename = $data['image_file'];
            else :
                $file_name  = strtolower($file);
                $file_ext = substr($file_name, strrpos($file_name, '.'));
                $prefix = 'neo_'.md5(time()*rand(1, 9999));
                $filename = $prefix.$file_ext; 
                move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$filename); 
            endif; 

            return $filename;
        }
    }

    // ===================================================================================
    //
    // USER FUNCTIONS
    //
    //====================================================================================
    
    // Check if user in session
    if ( ! function_exists('login')) {
        function login() { 
            if (isset($_SESSION['admin'])) { return true; } 
        }
    }

    // Direct to Login or other page if user not logged in
    if ( ! function_exists('confirm_login')) {
        function confirm_login($location) { 
            if ( ! login()) { 
                $_SESSION['error'] = 'Login required to proceed'; header('location: ' . $location); exit;
            } 
        }
    }

    // User redirect_to function
    if ( ! function_exists('user_redirect')) {
        function user_redirect($location) { 
            if (isset($_SESSION['admin'])) { header('location: ' . $location); exit; } 
        }
    }

    // ===================================================================================
    //
    // SQL TABLES FUNCTIONS
    //
    //====================================================================================

    // Find user function
    if ( ! function_exists('find_user')) {
        function find_user(){
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE id=:id");
            $stmt->execute(['id'=>$_SESSION['admin']]);
            return $stmt;

            $pdo->close();
        }
    }

    // All data from a table function
    if ( ! function_exists('dbtable')) {
        function dbtable($type, $table) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table");
            $stmt->execute();
            return $stmt;

            $pdo->close();
        }
    }

    // All data from a table with order condtion function
    if ( ! function_exists('dbtable_order')) {
        function dbtable_order($type, $table, $order) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table ORDER BY $order");
            $stmt->execute();
            return $stmt;

            $pdo->close();
        }
    }

    // Select data from a table with condition
    if ( ! function_exists('dbtable_condition_match')) {
        function dbtable_condition_match($type, $table, $condition, $match) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table $condition");
            $stmt->execute([$match]);
            return $stmt;

            $pdo->close();
        } 
    }

    // Select data from a table with condition
    if ( ! function_exists('dbtable_condition')) {
        function dbtable_condition($type, $table, $condition) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table $condition");
            $stmt->execute();
            return $stmt;

            $pdo->close();
        }
    }

    // All data from a table with a WHERE condtion function
    if ( ! function_exists('dbtable_w')) {
        function dbtable_w($type, $table, $column, $match) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table WHERE $column=:match");
            $stmt->execute(['match'=>$match]);
            return $stmt;

            $pdo->close();
        }
    }

    // All data from a table with a WHERE condtion LIKE function
    if ( ! function_exists('dbtable_w_like')) {
        function dbtable_w_like($type, $table, $column, $key, $condition) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table WHERE $column  LIKE '%$key%' $condition");
            $stmt->execute();
            return $stmt;

            $pdo->close();
        }
    }

    // All data from a table with a WHERE condtion function
    if ( ! function_exists('dbtable_wo')) {
        function dbtable_wo($type, $table, $column, $match, $order) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table WHERE $column=:match ORDER BY $order");
            $stmt->execute(['match'=>$match]);
            return $stmt;

            $pdo->close();
        }
    }

    // All data from a table with a WHERE condtion function
    if ( ! function_exists('dbtable_wo_L1')) {
        function dbtable_wo_L1($type, $table, $column, $match, $order, $L1) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table WHERE $column=:match ORDER BY $order LIMIT $L1");
            $stmt->execute(['match'=>$match]);
            return $stmt;

            $pdo->close(); 
        }
    }

    // All data from a table with a WHERE condtion function
    if ( ! function_exists('dbtable_wo_L1L2')) {
        function dbtable_wo_L1L2($type, $table, $column, $match, $order, $L1, $L2) { 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT $type FROM $table WHERE $column=:match ORDER BY $order LIMIT $L1,$L2");
            $stmt->execute(['match'=>$match]);
            return $stmt;

            $pdo->close();
        }
    }

    //Count / Give total
    if ( ! function_exists('count_total')) {
        function count_total($type, $table){ 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT COUNT($type) FROM $table");
            $stmt->execute();
            $table_rows = $stmt->fetch();
            $get_total = array_shift($table_rows); 
            
            return $get_total;
            $pdo->close();  
        }
    }

    // Count data from a table with condition
    if ( ! function_exists('count_total_condition')) {
        function count_total_condition($type, $table, $condition) { 
            global $pdo; $conn = $pdo->open(); 

            $stmt = $conn->prepare("SELECT COUNT($type) FROM $table $condition");
            $stmt->execute();
            $table_rows = $stmt->fetch();
            $get_total = array_shift($table_rows); 
            
            return $get_total;
            $pdo->close();  
        }
    }

    // Count data from a table with where condition
    if ( ! function_exists('count_total_wcondition')) {
        function count_total_wcondition($type, $table, $where, $condition) { 
            global $pdo; $conn = $pdo->open(); 

            $stmt = $conn->prepare("SELECT COUNT($type) FROM $table WHERE $condition");
            $stmt->execute($where);
            $table_rows = $stmt->fetch();
            $get_total = array_shift($table_rows); 
            
            return $get_total;
            $pdo->close();  
        }
    }

    //Count / Give total
    if ( ! function_exists('count_total_w')) {
        function count_total_w($type, $table, $column, $match){ 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT COUNT($type) FROM $table WHERE $column=:match");
            $stmt->execute(['match'=>$match]);
            $table_rows = $stmt->fetch();
            $get_total = array_shift($table_rows); 
            
            return $get_total;
            $pdo->close();  
        }
    }

    //Count / Give total like
    if ( ! function_exists('count_total_like_order')) {
        function count_total_like_order($type, $table, $key, $column1, $column2, $match, $order){ 
            global $pdo; $conn = $pdo->open();

            $stmt = $conn->prepare("SELECT COUNT($type) FROM $table WHERE $column1 LIKE '%$key%' AND $column2=:match ORDER BY $order"); 
            $stmt->execute(['match'=>$match]);
            $table_rows = $stmt->fetch();
            $get_total = array_shift($table_rows); 
            
            return $get_total;
            $pdo->close();  
        }
    }

    // ========= HTML CONTENT FUNCTIONS ======================================  




    // =================================================
    //
    // CATEGORIES SECTION
    // 
    

    // Get categories page header add-on
    // Top most header info here
    if (! function_exists('get_categories_page_addon')){
        function get_categories_page_addon($crud){ 
            ?><div class="manage-user-header-4">
                <div class="div-title"> 
                    <h4 class="card-title"><?php

                    switch ($crud) { case 450: echo 'Categories'; break; default: echo 'Categories'; break; }
                    
                    ?></h4> 
                    
                </div><?php 
                alert_message(); 
            ?></div><?php
        }
    } // End get_categories_page_addon()
    

    // categories header
    // categories navigation
    if ( ! function_exists('get_categories_header')) {
        function get_categories_header($page){ ?>
            
            <!-- Form 1 start haha -->
            <form action="category_crud.php" method="post" enctype="multipart/form-data">

            <div class="cat-crud">
                <div class="dropdown"> 
                    <button type="button" class="btn btn-outline-dark btn-sm btn-crud dropdown-toggle" id="dropdownMenuIconButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton4"> <?php 

                        if ($page == 450) :
                            echo '<button type="submit" class="dropdown-item" name="multidelete'. $page .'">Delete</button>';
                        else :
                            echo '<button type="submit" class="dropdown-item" disabled="disabled">No crud</button>';
                        endif; 
                        
                    ?></div>
                    <a class="btn btn-primary add-btn btn-sm" href="category-add.php"><i class="fa fa-plus"></i> Add Category</a>
                </div><!-- End dropdown -->
            </div><!-- End cat-crud --> <?php

        }
    } // End get_categories_header()


    // categorycol-box---Users-col-box
    // Most of HTML for categories-page and content here
    if ( ! function_exists('get_categories')) {
        function get_categories($type, $table, $order, $l1, $l2, $page){ 

            $stmt = dbtable_condition($type, $table, ' ORDER BY '. $order .' LIMIT '. $l1 .','. $l2 .'');
            
            ?><div class="col-lg-12 grid-margin stretch-card user-col-box ">
                <div class="card category-card">
                    <!-- General category section -->
                    <div class="card-body category-col-box-1">
                        <div class="table-responsive table-hover col-pages-box"><?php 
                    
                            $totalstmt = count_total_condition($type, $table, ' ORDER BY '. $order .'');
                            if ($totalstmt > 0) : 
                            ?><table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th> <input type="checkbox" name="select-all" id="select-all" value=""> </th>
                                        <th> Name </th>
                                        <th class="pyy"> Description </th>
                                        <th class="pyy"> Slug </th>
                                        <th class="pyy"> Posts </th>
                                    </tr>
                                </thead>
                                <tbody><?php

                                    foreach ($stmt as $row) : 
                                        
                                    // description && slug 
                                    $description = (empty($row['description'])) ? '---' : $row['description'];
                                    $slug = (empty($row['slug'])) ? '---' : $row['slug'];

                                    // Get no. of posts for each category if any
                                    $keyword = trim($row['cat_key']); $rowkey = "'%$keyword%'";
                                    $totalposts = count_total_condition($type, 'posts', ' WHERE post_cat LIKE '. $rowkey .'');

                                    ?><tr>
                                        <td><input class="input" type="checkbox" name="checkbox[]" id="" value="<?= $row['id']; ?>"></td>
                                        
                                        </form> <!-- End form 1 -->

                                        <td class="py-1"> <label><?= $row['name']; ?> </label>
                                            <div class="crud">
                                                <!-- Form 2 start haha -->
                                                <form action="category_crud.php?category=<?= $row['id']; ?>" method="post" enctype="multipart/form-data"> <!-- This form is for delete only -- Thats the only one using 'id' -->

                                                    <!-- Crud buttons -->
                                                    <?php if ($page == 450) : // Categories all ?> 
                                                    <a href="category-edit.php?category=<?= $row['cat_key']; ?>" class="btn btn-sm btn-outline-primary btn-a">Edit</a>
                                                    <button type="submit" name="delete<?= $page; ?>" class="btn btn-sm btn-outline-danger">Delete</button>  
                                                    <a href="category-view.php?category=<?= $row['cat_key']; ?>" class="btn btn-sm btn-primary btn-a">View</a>
                                                    <button disabled="disabled">></button> 

                                                    <?php else : // Default ?> 
                                                    <button type="button"  class="btn btn-sm btn-outline-light">No Crud</button>
                                                    <button disabled="disabled">></button> 
                                                    <?php endif; ?>
                                                </form><!-- End form 2 -->
                                                
                                            </div><!-- End crud -->
                                        </td>

                                        <td class="pyy py-2"><?= $description; ?></td>

                                        <td class="pyy py-2"><?= $slug; ?></td>

                                        <td class="pyy-4 py-2"><?= $totalposts; ?></td>
                                        
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table><?php
                            else : echo '<div class="col-page-box-else"> <p>Oooops! No categories found!</p> </div>'; endif;

                        ?></div>
                    </div> <!-- End General category section -->
                </div>
            </div><!-- End user-col-box --> <?php

        }
    } // End get_categories()


    // Get categories page with...
    //--> Pagination here -- categories Header / categories-page
    // Body(users-box) and function variables
    if ( ! function_exists('get_categories_page')) {
        function get_categories_page($type, $table, $array, $keyword, $order, $crud, $msg1, $redirect, $msg2){ ?>

            <!-- partial -->
            <div class="content-wrapper">
                <div class="row col-pages">
                    <div class="col-lg-12 grid-margin stretch-card users-pages">
                        <div class="card"> <?php

                            // page must be set
                            if (isset($_GET['page'])) : 
                                $page = $_GET['page']; 
                                if(empty($page) || $page < 1): $page = 1; endif; //<-- set default page to 1 if no page is set, to avoid errors
        
                                $totalstmt = count_total_condition($type, $table, ' ORDER BY '. $order .''); 
                                if ($page==0 || $page<1) : $page_count = 0; 
                                else : $postNo = page_item_number($type, $table, $array); $page_count = ($page*$postNo)-$postNo; endif; 
                                
                                include 'includes/modal.php';
                                ?><div class="card-body"><?php
                                
                                    get_categories_page_addon($crud);
                                    get_categories_header($crud); 
                                    get_categories($type, $table, $order, $page_count, $postNo, $crud);  
                                    
                                    //Only show pagination when the number of pages exceeds one e.g 2,3
                                    if($totalstmt > $postNo): pagination($page, $type,  $table, $array, $postNo); endif;   
                                    
                                ?></div> <!-- card-body End --> <?php 
                            else : on_page_errors($msg1, $redirect, $msg2); endif; ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends --> <?php

        }
    } // End get_categories_page()

    
    // Pages for ADD(CREATE) - EDIT - VIEW CATEGORY PAGES (CRU)
    // All in one function
    if ( ! function_exists('get_categories_cru_page')) {
        function get_categories_cru_page($type, $table, $array, $order, $page){

            if ($page !== 451) : 
            $stmt = dbtable_condition($type, $table, ' WHERE '. $array .''); $row = $stmt->fetch();
            
            // Get parent category of a category ($page==452 && 453)
            if (!empty($row['parent_cat'])) : $parentkey = $row['parent_cat'];
            $parentstmt = dbtable_condition($type, $table, ' WHERE id='. $parentkey .''); $parentrow = $parentstmt->fetch(); endif; 
            endif;
            
            ?> <!-- partial -->
            <div class="content-wrapper">
                <div class="row addedit-category">
                    <?= back_button('category-all.php?page=1', 'go back'); ?>
                    <div class="col-lg-7 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                
                                <h4 class="card-title"><?php
                                    switch ($page) { 
                                        case 451: echo 'Add Category'; break; 
                                        case 452: echo 'Edit Category'; break; 
                                        case 453: echo 'View Category'; break; 
                                        default: echo 'Category'; break;
                                    }
                                ?></h4>
                                <?php alert_message(); ?>
                                <div class="addedit-responsive"><?php 
                                
                                    // Add-category-page(451) does not need the extention for cat_key unlike edit-category-page(452)
                                    if($page == 451) : $form = 'category_crud.php'; else : $form = 'category_crud.php?category='. $row['cat_key'] .''; endif; 
                                    
                                    ?><form action="<?= $form; ?>" method="post" enctype="multipart/form-data"> 
                                    <!-- This form uses cat_key to get category and in crud too -->

                                        <!-- Category Name -->
                                        <div class="form-group">
                                            <label for="name">Category Name<code>*</code></label>
                                            <input type="text" 
                                                <?= ($page == 453) ? 'disabled="disabled"' : ''; // Only View Category page ?>
                                                class="form-control form-control-sm" name="catname" 
                                                value="<?= ($page !== 451) ? $row['name'] : ''; // Except add category page ?>" 
                                                placeholder="Enter category name" required>
                                        </div>
            
                                        <!-- Category Slug -->
                                        <div class="form-group">
                                            <label for="name">Slug</label><br>
                                            <p class="cat-p"><i class="fa fa-chevron-circle-right"></i> 
                                            <code>'Slug'</code> is the url friendly version of the category name. Should contain only letters, numbers and hyphens, and must be all lowercase
                                            </p>
                                            <input type="text"
                                                <?= ($page == 453) ? 'disabled="disabled"' : ''; // Only View-Category-page ?>
                                                class="form-control form-control-sm" name="catslug" 
                                                value="<?php 
                                                if ($page !== 451) :
                                                    if ($page == 453) :
                                                        echo (!empty($row['slug'])) ? $row['slug'] : 'No slug. Edit category to add slug';
                                                    else : echo $row['slug']; endif; 
                                                endif; // Except add category page ?>" 
                                                placeholder="eg enter-category-slug">
                                        </div>
            
                                        <!-- Parent Category -->
                                        <div class="form-group">
                                            <label for="name">Parent Category</label>
                                            <div class="">
            
                                                <!-- Select Category -->
                                                <select 
                                                    <?= ($page == 453) ? 'disabled="disabled"' : ''; // Only View Category page ?>
                                                    class="form-control form-control-sm" name="parentcat"><?php 
            
                                                    // Show already selected parent category if any
                                                    // This will be confusing but pay attention
                                                    if ($page == 451) : echo '<option value="0">Select</option>'; 
                                                        else : // Except add page
                                                        if ($page == 452) : // Edit page
                                                            echo (!empty($row['parent_cat'])) 
                                                            ? '<option selected="selected" value="'. $parentrow['id'] .'">'. $parentrow['name'] .'</option>
                                                            <option value="0">Select</option>' 
                                                            : '<option value="0">Select</option>'; 
                                                        else : 
                                                        if ($page == 453) :  // View page
                                                            echo (!empty($row['parent_cat'])) 
                                                            ? '<option value="'. $parentrow['id'] .'">'. $parentrow['name'] .'</option>' 
                                                            : '<option value="0">No parent category</option>'; 
                                                        endif; 
                                                        endif;
                                                    endif;
            
                                                    // All categories && Get total categories
                                                    $catstmt = dbtable_condition($type, $table, ' ORDER BY '. $order .'');
                                                    $totalstmt = count_total_condition($type, $table, ' ORDER BY '. $order .'');
                                                    if ($totalstmt > 0) : 
                                                        foreach ($catstmt as $option) {
                                                            echo '<option value="'. $option['id'] .'">'. $option['name'] .'</option>'; 
                                                        } 
                                                    else : echo '<option value="0" disabled="disabled">No Category</option>'; endif;
                                                ?></select>
                                            </div>
                                        </div>
            
                                        <!-- Category Description -->
                                        <div class="form-group">
                                            <label for="name">Description</label><br>
                                            <p class="cat-p"><i class="fa fa-chevron-circle-right"></i> 
                                                Max length 160 characters
                                            </p>
                                            <textarea 
                                                <?= ($page == 453) ? 'disabled="disabled"' : ''; // Only View Category page ?>
                                                class="form-control" name="description" id="description" 
                                                placeholder="Enter Description here" cols="30" rows="5"><?php 
                                                if ($page !== 451) :  
                                                    if (!empty($row['description'])) : echo $row['description'];
                                                    else : echo ($page == 453) ? 'No description. Edit category to add description' : ''; endif;
                                                endif; // Except add category page ?></textarea>
                                        </div>
                                        
                                        <!-- Buttons -->
                                        <?php if($page !== 453) : // Except view category page ?>
                                        <div class="form-group form-group-crud">
                                            <a class="btn btn-outline-dark" href="category-all.php?page=1">Cancel</a>
                                            <?= ($page == 451) ? 
                                            '<button style="margin-right: 20px;" class="btn btn-primary" type="submit" name="addcategory'. $page .'">Submit</button>' 
                                            : '<button style="margin-right: 20px;" class="btn btn-primary" type="submit" name="update'. $page .'">Update</button>'; 
                                        ?></div>
                                        <?php endif; ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 grid-margin stretch-card addedit-sidebar">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Recently Added</h4>
            
                                <div class="table-responsive"><?php 
                                    $allstmt = dbtable_condition($type, $table, ' ORDER BY '. $order .' LIMIT '. 10 .'');  
                                    $totalstmt = count_total_condition($type, $table, ' ORDER BY '. $order .''); 
            
                                    if ($totalstmt > 0) : $no = 0;
                                    ?><table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><i class="fa fa-sort"></i></th>
                                                <th>Category Name</th>
                                            </tr>
                                        </thead>
                                        <tbody><?php //sidebar_categories('id desc', 10); 
                                            foreach ($allstmt as $sidecat){ $no++;
                                                echo '
                                                <tr>
                                                    <td>'. $no .'.</td>
                                                    <td class="td-last">'. $sidecat['name'] .'</td>
                                                </tr>';
                                            }
                                        ?></tbody>
                                    </table><?php
                                    else : echo '<div class="col-page-box-else"> <p>Oooops! No categories available!</p> </div>'; endif;
                                ?></div>
            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends --> <?php
        }
    } // End get_categories_cru_page()


    // categories page function for individual pages
    // categories Values for db and other functions can be changed from here
    // To-avoid-wasting-more-of-your-time-,-kindly-do-not-delete-any-thing-here---Gracias
    if ( ! function_exists('categories_page')) {
        function categories_page($page, $keyword){ 
            switch ($page) {
                case 450: 
                    get_categories_page( // All categories
                        '*', 'categories', 'id>0', $keyword, 'id desc', 450,
                        'Categories page not found', 'category-all', 'Return to categories'
                    ); break;
                case 451: // Add category
                    $key = "'%$keyword%'"; $catkey = trim($key);
                    get_categories_cru_page(
                        '*', 'categories', 'cat_key LIKE '. $catkey .'', 'id desc', 451
                    ); break;
                case 452: // Edit category
                    $key = "'%$keyword%'"; $catkey = trim($key);
                    get_categories_cru_page(
                        '*', 'categories', 'cat_key LIKE '. $catkey .'', 'id desc', 452
                    ); break;
                case 453: // View category
                    $key = "'%$keyword%'"; $catkey = trim($key);
                    get_categories_cru_page(
                        '*', 'categories', 'cat_key LIKE '. $catkey .'', 'id desc', 453
                    ); break;

                default: on_page_errors('Categories page not found', 'category-all', 'Return to categories'); break;
            }
        }
    } // End categories_page()


    // ================================================= 
    // POSTS SECTION

    //Posts header
    if ( ! function_exists('get_posts_header')) {
        function get_posts_header($page, $post_key, $type, $table, $column, $match1, $match2, $match3){

            //Check total count for post/s 
            $total = count_total($type, $table); 
            $tposts = count_total_w($type, $table, $column, $match1); 
            $draft = count_total_w($type, $table, $column, $match2);
            $trash = count_total_w($type, $table, $column, $match3);?>

            <!-- Form 1 -- for bulk actions -- Be careful with the forms haha -->
            <form action="posts_crud.php" method="POST"> 
            <div class="col-pages-header" <?= $style = ($page == 450) ? 'style="margin-top: 30px"' : 'style="margin-top: 20px"' ; ?>style="">
                <div class="label">
                    
                    <label class="colheader" for="">
                        <span class="all">All (<?= $total; ?>)</span>&nbsp;|&nbsp;
                        <a class="<?= active_class(['posts-published.php']); ?>" 
                            href="posts-published.php?page=1">Published (<?= $tposts; ?>)
                        </a>&nbsp;|&nbsp;
                        <a class="<?= active_class(['posts-draft.php']); ?>" 
                            href="posts-draft.php?page=1">Draft (<?= $draft; ?>)
                        </a>&nbsp;|&nbsp;
                        <a class="<?= active_class(['posts-trash.php']); ?>" 
                            href="posts-trash.php?page=1">Trash (<?= $trash; ?>)
                        </a>
                    </label>
                    
                </div> <!-- End label -->
                <div class="upper-crud">
                    <div class="dropdown"> 
                        <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle filter-button" id="dropdownMenuIconButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Bulk Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton4"> <?php 

                            if ($page == 450 || $page == 453) :
                                echo '<button class="dropdown-item" type="submit" name="pmultidraft">Draft</button>
                                <button class="dropdown-item" type="submit" name="pmultitrash">Trash</button>';
                            elseif ($page == 451 || $page == 454) :
                                echo '<button class="dropdown-item" type="submit" name="dmultipublish">Publish</button>
                                <button class="dropdown-item" type="submit" name="dmultitrash">Trash</button>';
                            elseif ($page == 452 || $page == 455) :
                                echo '<button class="dropdown-item" type="submit" name="tmultipublish">Publish</button>
                                <button class="dropdown-item" type="submit" name="tmultidraft">Draft</button>
                                <a class="dropdown-item" data-toggle="modal" data-id="" href="#ptmultidelete">Delete</a>';
                            endif; 
                            
                        ?></div>
                    </div>
                    <div class="dropdown drop-2"> 
                        <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle filter-button" id="dropdownMenuIconButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Filter/Category </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton4"> <?php 
                            $table = dbtable('*', 'categories'); // get categories 
                            foreach ($table as $value) { 

                            if ($page == 450 || $page == 453) :
                                echo '<a class="dropdown-item" href="posts-published-filter.php?category=' . $value['cat_key'] . '">' . $value['name'] . '</a>';
                            elseif ($page == 451 || $page == 454) :
                                echo '<a class="dropdown-item" href="posts-draft-filter.php?category=' . $value['cat_key'] . '">' . $value['name'] . '</a>';
                            elseif ($page == 452 || $page == 455) :
                                echo '<a class="dropdown-item" href="posts-trash-filter.php?category=' . $value['cat_key'] . '">' . $value['name'] . '</a>';
                            endif; 
                            
                            } 
                            
                        ?></div>
                    </div> 
                    <?php include 'includes/modal.php'; ?>
                </div>
            </div> <?php
        }
    }

    // Posts Box
    // Most of:: HTML for posts box and content here
    if ( ! function_exists('get_posts')) {
        function get_posts($type, $table, $array, $order, $l1, $l2, $column, $match, $post_key, $page, $comsection){
 
            // Posts-pages && post-pages-filter respectively
            $postkey = "'%$post_key%'"; // For using category key to get posts
            ($page == 450 || $page == 451 || $page == 452) ? $stmt = dbtable_condition($type, $table, 'WHERE '. $array .' ORDER BY '. $order .' LIMIT '. $l1 .','. $l2 .'') : $stmt = dbtable_condition($type, $table, ' WHERE post_cat LIKE '. $postkey .' AND '. $column .'='. $match .' ORDER BY '. $order .'');  ?> 

            <div class="col-pages-box">
            <h4><i class="fa fa-newspaper-o"></i>&nbsp;<span <?php

            // Different color for different pages
            if     ($page == 450 || $page == 453) : echo 'style="color: #57B657;"';
            elseif ($page == 451 || $page == 454) : echo 'style="color: #248AFD;"';
            elseif ($page == 452 || $page == 455) : echo 'style="color: #FF4747;"'; endif;

            ?>><?= $comsection; ?></span></h4> <?php
            
            // Posts-pages && post-pages-filter respectively
            ($page == 450 || $page == 451 || $page == 452) ? $tposts = count_total_condition($type, $table, 'WHERE '. $array .'') : $tposts = count_total_like_order($type, 'posts', $post_key, 'post_cat', $column, $match, $order); 

            if ($tposts > 0) : ?>
            <input type="checkbox" name="select-all" id="select-all" value=""> Select All </p> <?php
                foreach ($stmt as $post) : 
                    //Get post author
                    $userdb = dbtable_condition('*','users', ' WHERE id='.$post['post_author'].''); $author = $userdb->fetch(); 
                    $img = (!empty($post['image_file'])) ? "uploads/" . $post['image_file'] : "uploads/post-default.jpg";
                    
                     ?>

                    <div class="col-page-box">
                        <!-- Input Checkbox -->
                        <div class="col-page-checkbox">
                            <input class="input" type="checkbox" name="checkbox[]" id="" value="<?= $post['id']; ?>">
                        </div> 
                        <!-- Image -->
                        <div class="col-page-pic"> 
                            <img src="<?= $img; ?>" class="post-pic" alt="post-picture" srcset=""> 
                        </div> 
                        </form><!-- End form 1 --> 
                        <div class="col-page-body">
                            <div class="col-page-content">
                                <!-- Post Title -->
                                <p class="post">
                                    <a target="_blank" href="../sailor/blog-single.php?id=<?= $post['id']; ?>">
                                        <?= htmlentities($post['post_title']); ?>
                                    </a>
                                </p>  

                                <!-- Author -->
                                <p class="author">
                                    <i class="fa fa-user"></i>&nbsp;<span class="name"><?= $author['username']; ?></span>&nbsp;&nbsp;On&nbsp;
                                    <!-- Date / Time -->
                                    <span class="time"><?= date('j M \'\ y \a\t\ g:i a', strtotime($post['post_date'])); ?></span>
                                </p> 

                                <!-- Categories -->
                                <p class="post-category"><i class="fa fa-tag"></i>&nbsp;<?php 
                                    if (empty($post['post_cat'])) : echo 'Uncategorised'; else :
                                        $pcategory = explode(",", $post['post_cat']);
                                        foreach ($pcategory as $key => $value) { $letcat = trim($value);
                                            $ctable = dbtable_w('*', 'categories', 'cat_key', $letcat); 
                                            $category = $ctable->fetch();
                                            if (!empty($category['name'])) : 
                                                // This eliminates errors in case a category is deleted
                                                echo '<span>'. $category['name'] .'</span>';  
                                            endif;
                                        } 
                                    endif;
                                ?></p>

                                <!-- Post Content -->
                                <p id="comment">
                                    <?= str_limit(htmlspecialchars_decode($post['post_content']), 200) . '...'; ?>
                                </p>
                                
                            </div>
                            <div class="crud">
                                <!-- Form 2 start haha -->
                                <form action="post_crud.php?singlepost=<?= $post['id']; ?>" method="POST" enctype="multipart/form-data">

                                    <!-- Crud buttons for different pages -->
                                    <?php if ($page == 450 || $page == 453) : //comments_unapproved ?> 
                                    <a href="post-edit.php?post=<?= $post['id']; ?>" class="btn btn-sm btn-primary btn-a">Edit</a>
                                    <button type="submit" name="psingledraft" class="btn btn-sm btn-info">Draft</button>
                                    <button type="submit" name="psingletrash" class="btn btn-sm btn-outline-danger"> Trash </button> 
                                    <button disabled="disabled">></button> 

                                    <?php elseif ($page == 451 || $page == 454) : //comments_draft ?>  
                                    <button type="submit" name="dsinglepublish" class="btn btn-sm btn-success">Publish</button>
                                    <a href="post-edit.php?post=<?= $post['id']; ?>" class="btn btn-sm btn-primary btn-a">Edit</a>
                                    <button type="submit" name="dsingletrash" class="btn btn-sm btn-outline-danger"> Trash </button> 
                                    <button disabled="disabled">></button> 

                                    <?php elseif ($page == 452 || $page == 455) : //comments_trash_can ?> 
                                    <button type="submit" name="tsinglepublish" class="btn btn-sm btn-outline-success">Publish</button>
                                    <button type="submit" name="tsingledraft" class="btn btn-sm btn-info">Draft</button> 
                                    <button type="submit" name="tsingledelete" class="btn btn-sm btn-danger">Delete</button> 
                                    <button disabled="disabled">></button> 
                                    <?php endif; ?>
                                </form><!-- End form 2 -->
                                
                            </div><!-- End crud -->
                        </div> <!-- End comment-body -->
                    </div><!-- End comment-box --> <?php
                endforeach; 
            else :  echo ' <div class="col-page-box-else"> <p>No available posts!</p> </div> '; endif; 
            echo ' </div><!-- End comments-box -->';
        }
    }

    //Get posts page with...
    //--> Pagination here -- Posts Header / 
    // Body(col-page-box) and function variables
    if ( ! function_exists('get_posts_page')) {
        function get_posts_page($type, $table, $column, $match, $match1, $match2, $match3, $array, $order, $post_key, $crud, $comsection, $msg1, $redirect, $msg2){ ?>

            <!-- partial -->
            <div class="content-wrapper">
                <div class="row col-pages all-post">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card post-card"> <?php

                            //page must be set
                            if (isset($_GET['page'])) : 
                                $page = $_GET['page']; 
                                if(empty($page) || $page < 1): $page = 1; endif;//<-- set default page to 1 if no page is set
        
                                $tposts = count_total_w($type, $table, $column, $match); 
                                if ($page==0 || $page<1) : $page_count = 0; 
                                else : $postNo = page_item_number($type, $table, $array); $page_count = ($page*$postNo)-$postNo; endif; ?>
        
                                <div class="card-body"><?php 

                                    switch ($crud) {
                                        case 450:
                                            echo '<h2 class=""><span>Posts </span>&nbsp;&nbsp;<a class="btn btn-primary btn-sm" href="post-add.php">Add New</a></h2>'; break;
                                        case 451:
                                            echo '<h2 class="" style="color: #248AFD;"><span>Draft</span> </h2>'; break;
                                        case 452:
                                            echo '<h2 class="" style="color: #FF4747;"><span>Trash</span> </h2>'; break;
                                        default: echo '<h2 class="" style="color: #248AFD;"><span>Posts</span> </h2>'; break;
                                    }
        
                                    alert_message(); get_posts_header($crud, $post_key, $type, $table, $column,  $match1, $match2, $match3); 
                                    get_posts($type, $table, $array, $order, $page_count, $postNo, $column, $match, $post_key, $crud, $comsection); 
                                    
                                    //Only show pagination when the number of pages exceeds one e.g 2,3
                                    if($tposts > $postNo): pagination($page, $type,  $table, $array, $postNo); endif;   
                                    
                                ?></div> <!-- card-body End --> <?php 
                            else : on_page_errors($msg1, $redirect, $msg2); endif; ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends --> <?php 
        }
    }

    // Get posts page with...
    //--> No Pagination for filter -- Posts Header / 
    // Body(col-page-box) and function variables
    if ( ! function_exists('get_posts_page_filter')) {
        function get_posts_page_filter($type, $table, $column, $match, $match1, $match2, $match3, $array, $order, $post_key, $crud, $comsection){ ?>

            <!-- partial -->
            <div class="content-wrapper">
                <div class="row col-pages all-post">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card post-card">
                            <div class="card-body"> <?php

                                $getcat = dbtable_w('*', 'categories', 'cat_key', $post_key); $cat = $getcat->fetch();

                                //total posts number for specific category
                                switch ($crud) {
                                    case 453:
                                        $cattotal = count_total_like_order('*', 'posts', $post_key, 'post_cat', $column, $match, $order); break;
                                    case 454:
                                        $cattotal = count_total_like_order('*', 'posts', $post_key, 'post_cat', $column, $match, $order); break;
                                    case 455:
                                        $cattotal = count_total_like_order('*', 'posts', $post_key, 'post_cat', $column, $match, $order); break;
                                } 

                                echo '<i class="fa fa-tag cat-fa"></i> <a class="category-href" href="">'. $cat['name'] .'&nbsp;('. $cattotal .')</a>'; 
    
                                alert_message(); get_posts_header($crud, $post_key, $type, $table, $column, $match1, $match2, $match3);
                                get_posts($type, $table, $array, $order, '', '', $column, $match, $post_key, $crud, $comsection); 
                                
                            ?></div><!-- card-body End -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends --> <?php 
        }
    }

    // Posts page function for individual pages
    // Posts Values for db and other functions can be changed from here
    // To-avoid-wasting-more-of-your-time-,-kindly-do-not-delete-any-thing-here
    if ( ! function_exists('posts_page')) {
        function posts_page($page, $post_key){ 
            switch ($page) {
                case 450: 
                    get_posts_page(
                        '*', 'posts', 'post_status', 0, 0, 1, 2,
                        'post_status=0', 'id desc', $post_key, 450, 'Published',
                        'Posts page not found', 'posts-published', 'Return to posts'
                    ); break;
                case 451: 
                    get_posts_page(
                        '*', 'posts', 'post_status', 1, 0, 1, 2,
                        'post_status=1', 'id desc', $post_key, 451, 'Draft',
                        'Posts page not found', 'posts-trash', 'Return to trash'
                    ); break; 
                case 452: 
                    get_posts_page(
                        '*', 'posts', 'post_status', 2, 0, 1, 2,
                        'post_status=2', 'id desc', $post_key, 452, 'Trash',
                        'Posts page not found', 'posts-trash', 'Return to trash'
                    ); break; 
                case 453:
                    get_posts_page_filter(
                        '*', 'posts', 'post_status', 0, 0, 1, 2,
                        '', 'id desc', $post_key, 453, 'Filter-Published' 
                    ); break; 
                case 454:
                    get_posts_page_filter(
                        '*', 'posts', 'post_status', 1, 0, 1, 2,
                        '', 'id desc', $post_key, 454, 'Filter-Draft' 
                    ); break; 
                case 455:
                    get_posts_page_filter(
                        '*', 'posts', 'post_status', 2, 0, 1, 2,
                        '', 'id desc', $post_key, 455, 'Filter-Trash' 
                    ); break; 
                
                default: on_page_errors('Page not found', 'posts-published', 'Return to posts'); break;
            }
        }
    } 

    
    // =================================================
    //
    // COMMENTS SECTION

    // Comments header
    // Comments navigation
    if ( ! function_exists('get_comments_header')) {
        function get_comments_header($page, $type, $table, $column, $match0, $match1, $match2, $match3){ 

            $totalcom = count_total($type, $table,);
            $unapproved = count_total_w($type, $table, $column, $match0); 
            $approved = count_total_w($type, $table, $column, $match1);
            $trash = count_total_w($type, $table, $column, $match2);
            $mine = count_total_w($type, $table, $column, $match3); 
            
            ?><!-- Form 1 -- Be careful with the forms haha -->
            <form action="comments_crud.php" method="POST" enctype="multipart/form-data">
            <div class="col-pages-header">
                <div class="label">
                    <label class="colheader" for="">
                        <span class="all">All (<?= $totalcom; ?>)</span>&nbsp;|&nbsp;
                        <a class="<?= active_class(['comments_unapproved.php']) ?>" 
                            href="comments_unapproved.php?page=1">Unapproved (<?= $unapproved; ?>)
                        </a>&nbsp;|&nbsp;
                        <a class="<?= active_class(['comments_approved.php']) ?>" 
                            href="comments_approved.php?page=1">Approved (<?= $approved; ?>)
                        </a>&nbsp;|&nbsp;
                        <a class="<?= active_class(['comments_mine.php']) ?>" 
                            href="comments_mine.php?page=1">Mine (<?= $mine; ?>)
                        </a>&nbsp;|&nbsp;
                        <a class="<?= active_class(['comments_trash_can.php']) ?>" 
                            href="comments_trash_can.php?page=1">Trash (<?= $trash; ?>)
                        </a> 
                    </label>
                </div>

                <div class="upper-crud">
                    <div class="dropdown"> 
                        <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle filter-button" id="dropdownMenuIconButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Bulk Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton4"> <?php 
                        
                            switch ($page) {
                                case 450:
                                    echo '<button class="dropdown-item" type="submit" name="multiapprove">Approve</button>
                                    <button class="dropdown-item" type="submit" name="multitrash">Trash</a>'; break;
                                case 451:
                                    echo '<button class="dropdown-item" type="submit" name="multiunapprove">Unapprove</button>
                                    <button class="dropdown-item" type="submit" name="multitrashapp">Trash</button>'; break;
                                case 452:
                                    echo '<a class="dropdown-item" data-toggle="modal" data-id="" href="#multidelete">Delete</a>'; break;
                                case 453:
                                    echo '<button class="dropdown-item" type="submit" name="replytrash">Trash</button>
                                    <a class="dropdown-item" data-toggle="modal" data-id="" href="#replydelete">Delete</a>'; break; 
                                default: echo '<a class="dropdown-item">Not found</a>'; break;
                            } 
                            
                        ?></div> 
                    </div>
                    <?php include 'includes/modal.php'; ?>
                </div>
            </div> 
            <?php
        }
    }

    // Comments Box
    // Most of HTML for comments box and content here
    if ( ! function_exists('get_comments')) {
        function get_comments($type, $table, $array, $order, $l1, $l2, $column, $match, $page, $comsection){ 
            $stmt = dbtable_condition($type, $table, 'WHERE '. $array .' ORDER BY '. $order .' LIMIT '. $l1 .','. $l2 .''); 
            
            ?><div class="col-pages-box">
            <h4><i class="fa fa-comment"></i>&nbsp;<span <?php

            // Different color for section headers for each page
            switch ($page) : 
                case 450: echo 'style="color: #FFC100;"'; break;
                case 451: echo 'style="color: #57B657;"';  break;
                case 452: echo 'style="color: #FF4747;"'; break; 
                case 453: echo 'style="color: #248AFD;"'; break;
                default: echo 'style="color: #248AFD;"';break; endswitch; 
            
            ?>><?= $comsection; ?></span></h4> <?php
            
            $tcomments = count_total_condition($type, $table, 'WHERE '. $array .'');  
            if ($tcomments > 0) : 

            ?><input type="checkbox" name="select-all" id="select-all" value=""> Select All </p> <?php

                foreach ($stmt as $comment) :

                    // Get posts of the comment
                    $post_table = dbtable_w('*', 'posts', 'id', $comment['post_id']); $post = $post_table->fetch(); 
                    // Get Profile picture
                    $img = (!empty($comment['image_file'])) ? "uploads/" . $comment['image_file'] : "uploads/profile.jpeg"; 
                    
                    ?><div class="col-page-box">
                        <div class="col-page-checkbox">
                            <input class="input" type="checkbox" name="checkbox[]" id="" value="<?= $comment['id']; ?>">
                        </div> 
                        <div class="col-page-pic"><?php 

                            // Profile pic
                            if (!empty($comment['comment_type'])) : 
                                $user_table = dbtable_w('*', 'users', 'username', $comment['comment_author']); 
                                $admin = $user_table->fetch(); 
                                $img_adm = (!empty($admin['photo'])) ? "uploads/" . $admin['photo'] : "uploads/profile.jpeg"; 
                                echo '<img src="'. $img_adm .'" class="rounded-circle" alt="" srcset="">';
                            else : echo '<img src="'. $img .'" class="rounded-circle" alt="" srcset="">'; endif; 
                            
                        ?></div> 
                        </form><!-- End form 1 --> 
                        <div class="col-page-body">
                            <div class="col-page-content"><?php 

                                // For admins comments on other users comments
                                // It will shouw the comment instead of the post-title 
                                if (!empty($comment['comment_type'])) : 
                                    $com_table = dbtable_w('*', 'comments', 'id', $comment['comment_id']); $reply_com = $com_table->fetch(); 
                                    echo '<p class="post"><i class="fa fa-comment"></i>'. str_limit(htmlentities($reply_com['comment_content']), 200).'...' .'</p>';

                                else: // Other comment pages -- Show post-title
                                    echo '
                                    <p class="post">
                                        <a target="_blank" href="../sailor/blog-single.php?id='. $post['id'] .'">
                                        <i class="fa fa-chevron-circle-right"></i>
                                        '. htmlentities($post['post_title']) .'
                                        </a>
                                    </p>'; 
                                endif; 
                                
                                ?><p class="author">
                                    <!-- Author name -->
                                    By <span class="name"><?= $comment['comment_author']; ?></span>
                                    &nbsp;<i class="ti-time ti"></i>&nbsp;<span class="time">
                                    <!-- Comment date -- Time -->
                                    <?= date('j M \'\ y', strtotime($comment['comment_date'])); ?></span>
                                </p>

                                <!-- Comment content -->
                                <p id="comment">
                                    <i class="fa fa-reply"></i><?= html_entity_decode($comment['comment_content']); ?>
                                </p>
                                
                            </div>
                            <div class="crud">
                                <!-- Form 2 start haha -->
                                <form action="comment_crud.php?id=<?= $comment['id']; ?>" method="post" enctype="multipart/form-data">

                                    <!-- Crud buttons for different pages -->
                                    <?php if ($page == 450) : //comments_unapproved ?> 
                                    <button type="submit" name="singleapprove" class="btn btn-sm btn-success">Approve</button>
                                    <button type="submit" name="singletrash" class="btn btn-sm btn-outline-danger">Trash</button> 
                                    <button disabled="disabled">></button>

                                    <?php elseif ($page == 451) : //comments_approved ?>
                                    <button type="submit" name="singleunapprove" class="btn btn-sm btn-outline-warning">Unapprove</button>
                                    <button type="submit" name="singletrashapp" class="btn btn-sm btn-outline-danger">Trash</button>
                                    <a class="btn btn-sm btn-primary btn-a" href="comment_reply.php?comment=<?= $comment['id']; ?>">Reply</a>
                                    <button disabled="disabled">></button>

                                    <?php elseif ($page == 452) : //comments_trash_can ?> 
                                    <button type="submit" name="<?php if ($comment['comment_type'] == 2) : echo 'replyrestore'; else : echo 'singlerestore'; endif; ?>" class="btn btn-sm btn-outline-success">Restore</button>
                                    <button type="submit" name="singledelete" class="btn btn-sm btn-danger">Delete</button> 
                                    <button disabled="disabled">></button>

                                    <?php elseif ($page == 453) : //comments_mine ?> 
                                    <button type="submit" name="singleminedelete" class="btn btn-sm btn-outline-danger">Delete</button> 
                                    <button type="submit" name="singletrashmine" class="btn btn-sm btn-outline-danger">Trash</button> 
                                    <a class="btn btn-sm btn-outline-primary btn-a" href="comment_reply_edit.php?comment=<?= $comment['id']; ?>">Edit</a>
                                    <button disabled="disabled">></button> 
                                    <?php endif; ?>
                                </form><!-- End form 2 -->
                                
                            </div><!-- End crud -->
                        </div> <!-- End comment-body -->
                    </div><!-- End comment-box --> <?php
                endforeach; 
            else :  echo ' <div class="col-page-box-else"> <p>No available comments!</p> </div> '; endif; 
            echo ' </div><!-- End comments-box -->';
        }
    } 

    //Get comments page with...
    //--> Pagination here -- Comments Header / Comment-box
    // Body(comments-box) and function variables
    if ( ! function_exists('get_comments_page')) {
        function get_comments_page($type, $table, $column, $match, $match0, $match1, $match2, $match3, $array, $order, $crud, $comsection, $msg1, $redirect, $msg2){ ?>

            <!-- partial -->
            <div class="content-wrapper">
                <div class="row col-pages">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card"> <?php

                            //page must be set
                            if (isset($_GET['page'])) : 
                                $page = $_GET['page']; 
                                if(empty($page) || $page < 1): $page = 1; endif;//<-- set default page to 1 if no page is set, to avoid errors
        
                                $tcomments = count_total_condition($type, $table, 'WHERE '. $array .''); 
                                if ($page==0 || $page<1) : $page_count = 0; 
                                else : $postNo = page_item_number($type, $table, $array); $page_count = ($page*$postNo)-$postNo; endif; ?>
        
                                <div class="card-body">
                                    <h4 class="card-title"><?php
                                        switch ($crud) : 
                                            case 450: echo 'Unapproved Comments'; break;
                                            case 451: echo 'Approved Comments';  break;
                                            case 452: echo 'Comments Trash'; break; 
                                            case 453: echo 'Comments - Mine'; break;
                                            default: echo 'Comments';break; endswitch;
                                    ?></h4> <?php 
        
                                    alert_message(); get_comments_header($crud, $type, $table, $column, $match0, $match1, $match2, $match3); 
                                    get_comments($type, $table, $array, $order, $page_count, $postNo, $column, $match, $crud, $comsection); 
                                    
                                    //Only show pagination when the number of pages exceeds one e.g 2,3
                                    if($tcomments > $postNo): pagination($page, $type,  $table, $array, $postNo); endif;   ?>  
                                </div>
                                <!-- card-body End --> <?php 
                            else : on_page_errors($msg1, $redirect, $msg2); endif; ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends --> <?php 
        }
    }

    // Comments page function for individual pages
    // Comments Values for db and other functions can be changed from here
    // To-avoid-wasting-more-of-your-time-,-kindly-do-not-delete-any-thing-here
    if ( ! function_exists('comments_page')) {
        function comments_page($page){ 
            switch ($page) {
                case 450: 
                    get_comments_page( // Unapproved
                        '*', 'comments', 'comment_status', 0, 0, 1, 2, 3,
                        'comment_status=0', 'id desc', 450, 'Unapproved',
                        'Comments page not found', 'comments_unapproved', 'Return to comments'
                    ); break;
                case 451: 
                    get_comments_page( // Approved
                        '*', 'comments', 'comment_status', 1, 0, 1, 2, 3,
                        'comment_status=1', 'id desc', 451, 'Approved',
                        'Comments page not found', 'comments_approved', 'Return to comments'
                    ); break;
                case 452: 
                    get_comments_page( // Trash
                        '*', 'comments', 'comment_status', 2, 0, 1, 2, 3,
                        'comment_status=2', 'id desc', 452, 'Trash',
                        'Comments page not found', 'comments_trash_can', 'Return to comments'
                    ); break;
                case 453: 
                    get_comments_page( // Mine
                        '*', 'comments', 'comment_status', 3, 0, 1, 2, 3,
                        'comment_status=3', 'id desc', 453, 'Mine',
                        'Comments page not found', 'comments_mine', 'Return to comments'
                    ); break;
                
                default: on_page_errors('Page not found', 'comments', 'Return to comments'); break;
            }
        }
    }

    //A substitute of comments.php page
    if ( ! function_exists('comments_redirect')) {
        function comments_redirect($column, $match1, $match2) {

            $unapproved = count_total_w('*', 'comments', $column, $match1); 
            $approved = count_total_w('*', 'comments', $column, $match2);
            
            if ($unapproved > 0) : 
                redirect_to('comments_unapproved.php?page=1');
            elseif ($unapproved == 0 && $approved == 0) : 
                redirect_to('comments_unapproved.php?page=1');
            else: 
                redirect_to('comments_approved.php?page=1'); 
            endif;
        }
    } // End comments_redirect()


    // GALLERY
    //
    // 
    // 

    // Get gallery page header add-on
    // Top most header info here
    if (! function_exists('get_gallery_page_addon')){
        function get_gallery_page_addon($crud){ 
            ?><div class="gallery-header">
                <div class="div-title"> 
                    <h4 class="card-title"><?php

                    switch ($crud) { case 450: echo 'Gallery'; break; default: echo 'Gallery'; break; }

                    if ($crud == 450) : echo '<a href="#addnewphoto" class="add-btn" data-toggle="modal"><i class="fa fa-photo"></i>&nbsp;&nbsp;Upload  Photo</a>'; endif;
                    ?></h4> 
                    
                </div><?php 
                alert_message(); 
            ?></div><?php
        }
    } // End get_gallery_page_addon()
    

    // Users-col-box Gallery-col-box
    // Most of HTML for gallery-page and content here
    if ( ! function_exists('get_gallery')) {
        function get_gallery($type, $table, $array, $order, $l1, $l2, $page, $postNo){ 

            $stmt = dbtable_condition($type, $table, ' ORDER BY '. $order .' LIMIT '. $l1 .','. $l2 .'');
            
            ?><div class="col-lg-12 grid-margin stretch-card user-col-box ">
                <div class="card gallery-card">
                    <p class="card-description">*<code>Hover on or click</code>a photo for more details</p>
                    
                    <div class="card-body gallery-card-body col-pages-box"><?php
                        
                        $totalstmt = count_total_condition($type, $table, ' ORDER BY '. $order .'');
                        if ($totalstmt > 0) : 

                            foreach ($stmt as $photo) {

                                // Check image
                                $pic = (!empty($photo['file_name'])) ? $photo['file_name'] : '' ;
                                ?><form action="gallery_crud.php?photo=<?= $photo['id']; ?>" method="post" enctype="multipart/form-data">
                                    <!-- Individual Photo div -->
                                    <div class="div-photo">
                                        <div class="img">
                                            <img src="uploads/<?= $pic; ?>" alt="">
                                            <label class="photo-footer">
                                                <span class="1">ID: <?= $photo['file_code']; ?></span>
                                                <button type="submit" class="photo-button" title="Delete" name="deletephoto"><i class="fa fa-trash"></i></button>
                                            </label>
                                        </div>
                                    </div>
                                </form><?php 
                            }

                        else: echo 'Nothing to see here champ!'; endif;
                    ?></div><!-- End card body --><?php

                    // Only show pagination when the number of pages exceeds 1 e.g 2,3
                    if($totalstmt > $postNo): pagination($page, $type,  $table, $array, $postNo); endif; 

                ?></div> 
            </div><!-- End user-col-box --> <?php

        }
    } // End get_gallery()


    // Get gallery page with...
    //--> Pagination here -- gallery Header / gallery-page
    // Body(users-box) and function variables
    if ( ! function_exists('get_gallery_page')) {
        function get_gallery_page($type, $table, $array, $order, $crud, $msg1, $redirect, $msg2){ ?>

            <!-- partial -->
            <div class="content-wrapper">
                <div class="row col-pages">
                    <div class="col-lg-12 grid-margin stretch-card users-pages">
                        <div class="card"> <?php

                            // page must be set
                            if (isset($_GET['page'])) : 
                                $page = $_GET['page']; 
                                if(empty($page) || $page < 1): $page = 1; endif; //<-- set default page to 1 if no page is set, to avoid errors
        
                                $tusers = count_total_condition($type, $table, ' ORDER BY '. $order .''); 
                                if ($page==0 || $page<1) : $page_count = 0; 
                                else : $postNo = page_item_number($type, $table, $array); $page_count = ($page*$postNo)-$postNo; endif; 
                                
                                include 'includes/modal.php';
                                ?><div class="card-body"><?php
                                
                                    get_gallery_page_addon($crud);
                                    get_gallery($type, $table, $array, $order, $page_count, $postNo, $page, $postNo);
                                    
                                ?></div> <!-- card-body End --> <?php 
                            else : on_page_errors($msg1, $redirect, $msg2); endif; ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends --> <?php

        }
    } // End get_gallery_page()


    // gallery page function for individual pages
    // gallery Values for db and other functions can be changed from here
    // To-avoid-wasting-more-of-your-time-,-kindly-do-not-delete-any-thing-here---Gracias
    if ( ! function_exists('gallery_page')) {
        function gallery_page($page, $keyword){ 
            switch ($page) {
                case 450: 
                    get_gallery_page( // All photos
                        '*', 'gallery', 'id>0', 'id desc', 450,
                        'Gallery page not found', 'gallery', 'Return to gallery'
                    ); break;
                default: on_page_errors('Gallery page not found', 'gallery', 'Return to gallery'); break;
            }
        }
    } // End gallery_page()




    // =================================================
    //
    // USERS SECTION

    // Get users page header add-on
    // Top most header info here
    if (! function_exists('get_users_page_addon')){
        function get_users_page_addon($crud, $card_title, $ttrash, $keyword){
            if ($crud != 455) :
            ?><div class="manage-user-header"><?php 

                if ($crud == 454) : // Trash page
                    echo '<div class="div-title"><h4 style="" class="card-title-trash"> Trash </h4></div>';
                else: // Any other page

                ?><div class="div-title">
                    <h4 class="card-title"><?php

                    switch ($crud) {
                        case 450: echo 'All Users'; break;
                        case 451: echo 'Active Users'; break;
                        case 452: echo 'Inactive Users'; break;
                        case 453: echo 'Admins'; break;
                        default: echo 'Manage Users'; break;
                    }

                    ?>&nbsp;<span><?= $card_title = (!empty($card_title)) ? '-&nbsp;' . $card_title : ''; ?></span></h4>
                </div>
                <div class="add-on">
                    <label for="" class="add-user">
                        <a class="span-1" href="#usersadduser" data-toggle="modal"><i class="fa fa-plus"></i>&nbsp;Add User</a>&nbsp;<a class="span-2" href="users_trash.php?page=1">View-Trash <?= '('. $ttrash .')'; ?></a>
                    </label>
                </div><?php 
                endif; alert_message(); 
            ?></div> 
            
            <!-- Search Bar -->
            <div class="manage-user-search">
                <form class="search-form" method="POST" action="users-search.php">
                    <div class="form-group"> 
                        <div class="input-group">
                            <input type="search" class="form-control form-control-sm" name="keyword" placeholder="Search by username or email" aria-label="Search User">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search" name="searchy"></i></button>
                            </div>
                        </div>
                    </div> 
                </form>
            </div><?php
            
            else : // Search Page
                back_button('users.php?page=1', 'Return home');
                ?><div class="col-lg-12 manage-user-header-2">
                    <div class=" div-title">
                        <h4 style="" class="search-results">Search results for... <span><?= $keyword; // In this case $ttrash will be $keyword..  ?></span></h4>
                    </div>
                </div><?php 
            endif;
        }
    } // End get_users_page_addon()

    // Users header
    // Users navigation
    if ( ! function_exists('get_users_header')) {
        function get_users_header($page){ ?>
            
            <!-- Form 1 start haha -->
            <form action="users_crud.php" method="post" enctype="multipart/form-data">

            <div class="header">
                <div class="header-nav">
                    <div class="dropdown"> 
                        <div class="drop-2">
                            <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle filter-button" id="dropdownMenuIconButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Bulk Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton4"> <?php 

                                if ($page == 450) :
                                    echo '<button type="submit" class="dropdown-item" name="usersactivate'. $page .'">Activate</button>
                                    <button type="submit" class="dropdown-item" name="usersdeactivate'. $page .'">Deactivate</button>
                                    <button type="submit" class="dropdown-item" name="userstrash'. $page .'">Send to Trash</button>';
                                elseif ($page == 451) :
                                    echo '<button type="submit" class="dropdown-item" name="usersdeactivate'. $page .'">Deactivate</button>
                                    <button type="submit" class="dropdown-item" name="userstrash'. $page .'">Send to Trash</button>';
                                elseif ($page == 452) :
                                    echo '<button type="submit" class="dropdown-item" name="usersactivate'. $page .'">Activate</button>
                                    <button type="submit" class="dropdown-item" name="userstrash452">Send to Trash</button>';
                                elseif ($page == 453) :
                                    echo '<button type="submit" class="dropdown-item" name="usersactivate'. $page .'">Activate</button>
                                    <button type="submit" class="dropdown-item" name="usersdeactivate'. $page .'">Deactivate</button>
                                    <button type="submit" class="dropdown-item" name="userstrash'. $page .'">Send to Trash</button>';
                                elseif ($page == 454) :
                                    echo '<button type="submit" class="dropdown-item" name="usersactivate'. $page .'">Activate</button>
                                    <button type="submit" class="dropdown-item" name="usersdelete'. $page .'">Delete</button>';
                                endif; 
                                
                            ?></div>
                        </div>
                        <div class=" drop-1">
                            <label for="" class="label users-drop-1">
                                <?php if ($page != 454) : ?>
                                <a href="users-active.php?page=1" id="users-a-a" 
                                    class="users-a users-active 
                                    <?= active_class(['users-active.php']); ?>">Active
                                </a>
                                <a href="users-inactive.php?page=1" 
                                    class="users-a users-inactive 
                                    <?= active_class(['users-inactive.php']); ?>">Inactive
                                </a>
                                <a href="users.php?page=1" 
                                    class="users-a users-all 
                                    <?= active_class(['users.php']); ?>">All
                                </a>
                                <?php else : echo '<a href="users.php?page=1" class="users-a users-all">Back to Users</a>';  endif; ?>
                            </label>
                        </div>
                    </div><!-- End dropdown -->
                </div>
            </div><!-- End Header --> <?php

        }
    } // End get_users_header()


    // Users-col-box
    // Most of HTML for users-page and content here
    if ( ! function_exists('get_users')) {
        function get_users($type, $table, $array, $array2, $order, $l1, $l2, $page){ 

            $stmt = ($page == 455) ? dbtable_condition($type, $table, 'WHERE '. $array .' AND '. $array2 .' ORDER BY '. $order .'') : dbtable_condition($type, $table, 'WHERE '. $array .' ORDER BY '. $order .' LIMIT '. $l1 .','. $l2 .'');
            
            ?><div class="col-lg-12 grid-margin stretch-card user-col-box">
                <div class="card">
                    <div class="card-body col-pages-box"><?php 
                    
                        $totalstmt = ($page == 455) ? count_total_condition($type, $table, 'WHERE '. $array .' AND '. $array2 .'') : count_total_condition($type, $table, 'WHERE '. $array .'');
                        if ($totalstmt > 0) : 
                        ?><div class="table-responsive table-hover">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                    <th> <input type="checkbox" name="select-all" id="select-all" value=""> </th>
                                    <th> User </th>
                                    <th> Username </th>
                                    <th> Email </th>
                                    <th> Role </th>
                                    <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody><?php

                                    foreach ($stmt as $user) : 

                                    // Check profile pic
                                    $img = (!empty($user['photo'])) ? 'uploads/' . $user['photo'] : 'uploads/profile.jpeg';
                                    // Check user-name && email
                                    $user_name = (empty($user['firstName']) || empty($user['secondName'])) ? '<span>---</span>' : $user['firstName'] . '&nbsp;' . $user['secondName'];
                                    $email = (empty($user['email'])) ? '---' : $user['email'];

                                    // For progress bar to check empty columns
                                    $bar_values = [$user['username'],$user['firstName'],$user['secondName'],$user['email'],$user['phone'],$user['country'],$user['city'],$user['bio'],$user['photo']];

                                    ?><tr>
                                        <td><input class="input" type="checkbox" name="checkbox[]" id="" value="<?= $user['id']; ?>"></td>
                                        
                                        </form> <!-- End form 1 -->

                                        <td class="py-1"><img src="<?= $img; ?>" alt="image"/> </td>

                                        <td class="py-1"> <?= '<span>' . $user['username'] . '</span><br>' . $user_name; ?> </td>

                                        <td class="py-1"><?= '<span>' . $email . '</span><br>Joined:&nbsp;' . date('M j\,\ Y', strtotime($user['user_registered'])); ?></td>

                                        <!-- Form 2 start haha -->
                                        <form action="user_crud.php?user=<?= $user['id']; ?>" method="post" enctype="multipart/form-data">
                                        <td> 
                                            <div class="dropdown"> 
                                                <div class="drop-2">
                                                    <button type="button" class="btn btn-outline-light btn-sm td-button" id="dropdownMenuIconButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span><?= get_user_level_type($user['user_level']); // Assigned user role ?></span>&nbsp;&nbsp;<i class="fa fa-sort"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton4"><?php 

                                                        // Only Active users
                                                        if ($user['user_status'] == 1) : 
                                                            // Only admins
                                                            if ($user['user_level'] != 0) :
                                                                // Only on admin page
                                                                // if ($page == 453) : 

                                                                ?><button disabled="disabled" class="dropdown-item">Change Role to
                                                                    <!-- &nbsp;<i class="fa fa-chevron-down"></i> -->
                                                                </button><?php

                                                                // Admin roles except super admin
                                                                $getarr = [0,2,3,4,5,6];
                                                                foreach ($getarr as $getlevel){ 
                                                                    // Show other user roles that an admin can switch the user to
                                                                    if ($getlevel != $user['user_level']) : ?>
                                                                        <button class="dropdown-item" type="submit" name="single<?= get_user_level_type($getlevel); ?>"> 
                                                                            <?= get_user_level_type($getlevel); ?>
                                                                        </button> <?php
                                                                    endif;
                                                                }

                                                                // endif;

                                                            echo '<button disabled="disabled" class="dropdown-item">Action </button>
                                                            <button type="submit" class="dropdown-item" name="usertrash'. $page .'">Send to Trash</button>';

                                                            else : 
                                                                echo '<button disabled="disabled" class="dropdown-item">Action </button>
                                                                <button type="submit" class="dropdown-item" name="useradmin'. $page .'">Make Admin</button>
                                                                <button type="submit" class="dropdown-item" name="usertrash'. $page .'">Send to Trash</button>'; 
                                                            endif;

                                                        else : 
                                                            echo  ($user['user_exit'] == 1) ?
                                                            '<button disabled="disabled" class="dropdown-item">User Inactive</button>
                                                            <button type="submit" class="dropdown-item" name="userdelete'. $page .'"> Delete </button>' : 
                                                            '<button disabled="disabled" class="dropdown-item">User Inactive</button>
                                                            <button type="submit" class="dropdown-item" name="usertrash'. $page .'">Send to Trash</button>' ; 
                                                        endif;

                                                    ?></div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="py-2">  
                                            <?php progress_bar($bar_values, 'Profile'); ?>
                                            <span><?= ($user['user_status'] == 1) ? '<button type="submit" class="action-1" name="userdeactivate'. $page .'">Deactivate</button>' : '<button type="submit" class="action-2" name="useractivate'. $page .'">Activate</button>'; ?></span>
                                        </td> 
                                        </form> <!-- Form 2 ends!  -->
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div><?php

                        else : echo ($page == 455) ? '<div class="col-page-box-else"> <p>Oooops! No users found!</p> </div> ' : '<div class="col-page-box-else"> <p>Oooops! No available users here!</p> </div> '; endif;
                    ?></div>
                </div>
            </div> <!-- End user-col-box --> <?php

        }
    } // End get_users()


    // Get users page with...
    //--> Pagination here -- Users Header / Users-page
    // Body(users-box) and function variables
    if ( ! function_exists('get_users_page')) {
        function get_users_page($type, $table, $column, $match, $array, $array2, $keyword, $order, $crud, $card_title, $msg1, $redirect, $msg2){ ?>

            <!-- partial -->
            <div class="content-wrapper">
                <div class="row col-pages">
                    <div class="col-lg-12 grid-margin stretch-card users-pages">
                        <div class="card"> <?php

                            // page must be set
                            if (isset($_GET['page'])) : 
                                $page = $_GET['page']; 
                                if(empty($page) || $page < 1): $page = 1; endif; //<-- set default page to 1 if no page is set, to avoid errors
        
                                $tusers = count_total_condition($type, $table, 'WHERE '. $array .''); 
                                if ($page==0 || $page<1) : $page_count = 0; 
                                else : $postNo = page_item_number($type, $table, $array); $page_count = ($page*$postNo)-$postNo; endif; 
                                
                                $ttrash = count_total_w($type, $table, $column, $match);
                                include 'includes/modal.php';
                                ?><div class="card-body"><?php
                                
                                    get_users_page_addon($crud, $card_title, $ttrash, $keyword);
                                    get_users_header($crud); 
                                    get_users($type, $table, $array, $array2, $order, $page_count, $postNo, $crud); 
                                    
                                    // Only show pagination when the number of pages exceeds 1 e.g 2,3
                                    if($tusers > $postNo): pagination($page, $type,  $table, $array, $postNo); endif;   
                                    
                                ?></div> <!-- card-body End --> <?php 
                            else : on_page_errors($msg1, $redirect, $msg2); endif; ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends --> <?php

        }
    } // End get_users_page()


    // Get users page with...
    //--> Pagination here -- Users Header / Users-page
    // Body(users-box) and function variables
    if ( ! function_exists('get_users_search_page')) {
        function get_users_search_page($type, $table, $array, $array2, $keyword, $order, $crud, $card_title){ ?>

            <!-- partial -->
            <div class="content-wrapper">
                <div class="row col-pages">
                    <div class="col-lg-12 grid-margin stretch-card users-pages">
                        <div class="card">
                            <div class="card-body"><?php 

                                $key = $_POST['keyword'];
                                get_users_page_addon($crud, $card_title, '',  $keyword); 
                                get_users($type, $table, $array, $array2, $order, '', '', $crud); 
                                    
                            ?></div> <!-- card-body End -->  
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends --> <?php

        }
    } // End get_users_search_page()


    // Users page function for individual pages
    // Users Values for db and other functions can be changed from here
    // To-avoid-wasting-more-of-your-time-,-kindly-do-not-delete-any-thing-here---Gracias
    if ( ! function_exists('users_page')) {
        function users_page($page, $keyword){ 
            switch ($page) {
                case 450: 
                    get_users_page( // All users except super admin
                        '*', 'users', 'user_exit', 1,
                        'user_type=0 AND user_exit=0', '', $keyword, 'id desc', 450, 'All',
                        'Users page not found', 'users', 'Return to users'
                    ); break;
                case 451: 
                    get_users_page( // Active users
                        '*', 'users', 'user_exit', 1,
                        'user_type=0 AND user_status=1 AND user_exit=0', '', $keyword, 'id desc', 451, 'Active',
                        'Users page not found', 'users', 'Return to users'
                    ); break;
                case 452: 
                    get_users_page( // Inactive users
                        '*', 'users', 'user_exit', 1,
                        'user_type=0 AND user_status=0 AND user_exit=0', '', $keyword, 'id desc', 452, 'Inactive',
                        'Users page not found', 'users', 'Return to users'
                    ); break;
                case 453: 
                    get_users_page( // Admins except super admin
                        '*', 'users', 'user_exit', 1,
                        'user_type=0 AND user_level!=0', '', $keyword, 'id desc', 453, 'Admins',
                        'Users page not found', 'users', 'Return to users'
                    ); break;
                case 454: 
                    get_users_page( // Users in Trash
                        '*', 'users', 'user_exit', 1,
                        'user_type=2 AND user_exit=1', '', $keyword, 'id desc', 454, 'Trash',
                        'Users page not found', 'users', 'Return to users'
                    ); break;
                case 455: 
                    $key = "'%$keyword%'"; // For search bar
                    get_users_search_page( // Users in Trash
                        '*', 'users', 'user_type=0', 
                        'username LIKE '. $key .' OR email LIKE '. $key .' ',
                        $keyword, 'id desc', 455, 'User Search'
                    ); break;
                
                default: on_page_errors('Userss page not found', 'users', 'Return to users'); break;
            }
        }
    } // End users_page()




    // =================================================
    //
    // SUSCRIBERS SECTION

    // Get subscribers page header add-on
    // Top most header info here
    
    if (! function_exists('get_subscribers_page_addon')){
        function get_subscribers_page_addon($crud){ 
            ?><div class="manage-user-header-3">
                <div class="div-title"> 
                    <h4 class="card-title"><?php
                    
                    switch ($crud) {
                        case 450: echo 'Active Subscribers&nbsp;<span>-&nbsp;<i class="fa fa-envelope"></i></span>'; break;
                        case 451: echo 'Subscribers <i class="fa fa-chevron-right"></i> Trash'; break;
                        case 452: echo 'Subscribers <i class="fa fa-chevron-right"></i> Spam'; break;
                        default: echo 'Subscribers'; break;
                    }

                    if ($crud == 450) : echo '<a href="#addnewsubscriber" class="add-btn" data-toggle="modal"><i class="ti-plus"></i>&nbsp;Add</a>'; endif;
                    ?></h4> 
                    
                </div><?php 
                alert_message(); 
            ?></div><?php
        }
    } // End get_subscribers_page_addon()
    

    // subscribers header
    // subscribers navigation
    if ( ! function_exists('get_subscribers_header')) {
        function get_subscribers_header($page){ ?>
            
            <!-- Form 1 start haha -->
            <form action="subscribers_crud.php" method="post" enctype="multipart/form-data">

            <div class="header">
                <div class="header-nav">
                    <div class="dropdown"> 
                        <div class="drop-2">
                            <button type="button" class="btn btn-outline-dark btn-sm dropdown-toggle filter-button" id="dropdownMenuIconButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton4"> <?php 

                                if ($page == 450) :
                                    echo '<button type="submit" class="dropdown-item" name="trash'. $page .'">Send to Trash</button>
                                    <button type="submit" class="dropdown-item" name="spam'. $page .'">Send to Spam</button>';
                                elseif ($page == 451) :
                                    echo '<button type="submit" class="dropdown-item" name="restore'. $page .'">Restore</button>
                                    <button type="submit" class="dropdown-item" name="delete'. $page .'">Delete</button>';
                                elseif ($page == 452) :
                                    echo '<button type="submit" class="dropdown-item" name="restore'. $page .'">Restore</button>
                                    <button type="submit" class="dropdown-item" name="delete'. $page .'">Delete</button>';
                                endif; 
                                
                            ?></div>
                        </div>
                        <div class=" drop-1">
                            <label for="" class="label users-drop-1">
                                <a href="subscribers-spam.php?page=1" id="users-a-a" 
                                    class="users-a users-active subscribers-spam 
                                    <?= active_class(['subscribers-spam.php']); ?>">Spam
                                </a>
                                <a href="subscribers-trash.php?page=1" 
                                    class="users-a users-inactive subscribers-trash 
                                    <?= active_class(['subscribers-trash.php']); ?>">Trash
                                </a>
                                <a href="subscribers.php?page=1" 
                                    class="users-a users-all subscribers 
                                    <?= active_class(['subscribers.php']); ?>">Active
                                </a>
                            </label>
                        </div>
                    </div><!-- End dropdown -->
                </div>
            </div><!-- End Header --> <?php

        }
    } // End get_subscribers_header()


    // Users-col-box
    // Most of HTML for subscribers-page and content here
    if ( ! function_exists('get_subscribers')) {
        function get_subscribers($type, $table, $array, $array2, $order, $l1, $l2, $page, $reetable, $reearray, $reeorder, $crud, $postNo){ 

            $stmt = dbtable_condition($type, $table, 'WHERE '. $array .' ORDER BY '. $order .' LIMIT '. $l1 .','. $l2 .'');
            
            ?><div class="col-lg-12 grid-margin stretch-card user-col-box ">
                <div class="card subscribers-card">
                    <div class="row">
                        <!-- General subscribers section -->
                        <div class="col-lg-6 card-body subscribers-col-box-1">
                            <div class="table-responsive table-hover  col-pages-box"><?php 
                        
                                $totalstmt = count_total_condition($type, $table, 'WHERE '. $array .'');
                                if ($totalstmt > 0) : 
                                ?><table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> <input type="checkbox" name="select-all" id="select-all" value=""> </th>
                                            <th> Email </th>
                                            <th> Subscribed-on </th>
                                        </tr>
                                    </thead>
                                    <tbody><?php

                                        foreach ($stmt as $user) : 
                                            
                                        // Check user-name && email
                                        $email = (empty($user['email'])) ? '---' : $user['email'];
                                        $subemail = ($page != 450) ? '<span style="color: #918f8f;">' . $email . '</span>'  : '<span>' . $email . '</span>' ;

                                        // Check date
                                        $todate = date('M j\,\ Y', strtotime($user['date_registered']));
                                        $subdate = ($page != 450) ? '<span style="color: #918f8f;">' . $todate . '</span>'  : '<span>' . $todate . '</span>' ;
                                            
                                        // Check user-name && email
                                        $email = (empty($user['email'])) ? '---' : $user['email'];

                                        ?><tr>
                                            <td><input class="input" type="checkbox" name="checkbox[]" id="" value="<?= $user['id']; ?>"></td>
                                            
                                            </form> <!-- End form 1 -->

                                            <td class="py-1"> <?= $subemail; ?> </td>

                                            <td class="py-2"><?= $subdate; ?></td>
                                            
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table><?php
                                else : echo '<div class="col-page-box-else"> <p>Oooops! No subscribers found!</p> </div>'; endif;
                                        
                                // Only show pagination when the number of pages exceeds 1 e.g 2,3
                                if($totalstmt > $postNo): pagination($crud, $type,  $table, $array, $postNo); endif;  
                            ?></div>
                        </div> <!-- End General subscribers section -->

                        <!-- Recently Subscribed section -->
                        <div class="col-lg-5 card-body subscribers-col-box-2">
                            <h4 class="card-title sub-2">Recently Subscribed</h4>
                            <p class="card-description">
                                Arranged in descending<code>Order</code>
                            </p><?php
                            
                            $stmt2 = dbtable_condition($type, $reetable, ' ORDER BY '. $reeorder .' LIMIT '. 0 .','. 10 .''); 
                            $totalstmt = count_total_condition($type, $reetable, ' ORDER BY '. $reeorder .'');

                            if ($totalstmt > 0) : $no = 0;
                            ?><div class="table-responsive table-hover">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                        <th style=""> <i class="fa fa-sort"></i> </th>
                                        <th> Email </th>
                                        <th> Subscribed-on </th>
                                        </tr>
                                    </thead>
                                    <tbody><?php

                                        foreach ($stmt2 as $user) : $no++;
                                            
                                        // Check user-name && email
                                        $email = (empty($user['email'])) ? '---' : $user['email'];
                                        $subemail = ($user['sub_type']==1 || $user['sub_type']==2) ? '<span style="color: #918f8f;">' . $email . '</span>'  : '<span>' . $email . '</span>' ;

                                        // Check date
                                        $todate = date('M j\,\ Y', strtotime($user['date_registered']));
                                        $subdate = ($user['sub_type']==1 || $user['sub_type']==2) ? '<span>' . $todate . '</span>'  : '<span style="color: #333;">' . $todate . '</span>' ;
                                            
                                        // Check user-name && email
                                        $email = (empty($user['email'])) ? '---' : $user['email'];

                                        ?><tr>
                                            <td class="count"><?= $no . '.'; ?></td>

                                            <td class="py-1"> <?= $subemail;  ?> </td>

                                            <td class="py-2"><?= $subdate;  ?></td>
                                            
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div><?php

                            else : echo '<div class="col-page-box-else"> <p>Oooops! No subscribers found!</p> </div>'; endif;
                        ?></div><!-- End Recently subscribers section -->
                    </div>
                </div> 
            </div><!-- End user-col-box --> <?php

        }
    } // End get_subscribers()


    // Get subscribers page with...
    //--> Pagination here -- subscribers Header / subscribers-page
    // Body(users-box) and function variables
    if ( ! function_exists('get_subscribers_page')) {
        function get_subscribers_page($type, $table, $array, $array2, $keyword, $order, $crud, $card_title, $msg1, $redirect, $msg2){ ?>

            <!-- partial -->
            <div class="content-wrapper">
                <div class="row col-pages">
                    <div class="col-lg-12 grid-margin stretch-card users-pages">
                        <div class="card"> <?php

                            // page must be set
                            if (isset($_GET['page'])) : 
                                $page = $_GET['page']; 
                                if(empty($page) || $page < 1): $page = 1; endif; //<-- set default page to 1 if no page is set, to avoid errors
        
                                $tusers = count_total_condition($type, $table, 'WHERE '. $array .''); 
                                if ($page==0 || $page<1) : $page_count = 0; 
                                else : $postNo = page_item_number($type, $table, $array); $page_count = ($page*$postNo)-$postNo; endif; 
                                
                                include 'includes/modal.php';
                                ?><div class="card-body"><?php
                                
                                    get_subscribers_page_addon($crud);
                                    get_subscribers_header($crud); 
                                    get_subscribers($type, $table, $array, $array2, $order, $page_count, $postNo, $crud, 'subscribers', 'sub_type=0', 'id desc', $page, $postNo);  
                                    
                                ?></div> <!-- card-body End --> <?php 
                            else : on_page_errors($msg1, $redirect, $msg2); endif; ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends --> <?php

        }
    } // End get_subscribers_page()


    // Subscribers page function for individual pages
    // Subscribers Values for db and other functions can be changed from here
    // To-avoid-wasting-more-of-your-time-,-kindly-do-not-delete-any-thing-here---Gracias
    if ( ! function_exists('subscribers_page')) {
        function subscribers_page($page, $keyword){ 
            switch ($page) {
                case 450: 
                    get_subscribers_page( // All subscribers
                        '*', 'subscribers', 'sub_type=0', '', $keyword, 'id desc', 450, 'All',
                        'Subscribers page not found', 'subscribers', 'Return to subscribers'
                    ); break;
                case 451: 
                    get_subscribers_page( // Subcribers in trash
                        '*', 'subscribers', 'sub_type=1', '', $keyword, 'id desc', 451, 'Trash',
                        'Subscribers page not found', 'subscribers', 'Return to subscribers'
                    ); break;
                case 452: 
                    get_subscribers_page( // Subcribers in spam
                        '*', 'subscribers', 'sub_type=2', '', $keyword, 'id desc', 452, 'Spam',
                        'Subscribers page not found', 'subscribers', 'Return to subscribers'
                    ); break;
                default: on_page_errors('Subscribers page not found', 'subscribers', 'Return to subscribers'); break;
            }
        }
    } // End subscribers_page()


    // =================================================
    //
    // BAHESIAN SECTION

    /*function reducing_balance($principal, $interestRate, $loanTermMonths){
        $monthInterestRate = $interestRate / 100 / 12;
        $monthlyPayment = ($principal * $monthInterestRate * pow(1 + $monthInterestRate, $loanTermMonths)) / (pow(1 + $monthInterestRate, $loanTermMonths) - 1);

        $balance = $principal;

        for($month = 1; $month <= $loanTermMonths; $month++){
            $interest_payment = $balance * $monthInterestRate;
            $pri_payment = $monthlyPayment - $interest_payment;
            $balance -= $pri_payment;

            echo '<p>Month: ' . $month . ' EMI: <span style="background: #67f167">' . round($monthlyPayment) . '</span> Interest: <span style="background: #67f167">' . round($interest_payment) . '</span> Principal: <span style="background: #67f167">' . round($pri_payment) . '</span></p><br>';
        }
    }*/

    // Get bahesian page header add-on
    // Top most header info here
    if (! function_exists('get_bahesian_page_addon')){
        function get_bahesian_page_addon($crud){ 
            ?><div class="manage-user-header-3">
                <div class="div-title"> 
                    <h4 class="card-title"><?php

                    switch ($crud) {
                        case 453: echo 'Bahesian'; break;
                        default: echo 'Bahesian'; break;
                    }

                    // $values = 123; $length = 1;

                    // echo '<br>' . generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' .
                    // generate_custom_code($values, $length) . '<br>' ;
                    
                    ?></h4> 
                    
                </div><?php 
                alert_message(); 
            ?></div><?php
        }
    } // End get_bahesian_page_addon()
    

    // subscribers header
    // subscribers navigation
    if ( ! function_exists('get_bahesian_header')) {
        function get_bahesian_header($page){ 
            include('includes/modal.php'); ?>

            <div class="headerr">
                <a href="#addbahesian" data-toggle="modal" class="btn btn-primary btn-sm">Add Units</a>
            </div>
            
            <?php 
       
        }
    } // End get_bahesian_header()



    // Users-col-box
    // Most of HTML for bahesian-page and content here
    if ( ! function_exists('get_bahesian')) {
        function get_bahesian($type, $table, $array, $array2, $order, $l1, $l2, $page, $reetable, $reearray, $reeorder, $crud, $postNo){ 

            $stmt = dbtable_condition($type, $table, 'WHERE '. $array .' ORDER BY '. $order .' LIMIT '. $l1 .','. 17 .'');
            
            ?><div class="col-lg-12 grid-margin stretch-card user-col-box ">
                <div class="card subscribers-card">
                    <div class="row">
                        <!-- General subscribers section -->
                        <div class="col-lg-12 card-body subscribers-col-box-1">
                            <div class="table-responsive table-hover  col-pages-box"><?php 
                        
                                $totalstmt = count_total_condition($type, $table, 'WHERE '. $array .'');
                                if ($totalstmt > 0) : 
                                ?><table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th> <i class="fa fa-sort"></i> </th>
                                            <th> BPH %</th>
                                            <th> BPD %</th>
                                            <th> BPA %</th>

                                            <th> PLH %</th>
                                            <th> PLD %</th>
                                            <th> PLA %</th>

                                            <th> CQH %</th>
                                            <th> CQD %</th>
                                            <th> CQA %</th>

                                            <th> CLH %</th>
                                            <th> CLD %</th>
                                            <th> CLA %</th>

                                            <!-- <th> PQH %</th>
                                            <th> PQD %</th>
                                            <th> PQA %</th> -->
                                        </tr>
                                    </thead>
                                    <tbody><?php $no = 0;

                                        foreach ($stmt as $pro) : $no++;

                                        // Home
                                        $prio_prob = $pro['prio'];
                                        $odds = $pro['odds'];
                                        $current_f = $pro['currentf'];
                                        $q_likelihood = $pro['qlike'];

                                        $likelihood = (1 / $odds);

                                        if($prio_prob == 0) { $prio_prob = $likelihood; }

                                        // Bahesian
                                        // $value11 = ($prio_prob * $likelihood * $current_f) / ($prio_prob * $likelihood * $current_f + (1 - $prio_prob) * (1 - $likelihood) * (1 - $current_f));

                                        // Bahesian
                                        $value1 = ($prio_prob * $likelihood) / ($prio_prob * $likelihood + (1 - $prio_prob) * (1 - $likelihood));
                                        // Bahesian ext 2
                                        $value2 = ($current_f * $q_likelihood) / ($current_f * $q_likelihood + (1 - $current_f) * (1 - $q_likelihood));
                                        // Bahesian ext 3
                                        $value3 = ($current_f * $likelihood) / ($current_f * $likelihood + (1 - $current_f) * (1 - $likelihood));
                                        // Bahesian ext 4
                                        $value4 = ($prio_prob * $q_likelihood) / ($prio_prob * $q_likelihood + (1 - $prio_prob) * (1 - $q_likelihood));

                                        // ($value1 + $value2 + $value3 + $value4) / 4
                                        $bahesian_probability = (($value1 + $value2 + $value3 + $value4) / 4) * 100;

                                        // Draw
                                        // 
                                        $dprio_prob = $pro['dprio'];
                                        $dodds = $pro['dodds'];
                                        $dcurrent_f = $pro['dcurrentf'];
                                        $dq_likelihood = $pro['dqlike'];

                                        $dlikelihood = (1 / $dodds);

                                        if($dprio_prob == 0) { $dprio_prob = $dlikelihood; }

                                        // Bahesian
                                        // $dvalue11 = ($dprio_prob * $dlikelihood * $dcurrent_f) / ($dprio_prob * $dlikelihood * $dcurrent_f + (1 - $dprio_prob) * (1 - $dlikelihood) * (1 - $dcurrent_f));

                                        // Bahesian
                                        $dvalue1 = ($dprio_prob * $dlikelihood) / ($dprio_prob * $dlikelihood + (1 - $dprio_prob) * (1 - $dlikelihood));
                                        // Bahesian ext 2
                                        $dvalue2 = ($dcurrent_f * $dq_likelihood) / ($dcurrent_f * $dq_likelihood + (1 - $dcurrent_f) * (1 - $dq_likelihood));
                                        // Bahesian ext 3
                                        $dvalue3 = ($dcurrent_f * $dlikelihood) / ($dcurrent_f * $dlikelihood + (1 - $dcurrent_f) * (1 - $dlikelihood));
                                        // Bahesian ext 4
                                        $dvalue4 = ($dprio_prob * $dq_likelihood) / ($dprio_prob * $dq_likelihood + (1 - $dprio_prob) * (1 - $dq_likelihood));

                                        // ($dvalue1 + $dvalue2 + $dvalue3 + $dvalue4) / 4
                                        $dbahesian_probability = (($dvalue1 + $dvalue2 + $dvalue3 + $dvalue4) / 4) * 100;

                                        // Away
                                        // 
                                        $aprio_prob = $pro['aprio'];
                                        $aodds = $pro['aodds'];
                                        $acurrent_f = $pro['acurrentf'];
                                        $aq_likelihood = $pro['aqlike'];

                                        $alikelihood = (1 / $aodds);

                                        if($aprio_prob == 0) { $aprio_prob = $alikelihood; }

                                        // Bahesian
                                        // $avalue11 = ($aprio_prob * $alikelihood * $acurrent_f) / ($aprio_prob * $alikelihood * $acurrent_f + (1 - $aprio_prob) * (1 - $alikelihood) * (1 - $acurrent_f));

                                        // Bahesian
                                        $avalue1 = ($aprio_prob * $alikelihood) / ($aprio_prob * $alikelihood + (1 - $aprio_prob) * (1 - $alikelihood));
                                        // Bahesian ext 2
                                        $avalue2 = ($acurrent_f * $aq_likelihood) / ($acurrent_f * $aq_likelihood + (1 - $acurrent_f) * (1 - $aq_likelihood));
                                        // Bahesian ext 3
                                        $avalue3 = ($acurrent_f * $alikelihood) / ($acurrent_f * $alikelihood + (1 - $acurrent_f) * (1 - $alikelihood));
                                        // Bahesian ext 4
                                        $avalue4 = ($aprio_prob * $aq_likelihood) / ($aprio_prob * $aq_likelihood + (1 - $aprio_prob) * (1 - $aq_likelihood));

                                        // ($avalue1 + $avalue2 + $avalue3 + $avalue4) / 4
                                        $abahesian_probability = (($avalue1 + $avalue2 + $avalue3 + $avalue4) / 4) * 100;

                                        $bahe_array = [$bahesian_probability,$dbahesian_probability,$abahesian_probability];
                                        $greatest = max($bahe_array);

                                        $val1_array = [$value1,$dvalue1,$avalue1];
                                        $greatest2 = max($val1_array);

                                        $val2_array = [$value2,$dvalue2,$avalue2];
                                        $greatest3 = max($val2_array);

                                        $val3_array = [$value3,$dvalue3,$avalue3];
                                        $greatest4 = max($val3_array);

                                        $val4_array = [$value4,$dvalue4,$avalue4];
                                        $greatest5 = max($val4_array);

                                        ?><tr>
                                            <td><?= $no; ?></td>
                                            <td <?= ($bahesian_probability == $greatest) ? 'style="background: #67f167;"' : ''; ?>><?= str_limit($bahesian_probability, 5); ?></td>
                                            <td <?= ($dbahesian_probability == $greatest) ? 'style="background: #67f167;"' : ''; ?>><?= str_limit($dbahesian_probability, 5); ?></td>
                                            <td <?= ($abahesian_probability == $greatest) ? 'style="background: #67f167;"' : ''; ?>><?= str_limit($abahesian_probability, 5); ?></td>

                                            <td <?= ($value1 == $greatest2) ? 'style="background: #e5e7e5"' : ''; ?>><?= str_limit($value1, 5) * 100; ?></td>
                                            <td <?= ($dvalue1 == $greatest2) ? 'style="background: #e5e7e5"' : ''; ?>><?= str_limit($dvalue1, 5) * 100; ?></td>
                                            <td <?= ($avalue1 == $greatest2) ? 'style="background: #e5e7e5"' : ''; ?>><?= str_limit($avalue1, 5) * 100; ?></td>

                                            <td <?= ($value2 == $greatest3) ? 'style="background: #d5f8d5"' : ''; ?>><?= str_limit($value2, 5) * 100; ?></td>
                                            <td <?= ($dvalue2 == $greatest3) ? 'style="background: #d5f8d5"' : ''; ?>><?= str_limit($dvalue2, 5) * 100; ?></td>
                                            <td <?= ($avalue2 == $greatest3) ? 'style="background: #d5f8d5"' : ''; ?>><?= str_limit($avalue2, 5) * 100; ?></td>

                                            <td <?= ($value3 == $greatest4) ? 'style="background: #e5e7e5"' : ''; ?>><?= str_limit($value3, 5) * 100; ?></td>
                                            <td <?= ($dvalue3 == $greatest4) ? 'style="background: #e5e7e5"' : ''; ?>><?= str_limit($dvalue3, 5) * 100; ?></td>
                                            <td <?= ($avalue3 == $greatest4) ? 'style="background: #e5e7e5"' : ''; ?>><?= str_limit($avalue3, 5) * 100; ?></td>

                                            <!-- <td <?= ($value4 == $greatest5) ? 'style="background: #d5f8d5"' : ''; ?>><?= str_limit($value4, 5) * 100; ?></td>
                                            <td <?= ($dvalue4 == $greatest5) ? 'style="background: #d5f8d5"' : ''; ?>><?= str_limit($dvalue4, 5) * 100; ?></td>
                                            <td <?= ($avalue4 == $greatest5) ? 'style="background: #d5f8d5"' : ''; ?>><?= str_limit($avalue4, 5) * 100; ?></td> -->

                                        </tr><?php 
                                        endforeach;

                                    ?></tbody>
                                </table><?php
                                else : echo '<div class="col-page-box-else"> <p>Oh No! Looks empty</p> </div>'; endif;
                                        
                                // Only show pagination when the number of pages exceeds 1 e.g 2,3
                                if($totalstmt > $postNo): pagination($crud, $type,  $table, $array, $postNo); endif;  
                            ?></div>
                        </div> <!-- End General bahesian section -->
                        
                    </div>
                </div> 
            </div><!-- End user-col-box --> <?php

        }
    } // End get_bahesian()


    // Get bahesian page with...
    //--> Pagination here -- bahesian Header / subscribers-page
    // Body(users-box) and function variables
    if ( ! function_exists('get_bahesian_page')) {
        function get_bahesian_page($type, $table, $array, $array2, $keyword, $order, $crud, $card_title, $msg1, $redirect, $msg2){ ?>

            <!-- partial -->
            <div class="content-wrapper">
                <div class="row col-pages">
                    <div class="col-lg-12 grid-margin stretch-card users-pages">
                        <div class="card"> <?php

                            // page must be set
                            if (isset($_GET['page'])) : 
                                $page = $_GET['page']; 
                                if(empty($page) || $page < 1): $page = 1; endif; //<-- set default page to 1 if no page is set, to avoid errors
        
                                $tusers = count_total_condition($type, $table, 'WHERE '. $array .''); 
                                if ($page==0 || $page<1) : $page_count = 0; 
                                else : $postNo = page_item_number($type, $table, $array); $page_count = ($page*$postNo)-$postNo; endif; 
                                
                                include 'includes/modal.php';
                                ?><div class="card-body"><?php
                                
                                    get_bahesian_page_addon($crud);
                                    get_bahesian_header($crud); 
                                    get_bahesian($type, $table, $array, $array2, $order, $page_count, $postNo, $crud, 'subscribers', 'sub_type=0', 'id desc', $page, $postNo);  
                                    
                                ?></div> <!-- card-body End --> <?php 
                            else : on_page_errors($msg1, $redirect, $msg2); endif; ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends --> <?php

        }
    } // End get_bahesian_page()


    // bahesian page function for individual pages
    // bahesian Values for db and other functions can be changed from here
    // To-avoid-wasting-more-of-your-time-,-kindly-do-not-delete-any-thing-here---Gracias
    if ( ! function_exists('bahesian_page')) {
        function bahesian_page($page, $keyword){ 
            switch ($page) {
                case 450: 
                    get_bahesian_page( // Bahesian
                        '*', 'bahesian', 'type=0', '', $keyword, 'id asc', 453, 'Spam',
                        'Bahesian page not found', 'bahesian', 'Return to bahesian'
                    ); break;
                default: on_page_errors('Bahesian page not found', 'bahesian', 'Return to bahesian'); break;
            }
        }
    } // End bahesian_page()

    


    // UNIVERSAL PAGE ADD-ONS
    //
    // 
    // 

    // Pagination nav
    if ( ! function_exists('pagination')) {
        function pagination($page, $type, $table, $array, $divideBy){ 
            $base = strtok($_SERVER["REQUEST_URI"], '?'); ?>  
            <nav class="pagination-nav">
                <ul class="pagination">
                    
                    <?php //Back button
                    if (isset($page)) { if ($page>1) { ?> <li><a href="<?= $base ?>?page=<?= $page-1; ?>"> <i class="fa fa-chevron-left"></i> </a></li> 
                    <?php } } ?>
    
                    <?php //Get total pages
                    $data = count_total_condition($type, $table, 'WHERE '. $array .'');
                    $totalpages = $data/$divideBy; 
                    $totalpages = ceil($totalpages); // round up fraction to whole numbers

                    for ($i=1; $i <= $totalpages ; $i++) { 

                    if (isset($page)) { if ($i==$page) { ?>
                    <li><a class="active" href="<?= $base ?>?page=<?= $i; ?>"> <?= $i; ?> </a></li>
                    <?php } else { ?>
                    <li><a href="<?= $base ?>?page=<?= $i; ?>"> <?= $i; ?> </a></li>
                    <?php } } }  //End For loop ?>

                    <!-- forward button -->
                    <?php if (isset($page)) { if ($page+1<=$totalpages) { ?> <li><a href="<?= $base ?>?page=<?= $page+1; ?>"> <i class="fa fa-chevron-right"></i> </a></li> 
                    <?php } } ?>

                </ul>
            </nav> <?php
        }
    }

    // Default Function to control number of items per page
    if ( ! function_exists('page_item_number')) {
        function page_item_number($type, $table, $array){

            $count = count_total_condition($type, $table, 'WHERE '. $array .'');

            if ($count < 80) : $postNo = 12; 

            elseif ($count > 80) : $postNo = 15; endif;
            
            return $postNo;
        }
    }

    // Sample modal function. 
    // Can be re-used
    if ( ! function_exists('get_modal')) {
        function get_modal($href, $action, $msg, $btnname){ ?>
            <div class="modal fade" id="<?= $href; ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?= $action; ?> </h5>
                            <button type="button" data-dismiss="modal" class="close" aria-label="close">
                                <span arial-hidden="true"></span> &times;
                            </button>
                        </div>
                            <div class="modal-body">
                                Are you sure you want to <?= $msg; ?>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary btn-sm " type="submit" name="<?= $href; ?>"><?= $btnname; ?></button>
                                <button class="btn btn-default btn-sm" type="button" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <?php
        }
    }
    
    // ===================================================================================
    //
    // SPECIFIC FUNCTIONS
    //
    //

    // on_page_errors
    if ( ! function_exists('on_page_errors')) {
        function on_page_errors($title, $page, $message){
            echo ' 
                <div style="" class="container not-set">
                    <div style="" class="row all-post">
                        <div class="col-lg-12 grid-margin">
                            <div class="card post-card">
                                <div class="card-body">
                                    <h3>'. $title .'</h3>
                                    <img src="images/file-icons/256/008-archive.png" alt="png-image-for-not-set">
                                    <br>
                                    <a class="btn btn-primary btn-sm" href="'. $page .'.php?page=1"> >> '. $message .'</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
    }

    // Progress Bar
    if ( ! function_exists('progress_bar')){
        function progress_bar($data1, $span){ 

            // Get values for determination of %'s
            $data1;
            $count1 = count($data1);
            $count2 = count(array_filter($data1));

            $count3 = $count1-$count2;

            $span = ($count3 == 0) ? 'complete' : $span;

            if ($count3 == 0) : $bg = 'bg-success'; $style = '100%'; $value = '100';
            elseif ($count3 <= 2) :  $bg = 'bg-primary'; $style = '80%'; $value = '80';
            elseif ($count3 > 2 && $count3 <= 4) :  $bg = 'bg-info'; $style = '60%'; $value = '60';
            elseif ($count3 > 4 && $count3 <= 6) :  $bg = 'bg-warning'; $style = '40%'; $value = '40';
            elseif ($count3 > 6 && $count3 <= 9) :  $bg = 'bg-danger'; $style = '20%'; $value = '20'; endif;

            echo '
                <div class="progress">
                <div class="progress-bar '. $bg .'" role="progressbar" style="width: '. $style .'" aria-valuenow="'. $value .'" aria-valuemin="0" aria-valuemax="100"><span style="color: #fff; font-size: .6em; padding-left: 5px">'. $span .'</span></div>
                </div>
            ';
        }
    }

    // User levels
    if ( ! function_exists('get_user_level_type')){
        function get_user_level_type($data){ 

            if     ($data == 0) : echo 'User';
            elseif ($data == 1) : echo 'Super Admin';
            elseif ($data == 2) : echo 'Manager';
            elseif ($data == 3) : echo 'Administrator';
            elseif ($data == 4) : echo 'Editor';
            elseif ($data == 5) : echo 'Contributor';
            elseif ($data == 6) : echo 'Author'; endif;
        }
    }

    //Get user info
    if ( ! function_exists('user_info')) {
        function user_info($column, $info){
            if (!empty($column)) { echo $column; } else { echo $info; }
        }  
    }

    // Back button
    if ( ! function_exists('back_button')){
        function back_button($redirect, $where){ 
            echo '
            <div class="col-lg-12 stretch-card back-button">
                <div class="back">
                    <a class="back-ref" href="'. $redirect .'"><i style="font-size: .8em;" class="fa fa-arrow-left"></i>&nbsp;'. $where .'</a>
                </div>
            </div>';
        }
    }

    // String limit function
    if ( ! function_exists('str_limit')) {
        function str_limit($variable, $str_length){
            if (strlen($variable)>$str_length) { $variable = substr($variable,0,$str_length); } 
            return $variable;
        }
    }

    // Set active class
    // Works well
    // Array prevents limitation of usage-- in case more than one link is provided
    if ( ! function_exists('active_class')) {
        function active_class($array){
            $url_parts = parse_url($_SERVER['REQUEST_URI']);
            $path = $url_parts['path'];

            $base_name = basename($path);
            foreach ($array as $link) {
                if ($base_name == $link) {
                    echo 'active-class';
                }
            }
        }
    }

    // Generate code
    if ( ! function_exists('generate_code')) {
        function generate_code(){
            $set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $code=substr(str_shuffle($set), 0, 12);
            return $code;
        }  
    }

    // Generate custom code
    if ( ! function_exists('generate_custom_code')) {
        function generate_custom_code($values, $length){
            $set= $values;
            $code=substr(str_shuffle($set), 0, $length);
            return $code;
        }  
    }

    // Generate ID
    if ( ! function_exists('generate_id')) {
        function generate_id(){
            $set='123456789FLE';
            $code=substr(str_shuffle($set), 0, 12);
            return $code;
        }  
    }
    

    function bahesian_all($prio_prob, $odds, $current_f, $q_likelihood){
        $likelihood = (1 / $odds);

        if($prio_prob == 0) { $prio_prob = $likelihood; }

        // Bahesian
        $value1 = ($prio_prob * $likelihood) / ($prio_prob * $likelihood + (1 - $prio_prob) * (1 - $likelihood));
        // Bahesian ext 2
        $value2 = ($current_f * $q_likelihood) / ($current_f * $q_likelihood + (1 - $current_f) * (1 - $q_likelihood));
        // Bahesian ext 3
        $value3 = ($current_f * $likelihood) / ($current_f * $likelihood + (1 - $current_f) * (1 - $likelihood));
        // Bahesian ext 4
        $value4 = ($prio_prob * $q_likelihood) / ($prio_prob * $q_likelihood + (1 - $prio_prob) * (1 - $q_likelihood));

        $bahesian_probability = (($value1 + $value2 + $value3 + $value4) / 4) * 100;

        // $bahesian_probability = ($prio_prob * $likelihood) / ($prio_prob * $likelihood + (1 - $prio_prob) * (1 - $likelihood));

        echo 'BP = ' . $bahesian_probability . '%  <br>BV1 = ' . $value1 * 100 .  '  <br>BV2 = ' . $value2 * 100 .  '  <br>BV3 = ' . $value3 * 100 .  '  <br>BV4 = ' . $value4 * 100 . '<br><br>';
    }

    //Set class for tags
    // if ( ! function_exists('set_class')) {
    //     function set_class($class){

    //     }
    // }


