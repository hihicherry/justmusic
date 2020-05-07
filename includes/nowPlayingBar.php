<?php

$songQuery = mysqli_query($con, "SELECT id FROM Songs ORDER BY RAND() LIMIT 10");
$resultArray = array();

while ($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);
?>

<script>
    $(document).ready(function() {
        currentPlaylist = <?php echo $jsonArray; ?>;
        audioElement = new Audio();
        setTrack(currentPlaylist[0], currentPlaylist, false);
        updateVolumeProgressBar(audioElement.audio);

        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e){
            //on後面可接不止一個事件
            e.preventDefault(); //預防事件預設的內容,此處是防止反白
        });

        $(".playbackBar .progressBar").mousedown(function(){
            mouseDown = true;
        });

        $(".playbackBar .progressBar").mousemove(function(e){
            if(mouseDown == true){
                timeFromOffset(e, this);
            }
        });

        $(".playbackBar .progressBar").mouseup(function(e){
            timeFromOffset(e, this);
        });
        
        $(".volumeBar .progressBar").mousedown(function(){
            mouseDown = true;
        });

        $(".volumeBar .progressBar").mousemove(function(e){
            if(mouseDown == true){
                var percentage = e.offsetX / $(this).width();
                if(percentage >= 0 && percentage <= 1){
                    audioElement.audio.volume = percentage;
                }
            }
        });

        $(".volumeBar .progressBar").mouseup(function(e){
            var percentage = e.offsetX / $(this).width();
            if(percentage >= 0 && percentage <= 1){
                    audioElement.audio.volume = percentage;
                }
        });

        $(document).mouseup(function(){
            mouseDown = false;
        });
    });

    function timeFromOffset(mouse, progressBar){
        var percentage = mouse.offsetX / $(progressBar).width() * 100;
        var seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
    }

    function nextSong(){
        if(currentIndex == currentPlaylist.length - 1){
            currentIndex = 0;
        }else{
            currentIndex++;
        }
        var trackToPlay = currentPlaylist['currentIndex'];
        setTrack(trackToPlay, currentPlaylist, true);
    }

    function setTrack(trackId, newPlaylist, play) {

        $.post("includes/handlers/ajax/getSongJson.php", {songId: trackId }, function(data) {

            currentIndex = currentPlaylist.indexOf(trackId);

            var track = JSON.parse(data);
            $(".trackName span").text(track.title);

            $.post("includes/handlers/ajax/getArtistJson.php", {artistId: track.artist }, function(data) {
                var artist = JSON.parse(data);
                $(".artistName span").text(artist.name);
            });

            $.post("includes/handlers/ajax/getAlbumJson.php", {albumId: track.album }, function(data) {
                var album = JSON.parse(data);
                $(".albumLink img").attr("src", album.artworkPath);
            });

            audioElement.setTrack(track);
            playSong();
        });

        if (play == true) {
            audioElement.play();
        }
    }

    function playSong() {
        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
        audioElement.play();
    }

    function pauseSong() {

        if(audioElement.audio.currentTime == 0){
            $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id});
        }

        $(".controlButton.play").show();
        $(".controlButton.pause").hide();
        audioElement.pause();
    }
</script>

<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img class="albumArtwork" src="" alt="">
                </span>

                <div class="trackInfo">
                    <span class="trackName">
                        <span></span>
                    </span>

                    <span class="artistName">
                        <span></span>
                    </span>

                </div>
            </div>
        </div>

        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="隨機播放">
                        <img src="assets/images/icons/shuffle.png" alt="隨機播放">
                    </button>

                    <button class="controlButton previous" title="上一首">
                        <img src="assets/images/icons/previous.png" alt="上一首">
                    </button>

                    <button class="controlButton play" title="播放" onclick="playSong()">
                        <img src="assets/images/icons/play.png" alt="播放">
                    </button>

                    <button class="controlButton pause" title="暫停" style="display: none;" onclick="pauseSong()">
                        <img src="assets/images/icons/pause.png" alt="暫停">
                    </button>

                    <button class="controlButton next" title="下一首">
                        <img src="assets/images/icons/next.png" alt="下一首">
                    </button>

                    <button class="controlButton repeat" title="循環播放">
                        <img src="assets/images/icons/repeat.png" alt="循環播放">
                    </button>
                </div>

                <div class="playbackBar">
                    <span class="progressTime current">0.00</span>

                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>

                    <span class="progressTime remaining">0.00</span>
                </div>

            </div>
        </div>

        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="音量">
                    <img src="assets/images/icons/volume.png" alt="音量">
                </button>

                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>