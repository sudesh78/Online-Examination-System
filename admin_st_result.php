<?php
session_start();
$conn = new mysqli("localhost", "root", "", "on_exams");
if (mysqli_connect_error()) {
    die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
}
$rid = $_GET['rid'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="css/sidenav.css">
</head>

<body>
<div class="nav">
    <header>
            <h1>
                <label for="">
                    <span class="las la-bars"></span>
                </label>
            </h1>
        </header>
            <div class="sidebar">
        <div class="profile">
            <img src="<?php echo $_SESSION['login_pic']; ?>" alt="profile_picture">
            <h3><?php echo $_SESSION['login_name']; ?></h3>
            <p>Student</p>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="admin.php?p=0" <?php if ($_GET['p'] == 0)  echo 'class="active"';  ?>><span class="las la-igloo"></span>
                        <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="admin.php?p=1" <?php if ($_GET['p'] == 1) echo 'class="active"'; ?>><span class="las la-history"></span>
                        <span>Add course</span></a>
                </li>
                <li>
                    <a href="admin.php?p=2" <?php if ($_GET['p'] == 2) echo 'class="active"'; ?>><span class="las la-history"></span>
                        <span>Exams</span></a>
                </li>
                <li>
                    <a href="admin.php?p=3" <?php if ($_GET['p'] == 3) echo 'class="active"'; ?>><span class="las la-clipboard-list"></span>
                        <span>Results</span></a>
                </li>
                <li>
                    <a href="admin.php?p=4" <?php if ($_GET['p'] == 4) echo 'class="active"'; ?>><span class="las la-user-circle"></span>
                        <span>Students</span></a>
                </li>
                <li>
                    <a href="admin.php?p=5" <?php if ($_GET['p'] == 5) echo 'class="active"'; ?>><span class="las la-user-circle"></span>
                        <span>Members</span></a>
                </li>
                <li>
                    <a href="logout.php"><span class="las la-sign-in-alt"></span>
                        <span>Log Out</span></a>
                </li>
            </ul>
        </div>
    </div>
    </div>
    <div class="main-content">
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
                                    <b>List of Questions</b>
                                    <span style="float:right">
                                        <button type="button" id="addques" class="btn btn-info">
                                            <span class="las la-plus" style="color: white;">
                                            </span>
                                        </button>
                                    </span>
                                </div>
                                <div class="card-body" style="overflow-x: auto">
                                    <table cellpadding="0" cellspacing="0" border="2" class="table table-striped table-bordered" id="example">
                                        <thead>
                                            <tr>
        
                                                <th class="text-center si ">Question</th>
                                                <th class="text-center si">Option-1</th>
                                                <th class="text-center si">Option-2</th>
                                                <th class="text-center si">Option-3</th>
                                                <th class="text-center si">Option-4</th>
                                                <th class="text-center si">Correct</th>
                                                <th class="text-center si">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $question = $conn->query("SELECT resultid,exams.exam_id,exams.exam_datetime,total_marks,Marks,
                                            cgpa,exam_declared_date,course_name,
                                            dept_name,exam_title,exam_code FROM result,exams,course,department
                                            where course.course_id=exams.course 
                                            and department.dept_id=exams.dept and exams.exam_id = result.exam_id and result.resultid='$rid'");
                                            // if ($question->num_rows > 0) {
                                            while ($row = $question->fetch_assoc()) :
                                                
                                            ?>
                                                <tr class="text-center">
                                                
                                                    <td class="ri">
                                                        <?php echo ucwords($row['question']) ?>

                                                    </td>
                                                    <td class="ri">
                                                        <?php echo ucwords($row['option1']) ?>
                                                    </td>

                                                    <td class="ri">
                                                        <?php echo ucwords($row['option2']) ?>
                                                    </td>
                                                    <td class="ri">
                                                        <?php echo $row['option3'] ?>
                                                    </td>
                                                    <td class="ri">
                                                        <?php echo $row['option4'] ?>
                                                    </td>
                                                    <td class="ri">
                                                        <?php echo $row['correct'];
                                                         ?>
                                                    </td>

                                                    <td class="ri">
                                                        <button class="btn btn-info edit_ques" type="button" data-qid="<?php echo $row['id'] ?>" data-id="<?php echo $row['exam_id'] ?>">Edit</button>
                                                        <button class="btn btn-sm btn-danger delete_ques" type="button" data-toggle="modal" data-target="#deletequestion" data-qid="<?php echo $row['id'] ?>" data-id="<?php echo $row['exam_id'] ?>">Delete</button>
                                                    </td>
                                    
                                                </tr>
                                            <?php
                             
                                                endwhile;
                                    
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" id="questionsForm" action="backend.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="exam_id" value="<?php echo $_GET['eid']; ?>">
                        <input type="hidden" name="que_no" id="que_no" value="">
                        <input type="hidden" name="total_que" id="total_que" value="">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Question Title <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="question_title" id="question_title" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Option 1 <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="option_title_1" id="option_title_1" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Option 2 <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="option_title_2" id="option_title_2" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Option 3 <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="option_title_3" id="option_title_3" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Option 4 <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="option_title_4" id="option_title_4" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Answer <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <select name="answer_option" id="answer_option" class="form-control">
                                        <option value="">Select</option>
                                        <option value="1">1 Option</option>
                                        <option value="2">2 Option</option>
                                        <option value="3">3 Option</option>
                                        <option value="4">4 Option</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="Submit" name="quessave" id="quessave" class="btn btn-info">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="editquestion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="post" action="backend.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_exam_id" id="edit_exam_id" value="<?php echo $_GET['eid']; ?>">
                        <input type="hidden" name="edit_que_id" id="edit_que_id" value="">
                        <input type="hidden" name="edit_total_que" id="edit_total_que" value="<?php echo $_GET['q']; ?>">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Question Title <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="edit_question_title" id="edit_question_title" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Option 1 <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="edit_option_title_1" id="edit_option_title_1" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Option 2 <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="edit_option_title_2" id="edit_option_title_2" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Option 3 <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="edit_option_title_3" id="edit_option_title_3" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Option 4 <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" name="edit_option_title_4" id="edit_option_title_4" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-4 text-right">Answer <span class="text-danger">*</span></label>
                                <div class="col-md-8">
                                    <select name="edit_answer_option" id="edit_answer_option" class="form-control">
                                        <option value="">Select</option>
                                        <option value="1">1 Option</option>
                                        <option value="2">2 Option</option>
                                        <option value="3">3 Option</option>
                                        <option value="4">4 Option</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="Submit" name="edit_quessave" id="edit_quessave" class="btn btn-info">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deletequestion" tabindex="-1" role="dialog" aria-labelledby="deletemodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Question</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" name="delete_quesform" action="backend.php">
                        <input type="hidden" name="del_qid" id="del_qid" value="">
                        <input type="hidden" name="del_eid" id="del_eid" value="">
                        <input type="hidden" name="del_tq" id="del_tq" value="">
                        <h4> Do you want to Delete this Question ?? </h4>
                        <div class="modal-footer">
                            <input type="Submit" name="delete_ques" id="delete_ques" class="btn btn-info">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".edit_ques").click(function(e) {
            e.preventDefault();
            var quesid = $(this).attr("data-qid");
            var eid= $(this).attr("data-id");
            var tq = <?php echo $_GET['q']; ?>;
            console.log(tq);
            $.ajax
            ({
                type: 'POST',
                url: 'backend.php',
                data: {
                    'checking_quesedit': true,
                    'qid': quesid,
                    'eid' : eid,
                    'tq':tq
                },
                success: function(response) {
                    $.each(response, function(key, value) {
                        console.log(response);
                        $('#edit_exam_id').attr('value', value['exam_id']);
                        $('#edit_que_id').attr('value', value['id']);
                        $('#edit_question_title').val(value['question']);
                        $('#edit_option_title_1').val(value['option1']);
                        $('#edit_option_title_2').val(value['option2']);
                        $('#edit_option_title_3').val(value['option3']);
                        $('#edit_option_title_4').val(value['option4']);
                        $('#edit_answer_option').val(value['correct']);
                        $('#editquestion').modal('show');
                    });
                }
            });
        });
    });
    
</script>

</html>