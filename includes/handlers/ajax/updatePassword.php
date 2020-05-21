<?php
include("../../config.php");

    if(!isset($_POST['username'])){
        echo "錯誤：無法設定此帳號";
        exit();
    }

    if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])){
        echo "不是所有密碼皆設定成功";
        exit();
    }

    if($_POST['oldPassword']=="" || $_POST['newPassword1']=="" || $_POST['newPassword2']==""){
        echo "請填寫所有欄位";
        exit();
    }

    $username = $_POST['username'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword1 = $_POST['newPassword1'];
    $newPassword2 = $_POST['newPassword2'];

    $oldMd5 = md5($oldPassword);

    $passwordCheck = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$$oldMd5'");
    if(mysqli_num_rows($passwordCheck)!=1){
        echo "密碼輸入錯誤";
        exit();
    }

    if($newPassword1 != $newPassword2){
        echo "您輸入的新密碼不相符";
        exit();
    }

    if(preg_match('/[^A-Za-z0-9]/', $newPassword1)){
        echo "您輸入的密碼只能包含英文字母和數字";
        exit();
    }

    if(strlen($newPassword1) > 30 || strlen($newPassword1) < 5){
        echo "您的密碼必須介於5~30個字元之間";
        exit();
    }

    $newMd5 = md5($newPassword1);
    $query = mysqli_query($con, "UPDATE users SET password='$newMd5' WHERE username='$username'");
    echo "用戶密碼更新完成！";

?>