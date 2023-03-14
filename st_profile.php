<style>
    body {
        background: url('img/profileback.jpg');
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #BA68C8
    }

    .profile-button {
        background: rgb(99, 39, 120);
        box-shadow: none;
        border: none
    }

    .profile-button:hover {
        background: #682773
    }

    .profile-button:focus {
        background: #682773;
        box-shadow: none
    }

    .profile-button:active {
        background: #682773;
        box-shadow: none
    }

    .back:hover {
        color: #682773;
        cursor: pointer
    }

    .labels {
        font-size: 11px
    }

    .form-div { margin-top: 100px; border: 1px solid #e0e0e0; }
	#profileDisplay,#profileDis,#profildisplay,#profiledis{ display: block; height: 210px; width: 100%; margin: 0px auto; border-radius: 50%; }
	.img-placeholder {
  width: 100%;
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

</style>

<div class="container rounded bg-white mx-auto mt-5 mb-5 ">
    <div class="row">
        <form action="viewExamServer.php" method="post" enctype="multipart/form-data">
        <div class="col-md border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
               
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
                <span name="dispemail" id="dispemail" class="text-black-50"></span><span> </span>
            </div>
            
        </div>
        <div class="col-md border-right">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">Profile Settings</h4>
                </div>
                <div class="row mt-2">
                <div class="col-md-6"><label class="labels">Roll No.</label><input name="studentid" id="studentid" type="text" class="form-control"  value="<?php echo $_SESSION['stdid']; ?>" readonly></div>
                    <div class="col-md-6"><label class="labels">FirstName</label><input name="name" id="name" type="text" class="form-control"  value="" readonly></div>
                    <div class="col-md-12"><label class="labels">Department</label>
                    <input name="dept" id="dept" type="text" class="form-control" value="" readonly></div>
                    <div class="col-md-6"><label class="labels">Course</label><input name="course" id="course" type="text" class="form-control" value="" readonly></div>
                    <div class="col-md-6"><label class="labels">Semester</label><input name="sem" id="sem" type="text" class="form-control" value="" readonly></div>
                </div>
            <div class="row mt-3">
                <div class="col-md-12"><label class="labels">PhoneNumber</label><input name="phone" id="phone" type="text" class="form-control"  value=""></div>
                    <!-- <div class="col-md-12"><label class="labels">Address</label><input name="address" id="address" type="text" class="form-control" value=""></div> -->
                    <div class="col-md-12"><label class="labels">Email ID</label><input name="email" id="email" type="text" class="form-control"  value=""></div>
                  
                </div>
                <div class="row mt-3">
                    <div class="col-md-12"><label class="labels">Password</label><input name="password" id="password" type="text" class="form-control" value=""></div>
                </div>
                <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit" name="profileupdate" value="Submit" >Save Profile</button></div>
            </div>
        </div>
        </form>
    </div>
</div>
</div>
</div>

<script>
$(document).ready(function () {
    var student = <?php echo $_SESSION['stdid']; ?>;
    $.ajax({
        type: "POST",
        url: "viewExamServer.php",
        data:{
            'stid': student,
             action: "profilecheck",
        },
        success: function (response) {
            $.each(response,function(key,value)
            {
                console.log(response);
                $('#name').attr('value',value['name']);
                $('#phone').val(value['mobileno']);

                $('#email').val(value['emailid']);
                $('#dept').val(value['dept_name']);
                $('#course').val(value['course_name']);
                $('#sem').val(value['sem']);
                $('#password').val(value['password']);
                
                $('#dispemail').html(value['emailid']);
                $('#profileDis').attr('src',value['photo']);
				$('#fakepic').attr('value',value['photo']);
            });
        }
        });		
	});



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