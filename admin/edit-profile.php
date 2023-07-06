<?php include('../includes/session.php'); ?>
<?php include('includes/navbar.php');?>
<div class="container rounded bg-profile">
    <div class="row edit-profile">
        <div class="col-md-12">
            <?php alert_message(); ?>
        </div>
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <img class="rounded-circle" src="<?php echo $img; ?>">
                <span class="font-weight-bold"><?php user_info($row['username'], ''); ?></span>
                <span class="text-black-50"><?php user_info($row['email'], ''); ?></span>
                <span class="text-black-50">ID: <?php user_info($row['activation_key'], ''); ?><?php ?></span>
            </div>
        </div>
        <div class="col-md-9 md-9">
            <form action="profile_update.php?profile=<?php echo $row['id']; ?>" method="post" enctype="multipart/form-data">
                <div class="p-3 py-5">
                    <?php alert_message(); ?>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-right">Edit your profile <i class="icon-arrow-down"></i></h6>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Name</label><input type="text" class="form-control  form-control-sm" name="Firstname" placeholder="First name" value="<?php user_info($row['firstName'], ''); ?>" required></div>
                        <div class="col-md-6"><label class="labels">Surname</label><input type="text" class="form-control form-control-sm" name="Secondname" placeholder="Last name" value="<?php user_info($row['secondName'], ''); ?>" required></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Role</label><input type="text" class="form-control form-control-sm" name="" disabled placeholder="Administrator" value=""></div>
                        <div class="col-md-6"><label class="labels">Phone</label><input type="text" class="form-control form-control-sm" name="Phone" placeholder="+1 234 567 789" value="<?php user_info($row['phone'], ''); ?>" required></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Country</label><input type="text" class="form-control form-control-sm" name="Country" placeholder="Country" value="<?php user_info($row['country'], ''); ?>" required></div>
                        <div class="col-md-6"><label class="labels">City</label><input type="text" class="form-control form-control-sm" name="City" placeholder="City" value="<?php user_info($row['city'], ''); ?>" required></div>
                    </div>
                    <br>
                    <div class=""><span><span class="border px-3 p-1 add-experience"><i class="icon-plus"></i>&nbsp;Bio&nbsp;/&nbsp;Experience</i></span></div>
                    <div class="d-flex flex-row mt-3 exp-container form-group">
                        <textarea type="text" class="form-control" name="Bio" id="bio" cols="30" rows="10" placeholder="Enter Bio Here" required><?php user_info($row['bio'], ''); ?></textarea>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-primary" type="submit" name="profile">Update</button> 
                        <a href="profile.php?profile=<?php echo $row['id']; ?>"><button class="btn btn-outline-dark" type="button">Cancel</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer_content.php'); ?>

