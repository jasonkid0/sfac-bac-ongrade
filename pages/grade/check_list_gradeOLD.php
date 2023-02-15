<?php
include '../../includes/session.php';
include '../../includes/db.php';
?>
<!DOCTYPE html>
<html>
<!-- ============================================HEAD CSS LINKS============================================= -->
                                    <?php include '../../includes/head_css.php'; ?>
<!-- ============================================./HEAD CSS LINKS============================================= -->
<body class="hold-transition skin-red sidebar-mini">
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
      <h1 allign="center">All Academic Grade</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
      <div class="row">
        <div class="col-sm-12">
          <?php check_message(); ?>
            <table id="" class="table table-condensed table-striped">
                <thead>
                  <col width="80">
                  <col width="250">
                  <col width="50">
                  <col width="50">
                  <col width="80">
                  <col width="80">
                <tr>
                  <th>Subj Code</th>
                  <th>Subj Description</th>
                  <th>Grade</th>
                  <th>Total Unit</th>
                  <th></th>
                  <th></th>
                </tr>
                </thead>

                <tbody>
<?php 
// $q = mysqli_query($db,"SELECT * FROM tbl_schoolyears LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_schoolyears.stud_id LEFT JOIN tbl_courses ON tbl_courses.course_id = tbl_schoolyears.course_id WHERE tbl_schoolyears.stud_id = '$_GET[stud_id]' LIMIT 1");
// while($row1 = mysqli_fetch_array($q)){
// $query = mysqli_query($db,"SELECT * FROM tbl_subjects WHERE course_id = '$row1[course_id]' AND year_id = '1' AND sem_id = '1'  AND eay_id = '$curri_id'");
// while($row = mysqli_fetch_array($query)){
//   echo '        
//                 <tr>
//                   <td>'.$row['subj_code'].'</td>
//                   <td>'.$row['subj_desc'].'</td>
//                   <td>'.$row['unit_total'].'</td>
//                   <td></td>
//                   <td></td>
//                 </tr>';
//               }
// }
?>




                


                </tbody>
              </table>
              <table id="" class="table table-condensed table-striped">
                <thead>
                  <col width="80">
                  <col width="250">
                  <col width="50">
                  <col width="50">
                  <col width="80">
                  <col width="80">
                <h4><strong>1st Year, 1st Sem</strong></h4>
                </thead>

                <tbody>
<?php 
if ($_SESSION['userid'] != $_GET['stud_id']) {
  header("location: ../404/404.php");
}

$sy=mysqli_query($db,"SELECT * from tbl_schoolyears left join tbl_year_levels on tbl_schoolyears.year_id=tbl_year_levels.year_id where stud_id='$_GET[stud_id]' and year_level='1st Year' and sem_id='First Semester' ")or die(mysqli_error($db));
$syrow=mysqli_fetch_array($sy);
if (mysqli_num_rows($sy) >= 1) 
{
$squery = mysqli_query($db, "SELECT tbl_subjects_new.unit_total, tbl_subjects_new.subj_code, tbl_subjects_new.subj_desc, tbl_enrolled_subjects.numgrade
          FROM tbl_enrolled_subjects
          LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
          LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id WHERE tbl_students.stud_id = '$_GET[stud_id]'  AND semester = '$syrow[sem_id]' and acad_year = '$syrow[ay_id]' AND tbl_subjects_new.course_id = '$syrow[course_id]' AND tbl_subjects_new.course_id = '$syrow[course_id]' ")or die(mysqli_error($db));
         
              if (mysqli_num_rows($squery) >= 1) 
              {
                while($row2 = mysqli_fetch_array($squery))
                  {
                   ?>   
                    <tr>
                    <td><?php echo $row2['subj_code']?></td>
                    <td><?php echo $row2['subj_desc']?></td>
                    <td><?php echo $row2['numgrade']?></td>
                    <td><?php echo $row2['unit_total']?></td>
                    <td></td>
                    <td></td>
                    </tr>
                      <?php
                  }
              }
}
?>




                


                </tbody>
              </table>
              <table id="" class="table table-condensed table-striped">
                <thead>
                  <col width="80">
                  <col width="250">
                  <col width="50">
                  <col width="50">
                  <col width="80">
                  <col width="80">
                <h4><strong>1st Year, 2nd Sem</strong></h4>
                </thead>

                <tbody>
<?php 
if ($_SESSION['userid'] != $_GET['stud_id']) {
  header("location: ../404/404.php");
}

$sy=mysqli_query($db,"SELECT * from tbl_schoolyears left join tbl_year_levels on tbl_schoolyears.year_id=tbl_year_levels.year_id where stud_id='$_GET[stud_id]' and year_level='1st Year' and sem_id='Second Semester' ")or die(mysqli_error($db));
$syrow=mysqli_fetch_array($sy);
if (mysqli_num_rows($sy) >= 1) 
{
$squery = mysqli_query($db, "SELECT tbl_subjects_new.unit_total,  tbl_subjects_new.subj_code, tbl_subjects_new.subj_desc, tbl_enrolled_subjects.numgrade
          FROM tbl_enrolled_subjects
          LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
          LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id WHERE tbl_students.stud_id = '$_GET[stud_id]'  AND semester = '$syrow[sem_id]' and acad_year = '$syrow[ay_id]' AND tbl_subjects_new.course_id = '$syrow[course_id]' ")or die(mysqli_error($db));
         
              if (mysqli_num_rows($squery) >= 1) 
              {
                while($row2 = mysqli_fetch_array($squery))
                  {
                   ?>   
                    <tr>
                    <td><?php echo $row2['subj_code']?></td>
                    <td><?php echo $row2['subj_desc']?></td>
                    <td><?php echo $row2['numgrade']?></td>
                    <td><?php echo $row2['unit_total']?></td>
                    <td></td>
                    <td></td>
                    </tr>
                      <?php
                  }
              }
}
?>




                


                </tbody>
              </table>
              <table id="" class="table table-condensed table-striped">
                <thead>
                  <col width="80">
                  <col width="250">
                  <col width="50">
                  <col width="50">
                  <col width="80">
                  <col width="80">
                <h4><strong>2nd Year, 1st Sem</strong></h4>
                </thead>

                <tbody>
<?php 
if ($_SESSION['userid'] != $_GET['stud_id']) {
  header("location: ../404/404.php");
}

$sy=mysqli_query($db,"SELECT * from tbl_schoolyears left join tbl_year_levels on tbl_schoolyears.year_id=tbl_year_levels.year_id where stud_id='$_GET[stud_id]' and year_level='2nd Year' and sem_id='First Semester' ")or die(mysqli_error($db));
$syrow=mysqli_fetch_array($sy);
if (mysqli_num_rows($sy) >= 1) 
{
$squery = mysqli_query($db, "SELECT tbl_subjects_new.unit_total, tbl_subjects_new.subj_code, tbl_subjects_new.subj_desc, tbl_enrolled_subjects.numgrade
          FROM tbl_enrolled_subjects
          LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
          LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id WHERE tbl_students.stud_id = '$_GET[stud_id]'  AND semester = '$syrow[sem_id]' and acad_year = '$syrow[ay_id]' AND tbl_subjects_new.course_id = '$syrow[course_id]' ")or die(mysqli_error($db));
         
              if (mysqli_num_rows($squery) >= 1) 
              {
                while($row2 = mysqli_fetch_array($squery))
                  {
                   ?>   
                    <tr>
                    <td><?php echo $row2['subj_code']?></td>
                    <td><?php echo $row2['subj_desc']?></td>
                    <td><?php echo $row2['numgrade']?></td>
                    <td><?php echo $row2['unit_total']?></td>
                    <td></td>
                    <td></td>
                    </tr>
                      <?php
                  }
              }
}
?>




                


                </tbody>
              </table>
              </table>
              <table id="" class="table table-condensed table-striped">
                <thead>
                  <col width="80">
                  <col width="250">
                  <col width="50">
                  <col width="50">
                  <col width="80">
                  <col width="80">
                <h4><strong>2nd Year, 2nd Sem</strong></h4>
                </thead>

                <tbody>
<?php 
if ($_SESSION['userid'] != $_GET['stud_id']) {
  header("location: ../404/404.php");
}

$sy=mysqli_query($db,"SELECT * from tbl_schoolyears left join tbl_year_levels on tbl_schoolyears.year_id=tbl_year_levels.year_id where stud_id='$_GET[stud_id]' and year_level='2nd Year' and sem_id='Second Semester' ")or die(mysqli_error($db));
$syrow=mysqli_fetch_array($sy);
if (mysqli_num_rows($sy) >= 1) 
{
$squery = mysqli_query($db, "SELECT tbl_subjects_new.unit_total, tbl_subjects_new.subj_code, tbl_subjects_new.subj_desc, tbl_enrolled_subjects.numgrade
          FROM tbl_enrolled_subjects
          LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
          LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id WHERE tbl_students.stud_id = '$_GET[stud_id]'  AND semester = '$syrow[sem_id]' and acad_year = '$syrow[ay_id]' AND tbl_subjects_new.course_id = '$syrow[course_id]' ")or die(mysqli_error($db));
         
              if (mysqli_num_rows($squery) >= 1) 
              {
                while($row2 = mysqli_fetch_array($squery))
                  {
                   ?>   
                    <tr>
                    <td><?php echo $row2['subj_code']?></td>
                    <td><?php echo $row2['subj_desc']?></td>
                    <td><?php echo $row2['numgrade']?></td>
                    <td><?php echo $row2['unit_total']?></td>
                    <td></td>
                    <td></td>
                    </tr>
                      <?php
                  }
              }
}
?>




                


                </tbody>
              </table>
              </table>
              <table id="" class="table table-condensed table-striped">
                <thead>
                  <col width="80">
                  <col width="250">
                  <col width="50">
                  <col width="50">
                  <col width="80">
                  <col width="80">
                <h4><strong>3rd Year, 1st Sem</strong></h4>
                </thead>

                <tbody>
<?php 
if ($_SESSION['userid'] != $_GET['stud_id']) {
  header("location: ../404/404.php");
}

$sy=mysqli_query($db,"SELECT * from tbl_schoolyears left join tbl_year_levels on tbl_schoolyears.year_id=tbl_year_levels.year_id where stud_id='$_GET[stud_id]' and year_level='3rd Year' and sem_id='First Semester' ")or die(mysqli_error($db));
$syrow=mysqli_fetch_array($sy);
if (mysqli_num_rows($sy) >= 1) 
{
$squery = mysqli_query($db, "SELECT tbl_subjects_new.unit_total, tbl_subjects_new.subj_code, tbl_subjects_new.subj_desc, tbl_enrolled_subjects.numgrade
          FROM tbl_enrolled_subjects
          LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
          LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id WHERE tbl_students.stud_id = '$_GET[stud_id]'  AND semester = '$syrow[sem_id]' and acad_year = '$syrow[ay_id]' AND tbl_subjects_new.course_id = '$syrow[course_id]' ")or die(mysqli_error($db));
         
              if (mysqli_num_rows($squery) >= 1) 
              {
                while($row2 = mysqli_fetch_array($squery))
                  {
                   ?>   
                    <tr>
                    <td><?php echo $row2['subj_code']?></td>
                    <td><?php echo $row2['subj_desc']?></td>
                    <td><?php echo $row2['numgrade']?></td>
                    <td><?php echo $row2['unit_total']?></td>
                    <td></td>
                    <td></td>
                    </tr>
                      <?php
                  }
              }
}
?>




                


                </tbody>
              </table>
              </table>
              <table id="" class="table table-condensed table-striped">
                <thead>
                  <col width="80">
                  <col width="250">
                  <col width="50">
                  <col width="50">
                  <col width="80">
                  <col width="80">
                <h4><strong>3rd Year, 2nd Sem</strong></h4>
                </thead>

                <tbody>
<?php 
if ($_SESSION['userid'] != $_GET['stud_id']) {
  header("location: ../404/404.php");
}

$sy=mysqli_query($db,"SELECT * from tbl_schoolyears left join tbl_year_levels on tbl_schoolyears.year_id=tbl_year_levels.year_id where stud_id='$_GET[stud_id]' and year_level='3rd Year' and sem_id='Second Semester' ")or die(mysqli_error($db));
$syrow=mysqli_fetch_array($sy);
if (mysqli_num_rows($sy) >= 1) 
{
$squery = mysqli_query($db, "SELECT tbl_subjects_new.unit_total, tbl_subjects_new.subj_code, tbl_subjects_new.subj_desc, tbl_enrolled_subjects.numgrade
          FROM tbl_enrolled_subjects
          LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
          LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id WHERE tbl_students.stud_id = '$_GET[stud_id]'  AND semester = '$syrow[sem_id]' and acad_year = '$syrow[ay_id]' AND tbl_subjects_new.course_id = '$syrow[course_id]' ")or die(mysqli_error($db));
         
              if (mysqli_num_rows($squery) >= 1) 
              {
                while($row2 = mysqli_fetch_array($squery))
                  {
                   ?>   
                    <tr>
                    <td><?php echo $row2['subj_code']?></td>
                    <td><?php echo $row2['subj_desc']?></td>
                    <td><?php echo $row2['numgrade']?></td>
                    <td><?php echo $row2['unit_total']?></td>
                    <td></td>
                    <td></td>
                    </tr>
                      <?php
                  }
              }
}
?>




                


                </tbody>
              </table>
              </table>
              <table id="" class="table table-condensed table-striped">
                <thead>
                  <col width="80">
                  <col width="250">
                  <col width="50">
                  <col width="50">
                  <col width="80">
                  <col width="80">
                <h4><strong>4th Year, 1st Sem</strong></h4>
                </thead>

                <tbody>
<?php 
if ($_SESSION['userid'] != $_GET['stud_id']) {
  header("location: ../404/404.php");
}

$sy=mysqli_query($db,"SELECT * from tbl_schoolyears left join tbl_year_levels on tbl_schoolyears.year_id=tbl_year_levels.year_id where stud_id='$_GET[stud_id]' and year_level='4th Year' and sem_id='First Semester' ")or die(mysqli_error($db));
$syrow=mysqli_fetch_array($sy);
if (mysqli_num_rows($sy) >= 1) 
{
$squery = mysqli_query($db, "SELECT tbl_subjects_new.unit_total, tbl_subjects_new.subj_code, tbl_subjects_new.subj_desc, tbl_enrolled_subjects.numgrade
          FROM tbl_enrolled_subjects
          LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
          LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id WHERE tbl_students.stud_id = '$_GET[stud_id]'  AND semester = '$syrow[sem_id]' and acad_year = '$syrow[ay_id]' AND tbl_subjects_new.course_id = '$syrow[course_id]' ")or die(mysqli_error($db));
         
              if (mysqli_num_rows($squery) >= 1) 
              {
                while($row2 = mysqli_fetch_array($squery))
                  {
                   ?>   
                    <tr>
                    <td><?php echo $row2['subj_code']?></td>
                    <td><?php echo $row2['subj_desc']?></td>
                    <td><?php echo $row2['numgrade']?></td>
                    <td><?php echo $row2['unit_total']?></td>
                    <td></td>
                    <td></td>
                    </tr>
                      <?php
                  }
              }
}
?>




                


                </tbody>
              </table>
              </table>
              <table id="" class="table table-condensed table-striped">
                <thead>
                  <col width="80">
                  <col width="250">
                  <col width="50">
                  <col width="50">
                  <col width="80">
                  <col width="80">
                <h4><strong>4th Year, 2nd Sem</strong></h4>
                </thead>

                <tbody>
<?php 
if ($_SESSION['userid'] != $_GET['stud_id']) {
  header("location: ../404/404.php");
}

$sy=mysqli_query($db,"SELECT * from tbl_schoolyears left join tbl_year_levels on tbl_schoolyears.year_id=tbl_year_levels.year_id where stud_id='$_GET[stud_id]' and year_level='4th Year' and sem_id='Second Semester' ")or die(mysqli_error($db));
$syrow=mysqli_fetch_array($sy);
if (mysqli_num_rows($sy) >= 1) 
{
$squery = mysqli_query($db, "SELECT tbl_subjects_new.unit_total, tbl_subjects_new.subj_code, tbl_subjects_new.subj_desc, tbl_enrolled_subjects.numgrade
          FROM tbl_enrolled_subjects
          LEFT JOIN tbl_students ON tbl_students.stud_id = tbl_enrolled_subjects.stud_id
          LEFT JOIN tbl_subjects_new ON tbl_subjects_new.subj_id = tbl_enrolled_subjects.subj_id WHERE tbl_students.stud_id = '$_GET[stud_id]'  AND semester = '$syrow[sem_id]' and acad_year = '$syrow[ay_id]' AND tbl_subjects_new.course_id = '$syrow[course_id]' ")or die(mysqli_error($db));
         
              if (mysqli_num_rows($squery) >= 1) 
              {
                while($row2 = mysqli_fetch_array($squery))
                  {
                   ?>   
                    <tr>
                    <td><?php echo $row2['subj_code']?></td>
                    <td><?php echo $row2['subj_desc']?></td>
                    <td><?php echo $row2['numgrade']?></td>
                    <td><?php echo $row2['unit_total']?></td>
                    <td></td>
                    <td></td>
                    </tr>
                      <?php
                  }
              }
}
?>




                


                </tbody>
              </table>
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
