<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('gnr_x_prescription',$id);
	if($r['r']){
		$sd=0;
		$doc=$r['doc'];
		$note=$r['note'];
		$complaint=$r['complaint_txt'];
        $status=$r['status'];
        $sending=$r['sending_status'];
		if($doc==$thisUser){$sd=1;}
		echo $sd.'^';
		$sql="select * from gnr_x_prescription_itemes where presc_id='$id' group by mad_id order by id";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
            $senButt='';
            $manual_sending=intval(_set_8g9zjll9cm);//0=>without,1=>auto sending, 2=>manual sending
            if($manual_sending){
                if(!$sending){
                    $title="إرسال للصيدلية";// مرسلة للصيدلية
                    $icon="ic40_send";
                    $status=1;//sent
                }else if($process_status==0){// مرسلة لكن لم تتمك معالجتها أبدا
                    $title="استرجاع الوصفة من الصيدلية";
                    $icon="ic40_ref";
                    $status=0;//retreived
                }
                if($manual_sending==2){
                    $senButt='<div class="fr ic40 Over icc33 ic40Txt mg5v '.$icon.'" onclick="presc_send_toPhr('.$id.','.$status.')">'.$title.'</div>';
                }
            }
			echo '<div class="f1 fs16 clr1 lh40">'.$senButt.k_diagnoses.' : ';
			if($complaint){echo $complaint;}else{echo k_diagnosis_not_detrmined;}			
			echo '<div>
			<div class="clr55 lh40 f1 fs14">'.splitNo($note).'</div>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s " type="static" id="mdcTable">
				<tr>
				<th>'.k_medicine.'</th>
				<th>'.k_dosage.'</th>
				<th>'.k_num_of_tim.' </th>
				<th> '.k_dosage_status.'</th>
				<th>'.k_duration.'</th>	
				<th>الكمية</th>
				</tr>';
			while($r=mysql_f($res)){
				$r_id=$r['id'];
				$mad_id=$r['mad_id'];				
				$dose=$r['dose'];
				$num=$r['num'];
				$duration=$r['duration'];
				$dose_s=$r['dose_s'];
				$note=$r['note'];
				$quantity=$r['presc_quantity'];
				$name=$dose_t=$num_t=$duration_t=$dose_s_t='';
				$name=get_val_arr('gnr_m_medicines','name',$mad_id,'m');
				if($dose){$dose_t=get_val_arr('gnr_m_medicines_doses','name_'.$lg,$dose,'m1');}
				if($num){$num_t=get_val_arr('gnr_m_medicines_times','name_'.$lg,$num,'m2');}
				if($duration){$duration_t=get_val_arr('gnr_m_medicines_duration','name_'.$lg,$duration,'m3');}
				if($dose_s){$dose_s_t=get_val_arr('gnr_m_medicines_doses_status','name_'.$lg,$dose_s,'m4');}
				echo '
				<tr >
					<td>
					<div class="fl lh20 TL">
						<span class="f1 fs14">'.splitNo($name).'</span><br>
						<span class="clr55" >'.splitNo($note).'</span>
					</div>
					</td>
					<td txt>'.splitNo($dose_t).'</td>
					<td txt>'.splitNo($num_t).'</td>
					<td txt>'.splitNo($dose_s_t).'</td>
					<td txt>'.splitNo($duration_t).'</td>
					<td txt><ff>['.$quantity.']</ff></td>
				</tr>';
			}
			echo '</table>';
		}                
	}else{
        echo 0;
    }	
}?>