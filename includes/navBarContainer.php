<div id="navBarContainer">
    <nav class="navBar">
        <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
            <img src="assets/images/icons/logo.png" alt="JustMusic">
        </span>

        <div class="group">
            <div class="navItem">
                <span role='link' tabindex='0' onclick="openPage('search.php')" class="navitemlink">搜尋
                    <img src="assets/images/icons/search.png" alt="搜尋" class="icon">
                </span>
            </div>
        </div>

        <div class="group">
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">瀏覽</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">你的音樂</span>
            </div>

            <div class="navItem">
               <span role="link" tabindex="0" onclick="openPage('settings.php')" class="navItemLink"><?php echo $userLoggedIn->getFirstAndLastName(); ?></span>
            </div>
        </div>
    </nav>
</div>