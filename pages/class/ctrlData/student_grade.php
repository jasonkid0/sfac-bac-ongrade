<?php
include '../../../includes/db.php';
include '../../../includes/session.php';
if (isset($_POST['btn_save'])) 

{

    $special_tut = mysqli_real_escape_string($db,$_POST['special_tut']);
                    $enrolled_subj_id = mysqli_real_escape_string($db,$_POST['hidden_id']);

      if ($_SESSION['active_sem'] == 'First Semester' || $_SESSION['active_sem'] == 'Second Semester') 
      {
                        if ($special_tut == '0' || $special_tut == '')
                        {
                                if (empty($_POST['prelim'])) {
                                  $prelim = mysqli_real_escape_string($db,'0');
                                }else{
                                $prelim = mysqli_real_escape_string($db,$_POST['prelim']);
                                }
                                if (empty($_POST['midterm'])) {
                                  $midterm = mysqli_real_escape_string($db,'0');
                                }else{
                                $midterm = mysqli_real_escape_string($db,$_POST['midterm']);
                                }
                                if (empty($_POST['finalterm'])) {
                                  $finalterm = mysqli_real_escape_string($db,'0');
                                }else{
                                $finalterm = mysqli_real_escape_string($db,$_POST['finalterm']);
                                }
                                $ofgrade = mysqli_real_escape_string($db,number_format( (float)(($prelim * 0.3) + ($midterm * 0.3) + ($finalterm * 0.4)), 2, '.', '' ) );

                                if ($prelim== '0' || $midterm == '0' || $finalterm == '0') {
                                  $remarks = mysqli_real_escape_string($db,'INC');
                                  $numgrade = mysqli_real_escape_string($db,'INC');
                                }else{
                                      if ($ofgrade <= 74) {
                                        $numgrade = mysqli_real_escape_string($db,'5.00');
                                        $remarks = mysqli_real_escape_string($db,'Failed');
                                      }elseif ($ofgrade <= 79.49){
                                        $numgrade = mysqli_real_escape_string($db,'3.00');
                                        $remarks = mysqli_real_escape_string($db,'Passed');
                                      }elseif ($ofgrade <= 82.49){
                                        $numgrade = mysqli_real_escape_string($db,'2.75');
                                        $remarks = mysqli_real_escape_string($db,'Passed');
                                      }elseif ($ofgrade <= 84.49){
                                        $numgrade = mysqli_real_escape_string($db,'2.50');
                                        $remarks = mysqli_real_escape_string($db,'Passed');
                                      }elseif ($ofgrade <= 87.49){
                                        $numgrade = mysqli_real_escape_string($db,'2.25');
                                        $remarks = mysqli_real_escape_string($db,'Passed');
                                      }elseif ($ofgrade <= 92.49){
                                        $numgrade = mysqli_real_escape_string($db,'2.00');
                                        $remarks = mysqli_real_escape_string($db,'Passed');
                                      }elseif ($ofgrade <= 95.49){
                                        $numgrade = mysqli_real_escape_string($db,'1.75');
                                        $remarks = mysqli_real_escape_string($db,'Passed');
                                      }elseif ($ofgrade <= 97.49){
                                        $numgrade = mysqli_real_escape_string($db,'1.50');
                                        $remarks = mysqli_real_escape_string($db,'Passed');
                                      }elseif ($ofgrade <= 99.99){
                                        $numgrade = mysqli_real_escape_string($db,'1.25');
                                        $remarks = mysqli_real_escape_string($db,'Passed');
                                      }elseif ($ofgrade == 100){
                                        $numgrade = mysqli_real_escape_string($db,'1.00');
                                        $remarks = mysqli_real_escape_string($db,'Passed');
                                      }
                                    }
                                     $absences = mysqli_real_escape_string($db,$_POST['absences']);
                                     
                                     
                                     


                    $query = mysqli_query($db,"
                      UPDATE tbl_enrolled_subjects 
                      SET prelim='".$prelim."',
                    midterm='".$midterm."',
                    finalterm='".$finalterm."',
                    ofgrade='".$ofgrade."',
                    numgrade='".$numgrade."',
                    absences='".$absences."',
                    remarks='".$remarks."',
                    last_update ='".date('Y-m-d H:i:s')."', 
                    updated ='".$_SESSION['role']." - ".$_SESSION['name']."' 
                      WHERE enrolled_subj_id = '".$enrolled_subj_id."'")or die(mysqli_error($db));
                    if($query == true)
                      { 
                        header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                        message("Successfully Updated!","success");
                      }else{
                        header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                        message("Something went wrong!","danger");
                      }
                          }
                          else
                          { 
                            if (empty($_POST['midterm'])) {
                        $midterm = mysqli_real_escape_string($db,'0');
                      }else{
                      $midterm = mysqli_real_escape_string($db,$_POST['midterm']);
                      }
                      if (empty($_POST['finalterm'])) {
                        $finalterm = mysqli_real_escape_string($db,'0');
                      }else{
                      $finalterm = mysqli_real_escape_string($db,$_POST['finalterm']);
                      }
                      $ofgrade = mysqli_real_escape_string($db,number_format( (float)( ($midterm * 0.4) + ($finalterm * 0.6)), 2, '.', '' ) );

                      if ($midterm == '0' || $finalterm == '0') {
                        $remarks = mysqli_real_escape_string($db,'INC');
                        $numgrade = mysqli_real_escape_string($db,'INC');
                      }else{
                      if ($ofgrade <= 74) {
                        $numgrade = mysqli_real_escape_string($db,'5.00');
                        $remarks = mysqli_real_escape_string($db,'Failed');
                      }elseif ($ofgrade <= 79){
                        $numgrade = mysqli_real_escape_string($db,'3.00');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 82.49){
                        $numgrade = mysqli_real_escape_string($db,'2.75');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 84.49){
                        $numgrade = mysqli_real_escape_string($db,'2.50');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 87.49){
                        $numgrade = mysqli_real_escape_string($db,'2.25');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 92.49){
                        $numgrade = mysqli_real_escape_string($db,'2.00');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 95.49){
                        $numgrade = mysqli_real_escape_string($db,'1.75');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 97.49){
                        $numgrade = mysqli_real_escape_string($db,'1.50');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 99.49){
                        $numgrade = mysqli_real_escape_string($db,'1.25');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade == 100){
                        $numgrade = mysqli_real_escape_string($db,'1.00');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }}
                        $absences = mysqli_real_escape_string($db,$_POST['absences']);
                        
                        $prelim = '';

                        $query = mysqli_query($db,"
                          UPDATE tbl_enrolled_subjects 
                          SET prelim='".$prelim."',
                          midterm='".$midterm."',
                          finalterm='".$finalterm."',
                          ofgrade='".$ofgrade."',
                          numgrade='".$numgrade."',
                          absences='".$absences."',
                          remarks='".$remarks."',
                          last_update ='".date('Y-m-d H:i:s')."',
                          updated ='".$_SESSION['role']." - ".$_SESSION['name']."'
                          WHERE enrolled_subj_id = '".$enrolled_subj_id."'")or die(mysqli_error($db));
                        if($query == true)
                          { 
                            header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                            message("Successfully Updated!","success");
                          }else{
                            header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                            message("Something went wrong!","danger");
                          }
                          }



                   
                    
                  //====================================IF SUMMER TERM==============================
}else{
                    
                      if (empty($_POST['midterm'])) {
                        $midterm = mysqli_real_escape_string($db,'0');
                      }else{
                      $midterm = mysqli_real_escape_string($db,$_POST['midterm']);
                      }
                      if (empty($_POST['finalterm'])) {
                        $finalterm = mysqli_real_escape_string($db,'0');
                      }else{
                      $finalterm = mysqli_real_escape_string($db,$_POST['finalterm']);
                      }
                      $ofgrade = mysqli_real_escape_string($db,number_format( (float)( ($midterm * 0.4) + ($finalterm * 0.6)), 2, '.', '' ) );

                      if ($midterm == '0' || $finalterm == '0') {
                        $remarks = mysqli_real_escape_string($db,'INC');
                        $numgrade = mysqli_real_escape_string($db,'INC');
                      }else{
                      if ($ofgrade <= 74) {
                        $numgrade = mysqli_real_escape_string($db,'5.00');
                        $remarks = mysqli_real_escape_string($db,'Failed');
                      }elseif ($ofgrade <= 79){
                        $numgrade = mysqli_real_escape_string($db,'3.00');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 82.49){
                        $numgrade = mysqli_real_escape_string($db,'2.75');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 84.49){
                        $numgrade = mysqli_real_escape_string($db,'2.50');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 87.49){
                        $numgrade = mysqli_real_escape_string($db,'2.25');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 92.49){
                        $numgrade = mysqli_real_escape_string($db,'2.00');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 95.49){
                        $numgrade = mysqli_real_escape_string($db,'1.75');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 97.49){
                        $numgrade = mysqli_real_escape_string($db,'1.50');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade <= 99.49){
                        $numgrade = mysqli_real_escape_string($db,'1.25');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }elseif ($ofgrade == 100){
                        $numgrade = mysqli_real_escape_string($db,'1.00');
                        $remarks = mysqli_real_escape_string($db,'Passed');
                      }}
                        $absences = mysqli_real_escape_string($db,$_POST['absences']);
                        
                        $prelim = '';

                        $query = mysqli_query($db,"
                          UPDATE tbl_enrolled_subjects 
                          SET  prelim='".$prelim."',
                          midterm='".$midterm."',
                          finalterm='".$finalterm."',
                          ofgrade='".$ofgrade."',
                          numgrade='".$numgrade."',
                          absences='".$absences."',
                          remarks='".$remarks."',
                          last_update ='".date('Y-m-d H:i:s')."',
                          updated ='".$_SESSION['role']." - ".$_SESSION['name']."'
                           WHERE enrolled_subj_id = '".$enrolled_subj_id."'")or die(mysqli_error($db));
                        if($query == true)
                          { 
                            header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                            message("Successfully Updated!","success");
                          }else{
                            header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                            message("Something went wrong!","danger");
                          }
                    }
                    
                    



                    
                  }


?>