<div class="container">
    <div class="container-fluid">
        <div class="col-lg-12" style="width:100%;">
        <div class="pad-botm">
                <span class="las la-igloo"></span>
                <h4 class="header-line"> Result  <span class="timeset" id='ct'></span> <span class="header-underline"></span></h4>
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
                            <b>List of Results</b>
                        </div>
                        <div class="card-body" style="overflow-x: auto">
                            <table cellpadding="0" cellspacing="0" border="2" class="table table-striped table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center si">S_No</th>
                                        <th class="text-center si ">Exam Title</th>
                                        <th class="text-center si">Exam Code</th>
                                        <th class="text-center si">Exam Datetime</th>
                                        <th class="text-center si">Status</th>
                                        <th class="text-center si">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stid = $_SESSION['stdid'];
                                    $users = $conn->query("SELECT resultid,exam_title,exam_code,exams.exam_datetime,result.status FROM result,exams 
                                    where result.exam_id = exams.exam_id and studentid ='$stid'");
                                    $i = 0;
                                    if(mysqli_num_rows($users) == 0){
                                    ?>
                                    <tr class="text-center">
                                            <td class="ri" colspan="6">
                                                <?php echo "No Record Available" ?>
                                            </td >
                                        </tr>
                                    <?php
                                    }else{
                                    while ($row = $users->fetch_assoc()) :
                                        $i++;
                                    ?>
                                        <tr class="text-center">
                                            <td class="ri">
                                                <?php echo $i; ?>
                                            </td >
                                            <td class="ri">
                                                <?php echo ucwords($row['exam_title']) ?>
                                            </td>

                                            <td class="ri">
                                                <?php echo $row['exam_code'] ?>
                                            </td>
                                            <td class="ri">
                                                <?php echo date('Y-m-d h:i:s',strtotime($row['exam_datetime'])); ?>
                                            </td>
                                            <td class="ri">
                                                <?php echo $row['status'] ?>
                                            </td>
                                            <td class="ri">
                                                <button class="btn btn-sm btn-info view" data-id="<?php echo $row['resultid'] ?>" type="button" > View </button>
                                            </td>
                                        </tr>
                                    <?php endwhile;} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Result Detail</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        <div class="modal-body">
        <div class="modal-body">
				<div class="form-group">
				<label for="" class="control-label">Result ID</label>
				<input type="text" class="form-control" id="resultid" name="resultid" readonly>
			</div>		
			  <div class="form-group">
				  <label for="" class="control-label">Subject Name : </label>
				  <input type="text" class="form-control" id="examtitle" name="examtitle" readonly>
			  </div>
			  <div class="form-group">
				<label >Subject Code</label>
				<input type="text" name="examcode" id="examcode" class="form-control" readonly >
			</div>
            <div class="form-group">
				<label >Exam DateTime</label>
				<input type="text" name="examdatetime" id="examdatetime" class="form-control" readonly>
			</div>
			  <div class="form-group">
				  <label class="control-label">Total Marks</label>
				  <input type="text" class="form-control" name="totalmarks" id="totalmarks" readonly>
			  </div>
              <div class="form-group">
				  <label class="control-label">Marks Scored</label>
				  <input type="text" class="form-control" name="scoredmarks" id="scoredmarks" readonly>
			  </div>			
              <div class="form-group">
				  <label class="control-label">Percentage</label>
				  <input type="text" class="form-control" name="percentage" id="percentage" readonly>
			  </div>
              <div class="form-group">
				  <label class="control-label">Result Declared On</label>
				  <input type="text" class="form-control" name="resultdeclare" id="resultdeclare" readonly>
			  </div>	
		</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <script>
	$(document).ready(function () {
		$('.view').click(function(e)
		{
			e.preventDefault();
			var resultid = $(this).attr("data-id");
            $.ajax({
				type: "POST",
				url: "viewExamServer.php",
				data:{
					'r_id':resultid,
                    'action':'resulttable'
				},
				success: function (response) {
                    console.log(response);
					$.each(response,function(key,value)
					{
						
						$('#resultid').attr('value',value['resultid']);
						$('#examtitle').attr('value',value['exam_title']);
						$('#examcode').val(value['exam_code']);
						$('#examdatetime').val(value['exam_datetime']);
						$('#totalmarks').val(value['total_marks']);
						$('#scoredmarks').val(value['marks']);
                        
                        if(value['exam_declared_date'] == null){
                            $('#resultdeclare').val("Not Declared");
                        }else{
                            $('#resultdeclare').val(value['exam_declared_date']);
                        }
                        $('#percentage').val(value['percentage']);
						$('#myModal').modal('show');
					});
				}
			});
		});

	});


</script>