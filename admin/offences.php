<?php
include('../../includes/session.php');
include('includes/navbar.php'); 
?>
<!-- partial -->
<div class="content-wrapper">
    <div class="row col-pages">
        <div class="col-lg-12 grid-margin stretch-card users-pages">
            <div class="card">

            
     <div class="offence-wrapper">
          <div class="header">
               <h4 class="page-header">Offences <i class="fa fa-chevron-circle-down"></i></h4>
          </div>
          <div class="container">
               <div class="row">
                    <div class="offence-holder col-sm-12">
                         <div class="box-header with-border">
                              <a href="addoffence.php" class="btn btn-sm btn-flat"><i class="fa fa-plus"></i>&nbsp;Add Offence</a>
                         </div>
                         <?php //include '../includes/alert-message.php'; ?>
                         <?php //get all offences
                            //   $sql = "SELECT * FROM offences ORDER BY id desc";
                            //   $query = mysqli_query($conn, $sql);
                            //   if (mysqli_num_rows($query)>0) { 
                            //        $offence_num = 0;
                         ?>
                         <div class="offences">
                              <?php  
                            //   while ($row = mysqli_fetch_array($query)) { //iterate
                            //             $offence_num++;
                              ?>
                              <!-- <form action="delete_offence.php?Delete=<?php //echo $row['id']; ?>" method="post"> -->
                              <div class="card-group" id="accordion">
                                   <div class="card card-primary">
                                        <div class="card-heading">
                                             <a data-toggle="collapse" data-parent="#accordion" href="#menu<?php //echo $offence_num; ?>">        
                                                  <p class="card-title"><span> Offence&nbsp;<?php //echo $offence_num; ?>:<br> </span></p>
                                                  <p class="card-title-2"><?php //echo strip_tags($row['description']); ?></p>
                                             </a>
                                        </div>
                                        <div id="menu<?php //echo $offence_num; ?>" class="card-collapse collapse in">
                                             <div class="card-body">
                                                  <div class="form-group">
                                                       <label class="title" for="penalty">Penalty</label>
                                                       <p><?php  //echo strip_tags($row['penalty']); ?></p>
                                                  </div>
                                                  <div class="form-group">
                                                       <label for="provision">Full Provision </label>
                                                       <p><?php  //echo strip_tags($row['full_provision']); ?></p>
                                                  </div>
                                                  <?php //$offence_id = $row['id']; //get all cases for that specific offence
                                                    //    $case_sql = "SELECT * FROM cases WHERE offence_id='$offence_id' ORDER BY id desc";
                                                    //    $case_query = mysqli_query($conn, $case_sql);
                                                    //    if (mysqli_num_rows($case_query)>0) {
                                                    //         $case_num = 0;
                                                  ?>
                                                  <div class="form-group">
                                                       <label for="provision">Related Cases&nbsp;<i class="fa fa-chevron-circle-down"></i> </label><br><hr>
                                                       <?php //while ($case_row = mysqli_fetch_array($case_query)) { $limit=200; $case_num++;
                                                       ?>
                                                       <label for="provision">Case&nbsp;<?php //echo $case_num; ?>: </label>
                                                       <p>  <?php //str_limit($case_row['title'], $limit); ?><a href="viewcase.php?Case=<?php //echo $case_row['id']; ?>">read more >></a>
                                                       </p>
                                                       <?php //} //End while statement for case?>
                                                  </div>
                                                  <?php //} //End if statement for case?>
                                             </div>
                                             <div class="card-footer">
                                                  <a class="btn btn-sm" href="#">Tools&nbsp;<i class="fa fa-sort"></i> </a>
                                                  <a class="btn btn-primary btn-sm pull-right" href="addcase.php?Offence=<?php //echo $row['id']; ?>"> <i class="fa fa-plus"></i> ADD CASE</a>
                                                  <a class="btn btn-primary btn-sm pull-right" href="editoffence.php?Edit=<?php //echo $row['id']; ?>">Edit</a>
                                                  <?php //if ($role == 1 || $role == 2) //{ ?><a class="btn btn-danger btn-sm pull-right" href="delete-offence.php?Delete=<?php //echo $row['id']; ?>">Delete</a><?php //} //End if for role?>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <?php //} //End while?>
                         </div>
                         <!-- </form> -->
                         <?php //} //End if statement ?>
                    </div>
               </div> <!-- End Row -->
          </div> <!-- End Container -->
     </div> <!-- End Offence-wrapper -->
                            
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->