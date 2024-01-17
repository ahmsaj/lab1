<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['id'],$_POST['itId'])){
	$id=pp($_POST['id']);
	$itId=pp($_POST['itId']);
	$vis=pp($_POST['vis']);	
	$r=getRecCon('den_x_visits'," id='$vis' and doctor='$thisUser' ");
	if($id){
		$rec=getRec('cln_x_medical_his',$id);
		if($rec['r']){
			$itId=$rec['med_id'];
			$val_s_date=$rec['s_date'];
			if($val_s_date){$val_s_date=date('Y-m-d',$val_s_date);}
			$val_e_date=$rec['e_date'];
			if($val_e_date){$val_e_date=date('Y-m-d',$val_e_date);}
			$val_num=$rec['num'];if($val_num==0){$val_num='';}
			$val_year=$rec['year'];if($val_year==0){$val_year='';}
			$val_note=$rec['note'];
			if($rec['active']){$val_active='checked';}
			if($rec['alert']){$val_alert='checked';}
		}else{
			exit;
		}
	}
	if($r['r']){
		$r=getRec('cln_m_medical_his',$itId);
		if($r['r']){
			$name=$r['name_'.$lg];
			$cat=$r['cat'];
			$r_cat=getRec('cln_m_medical_his_cats',$cat);			
			$catTxt=$r_cat['name_'.$lg];
			$s_date=$r_cat['s_date'];
			$e_date=$r_cat['e_date'];
			$num=$r_cat['num'];
			$active=$r_cat['active'];
			$alert=$r_cat['alert'];
			$note=$r_cat['note'];
			$year=$r_cat['year'];
			echo '<div class="f1 fs16 lh40" >'.$catTxt.' :  
			<span class="clr55 f1 fs16"> ( '.$name.' )</span></div>
			<div class="f1 clr5">يرجى إدخال التفاصيل</div>
			<form name="mHis" id="mHis" action="'.$f_path.'X/den_prv_medhis_add_form_save.php" method="post"  cb="viewMHisCB()">
				<input type="hidden" name="id" value="'.$id.'"/>
				<input type="hidden" name="itId" value="'.$itId.'"/>
				<input type="hidden" name="vis" value="'.$vis.'"/>
				<table class="fTable" cellpadding="0" cellspacing="0" border="0" width="600" style="max-width:600px">';
				if($s_date){
					$title="التاريخ";
					if($e_date){$title="تاريخ البدء";}
					echo '<tr><td n>'.$title.': </td>
					<td i><input type="text" class="Date" name="s_date" id="sd" value="'.$val_s_date.'"></td></tr>';
				}
				if($e_date){
					$title="تاريخ الانتهاء";
					echo '<tr><td n>'.$title.': </td>
					<td i><input type="text" class="Date" name="e_date" id="ed" value="'.$val_e_date.'"></td></tr>';
				}
				if($num){
					$title="عدد المرات";
					echo '<tr><td n>'.$title.': </td>
					<td i><input type="number" name="num" value="'.$val_num.'"></td></tr>';
				}
				if($active){
					$title="غير نشطة";
					echo '<tr><td n><div class="clr9 f1 fs16">'.$title.': </div></td>
					<td i><input type="checkbox" name="active" '.$val_active.'></td></tr>';
				}
				if($alert){
					$title="حرج";
					echo '<tr><td n><div class="clr5 f1 fs16">'.$title.': </div></td>
					<td i><input type="checkbox" name="alert" '.$val_alert.'></td></tr>';
				}
				if($year){
					$title="السنة";
					echo '<tr><td n>'.$title.': </td>
					<td i><input type="text" name="year" id="year" value="'.$val_year.'"></td></tr>';
				}
				if($note){
					$title="تفاصيل";
					echo '<tr><td n valgin="top">'.$title.': </td>
					<td i><textarea class="w100" name="note">'.$val_note.'</textarea></td></tr>';
				}
				echo '<tr><td n></td>
					<td i><div class="fl ic40 icc2 ic40_save ic40Txt" id="saveHisDen">'.k_save.'</div></td></tr>
				</table>
			</form>';
		}		
	}
}?>