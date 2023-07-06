<!-- partial -->
<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= active_class(['offences.php','category-edit.php','category-view.php']); ?>" 
                href="offences.php">
                <i class="icon-grid-2 menu-icon"></i><span class="menu-title">Offences</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= active_class(['category-add.php','category-edit.php','category-view.php']); ?>" 
                href="category-all.php?page=1">
                <i class="icon-grid-2 menu-icon"></i><span class="menu-title">Category</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link 
                <?= active_class(['posts-published-filter.php','posts-draft-filter.php','posts-trash-filter.php']); ?>" 
                data-toggle="collapse" href="#posts" aria-expanded="false" aria-controls="posts">
                <i class="fa fa-newspaper-o menu-icon"></i>
                    <span class="menu-title">Blog Posts</span>
                <i class="menu-arrow menu-icon"></i> 
            </a>
            <div class="collapse" id="posts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="posts-published.php?page=1">Published</a></li>
                    <li class="nav-item"> <a class="nav-link" href="posts-draft.php?page=1">Draft</a></li>
                    <li class="nav-item"> <a class="nav-link" href="posts-trash.php?page=1">Trash</a></li>
                    <li class="nav-item"> <a class="nav-link" href="post-add.php">Add New</a></li>
                </ul>
            </div> 
        </li> 
        <li class="nav-item"><?php 
            // Check for number of un-approved comments
            $unapproved = count_total_w('*', 'comments', 'comment_status', 0); 
            $uncom = ($unapproved > 0) ? '<label class="comments-nav-link">'. $unapproved .'</label>' : '';?>
            <a class="nav-link" data-toggle="collapse" href="#comments" aria-expanded="false" aria-controls="comments">
                <i class="fa fa-comments menu-icon"></i>
                    <span class="menu-title">Comments&nbsp;<?= $uncom; ?></span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="comments">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="comments_unapproved.php?page=1">Unapproved&nbsp;<?= $uncom; ?></a></li>
                    <li class="nav-item"> <a class="nav-link" href="comments_approved.php?page=1">Approved</a></li>
                    <li class="nav-item"> <a class="nav-link" href="comments_mine.php?page=1">Mine</a></li>
                    <li class="nav-item"> <a class="nav-link" href="comments_trash_can.php?page=1">Trash</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="gallery.php?page=1">
                <i class="icon-image menu-icon"></i>
                <span class="menu-title">Gallery</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= active_class(['users_trash.php']); ?>" data-toggle="collapse" href="#users" aria-expanded="false" aria-controls="users">
                <i class="icon-head menu-icon"></i>
                    <span class="menu-title">Users</span>
                <i class="menu-arrow menu-icon"></i>
            </a>
            <div class="collapse" id="users">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="users.php?page=1">All Users</a></li>
                    <li class="nav-item"> <a class="nav-link" href="users-active.php?page=1">Active</a></li>
                    <li class="nav-item"> <a class="nav-link" href="users-inactive.php?page=1">Inactive</a></li>
                    <li class="nav-item"> <a class="nav-link" href="users-admins.php?page=1">Admins</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= active_class(['subscribers-spam.php','subscribers-trash.php']); ?>" 
                href="subscribers.php?page=1">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Subscribers</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="newsletters.php?page=1">
                <i class="icon-mail menu-icon"></i>
                <span class="menu-title">Newsletters</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="bahesian.php?page=1">
                <i class="icon-bar-graph menu-icon"></i>
                <span class="menu-title">Bahesian</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basicc" aria-expanded="false" aria-controls="ui-basicc">
                <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">UI Elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basicc">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="icon-columns menu-icon"></i>
                    <span class="menu-title">Form elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Basic Elements</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="icon-bar-graph menu-icon"></i>
                    <span class="menu-title">Charts</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/charts/chartjs.html">ChartJs</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="icon-grid-2 menu-icon"></i>
                    <span class="menu-title">Tables</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/tables/basic-table.html">Basic table</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="icon-contract menu-icon"></i>
                    <span class="menu-title">Icons</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/icons/mdi.html">Mdi icons</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="icon-head menu-icon"></i>
                    <span class="menu-title">User Pages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
                <i class="icon-ban menu-icon"></i>
                    <span class="menu-title">Error pages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="pages/documentation/documentation.html">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Documentation</span>
            </a>
        </li>
    </ul>
</nav>

<!-- partial -->
<div class="main-panel">

