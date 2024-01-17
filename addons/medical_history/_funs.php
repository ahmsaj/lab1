<?/***imedical_history***/
function medical_history($pat,$name,$color,$short_code,$iconT,$visStatus){
	global $align,$visStatus;
	$tools='';
	if($visStatus==1 || _set_whx91aq4mx){
		$tools='<div class="fl i30 i30_add mg10 mg5v" addMHis title="إضافة" set="0"></div>';
	}
	$out='
	<div class="hisMBlc fl cbg7 w100 bord pd5v" style="border-'.$align.'-color:'.$color.';"
	id="b_'.$short_code.'">
		<div class="lh30">'.$tools.'
			<div class="fl f1 fs16 lh40 pd5">'.$name.'</div>			
			<div class="fr i30 i30_min mg10 mg5v" title="تصغير" s="1" mmb="his"></div>
		</div>
		<div class="fl w100" his_items blcCon="his" blcIn>'.view_his_item($pat).'</div>
		<div blcCon="his">
			<div class="fl lh20 w100 pd10">
				<div class="fl cbg5 hidCb"></div>
				<div class="fl clr5 f1 fs14 pd10 lh30">'.k_critical.'</div>
				<div class="fl cbg9 hidCb"></div>
				<div class="fl clr9 f1 fs14 pd10 lh30">'.k_inactive.'</div>
			</div>
		</div>		
	</div>';
	return $out;
}
function view_his_item($pat){
	global $lg,$visStatus;
	$out='';
	$sql="select * from cln_x_medical_his where patient='$pat' order by date DESC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$data=array();
	while($r=mysql_f($res)){
		$id=$r['id'];
		$date=$r['date'];
		$med_id=$r['med_id'];
		$cat=$r['cat'];
		$s_date=$r['s_date'];
		$e_date=$r['e_date'];
		$num=$r['num'];
		$active=$r['active'];
		$alert=$r['alert'];
		$note=$r['note'];
		$year=$r['year'];
		$dateData=$yearTxt=$numTxt=$act=$alrt=$notTxt='';
		if($s_date || $e_date){
			$dateData='<div d>'.date('Y-m-d',$s_date);
			if($s_date && $e_date){$dateData.=' | ';}
			$dateData.=date('Y-m-d',$e_date).'</div>';
		}
		if($num){$numTxt='<ff class="fs14"> ('.$num.') </ff>';}
		if($year){$yearTxt='<ff class="fs14"> ('.$year.') </ff>';}
		if($note){$notTxt='<div n>'.$note.'</div>';}
		if($active){$act=' act ';}
		if($alert){$alrt=' art ';}
		if($visStatus==1 || _set_whx91aq4mx){
			$butts='
			<div class="fr i30 i30_edit hide" edthis title="تحرير"></div>
			<div class="fr i30 i30_del hide" delhis title="حذف"></div>';
		}
		$med_txt='<div t '.$act.' '.$alrt.' > '.get_val('cln_m_medical_his','name_'.$lg,$med_id).$numTxt.$yearTxt.'</div>';
		$data[$cat].='<div mhit no="'.$id.'">'.$butts.$med_txt.$dateData.$notTxt.'</div>';
	}
	$c=count($data);	
	$fix='hp:0';
	if($c){
		$fix='|wp%:'.(100/$c);
	}
	ksort($data);
	foreach($data as $k=>$d){
		$out.='<div class="fl pd10 hisListIn" fix="'.$fix.'">
			<div class="f1 fs14 clr1111 lh30" >'.get_val('cln_m_medical_his_cats','name_'.$lg,$k).'</div>
			'.$d.'
		</div>';
	}
	return $out;
}
?>