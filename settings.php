<?php
    $host = "feenix-mariadb.swin.edu.au";
    $user = "s104849906";
    $pwd = "vtkien16";
    $sql_db = "s104849906_db";

    $conn = mysqli_connect($host, $user, $pwd, $sql_db);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
