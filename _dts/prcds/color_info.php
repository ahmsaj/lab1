<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body">
<div class="form_body so"><?
	foreach($dateStatusInfo as $k => $d){
		if($k && $d){
			echo '<div class="cb lh40 uLine">';
				echo '<div class="fl ic30x bord" style="background-color:'.$dateStatusInfoClr[$k].'"></div>';
				echo '<div class="fl f1 fs18 pd10 lh30">'.$d.'</div>&nbsp;';
			echo '</div>';
		}
	}
	echo '<div class="cb lh40 uLine">';
		echo '<div class="fl ic30x bord" style="background-color:#ed9535"></div>';
		echo '<div class="fl f1 fs18 pd10 clr1 lh30">تم الحضور ولكن بدء زمن الموعد  </div>&nbsp;';
	echo '</div>';
	echo '<div class="cb lh40 uLine">';
		echo '<div class="fl ic30x bord" style="background-color:#c32d34"></div>';
		echo '<div class="fl f1 fs18 pd10 clr1 lh30">موعد متأخر جدا</div>&nbsp;';
	echo '</div>';
?>
</div>
<div class="form_fot fr">
	<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
</div>
</div>
