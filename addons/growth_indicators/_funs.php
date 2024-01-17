<?/***growth_indicators***/
function view_gi($pat,$name,$color,$short_code,$icon){
	global $align,$visStatus;
	$tot=getTotalCO('gnr_x_growth_indicators',"patient ='$pat'");
	$tools='';
	if($visStatus==1 || _set_whx91aq4mx){
		$tools='<div class="fr i30 i30_add" t="" addGi></div>';
	}
	$out='
	<div class="prvlBlc" fix="wp:0" style="border-'.$align.'-color:'.$color.';" blc="" id="b_'.$short_code.'">
		
		<div class="prvl_title "><div class="fl">'.$tools.'</div>
			<div class="fl f1 pd5 fs14" n>'.$name.' <ff14 giTot> ('.$tot.') </ff14></div>
			'.minButt($short_code).'
		</div>
		<div class="ofxy so" fix="wp:0" blcCon="'.$short_code.'" blcIn>'.getGiData($pat).'</div>		
	</div>';	
	return $out;
}
function getGiData($pat){	
	global $lg,$thisUser,$sex_types,$giSexClr,$visStatus;
	$out='';
	$pat_Info=get_p_name($pat,3);
	$sex=$pat_Info[4];
	$birthDate=$pat_Info[5];
	$medRecEx=0;
	$r=getRecCon('gnr_m_patients_medical_info'," patient = '$pat' ");	
	if($r['r']){
		$rec_id=$r['id'];
		$sex=$r['sex'];
		$birthDate=$r['birth_date'];
		$father_height=$r['father_height'];
		$mother_height=$r['mother_height'];
		$exp_length=patEexHight($father_height,$mother_height,$sex);
		list($GIval,$GIclr)=GI_NA(2,$sex,(18*12),$exp_length);
		$medRecEx=1;
	}
	$mosAge=giGetMonthAge($birthDate);
	$out.='<div class="fl w100 pd5v mg5v cbgw">
		<div></div>
		<div class="fl mg5">
			<div class="fl igInIc sexIc_'.$sex.'" title="'.$sex_types[$sex].'"></div>
			<div class="fl f1 lh40 sexClr_'.$sex.'">'.$pat_Info[1].'</div>
		</div>';
	if($medRecEx){
		$out.='
		<div class="fl mg5 l_bord" title="'.k_fath_height.'">
			<div class="fl ic_father igInIc"></div>
			<div class="fl lh40 ff fs24 sexClr_1 B">'.$father_height.'</div>
		</div>
		<div class="fl mg5 l_bord" title="'.k_moth_height.'">
			<div class="fl ic_mother igInIc" ></div>
			<div class="fl lh40 ff fs24 sexClr_2 B">'.$mother_height.'</div>
		</div>
		<div class="fl mg5 l_bord" title="'.k_height_expctd.'">
			<div class="fl ic_tall igInIc" ></div>
			<div class="fl lh40 ff fs24 B clr9">'.$exp_length.'</div>
		</div>
		<div class="fl mg5 l_bord" title="'.k_grow_indic.'">
			<div class="fl lh40 ff fs24 pd10 B clrw" style="background-color:'.$GIclr.'"> '.$GIval.'</div>
		</div>';
		if($visStatus==1 || _set_whx91aq4mx){
			$out.='<div class="fr ic30x icc1 ic30_edit mg5v mg10 ic30Txt" patGi>'.k_info_edit.'</div>';
		}
	}else{
		if($visStatus==1 || _set_whx91aq4mx){
			$out.='<div class="fr ic30x icc4 ic30_add mg5v mg10 ic30Txt" patGi>'.k_info_add.'</div>';
		}
	}
	$out.='</div>';
	$sql="select * from gnr_x_growth_indicators where patient='$pat' order by age DESC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		$out.='
		<table width="100%" border="0" cellspacing="5" cellpadding="4" class="gi_table">
		<tr>		
		<th class="fs12">'.k_age.'</th>
		<th class="fs12">'.k_weight.'</th>
		<th class="fs12">'.k_height.'</th>					
		<th class="fs12">'.k_head_circumf.'</th>
		<th class="fs14 ff">BMI</th>
		<th width="50" ch="1" title="'.k_click_view_chart.'" class="act fs12">'.k_age.'<br>'.k_weight.'</th>
		<th width="50" ch="2" title="'.k_click_view_chart.'" class="act fs12">'.k_age.'<br>'.k_height.'</th>			
		<th width="50" ch="3" title="'.k_click_view_chart.'" class="act fs12">'.k_age.'<br>'.k_head.'</th>
		<th width="50" ch="4" title="'.k_click_view_chart.'" class="act fs12">'.k_age.'<br>BMI </th>
		<th width="50" ch="5" title="'.k_click_view_chart.'" class="act fs12">'.k_weight.'<br>'.k_height.'</th>
		<th width="30"></th>
		</tr>';		
		while($r=mysql_f($res)){
			$gi_id=$r['id'];
			$age=$r['age'];
			$weight=$r['weight'];
			$Length=$r['Length'];
			$head=$r['head'];
			$user=$r['user'];
			$date=$r['date'];
			$BMI=$weight/($Length/100*$Length/100);
			$HA_GIval=$HA_GIclr=$B_GIval=$B_GIclr='';
			list($W_GIval,$W_GIclr)=GI_NA(1,$sex,$age,$weight);
			list($H_GIval,$H_GIclr)=GI_NA(2,$sex,$age,$Length);
			if($head && $age<=36){list($HA_GIval,$HA_GIclr)=GI_NA(3,$sex,$age,$head);}
			if($age>=24){list($B_GIval,$B_GIclr)=GI_NA(4,$sex,$age,$BMI);}
			list($HW_GIval,$HW_GIclr)=GI_NA(5,$sex,$Length,$weight);

			$out.='<tr>			
			<td><ff14>'.$age.'</ff14></td>
			<td><ff14>'.$weight.'</ff14></td>
			<td><ff14>'.$Length.'</ff14></td>						
			<td><ff14>'.$head.'</ff14></td>
			<td><ff14>'.number_format($BMI,3).'</ff14></td>
			<td><div cb style="background-color:'.$W_GIclr.'">'.$W_GIval.'</div></td>
			<td><div cb style="background-color:'.$H_GIclr.'">'.$H_GIval.'</div></td>
			<td><div cb style="background-color:'.$HA_GIclr.'">'.$HA_GIval.'</div></td>
			<td><div cb style="background-color:'.$B_GIclr.'">'.$B_GIval.'</div></td>
			<td><div cb style="background-color:'.$HW_GIclr.'">'.$HW_GIval.'</div></td>
			<td><div class="i30 i30_info" giInfo="'.$gi_id.'" title="'.k_details.'" ></div></td>
			</tr>';

		}
		$out.='</table>';
	}
	return $out;	
}
function giGetMonthAge($date,$sDate=''){
	$y=date('Y');
	$m=date('m');
	$d=date('d');
	if($sDate){
		$y=date('Y',$sDate);
		$m=date('m',$sDate);
		$d=date('d',$sDate);
	}
	$out=0;
	if($date){
		$dd=explode('-',$date);
		$out=($y-$dd[0])*12;
		if($m>=$dd[1]){
			$out+=($m-$dd[1]);
		}else{
			$out-=($dd[1]-$m);
		}
		if($d>=$dd[2]){
			if($d-$dd[2]>=8){
				$out+=0.5;
			}
		}else{
			$out-=1;
			$t=$d+30-$dd[2];
			if($t>=8 && $t<22){
				$out+=0.5;
			}
			if($t>=22){
				$out+=1;
			}
		}
	}
	return $out;
}
function GI_NA($type,$sex,$scale,$Mval){
	global $GI_txt,$GI_clr,$clr5;
	$out=array('','');
	$vals=getRecCon('gnr_m_growth_indicators'," type='$type' and sex='$sex' and scale>='$scale' order by scale ASC");
	if($vals['r']){
		$valsArr=array($vals['minus_2_res'], $vals['minus_1.5_res'], $vals['minus_1_res'], $vals['minus_0.5_res'], $vals['equation_res'], $vals['plus_0.5_res'], $vals['plus_1_res'], $vals['plus_1.5_res'], $vals['plus_2_res']);
		$val=0;
		$lastVal=0;
		$x='';
		foreach($valsArr as $k=>$v){
			if($Mval>$v){
				$val=$k;
				if($k==8){					
					$GIreng=($Mval-$lastVal)/($v-$lastVal);
					if($GIreng>1){$x='+';$x.=intval($GIreng)+1;}
				}
			}else{
				if($k==0){					
					$GIreng=($v-$Mval)/($valsArr[1]-$v);
					if($GIreng>1){$x='-'.intval($GIreng)-1;}
				}
				if($Mval>$lastVal){					
					$GIreng=($Mval-$lastVal)/($v-$lastVal);					
					if($GIreng>=0.5){$val=$k;}
				}
			}
			$lastVal=$v;
		}
		if($x){
			$out[0]=$x;
			$out[1]=$clr5;				
		}else{
			$out[0]=$GI_txt[$val];
			$out[1]=$GI_clr[$val];
		}
	}
	return $out;
}
function giAge($val){	
	$out='<select name="age" >';		
	for($i=0;$i<=240;$i=$i+0.5){
		$sel='';
		if($i>12){
			$y=intval($i/12);
			$m=($i-($y*12));
			$year=' <------------->  Y'.$y.' | M'.$m.'';
		}
		if($i==$val){$sel=' selected ';}
		$out.='<option value="'.$i.'" '.$sel.'>'.$i.$year.'</option>';
	}
	$out.='</select>
	<div class="lh20 clr9 TL">'.k_age_in_month.'</div>';	
	return $out;
}
function patEexHight($fa_hi,$mo_hi,$sex){
	$t=13;
	if($sex==2){$t=-13;}
	return ($fa_hi+$mo_hi+$t)/2;
}
function giPatUpdate($pat){
	list($sex,$bd)=get_val_con('gnr_m_patients_medical_info','sex,birth_date'," patient='$pat'");
	if($pat){
		mysql_q("UPDATE gnr_m_patients SET birth_date='$bd' , sex='$sex' where id='$pat' ");
	}
}
?>