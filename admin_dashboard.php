<div class="container" style="background-color: #f3eeee;">
            <div class="container-fluid">
                <div class="col-lg-12" style="width:100%;">
                    <div class="pad-botm">
                        <span class="las la-igloo"></span>
                        <h4 class="header-line"> DASHBOARD <span class="timeset" id='ct'></span>  <span class="header-underline"></span></h4>
                    </div>
                    <div class="home-content">
                        <div class="overview-boxes">
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">Exams Today</div>
                                    <div class="number"> <?php echo $conn->query("SELECT exam_id FROM exams")->num_rows  ?></div>
                                    <div class="indicator">
                                        <a class="text" href="admin.php?p=2">show more</a>
                                    </div>
                                </div>
                                <img src="img/mmu logo.jpg" class='bx bxs-cart-add cart two'></img>
                            </div>
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">Total Course</div>
                                    <div class="number"> <?php echo $conn->query("SELECT course_id FROM course")->num_rows  ?></div>
                                    <div class="indicator">
                                        <a href="admin.php?p=1" class="text">show More</a>
                                    </div>
                                </div>
                                <img src="img/mmu logo.jpg" class='bx bxs-cart-add cart two'></img>
                            </div>
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">Total Branch</div>
                                    <div class="number"><?php echo $conn->query("SELECT dept_id FROM department")->num_rows ?></div>
                                    <div class="indicator">
                                        <a href="admin.php?p=1" class="text">show More</a>
                                    </div>
                                </div>
                                <img src="img/mmu logo.jpg" class='bx bxs-cart-add cart two'></img>
                            </div>
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">Total Subjects</div>
                                    <div class="number"><?php echo $conn->query("SELECT sub_id FROM subjects")->num_rows ?></div>
                                    <div class="indicator">
                                        <a href="admin.php?p=4" class="text">show More</a>
                                    </div>
                                </div>
                                <img src="img/mmu logo.jpg" class='bx bxs-cart-add cart two'></img>
                            </div>
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">Total Students</div>
                                    <div class="number"><?php echo $conn->query("SELECT studentid FROM students")->num_rows ?></div>
                                    <div class="indicator">
                                        <a href="admin.php?p=4" class="text">show More</a>
                                    </div>
                                </div>
                                <img src="img/mmu logo.jpg" class='bx bxs-cart-add cart two'></img>
                            </div>
                            <div class="box">
                                <div class="right-side">
                                    <div class="box-topic">Total Member</div>
                                    <div class="number"><?php echo $conn->query("SELECT memberid FROM admin")->num_rows ?></div>
                                    <div class="indicator">
                                        <a href="admin.php?p=4" class="text">show More</a>
                                    </div>
                                </div>
                                <img src="img/mmu logo.jpg" class='bx bxs-cart-add cart two'></img>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>