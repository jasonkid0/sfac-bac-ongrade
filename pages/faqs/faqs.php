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
      <h1>Frequently Asked Questions</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Main row -->
            <div class="row">
            <div class="col-md-12">
              <form method="POST">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <select name="name" id="name" data-style="btn btn-primary btn-round" required class="form-control select-2">
                      <?php
                       if ($_SESSION['role'] == "Registrar") {
                        ?>
                        <option value="grade_enable_disable.pdf"> How to Enable and Disable Students Grades</option>
                        <?php
                       } else if ($_SESSION['role'] == "Faculty Staff") {
                      ?>
                        <option value="add_students.pdf"> How to Add Students in Schoology</option>
                        <!-- <option value="enter_grade.pdf"> How to Enter Student's Grade</option> -->
                      <?php
                         }  else {
                        ?>
                        <option value="grade.pdf"> How to View Grades</option>
                        <?php
                       }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="">
                    <div class="form-group">
                      <center><button type="submit" name="search" class="btn btn-md btn-primary">Search</button></center>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <?php if (isset($_POST['search'])) {
                $link = mysqli_real_escape_string($db,$_POST['name']);
            echo'<script>{
                location.replace("'.$link.'")}
                </script>';

                ?>
          
                            <?php
                            } ?>
                                                        
                                      

                      </tbody>
                    </table>
                  </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
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
