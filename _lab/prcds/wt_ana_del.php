<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['t'])){
	$id=pp($_POST['id']);
	$t=pp($_POST['t']);	
	if($t==0){
		$tot=getTotalCO('lab_x_visits_services'," w_table=0 and status in(5) and service='$id'");
		$srvTxt=get_val('lab_m_services','short_name',$id);	?>
		<div class="win_body">
		<div class="form_header"><div class=" lh40 clr1 f1 fs18 fll"><?=$srvTxt?> <ff class="clr55">(<?=$tot ?>)</div></div>
		<div class="form_body so">
			<div class="bu bu_t1" wgad1><?=k_not_include_work_tables?></div>
			<div class="bu bu_t3" wgad2><?=k_not_show_ser?></div>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
		</div>
		</div><?
	}else{
		if($t==1){
			if(mysql_q("UPDATE lab_x_visits_services SET w_table='-1' where w_table=0 and status in(5) and service='$id' ")){echo 1;}
		}
		if($t==2){
			if(mysql_q("UPDATE lab_m_services SET add_to_table='0' where id='$id' ")){echo 1;}
		}
		
	}
}?>