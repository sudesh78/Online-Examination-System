
<style>
    .text-center {
        text-align: center;
    }

    .si {
        font-size: 1.2rem;
        font-weight: bold;
        height: 2rem;
    }

    .ri {
        padding: 8px 0;
        font-size: 17px;
    }

    .form-div {
        margin-top: 100px;
        border: 1px solid #e0e0e0;
    }

    #profileDisplay,
    #profileDis,
    #profildisplay,
    #profiledis {
        display: block;
        height: 210px;
        width: 60%;
        margin: 0px auto;
        border-radius: 50%;
    }

    .img-placeholder {
        width: 60%;
        color: white;
        height: 100%;
        background: black;
        opacity: .7;
        height: 210px;
        border-radius: 50%;
        z-index: 2;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        display: none;
    }

    .img-placeholder h4 {
        margin-top: 40%;
        color: white;
    }

    .img-div:hover .img-placeholder {
        display: block;
        cursor: pointer;
    }

    .container1 {

        position: relative;
        width: calc(100% - 200px);
        left: 200px;
        top: 0;

    }
</style>
<div class="container" style="position: relative;">
    <div class="container-fluid" style="width:100%;">
        <div class="col-lg-12" style="top:10px;">
            <div class="row mb-4 mt-4">
                <div class="pad-botm">
                    <span class="las la-igloo"></span>
                    <h4 class="header-line">Members<span class="timeset" id='ct'></span> <span class="header-underline"></span></h4>
                </div>
            </div>
            <div class="row">
                <?php if ($_SESSION['status'] != "") { ?>
                    <div class="col-md-6">
                        <div class="alert alert-danger">
                            <strong>Status :</strong>
                            <?php echo htmlentities($_SESSION['status']); ?>
                            <?php echo htmlentities($_SESSION['status'] = ""); ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <b>List of Members</b>
                            <span style="float:right"><a class="btn btn-primary float-right btn-sm" data-target="#new--member" data-toggle="modal">
                                    <i class="fa fa-plus">Add Member</i>
                                </a></span>
                        </div>
                        <div class="card-body" style="overflow-x: auto">
                            <table cellpadding="0" cellspacing="0" border="2" class="table table-striped table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center si">M_Id</th>
                                        <th class="text-center si">Photo</th>
                                        <th class="text-center si ">Name</th>
                                        <th class="text-center si">Email</th>
                                        <th class="text-center si">Mobile No.</th>
                                        <th class="text-center si">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $users = $conn->query("SELECT * FROM admin order by memberid");
                                    while ($row = $users->fetch_assoc()) :
                                    ?>
                                        <tr class="text-center">
                                            <td class="ri">
                                                <?php echo $row['memberid'] ?>
                                            </td>
                                            <td class="ri">
                                                <img src="<?php echo ucwords($row['photo']) ?>" width="100px" height="100px" style="border:1px solid #333333;">
                                            </td>
                                            <td class="ri">
                                                <?php echo ucwords($row['name']) ?>
                                            </td>

                                            <td class="ri">
                                                <?php echo $row['emailid'] ?>
                                            </td>
                                            <td class="ri">
                                                <?php echo $row['mobileno'] ?>
                                            </td>

                                            <td class="ri">
                                                <button class="btn btn-sm btn-info edit_member" data-id="<?php echo $row['memberid'] ?>" type="button"> Edit </button>
                                                <button class="btn btn-sm btn-danger delete_member" type="button" data-toggle="modal" data-target="#deletemodal" data-id="<?php echo $row['memberid'] ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ########################################### New Account ##########################################################################################-->

<div class="modal fade" id="new--member" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin: 5% 32%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">New Member</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="backend.php" method="POST" id="new-member" enctype="multipart/form-data">
                    <div id="err"></div>
                    <div class="form-group text-center" style="position: relative;">
                        <span class="img-div">
                            <div class="text-center img-placeholder" onClick="triggerClick()">
                                <h4>Update image</h4>
                            </div>
                            <img src="img/avatar.jpeg" onClick="triggerClick()" id="profileDisplay">

                        </span>
                        <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">
                        <label>Profile Image</label>
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">Member ID</label>
                        <input type="text" class="form-control" id="newmid" name="newmid">
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">Name</label>
                        <input type="text" class="form-control" id="newmembername" name="newmembername">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Email</label>
                        <input type="email" class="form-control" name="newemail">
                    </div>
                    <div class="form-group">
                        <label for="mobile number">Mobile No.</label>
                        <input type="text" name="newmobile" id="newmobile" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="newpassword" id="newpassword" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name='newmembersubmit'>Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--########################################### Manage account #################################################################-->
<div class="modal fade" id="edit__member" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin: 5% 32%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Manage Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="backend.php" method="POST" id="edit_user" enctype="multipart/form-data">
                    <input type='hidden' name='edit_mid' id='edit_mid' value="">
                    <div class="form-group text-center" style="position: relative;">
                        <span class="img-div">
                            <div class="text-center img-placeholder" onClick="triggerClck()">
                                <h4>Update image</h4>
                            </div>
                            <img src="" alt="Not Available" onClick="triggerClck()" id="profiledis">
                        </span>
                        <input type="hidden" id="fakepic" name="fakepic" value="">
                        <input type="file" name="profileImg" onChange="displayImg(this)" id="profileImg" value="" class="form-control" style="display: none;">
                        <label>Profile Image</label>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Member ID</label>
                        <input type="text" class="form-control" id="editmid" name="editmid" readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Name</label>
                        <input type="text" class="form-control" id="editname" name="editname">
                    </div>
                    <div class="form-group">
                        <label for="mobile number">Mobile No.</label>
                        <input type="text" name="editmobile" id="editmobile" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Email</label>
                        <input type="email" class="form-control" name="editemail" id="editemail">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" name="editpassword" id="editpassword" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="editmembersubmit">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--########################################### Delete account #################################################################-->

<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="backend.php" method="POST">
                    <input type="hidden" name="del_mid" id="del_mid" value="">
                    <h4> Do you want to Delete this User </h4>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="delete_member">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
        $('.dataTables_length').addClass('select');
        $('.edit_member').click(function(e) {
            e.preventDefault();
            var member = $(this).attr("data-id");

            $.ajax({
                type: "POST",
                url: "backend.php",
                data: {
                    'action': 'checking_memberedit',
                    'm_id': member,
                },
                success: function(response) {
                    $.each(response, function(key, value) {
                        
                        $('#edit_mid').attr('value', value['memberid']);
                        $('#editmid').attr('value', value['memberid']);
                        $('#editname').val(value['name']);
                        $('#editemail').val(value['emailid']);
                        $('#editmobile').val(value['mobileno']);
                        $('#editpassword').val(value['password']);
                        $('#profiledis').attr('src', value['photo']);
                        $('#fakepic').attr('value', value['photo']);
                        $('#edit__member').modal('show');
                    });
                }
            });
        });
        $(".delete_member").click(function(e) {
            e.preventDefault;
            var mid = $(this).attr("data-id");
            $("#del_mid").val(mid);
        });
    });
    //////////////////////////////////////////////
    function triggerClick(e) {
        document.querySelector('#profileImage').click();
    };

    function displayImage(e) {
        if (e.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    };
    ///////////////////////////////////////////////////////////
    function triggerClck(e) {
        document.querySelector('#profileImg').click();
    };

    function displayImg(e) {
        if (e.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('#profileDis').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    };
</script>