<div class="container">
  <div class="container-fluid">
    <div class="col-lg-12" style="width:100%;">
      <div class="row">
        <div class="col-md-12">
          <div class="pad-botm">
            <span class="las la-igloo"></span>
            <h4 class="header-line"> DASHBOARD <span class="timeset" id='ct'></span></h4>
            <span class="header-underline"></span>
          </div>
          <?php if ($_SESSION['status'] != "") { ?>
            <div class="col-md-6">
              <div class="alert alert-danger">
                <strong>Status :</strong>
                <?php echo htmlentities($_SESSION['status']); ?>
                <?php echo htmlentities($_SESSION['status'] = ""); ?>
              </div>
            </div>
          <?php } ?>

          <?php
          $course = $_SESSION['stcourse'];
          $sem = $_SESSION['stsem'];
          $dept = $_SESSION['stdept'];
          $date = date("Y-m-d");

          $sql = "SELECT exam_id,exam_code,exam_title,exam_datetime,exam_duration,total_question,
                course_name FROM exams,course where 
                course.course_id = exams.course and course = '$course' and dept='$dept' 
                and sem='$sem' and exam_datetime like'$date%' and status='Started'";

          $resultset = mysqli_query($conn, $sql);
          $resultset1 = mysqli_query($conn, $sql);
          if (mysqli_num_rows($resultset) == 0) {
          ?>
            <div class="container bootstrap snippets bootdey">
              <div class="row">
                <div class="col-md-12" style="text-align: center;">
                  <h3 style="font-family: auto;">No Exam Currently </h3>
                </div>
              </div>
            </div>
          <?php
          }
          else{ ?>
          <?php
          if($row = mysqli_fetch_assoc($resultset)){
            $time = date("Y-m-d h:i:s");
            $min = $row['exam_duration'];
            $examtime = date('Y-m-d h:i:s', strtotime("+$min minutes", strtotime("{$row['exam_datetime']}")));
            if($time>$examtime){
                ?>
               <div class="container bootstrap snippets bootdey">
              <div class="row">
                <div class="col-md-12" style="text-align: center;">
                  <h3 style="font-family: auto;">No Exam Currently</h3>
                </div>
              </div>
            </div>
                <?php
            }else{
              while ($record = mysqli_fetch_assoc($resultset1)) {
          ?>
                         <div class="container bootstrap snippets bootdey">

              <div class="row">
                <div class="col-sm-4">
                  <div class="tile blue">
                    <h3 class="title"> <b><?php echo $record['exam_code']; ?></b></h3>
                    <div class="desc">Title : <?php echo $record['exam_title']; ?></div>                    <div class="desc">Course : <?php echo $record['course_name']; ?></div>
                    <div class="desc">DateTime : <?php echo date("y-m-d h:i a",strtotime($record['exam_datetime'])); ?></div>
                    <div class="desc">Duration : <?php echo $record['exam_duration']; ?></div>
                    <div class="desc">Total Question : <?php echo $record['total_question']; ?></div>
                    <div class="bottom">
                      <button type="button" name="enroll_button" onclick="openexam(<?php echo $record['exam_id']; ?>,<?php echo $_SESSION['stdid']?>);" class="btn btn-info">Start Exam</button>
                    </div>
                  </div>

                </div>
              </div>
              </div>
              <?php } }  } } ?>
            </div>

        </div>
      </div>
    </div>
  </div>


  <script type="text/javascript">


    function openexam(eid , stid) {
      $.ajax({
        url: "viewExamServer.php",
				method: "POST",
				data: {
					'eid': eid,
          'stid': stid,
					action: 'checkexam'
				},
				success: function(data) {
          if(data.length == 9){
            window.location = "stView_exam.php?eid="+eid+"";
          }else{
            alert(data);
          }
				}
      })
     
    }
  </script>