<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['v_id'],$_POST['srv'])){
	$vis=pp($_POST['v_id']);
	$srv=pp($_POST['srv']);
	$sql="select * from bty_x_visits_services where id='$srv' and visit_id='$vis' and status in (0,2) limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		$r=mysql_f($res);
		$service=$r['service'];
		list($cat,$ser_name)=get_val('bty_m_services','cat,name_'.$lg,$service);
		$cat_name=get_val('bty_m_services_cat','name_'.$lg,$cat);
		$note=$r['note'];
		?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><?=$cat_name.' ( '.$ser_name.' ) '?></div>
		<div class="form_body so">
		<div class="f1 fs16 clr5 lh30"><?=k_srv_notes?> </div>
		<textarea class="w100" id="b_note"><?=$note?></textarea>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
			<div class="bu bu_t3 fl" onclick="bty_finshSrvDo(<?=$srv?>);"><?=k_end?></div>
		</div>
		</div><?
	}
}?>