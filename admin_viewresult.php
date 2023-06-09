<?php
    $rid = $_GET['rid'];
?>
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
                                        <th class="text-center si">Total Marks</th>  
                                        <th class="text-center si">Student Id</th>
                                        <th class="text-center si">Student Percentage</th>  
                                        <th class="text-center si">Status</th>
    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $users = $conn->query("SELECT result.Studentid,result.total_marks,result.marks,result.percentage,resultid,exam_title,exam_code,exams.exam_datetime,result.status FROM result,exams 
                                    where result.exam_id = exams.exam_id and resultid='$rid'");
                                    $i = 0;
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
                                                <?php echo $row['total_marks'] ?>
                                            </td>
                                            <td class="ri">
                                                <?php echo $row['Studentid'] ?>
                                            </td>
                                            <td class="ri">
                                                <?php echo $row['percentage'],'%' ?>
                                            </td>
                                            <td class="ri">
                                                <?php if($row['percentage']>33){
                                                    echo "Passed";
                                                }
                                                else
                                                {
                                                    echo "Failed";
                                                } 
                                                ?>
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
<script>
	$(document).ready(function () {
        $('#example').DataTable();
        $('.dataTables_length').addClass('bs-select');
	});


</script>