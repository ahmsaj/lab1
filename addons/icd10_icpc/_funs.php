<?/***icd10_icpc***/
function view_icd($vis,$type,$name,$color,$short_code,$icon){
	global $align,$visStatus;
	$tools='';
	if($visStatus==1 || _set_whx91aq4mx){
		$tools='<div class="fl i30 i30_add" t="'.$type.'" addIc></div>';
	}
	$inButt='<div class="fr i30 i30_info" t="'.$type.'" info="'.$short_code.'" title="معلومات تفصيلية"></div>';
	$out='
	<div class="prvlBlc" fix="wp:0" style="border-'.$align.'-color:'.$color.';" ic_blc="'.$type.'" id="b_'.$short_code.'">
		<div class="prvl_title">'.$tools.'<ff14 tot="ic_item" > (0) </ff14>
			<div class="fl ff B pd5 fs14" n>'.$name.'</div>
			'.minButt($short_code).$inButt.'
		</div>
		<div t="'.$type.'" ic_items blcCon="'.$short_code.'" blcIn >'.view_icd_item($type,$vis).'</div>		
	</div>';
	return $out;
}
function view_icd_item($t,$vis,$mood=1){
	global $icd_table,$icd_table_x,$visStatus,$lg;
	$out='';
	$table=$icd_table_x[$t];	
	$sql="select * from $table where visit='$vis' order by date ASC";
	$res=mysql_q($sql);	
	while($r=mysql_f($res)){
		$id=$r['id'];
		$opr=$r['opr_id'];		list($val,$code)=get_val($icd_table[$t],'name_'.$lg.',code',$opr);
		$out.='<div ic_item t="'.$t.'" n="'.$id.'" opr="'.$opr.'" set="0">';
		if($visStatus==1){
			$out.='<div class="fr" tool >
			<div class="fl i30 i30_del" title="'.k_delete.'" del></div>
			</div>';
		}
		$out.='<div txt class="fs12 pd10"><ff>'.$code.' | </ff>'.$val.'</div>
		</div>';
	}
	return $out;
}
function ic_showDet($mood,$pat,$t){
	global $icd_table,$icd_table_x,$thisUser,$lg;
	$out='<div class="mpDet">';
	$table=$icd_table_x[$t];
	$q='';
	if($mood==1){$q=" and doc='$thisUser' ";}
	$sql="select * from $table where patient='$pat' $q order by visit DESC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$actVis=0;
	if($rows){
		//$out.='<div vis>';
		while($r=mysql_f($res)){
			$id=$r['id'];
			$doc=$r['doc'];
			$vis=$r['visit'];
			$opr_id=$r['opr_id'];
			$date=$r['date'];
			list($valTxt,$code)=get_val($icd_table[$t],'name_'.$lg.',code',$opr_id);
			if($actVis!=$vis){
				if($actVis){$out.='</div>';}
				$out.='<div vis><div hd>';				
				if($mood==1){					
					$out.='<ff14>'.date('Y-m-d',$date).'</ff14>';
				}else{
					list($doc,$date,$clinic)=get_val('cln_x_visits','doctor,d_start,clinic',$vis);
					$clr='clr8';
					if($doc==$thisUser){$clr='clr6';}
					$docName=get_val_arr('_users','name_'.$lg,$doc,'d');
					$clinicName=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c');
					$out.='<div class="f1 fs14 '.$clr.'">'.$docName.' ( '.$clinicName.' )<br>';
					$out.='<ff14>'.date('Y-m-d',$date).'</ff14></div>';
				}				
				$out.='</div>';
				$actVis=$vis;
			}
			$out.='<div rec class="fs12">- <ff14 class="clr88">'.$code.' | </ff14>'.splitNo($valTxt).'</div>';
		}
		$out.='</div>';
	}
	$out.='</div>';
	return $out;
}
?>