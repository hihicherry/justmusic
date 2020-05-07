<?php

    ob_start();
    session_start();

    $timezone = date_default_timezone_set("Asia/Taipei");

    $con = mysqli_connect("localhost", "root", "1qaz@wsx", "JustMusic");
    if(mysqli_connect_errno()){
        echo "資料庫連接失敗：" . mysqli_connect_errno();
    }


?>