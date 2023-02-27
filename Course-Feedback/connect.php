<?php
    $DB_SERVER = "localhost";
    $DB_USER = "root";
    $DB_PASSWORD = "smallting.94214";
    $DB_NAME = "course_feedback";

    $conn = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASSWORD, $DB_NAME);
    if(!$conn){
        die("<script type='text/javascript'>alert('" . mysqli_connect_error() . "');</script>");
    }
    mysqli_set_charset($conn, "utf8");
?>