<?php
    include("includes/config.php");
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");

    $account = new Account($con);

    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");

    function getInputValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Just Music</title>
    <link rel="stylesheet" href="assets/css/register.css">
    <script src="assets/js/jquery-3.5.0.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>
    <?php
    if(isset($_POST['registerButton'])){
        echo "<script>
                $(document).ready(function(){
                    $('#loginForm').hide();
                    $('#registerForm').show();
                });
                </script>";
    }else{
        echo "<script>
                $(document).ready(function(){
                    $('#loginForm').show();
                    $('#registerForm').hide();
                });
                </script>";
    }
    ?>

    <div id="background">
        <div id="loginContainer">
            <div id="inputContainer">
                <form id="loginForm" action="register.php" method="POST">
                    <h2>會員登入</h2>
                    <p>
                        <?php echo $account->getError(Constants::$loginFailed); ?>
                        <label for="loginUsername">帳號</label>
                        <input id="loginUsername" name="loginUsername" type="text" placeholder="ex. maxwang" value="<?= getInputValue('loginUsername') ?>" required">
                    </p>
                    <p>
                        <label for="userPassword">密碼</label>
                        <input id="loginPassword" name="loginPassword" type="password" placeholder="請輸入您的密碼" required>
                    </p>
                <button type="submit" name="loginButton">登入</button>
                <div class="hasAccountText">
                    <span id="hideLogin">還未加入會員嗎？請點此註冊</span>
                </div>
                </form>


                <form id="registerForm" action="register.php" method="POST">
                    <h2>會員註冊</h2>
                    <p>
                        <?php echo $account->getError(Constants::$usernameCharacters); ?>
                        <?php echo $account->getError(Constants::$usernameTaken); ?>
                        <label for="username">帳號</label>
                        <input id="username" name="username" type="text" placeholder="ex. maxwang" value="<?= getInputValue('username') ?>" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                        <label for="firstName">名字</label>
                        <input id="firstname" name="firstName" type="text" placeholder="ex. 小明" value="<?= getInputValue('firstName') ?>" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                        <label for="lastName">姓氏</label>
                        <input id="lastName" name="lastName" type="text" placeholder="ex. 王" value="<?= getInputValue('lastName') ?>" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                        <?php echo $account->getError(Constants::$emailInvalid); ?>
                        <?php echo $account->getError(Constants::$emailTaken); ?>
                        <label for="email">電子信箱 Email</label>
                        <input id="email" name="email" type="email" placeholder="ex. wang@gmail.com" value="<?= getInputValue('email') ?>" required>
                    </p>
                    <p>
                        <label for="email2"">電子信箱確認</label>
                        <input id="email2" name="email2" type="email" placeholder="再次輸入您的email" value="<?= getInputValue('email2') ?>" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                        <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
                        <?php echo $account->getError(Constants::$usernameCharacters); ?>
                        <label for="password">密碼</label>
                        <input id="password" name="password" type="password" placeholder="請輸入您的密碼" required>
                    </p>
                    <p>
                        <label for="password2">密碼確認</label>
                        <input id="password2" name="password2" type="password" placeholder="再次輸入您的密碼" required>
                    </p>
                    <button type="submit" name="registerButton">註冊</button>
                    <div class="hasAccountText">
                        <span id="hideRegister">已經註冊過JustMusic會員？請點此登入</span>
                    </div>
                </form>
            </div>
            <div id="loginText">
                <h1>Just Music音樂串流平台</h1>
                <h2>免費收聽各種風格的歌曲</h2>
                <ul>
                    <li>尋找你喜愛的音樂</li>
                    <li>建立自己的播放清單</li>
                    <li>追蹤喜愛歌手的最新資訊</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>