<? include("../../__sys/prcds/ajax_header.php");?>
	<div class="win_body">	
	<div class="form_body so">
		<div class="f1 fs18 clr1 lh40"><?=k_new_group?></div>
		<input type="text" id="grpSname"/><? 
		$sql="select * from lab_x_visits_samlpes_group where date > '$ss_day' and status=0 order by date DESC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			echo '<div n="0" class="lh30 uLine">&nbsp;</div>
			<div class="f1 fs18 clr1 lh40">'.k_another_group_add.'</div>
			<div class="mg10 samp_grp_list ofx so" fix="hp:51">';
			while($r=mysql_f($res)){
				$g_id=$r['id'];
				$name=$r['name'];
				$date=$r['date'];
				$status=$r['status'];				
				echo '<div  s="'.$status.'" onclick="saveSampGrop('.$g_id.')" >'.splitNo($name).'<br><span>'.date('A h:i').'</span></div>';
			}
			echo '</div>';
		}?>
			
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
		<div class="bu bu_t3 fl" onclick="saveSampGrop(0)"><?=k_save?></div>
    </div>
    </div><?
?>