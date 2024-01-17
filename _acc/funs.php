<?/***ACC***/
function accSrvSet($id){
	global $clinicTypes;
	$out='';
	$blocks='';
	list($type,$sett)=get_val('gnr_m_offers','type,sett',$id);
	if($type<3){
		$action='offerItemes('.$id.')';		
	}else if($type==6){
		$action='addSrvToOffer('.$id.')';	
	}else{
		$action='setOffer('.$id.')';
	}	
	$out.='<div class="fr ic40 icc4 ic40_report" onclick="offerInfo('.$id.')" title="'.k_stats.'"></div>
	<div class="fl">'.$blocks.'</div>';
	$out.='<div class="fr ic40 icc2 ic40_set" onclick="'.$action.'" title="'.k_offer_set.'"></div>';
	return $out;
}
function accShowSrv($id,$srv){
	global $srvTables,$subTablesOfeer,$subTablesOfferCol,$lg;
	list($mood,$sType)=get_val('acc_m_service','mood,clinic',$id);
	$serTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv'.$mood);
	$subVal=get_val_arr($srvTables[$mood],$subTablesOfferCol[$mood],$srv,'cl'.$mood);
	$subTxt=get_val_arr($subTablesOfeer[$mood],'name_'.$lg,$subVal,'sub'.$mood);
	return '<div class="f1 fs12"><span class="f1 clr1 fs12">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</div>';
}

function fixExeServ($mood,$id){
	global $srvXTables;
	$table=$srvXTables[$mood];
	if($mood==4){
	
	}else{
		$sql="select * from $table where visit_id='$id' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$status=$r['status'];			
			if($status==1 || $status==5 || $mood==2){
				mysql_q("UPDATE gnr_x_exemption_srv SET status=1 where mood='$mood' and vis='$id' and x_srv='$s_id' ");
			}
		}
	}
}
function srv_name($id){
	global $srvTables,$lg;
	list($srv,$mood)=get_val('gnr_x_charities_srv','m_srv,mood',$id);	
	return get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'s'.$mood);
}
function latePay($id){
	$sql="select * from gnr_x_box_take where box='$id' order by date DESC limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows==0){return 0;}else{
		$r=mysql_f($res);
		$date=$r['date'];
		return $date-($date%86400)-(86400*60);
	}
}
function boxPayFix($id){
	$box=get_val('gnr_x_box_take','box',$id);	
	fixCasherBalans($box);
}
function getMBoxBal($box){
	$res=array();
	$pt=1;
	
	$opr_out=get_sum('gnr_x_box_oprs','amount',"m_box='$box' and type=2 and pay_type=1");
	
	$chart_in=get_sum('gnr_x_box_oprs','amount',"m_box='$box' and type=1 and pay_type=2");
	$insu_in=get_sum('gnr_x_box_oprs','amount',"m_box='$box' and type=1 and pay_type=3");
	
	$opr_in2= get_sum('gnr_x_box_oprs_other','amount',"m_box='$box' and type=1 ");
	$opr_out2=get_sum('gnr_x_box_oprs_other','amount',"m_box='$box' and type=2 ");
	
	$boxs_in=get_sum('gnr_x_box_take','amount',"m_box='$box'");
	$ex_out=get_sum('gnr_x_box_expenses','amount',"m_box='$box'");
	
	$in=$chart_in+$insu_in+$opr_in2+$boxs_in;
	$out=$opr_out+$opr_out2+$ex_out;
	$res['in']=$in;
	$res['out']=$out;
	$res['bal']=$in-$out;
	return $res;
}
function getCharBal($box=0,$chr=0){
	$res=array();
	$pt=2;
	$q1=$q2=$q3='';
	if($chr){
		$q1="charity='$chr'";
		$q2=" and source='$chr'";
	}
	if($box){		
		$q3=" and m_box='$box'";
	}    
	$pay=get_sum('gnr_x_box_oprs','amount',"type=1 and pay_type='$pt' $q2");
	$dis=get_sum('gnr_x_box_oprs','amount',"type=3 and pay_type='$pt' $q2");
	$srvs=get_sum('gnr_x_charities_srv','srv_covered',"$q1");
	
	$res['pay']=$pay;
	$res['dis']=$dis;
	$res['srvs']=$srvs;
	$res['bal']=$srvs-$pay-$dis;
	return $res;
}
function getInsrBal($box=0,$ins=0){
	$res=array();
	$pt=3;
	$q1=$q2=$q3='';
	if($ins){
		$q1="company='$ins'";
		$q2=" and source='$ins'";
	}
	$pay=get_sum('gnr_x_box_oprs','amount',"type=1 and pay_type='$pt' $q2");
	$dis=get_sum('gnr_x_box_oprs','amount',"type=3 and pay_type='$pt' $q2");
	$srvs=get_sum('gnr_x_insurance_rec','in_price_includ',"$q1");
	
	$res['pay']=$pay;
	$res['dis']=$dis;
	$res['srvs']=$srvs;
	$res['bal']=$srvs-$pay-$dis;
	return $res;
}
?>