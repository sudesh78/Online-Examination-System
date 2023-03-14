<style>
	.text-center{
		text-align: center;
	}
	.si{
		font-size: 1.2rem;
		font-weight: bold;
		height: 2rem;
	}
	.ri{
		padding: 8px 0;
		font-size: 17px;
	}
	.form-div { margin-top: 100px; border: 1px solid #e0e0e0; }
	#profileDisplay,#profileDis,#profildisplay,#profiledis{ display: block; height: 210px; width: 60%; margin: 0px auto; border-radius: 50%; }
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

	.container1{
	
    position: relative;
    width: calc(100% - 200px);
    left: 200px;
    top: 0;

	}
</style>
<div class="container">
    <div class="container-fluid">
        <div class="col-lg-12" style="width:100%;">
        <div class="pad-botm">
                <span class="las la-igloo"></span>
                <h4 class="header-line"> EXAMS <span class="timeset" id='ct'></span>  <span class="header-underline"></span></h4>
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
                            <b>List of Users</b>
                            <span style="float:right"><a class="btn btn-primary float-right btn-sm" data-target="#new--user" data-toggle="modal">
                                    <i class="fa fa-plus">Add User</i>
                                </a></span>
                        </div>
                        <div class="card-body" style="overflow-x: auto">
                            <table cellpadding="0" cellspacing="0" border="2" class="table table-striped table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center si">S_Id</th>
                                        <th class="text-center si">Photo</th>
                                        <th class="text-center si ">Name</th>
                                        <th class="text-center si">Email</th>
                                        <th class="text-center si">Mobile No.</th>
                                        <th class="text-center si">Status</th>
                                        <th class="text-center si">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $users = $conn->query("SELECT * FROM students order by studentid");
                                    while ($row = $users->fetch_assoc()) :
                                    ?>
                                        <tr class="text-center">
                                            <td class="ri">
                                                <?php echo $row['studentid'] ?>
                                            </td >
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
                                                <?php echo $row['status'] ?>
                                            </td>
                                            <td class="ri">
                                                <button class="btn btn-sm btn-info edit_user" data-id="<?php echo $row['studentid'] ?>" type="button"> Edit </button>
                                                <button class="btn btn-sm btn-danger delete_user" type="button" data-toggle="modal" data-target="#deletemodal" data-id="<?php echo $row['studentid'] ?>">Delete</button>
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

<div class="modal fade" id="new--user" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin: 5% 32%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">New User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="backend.php" method="POST" id="new-user" enctype="multipart/form-data">
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
                        <label for="" class="control-label">Student ID</label>
                        <input type="text" class="form-control" id="newsid" name="newsid">
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">Name</label>
                        <input type="text" class="form-control" id="newusername" name="newusername">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Course</label>
                        <select class="form-control" id="newcoursename" name="newcoursename" style="height: 34px;">
                            <option value="">Select Course</option>
                            <?php
                            $qry = $conn->query("SELECT course_id,course_name FROM course");
                            while ($row = $qry->fetch_assoc()) :
                            ?>
                                <option value="<?php echo $row['course_id'] ?>"><?php echo $row['course_name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Branch</label>
                        <select class="form-control" name="newdeptname" id="newdeptname" style="height: 34px;">
                            <option value="">Select Department</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Semester</label>
                        <input type="text" class="form-control" id="newsemno" name="newsemno">
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
                        <button type="submit" class="btn btn-primary" name='newusersubmit'>Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--########################################### Manage account #################################################################-->
<div class="modal fade" id="edit__user" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
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
                    <input type='hidden' name='edit_sid' id='edit_sid' value="">
                    <div class="form-group text-center" style="position: relative;" >
                        <span class="img-div">
                        <div class="text-center img-placeholder"  onClick="triggerClck()">
                            <h4>Update image</h4>
                        </div>
                        <img src="" alt="Not Available" onClick="triggerClck()" id="profileDis">
                        </span>
                        <input type="hidden" id="fakepic" name="fakepic" value="">	
                        <input type="file" name="profileImg" onChange="displayImg(this)" id="profileImg" class="form-control" style="display: none;">
                        <label>Profile Image</label>
                        </div>		
                            
                    <div class="form-group">
                        <label for="" class="control-label">Student ID</label>
                        <input type="text" class="form-control" id="editsid" name="editsid" readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Name</label>
                        <input type="text" class="form-control" id="editname" name="editname">
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Course</label>
                        <input type="text" class="form-control" id="editcourse" name="editcourse" readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Branch</label>
                        <input type="text" class="form-control" id="editdept" name="editdept" readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Semester</label>
                        <input type="text" class="form-control" id="editsemno" name="editsemno">
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
                        <button type="submit" class="btn btn-primary" name="editusersubmit">Save</button>
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
                    <input type="hidden" name="del_id" id="del_id" value="">
                    <h4> Do you want to Delete this User </h4>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="delete_user">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


 
<script type="text/javascript">

    $(document).ready(function() {
        $('#example').DataTable();
        $('.dataTables_length').addClass('bs-select');
        $('.edit_user').click(function(e) {
            e.preventDefault();
            var student = $(this).attr("data-id");
            $.ajax({
                type: "POST",
                url: "backend.php",
                data: {
                    'action': 'checking_editbtn',
                    'sid': student,
                },
                success: function(response) {
                    console.log(response);
                    $.each(response, function(key, value) {
                        
                        $('#edit_sid').attr('value', value['studentid']);
                        $('#editsid').attr('value', value['studentid']);
                        $('#editname').val(value['name']);
                        $('#editcourse').val(value['course_name']);
                        $('#editdept').val(value['dept_name']);
                        $('#editsemno').val(value['sem']);
                        $('#editemail').val(value['emailid']);
                        $('#editmobile').val(value['mobileno']);
                        $('#editpassword').val(value['password']);
                        $('#profileDis').attr('src', value['photo']);
                        $('#fakepic').attr('value', value['photo']);
                        $('#edit__user').modal('show');
                    });
                }
            });
        });
        $(".delete_user").click(function(e) {
            e.preventDefault;
            var sid = $(this).attr("data-id");
            $("#del_id").val(sid);
        });



        $(document).on('change', '#newcoursename', function() {
            var courseid = $(this).val();
            if (courseid) {
            $.ajax({
                type: 'POST',
                url: 'backend.php',
                data: {
                'course_id': courseid
                },
                success: function(result) {
                $('#newdeptname').html(result);
                }
            });
            } else {
            $('#newdeptname').html('<option value="">Select Department</option>');
            }
        });
    });
    //////////////////////////////////////////////
    function triggerClick(e) {
  		document.querySelector('#profileImage').click();
	};

	function displayImage(e) {
  		if (e.files[0]) {
    		var reader = new FileReader();
    		reader.onload = function(e){
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
    		reader.onload = function(e){
      			document.querySelector('#profileDis').setAttribute('src', e.target.result);
    		}
    	reader.readAsDataURL(e.files[0]);
  		}
	};
</script>