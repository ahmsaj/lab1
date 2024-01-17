<?/***vital_signs***/
function view_vs($pat,$name,$color,$short_code,$icon){
	global $align,$visStatus;
	$tot=getTotalCO('cln_x_vital',"patient ='$pat'");
	$tools='';
	if($visStatus==1 || _set_whx91aq4mx){
		$tools='<div class="fl i30 i30_add" t="" addVs></div>';
	}
	$out='
	<div class="prvlBlc" fix="wp:0" style="border-'.$align.'-color:'.$color.';" blc="" id="b_'.$short_code.'">
		<div class="prvl_title ">'.$tools.'
			<div class="fl f1 pd5 fs14" n>'.$name.' <ff14 vsTot> ('.$tot.') </ff14></div>
			'.minButt($short_code).'
		</div>
		<div class="ofxy so" fix="wp:0" blcCon="'.$short_code.'" blcIn>'.getVSData($pat).'</div>		
	</div>';	
	return $out;
}
function getVSData($pat){
	$c=4;
	global $vsCol,$lg,$thisUser;
	$out='';
	$secs=array();
	$vitals=array();
	$vital_data=array();
	$sql="select *from cln_x_vital_items where patient ='$pat' order by date DESC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		while($r=mysql_f($res)){
			$s_id=$r['session_id'];
			$vital=$r['vital'];
			$value=$r['value'];
			$v_type=$r['v_type'];
			$normal_val=$r['normal_val'];
			$add_value=$r['add_value'];
			list($val,$clr)=vsGetVal($v_type,$value,$normal_val,$add_value);
			$vital_data[$s_id][$vital]['v']=$val;				
			$vital_data[$s_id][$vital]['c']=$vsCol[$clr];
			if(!in_array($s_id,$secs)){array_push($secs,$s_id);}
			if(!in_array($vital,$vitals)){array_push($vitals,$vital);}
		}
		$secsStr=implode(',',$secs);
		$vitalsStr=implode(',',$vitals);
		$secs_arr=get_arr('cln_x_vital','id','date'," id IN($secsStr)",1," order by date DESC");
		$vitals_arr=get_arr('cln_m_vital','id','name_'.$lg," id IN($vitalsStr)");		
		$out.='<div class="hh10"></div>
		<table width="100%" border="0" cellspacing="5" cellpadding="4" class="vs_table holdH">
		<tr><th width="30"><div class="fl i30 i30_report" vsRep="0" title="عرض كافة المخططات"></th><th width="110" class="f1 fs12">'.k_date.'</th>';
		$i=0;
		foreach($secs_arr as $vs=>$s){
			if($i<$c){
				$out.='<th class="cbgw ws"><ff class="fs16">'.date('Y-m-d',$s).'</ff></th>';
			}
			$i++;
		}
		$out.='</tr>';		
		foreach($vitals_arr as $vk=>$v){
			$out.='<tr>
			<td><div class="fl i30 i30_report" vsRep="'.$vk.'" title="عرض المخطط"></div></td>
			<td class="ws f1 fs12">'.$v.'</td>';
			$i=0;
			foreach($secs_arr as $sk=>$s){				
				if($i<$c){
					$val=$vital_data[$sk][$vk]['v'];
					$clr=$vital_data[$sk][$vk]['c'];
					if(!$val){$val='-';}
					$out.='<td><ff  class="'.$clr.'">'.$val.'</ff></td>';
				}
				$i++;
			}
			$out.='</tr>';
		}
		$out.= '</table>';
	}else{
		$out.= '<div class="f1 fs14 lh40 clr9">لايوجد جلسات قياس سابقة </div>';
	}
	return $out;	
}
function vsGetVal($type,$val,$nor,$add_val){
	global $vital_T2_types;
	$out=array($val,'','');
	$s=0;
	$norTxt=$v1=$v2='';
	$vvn=explode(',',$nor);
	if($val){
		if($nor){
			$s=2;			
			if($type==1){if($val>=$vvn[1] && $val<=$vvn[2]){$s=1;}}
			if($type==2){
				if($vvn[0]==0){if($val>$vvn[1]){$s=1;}}
				if($vvn[0]==1){if($val<$vvn[1]){$s=1;}}
				if($vvn[0]==2){if($val>=$vvn[1]){$s=1;}}
				if($vvn[0]==3){if($val<=$vvn[1]){$s=1;}}
				if($vvn[0]==4){if($val==$vvn[1]){$s=1;}}
				if($vvn[0]==5){if($val!=$vvn[1]){$s=1;}}
			}
		}
	}
	if($type==1){
		$v1=$vvn[1];
		$v2=$vvn[2];
		if($vvn[0]==0){
			$norTxt='<span class="clr6"><ff14> [ '.$vvn[1].' - '.$vvn[2].' ] </ff14></span>';
		}else{							
			$norTxt='
			<span class="clr5">
				<ff14>[ '.$vvn[0].'</ff14>
				<span class="clr6"><ff14> [ '.$vvn[1].'</ff14> - <ff14>'.$vvn[2].' ] </ff14></span>
				<ff14> '.$vvn[3].' ] </ff14>
			</span>';
		}
	}
	if($type==2){
		$v1=$vvn[0];
		$v2=$vvn[1];
		$norTxt='<span class="clr6 f1 fs14">'.$vital_T2_types[$vvn[0]].' <ff14>'.$vvn[1].'</ff14></span>';
	}
	if($s){$out[1]=$s;}
	$out[2]=$norTxt;
	$out[3]=$v1;
	$out[4]=$v2;
	return $out;
}
function vitalNorVal($v_id,$sex,$birth){
	global $vital_T2_types;
	$out=array(0,0,0);
	$b=birthByTypes($birth);
	$sql="select * from cln_m_vital_normal where vital='$v_id' and (sex='$sex' or sex=0 or age='') order by sex DESC , age DESC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$age=$r['age'];
			$a=explode(',',$age);
			$type=$r['type'];
			$val=$r['value'];
			$add_value=$r['add_value'];
			$add_pars=$r['add_pars'];
			//$value=explode(',',$add_pars);				
			if(($a[1]<=$b[$a[0]] && $a[2]>=$b[$a[0]]) || $age==''){		
				$out[0]=$val;
				$out[1]=$add_value;
				$out[2]=$type;
				$out[3]=$add_pars;
			}
		}
	}
	return $out;
}
?>