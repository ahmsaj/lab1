<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body">
<div class="form_header lh40 f1 fs18 clr1">
<!--<div class="fr printIcon" title="<?=k_print_sams?>" onclick="printLab(1,1)"> </div>-->
</div>
<div class="form_body of w100 fxg" type="static" fxg="gtc:25% 1fr|gtr:1fr">
	<div class="fl r_bord of fxg h100" fxg="gtr:auto 1fr">
		<div class="f1 fs18 lh40 clr1 uLine mg10 TC"><?=k_samples_groups_tday?></div>
		<div class="mg10 samp_grp_list ofx so">
			<div n="0" class="TC uLine"><?=k_unassembled_view?></div>
			<? 
			$sql="select * from lab_x_visits_samlpes_group where date > '$ss_day' order by date DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			while($r=mysql_f($res)){
				$g_id=$r['id'];
				$name=$r['name'];
				$date=$r['date'];
				$status=$r['status'];				
				echo '<div n="'.$g_id.'" s="'.$status.'">'.splitNo($name).'<br><span>'.date('A h:i',$date).'</span></div>';
			}?>
		</div>
	</div>
	<div class="fl h100 of so " fix1="wp%:75|hp:0" id="sampGrpDet">
		
	</div>
</div>
<div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win('close','#full_win1');"><?=k_close?></div></div>
</div>