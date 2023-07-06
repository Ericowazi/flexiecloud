<!-- POSTS MODALS -->

<!-- Move to trash checkbox modal -->
<div class="modal fade" id="movetotrash">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">MOVING TO TRASH... </h5>
                <button type="button" data-dismiss="modal" class="close" aria-label="close">
                    <span arial-hidden="true"></span> &times;
                </button>
            </div>
                <div class="modal-body">
                    Are you sure you want to move post/s to trash?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm " type="submit" name="movetotrash">Move to trash</button>
                    <button class="btn btn-default btn-sm" type="button" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                </div>
        </div>
    </div>
</div>

<!-- Delete post checkbox modal -->
<div class="modal fade" id="ptmultidelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DELETING... </h5>
                <button type="button" data-dismiss="modal" class="close" aria-label="close">
                    <span arial-hidden="true"></span> &times;
                </button>
            </div> 
                <div class="modal-body"> 
                    Are you sure you want to delete seleted posts?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm " type="submit" name="tmultidelete">Delete Now</button>
                    <button class="btn btn-default btn-sm" type="button" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                </div>
        </div>
    </div>
</div>
<!--  -->



<!-- COMMENTS MODALS 
====
====
-->

<!-- Delete comments checkbox modal on comments_mine -->
<div class="modal fade" id="replydelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DELETING... </h5>
                <button type="button" data-dismiss="modal" class="close" aria-label="close">
                    <span arial-hidden="true"></span> &times;
                </button>
            </div>
                <div class="modal-body">
                    Are you sure you want to delete selected replies?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm " type="submit" name="replydelete">Delete Now</button>
                    <button class="btn btn-default btn-sm" type="button" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                </div>
        </div>
    </div>
</div>

<!-- Delete comments checkbox modal on comments_trash_can -->
<div class="modal fade" id="multidelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DELETING... </h5>
                <button type="button" data-dismiss="modal" class="close" aria-label="close">
                    <span arial-hidden="true"></span> &times;
                </button>
            </div>
                <div class="modal-body">
                    Are you sure you want to delete selected comments?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm " type="submit" name="multidelete">Delete Now</button>
                    <button class="btn btn-default btn-sm" type="button" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                </div>
        </div>
    </div>
</div>

<!-- Delete comments checkbox modal on comments_trash_can -->
<div class="modal fade" id="singledelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DELETING... </h5>
                <button type="button" data-dismiss="modal" class="close" aria-label="close">
                    <span arial-hidden="true"></span> &times;
                </button>
            </div>
                <div class="modal-body">
                    Are you sure you want to delete?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm " type="submit" name="singledelete">Delete Now</button>
                    <button class="btn btn-default btn-sm" type="button" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                </div>
        </div>
    </div>
</div>

<!-- Delete comments checkbox modal on comments_trash_can -->
<div class="modal fade" id="singleminedelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DELETING... </h5>
                <button type="button" data-dismiss="modal" class="close" aria-label="close">
                    <span arial-hidden="true"></span> &times;
                </button>
            </div>
                <div class="modal-body">
                    Are you sure you want to delete reply?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm " type="submit" name="singleminedelete">Delete Now</button>
                    <button class="btn btn-default btn-sm" type="button" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                </div>
        </div>
    </div>
</div>


<!-- PROFILE MODAL 
====
====
-->

<!-- Image upload modal -->
<div class="modal fade" id="imageupload">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Choose featured image</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="file" name="image" id="photo" value="" accept=".jpg, .jpeg, .png"> 
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm" type="button" name="upload" id="photo" data-dismiss="modal">Done</button>
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="ti-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<!-- USERS MODALS
====
====
-->

 
<div class="modal fade" id="usersadduser">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Basic form elements</h4>
                        <p class="card-description">Basic form elements </p>
                        <form class="forms-sample">
                            <div class="form-group">
                                <label for="exampleInputName1">Name</label>
                                <input type="text" class="form-control" id="exampleInputName1" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail3">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword4">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword4" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="exampleSelectGender">Gender</label>
                                <select class="form-control" id="exampleSelectGender">
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>File upload</label>
                                <input type="file" name="img[]" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                    <span class="input-group-append">
                                        <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputCity1">City</label>
                                <input type="text" class="form-control" id="exampleInputCity1" placeholder="Location">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea1">Textarea</label>
                                <textarea class="form-control" id="exampleTextarea1" rows="4"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- SUBSCRIBERS PAGE 
==
==

-->

<!-- Move to trash checkbox modal -->
<div class="modal fade" id="addnewsubscriber">
    <div class="modal-dialog">
      <form action="subscribers_crud.php" method="post">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Add Subscriber </h5>
                  <button type="button" data-dismiss="modal" class="close" aria-label="close">
                      <span arial-hidden="true"></span> &times;
                  </button>
              </div>
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="exampleInputCity1">Email*</label>
                          <input type="email" class="form-control" id="exampleInputCity1" name="email" placeholder="Enter Email here" required>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button class="btn btn-primary btn-sm " type="submit" name="addnewsubscriber">Submit</button>
                      <button class="btn btn-default btn-sm" type="button" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                  </div>
          </div>
      </form>
    </div>
</div>


<!-- GALLERY PAGE 
==
==

-->

<!-- Move to trash checkbox modal -->
<div class="modal fade" id="addnewphoto">
    <div class="modal-dialog">
        <form action="gallery_crud.php" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Upload Photo </h5>
                  <button type="button" data-dismiss="modal" class="close" aria-label="close">
                      <span arial-hidden="true"></span> &times;
                  </button>
                </div>
                    <div class="modal-body">
                        <!-- <div class="form-group">
                            <label>File upload</label>
                            <input type="file" name="image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Choose</button>
                                </span>
                            </div>
                        </div> -->
                        <input type="file" name="image" id="photo" value="" accept=".jpg, .jpeg, .png">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm " type="submit" name="uploadphoto">Upload</button>
                        <button class="btn btn-default btn-sm" type="button" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                    </div>
            </div>
        </form>
    </div>
</div>


<!-- GALLERY PAGE 
==
==

-->

<!-- Move to trash checkbox modal -->
<div class="modal fade" id="addbahesian">
    <div class="modal-dialog">
        <form action="subscribers_crud.php" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add Units </h5>
                  <button type="button" data-dismiss="modal" class="close" aria-label="close">
                      <span arial-hidden="true"></span> &times;
                  </button>
                </div>
                    <div class="modal-body">
                        <div class="bahesian">
                            <div class="table table-responsive">
                                <table style=";">
                                    <tbody style="">
                                        <tr style="">
                                            <td style=" padding: 5px !important;">
                                                <input type="text" class="form-control form-control-sm" name="prio" placeholder="Prior">
                                            </td>
                                            <td style=" padding: 5px !important;">
                                                <input type="text" class="form-control form-control-sm" name="odds" placeholder="Odds">
                                            </td>
                                            <td style=" padding: 5px !important;">
                                                <input type="text" class="form-control form-control-sm" name="currentf" placeholder="CF">
                                            </td>
                                            <td style=" padding: 5px !important;">
                                                <input type="text" class="form-control form-control-sm" name="qlike" placeholder="qlike">
                                            </td>
                                        </tr>
                                        <tr style="">
                                            <td style=" padding: 5px !important;">
                                                <input type="text" class="form-control form-control-sm" name="dprio" placeholder="Prior">
                                            </td>
                                            <td style=" padding: 5px !important;">
                                                <input type="text" class="form-control form-control-sm" name="dodds" placeholder="Odds">
                                            </td>
                                            <td style=" padding: 5px !important;">
                                                <input type="text" class="form-control form-control-sm" name="dcurrentf" placeholder="CF">
                                            </td>
                                            <td style=" padding: 5px !important;">
                                                <input type="text" class="form-control form-control-sm" name="dqlike" placeholder="qlike">
                                            </td>
                                        </tr>
                                        <tr style="">
                                            <td style=" padding: 5px !important;">
                                                <input type="text" class="form-control form-control-sm" name="aprio" placeholder="Prior">
                                            </td>
                                            <td style=" padding: 5px !important;">
                                                <input type="text" class="form-control form-control-sm" name="aodds" placeholder="Odds">
                                            </td>
                                            <td style=" padding: 5px !important;">
                                                <input type="text" class="form-control form-control-sm" name="acurrentf" placeholder="CF">
                                            </td>
                                            <td style=" padding: 5px !important;">
                                                <input type="text" class="form-control form-control-sm" name="aqlike" placeholder="qlike">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-sm " type="submit" name="addbahesian">Submit</button>
                        <button class="btn btn-default btn-sm" type="button" data-dismiss="modal"><i class="ti-close"></i> Close</button>
                    </div>
            </div>
        </form>
    </div>
</div>

