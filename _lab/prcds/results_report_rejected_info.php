<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
	list($z_ser,$srv_id)=get_val_c('lab_x_visits_services_results_x','x_ser_id,srv',$id,'x_id');
	
	$rec=getRec('lab_m_services_items',$z_ser);
	if($rec['r']){
		$normal_code=$rec['normal_code'];
		list($vis,$sample)=get_val('lab_x_visits_services','visit_id,sample',$srv_id);		
		$pat=get_val('lab_x_visits','patient',$vis);
		list($sex,$age)=getPatInfoL($pat);		
		list($unit_code,$unit_txt,$dec_point)=get_val('lab_m_services_units','code,name_'.$lg.',dec_point',$rec['unit']);

		$val=get_val('lab_x_visits_services_results','value',$id);
		$nor_val2=show_LreportNormalVal($rec['report_type'],$z_ser,$sex,$age,$sample,$val,$rec['unit'],$normal_code);
		$new_val2=$nor_val2[3];
		$txtVal=drowReport(2,$rec['report_type'],'',$unit_txt,$unit_code,$dec_point,$nor_val2);
		       // drowReport(1,$report_type,$name,$unit_txt,$unit_code,$dec_point,$nor_val)?>
		<div class="win_body">
		<div class="form_header f1 fs18 clr1 lh40"><?=$rec['name_'.$lg]?></div>
		<div class="form_body so">
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">
		<tr><td class="f1 fs16"><?=k_cur_value?></td><?=$txtVal?></tr><?
		$sql="select * from lab_x_visits_services_results_x where x_id='$id' order by date DESC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		
		if($rows>0){
			while($r=mysql_f($res)){				
				$val=$r['value'];
				$date=$r['date'];	$nor_val2=show_LreportNormalVal($rec['report_type'],$z_ser,$sex,$age,$sample,$val,$rec['unit'],$normal_code);
				$new_val2=$nor_val2[3];
				$txtVal=drowReport(2,$rec['report_type'],'',$unit_txt,$unit_code,$dec_point,$nor_val2);
				echo '<tr><td><ff>'.date('Y-m-d A h:i:s',$date).'</ff></td>'.$txtVal.'</tr>';
			}
		}
	}
	/****************************************************************/?>
	</table></div>
	<div class="form_fot fr"><div class="bu bu_t2 fr" onclick="win('close','#m_info3');"><?=k_close?></div></div>
	</div><?	
}?>