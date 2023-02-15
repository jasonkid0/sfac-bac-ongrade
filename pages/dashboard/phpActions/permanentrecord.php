<?php
include '../../../includes/db.php';


if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $db->real_escape_string($_POST['id']);
    $status = $db->real_escape_string($_POST['status']);
    $semester = $db->real_escape_string($_POST['semester']);
    $ay = $db->real_escape_string($_POST['ay']);

    $db->query("UPDATE tbl_enrolled_subjects SET accounting_status = '$status' WHERE acad_year = '$ay' AND semester = '$semester' AND stud_id = '$id'");
}

if (isset($_POST['submit_all']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

    $status = substr($_POST['status'], 4);
    $status = $db->real_escape_string($status);
    $semester = $db->real_escape_string($_POST['semester']);
    $ay = $db->real_escape_string($_POST['ay']);

    $db->query("UPDATE tbl_enrolled_subjects SET accounting_status = '$status' WHERE acad_year = '$ay' AND semester = '$semester'");
}