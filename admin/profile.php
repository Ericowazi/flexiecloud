<?php include('../includes/session.php'); ?>
<?php include('includes/navbar.php'); ?>
<div class="container rounded bg-profile">
    
    <div class="row main-profile">
        <div class="col-md-12">
            <?php alert_message(); ?>
        </div>
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <div><img class="rounded-circle" src="<?php echo $img; ?>"></div>
                <div class="profile-photo"><a class="btn btn-inverse-primary btn-sm btn-flat" data-toggle="modal" href="#photo">Upload photo</a></div>
                <span class="font-weight-bold"><?php user_info($row['username'], ''); ?></span>
                <span class="text-black-50"><?php  user_info($row['email'], ''); ?></span>
                <span class="text-black-50">ID: <?php  user_info($row['activation_key'], ''); ?><?php ?></span>
                <a href="edit-profile.php?profile=<?php echo  $row['id']; ?>"><button class="btn btn-primary btn-sm" type="button">Edit Profile</button></a> 
            </div>
        </div>
        <div class="col-md-9 md-9">
            <div class="p-3 py-5">
                <div class="d-flex flex-row exp-container form-group">
                    <p class="bio-p">BIO / EXPERIENCE <i class="icon-arrow-down"></i> <br><br><?php user_info($row['bio'],"Edit profile to add bio..."); ?></p>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6"><input type="text" class="form-control form-control-sm tete" disabled placeholder="Role: <?php get_user_level_type($row['user_level']) ?>" value=""></div>
                    <div class="col-md-6"><a href="#changePassword" data-toggle="modal"><label class="edit-pwd" for=""><i class="ti-pencil"></i> Change password</label></a></div>
                </div>
                <div class="row"> 
                    <div class="col-md-6"><input type="text" class="form-control  form-control-sm" disabled value="Name: <?php user_info($row['firstName'], '---'); ?>"></div>
                    <div class="col-md-6"><input type="text" class="form-control form-control-sm" disabled value="Surname: <?php user_info($row['secondName'], '---'); ?>"></div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6"><input type="email" class="form-control form-control-sm tete" disabled  value="Email: <?php user_info($row['email'], '---'); ?>"></div>
                    <div class="col-md-6"><input type="tel" class="form-control form-control-sm" disabled value="Phone: <?php user_info($row['phone'], '---'); ?>"></div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6"><input type="text" class="form-control form-control-sm" disabled value="Country: <?php user_info($row['country'], '---'); ?>"></div>
                    <div class="col-md-6"><input type="text" class="form-control form-control-sm" disabled value="City: <?php user_info($row['city'], '---'); ?>"></div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>

<!-- Upload New Profile -->
<div class="modal fade" id="photo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Upload New Profile Photo</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="user_photo.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                    <input type="file" name="image" id="photo" value="" accept=".jpg, .jpeg, .png"> 
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm" type="submit" name="upload" id="photo">Upload Photo</button>
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="ti-close"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password -->
<div class="modal fade password" id="changePassword">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Change Password</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="repassword.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                    <input type="password" class="form-control form-control-sm" name="oldPassword" id="oldPassword" value="" required placeholder="Enter Old Password"> 
                    <br>
                    <input type="password" class="form-control form-control-sm" name="newPassword" id="newPassword" value="" required placeholder="Enter New Password"> 
                    <br>
                    <input type="password" class="form-control form-control-sm" name="rePassword" id="rePassword" value="" required placeholder="Repeat New Password"> 
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm" type="submit" name="password" id="photo">Update Password</button>
              <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer_content.php'); ?>

