<?php
include '../../includes/session.php';
include '../../includes/db.php';

if (isset($_GET['ay'])) {
  $ay = $_GET['ay'];
} else {
  $ay = $_SESSION['active_acad'];
}

if (isset($_GET['sem'])) {
  $sem = $_GET['sem'];
} else {
  $sem = $_SESSION['active_sem'];
}

?>
<!DOCTYPE html>
<html>
<!-- ============================================HEAD CSS LINKS============================================= -->
                                    <?php include '../../includes/head_css.php'; ?>
<!-- ============================================./HEAD CSS LINKS============================================= -->
<body class="hold-transition skin-blue sidebar-mini">
<!-- =================================================HEADER================================================== -->
                                      <?php include '../../includes/header.php'; ?>
<!-- ================================================./HEADER================================================= -->
<!-- ================================================SIDEBAR LEFT============================================ -->
                                    <?php include '../../includes/sidebar_left.php'; ?>
<!-- ================================================./SIDEBAR LEFT============================================ -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>List of Enrolled Student(s) in <strong><?php echo $_GET['code']; ?></strong> - Section <strong><?php echo $_GET['section'] ?>
      
      
      </strong> - A.Y. <strong><?php echo $ay.'-'.$sem ?></strong></h1>
    
    
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
        <div class="col-sm-12">
          <?php check_message(); ?>
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
              <?php $que= mysqli_query($db,"
                SELECT * 
                FROM tbl_subjects_new 
                where subj_code = '$_GET[code]' LIMIT 1")  or die(mysqli_error($db));
              while ($row = mysqli_fetch_array($que)) {
                ?>
              <h2 class="box-title">Students Enrolled in <strong><?php echo $_GET['code'].' - '.$_GET['section']; ?></strong> - Section <strong><?php echo $_GET['section'] ?></strong></h2>
            <?php } ?>
              <div class="pull-right">
                <a class="btn btn-primary  ms-2" href="section_stud.php?code=<?php echo $_GET['code']; ?>&section=<?php echo $_GET['section']; ?>&class_desc=<?php echo $_GET['class_desc']; ?>">Enter class grades</a>
                <a href="javascript:history.back()" class="btn btn-primary  ms-2">Back</a>
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover dataTable">
                <thead>
                <tr>
                 <th>Image</th>
                  <th>Student#</th>
                  <th>Student Name</th>
                  <th>Course</th>
                  <th>Prelim</th>
                  <th>Midterm</th>
                  <th>Finalterm</th>
                  <th>Final Grade</th>
                  <th>Numerical Grade</th>
                  <th>Updated At</th>
                  <th>Updated By</th>
                  <th>Remarks</th>
                  <th>Absences</th>
                  <th>Option</th>
                </tr>
                </tr>
                </thead>
                <tbody>
                  <?php 

                  $que = mysqli_query($db,
                  "SELECT *,tbl_students.img,CONCAT(tbl_students.lastname, ', ', tbl_students.firstname, ' ', tbl_students.middlename)  as fullname FROM tbl_enrolled_subjects 
                  LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id
                  LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
                  LEFT JOIN tbl_schedules ON tbl_schedules.class_id = tbl_enrolled_subjects.class_id LEFT JOIN tbl_faculties_staff ON tbl_faculties_staff.faculty_id = tbl_schedules.faculty_id 
                  LEFT JOIN tbl_schoolyears ON tbl_schoolyears.stud_id = tbl_students.stud_id
                  LEFT JOIN tbl_courses ON tbl_courses.course_id = tbl_schoolyears.course_id
                  
                  WHERE tbl_schoolyears.ay_id = '$ay' 
                  AND tbl_schoolyears.sem_id ='$sem'
                  AND tbl_subjects_new.subj_code = '$_GET[code]' 
                  AND tbl_schedules.section = '$_GET[section]' 
                  AND tbl_schoolyears.remark = 'Approved' 
                  ORDER BY fullname");

                  while($row = mysqli_fetch_array($que)){
                    echo'<tr> <style>
                      .zoom:hover{
                        -ms-transform: scale(3);
                        -webkit-transform: scale(3);
                        transform: scale(3);
                        margin-left: 50px;
                      }
                    </style>
                                    <td>'; if(empty($row['img'])){
                                                        echo'<img class="img zoom" style="height:80px; width:80px;" src="../../img/user2.png" />';
                                                      }else{ echo' <img class="img zoom" style="height:80px; width:80px;" src="data:image/jpeg;base64,'.base64_encode( $row['img'] ).'" "/>';} 
                                                      echo'</td>
                                    <td>'.$row['stud_no'].'</td>
                                    <td>'.strtoupper($row['fullname']).'</td>
                                    <td>'.$row['course'].'</td>
                                    <td>'.$row['prelim'].'</td>
                                    <td>'.$row['midterm'].'</td>
                                    <td>'.$row['finalterm'].'</td>
                                    <td>'.$row['ofgrade'].'</td>
                                    <td>'.$row['numgrade'].'</td>
                                    <td>'.$row['last_update'].'</td>
                                    <td>'.$row['updated'].'</td>';

                                    if ($row['remarks']== 'Failed') {
                                          echo'<td style="color: red"> '.$row['remarks'].'</td>';
                                    }
                                    elseif($row['remarks']== 'Passed'){
                                          echo'<td style="color: green"> '.$row['remarks'].'</td>';
                                    }
                                    else{
                                      echo'<td> '.$row['remarks'].'</td>';
                                    }

                              echo'<td>'.$row['absences'].'</td>
                              
                                    <td>
                                      <a href="edit_class_stud.php?stud_id='.$row['stud_id'].'&code='.$_GET['code'].'&section='.$row['section'].'" class="btn btn-danger disabled">Transfer to other Section</a>
                                      <button class="btn btn-success btn-sm" data-target="#editModal'.$row['enrolled_subj_id'].'" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Enter Grade</button>
                                    </td>
                          </tr> 

                                  <!--==========================ENTER GRADE MODAL==========================-->
                  <div id="editModal'.$row['enrolled_subj_id'].'" class="modal fade">
                  <form method="POST" class="form-horizontal" action="ctrlData/student_grade.php?code='. $_GET['code'].'&section='. $_GET['section'].'&class_desc='. $_GET['class_desc'].'">
                    <div class="modal-dialog modal-sm" style="width:40% !important;">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <h4 class="modal-title">Enter Grade for <strong>'.$row['fullname'].'</strong></h4>
                          </div>
                          <div class="modal-body">
                          <div class="row">
                              <div class="col-md-12">
                                  <input type="hidden" value="'.$row['enrolled_subj_id'].'" name="hidden_id" id="hidden_id"/>
                                  <input type="hidden" value="'.$row['special_tut'].'" name="special_tut" id="hidden_id"/>
                                  <div class="row">
                              <div class="box-header with-border">
                                <h3 class="box-title"></h3>
                              </div>
                                <div class="box-body">
                                  <div class="form-group">
                                    <label for="acadyear" class="col-sm-3 control-label">Prelim</label>
                                    <div class="col-sm-9">';
                                    if ($row['special_tut'] == '0' || $row['special_tut'] == ''){
                                      if($_SESSION['active_sem'] == 'Summer'){
                                        echo'
                                      <input type="text" disabled name="prelim" class="form-control" id="prelim" value="'.$row['prelim'].'">';}
                                      else{ echo '
                                      <input type="text" name="prelim" class="form-control" id="prelim" value="'.$row['prelim'].'">';}
                                    }else{
                                      echo'
                                      <input type="text" disabled name="prelim" class="form-control" id="prelim" value="'.$row['prelim'].'">';
                                    }
                                    echo'</div>
                                  </div>
                                  <div class="form-group">
                                    <label for="acadyear" class="col-sm-3 control-label">Midterm</label>
                                    <div class="col-sm-9">
                                      <input type="text" name="midterm" class="form-control" id="midterm" value="'.$row['midterm'].'">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="acadyear" class="col-sm-3 control-label">Final Term</label>
                                    <div class="col-sm-9">
                                      <input type="text" name="finalterm" class="form-control" id="finalterm" value="'.$row['finalterm'].'">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="acadyear" class="col-sm-3 control-label">Final Grade</label>
                                    <div class="col-sm-9">
                                      <input type="text" disabled name="ofgrade" class="form-control" id="ofgrade" value="'.$row['ofgrade'].'">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="acadyear" class="col-sm-3 control-label">Num Grade</label>
                                    <div class="col-sm-9">
                                      <input type="text" disabled name="numgrade" class="form-control" id="numgrade" value="'.$row['numgrade'].'">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="acadyear" class="col-sm-3 control-label">Absences</label>
                                    <div class="col-sm-9">
                                      <input type="text" name="absences" class="form-control" id="absences" value="'.$row['absences'].'">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="acadyear" class="col-sm-3 control-label">Remarks</label>
                                    <div class="col-sm-9">
                                      <input type="text" disabled name="remarks" class="form-control" id="remarks" value="'.$row['remarks'].'">
                                    </div>
                                  </div>
                                </div>
                                <!-- /.box-body -->
                          </div>
                                <!-- /.box-footer -->
                            </div>

                          </div>
                          </div>
                          <div class="modal-footer">
                              <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel"/>
                              <input type="submit" class="btn btn-primary btn-sm" name="btn_save" value="Save"/>
                          </div>
                      </div>
                    </div>
                  </form>
                  </div>';
                  
}
                  ?>
                                  


                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- =================================================FOOTER================================================== -->
                                    <?php include '../../includes/footer.php'; ?>
<!-- =================================================FOOTER================================================== -->

<!-- =================================================SCRIPT================================================== -->
                                    <?php include '../../includes/script.php'; ?>
<!-- =================================================SCRIPT================================================== -->

</body>
</html>