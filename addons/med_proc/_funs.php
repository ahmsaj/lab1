<?/***med_proc***/
function view_med_proc($vis,$type,$name,$color,$short_code,$icon){
	global $align,$visStatus;
	$tools='';
	if($visStatus==1 || _set_whx91aq4mx){
		$tools='<div class="fl i30 i30_add" t="'.$type.'" add title="إضافة"></div>';
	}
	$inButt='<div class="fr i30 i30_info" t="'.$type.'" info="'.$short_code.'" title="معلومات تفصيلية"></div>';
	$out='
	<div class="prvlBlc" fix="wp:0" style="border-'.$align.'-color:'.$color.';" blc="'.$type.'" id="b_'.$short_code.'">
		<div class="prvl_title">'.$tools.'
			<div class="fl f1 pd5 fs14" n>'.$name.' <ff14 tot="item" > (0) </ff14></div>
			'.minButt($short_code).$inButt.'
		</div>
		<div t="'.$type.'" items blcCon="'.$short_code.'" blcIn>'.getprocData($type,$vis).'</div>		
	</div>';	
	return $out;
}
function clearTxt($val){
	$val=str_replace('<div style="\&quot;direction:" ltr;\"="">','',$val);
	$val=str_replace('<div style="direction: ltr;">','',$val);	                 
	$val=str_replace('<div>','</br>',$val);
	$val=str_replace('</div>','',$val);
	return $val;
}
function getprocData($t,$vis,$mood=1){
	global $mp_table,$visStatus;
	$out='';
	$table=$mp_table[$t];
	$sql="select * from $table where visit='$vis' order by date ASC";    
	$res=mysql_q($sql);
    $rows=mysql_n($res);
	mysql_n($res);
	while($r=mysql_f($res)){
		$id=$r['id'];
		$val=$r['val'];
		$out.='<div item t="'.$t.'" n="'.$id.'" set="0">';
		if($visStatus==1 || _set_whx91aq4mx){
			$out.='<div class="fr" tool >
			<div class="fl i30 i30_edit" title="تحرير" edit></div>
			<div class="fl i30 i30_up" title="حفظ كنموذج" temp></div>
			<div class="fl i30 i30_del" title="حذف" del></div>
			</div>';
		}
		$out.='<div txt class="fs12 pd10">'.$val.'</div>
		</div>';
	}
	return $out;
}
function mp_showDet($mood,$pat,$t){
	global $mp_table,$thisUser,$lg,$userSubType;
	$privClinic=array();
	if($mood==2){$privClinic=get_vals('gnr_m_clinics','id'," private=1 and id!='$userSubType'",'arr');}
	$out='<div class="mpDet">';
	$table=$mp_table[$t];
	$q='';
	if($mood==1){$q=" and doc='$thisUser' ";}
	$sql="select * from $table where patient='$pat' $q order by visit DESC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$actVis=0;
	if($rows){		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$doc=$r['doc'];
			$vis=$r['visit'];
			$val=$r['val'];
			$date=$r['date'];			
			if($actVis!=$vis){
				$visOk=1;
				if($mood==2){
					$clinic=get_val('cln_x_visits','clinic',$vis);
					if(in_array($clinic,$privClinic)){$visOk=0;}else{$visOk=1;}
				}
				if($visOk){
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
				}
				$actVis=$vis;
			}
			if($visOk){$out.='<div rec class="fs12">- '.splitNo($val).'</div>';}
		}
		$out.='</div>';
	}
	$out.='</div>';
	return $out;
}?>