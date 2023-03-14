<link rel="stylesheet" href="css/bootstrap-datetimepicker.css">
<script src="js/bootstrap-datetimepicker.js" crossorigin="anonymous"></script>
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
                            <b>List of Exams</b>
                            <span style="float:right">
                                <a class="btn btn-primary float-right btn-sm" data-target="#addexam" data-toggle="modal" style="padding: 5px 5px; margin-bottom: 8px;margin-left: 5px;"><i class="fa fa-plus">Add Exam</i>
                                </a>
                            </span>
                        </div>
                        <div class="card-body" style="overflow-x: auto">
                            <table cellpadding="0" cellspacing="0" border="2" class="table table-striped table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center si">Code</th>
                                        <th class="text-center si ">Name</th>
                                        <th class="text-center si">Course</th>
                                        <th class="text-center si">Department</th>
                                        <th class="text-center si">Sem</th>
                                        <th class="text-center si">Datetime</th>
                                        <th class="text-center si">Questions</th>
                                        <th class="text-center si">Status</th>
                                        <th class="text-center si">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $users = $conn->query("select * from exams order by exam_datetime ASC");
                                    while ($row = $users->fetch_assoc()) :
                                    ?>
                                        <tr class="text-center">
                                            <td class="ri">
                                                <?php echo ucwords($row['exam_code']) ?>
                                            </td class="ri">
                                            <td class="ri">
                                                <?php echo ucwords($row['exam_title']) ?>

                                            </td>
                                            <td class="ri">
                                                <?php echo ucwords($row['course']) ?>
                                            </td>

                                            <td class="ri">
                                                <?php echo ucwords($row['dept']) ?>
                                            </td>
                                            <td class="ri">
                                                <?php echo $row['sem'] ?>
                                            </td>
                                            <td class="ri">
                                                <?php echo $row['exam_datetime'] ?>
                                            </td>
                                            <td class="ri">
                                                <a class="btn btn-info " href="questions.php?p=2&eid=<?php echo $row['exam_id']; ?>&q=<?php echo $row['total_question']; ?>" style="width:100%; font-weight:bolder;"> <span class="las la-edit"></span> <?php echo $row['total_question']; ?> </a>
                                            </td>
                                            <td class="ri">
                                                <?php echo $row['status']; ?>
                                            </td>
                                            <td class="ri">
                                            <button class="btn btn-sm btn-danger delete_exams" type="button" data-id="<?php echo $row['exam_id']; ?>">Delete</button>
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

<!-- #3################################### Delete Modal ############################################# -->

<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="backend.php" method="POST">
                    <input type="hidden" name="del_id" id="del_id" value="">
                    <h4> Do you want to Delete this Exam </h4>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="delete_exam">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ########################################### Add Modal ################################################################# -->

<div class="modal fade" id="addexam" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin: 5% 32%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">New User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="POST" id="examForm" action="backend.php">
              <div class="modal-body">
                <div class="form-group"> <label for="project" class="control-label">Course</label>
                  <select class="form-control" id="coursename" name="coursename" style="height: 34px;">
                    <option value="">Select Course</option>
                    <?php
                    $qry = $conn->query("SELECT course_id,course_name FROM course");
                    while ($row = $qry->fetch_assoc()) :
                    ?>
                      <option value="<?php echo $row['course_id'] ?>"><?php echo $row['course_name'] ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
                <div class="form-group"> <label for="project" class="control-label">Department</label>
                  <select class="form-control" name="dept_name" id="dept_name" style="height: 34px;">
                    <option value="">Select Department</option>
                  </select>
                </div>
                <div class="form-group"> <label for="project" class="control-label">Semester</label>
                  <input type="text" name="sem_no" id="sem_no" class="form-control" placeholder="Semester Number" required>
                </div>
                <div class="form-group"> <label for="project" class="control-label">Subject Code</label>
                  <select class="form-control" id="sub_code" name="sub_code" style="height: 34px;">
                    <option value="">Select Code</option>
                  </select>
                </div>
                <div class="form-group"> <label for="project" class="control-label">Subject Name</label>
                  <input type="text" name="sub_name" id="sub_name" class="form-control" placeholder="Subject Name" readonly>
                </div>
                <div class="form-group"> <label for="project" class="control-label">Date and Time</label>
                  <input type="text" name="exam_datetime" id="exam_datetime" class="form-control" placeholder="Set Date and Time" required>
                </div>
                <div class="form-group"> <label for="project" class="control-label">Duration</label>
                  <input type="text" name="exam_duration" id="exam_duration" class="form-control" placeholder="Duration in Minutes" required>
                </div>

                <div class="form-group"> <label for="project" class="control-label">Total Question</label>
                  <input type="text" name="total_question" id="total_question" class="form-control" placeholder="Total number of questions" required>
                </div>

                <div class="form-group"> <label for="project" class="control-label">Marks For Right Answer</label>
                  <input type="text" name="marks_right_answer" id="marks_right_answer" class="form-control" placeholder="Without sign(+/-)" required>
                </div>

                <div class="form-group"> <label for="project" class="control-label">Marks For Wrong Answer</label>
                  <input type="text" name="marks_wrong_answer" id="marks_wrong_answer" class="form-control" placeholder="Without sign(+/-)" required>
                </div>

                <div class="modal-footer">
                  <input type="hidden" name="id" id="id" />
                  <input type="hidden" name="action" id="action" value="" />
                  <input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
                  <a onclick="window.history.back(-1)" class="btn btn-danger">Cancel</a>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function () {
      $('#example').DataTable();
      $('.dataTables_length').addClass('bs-select');
    
		$('.edit_user').click(function(e)
		{
			e.preventDefault();
			var student = $(this).attr("data-id");
			$.ajax({
				type: "POST",
				url: "backend.php",
				data:{
					'checking_editbtn': true,
					'sid':student,
				},
				success: function (response) {
					$.each(response,function(key,value)
					{
						console.log(response);
						$('#edit_sid').attr('value',value['studentid']);
						$('#editsid').attr('value',value['studentid']);
						$('#editname').val(value['name']);
						$('#editemail').val(value['emailid']);
						$('#editmobile').val(value['mobileno']);
						$('#editpassword').val(value['password']);
						$('#profiledis').attr('src',value['photo']);
						$('#fakepic').attr('value',value['photo']);
						$('#edit__user').modal('show');
					});
				}
			});
		});
		$(".delete_exams").click(function(e){
			e.preventDefault;
			var eid = $(this).attr("data-id");
      console.log("he");
			$("#del_id").val(eid);
      $('#deletemodal').modal("show");
		});
    var date = new Date();
    date.setDate(date.getDate());

    $('#exam_datetime').datetimepicker({
        startDate :date,
        format: 'yyyy-mm-dd hh:ii',
        autoclose:true
      });
	});
  $(document).on('change', '#coursename', function() {
    var courseid = $(this).val();
    if (courseid) {
      $.ajax({
        type: 'POST',
        url: 'backend.php',
        data: {
          'course_id': courseid
        },
        success: function(result) {
          $('#dept_name').html(result);
        }
      });
    } else {
      $('#dept_name').html('<option value="">Select Department</option>');
    }
  });

  // ajax script for getting  city data

  $(document).on('change', '#dept_name', function() {
    var dept_id = $(this).val();
    if (dept_id) {
      $.ajax({
        type: 'POST',
        url: 'backend.php',
        data: {
          'dept_id': dept_id
        },
        success: function(result) {
          $('#sub_code').html(result);
        }
      });
    } else {
      $('#sub_code').html('<option value="">Select Code</option>');
    }
  });

  ////////////////////////////////////////////

  $(document).on('change', '#sub_code', function() {
    var subcode = $(this).val();
    if (subcode) {
      $.ajax({
        type: 'POST',
        url: 'backend.php',
        data: {
          'subcode': subcode
        },
        success: function(result) {
          $('#sub_name').val(result);
        }
      });
    }
  });
  
</script>