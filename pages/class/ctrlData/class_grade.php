<?php
include '../../../includes/db.php';
include '../../../includes/session.php';


if (isset($_POST['btn_save'])) {

    $prelim_array = array();

    if (isset($_POST['prelim'])) {
        $temp_array = $_POST['prelim'];

        foreach ($temp_array as $index) {
            if ($index != null) {
                array_push($prelim_array, $index);
            } else {
                array_push($prelim_array, 0);
            }
        }
    }

    $midterm_array = array();

    if (isset($_POST['midterm'])) {
        $temp_array = $_POST['midterm'];

        foreach ($temp_array as $index) {
            if ($index != null) {
                array_push($midterm_array, $index);
            } else {
                array_push($midterm_array, 0);
            }
        }
    }

    $finalterm_array = array();

    if (isset($_POST['finalterm'])) {
        $temp_array = $_POST['finalterm'];

        foreach ($temp_array as $index) {
            if ($index != null) {
                array_push($finalterm_array, $index);
            } else {
                array_push($finalterm_array, 0);
            }
        }
    }

    $absences_array = array();

    if (isset($_POST['absences'])) {
        $temp_array = $_POST['absences'];

        foreach ($temp_array as $index) {
            if ($index != null) {
                array_push($absences_array, $index);
            } else {
                array_push($absences_array, 0);
            }
        }
    }

    $special_tut_array = array();

    if (isset($_POST['special_tut'])) {
        $temp_array = $_POST['special_tut'];

        foreach ($temp_array as $index) {
            if ($index != null) {
                array_push($special_tut_array, $index);
            } else {
                array_push($special_tut_array, 0);
            }
        }
    }

    $student_array = array();

    if (isset($_POST['student_array'])) {
        $temp_array = $_POST['student_array'];

        foreach ($temp_array as $index) {
            if ($index != null) {
                array_push($student_array, $index);
            } else {
                array_push($student_array, 0);
            }
        }
    }

    $i = 0;

    foreach ($student_array as $id) {

        if ($_SESSION['active_sem'] == 'First Semester' || $_SESSION['active_sem'] == 'Second Semester') /////////// summer
        {
            if ($special_tut_array[$i] == '0' || $special_tut_array[$i] == '') {
                if (empty($prelim_array[$i])) {
                    $prelim = mysqli_real_escape_string($db, '0');
                } else {
                    $prelim = $prelim_array[$i];
                }
                if (empty($midterm_array[$i])) {
                    $midterm = mysqli_real_escape_string($db, '0');
                } else {
                    $midterm = $midterm_array[$i];
                }
                if (empty($finalterm_array[$i])) {
                    $finalterm = mysqli_real_escape_string($db, '0');
                } else {
                    $finalterm = $finalterm_array[$i];
                }
                $ofgrade = mysqli_real_escape_string($db, number_format((float) (($prelim * 0.3) + ($midterm * 0.3) + ($finalterm * 0.4)), 2, '.', ''));

                if ($prelim == '0' || $midterm == '0' || $finalterm == '0') {
                    $remarks = mysqli_real_escape_string($db, 'INC');
                    $numgrade = mysqli_real_escape_string($db, 'INC');
                } else {
                    if ($ofgrade <= 74) {
                        $numgrade = mysqli_real_escape_string($db, '5.00');
                        $remarks = mysqli_real_escape_string($db, 'Failed');
                    } elseif ($ofgrade <= 79.49) {
                        $numgrade = mysqli_real_escape_string($db, '3.00');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 82.49) {
                        $numgrade = mysqli_real_escape_string($db, '2.75');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 84.49) {
                        $numgrade = mysqli_real_escape_string($db, '2.50');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 87.49) {
                        $numgrade = mysqli_real_escape_string($db, '2.25');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 92.49) {
                        $numgrade = mysqli_real_escape_string($db, '2.00');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 95.49) {
                        $numgrade = mysqli_real_escape_string($db, '1.75');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 97.49) {
                        $numgrade = mysqli_real_escape_string($db, '1.50');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 99.99) {
                        $numgrade = mysqli_real_escape_string($db, '1.25');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade == 100) {
                        $numgrade = mysqli_real_escape_string($db, '1.00');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    }
                }
                $absences = $absences_array[$i];


                $subj_info = mysqli_query($db, "SELECT * FROM tbl_enrolled_subjects WHERE enrolled_subj_id = '$id'");
                $row3 = mysqli_fetch_array($subj_info);

                if ($prelim != $row3['prelim'] || $midterm != $row3['midterm'] || $finalterm != $row3['finalterm'] || $absences != $row3['absences']) {


                    $query = mysqli_query($db, "
                UPDATE tbl_enrolled_subjects 
                SET prelim='" . $prelim . "',
                midterm='" . $midterm . "',
                finalterm='" . $finalterm . "',
                ofgrade='" . $ofgrade . "',
                numgrade='" . $numgrade . "',
                absences='" . $absences . "',
                remarks='" . $remarks . "',
                last_update ='" . date('Y-m-d H:i:s') . "', 
                updated ='" . $_SESSION['role'] . " - " . $_SESSION['name'] . "' 
                WHERE enrolled_subj_id = '" . $id . "'") or die(mysqli_error($db));

                if ($query == true) {
                    header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                    message("Successfully Updated!", "success");
                } else {
                    header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                    message("Something went wrong!", "danger");
                }


                } else {
                    header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                    message("Something went wrong!", "danger");
                }

                


            } else {
                if (empty($midterm_array[$i])) {
                    $midterm = mysqli_real_escape_string($db, '0');
                } else {
                    $midterm = $midterm_array[$i];
                }
                if (empty($finalterm_array[$i])) {
                    $finalterm = mysqli_real_escape_string($db, '0');
                } else {
                    $finalterm = $finalterm_array[$i];
                }
                $ofgrade = mysqli_real_escape_string($db, number_format((float) (($midterm * 0.4) + ($finalterm * 0.6)), 2, '.', ''));

                if ($midterm == '0' || $finalterm == '0') {
                    $remarks = mysqli_real_escape_string($db, 'INC');
                    $numgrade = mysqli_real_escape_string($db, 'INC');
                } else {
                    if ($ofgrade <= 74) {
                        $numgrade = mysqli_real_escape_string($db, '5.00');
                        $remarks = mysqli_real_escape_string($db, 'Failed');
                    } elseif ($ofgrade <= 79) {
                        $numgrade = mysqli_real_escape_string($db, '3.00');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 82.49) {
                        $numgrade = mysqli_real_escape_string($db, '2.75');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 84.49) {
                        $numgrade = mysqli_real_escape_string($db, '2.50');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 87.49) {
                        $numgrade = mysqli_real_escape_string($db, '2.25');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 92.49) {
                        $numgrade = mysqli_real_escape_string($db, '2.00');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 95.49) {
                        $numgrade = mysqli_real_escape_string($db, '1.75');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 97.49) {
                        $numgrade = mysqli_real_escape_string($db, '1.50');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade <= 99.49) {
                        $numgrade = mysqli_real_escape_string($db, '1.25');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    } elseif ($ofgrade == 100) {
                        $numgrade = mysqli_real_escape_string($db, '1.00');
                        $remarks = mysqli_real_escape_string($db, 'Passed');
                    }
                }
                $absences = $absences_array[$i];

                $prelim = '';
                $subj_info = mysqli_query($db, "SELECT * FROM tbl_enrolled_subjects WHERE enrolled_subj_id = '$id'");
                $row3 = mysqli_fetch_array($subj_info);

                if ($prelim != $row3['prelim'] || $midterm != $row3['midterm'] || $finalterm != $row3['finalterm'] || $absences != $row3['absences']) {


                    $query = mysqli_query($db, "
                UPDATE tbl_enrolled_subjects 
                SET prelim='" . $prelim . "',
                midterm='" . $midterm . "',
                finalterm='" . $finalterm . "',
                ofgrade='" . $ofgrade . "',
                numgrade='" . $numgrade . "',
                absences='" . $absences . "',
                remarks='" . $remarks . "',
                last_update ='" . date('Y-m-d H:i:s') . "',
                updated ='" . $_SESSION['role'] . " - " . $_SESSION['name'] . "'
                WHERE enrolled_subj_id = '" . $id . "'") or die(mysqli_error($db));

                if ($query == true) {
                    header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                    message("Successfully Updated!", "success");
                } else {
                    header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                    message("Something went wrong!", "danger");
                }
                } else {
                    header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                    message("Something went wrong!", "danger");
                }

                
            }





            //====================================IF SUMMER TERM==============================
        } else {

            if (empty($midterm_array[$i])) {
                $midterm = mysqli_real_escape_string($db, '0');
            } else {
                $midterm = $midterm_array[$i];
            }
            if (empty($finalterm_array[$i])) {
                $finalterm = mysqli_real_escape_string($db, '0');
            } else {
                $finalterm = $finalterm_array[$i];
            }
            $ofgrade = mysqli_real_escape_string($db, number_format((float) (($midterm * 0.4) + ($finalterm * 0.6)), 2, '.', ''));

            if ($midterm == '0' || $finalterm == '0') {
                $remarks = mysqli_real_escape_string($db, 'INC');
                $numgrade = mysqli_real_escape_string($db, 'INC');
            } else {
                if ($ofgrade <= 74) {
                    $numgrade = mysqli_real_escape_string($db, '5.00');
                    $remarks = mysqli_real_escape_string($db, 'Failed');
                } elseif ($ofgrade <= 79) {
                    $numgrade = mysqli_real_escape_string($db, '3.00');
                    $remarks = mysqli_real_escape_string($db, 'Passed');
                } elseif ($ofgrade <= 82.49) {
                    $numgrade = mysqli_real_escape_string($db, '2.75');
                    $remarks = mysqli_real_escape_string($db, 'Passed');
                } elseif ($ofgrade <= 84.49) {
                    $numgrade = mysqli_real_escape_string($db, '2.50');
                    $remarks = mysqli_real_escape_string($db, 'Passed');
                } elseif ($ofgrade <= 87.49) {
                    $numgrade = mysqli_real_escape_string($db, '2.25');
                    $remarks = mysqli_real_escape_string($db, 'Passed');
                } elseif ($ofgrade <= 92.49) {
                    $numgrade = mysqli_real_escape_string($db, '2.00');
                    $remarks = mysqli_real_escape_string($db, 'Passed');
                } elseif ($ofgrade <= 95.49) {
                    $numgrade = mysqli_real_escape_string($db, '1.75');
                    $remarks = mysqli_real_escape_string($db, 'Passed');
                } elseif ($ofgrade <= 97.49) {
                    $numgrade = mysqli_real_escape_string($db, '1.50');
                    $remarks = mysqli_real_escape_string($db, 'Passed');
                } elseif ($ofgrade <= 99.49) {
                    $numgrade = mysqli_real_escape_string($db, '1.25');
                    $remarks = mysqli_real_escape_string($db, 'Passed');
                } elseif ($ofgrade == 100) {
                    $numgrade = mysqli_real_escape_string($db, '1.00');
                    $remarks = mysqli_real_escape_string($db, 'Passed');
                }
            }
            $absences = $absences_array[$i];

            $prelim = '';
            $subj_info = mysqli_query($db, "SELECT * FROM tbl_enrolled_subjects WHERE enrolled_subj_id = '$id'");
            $row3 = mysqli_fetch_array($subj_info);

            if ($prelim != $row3['prelim'] || $midterm != $row3['midterm'] || $finalterm != $row3['finalterm'] || $absences != $row3['absences']) {


                $query = mysqli_query($db, "
            UPDATE tbl_enrolled_subjects 
            SET  prelim='" . $prelim . "',
            midterm='" . $midterm . "',
            finalterm='" . $finalterm . "',
            ofgrade='" . $ofgrade . "',
            numgrade='" . $numgrade . "',
            absences='" . $absences . "',
            remarks='" . $remarks . "',
            last_update ='" . date('Y-m-d H:i:s') . "',
            updated ='" . $_SESSION['role'] . " - " . $_SESSION['name'] . "'
            WHERE enrolled_subj_id = '" . $id . "'") or die(mysqli_error($db));

                if ($query == true) {
                    header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                    message("Successfully Updated!", "success");
                } else {
                    header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                    message("Something went wrong!", "danger");
                }
            } else {
                header("location: ../section_stud.php?code=".$_GET['code']."&section=". $_GET['section']."&class_desc=".$_GET['class_desc']);
                    message("Something went wrong!", "danger");

            }
            
        }

        $i++;

    }

}
?>