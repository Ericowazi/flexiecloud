<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin</title>
  <!-- plugins:css -->
  
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="js/select.dataTables.min.css"> 
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="profile.css">
  <link rel="stylesheet" href="category.css">
  <link rel="stylesheet" href="post.css">
  <link rel="stylesheet" href="comment.css">
  <link rel="stylesheet" href="users.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.ico" />
  <!-- inject:js -->
  <script src="vendors/tinymce/tinymce.min.js"></script>
  <script src="vendors/ckeditor/ckeditor.js"></script> 
  <script>
    tinymce.init({
      selector: '#TextArea',
    });
  </script>

  
  <!-- Setting different header links for different pages -->
  <?php if ($linkrel == 1) { ?>
  <link rel="stylesheet" href="admin/vendors/feather/feather.css">
  <link rel="stylesheet" href="admin/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="admin/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->

  <!-- inject:css -->
  <link rel="stylesheet" href="admin/css/vertical-layout-light/style.css">
  <link rel="stylesheet" href="admin/post.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="admin/images/favicon.png" />
  <?php } ?>
</head>
<body>