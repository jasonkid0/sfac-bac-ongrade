<?php
include '../../includes/session.php';
include '../../includes/db.php';
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
      <h1>List of Enrolled Student(s) in <strong>
          <?php echo $_GET['code']; ?>
        </strong> - Section <strong>
          <?php echo $_GET['section'] ?>
        </strong> - A.Y. <strong>
          <?php echo $_SESSION['active_acad'] . '-' . $_SESSION['active_sem'] ?>
        </strong></h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
        <div class="col-sm-12">
          <?php check_message(); ?>
          <div class="box">
            <form method="POST" class="form-horizontal" action="ctrlData/class_grade.php?code=<?php echo $_GET['code']; ?>&section=<?php echo $_GET['section']; ?>&class_desc=<?php echo $_GET['class_desc']; ?>">
            <!-- /.box-header -->
            <div class="box-header">
              <?php $que = mysqli_query($db, "
                SELECT * 
                FROM tbl_subjects_new 
                where subj_code = '$_GET[code]' LIMIT 1");
              while ($row = mysqli_fetch_array($que)) {
                ?>
                <h2 class="box-title">Students Enrolled in <strong>
                    <?php echo $_GET['code'] . ' - ' . $_GET['class_desc']; ?>
                  </strong> - Section <strong>
                    <?php echo $_GET['section'] ?>
                  </strong></h2>
              <?php } ?>
              <div class="pull-right">
                <button class="btn btn-success  ms-2" href="section_stud.php" name="btn_save">Enter grades</button>
                <a href="javascript:history.back()" class="btn btn-primary  ms-2">Back</a>
                
              </div>

            </div>
            <div class="box-body">
              <table id="example3" class="table table-bordered table-hover dataTable">
                <thead>
                  <tr>
                    <th>Student#</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Prelim</th>
                    <th>Midterm</th>
                    <th>Finalterm</th>
                    <th>Final Grade</th>
                    <th>Numerical Grade</th>
                    <th>Absences</th>
                  </tr>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  $que = mysqli_query(
                    $db,
                    "SELECT enrolled_subj_id, special_tut, stud_no, course, prelim, midterm, finalterm, ofgrade, numgrade, absences,CONCAT(tbl_students.lastname, ', ', tbl_students.firstname, ' ', tbl_students.middlename)  AS fullname
                        FROM tbl_enrolled_subjects 
                        LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id
                        LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
                        LEFT JOIN tbl_schedules ON tbl_schedules.class_id = tbl_enrolled_subjects.class_id
                        LEFT JOIN tbl_faculties_staff ON tbl_faculties_staff.faculty_id = tbl_schedules.faculty_id   
                        LEFT JOIN tbl_schoolyears ON tbl_schoolyears.stud_id = tbl_students.stud_id
                        LEFT JOIN tbl_courses ON tbl_courses.course_id = tbl_schoolyears.course_id
                        WHERE tbl_schoolyears.ay_id = '$_SESSION[active_acad]' 
                        AND tbl_schoolyears.sem_id ='$_SESSION[active_sem]' 
                        AND tbl_subjects_new.subj_code = '$_GET[code]' 
                        AND tbl_schedules.section = '$_GET[section]'
                        And tbl_schoolyears.remark= 'Approved'
                        ORDER BY fullname"
                  );
                  $student_array = [];
                  while ($row = mysqli_fetch_array($que)) {
                    
                    array_push ($student_array, $row['enrolled_subj_id']);
                    echo '
                    <input name="student_array[]" type="text" value="'. $row['enrolled_subj_id'] .'" hidden>
                    <input name="special_tut[]" type="text" value="'. $row['special_tut'] .'" hidden>
                    
                    <tr> <style>
                      .zoom:hover{
                        -ms-transform: scale(3);
                        -webkit-transform: scale(3);
                        transform: scale(3);
                        margin-left: 50px;
                      }
                    </style>
                                    ';
                    echo '
                                    <td>' . $row['stud_no'] . '</td>
                                    <td>' . strtoupper($row['fullname']) . '</td>
                                    <td>' . $row['course'] . '</td>
                                    <td>';

                                    if ($row['special_tut'] == '0' || $row['special_tut'] == '') {
                                        if ($_SESSION['active_sem'] == 'Summer') {
                                          echo '
                                                        <input class="form-control" style="width: 60px" type="text" value="' . $row['prelim'] . '" name="prelim[]" disabled>';
                                        } else {
                                          echo '
                                          <input class="form-control" style="width: 60px" type="text" value="' . $row['prelim'] . '" name="prelim[]">';
                                        }
                                      } else {
                                        echo '
                                                        <input class="form-control" style="width: 60px" type="text" value="' . $row['prelim'] . '" name="prelim[]" disabled>';
                                      }
                                    echo'</td>
                                    <td><input class="form-control" style="width: 60px" type="text" value="' . $row['midterm'] . '" name="midterm[]"></td>
                                    <td><input class="form-control" style="width: 60px" type="text" value="' . $row['finalterm'] . '" name="finalterm[]"></td>
                                    <td>' . $row['ofgrade'] . '</td>
                                    <td>' . $row['numgrade'] . '</td>';

                    echo '<td><input class="form-control" style="width: 60px" type="text" value="' . $row['absences'] . '" name="absences[]"></td>
                          </tr>';

                  }
                  ?>



                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
                </form>
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