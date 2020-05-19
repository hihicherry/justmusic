<?php include("../../config.php");
    if(isset($_POST['name']) && isset($_POST['username'])){
        $name = $_POST['name'];
        $username = $_POST['username'];
        $date = date("Y-m-d");

        $query = mysqli_query($con, "INSERT INTO playlists VALUES(null, '$name', '$username', '$date')");
    }else{
        echo "名稱或是使用者名稱無法加入檔案";
    }
?>