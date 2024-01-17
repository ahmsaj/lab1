<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['mdc'] , $_POST['pre'])){
	$mdc=pp($_POST['mdc']);
	$pre=pp($_POST['pre']);	
	$outRes=0;
	$preRows=0;
	$rowTxt='';
	$r=getRec('gnr_x_prescription',$pre);
	if($r['r']){
		if($r['doc']==$thisUser){
			$r2=getRec('gnr_m_medicines',$mdc);
			if($r2['r']){
				$r_id=$r2['id'];
				$name=$r2['name'];
				$dose=$r2['dose'];
				$dose_s=$r2['dose_s'];
				$num=$r2['num'];
				$duration=$r2['duration'];
				if($dose){$dose_t=get_val('gnr_m_medicines_doses','name_'.$lg,$dose);}
				if($num){$num_t=get_val('gnr_m_medicines_times','name_'.$lg,$num);}
				if($duration){$duration_t=get_val('gnr_m_medicines_duration','name_'.$lg,$duration);}
				if($dose_s){$dose_s_t=get_val('gnr_m_medicines_doses_status','name_'.$lg,$dose_s);}

				if(mysql_q("INSERT INTO gnr_x_prescription_itemes (`presc_id`,`mad_id`,`dose`,`num`,`duration`,`doc`,`dose_s`)
				values('$pre','$mdc','$dose','$num','$duration','$thisUser','$dose_s')")){
					$mdc_id=last_id();
					$outRes=1;
					$preRows=getTotalCO('gnr_x_prescription_itemes'," `presc_id`='$pre' ");
					$rowTxt= '
					<tr mdc="'.$mdc_id.'">
						<td txt>'.splitNo($name).'
						<div class="clr55" mn="'.$mdc_id.'"></div></td>
						<td txt>'.splitNo($dose_t).'</td>
						<td txt>'.splitNo($num_t).'</td>
						<td txt>'.splitNo($dose_s_t).'</td>
						<td txt>'.splitNo($duration_t).'</td>
						<td txt><ff class="clr5 fs18 Over" id="mq_'.$mdc_id.'" onclick="editMdcQ('.$mdc_id.')">['.splitNo(1).']</ff></td>
						<td>
							<div class="fr ic40 icc2 ic40_del" onclick="delMdc('.$mdc_id.')" title="'.k_delete.'"></div> 
							<div class="fr ic40 icc1 ic40_edit" onclick="editMdc('.$mdc_id.')" title="'.k_edit.'"></div>
							<div class="fr ic40 icc4 ic40_note" onclick="presc_add_note('.$mdc_id.',\'medicin\')" title="إضافة ملاحظة"></div>
						</td>
					</tr>';
				}
			}
		}
	}
	echo $outRes.'^'.$rowTxt.'^ ( '.$preRows.' ) ';
}?>