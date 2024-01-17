<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
$id=pp($_POST['id'],'s');
	$cats=modListToArray('66epjw1t3u');
	$title=$cats[$id];
	$sql="select * from _help where cat='$id' and act=1 order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
	if($title){?>
	<div class="win_body">
	<div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win1');"></div></div>
	<div class="form_header so lh40 clr1 f1 fs18"></div>
	<div class="form_body of" type="pd0">
		<div class="fl r_bord of " fix="w:300|hp:0">
			<div class="lh50 pd10 uLine clr1 f1 fs18"><?=$title?> <ff> ( <?=$rows?> )</ff></div>
			<div class="vidLinks pd10f ofx so" actButt="act" fix="w:300|hp:60"><?
			if($rows){
				$i=1;
				$act='act';
				while($r=mysql_f($res)){
					$name=$r['name_'.$lg];
					$video=$r['video_'.$lg];
					echo '<div class="f1 fs14 " '.$act.' v="'.$video.'"><ff>'.$i.'.  </ff>'.$name.'</div>';
					if($i==1){$actVid=$video;}
					$act='';
					$i++;
				}
			}else{
				echo '<div class="f1 fs16 lh40 clr5">لايوجد فيديوها حاليا</div>';
			}
			?>
			</div>
		</div>
		<div class="fl of pd10f cbg9" fix="wp:300|hp:0" id="vidC">
			<? if($actVid){?>
			<video width="100%" height="100%" controls autoplay>
			  <source src="../videos/<?=$actVid?>" type="video/mp4" id="vSrc">		  
			  Your browser does not support HTML5 video.
			</video>
			<? }?>
		</div>
    </div>
	<div class="form_fot fr">&nbsp;</div>
    </div><?
	}
}?>