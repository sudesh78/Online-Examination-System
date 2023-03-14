<?php
    if(isset($_GET['cid'])){
        $cid = $_GET['cid'];
    }
    else{
        $cid ='';
    }

    if(isset($_GET['did'])){
        $did = $_GET['did'];
    }
    else{
        $did ='';
    }
    
?>
<div class="container">
    <div class="container-fluid">
        <div class="col-lg-12" style="width:100%;">
            <div class="pad-botm">
                <span class="las la-igloo"></span>
                <h4 class="header-line">Branch & Subject<span class="timeset" id='ct'></span> <span class="header-underline"></span></h4>
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
                <div class="selectsec" style="display: flex;padding-bottom:16px">
                    <div class="form-group"><label for="project" class="control-label">Course</label>
                        <select class="form-control" id="selectcoursename" name="selectcoursename" style="height: 34px;">
                            <option value="">Select Course</option>
                            <?php
                            $qry = $conn->query("SELECT course_id,course_name FROM course");
                            while ($row = $qry->fetch_assoc()) :
                            ?>
                                <option value="<?php echo $row['course_id'] ?>" <?php if($row['course_id']==$cid){
                                    echo "selected";
                                } ?> ><?php echo $row['course_name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group"> <label for="project" class="control-label">Department</label>
                    <select class="form-control" name="select_dept_name" id="select_dept_name" style="height: 34px;">
                        <option value="">Select Department</option>
                    </select>
                </div>

                </div>
                    <div class="card">
                        <div class="card-header">

                            <span style="float:left"><a class="btn btn-primary float-right btn-sm addsub" >
                                    <i class="fa fa-plus">Add Subject</i>
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
                                <tbody id="tabledata">
     
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
                        <div class="form-group">
                        <input type="hidden" name="formtype" id="formtype" value="1">
                            <input type="hidden" id="coursename" name="coursename">
                            <input type="hidden" name="dept_name" id="dept_name">
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
                <h5 class="modal-title" id="exampleModalLabel">Delete Subject </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="backend.php" method="POST">
                    <input type="hidden" name="del_cid" id="del_cid" value=''>
                    <input type="hidden" name="del_did" id="del_did" value=''>
                    <input type="hidden" name="del_subid" id="del_subid" value=''>
                    <h4> Do you want to Delete Subject </h4>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="delete_subject">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    var cid = '<?php echo $cid; ?>';
    var deptid = '<?php echo $did; ?>';
    if(cid == ''){
    }
    else{
        courseChange();
        tabledata();
    }
    function delmodal(val){
        var bid = val;
        var coid = $('#selectcoursename').val();
        var deid = $('#select_dept_name').val();
        $("#del_cid").val(coid);
        $("#del_did").val(deid);
        $("#del_subid").val(bid);
        $('#deletemodal').modal("show");
    }

    function courseChange(){
        var courseid = $('#selectcoursename').val();
        console.log(deptid);
        if (courseid) {
            $.ajax({
                type: 'POST',
                url: 'backend.php',
                data: {
                    'course_id': courseid,
                    'deptid':deptid
                },
                success: function(result) {
                    $('#select_dept_name').html(result);
                }
            });
        } else {
            $('#select_dept_name').html('<option value="">Select Department</option>');
        }
    }

    $(document).ready(function() {
        $('#example').DataTable();
        $('.dataTables_length').addClass('bs-select');
        $(".addsub").click(function(e){
            e.preventDefault;
            var cid = $('#selectcoursename').val();
            var did = $('#select_dept_name').val();
            if(cid != '' && did != ''){
                document.getElementById("coursename").value = cid;
                document.getElementById("dept_name").value = did;
                $('#new--subject').modal('show');
            }
            else if(cid == '' && did == ''){
                alert("Course and Dept Not Selected");
            }
            else if(cid == ''){
                alert("Course Not Selected");
            }
            else if(did == ''){
                alert("Department Not Selected");
            }
            
        });
    });
    $(document).on('change', '#selectcoursename', function() {
        courseChange();
    });

    // ajax script for getting  city data

    $(document).on('change', '#select_dept_name', function() {
        var dept_id = $(this).val();
        if (dept_id) {
            $.ajax({
                type: 'POST',
                url: 'backend.php',
                data: {
                    'dept_id': dept_id
                },
                success: function(result) {
                    tabledata();
                }
            });
        }
    });
    function tabledata() {
        var cid = $("#selectcoursename").val();
        if(deptid!=''){
            var did = deptid;
        }else{
            var did = $("#select_dept_name").val();
        }
        
        var trHTML = '';
        $.ajax({
            type: 'POST',
            url: 'backend.php',
            data: {
                'cid': cid,
                'did':did,
                'action': 'subtablefetch'
            },
            success: function(response) {
                if(response == 'not'){
                    $("#tabledata").html("<tr class='odd'><td valign='top' colspan='4' class='dataTables_empty'>No data available in table</td></tr>");
                }
                else{
                    var i=0;
                    $.each(response, function (key, o) {
                        i++;
                    trHTML += '<tr><td>' + i+
                            '</td><td>' + o['sub_name'] +
                            '</td><td>' + o['sub_code'] +
                            '</td><td>' + 
                            '<button class="btn btn-sm btn-danger delete_sub" type="button" onClick="delmodal('+o['sub_id']+')">Delete</button>' +
                            '</td></tr>';
                    });
                    $("#tabledata").html("");
                    $("#tabledata").html(trHTML);
                }
                
            }
        });
    }
</script>