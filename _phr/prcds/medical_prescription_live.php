<? include("../../__sys/prcds/ajax_header.php");
$bool=0; $condition='';
if(isset($_POST['barcode'])){
	$txt=k_for_this_day;
	$barcode=pp($_POST['barcode'],'s');
	if($barcode!=''){
		$txt=k_linked_spe_barcode;
		$temp=explode('-',$barcode);
		$code=intval($temp[0]);
		$presc=intval($temp[1]);
		if($code=='36'){$condition=" id='$presc' and sending_status!='0' "; $bool=1;}//البحث حسب الوصفة
		else{//البحث حسب المريض
			$patient=intval($barcode);
			$bool=$foundPatient=1;
			$condition="patient='$patient' and sending_status!='0'";
			$patientName=get_vals('gnr_m_patients','f_name,ft_name,l_name',"id='$patient'");
			if($patientName && $patientName!=''){
				$patientName=k_patient_name.': '.implode(' ',$patientName);
			}else{
				$foundPatient=0;
				echo $patientName='<div class="fs16 f1 clr5>'.k_no_patient_with_barcode.'..</div>';
			}
			echo $patientName;
		}
	}
}

echo '^';
if(!$bool){ 
	$condition="done!='1' and date>=$ss_day and date<=$ee_day and sending_status!='0'"; 
}
$sql="select * from `gnr_x_prescription` where $condition order by date desc";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows){?>
	<table width="100%" class="grad_s holdH" cellpadding="4" cellspacing="4" type="static" over="0">
		<tr>
			<th><?=k_thnum?></th>
			<th><?=k_tim?></th>
			<? if(!$foundPatient){?><th><?=k_patient?></th><?}?>
			<th><?=k_tclinic?></th>
			<th><?=k_tclinic?></th>
			<th><?=k_status?></th>
			<th width="95"></th>
		</tr>
	<?
	while($r=mysql_f($res)){
		$id=$r['id'];
		$date=$r['date'];
		$clinic=$r['clinic'];
		$doc=$r['doc'];
		$visit=$r['docvisit'];
		$patient=$r['patient'];
		$status=$r['process_status'];
		$done=$r['done'];
		$medic=$r['medic'];
		$clinicTxt=get_val('gnr_m_clinics','name_'.$lg,$clinic);
		$doctor=get_val('_users','name_'.$lg,$doc);
		$patientTxt=get_vals('gnr_m_patients','f_name,ft_name,l_name',"id='$patient'");
		$patientTxt=implode(' ',$patientTxt);
		$dateTxt=date('h:m',$date);
		$cbg=$presc_statusClr[$status];
		?>
		<tr class="<?=$cbg?>">
			<td><ff><?=$id?></ff></td>
			<td><ff><?=$dateTxt?></ff></td>
			<? if(!$foundPatient){?><td class="fs14"><?=$patientTxt?></td><?}?>
			<td class="fs14"><?=$clinicTxt?></td>
			<td class="fs14"><?=$doctor?></td>
			<td><?=$presc_statusTxt[$status]?></td>
			<td>
				<div class="fr ic40 icc4 ic40_info" title="<?=k_pres_info?>" onclick="presc_infoPrescription(<?=$id?>)"></div>
				<div class="fr ic40 icc1 ic40_print" title="<?=k_print_pres?>" onclick="presc_print2(<?=$id?>)"></div>
			</td>
		</tr>
		<?
		
	}?>
	</table>
	<?
	echo "^<ff>( $rows )</ff>";
}else{
	echo '<div class="f1 clr5 fs16 lh50">'.k_no_pres.' '.$txt.'..</div>^<ff>( 0 )</ff>';
}

$co="date>='$ss_day' and date<='$ee_day' and sending_status!='0'"; 
$all_presc=getTotalCO('gnr_x_prescription',$co);//إجمالي الوصفات 
$exchanged_presc=getTotalCO('gnr_x_prescription',"process_status=1 and $co");//الوصفات المصروفة
$not_exchanged_presc=getTotalCO('gnr_x_prescription',"process_status=2 and $co");//الوصفات غير المصروفة
$part_exchanged_presc=getTotalCO('gnr_x_prescription',"process_status=3 and $co");//الوصفات  المصروفة جزئياُ
//$notEsist_drug=getTotalCO('gnr_x_prescription_x_medic',"1=1"); // الأدوية غير المتوفرة
echo "^$all_presc^$exchanged_presc^$not_exchanged_presc^$part_exchanged_presc";
?>
	