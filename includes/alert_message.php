<?php
  if(isset($_SESSION['error'])){
    echo '
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <span><i class="ti-alert"></i>Error</span>
        <p>'.$_SESSION['error'].'</p>
      </div>
    ';  
    unset($_SESSION['error']); 
  }

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