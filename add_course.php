<div class="container">
    <div class="container-fluid">
        <div class="col-lg-12" style="width:100%;">
            <div class="pad-botm">
                <span class="las la-igloo"></span>
                <h4 class="header-line"> Course And Branch <span class="timeset" id='ct'></span>  <span class="header-underline"></span></h4>
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
                            <span style="float:left"><a class="btn btn-primary float-right btn-sm" data-target="#new--subject" data-toggle="modal">
                                        <i class="fa fa-plus">Add Subject</i>
                                    </a>
                            </span>
                            <span style="float:right"><a class="btn btn-primary float-right btn-sm" data-target="#new--cour_bran" data-toggle="modal">
                                    <i class="fa fa-plus">Add Course/Branch</i>
                                </a>
                            </span>
                        </div>

                        <div class="card-body" style="overflow-x: auto">
                            <table cellpadding="0" cellspacing="0" border="2" class="table table-striped table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center si">S_Id</th>
                                        <th class="text-center si ">Course</th>
                                        <th class="text-center si ">Branch</th>
                                        <th class="text-center si">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $users = $conn->query("SELECT * FROM course c,department d WHERE c.course_id = d.course_id;
                        ");
                                    $i = 0;
                                    while ($row = $users->fetch_assoc()) :
                                        $i++;
                                    ?>
                                        <tr class="text-center">
                                            <td class="ri">
                                                <?php echo $i ?>
                                            </td>
                                            <td class="ri">
                                                <?php echo ucwords($row['course_name']) ?>
                                            </td>
                                            <td class="ri">
                                                <?php echo ucwords($row['dept_name']) ?>
                                            </td>

                                            <td class="ri">
                                                <button class="btn btn-sm btn-danger delete_branc" type="button" data-toggle="modal" data-target="#deletemodal" data-id="<?php echo $row['dept_id'] ?>">Delete</button>
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
<!-- ########################################### New Course ##########################################################################################-->

<div class="modal fade" id="new--cour_bran" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin: 5% 32%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">New Course/Branch</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="backend.php" method="POST" id="new-cour_bran">
                    <div class="form-group">
                        <label>Input Type</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="store" id="store" value="0">Course
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="store" id="store" value="1">Branch
                            </label>
                        </div>
                    </div>
                    <div class="form-group" id="courside" style="display: none;">
                        <label>Course Name</label>
                        <input class="form-control" type="text" name="newcourse" autocomplete="off"  value="" />
                    </div>
                    <div id="branside" style="display:none">
                        <div class="form-group"> <label for="project" class="control-label">Course Name</label>
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
                            <label>Branch Name</label>
                            <input class="form-control" type="text" name="newbranchname" id="newbranchname" autocomplete="off" value=""/>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name='new_cour_submit'>Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ######################################### New Subject ####################################### -->
<div class="modal fade" id="new--subject" tabindex="-1" role="dialog" aria-labelledby="viewuserLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin: 5% 32%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">New Subject</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="backend.php" method="POST" id="new-subject">
                    <div id="branside">
                    <input type="hidden" name="formtype" id="formtype" value="0">
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
                        <div class="form-group">
                            <label>Subject Name</label>
                            <input class="form-control" type="text" name="newsubname" id="newsubname" autocomplete="off" value=""/>
                        </div>
                        <div class="form-group">
                            <label>Subject Code</label>
                            <input class="form-control" type="text" name="newsubcode" id="newsubcode" autocomplete="off" value=""/>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name='new_subject_submit'>Save</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Delete Branch </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="backend.php" method="POST">
                    <input type="hidden" name="del_deptid" id="del_deptid" value="">
                    <h4> Do you want to Delete this Branch  </h4>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="delete_branch">Yes</button>
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
        $('.dataTables_length').addClass('bs-select');
        $(".delete_branc").click(function(e) {
            e.preventDefault;
            var bid = $(this).attr("data-id");
            $("#del_deptid").val(bid);
        });
    });
    $(function() {
        $("input[name='store']").change(function() {
            if ($(this).val() == '0') {
                $('#courside').show();
                $('#branside').hide();

            } else if ($(this).val() == '1') {
                $('#courside').hide();
                $('#branside').show();
            }
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
</script>