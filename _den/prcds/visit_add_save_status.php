<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$cType=4;
	$v_id=pp($_POST['id']);
	$sql="select * from den_x_visits where id='$v_id' and status=0";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$patient=$r['patient'];
		$clinic=$r['clinic'];
		$type=$r['type'];
		$d_start=$r['d_start'];
		$status=$r['status'];
		$p_name=get_p_name($patient);
		$c_name=get_val('gnr_m_clinics','name_'.$lg,$clinic);
		$total2=_set_lbza344hl;?>
        <div class="win_body">
            <div class="form_header">
				<div class="fl f1 fs16 clr1 lh40 Over" onclick="check_card_do(<?=$patient?>)">
					<?=k_patient?> : <?=get_p_name($patient)?>
				</div>
				<div class="fr f1 fs16 clr1 lh40"><?=k_clinic?> : <?=$c_name?></div>
            </div>        
			<div class="form_body so" id="denElm">
				<div class="bu bu_t1 " id="b2" onclick="win('close','#m_info');printTicket2(4,<?=$v_id?>,1)"><?=k_treatment_session?> </div>
				<div class="bu bu_t1 " onclick="win('close','#m_info');printTicket2(4,<?=$v_id?>,2)"><?=k_consultation?>  : <ff><?=$total2?></ff> <?=k_sp?></div>
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
				<div class="bu bu_t3 fr" onclick="delVis(<?=$v_id?>,<?=$cType?>)"><?=k_delete?></div>
				
			</div>
		</div><?	
	}else{
		delTempOpr($cType,$v_id,'a');
		echo script("win('close','#m_info');");
		
	}
}?>