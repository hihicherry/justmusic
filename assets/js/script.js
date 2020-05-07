var currentPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;

function formateTime(seconds){
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60); //四捨五入
    var seconds = time - (minutes * 60); 
    
    var extraZero = (seconds < 10) ? "0" : ""; //如果秒數小於10會自動補0

    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio){
    $(".porgressTime.current").text(formateTime(audio.currentTime));
    $(".porgressTime.remaining").text(formateTime(audio.duration - audio.currentTime));

    var progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio){
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

function Audio(){
    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("canPlay", function(){
        var duration = formateTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("timeupdate", function(){
        //時間線是否有在跑
        if(this.duration){
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function(){
        updateVolumeProgressBar(this);
    });

    this.setTrack = function(track){
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }
    
    this.play = function(){
        this.audio.play();
    }

    this.pause = function(){
        this.audio.pause();
    }

    this.setTime = function(seconds){
        this.audio.currentTime = seconds;
    }
}