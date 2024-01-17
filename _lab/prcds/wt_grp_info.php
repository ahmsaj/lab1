<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('lab_x_work_table',$id);
	if($r['r']){
		$name=$r['name'];
		$date=$r['date'];
		$services=$r['services'];
		$status=$r['status'];
		$print=$r['print'];
		
		$c=0;
		if($services){
			$srvArr=explode(',',$services);
			$c=count($srvArr);
		}
		$dStatus='';
		$txtDate='<ff>'.date('A h:i',$date).'</ff>';
		if($ss_day<$date){
			$dStatus=' '.k_tday.' | ';
		}elseif($ss_day-$date<86400){
			$dStatus=' '.k_yesterday.' | ';
		}else{
			$txtDate='<ff>'.date('Y-m-d | A h:i',$date).'</ff>';
		}
		echo '<div class="fl fs16 f1">'.$dStatus.' '.$txtDate.' </div>
		<div class="fl"><ff class="clr5"> : '.$c.' </ff></div>';
		echo '<div class="fr i40 i40_done mg5v" wtg_done></div>';
		echo '<div class="fr i40 i40_del mg5v" wtg_del></div>';
		echo '<div class="fr i40 i40_print mg5v" wtg_print></div>';
		
		echo '^';
		if($services){
			$sql="select id,visit_id ,patient,service,d_start from lab_x_visits_services where w_table='$id' order by service ASC , d_start ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$actSrv=0;
			if($rows){
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$vis=$r['visit_id'];
					$patient=$r['patient'];
					$service=$r['service'];
					$d_start=$r['d_start'];
					if($actSrv!=$service){
						
						$srvTxt=get_val('lab_m_services','short_name',$service);
						if($actSrv!=0){echo '</table>';}
						$actSrv=$service;
						echo '<div class="lh40">
						<div class="frr ic30x ic30_ref icc1 mg5v" wtBacAna="'.$service.'" title="'.k_return_ser_to_ana.'"></div>
						<ff class="clr1 fll pd10">'.$srvTxt.'</ff></div>
						<table width="100%" border="0" cellspacing="0" type="static" cellpadding="4" class="grad_s holdH1" >
						<tr><th>'.k_service.'</th><th>'.k_patient.'</th><th width="70"></th></tr>';
					}
					echo '<tr><td><ff>'.$s_id.'</ff><br><ff14 class="clr1">'.date('m-d Ah:i',$d_start).'</ff14></td>
					<td class="f1 fs14">'.get_p_name($patient).'</td>
					<td>
						<div class="fr i30 i30_res" wtBacSrv="'.$s_id.'" title="'.k_return_ana_list.'"></div>
						<div class="fr i30 i30_del" wtDelSrv="'.$s_id.'" title="'.k_not_include_work_table.'"></div>
					</td>
					</tr>';
				}
				echo '</table>';
			}
		}else{
			echo '<div class="f1 fs14 clr5 lh30">'.k_no_ana_group.'</div>';
		}
	}
}?>