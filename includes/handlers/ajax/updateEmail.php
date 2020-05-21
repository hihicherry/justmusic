<?php
include("../../config.php");

    if(!isset($_POST['username'])){
        echo "錯誤：無法設定此帳號";
        exit();
    }

    if(isset($_POST['email']) && $_POST['email'] != ""){
        $username = $_POST['username'];
        $email = $_POST['email'];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "無法使用此email帳號";
            exit();
        }

        $emailCheck = mysqli_query($con, "SELECT email FROM users WHERE email='$email' AND username!='$username'");
        if(mysqli_num_rows($emailCheck) > 0){
            echo "此email已被其他用戶使用了";
            exit();
        }

        $updateQuery = mysqli_query($con, "UPDATE users SET email='$email' WHERE username='$username'");
        echo "email更新成功！";
    }else{
        echo "請輸入email帳號";
    }
?>