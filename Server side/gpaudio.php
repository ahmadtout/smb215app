<?php require_once('Connections/conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conn, $conn);
$query_rs_audio = "SELECT * FROM audio";
$rs_audio = mysql_query($query_rs_audio, $conn) or die(mysql_error());
$row_rs_audio = mysql_fetch_assoc($rs_audio);
$totalRows_rs_audio = mysql_num_rows($rs_audio);
?>

<div class="col-sm-12 nopadding  demo-container" id="jp_container"  >
 
  <?php do { ?>
  
     <div class="audio-item">
        <div class="icon-audio">
         <a href="<?php echo $row_rs_audio['audio_link']; ?>" download="<?php echo $row_rs_audio['audio_name']; ?>.mp3" style="text-decoration:none;" >
                <span class=" fa-stack margin-icons-home">
                                <i class="fa fa-circle fa-stack-2x color_brown"></i>
                                <i class="fa fa-cloud-download  fa-stack fa-inverse"></i>
                            </span>
                        </a>    
         
             <span class=" fa-stack margin-icons-home track" ref="<?php echo $row_rs_audio['audio_link']; ?>" title="<?php echo $row_rs_audio['audio_name']; ?>">
                                <i class="fa fa-circle fa-stack-2x color_brown"></i>
                                <i class="fa fa-play  fa-stack fa-inverse"></i>
                            </span>    
                           </div>
                           
                   <span class="text-audio" ><?php echo $row_rs_audio['audio_name']; ?></span>                     
        </div>
      
     
    <?php } while ($row_rs_audio = mysql_fetch_assoc($rs_audio)); ?>
 


 
     
      
    
 </div> 

 <div id="jquery_jplayer_1"  class="jp-jplayer"></div>
<div id="jp_container_1" class="jp-audio" style="display:none;" role="application" aria-label="media player">
	<div class="jp-type-single">
		<div class="jp-gui jp-interface">
			<div class="jp-controls">
				<button class="jp-play" role="button" tabindex="0">play</button>
				<button class="jp-stop" role="button" tabindex="0">stop</button>
			</div>
			<div class="jp-progress">
				<div class="jp-seek-bar">
					<div class="jp-play-bar"></div>
				</div>
			</div>
			<div class="jp-volume-controls">
				<button class="jp-mute" role="button" tabindex="0">mute</button>
				<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
				<div class="jp-volume-bar">
					<div class="jp-volume-bar-value"></div>
				</div>
			</div>
			<div class="jp-time-holder">
				<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
				<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
				<div class="jp-toggles">
					<button class="jp-repeat" role="button" tabindex="0">repeat</button>
				</div>
			</div>
		</div>
		<div class="jp-details">
			<div class="jp-title" aria-label="title">&nbsp;</div>
		</div>
		<div class="jp-no-solution">
			<span>Update Required</span>
			To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
		</div>
	</div>
</div> 

<script type="text/javascript">
$(document).ready(function() {

 var my_jPlayer = $("#jquery_jplayer_1");
 var my_trackName = "";
 my_jPlayer.jPlayer({
        ready: function(event) {
            $(this).jPlayer("setMedia", {
				title: "",
				mp3: "" 
            });
        },
        swfPath: "http://jplayer.org/latest/dist/jplayer",
        supplied: "mp3, oga",
		wmode: "window",
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true,
		remainingDuration: true,
		toggleDuration: true
    }); 
	
	// Create click handlers for the different tracks
	 $("#jp_container .track").click(function(e) {
		 var isplayed = $(this).find('.fa-inverse').hasClass('fa-pause');
		 $('#jp_container_1').show();
		 $('.track .fa-inverse').removeClass('fa-pause').addClass('fa-play');
		 if(!isplayed)
		 $(this).find('.fa-inverse').removeClass('fa-play').addClass('fa-pause');
		 
		my_trackName=$(this).attr("title");
		my_jPlayer.jPlayer("setMedia", {
			title:my_trackName,
			mp3: $(this).attr("ref")
		});
		 
		 	if(isplayed)
			my_jPlayer.jPlayer("pause");
			else
			my_jPlayer.jPlayer("play");
		 
	}); 

  
	
});                                      
                               

</script>
<?php
mysql_free_result($rs_audio);
?>