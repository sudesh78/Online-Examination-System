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
                                    $users = $conn->query("SELECT resultid,exam_title,exam_code,exams.exam_datetime,result.status FROM result,exams 
                                    where result.exam_id = exams.exam_id GROUP BY exams.exam_id;");
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
                                                <?php echo date('Y-m-d h:i',strtotime($row['exam_datetime'])); ?>
                                            </td>
                                            <td class="ri">
                                              <?php
                                                   echo $row['status'];
                                              ?>
                                            </td>
                                            <td class="ri">
                                                <button class="btn btn-sm btn-info view" data-id="<?php echo $row['resultid'] ?>" type="button" > View </button>
                                                <?php if($row['status'] == 'Not Declared'){
                                                    ?>
                                                <button class="btn btn-sm btn-info declare" data-id="<?php echo $row['resultid'] ?>" type="button" > Declare </button>
                                                <?php } ?>
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


  <script>
	$(document).ready(function () {
        $('#example').DataTable();
        $('.dataTables_length').addClass('bs-select');
		$('.view').click(function(e)
		{
			e.preventDefault();
			var resultid = $(this).attr("data-id");
            window.location = "./admin.php?p=3&rid="+resultid;
		});
        $('.declare').click(function(e)
		{
			e.preventDefault();
			var resultid = $(this).attr("data-id");
            $.ajax({
				type: "POST",
				url: "backend.php",
				data:{
					'r_id':resultid,
                    'action':'declare_result'
				},
				success: function (response) {

				}
			});
		});

	});


</script>