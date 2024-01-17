<?/***CLN***/
function getActVisClinc($id,$clins=0,$type=''){
	if($clins==0){
		global $now,$logTime;
		$sql="select SUM(time_need)c from gnr_x_roles where clic='$id' and status in(0,1,2)";
		$res=mysql_q($sql);
		$r=mysql_f($res);
		$time=$r['c']*60;	
		return $time;
	}else{
		if($clins){
			$out=array();
			$q='';
			if($type=0){$q='not';}
			$sql="select clic,count(clic)c,SUM(time_need)s from gnr_x_roles where clic IN($clins) and  status $q in(0,1,2) GROUP BY clic; ";		
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$clic=$r['clic'];
					$out[$clic]['t']=$r['s']*60;
					$out[$clic]['n']=$r['c'];
				}
			}
			return $out;
			
		}
	}
}
function prv_srvs($vis_id,$pat,$doc=0){
    global $now;
    $out=[];
    $q='';
	if($doc){$q="and doctor='$doc' ";}
    $sql="select id,d_start from cln_x_visits where patient='$pat' and id !='$vis_id' $q     
	order by d_start DESC limit 1";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    $r=mysql_f($res);
    if($rows){
        $last_vis=$r['id'];
        $last_date=$r['d_start'];
        $days=intval(($now-$last_date)/86400);
        $sql="select service from cln_x_visits_services where visit_id ='$last_vis' and status=1 and rev=0";
        $res=mysql_q($sql);
        $rows=mysql_n($res);	
        if($rows>0){
            while($r=mysql_f($res)){
                $service=$r['service'];                              
                $pt=intval(get_val('cln_m_services','rev_time',$service));
                if($days<=$pt){$out[]=$service;}
            }
        }
    }
    return $out;
}
function ch_prv($s,$p,$doc=0){
	global $now;
	$out=0;
	$q='';
	if($doc){$q="and doctor='$doc' ";}
	$sql="select v.d_start as v_date, x.rev as x_rev from cln_x_visits v ,cln_x_visits_services x where 
	v.id=x.visit_id and 
	v.patient='$p' and 
	x.service='$s' and 	
	x.status=1 $q
	order by v.d_start DESC limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		$r=mysql_f($res);
		$d_start=$r['v_date'];
		$rev=$r['x_rev'];
		if($rev==0){
			$days=((($now-($now%86400))-($d_start-($d_start%86400)))/86400);
			$pt=intval(get_val('cln_m_services','rev_time',$s));
			if($days<=$pt && $rev==0){$out= 1;}
		}
	}
	return $out;
}
function getVisitTime($vis,$s){
	global $now;
	$sql="select SUM(ser_time*60)s from cln_m_services  where  id IN (select service from cln_x_visits_services where visit_id='$vis') ";
	$res=mysql_q($sql);
	$r=mysql_f($res);
	$co=$r['s']*_set_pn68gsh6dj;
	if($s==2){
		$d_check=get_val('cln_x_visits','d_check',$vis);
		$co=$co-($now-$d_check);
		if($co<0)$co=0;
		return $co;
	}
	return $co;	
}
function showMadInfo($type,$pationt,$style){
	global $lg,$clr1,$p_mid_table_arr;
	$out='';
	$table=$p_mid_table_arr[$type];
	$sql="select * from $table t , cln_x_medical_info m where t.id=m.val and m.pationt_id='$pationt' and m.type='$type' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['val'];
			$name=$r['name_'.$lg];
			if($style==1){
				$out.='<div class="listButt fl" id="m'.$type.'-'.$id.'" style="background-color:'.$clr1.'">';
				$out.='<div class="delTag" onclick="delOprList2('.$type.','.$id.')"></div>';
				$out.='<div class="strTag">'.$name.'</div>';
				$out.='</div>';
			}else{
				$out.='<div><span style=" font-size:24px;margin-'.k_Xalign.':7px">.</span>'.$name.'</div>';				
			}
		}
	}
	return $out;	
}
function ThisVisitItem($visit_id,$type){
	global $lg,$clr1;
	$out='';
	if($type==1){$table='cln_m_prv_complaints';$tabl2='cln_x_prv_complaints';}
	if($type==2){$table='cln_m_prv_diagnosis';$tabl2='cln_x_prv_diagnosis';}
	if($type==3){$table='cln_m_prv_story';$tabl2='cln_x_prv_story';}
	if($type==4){$table='cln_m_prv_clinical';$tabl2='cln_x_prv_clinical';}
	$sql="select t2.opr_id as opr , t1.name as name from $table t1 , $tabl2 t2 where t1.id=t2.opr_id and t2.visit='$visit_id' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['opr'];
			$name=$r['name'];
			$out.='<div class="listButt fl" id="'.$type.'-'.$id.'" style="background-color:'.$clr1.'">';
			$out.='<div class="delTag" onclick="delOprList('.$type.','.$id.')"></div>';
			$out.='<div class="strTag">'.$name.'</div>';
			$out.='</div>';
		}
	}
	return $out;
}
function his_data($v_id,$type){
	global $lg,$clr1;
	$out='';
	if($type=='icp'|| $type=='icd'){
		$tbArr1=array('icp'=>'cln_m_icpc','icd'=>'cln_x_prev_icpc');
		$tbArr2=array('icp'=>'cln_m_icd10','icd'=>'cln_x_prev_icd10');
		
		$sql="select code,name_$lg from cln_m_icpc where id IN(select opr_id from cln_x_prev_icpc where visit ='$v_id') ";			
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){
			while($r=mysql_f($res)){
				$code=$r['code'];
				$name=$r['name_'.$lg];				
				$out.='<div r><ff14>'.$code.'</ff14> : '.$name.'</div>';
			}
		}
		
	}else{
		$tbArr=array(
			'com'=>'cln_x_prev_com',
			'dia'=>'cln_x_prev_dia',
			'cln'=>'cln_x_prev_cln',
			'str'=>'cln_x_prev_str',
			'not'=>'cln_x_prev_not',
		);
		$table=$tbArr[$type];
		$sql="select * from $table where visit ='$v_id' ";				
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){			
			while($r=mysql_f($res)){				
				$val=$r['val'];
				$out.='<div>&#8226; '.$val.'</div>';			
			}
		}
	}
	return $out;
}
function getVisitLink($id,$style=0){
	$out='';
	$t1=getTotalCO('gnr_x_prescription'," visit='$id' ");
	$t2=getTotalCO('cln_x_pro_analy'," v_id='$id' ");
	$t3=getTotalCO('xry_x_pro_radiography'," v_id='$id' ");
	$t4=get_val('cln_x_visits','report',$id);
	$t5=getTotalCO('cln_x_pro_referral'," v_id='$id' ");
	$t6=getTotalCO('cln_x_pro_x_operations'," v_id='$id' ");
	
	if($style!=0){
		$out=array(0,0,0,0,0);
		if($t1>0){$out[0]=1;}
		if($t2>0){$out[1]=1;}
		if($t3>0){$out[2]=1;}
		if($t4!=''){$out[3]=1;}
		if($t5>0){$out[4]=1;}
		if($t6>0){$out[5]=1;}
	}else{
		$n=2;
		$out.='<div class="det_icon">';
		$out.='<div class="svi_0" title="'.k_visit_details.'" onclick="showVd('.$id.',1)"></div>';
		if($t1>0){$out.='<div class="svi_1" title="'.k_the_prescription.'" onclick="showVd('.$id.','.$n.')"></div>';$n++;}
		if($t2>0){$out.='<div class="svi_2" title="'.k_analysis.'" onclick="showVd('.$id.','.$n.')"></div>';$n++;}
		if($t3>0){$out.='<div class="svi_3" title="'.k_medical_images.'" onclick="showVd('.$id.','.$n.')"></div>';$n++;}
		if($t4!=''){$out.='<div class="svi_4" title="'.k_report.'" onclick="showVd('.$id.','.$n.')"></div>';$n++;}
		if($t5>0){$out.='<div class="svi_6" title="'.k_referral.'" onclick="showVd('.$id.','.$n.')"></div>';$n++;}
		if($t6>0){$out.='<div class="svi_5" title="'.k_operations.'" onclick="showVd('.$id.','.$n.')"></div>';$n++;}
		$out.='&nbsp;</div>';
	}
	return $out;
}
function get_ana_cats(){
	global $lg,$clr1;
	$out='';
	$sql="select * from cln_m_pro_analysis_cat order by name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$out.='<div class="ana_list_cat">';
		$out.='<div class="actCat" cat_num="0">'.k_all_test.'</div>';		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$catname=$r['name_'.$lg];
			$out.='<div class="norCat" cat_num="'.$id.'">'.$catname.'</div>';
		}
		$out.='</div>';
	}
	return $out;
}
function get_ana($id){
	global $lg,$clr1;
	$out='';
	$selected=array();
	$sql2="select mad_id from cln_x_pro_analy_items where ana_id='$id'";
	$res2=mysql_q($sql2);
	$rows2=mysql_n($res2);	
	if($rows2>0){while($r2=mysql_f($res2)){$id2=$r2['mad_id'];array_push($selected,$id2);}}
	$sql=" SELECT cln_m_pro_analysis.*, COUNT(mad_id) AS ana_count
    FROM cln_m_pro_analysis LEFT JOIN cln_x_pro_analy_items 	
    ON cln_m_pro_analysis.id = cln_x_pro_analy_items.mad_id	
	where cln_m_pro_analysis.act=1
    GROUP BY cln_m_pro_analysis.id
    ORDER BY ana_count DESC";	
	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){				
		$out.='<div class="ana_list_mdc">';
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			$cat=$r['cat'];
			$ana_count=$r['ana_count'];
			$del=0;
			if(in_array($id,$selected)){$del=1;}
			$out.='<div class="norCat " cat_mdc="'.$cat.'" mdc="'.$id.'" name="'.$name.'" del="'.$del.'">'.$name.'</div>';
		}
		$out.='</div>';
			
	}
	return $out;
}
function getAnaList($id,$style=0){
	global $lg,$clr1;
	$out='';
	if(_set_9jfawiejb9==1){        
		$anas=get_vals('lab_x_visits_requested_items','ana',"r_id='$id' and action=2");
		$sql="select * from lab_m_services  where id in($anas) order by name_$lg ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){
			$i=1;
			while($r=mysql_f($res)){
				$id=$r['mad_id'];
				$name=$r['name_en'];
				if($style==0){
					$out.='<div class="sel_Ana sel_AnaHov" mdc="'.$id.'" title="'.k_delete.'">'.$name.'</div>';
				}else{
					$out.='<div class="sel_mdc_p"><span>'.$i.'- </span>'.$name.'</div>';
				}
				$i++;
			}
		}
	}else{
		$sql="select * from cln_x_pro_analy_items x , cln_m_pro_analysis z where z.id=x.mad_id and x.ana_id='$id'
		order by z.name_$lg ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);	
		if($rows>0){
			$i=1;
			while($r=mysql_f($res)){
				$id=$r['mad_id'];
				$name=$r['name_'.$lg];
				if($style==0){
					$out.='<div class="sel_Ana sel_AnaHov" mdc="'.$id.'" title="'.k_delete.'">'.$name.'</div>';
				}else{
					$out.='<div class="sel_mdc_p"><span>'.$i.'- </span>'.$name.'</div>';
				}
				$i++;
			}
		}
	}
	return $out;
}
function getXpList($id,$pars='',$style=0){	
	global $lg,$clr1;
	$chFil=0;
	if($pars){$chFil=1;$pp=explode('a',$pars);}
	$out='';
	$xphotos=get_vals('xry_x_visits_requested_items','xphoto',"r_id='$id' and action =2");
	$sql="select * from xry_m_services  where id in($xphotos) order by name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		$i=1;
		while($r=mysql_f($res)){
			$id=$r['mad_id'];
			$this_id=$r['x_id'];
			$name=$r['name_'.$lg];
			if($style==0){
				$out.='<div class="sel_Ana sel_AnaHov" mdc="'.$id.'" title="'.k_delete.'">'.$name.'</div>';
			}else{
				if($chFil==0 || in_array($this_id,$pp)){
					$out.='<div class="sel_mdc_p"><span>'.$i.'- </span>'.$name.'</div>';
				}
			}
			$i++;
		}
	}
	return $out;
}
/*
function xpDCat($ids ,$ph=1){
	global $lg;
	$iddes=explode(',',$ids);
	$sql="select * from xry_m_pro_radiography_details where id IN($ids)";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$photo='';
	if($rows>0){
		$r=mysql_f($res);
		$p_id=$r['p_id'];
		$phh=get_val('xry_m_pro_radiography','photo',$p_id);
		$type=get_val('xry_m_pro_radiography','name_'.$lg,$p_id);
		if($ph){
			$photo=viewPhotos2($phh,1,50,50,'img');
			if($photo!=''){$photo='<div class="fl">'.$photo.'</div>';}else{$photo='';}
			return $photo.'<div class="ff fs22" style="line-height:50px;">'.$type.'</div> ';		
		}else{		
			return '<span class="ff fs22">'.$type.'</span> ';		
		}
	}
}*/
function xpDet($xphotos){
	global $lg;
	$out='';
	if($xphotos!=''){
		$sql="select * from xry_m_pro_radiography_details where id IN($xphotos)";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$i=0;
			while($r=mysql_f($res)){
				if($i!=0)$out.=' - ';
				$out.=$r['name_'.$lg];
				$i++;
			}
		}		
	}
	return $out;
}
function getTools($tools,$style=0){
	global $lg;
	if($tools!=''){
		$str='';
		$t=explode('|',$tools);
		$i=1;
		foreach($t as $tt){	
			$t_arr=explode(':',$tt);
			$name_id=$t_arr[0];
			$count=$t_arr[1];
			$name=get_val('cln_m_pro_operations_tools','name_'.$lg,$name_id);
			if($style==0){				
				$str.='<div class="cb"><div class="fl f1">- '.$name.' </div><div class="fl ff" nb>( '.$count.' )</div></div>';
			}else{
				$str.='<span class="ff">'.$i.'- </span>
				<span class="f1">'.$name.' '.k_quantity.' </span>
				<span class="ff">( '.$count.' )</span><br>';
			}
			$i++;
		}
	}
	return $str;
}
function getClinicDoctor($id){
	global $lg;
	$onlineDos=array();
	$sql="select user from _log where grp='7htoys03le' ";	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$user=$r['user'];
		array_push($onlineDos,$user);
	}

	$sql="select * from _users where subgrp='$id' and `grp_code`='7htoys03le'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$id=$r['id'];
		$name=$r['name_'.$lg];
		$col='clr4';
		if(in_array($id,$onlineDos)){$col='clr6';}					
		return '<div class="f1 fs14 '.$col.' ">'.$name.'</div>';		
	}
}
function getXServsStatus(){
	global $now;
	$s_date=$now-($now%86400);	
	$sql="select count(*)c from cln_x_visits_services where status=0 and d_start > '$s_date' ";
	$res=mysql_q($sql);
	$r=mysql_f($res);
	$t1=$r['c'];	
	return '<div class="f1 fs14">'.k_not_completed.' <ff> ( '.$t1.' )</ff></div> ';
}
function getLabId(){
	$sql="select id from gnr_m_clinics where type=2 order by id ASC limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		return $r['id'];
	}else{return 0;}
}
function getServItem($srv){
	$out='';
	$sql="select * from cln_m_services_items where ser_id='$srv' and act=1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$data='';
		while($r=mysql_f($res)){			
			$item=$r['item'];			
			$qunt=$r['qunt'];			
			if($out){$out.='|';}
			$out.=$item.':'.$qunt;
		}
	}
	return $out;
}
function actItemeConsCln($vis,$s_id,$data){
	global $now,$thisUser,$userSubType;
	$total_cost=0;
	if($vis && $s_id){
		$srv=get_val('cln_x_visits_services','service',$s_id);
		$custmItems=array();
		$realyItems=array();
		$sql="select * from cln_m_services_items where ser_id='$srv' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$i=0;
			while($r=mysql_f($res)){			
				$custmItems[$i]['i']=$r['item'];
				$custmItems[$i]['q']=$r['qunt'];
				$i++;
			}
		}	
		if($data){
			$d1=explode('|',$data);
			$i=0;
			foreach($d1 as $d2){
				$status=1;
				$d3=explode(':',$d2);
				$iteme=$d3[0];
				$qu=$d3[1];
				$price=$d3[2];
				$realyItems[$i]['q']=$qu;
				$realyItems[$i]['i']=$iteme;
				$realyItems[$i]['p']=$price;
				$realyItems[$i]['s']=0;
				$i++;
			}
		}
		foreach($custmItems as $c){
			$status=4;			
			$cq=$c['q'];
			$rq=0;
			$t_price=0;
			$iteme=$c['i'];
			foreach($realyItems as $k => $rr){
				$cq=$c['q'];
				$rq=$rr['q'];
				//$iteme=$rr['i'];
				$t_price=$rr['p'];
				if($c['i']==$rr['i']){				
					$realyItems[$k]['s']=1;
					if($c['q']==$rr['q']){
						$status=1;
					}else if($c['q']<$rr['q']){
						$status=2;
					}else if($c['q']>$rr['q']){
						$status=3;
					}
					break;
				}
				if($status==4){$rq=0;$t_price=0;}
			}
			$total_cost+=$t_price;
			mysql_q("INSERT INTO cln_x_services_items
			(`visit`,`srv`,`iteme`,`qunt`,`r_qunt`,`t_price`,`status`,`date`,`doc`,`clinic`)values
			('$vis','$s_id','$iteme','$cq','$rq','$t_price','$status','$now','$thisUser','$userSubType')");
		}
		foreach($realyItems as $rr){
			$status=5;
			if($rr['s']==0){
				$cq=0;
				$rq=$rr['q'];
				$t_price=$rr['p'];
				$iteme=$rr['i'];
				$total_cost+=$t_price;
				mysql_q("INSERT INTO cln_x_services_items
				(`visit`,`srv`,`iteme`,`qunt`,`r_qunt`,`t_price`,`status`,`date`,`doc`,`clinic`)values
				('$vis','$s_id','$iteme','$cq','$rq','$t_price','$status','$now','$thisUser','$userSubType')");
			}
		}
		mysql_q("UPDATE cln_x_visits_services SET cost='$total_cost' where id='$s_id' ");
	}else{
		if($data){
			$d1=explode('|',$data);
			$i=0;
			foreach($d1 as $d2){
				$status=6;
				$d3=explode(':',$d2);
				$iteme=$d3[0];
				$qu=$d3[1];
				$price=$d3[2];				
				mysql_q("INSERT INTO cln_x_services_items
				(`visit`,`srv`,`iteme`,`qunt`,`r_qunt`,`t_price`,`status`,`date`,`doc`,`clinic`)values
				('','','$iteme','','$qu','$price','$status','$now','$thisUser','$userSubType')");
				$i++;
			}
		}
	}
}
function p_his_b($id){
	global $logTs,$thisUser;	
	$his=getTotalCO('cln_x_visits',"patient='$id' and doctor='$thisUser'");
	$out='<div class="bu2 buu bu_t1" onclick="loadHistory('.$id.',1)">'.k_visits.' <ff>( '.$his.' )</ff></div>';
	return $out;
}
function vis_det($id){
	global $logTs;
	//$his=getTotalCO('cln_x_visits',"patient='$id' and doctor='$doc'");
	$out='<div class="info_icon" title="'.k_details.'" onclick="showVd('.$id.',0)"></div>';
	return $out;
}
function acc_but($id){	
	$out='<div class="info_icon" title="'.k_details.'" onclick="showAcc('.$id.',1)"></div>';
	return $out;
}
function mis_vis($id){
	global $thisGrp,$thisUser;
	$mood=1;
	$out='';
	if($thisGrp=='1ceddvqi3g' || $thisGrp=='nlh8spit9q'){$mood=3;}
	if($mood==3){
		list($doc,$tec)=get_val('xry_x_visits','doctor,ray_tec',$id);
		if($doc==$thisUser || $tec==$thisUser || ($doc==0 && $tec==0)){
			$out.='<div class="bu2 bu_t1" onclick="d_vis_Play('.$id.',2,'.$mood.')">'.k_lgin_prv.'</div>';
		}
	}else{
		$out.='<div class="bu2 bu_t1" onclick="d_vis_Play('.$id.',2,'.$mood.')">'.k_lgin_prv.'</div>';
	}
	return $out;
}
function getAssi($id){
	global $assi_typs_arr,$lg;
	$out='';
	$sql="select * from cln_x_pro_referral where id='$id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$type=$r['type'];
		$p_id=$r['p_id'];
		$hospital=$r['hospital'];
		$doctor=$r['doctor'];
		$opr_date=$r['opr_date'];
		$des=$r['des'];
		$opration=$r['opration'];
		$v_id=$r['v_id'];
		$date=$r['date'];
		$out.='								
        <div class="sel_mdc_p">
        <span class="f1 fs14">'.k_referral_num.'</span> : '.$id.'<br>
        <span class="f1 fs14">'.k_patient.'</span> : '.get_p_name($p_id).'<br>
        <span class="f1 fs14">'.k_referral_type.'</span> : '.$assi_typs_arr[$type].' &nbsp;&nbsp;&nbsp;&nbsp;
		<span class="f1 fs14">'.k_date_of_referral.'</span> : '.dateToTimeS3($date,1).'<br>';        
        if($hospital){									
        	$phone=get_val('cln_m_pro_referral_hospitals','phone',$hospital);
        	$addres=get_val('cln_m_pro_referral_hospitals','addres',$hospital);									
        	$out.='<span class="f1 fs14">'.k_the_hospital.'</span>  : '.get_val('cln_m_pro_referral_hospitals','name_'.$lg,$hospital).'<br>';
        	if($phone){$out.='<span class="f1 fs14">'.k_phone.'</span> :'.$phone.'<br>';}
        	if($addres){$out.='<span class="f1 fs14">'.k_address.'</span> :'.$addres.'<br>'; }
        }
        if($doctor){$out.='<span class="f1 fs14">'.k_dr.'</span>: '.get_val('cln_m_pro_referral_doctors','name_'.$lg,$doctor).'<br>';}
        if($opration){$out.='<span class="f1 fs14">'.k_operation.'</span>: '.get_val('cln_m_pro_operations','name_'.$lg,$opration).'<br>';}
        if($opr_date!='0000-00-00'){$out.='<span class="f1 fs14">'.k_date_of_operation.'</span>: '.$opr_date.'<br>'; }
        if($des){$out.='<span class="f1 fs14">'.k_notes.'</span>: '.$des; }
        $out.='</div>'; 
	}
	return $out;
}
function getOpration($id){
	global $lg;
	$out='';
	$sql="select * from cln_x_pro_x_operations where id='$id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$opration=$r['opration'];
		$hospital=$r['hospital'];
		$opr_date=$r['date'];
		$duration=$r['duration'];
		$price=$r['price'];
		$tools=$r['tools'];	
		$opration_name=get_val('cln_m_pro_operations','name_'.$lg,$opration);		
		$out.='								
        <div class="sel_mdc_p">
        <span class="f1 fs14">'.k_operation.'</span> : '.$opration_name.'<br>';
		if($hospital){
			$hospital_name=get_val('cln_m_pro_referral_hospitals','name_'.$lg,$hospital);
			$phone=get_val('cln_m_pro_referral_hospitals','phone',$hospital);
        	$addres=get_val('cln_m_pro_referral_hospitals','addres',$hospital);			
			$out.='<span class="f1 fs14">'.k_the_hospital.'</span> : '.$hospital_name;
			if($phone){$out.=' - '.$phone;}
			if($phone){$out.=' - '.$addres;}
			$out.='<br>';       	
		}
	    if($opr_date){$out.='<span class="f1 fs14">'.k_oper_dat_tim.'</span> : '.$opr_date.'<br>';}
		if($duration){$out.='<span class="f1 fs14">'.k_oper_dur.'</span> : '.$duration.'<br>';}
		if($price){$out.='<span class="f1 fs14">'.k_oper_cost.'</span> : '.$price.'<br>';}
		if($tools){
			$out.='<span class="f1 fs14">'.k_oper_tools.'</span> :<br>'.getTools($tools,1);
		}
        $out.='</div>'; 
	}
	return $out;
}
function linkX($id,$opr,$filed,$val,$type){
	global $lg;
	$out='';
	if($type==3){$tableIn='xry_m_pro_radiography_details';}
	if($type==2){$tableIn='cln_m_pro_analysis';}
	if($opr=='list' || $opr=='view'){
		if($val){$out.='<span class="clr6">'.get_val('cln_m_services','name_'.$lg,$val).'</span>';
		}else{$out.='<span class="clr5">'.k_nlnk.'</span>';}		
	}
	if($opr=='add' || $opr=='edit'){
		$c=$_SESSION['act_x_clinic'];
		$uu=explode('/',$_SERVER['HTTP_REFERER']);
		$q='';
		if($uu[count($uu)-2]=='_Preview-Clinic'){$q=" and cs.clinic='$c' ";}
		$out.='<select name="'.$filed.'" >';
		$out.='<option value="0">--- '.k_select_service.' ---</option>';	
		$sql="select 
		c.name_$lg as c_name , 
		cs.name_$lg as cs_name , 
		cc.name_$lg as cc_name ,
		cs.id as cs_id 
		from  gnr_m_clinics c, cln_m_services cs, xry_m_services_cat cc where 
		c.id=cs.clinic and
		
		c.type='$type' $q and 	
		cs.id NOT IN (select s_link from $tableIn where s_link!='$val')
		order by c.name_$lg ASC , cc.name_$lg , cs.name_$lg ASC
		";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$c_name=$r['c_name'];
				$cs_id=$r['cs_id'];
				$cs_name=$r['cs_name'];
				$cc_name=$r['cc_name'];
				//$name=$r['name_'.$lg];
				if($out)$out.=' / ';
				$sel='';
				if($cs_id==$val){$sel =" selected ";}
				$out.='<option value="'.$cs_id.'" '.$sel.'>'.$c_name.' &raquo; '.$cc_name.' &raquo; ' .$cs_name.'</option>';
			}
		}
		$out.='</select>';		
	}	
	return $out;
}
function checkWorkingClinic($id){
	$day_no=date('w');
	$sql="select id from gnr_m_users_times where clinic='$id' and  FIND_IN_SET('$day_no',`days`)> 0  limit 1";	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	return $rows;
}
function vital_normal($id){
	$t='n';	
	$total=getTotalCO('cln_m_vital_normal'," vital ='$id' ");
	if($total>0){$t='t';}
	return '<div class="child_link fl" onclick="vitalNormal('.$id.')">
	<div '.$t.'>'.$total.'</div>'.k_norl_rates.'</div>';
}
function vital_links($id,$val){
	$t='';		
	if($val){$t='cbg1 clrw';}
	return '<div class="child_link fl '.$t.'" onclick="vital_links('.$id.')">'.k_link_to_val.'</div>';
}
function getVitalVal($type,$value){
	global $vital_T2_types;
	$out='';
	switch ($type) {
		case 1:
			$v=explode(',',$value);
			if($v[0]){
				$out='<ff dir="ltr">[ '.$v[0].' [ '.$v[1].'-'.$v[2].' ] '.$v[3].' ]';
			}else{
				$out='<ff dir="ltr">[ '.$v[1].'-'.$v[2].' ]</ff>';
			}
		break;		
		case 2:
			$v=explode(',',$value);
			$out='<span class="f1">'.$vital_T2_types[$v[0]].'</span> <ff>'.$v[1].'</ff>';
		break;
	}
	return $out;
}
function getVitalADDVal($type,$value){
	if($value){		
		$out='';
		switch ($type) {
			case 1:
			$v=explode(',',$value);
			if($v[1]==1){$vv=$v[0];}
			if($v[1]==2){$vv=$v[0].'%';}
			$out='<ff dir="ltr">'.$vv.'</ff>';break;			
		}
		return $out;
	}
}
function getVQGraphic($q){
	global $lg,$Q_sin;
	$out='';
	if($q){
		$qq=explode(',',$q);
		foreach($qq as $qqq){
			$v=explode(':',$qqq);
			if($v[0]=='o'){$out.='<div class="fl" o val="'.$v[1].'" type="o" t="o">'.$Q_sin[$v[1]].'</div>';}
			if($v[0]=='v'){$out.='<div class="fl" title="'.get_val('lab_m_services_items','name_'.$lg,$v[1]).'" v val="'.$v[1].'" type="v" t="v">['.$v[1].']</div>';}
			if($v[0]=='n'){$out.='<div class="fl" n val="'.$v[1].'" type="v" t="n">'.$v[1].'</div>';}
		}
	}
	return $out;
}
function vitalNormaVal($v_id,$sex,$birth){
	global $vital_T2_types;
	$out=array(0,0,0,'');
	$b=birthByTypes($birth);
	$sql="select * from cln_m_vital_normal where vital='$v_id' and (sex='$sex' or sex=0 or age='') order by sex DESC , age DESC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$age=$r['age'];
			$a=explode(',',$age);
			$type=$r['type'];
			$value=explode(',',$r['value']);				
			if(($a[1]<=$b[$a[0]] && $a[2]>=$b[$a[0]]) || $age==''){		
				$out[0]=$r['id'];;					
				if($type==1){
					$out[1]=$value[1];
					$out[2]=$value[2];
					
					if($value[0]==0){
						$out[3]='<span class="clr6"><ff> [ '.$value[1].' - '.$value[2].' ] </ff></span>';
					}else{							
						$out[3]='<span class="clr5"><ff>[ '.$value[0].'</ff><span class="clr6"><ff> [ '.$value[1].'</ff> - <ff>'.$value[2].' ] </ff></span><ff> '.$value[3].' ] </ff></span>';
					}

				}
				if($type==2){
					$out[1]=$value[0];
					$out[2]=$value[1];					
					$out[3]='<span class="clr6 f1 fs14">'.$vital_T2_types[$value[0]].' <ff>'.$value[1].'</ff></span>';
				}
			}
		}
	}
	if($out[3]==''){$out[3]='-';}
	return $out;
}
function getVitalDepart($type){
	global $userSubType;
	if($type==1){return $userSubType;}
}
function get_complCat($cats){	
	global $lg,$clr1;	
	$out='';
	if($cats){ $cats= " where id IN ($cats)";}
	$sql="select * from cln_m_icpc_cat $cats order by name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){					
		$out.='<div class="ana_list_cat">';
		//$out.='<div class="actCat" cat_num="0">'.k_all_cats.'</div>';		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$catname=$r['name_'.$lg];
			$out.='<div class="norCat" cat_num="'.$id.'">'.$catname.'</div>';
		}
		$out.='</div>';
	}
	return $out;
}
function get_diagnCat($cats){	
	global $lg,$clr1;	
	$out='';
	if($cats){ $cats= " where id IN ($cats)";}
	$sql="select * from cln_m_icd10_cat $cats order by name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){					
		$out.='<div class="ana_list_cat">';
		//$out.='<div class="actCat" cat_num="0">'.k_all_cats.'</div>';		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$catname=$r['name_'.$lg];
			$out.='<div class="norCat" cat_num="'.$id.'">'.$catname.'</div>';
		}
		$out.='</div>';
	}
	return $out;
}
function clnOprList($title,$class,$action,$n='',$code=''){
	if($action){$action='onclick="'.$action.'"';}	
	$act='';
	if($n!=''){
		if($n){$act='on';}else{$act='off';}
		$nTxt='<ff n> ('.$n.')</ff>';
	}
	$out='
	<div '.$action.' oLi="'.$code.'">
		<div ic class="fl '.$class.'"></div>
		<div act="'.$act.'"></div>
		<div t class="fl fs14">'.$title.$nTxt.'</div>
	</div>
	';
	return $out;
}
function checkOPrEx($o,$pat){
	$n=0;
	switch($o){
		case 'prc':$n=getTotalCO('gnr_x_prescription',"patient='$pat'");break;		
		case 'xry':$n=getTotalCO('xry_x_visits_requested',"patient='$pat'");break;
		case 'opr':$n=getTotalCO('cln_x_pro_x_operations',"p_id='$pat'");break;
		case 'ana':
			if(_set_9jfawiejb9==1){				
				$n=getTotalCO('lab_x_visits_requested',"patient='$pat'");
			}else{				
				$n=getTotalCO('cln_x_pro_analy',"p_id='$pat'");
			}
		break;
	}	
	return $n;
}
function fixVisitSevesCln($id){
	$sql="select * from cln_x_visits where id='$id' and  status>0 limit 1";	
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		$r=mysql_f($res);
		$patient=$r['patient'];
		$doctor=$r['doctor'];
		$clinic=$r['clinic'];
		$d_start=$r['d_start'];
		$d_check=$r['d_check'];
		$d_finish=$r['d_finish'];
		$pay_type=$r['pay_type'];
		if($d_check==0){mysql_q("UPDATE cln_x_visits SET d_check=d_start where id='$id' ");}
		$sql2="select * from cln_x_visits_services where visit_id='$id' ";
		$res2=mysql_q($sql2);
		$rows2=mysql_n($res2);
		if($rows2>0){
			while($r2=mysql_f($res2)){
				$s_id=$r2['id'];
				$hos_part=$r2['hos_part'];
				$doc_part=$r2['doc_part'];
				$doc_percent=$r2['doc_percent'];
				$pay_net=$r2['pay_net'];
				$service=$r2['service'];				
				$cost=$r2['cost'];
				$clinic=$r2['clinic'];
				/**********************/
				$fp_dd=0;
				$fp_hh=0;
				$total_pay=$hos_part+$doc_part;
				$dis=$total_pay-$pay_net;
				if($pay_type==2 || $pay_type==3){$dis=0;}			
				if($dis==0){
					if($doc_percent==0){
						$doc_bal= 0;
						$hos_bal=$total_pay;
					}else{
						$doc_bal= intval($doc_percent*$doc_part/100);
						$hos_bal=$total_pay-$doc_bal;
					}
				}else{
					if($hos_part<=$doc_part){
						$dis_x=$hos_part/$doc_part;
						$fp_dd=intval($dis/($dis_x+1));
						$fp_hh=$dis-$fp_dd;
					}else{
						$dis_x=$doc_part/$hos_part;
						$fp_hh=intval($dis/($dis_x+1));
						$fp_dd=$dis-$fp_hh;
					}
					if($pay_net==0 && $pay_type==1){
						$doc_bal=0;$hos_bal=0;
					}else{				
						$doc_bal=intval(($doc_part-$fp_dd)/100*$doc_percent); 
						$hos_bal=($total_pay-$dis)-$doc_bal;
					}
				}
				if($cost>0){					
					$doc_bal=($doc_part-$cost)/100*$doc_percent;
				}
				$sql3="UPDATE cln_x_visits_services set 
				total_pay='$total_pay' ,
				doc='$doctor',
				doc_dis='$fp_dd' ,
				hos_dis='$fp_hh' , 
				hos_bal='$hos_bal' ,
				doc_bal='$doc_bal' , 
				patient='$patient' ,			
				clinic='$clinic' ,
				d_start='$d_start' ,
				d_finish='$d_finish' 
				where id='$s_id' ";
				mysql_q($sql3);
			}
			/**********************/
			fixPatAccunt($patient);
			if($pay_type==2){fixCharServ(1,$id);}
			if($pay_type==1){fixExeServ(1,$id);}
		}
	}
}
/******************New********************/
function cln_selSrvs($vis,$c,$doc,$pat,$type,$dts_id=0){
	global $f_path,$lg,$bupOffer,$srvXTables,$srvTables;
	$mood=1;
	$out='';
	$ms_table=$srvTables[$mood];
	$xs_table=$srvXTables[$mood];
	$emplo=get_val('gnr_m_patients','emplo',$pat);
	if($vis){
        delOfferVis($mood,$vis);
        $selectedSrvs=get_vals($xs_table,'service',"visit_id='$vis'",'arr');
    }
    if($dts_id){        
        $selectedSrvs=get_vals('dts_x_dates_services','service',"dts_id='$dts_id'",'arr');
    }
    $action='gnr_rec_addvis_srv_save';
    $cb="recNewVisSrvSta([1],$mood);";
    $fxg="gtc:1fr 140px 140px|gtc:1fr 50px 140px:900";
    if($type==2){
        $action='dts_rec_add_srv_save';
        $cb="recNewDtsDoc([1]);";        
        $fxg="gtc:1fr 140px";
    }
	$out.='
	<div class="fl w100 lh50 b_bord cbg4 pd10f fxg" fxg="'.$fxg.'">		
		<div class="lh40 fl">
			<input type="text" fix="h:40" class=" " placeholder="'.k_search.'" id="srvSrch"/>
		</div>';
        if($type==1){$out.='<div class="srvEmrg fr f1 fs14" s="0">'.k_emergency.'</div>';}
		$out.='<div class="srvTotal fr"><ff rvTot>0</ff></div>
	</div>
	<div class="fl w100 ofx so pd10">
	<form name="srvsForm" id="srvsForm" action="'.$f_path.'X/'.$action.'.php" method="post"  cb="'.$cb.'" bv="id">';
	$m_clinic=getMClinic($c);
	if(_set_9iaut3jze){$offerSrv=getSrvOffers($mood,$pat);} 
    $prv_srvs=prv_srvs($vis,$pat,$doc);
	$sql="select * from $ms_table where clinic='$m_clinic' and act=1 order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$out.='
		<input type="hidden" name="m" value="'.$mood.'"/>
		<input type="hidden" name="c" value="'.$c.'"/>
		<input type="hidden" name="p" value="'.$pat.'"/>
		<input type="hidden" name="d" value="'.$doc.'"/>		
		<input type="hidden" name="vis" value="'.$vis.'"/>
        <input type="hidden" name="dts" value="'.$dts_id.'"/>
		<input type="hidden" name="fast" id="srvFast" value="0"/>
		<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" srvList>
		<tr><th width="30">#</th>
		<th>'.k_service.'</th>
		<th>'.k_notes.'</th>
		<th width="80">'.k_multip.'</th>
		<th width="80">'.k_price.'</th></tr>';
		$q_pay='';
		$q_price=0;
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$name=$r['name_'.$lg];
			$hos_part=$r['hos_part'];
			$doc_part=$r['doc_part'];
			$edit_price=$r['edit_price'];
            $service=$r['service'];
			$total_pay=$hos_part+$doc_part;
			$rev=$r['rev'];
			$def=$r['def'];
			$multi=$r['multi'];
			$price=$hos_part+$doc_part;
			//$ch_p=ch_prv($s_id,$pat,$doc);
            $ch_p=0;
            if(in_array($s_id,$prv_srvs)){$ch_p=1;}
			$revTxt='';
			$ch='';
			$edit_priceTxt='';
			$offerTxt='';
			$trClr='';
			$offerDisPrice=0;
			if($edit_price){
				$hos_part=$doc_part=0;
				$edit_priceTxt='<div class="f1 fs12 clr1111">'.k_price_det_by_dr.'</div>';
			}
				
			if($ch_p==1 && $rev){$price=0;$revTxt='<div class="f1 clr5 fs12">'.k_review.'</div>';}
			if($price && $doc){			
				$newPrice=get_docServPrice($doc,$s_id,1);
				$newP=$newPrice[0]+$newPrice[1];							
				if($newP){$price=$newP;}
			}
			if($vis || $dts_id){				
				if(in_array($s_id,$selectedSrvs)){$ch=" checked ";}
			}else{
				if($def && $emplo==0){
					if(_set_p7svouhmy5==0){$ch=" checked ";}
					if($q_pay!=''){$q_pay.=' , ';}
					$q_pay.=$name;
					//$q_price+=$price;
				}
			}
			$price2=$price;
			if(_set_9iaut3jze && $price>0){
                $Nprice=$price;
				if($bupOffer[0]==3){
					$offerTxt='<div class="f1 fs12 clr66">'.k_gen_discount.'<ff14>%'.$bupOffer[1].'</ff14></div>';
					$offerDisPrice=$price2;
					$Nprice=($price2/100)*(100-$bupOffer[1]);
				}
				if($bupOffer[0]==4){
					$offerTxt='<div class="f1 fs12 clr66">'.k_for_discount.'<ff14>%'.$bupOffer[1].'</ff14></div>';
					$offerDisPrice=$price2;
					$Nprice=($price2/100)*(100-$bupOffer[1]);
				}
				foreach($offerSrv as $o){			
                    if($o[1]==$s_id ){					
                        if($o[0]==2){
                            $offerTxt='<div class="f1 fs12 clr66">'.k_ser_descount.'<ff14>%'.$o[2].'</ff14></div>';
                            $offerDisPrice=$price2;
                            //$Nprice=($price2/100)*(100-$o[2]);
                            $Nprice=$o[4];
                        }
                        if($o[0]==1){
                            $offerTxt='<div class="f1 fs12 clr55">'.k_patient_bou_ser.'</div>';
                            $Nprice=0;						
                        }
                        $trClr=' cbg666 ';
                    }
                }
                $price=$Nprice;
			}
			$muliTxt='-';
			if($multi){$muliTxt='<input type="number" name="m_'.$s_id.'" value="1" multi min="1" max="3"/>';}
			$offerDisPriceTxt='';
			if($offerDisPrice){$offerDisPriceTxt='<br><ff14 class="fs12 clr5 LT">'.number_format($offerDisPrice).'</ff>';}
			$out.='<tr class="'.$trClr.'" serName="'.$name.'" no="'.$s_id.'" p="'.$price.'" m="'.$multi.'">
			<td><input type="checkbox" name="srvs[]" value="'.$s_id.'" '.$ch.' par="ceckSrv"/></td>
			<td class="f1 fs12">'.$name.'</td>
			<td class="f1 fs12">'.$offerTxt.$revTxt.$edit_priceTxt.'</td>
			<td>'.$muliTxt.'</td>
			<td><ff class="clr1111 fs20">'.number_format($price).$offerDisPriceTxt.'<ff></td>
			</tr>';
		}
		$out.='</table>';
	}
	$out.='</form>
	</div>
	<div class="fl w100 lh60 cbg4 pd10f t_bord">
		<div class="fl br0 ic40 icc2 ic40_save ic40Txt hide" saveSrv>'.k_save.'</div>
	</div>';
	return $out;
}
function cln_selSrvs_save($vis_id,$pat,$emplo,$cln,$doc,$fast){
	global $now,$thisUser,$visXTables,$srvXTables,$srvTables,$lg;
	$mood=1;
	$vTable=$visXTables[$mood];
	$sTable=$srvXTables[$mood];
	$smTable=$srvTables[$mood];
	$m_clinic=getMClinic($cln);
    $cln=minDocClinc($cln,$doc);
	$app=[];
	if($vis_id==0){
		$doc_ord=0;
		$new_pat=isNewPat($pat,$doc,$mood);
		$sql="INSERT INTO $vTable(`patient`,`clinic`,`d_start`,`reg_user`,`fast`,`emplo`,`doctor`,`new_pat`)values ('$pat','$cln','$now','$thisUser','$fast','$emplo','$doc','$new_pat')";
		if(mysql_q($sql)){			
			$vis_id=last_id();
		}					
	}else{
		delOfferVis($mood,$vis_id);
		mysql_q("DELETE from $sTable where `visit_id`='$vis_id' and app=0");
        $app=get_vals($sTable,'service',"`visit_id`='$vis_id' and app=1",'arr');
	}
	/****************************/
	if($vis_id){
        $srvs=implode(',',$_POST['srvs']);
        $srvs=pp($srvs,'s');
        if($srvs){
            $sql="select * from $smTable where clinic='$m_clinic' and id IN($srvs) and act=1 order by ord ASC";
            $res=mysql_q($sql);
            $rows=mysql_n($res);            
            if($rows>0){
                while($r=mysql_f($res)){
                    $s_id=$r['id'];
                    $name=$r['name_'.$lg];
                    $hos_part=$r['hos_part'];
                    $doc_part=$r['doc_part'];
                    $edit_price=$r['edit_price'];
                    $opr_type=$r['opr_type'];

                    if($edit_price){$hos_part=$doc_part=0;}
                    $total_pay=$hos_part+$doc_part;
                    $doc_percent=$r['doc_percent'];
                    $multi=$r['multi'];
                    $rev=$r['rev'];
                    $ch_p=ch_prv($s_id,$pat,$doc);
                    if($ch_p==1 && $rev){$hos_part=0;$doc_part=0;}
                    $pay_net=$hos_part+$doc_part;
                    
                    if($pay_net && $doc){					
                        $newPrice=get_docServPrice($doc,$s_id,1);
                        $newP=$newPrice[0]+$newPrice[1];
                        if($newP){
                            $doc_percent=$newPrice[2];
                            $hos_part=$newPrice[0];
                            $doc_part=$newPrice[1];
                            $pay_net=$newP;
                            $total_pay=$newP;
                        }
                    }
                    $m_hos_part=$hos_part;
                    $m_doc_part=$doc_part;
                    if($emplo && $pay_net){
                        if(_set_osced6538u){
                            $hos_part=$hos_part-($hos_part/100*_set_osced6538u);
                            $hos_part=round($hos_part,-1,PHP_ROUND_HALF_DOWN);
                            $doc_part=$doc_part-($doc_part/100*_set_osced6538u);
                            $doc_part=round($doc_part,-1,PHP_ROUND_HALF_DOWN);
                            $pay_net=$hos_part+$doc_part;
                        }
                    }

                    $m=1;
                    if($multi){$m=pp($_POST['m_'.$s_id]);}
                    if(!in_array($s_id,$app)){
                        for($s=0;$s<$m;$s++){						
                            $sql="INSERT INTO $sTable (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`, `rev`,`d_start`,`total_pay`, `patient`,`doc`,`srv_type`)	values ('$vis_id','$m_clinic','$s_id','$hos_part','$doc_part','$doc_percent','$pay_net','$ch_p','$now','$total_pay','$pat','$doc','$opr_type')";
                            mysql_q($sql);
                            $srv_x_id=last_id();							
                            if($doc_ord){
                                mysql_q("UPDATE xry_x_visits_requested_items set status=1 , service_id='$srv_x_id'  where r_id='$doc_ord' and action=1 and status=0 and xphoto='$s_id' ");
                            }
                            if(_set_9iaut3jze){activeOffer($mood,$cln,$doc,$pat,$vis_id,$s_id,$srv_x_id);}
                        }
                    }
                }
                if($doc_ord){
                    mysql_q("UPDATE xry_x_visits_requested set status=3 where id='$doc_ord' and status in(1,2) ");
                }
                return $vis_id;
            }else{return '0';}
        }
	}
}
function cln_selSrvsSta($vis){
	global $f_path,$lg,$bupOffer,$payStatusArrRec,$reqStatusArr,$insurStatusColArr;	
	$mood=1;
	$editable=1;
    $out='';
	$sql="select * from cln_x_visits where id='$vis' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$patient=$r['patient'];
		$clinic=$r['clinic'];
		$type=$r['type'];
		$doctor=$r['doctor'];
		$dts_id=$r['dts_id'];
		$pay_type=$r['pay_type'];
		$d_start=$r['d_start'];	
		$status=$r['status'];
		$sub_status=$r['sub_status'];
		if(($status>0 || $sub_status>0) && $pay_type==0){$editable=0;}        
		$emplo=$r['emplo'];
		list($c_name,$mood)=get_val('gnr_m_clinics','name_'.$lg.',type',$clinic);
		$out.='<div class="fl w100 ofx so pd10 " >';	
		$sql="select * from cln_x_visits_services where visit_id='$vis' order by id ASC";
		$res=mysql_q($sql);
		$rows2=mysql_n($res);
		if($rows2>0){
            if($pay_type==1){
                $gm_note=get_val_con('gnr_x_exemption_notes','note'," vis='$vis' and mood='$mood' "); 
                if($gm_note){ $out.='<div class="f1 fs14 lh50 clr5">'.k_management_notes.' : '.$gm_note.'  </div>';}else{$out.='<div class="hh10"></div>';}
            }
            $out.='
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" over="0">';
			if($pay_type!=0){
				$out.='<tr><th>'.k_services.'</th>
				<th>'.k_notes.'</th>
				<th width="80">'.k_price.'</th>
				<th width="80">'.k_includ.'</th>
				<th width="80">'.k_must_be_paid.'</th>				
				</tr>';
			}else{
				$out.='<tr><th>'.k_services.'</th>
				<th>'.k_notes.'</th>
				<th width="80">'.k_price.'</th></tr>';
			}
            $total1=0;
            $total2=0;
            while($r=mysql_f($res)){					
                $s_id=$r['id'];
                $service=$r['service'];	list($serviceName,$edit_price,$hPart,$dPart)=get_val('cln_m_services','name_'.$lg.',edit_price,hos_part,doc_part',$service);
				$srvPriceOrg=$hPart+$dPart;
                $hos_part=$r['hos_part'];
                $doc_part=$r['doc_part'];
				$offer=$r['offer'];
                $app=$r['app'];
				$edit_priceTxt='';
				if($edit_price){$hos_part=$doc_part=0;$edit_priceTxt='<div class="f1 clr1111 lh30">'.k_price_det_by_dr.'</div>';}
                $pay_net=$r['pay_net'];
				$rev=$r['rev'];
                $total_price=$hos_part+$doc_part;
                $price=$total_price;
				if($emplo && $price){$price=$srvPriceOrg;}
				$dis=$price-$pay_net;
				$total1+=$price;
                $total2+=$pay_net;	
                $netTotal=$pay_net;
				if(_set_9iaut3jze){$offerText=getSrvView($offer,$mood,$vis,$s_id);}
				$msg='';
                if($pay_type!=0){$offerText='';}                
                if($app){$msg.='<div class="f1 clr5">خضم موعد التطبيق ( '.number_format($total_price-$pay_net).' )</div>';}
				if($rev && $pay_net==0){$msg.='<div class="f1 clr5"> ( '.k_review.' )</div>';}
                $out.= '<tr>					
                <td class="f1">'.$serviceName.'</td>';
                if($pay_type==0){
				    $out.='<td class="f1">'.$msg.$edit_priceTxt.$offerText.'</td>
                    <td><ff>'.number_format($pay_net).'</ff></td>';
                }
				if($pay_type!=0){
					$insurS='-';
					if($status==0){$insurS='<span class="clr5 f1 fs14">'.k_not_included.'</span>';}
					$cancelServ='';
                    $incPerc='';
                    if($pay_type==3){
                        $sur=getRecCon('gnr_x_insurance_rec'," visit='$vis' and service_x='$s_id'  and mood='$mood'");
                        $in_status=$sur['res_status'];
                        $in_s_date=$sur['s_date'];
                        $in_r_date=$sur['r_date'];
                        $ref_no=$sur['ref_no'];
                        if($ref_no){$ref_no=' <ff14 class="lh30">('.$ref_no.')</ff14>';}
                        if($in_status==2){
                            $cancelServ='
                            <div class="fl ic30 ic30_del icc2" srvDelIn="'.$s_id.'" mood="'.$mood.'" onclick1="delServ('.$s_id.','.$mood.')" title="'.k_cncl_serv.'"></div>';
                        }
                        if($in_status==1){
                            $incPerc=' <ff14 class="clr6"> '.number_format(($dis*100/$price),2).'%</ff14>';
                        }
                        if($in_status!=''){$insurS=$reqStatusArr[$in_status];}
                    }
					$out.= '
                    <td class="f1">
                        <div class="f1 '.$insurStatusColArr[$in_status].'" > '.$reqStatusArr[$in_status].''.$incPerc.$ref_no.$cancelServ.'</div>
                    </td>
                    <td><ff>'.number_format($total_price).'</ff></td>
                    <td><ff>'.$dis.'</ff></td>
                    <td><ff class="clr6">'.number_format($pay_net).'</ff></td>';
				}
                $out.= '</tr>';
            }
			$totClr1='cbg66';
			$totClr2='cbg666';
			if($total2==0){$totClr1='cbg88';$totClr2='cbg888';}
            $out.='<tr >					
            <td class="f1 B '.$totClr2.'" colspan="2">'.k_total.'</td>';
            if($pay_type!=0){
                $out.='<td class="'.$totClr2.'"><ff>'.number_format($total1).'</ff></td>
                <td class="'.$totClr2.'"><ff>'.number_format($total1-$total2).'</ff></td>';
            }
            $out.='<td class="fs18 ff B '.$totClr1.' "><ff class="clrw">'.number_format($total2).'</ff></td></tr>';
			
            $showNetPay=0;
            $cardPay=get_sum('gnr_x_acc_payments','amount',"mood='$mood' and vis='$vis' and pay_type=2 and type!=7");
            if($cardPay){// دفع الكتروني جزئي
                $total2-=$cardPay;
                $showNetPay=1;
                $out.='<tr>					
                <td class="f1 B cbg555" colspan="2">'.k_ele_payment.'</td>';
                if($pay_type!=0){$out.='<td colspan="2" class="f1 cbg555"></td>';}
                $out.='<td class="fs18 ff B cbg55 "><ff class="clrw">'.number_format($cardPay).'</ff></td>';
                $out.='</tr>'; 
            }
            if($dts_id){// دفعة موعد مقدمة
				$dtsPay=DTS_PayBalans($dts_id,$vis,$mood);				
				if($dtsPay){										
					$total2-=$dtsPay;
                    $showNetPay=1;
					$out.='<tr>					
					<td class="f1 B cbg555" colspan="2">'.k_payment_amount.'</td>';
					if($pay_type!=0){$out.='<td colspan="2" class="f1 cbg555"></td>';}
                    $out.='<td class="fs18 ff B cbg55 "><ff class="clrw">'.number_format($dtsPay).'</ff></td>';
					$out.='</tr>';
				}
			}
            if($showNetPay){
                $totClr1='cbg66';
                $totClr2='cbg666';
                if($total2==0){$totClr1='cbg88';$totClr2='cbg888';}
                if($total2<0){$totClr1='cbg55';$totClr2='cbg555';}
                $out.='<tr>					
					<td class="f1 B '.$totClr2.'" colspan="2">'.k_net.'</td>';
                    if($pay_type!=0){$out.='<td colspan="2" class="f1 '.$totClr2.'"></td>';}
					$out.='<td class="fs18 ff B '.$totClr1.' "><ff class="clrw">'.number_format($total2).'</ff></td>';
					
					$out.='</tr>';
            }
            $out.='</table>';
		}else{
            $out.='<div class="f1 fs14 lh30 pd10v clr5">لا يوجد خدمات محدد يرجى تحرير الزيارة</div>';
        }
        
		$out.='</div>';        
        $out.=visStaPayFot($vis,$mood,$total2,$pay_type,$editable);        
	}
    if($rows==0 || $status>0){
        delTempOpr($mood,$vis,'a');
		$out.= script("closeRecWin();");
    }
	return $out;
}
function cln_selSrvsStaBalans($vis){
	global $f_path,$lg,$bupOffer,$payStatusArrRec,$reqStatusArr,$insurStatusColArr;	
	$mood=1;
	$editable=1;
    $out='';
	$sql="select * from cln_x_visits where id='$vis' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);		
		$clinic=$r['clinic'];
		$dts_id=$r['dts_id'];
		$pay_type=$r['pay_type'];		
		$status=$r['status'];
		$sub_status=$r['sub_status'];
		if(($status>0 || $sub_status>0) && $pay_type==0){$editable=0;}        
		$emplo=$r['emplo'];
		$mood=get_val('gnr_m_clinics','type',$clinic);
			
		$sql="select * from cln_x_visits_services where visit_id='$vis' order by id ASC";
		$res=mysql_q($sql);
		$rows2=mysql_n($res);
		if($rows2>0){
            $total1=0;
            $total2=0;
            while($r=mysql_f($res)){
                $service=$r['service'];	
				list($edit_price,$hPart,$dPart)=get_val('cln_m_services','edit_price,hos_part,doc_part',$service);
				$srvPriceOrg=$hPart+$dPart;
                $hos_part=$r['hos_part'];
                $doc_part=$r['doc_part'];
				if($edit_price){$hos_part=$doc_part=0;}
                $pay_net=$r['pay_net'];				
                $total_price=$hos_part+$doc_part;
                $price=$total_price;
				if($emplo && $price){$price=$srvPriceOrg;}				
				$total1+=$price;
                $total2+=$pay_net;	                
				$msg='';    
            }
            $cardPay=get_sum('gnr_x_acc_payments','amount',"mood='$mood' and vis='$vis' and pay_type=2 and type!=7");            
            if($dts_id){// دفعة موعد مقدمة
				$dtsPay=DTS_PayBalans($dts_id,$vis,$mood);				
			}
		}
		$total=$total2;
		$xTotal='';
		if($editable){
			if($rows>=0){
				$netPayment=$total;
				if($netPayment<0){
					//$netPayment=$netPayment*(-1);						
				}					
				$payBox=number_format($netPayment);
				if($mood==6){
					$payText="حجز الخدمات";					
					$payBox='';
				}
				if($mood!=4){
					if($mood==2){
						$payBox='<input type="number" id="l_pay" '.$xTotal.' max="'.$netPayment.'" value="'.$netPayment.'" style="width:100px;"/>';
					}
					$out.='
					<div class="fr  f1 fs14 pd10 ">'.$payText.'</div>				
					<div class="fr  f1 fs14 pd10 "><ff class="fs20">'.$payBox.'</ff></div>';						
				}
			}
		}
	}    
	return $out;
}
function cln_recAlert($vis,$alert_id,$alert_status){
    global $visXTables,$srvXTables,$srvTables,$ser_status_Tex,$ser_status_color,$lg;
    $mood=1;$out='';
    $table2=$srvXTables[$mood];
    $r=getRec($visXTables[$mood],$vis);
    if($r['r']){
        $pat=$r['patient'];
        $clinic=$r['clinic'];
        $doc=$r['doctor'];
        $docTxt='';
        if($doc){
            $dName=get_val('_users','name_'.$lg,$doc);
            $docTxt='<div class=" lh30 f1 fs12  ">'.k_doctor.' : '.$dName.'</div>';
        }
        $r=getRec('gnr_m_patients',$pat);
        if($r['r']){
            $photo=$r['photo'];
            $sex=$r['sex'];
            $title=$r['title'];
            $birth_date=$r['birth_date'];
            $birthCount=birthCount($birth_date);
            $bdTxt='<div class="f1 clr5 fs12 lh30">'.k_age.' : <ff14 class="clr5">'.$birthCount[0].'</ff14> <span class="clr5 f1">'.$birthCount[1].'</span></div>';
            $titles=modListToArray('czuwyi2kqx');
            $patPhoto=viewPhotos_i($photo,1,40,60,'css','nophoto'.$sex.'.png');
            $pName=$titles[$title].' : '.$r['f_name'].' '.$r['ft_name'].' '.$r['l_name'];
        }
        $cnlicName=get_val('gnr_m_clinics','name_'.$lg,$clinic); 
        $out.='
        <div class="h100 fxg" fxg="gtc:1fr 2fr|gtr:auto 50px">
            <div class="ofx so fxg r_bord" fxg="grs:2">
                <div class="fl pd10 of fxg" fxg="gtr:auto auto 1fr" >
                    <div class="fl w100 b_bord fxg" fxg="gtc:50px 1fr">
                        <div class="fl pd5">'.$patPhoto.'</div>
                        <div class="fl pd10f">
                            <div class="lh20 f1 fs14 clr1111">'.$pName.'</div>
                            <div class="lh20 f1 fs12 clr1">'.$bdTxt.'</div>
                        </div>
                    </div>
                    <div class="fl w100  pd5v">
                        <div class=" lh30 f1 fs12 ">'.k_visit_num.' : <ff14 class="clr1">'.number_format($vis).'</ff></div>
                        <div class=" lh30 f1 fs12 ">'.k_clinic.' : '.$cnlicName.'</div>
                        '.$docTxt.'
                    </div>
                </div>
            </div>
            <div class="ofx so pd10f b_bord">
            <div class="f1 fs16 clr1 lh40 ">'.k_srvs_prvd.'</div>';
            $sql="select * from $table2 where visit_id='$vis'";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows){
                $priceT=$payT=$backT=0;
                $out.='<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" Over="0">                
                <th>'.k_service.'</th>
                <th width="80">'.k_price.'</th>
                <th width="80">'.k_receive.'</th>
                <th width="80">'.k_return.'</th>
                </tr>';
                while($r=mysql_f($res)){
                    $srv=$r['service'];
                    $price=$r['pay_net'];
                    $status=$r['status'];
                    $pay=$back=0;                   
                    if($status==5){$pay=$price;}
                    if($status==4){$back=$price;}
                    $priceT+=$price;
                    $payT+=$pay;
                    $backT+=$back;
                    $name=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv');
                    $out.='<tr >
                    <td class="f1 fs12">'.$name.'
                    <div class="f1 clr5 lh20" >'.$ser_status_Tex[$status].'</div>
                    </td>
                    <td><ff class="clr1">'.number_format($price).'</ff></td>
                    <td><ff class="clr6">'.number_format($pay).'</ff></td>
                    <td><ff class="clr5">'.number_format($back).'</ff></td>                    
                    </tr>';
                }
                //*********مستحقات المريض****
                $sql="select * from gnr_x_insur_pay_back where patient='$pat' and mood='$mood' and visit='$vis'";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows){
                    while($r=mysql_f($res)){			
                        $visit=$r['visit'];
                        $insur_rec=$r['insur_rec'];
                        $mood=$r['mood'];
                        $service_x=$r['service_x'];
                        $back=$r['amount'];                        
                        list($srv,$price)=get_val($table2,'service,pay_net',$service_x);                        
                        $name=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv');                        
                        $backT+=$back;                        
                        $out.='<tr style="color:'.$ser_status_color[$status].'">
                        <td class="f1 fs12">'.$name.'
                            <div class="f1 clr5 lh20" >'.k_insure_benefits.'</div>
                        </td>
                        <td><ff class="clr1">'.number_format($price).'</ff></td>
                        <td><ff class="clr6">0</ff></td>
                        <td><ff class="clr5">'.number_format($back).'</ff></td>                    
                        </tr>';
                    }
                }
                $out.='<tr>
                    <td class="f1 fs12">'.k_total.'</td>
                    <td class="cbg888"><ff class="clr1">'.number_format($priceT).'</ff></td>
                    <td class="cbg666"><ff class="clr6">'.number_format($payT).'</ff></td>
                    <td class="cbg555"><ff class="clr5">'.number_format($backT).'</ff></td>                    
                </tr>';
                $bankPay=get_sum('gnr_x_acc_payments','amount',"mood='$mood' and vis='$vis' and pay_type=2 and type=2");
                if($bankPay){
                    $out.= '<tr class="cbg444">
                        <td class="f1 fs12">'.k_ele_payments.'</td>
                        <td class=""></td>
                        <td class=""></td>
                        <td class=""><ff class="clr5">'.number_format($bankPay).'</ff></td>
                    </tr>';
                }
                $out.='</table>';
            }            
            $bal=$payT-$backT-$bankPay;
            $out.='</div>
            <div class="cbg4">
            '.visStaPayAlertFot($alert_id,$vis,$mood,$bal,$alert_status).'
            </div>
        </div>';
    }
    return $out;
}
function cln_ticket($r){
	global $lg,$ser_status_Tex,$srvXTables,$srvTables;	
	$mood=1;
	$out='';
    $srvTable=$srvXTables[$mood];
    $srvMTable=$srvTables[$mood];
	if($r['r']){		
        $vis=$r['id'];
		$patient=$r['patient'];
		$clinic=$r['clinic'];
		$type=$r['type'];
		$doctor=$r['doctor'];
		$dts_id=$r['dts_id'];
		$pay_type=$r['pay_type'];
		$d_start=$r['d_start'];	
		$vis_status=$r['status'];
        $pat=$r['patient'];
		$sub_status=$r['sub_status'];		
		if($vis_status==1 && _set_9iaut3jze){
            $bupOffer=array();        
            $offersAv=offersList($mood,$pat);        
            $offerSrv=getSrvOffers($mood,$pat);
        }	        
        $visChanges=getTotalCo($srvTable,"visit_id='$vis' and status IN(2,4)");
		$out.='<div class="fl w100 ofx so pd10 " >';	
		$sql="select * from $srvTable where visit_id='$vis' order by id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
            if($pay_type==1){
                $gm_note=get_val_con('gnr_x_exemption_notes','note'," vis='$vis' and mood='$mood' "); 
                if($gm_note){ $out.='<div class="f1 fs14 lh50 clr5">'.k_management_notes.' : '.$gm_note.'  </div>';}else{$out.='<div class="hh10"></div>';}
            }
            $out.='
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" over="0">
                <tr><th>'.k_services.'</th>				
				<th width="80">'.k_price.'</th>';
			if($vis_status==1 && $visChanges){
				$out.='
				<th width="80">'.k_receive.'</th>
                <th width="80">'.k_return.'</th>';
			}
			$out.='</tr>';
			$totalPay=0;
            $totalPrice=0;
            $totalIN=0;
            $totalOut=0;
            $deleteAble=1;
            while($r=mysql_f($res)){					
                $s_id=$r['id'];
                $service=$r['service'];	list($serviceName,$edit_price,$hPart,$dPart)=get_val($srvMTable,'name_'.$lg.',edit_price,hos_part,doc_part',$service);
				$srvPriceOrg=$hPart+$dPart;
                $hos_part=$r['hos_part'];
                $doc_part=$r['doc_part'];
                $price=$hos_part+$doc_part;
				$offer=$r['offer'];
                $status=$r['status'];
                if($status!=0){$deleteAble=0;}
				$edit_priceTxt='';				
                $pay_net=$r['pay_net'];
				$rev=$r['rev'];
                $price2=$price;
                if(_set_9iaut3jze &&  $status==2 && $price>0 ){
                    $Nprice=$price;
                    if($bupOffer[0]==3){
                        $offerTxt='<div class="f1 fs12 clr66">'.k_gen_discount.'<ff14>%'.$bupOffer[1].'</ff14></div>';
                        $offerDisPrice=$price2;
                        $Nprice=($price2/100)*(100-$bupOffer[1]);
                    }
                    if($bupOffer[0]==4){
                        $offerTxt='<div class="f1 fs12 clr66">'.k_for_discount.'<ff14>%'.$bupOffer[1].'</ff14></div>';
                        $offerDisPrice=$price2;
                        $Nprice=($price2/100)*(100-$bupOffer[1]);
                    }
                    foreach($offerSrv as $o){			
                        if($o[1]==$s_id ){					
                            if($o[0]==2){
                                $offerTxt='<div class="f1 fs12 clr66">'.k_ser_descount.'<ff14>%'.$o[2].'</ff14></div>';
                                $offerDisPrice=$price2;
                                //$Nprice=($price2/100)*(100-$o[2]);
                                $Nprice=$o[4];
                            }
                            if($o[0]==1){
                                $offerTxt='<div class="f1 fs12 clr55">'.k_patient_bou_ser.'</div>';
                                $Nprice=0;						
                            }
                            $trClr=' cbg666 ';
                        }
                    }
                    $pay_net=$Nprice;
                }
                $showPice=$pay_net;
                $showIN=0;
                $showOut=0;
                if($status==2){
                    $showPice=0;
                    $showIN=$pay_net;
                }else{
                    $totalPrice+=$showPice;
                }
                if($status==4){                    
                    $showOut=$pay_net;
                }
                $totalIN+=$showIN;	
                $totalOut+=$showOut;                
				
				$msg='';                
				if($rev && $pay_net==0){$msg='<div class="f1 clr5"> ( '.k_review.' )</div>';}
                
                $out.= '<tr>					
                <td class="f1 fs14">'.$serviceName.'<div class="clr5 f1">'.$ser_status_Tex[$status].'  '.$msg.'</div></td>';
				$out.='<td><ff>'.number_format($showPice).'</ff></td>';
				if($vis_status==1 && $visChanges){
					$insurS='-';
					$cancelServ='';
                    $incPerc='';                    
					$out.= '
                    <td><ff class="clr6">'.number_format($showIN).'</ff></td>
                    <td><ff class="clr5">'.number_format($showOut).'</ff></td>';
				}
                $out.= '</tr>';
            }
			$totClr1='cbg66';
			$totClr2='cbg666';
			//if($total2==0){$totClr1='cbg88';$totClr2='cbg888';}
            $out.='<tr >					
            <td class="f1 fs14 cbg444" >'.k_total.'</td>
            <td class="cbg888"><ff>'.number_format($totalPrice).'</ff></td>';
            if($vis_status==1 && $visChanges){
                $out.='
                <td class="cbg666"><ff>'.number_format($totalIN).'</ff></td>
                <td class="cbg555"><ff>'.number_format($totalOut).'</ff></td>';
                $totalPay=$totalIN-$totalOut;
            }            
            $out.='</tr>
            </table>';
		}
		$out.='</div>'; 
        $out.=visTicketFot($vis,$mood,$vis_status,$totalPay,$visChanges,$deleteAble);
	}
    return $out;
}
function cln_ticket_cancel($r){
	global $lg,$payArry;	
	$mood=1;
	$out='';
	if($r['r']){		
        $vis=$r['id'];
		$pay_type=$r['pay_type'];
		$vis_status=$r['status'];
		$out.='<div class="fl w100 ofx so pd10 " >';	
		$sql="select * from gnr_x_acc_payments where vis='$vis' and mood='$mood' and type NOT IN(6,9,10) order by date ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){            
            $out.='
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" over="0">
            <tr><th>'.k_paym_type.'</th>				
            <th width="80">'.k_receive.'</th>
            <th width="80">'.k_return.'</th>
            </tr>';
			            
            $totalIN=0;
            $totalOut=0;
            
            while($r=mysql_f($res)){
                $payType=$r['type'];
				$amount=$r['amount'];
                $showIN=$showOut=0;
                if(in_array($payType,array(1,2,5,7))){
                    $showIN=$amount;
                }elseif(in_array($payType,array(3,4,8))){
                    $showOut=$amount;
                }
                $totalIN+=$showIN;	
                $totalOut+=$showOut;                
				
                $out.= '<tr>					
                <td class="f1 fs12">'.$payArry[$payType].'</td>				
				<td><ff class="clr6">'.number_format($showIN).'</ff></td>
                <td><ff class="clr5">'.number_format($showOut).'</ff></td>
                </tr>';
            }
			$totClr1='cbg66';
			$totClr2='cbg666';
			//if($total2==0){$totClr1='cbg88';$totClr2='cbg888';}
            $out.='<tr >					
            <td class="f1 fs14 cbg444" >'.k_total.'</td>
            <td class="cbg666"><ff>'.number_format($totalIN).'</ff></td>
            <td class="cbg555"><ff>'.number_format($totalOut).'</ff></td>
            </tr>
            </table>';
            $totalPay=$totalIN-$totalOut;
		}
		$out.='</div>'; 
        $out.=visTicketFotCancel($vis,$mood,$totalPay);
	}
    return $out;
}

/*
function fixVisitS(){	
	$sql="select x.* , xs.id as xsid , xs.hos_part , xs.doc_part , xs.doc_percent ,xs.pay_net ,xs.service ,xs.cost from cln_x_visits_services xs , cln_x_visits x where x.id=xs.visit_id  and x.status>1 and  (hos_part !=0 OR doc_part!=0 ) and xs.total_pay=0 limit 5000";// and total_pay IS NULL
	//$sql="select x.* , xs.id as xsid , xs.hos_part , xs.doc_part , xs.doc_percent ,xs.pay_net ,xs.service ,xs.cost from cln_x_visits_services xs , cln_x_visits x where x.id=xs.visit_id  and x.status>1 ";// and total_pay IS NULL
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$s_id=$r['xsid'];
			$patient=$r['patient'];
			$doctor=$r['doctor'];
			$clinic=$r['clinic'];
			$d_start=$r['d_start'];
			$d_finish=$r['d_finish'];			
			$hos_part=$r['hos_part'];
			$doc_part=$r['doc_part'];
			$doc_percent=$r['doc_percent'];
			$pay_net=$r['pay_net'];
			$service=$r['service'];
			$pay_type=$r['pay_type'];
			$cost=$r['cost'];			
			$clinicType=1;
			$fp_dd=0;
			$fp_hh=0;
			$total_pay=$hos_part+$doc_part;
			$dis=$total_pay-$pay_net;
			
			if($pay_type==2 || $pay_type==3){$dis=0;}			
			if($dis==0){
				$doc_bal= intval($doc_percent*$doc_part/100);
				$hos_bal=$total_pay-$doc_bal;				 
			}else{
				if($hos_part<=$doc_part){
					$dis_x=$hos_part/$doc_part;
					$fp_dd=intval($dis/($dis_x+1));
					$fp_hh=$dis-$fp_dd;
				}else{
					$dis_x=$doc_part/$hos_part;
					$fp_hh=intval($dis/($dis_x+1));
					$fp_dd=$dis-$fp_hh;
				}
				if($pay_net==0 && $pay_type==1){
					$doc_bal=0;$hos_bal=0;
				}else{				
					$doc_bal=intval(($doc_part-$fp_dd)/100*$doc_percent); 
					$hos_bal=($total_pay-$dis)-$doc_bal;
				}
			}
			$sql2="UPDATE cln_x_visits_services set 
			total_pay='$total_pay' ,
			doc='$doctor',
			doc_dis='$fp_dd' ,
			hos_dis='$fp_hh' , 
			hos_bal='$hos_bal' ,
			doc_bal='$doc_bal' , 
			patient='$patient' ,			
			clinic='$clinic' ,
			d_start='$d_start' ,
			d_finish='$d_finish' 
			where id='$s_id' ";
			mysql_q($sql2);
		}                    
	}
	
	$sql="select x.* , xs.id as xsid , xs.hos_part , xs.doc_part , xs.doc_percent ,xs.pay_net ,xs.service ,xs.cost from xry_x_visits_services xs , xry_x_visits x where x.id=xs.visit_id  and x.status>1 and  (hos_part !=0 OR doc_part!=0 ) and xs.total_pay=0 limit 5000";
	
	$sql="select x.* , xs.id as xsid , xs.hos_part , xs.doc_part , xs.doc_percent ,xs.pay_net ,xs.service ,xs.cost from xry_x_visits_services xs , xry_x_visits x where x.id=xs.visit_id and x.status>1 and (hos_part !=0 OR doc_part!=0 ) and ( xs.total_pay=0 OR (xs.total_pay!=0 and xs.doc_bal=0 and xs.hos_bal=0 ) ) limit 5000";
	// and total_pay IS NULL
	//$sql="select x.* , xs.id as xsid , xs.hos_part , xs.doc_part , xs.doc_percent ,xs.pay_net ,xs.service ,xs.cost from cln_x_visits_services xs , cln_x_visits x where x.id=xs.visit_id  and x.status>1 ";// and total_pay IS NULL
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$s_id=$r['xsid'];
			$patient=$r['patient'];
			$doctor=$r['doctor'];
			$clinic=$r['clinic'];
			$d_start=$r['d_start'];
			$d_finish=$r['d_finish'];			
			$hos_part=$r['hos_part'];
			$doc_part=$r['doc_part'];
			$doc_percent=$r['doc_percent'];
			$pay_net=$r['pay_net'];
			$service=$r['service'];
			$pay_type=$r['pay_type'];
			$cost=$r['cost'];			
			$clinicType=get_val('gnr_m_clinics','type',$clinic);
			$fp_dd=0;
			$fp_hh=0;
			$total_pay=$hos_part+$doc_part;
			$dis=$total_pay-$pay_net;
			
			if($pay_type==2 || $pay_type==3){$dis=0;}			
			if($dis==0){
				$doc_bal= intval($doc_percent*$doc_part/100);
				$hos_bal=$total_pay-$doc_bal;				 
			}else{
				if($hos_part<=$doc_part){
					$dis_x=$hos_part/$doc_part;
					$fp_dd=intval($dis/($dis_x+1));
					$fp_hh=$dis-$fp_dd;
				}else{
					$dis_x=$doc_part/$hos_part;
					$fp_hh=intval($dis/($dis_x+1));
					$fp_dd=$dis-$fp_hh;
				}
				if($pay_net==0 && $pay_type==1){
					$doc_bal=0;$hos_bal=0;
				}else{				
					$doc_bal=intval(($doc_part-$fp_dd)/100*$doc_percent); 
					$hos_bal=($total_pay-$dis)-$doc_bal;
				}
			}
			if($clinicType==3 && $cost>0){					
				$doc_bal=($doc_part-$cost)/100*$doc_percent;
			}
			$sql2="UPDATE xry_x_visits_services set 
			total_pay='$total_pay' ,
			doc='$doctor',
			doc_dis='$fp_dd' ,
			hos_dis='$fp_hh' , 
			hos_bal='$hos_bal' ,
			doc_bal='$doc_bal' , 
			patient='$patient' ,			
			clinic='$clinic' ,
			d_start='$d_start' ,
			d_finish='$d_finish' 
			where id='$s_id' ";
			mysql_q($sql2);
		}                    
	}
}*/?>