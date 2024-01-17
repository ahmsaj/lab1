<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] ,$_POST['t'])){
	$id=pp($_POST['id']);
	$type=pp($_POST['t']);
	$table='gnr_m_services_prices';
	
	$r=getRec($srvTables[$type],$id);
	if($r['r']){
		$service=$r['name_'.$lg];
		$clinc=$r['clinic'];
		$hos_part=$r['hos_part'];
		$doc_part=$r['doc_part'];
		$doc_percent=$r['doc_percent'];
	}?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18">
	<? echo $service.'<ff> ( '.$hos_part.' - '.$doc_part.' - '.$doc_percent.'% )</ff> </div>';?>
	<div class="form_body so"><?
	$saveVals=array();
	$sql="select * from $table where service='$id' and mood='$type' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$doctor=$r['doctor'];
			$v1=$r['hos_part'];
			$v2=$r['doc_part'];
			$v3=$r['doc_percent'];
			if($v1==0){$v1='';}if($v2==0){$v2='';}if($v3==0){$v3='';}
			$saveVals[$doctor]['v1']=$v1;$saveVals[$doctor]['v2']=$v2;$saveVals[$doctor]['v3']=$v3;
		}
	}
	
	$selClnc=getAllLikedClinics($clinc,',');
	if($type==1){$q=" grp_code = '7htoys03le' and subgrp IN($selClnc)";}
	if($type==3){$q=" grp_code = 'nlh8spit9q' ";}
	if($type==4){$q=" grp_code = 'fk590v9lvl' ";}
	if($type==5){$q=" grp_code = '9yjlzayzp' ";}
	if($type==7){$q=" grp_code = '9k0a1zy2ww' ";}
	
	$sql="select * from _users where  $q and act=1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		echo '<form name="cst" id="cst" action="'.$f_path.'X/gnr_service_doctor_price_save.php" method="post" cb="loadModule(\'h6j2zt4wjp\')">
		<input type="hidden" name="id" value="'.$id.'"/>
		<input type="hidden" name="t" value="'.$type.'"/>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
		<tr><th>'.k_dr.'</th><th width="100">'.k_preview.'</th><th width="100">'.k_procedure.'</th><th width="100">'.k_perc_doc.'</th></tr>';
		while($r=mysql_f($res)){
			$u_id=$r['id'];
			$u_name=$r['name_'.$lg];						
			echo '<tr>
				<td class="f1 fs16">'.$u_name.'</td>
				<td><input type="number" name="v1_'.$u_id.'" value="'.$saveVals[$u_id]['v1'].'" /></td>
				<td><input type="number" name="v2_'.$u_id.'" value="'.$saveVals[$u_id]['v2'].'" /></td>
				<td><input type="number" name="v3_'.$u_id.'" value="'.$saveVals[$u_id]['v3'].'" max="100s" /></td>
			</tr>';
		}
		echo '</table></form>';
	}?>
    </div>
    <div class="form_fot fr">
		<div class="bu bu_t3 fl" onclick="sub('cst');"><?=k_save?></div>  
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
    </div>
    </div><?
}?>