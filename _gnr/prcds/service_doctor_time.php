<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] ,$_POST['t'])){
	$id=pp($_POST['id']);
	$type=pp($_POST['t']);
	if($type==1){
		$table='cln_m_services_times';	
		list($service,$clinc,$ser_time)=get_val('cln_m_services','name_'.$lg.',clinic,ser_time',$id);
	}
	if($type==2){
		$table='den_m_services_times';	
		list($service,$ser_time)=get_val('den_m_services','name_'.$lg.',ser_time',$id);
	}?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18">
	<? echo $service.'<ff> ( '.($ser_time*_set_pn68gsh6dj).' <span class="f1">'.k_minute.'</span> )</ff> </div>';?>
	<div class="form_body so"><?
	$saveVals=array();
	$sql="select * from $table where service='$id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$doctor=$r['doctor'];
			$ser_time=$r['ser_time'];
			$saveVals[$doctor]=$ser_time;
		}
	}
	if($type==1){
		$selClnc=getAllLikedClinics($clinc,',');
		$sql="select * from _users where  grp_code IN('7htoys03le','nlh8spit9q') and act=1 and subgrp IN($selClnc) ";
	}
	if($type==2){
		$sql="select * from _users where  grp_code = 'fk590v9lvl' and act=1";
	}
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		echo '<form name="cst" id="cst" action="'.$f_path.'X/gnr_service_doctor_time_save.php" method="post" cb="loadModule(\'h6j2zt4wjp\')">
		<input type="hidden" name="id" value="'.$id.'"/>
		<input type="hidden" name="t" value="'.$type.'"/>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
		<tr><th>'.k_dr.'</th><th>'.k_time_per_min.'</th></tr>';
		while($r=mysql_f($res)){
			$u_id=$r['id'];
			$u_name=$r['name_'.$lg];						
			echo '<tr><td class="f1 fs16">'.$u_name.'</td>
			<td><select name="d_'.$u_id.'" >
			<option value="0">-----</option>';
			for($ii=1;$ii<=10;$ii++){				
				if($ii*_set_pn68gsh6dj<=90){
					$sel='';
					if($saveVals[$u_id]==$ii){$sel=' selected ';}
					echo '<option value="'.$ii.'" '.$sel.' >'.($ii*_set_pn68gsh6dj).' '.k_minute.'</option>';
				}
			}
			echo '</select></td></tr>';
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