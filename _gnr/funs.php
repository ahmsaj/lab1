<?/***GNR***/
$bupOffer=array();
function u_clinic($id,$opr,$filed,$val){
	global $lg,$clinicTypes;
	$out='';
	if($opr=='add' || $opr=='edit'){		
		$out='<div id="setGU" f="'.$filed.'">'.u_clinicIn($id,'',$filed,$val).'</div>';
	}else{
		$u_grp=get_val('_users','grp_code',$id);
		if($val){
			if(in_array($u_grp,array('pfx33zco65','nlh8spit9q','1ceddvqi3g'))){
				$sql="select name_$lg from gnr_m_clinics where id IN($val)";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					while($r=mysql_f($res)){
						$name=$r['name_'.$lg];
						if($out){$out.=' / ';}
						$out.=$name;
					}
				}
			}			
            if(in_array($u_grp,array('7htoys03le','fk590v9lvl','9yjlzayzp','66hd2fomwt','9k0a1zy2ww'))){$out=get_val('gnr_m_clinics','name_'.$lg,$val);}
			if($u_grp=='tcswrreks0' || $u_grp=='fcbj8r9oq'){$out=get_val('str_m_stores','name_'.$lg,$val);}
			
			if($u_grp=='im22ovq3jm'){$out=$clinicTypes[$val];}
		}
	}
	return $out;
}
function u_clinicIn($id,$link,$filed,$val){
	global $lg,$clinicTypes;		
	$out='';
	if(!$link){
		if($id){
			$link=get_val('_users','grp_code',$id);		
		}else{
			/*$sql="select code from _groups order by name_$lg ASC limit 1";
			$res=mysql_q($sql);
			$rows=mysql_n($res);				
			if($rows>0){$r=mysql_f($res);$link=$r['code'];}*/
		}
	}
	if($link=='pfx33zco65'){		
		$sql="select id,name_$lg from gnr_m_clinics order by ord ASC ";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){$data[$r['id']]=$r['name_'.$lg];}
		$sel=explode(',',$val);
		$out.=multArrSelect($filed,$data,$sel);
	}else
	if($link=='7htoys03le'){
		$out.=make_Combo_box('gnr_m_clinics','name_'.$lg,'id'," where act =1 and type IN(1,2)",$filed,1,$val).'
		<span>'.k_select_clin_doctor.'</span>';
	}else
	if($link=='nlh8spit9q' || $link=='1ceddvqi3g'){
		$sql="select id,name_$lg from gnr_m_clinics where type=3 order by ord ASC ";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){$data[$r['id']]=$r['name_'.$lg];}
		$sel=explode(',',$val);
		$out.=multArrSelect($filed,$data,$sel);
		
	}else
	if($link=='fk590v9lvl'){
		$out.=make_Combo_box('gnr_m_clinics','name_'.$lg,'id'," where act =1 and type=4",$filed,1,$val).'
		<span>'.k_select_clin_xray.'</span>';
	}else
	if($link=='9yjlzayzp'){
		$out.=make_Combo_box('gnr_m_clinics','name_'.$lg,'id'," where act =1 and type=5",$filed,1,$val).'
		<span>'.k_select_clin_xray.'</span>';
	}else
	if($link=='66hd2fomwt'){
		$out.=make_Combo_box('gnr_m_clinics','name_'.$lg,'id'," where act =1 and type=6",$filed,1,$val).'
		<span>'.k_select_clin_xray.'</span>';
	}else
	if($link=='tcswrreks0'){
		$out.=make_Combo_box('str_m_stores','name_'.$lg,'id'," where act =1 and type=1",$filed,0,$val).'
		<span>'.k_dfn_mn_str_mgr_lv_bnk.'</span>';
	}else
	if($link=='fcbj8r9oq'){
		$out.=make_Combo_box('str_m_stores','name_'.$lg,'id'," where act =1 and type=2",$filed,0,$val).'
		<span>'.k_dfn_mn_str_mgr_lv_bnk.'</span>';
	}else
	if($link=='9k0a1zy2ww'){
		$out.=make_Combo_box('gnr_m_clinics','name_'.$lg,'id'," where act =1 and type=7",$filed,1,$val).'
		<span>'.k_chs_osc_clin.'</span>';
	}else
	if($link=='im22ovq3jm'){		
		$out.='<select name="'.$filed.'" required>';
		foreach($clinicTypes as $k=>$v){
			$sel='';
			if($k==$val){$sel=' selected ';}
			$out.='<option value="'.$k.'" '.$sel.'>'.$v.'</option>';
		}
		$out.='</select>';
	}else
	{$out='<div class="f1 fs14 lh40">'.k_no_links_groups.'</div>';}		
	return $out;
}
function u_date($id){
	global $docsGrp,$dgArr,$dtArr;
	$dg=implode("','",$docsGrp);
	if(!is_array($dgArr)){$dgArr=get_vals('_users','id'," grp_code IN ('$dg')",'arr');}
	if(!is_array($dtArr)){$dtArr=get_vals('gnr_m_users_times','id'," days is not null AND days!='' ",'arr');} 
	
	if(in_array($id,$dgArr)){
		$c='icc3';
		if(in_array($id,$dtArr)){$c='icc1';}
		return '<div class="ic40 '.$c.' ic40_time ic40Txt fl ws" onclick="setUserTime('.$id.')">'.k_doc_tim.'</div>';
	}
}				
function get_p_name($id, $t=0,$opr='',$fil='',$date=0){
	$out='';
	$res=mysql_q("select * from gnr_m_patients where id='$id'");
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$f_name=$r['f_name'];
		$ft_name=$r['ft_name'];
		$l_name=$r['l_name'];
		$mobile=$r['mobile'];
		$sex=$r['sex'];
		$birth_date=$r['birth_date'];
		$phone=$r['phone'];		
		
		if($t==0){$out= $f_name.' '.$ft_name.' '.$l_name;}
		if($t==1){$out= $f_name.' '.$l_name;}
		if($t==2){
			$text='';
			if($birth_date){$text.=' <ff dir="ltr">'.$birth_date.'</ff>';}
			$text.='<br>';
			if($mobile){$text.=' - '.$mobile;}
			if($phone){$text.=' - '.$phone;}
			
			$out= $f_name.' '.$ft_name.' '.$l_name.' '.$text;
		}
		if($t==3){
			$birthCount=birthCount($birth_date,$date);
			$bb='<ff>'.$birthCount[0].' </ff>'.$birthCount[1];
			$out = array($f_name.' '.$ft_name.' '.$l_name,$bb,$mobile,$phone,$sex,$birth_date);
		}
		if($t==4){		
			$text='';			
			$reg_id=get_val_con('_log_opr','user'," `mod`='p7jvyhdf3' and opr=1 and opr_id='$id' ");
			//$out=get_val('_users','name_ar',$reg_id).'^'.$id.'-'.$f_name.' '.$ft_name.' '.$l_name.' \n ('.$text.')\n';
			$out.=$id.'^'.$f_name.' '.$ft_name.' '.$l_name.'^'.$birth_date.'^'.$mobile.'^'.get_val('_users','name_ar',$reg_id);
		}
		if($t==5){		
			$text='';
			if($birth_date){$text.=$birth_date;}			
			if($mobile){$text.=' - '.$mobile;}
			if($phone){$text.=' - '.$phone;}
			$out='<div class="f1 fs14">'.$f_name.' '.$ft_name.' '.$l_name.' </div> <ff14>('.$text.')</ff14>';
		}
		if($opr=='add' || $opr=='edit'){				
            $out='<div class="f1 fs14">'.$out.'</div>';
			$out.='<input type="hidden" name="'.$fil.'" value="'.$id.'"/>';
		}
	}
	return $out;
}
function print_card($id,$opr,$filed,$val){
	$out='';
	if($opr=='list' || $opr=='view'){		
		if($opr=='view'){
			//$out.='<div class="f1 fs14">'.$print_txt.'</div>';
		}else{
			$out.='<div class="fr ic40 icc1 ic40_print ic40Txt" onclick="pr_card('.$id.')">'.k_print.' <ff> ( '.$val.' ) </ff></div>';
		}
	}
	if($opr=='add' || $opr=='edit'){
		$out.='<input type="hidden" name="'.$filed.'" id="'.$filed.'" value="'.$val.'"  >';
		if($val==0){
			$out.=k_print_card_firstime;	
		}else{
			$out.=k_print.' <ff>( '.$val.' )</ff>';
		}			
	}
	return $out;
}
function birthCount($birth,$date=0){
	global $now;	
	if($date==0){$date=$now;}
	//else{echo 'XXXXX'; }	
	$out='';
	$codArr=array(k_day,k_month,k_year);
	
	$out=array('','');
	if($birth=='0000-00-00'){return $out;}
	$today = date("Y-m-d",$date);
	$diff = date_diff(date_create($birth), date_create($today));
	$y=$diff->format('%y');
	$m=$diff->format('%m')+($y*12);
	$d=$diff->format('%d')+($y*12)+($m*30.4);
	
	if($d<92){
		$code=$codArr[0];
		$num=$d;
	}else if($m<12){
		$code=$codArr[1];
		$num=$m;	
	}else{
		$code=$codArr[2];
		$num=$y;
	}
 	$out=array($num,$code);
	return $out;
}
function birthByTypes($birth){
	global $now;
	$out=array(0,0,0);
	if($birth=='0000-00-00'){return $out;}	
	$today = date("Y-m-d",$now);
	$diff = date_diff(date_create($birth), date_create($today));
	$y=$diff->format('%y');
	$m=$diff->format('%m')+($y*12);
	$d=$diff->format('%d')+($y*12)+($m*30.4);
	
	$out[0]=$y;
	$out[1]=$m;
	$out[2]=$d;

	return $out;
}
function getPatAge($id){	
	$birth=get_val('gnr_m_patients','birth_date',$id);
	$b=birthCount($birth);
	return '  <ff class="fs14"> '.$b[0].' </ff> '.$b[1];
}
function get_host_Time(){
	list($h_type,$hData,$days)=get_val('gnr_m_users_times','type,data,days',0);	
	if($h_type==1){		
		$h_dates=explode(',',$hData);
		return array($h_dates[0],$h_dates[1]);
	}else{
		$day_no=date('w');
		$h_days=explode(',',$days);
		$h_dates=explode('|',$hData);
		$i=0;
		foreach($h_days as $d){
			if($d==$day_no){
				$h_dates=explode(',',$h_dates[$i]);
				return array($h_dates[0],$h_dates[1]);
			}
		}
		return array($h_dates[0],$h_dates[1]);
	}
}
function get_doc_Time($type,$data,$days){
	if($type==1){		
		$d_dates=explode(',',$data);
		return array($d_dates[0],$d_dates[1],$d_dates[2],$d_dates[3]);
	}else{
		$day_no=date('w');
		$d_days=explode(',',$days);
		$d_dates=explode('|',$data);
		$i=0;
		foreach($d_days as $d){
			if($d==$day_no){
				$d_dates=explode(',',$d_dates[$i]);
				return array($d_dates[0],$d_dates[1],$d_dates[2],$d_dates[3]);
			}
			$i++;
		}
		return array($d_dates[0],$d_dates[1],$d_dates[2],$d_dates[3]);
	}	
}
function pa_visits($id,$t=1){
	$vis=intval(get_val('gnr_m_patients_evaluation','visits',$id));	
	$clr=3;
	$action='';
	//$clr=1;
	$action='onclick="showVisits('.$id.')"';	
	if($t==1){
		$out='<div class="fl ic40 icc1 ic40_info ic40Txt" title="'.k_visits.'" '.$action.' >'.k_visits.'</div>';
	}else{
		$out=$vis;
	}	
	return $out;
}
function pa_visitss($id){
	$out='<div class="ic40 icc1 ic40_info" title="'.k_info.'" onclick="showVisits('.$id.')" ></div>';	
	return $out;
}
function getThisWeek(){
	global $weekMod;
	$dd=0;
	$w=date('w');
	foreach($weekMod as $ww){
		if($w==$ww){break;}else{$dd++;}		
	}
	$start=(date('U')-(date('U')%86400))-($dd*86400);
	$end=$start+(7*86400);
	return array($start,$end);
}
function getDoc_Clinic(){
	global $logTs,$thisGrp,$thisUser;
	if($thisGrp=='7htoys03le' || $thisGrp=='nlh8spit9q'){
		$user_id=$thisUser;
		return get_val('_users','subgrp',$user_id);
	}
	if($thisGrp=='5j218rxbn0'){
		return get_val_c('gnr_m_clinics','id',2,'type');
	}	
}
function printCard($id){
	global $sender;
    fixMobileNo($id);
	if($sender=='Patients'){return script('pr_card('.$id.')');}
    //labJsonPat($id);
    
}
function fixMobileNo($id){
    $mobile=get_val('gnr_m_patients','mobile',$id);
    if($mobile){
        $mobile=fixNumber($mobile);
        mysql_q("UPDATE gnr_m_patients SET mobile='$mobile' where id='$id' ");
    }
}
function fixMobileNoT($id){
    $mobile=get_val('dts_x_patients','mobile',$id);
    if($mobile){
        $mobile=fixNumber($mobile);
        mysql_q("UPDATE dts_x_patients SET mobile='$mobile' where id='$id' ");
    }
}
function patCopyData($id){
	list($birth,$mobile)=get_val('gnr_m_patients','birth_date,mobile',$id);
	mysql_q("UPDATE gnr_m_patients_evaluation SET birth='$birth', mobile='$mobile' where id='$id' ");
    labJsonPat($id);
			
}
function checkDocPrv(){
	global $thisGrp,$MO_ID,$thisUser,$now,$logTime,$userSubType;
    $previewModule=[1=>'rkzmllzcn',3=>'qe9qdi3mu',4=>'nwhrv77mni',5=>'wzxjivev73',6=>'y55f08lm9i',7=>'gdp456lau'];    
    $mood=array_search($MO_ID,$previewModule);
	if(in_array($MO_ID,$previewModule) && $mood){
        $u=explode('.',$_SERVER['HTTP_REFERER']);
		$id=end($u);
        if($id){
            $sql="select * from gnr_x_visits_timer where visit_id='$id' and  mood='$mood' and user='$thisUser' ";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows){
                $r=mysql_f($res);
                $id=$r['id'];
                $status=$r['status'];
                $s_time=$r['s_time'];
                $e_time=$r['e_time'];
                $sp_time=$e_time-$s_time;
                $q="work= work+(e_time-s_time)";
                if(($now-$e_time) < ($logTime/1000)+6){
                    if($status==0){
                        mysql_q("UPDATE gnr_x_visits_timer set $q , e_time='$now',s_time='$now',status=1 where id='$id'");
                    }
                    if($status==1){
                        mysql_q("UPDATE gnr_x_visits_timer set e_time='$now' where id='$id'");
                    }
                }else{
                    mysql_q("UPDATE gnr_x_visits_timer set $q , e_time='$now',s_time='$now',status=0 where id='$id'");
                }
            }
        }
	}
}
function checkRackAlert(){	
	$out='';
	$a=getTotalCO('lab_x_racks_alert'," status=0 ");		
	echo "script::showRackAlert(".$a.")";	
}
function clockSty($t,$code=0){
	$out='';
    $h=$t;$m='0';$s='0';$c='AM';
	if(is_float($t)){
		$a=$t-intval($t);
		$h=intval($t);
		if($a!=0){$m=$a*60;}
	}
    $m=intval($m);
	if($m<10){$m='0'.$m;}
	if($h>12){$h=$h-12;$c='PM';}	
	if($code!=0){$out=$c.' ';}
	$out.=$h.':'.$m;
	return $out;
}

function getAnAge($age){
	global $age_types;
	if($age){
		$a=explode(',',$age);
		return '<span class="f1"> '.k_from.' <ff>'.$a[1].'</ff> <span class="f1">'.k_to.'</span> <ff>'.$a[2].'</ff> 
		<span class="f1 fs16"> ( '.$age_types[$a[0]].' )</span>';
	}else{return '<div class="f1 clr5">'.k_age_no_selected.'</div>';}
}
function clinicServisLink($id){
	global $f_path;
	$type=get_val('gnr_m_clinics','type',$id);
	$out='';
	if($type==1 || ($type==2 && _set_9jfawiejb9==0)){
		$t='n';
		$total=getTotalCO('cln_m_services'," clinic ='$id' ");		
		if($total>0){$t='t';}		
		$out.='
		<a href="'.$f_path.'Clinics-Services.'.$id.'" class="ex_link">
			<div class="child_link fl">
			<div '.$t.'>'.$total.'</div>'.k_services.'</div>		
		</a>';
	}
	if($type==2 && _set_9jfawiejb9){
		$t='n';
		$total=getTotalCO('lab_m_services');
		if($total>0){$t='t';}	
		$out.='
		<a href="'.$f_path.'Lab-Services" class="ex_link">
			<div class="child_link fl" >
			<div '.$t.'>'.$total.'</div>'.k_services.'</div>		
		</a>';
	}
	if($type==3){
		$t='n';
		$total=getTotalCO('xry_m_services'," clinic ='$id' ");		
		if($total>0){$t='t';}		
		$out.='
		<a href="'.$f_path.'X-Ray-Services.'.$id.'" class="ex_link">
			<div class="child_link fl">
			<div '.$t.'>'.$total.'</div>'.k_services.'</div>		
		</a>';
	}
	
	if($type==4){
		$t='n';
		$total=getTotalCO('den_m_services');
		if($total>0){$t='t';}	
		$out.='
		<a href="'.$f_path.'Den-Services" class="ex_link">
			<div class="child_link fl">
			<div '.$t.'>'.$total.'</div>'.k_services.'</div>	
		</a>';
	}
	if($type==5 || $type==6){
		$t='n';
		$total=getTotalCO('bty_m_services_cat',"clinic='$id' ");
		if($total>0){$t='t';}	
		$out.='
		<a href="'.$f_path.'Beauty-Services-Category.'.$id.'" class="ex_link">
			<div class="child_link fl">
			<div '.$t.'>'.$total.'</div>'.k_cats.' </div>	
		</a>';
	}
	if($type==7){
		$t='n';
		$total=getTotalCO('osc_m_services'," clinic ='$id' ");		
		if($total>0){$t='t';}		
		$out.='
		<a href="'.$f_path.'OSC-Services.'.$id.'" class="ex_link">
			<div class="child_link fl">
			<div '.$t.'>'.$total.'</div>'.k_services.'</div>		
		</a>';
	}
	return $out;
}
function servTime($id,$opr,$filed,$val,$type){
	global $lg;
	if($opr=='add' || $opr=='edit'){		
		$out='<select name="'.$filed.'" id="'.$filed.'" >';
		for($i=1;$i<=40;$i++){
			if($i*_set_pn68gsh6dj<=200){
				$sel='';
				if($val==$i){$sel=' selected ';}
				$out.='<option value="'.$i.'" '.$sel.' >'.($i*_set_pn68gsh6dj).' '.k_minute.'</option>';
			}
		}
		$out.='</select>';
	}else{
		if($val){
			$out='<ff>'.$val*_set_pn68gsh6dj.' </ff>'.k_minute;
			if(_set_ej94msmod1){
				if($type==1){$t=getTotalCO('cln_m_services_times',"service='$id'" );}
				//if($type==3){$t=getTotalCO('xry_m_services_times',"service='$id'" );}
				if($type==4){$t=getTotalCO('den_m_services_times',"service='$id'" );}
				//if($type==7){$t=getTotalCO('osc_m_services_times',"service='$id'" );}
				if($type==1){
					$out='';
					$s='t';								
					if($t==0){$s='n';}
					$link='setDocCusTime('.$id.','.$type.')';
					$out.='<div class="child_link fl w100" onclick="'.$link.'"><div '.$s.'>'.$t.'</div> '.k_cust_time.' <ff class="fs16"> | '.$val*_set_pn68gsh6dj.' </ff>'.k_minute.'</div></a>';
					
				}
			}			
		}
	}
	return $out;
}
function s_price($id,$type){
	global $srvTables,$clinicCode;
	$out='';
	list($s1,$s2)=get_val($srvTables[$type],'hos_part,doc_part',$id);
	$out.='<ff>'.($s1+$s2).'</ff>';	
	if(_set_virrge4o02){
		if($type!=6){
			$out='';
			$s='t';
			$t=getTotalCO('gnr_m_services_prices',"service='$id' and mood ='$type' " );			
			if($t==0){$s='n';}
			$link='setDocCusPrice('.$id.','.$type.')';
			$out.='<div class="child_link fl w100" onclick="'.$link.'"><div '.$s.'>'.$t.'</div>'.k_cust_price.'<ff class="fs16"> | '.number_format($s1+$s2).'</ff></div></a>';			
		}
	}	
	return $out;
}
function setInsurPrice($id,$type){
	$out='';
	if(_set_rkq2s40u5g){
		$t=getTotalCO('gnr_m_insurance_prices',"type='$type' and service='$id'" );		
		$s='t';
		if($t==0){$s='n';}
		$link='setInsurPrice('.$id.','.$type.')';
		$out.='<div class="child_link fl" onclick="'.$link.'"><div '.$s.'>'.$t.'</div>'.k_compans.'</div></a>';
		return $out;	
	}else{
		return '-';
	}
}
function get_docTimePrice($doc,$srvs,$type=0,$dts=0){
	if(!$srvs){$srvs=0;}
	if($type==1){
		$sql="select * from cln_m_services where id IN($srvs) order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);		
		if($rows>0){
			$serv_data=array();
			while($r=mysql_f($res)){
				$s_id=$r['id'];			
				$serv_data[$s_id]['ser_time']=$r['ser_time'];				
				$hos_part=$r['hos_part'];
				$doc_part=$r['doc_part'];				
				$serv_data[$s_id]['price']=$hos_part+$doc_part;
			}
			$sql="select * from gnr_m_services_prices where service IN($srvs) and doctor='$doc'";
			$res=mysql_q($sql);
			$rows=mysql_n($res);		
			if($rows>0){
				while($r=mysql_f($res)){
					$serv_id=$r['service'];
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
                    $total=$hos_part+$doc_part;
                    if($total){
					   $serv_data[$serv_id]['price']=$total;
                    }
				}
			}
			$sql="select * from cln_m_services_times where service IN($srvs) and doctor='$doc'";
			$res=mysql_q($sql);
			$rows=mysql_n($res);		
			if($rows>0){
				while($r=mysql_f($res)){
					$serv_id=$r['service'];		
					$serv_data[$serv_id]['ser_time']=$r['ser_time'];
                    if($dts){
                        $t=$r['ser_time']*_set_pn68gsh6dj;
                        mysql_q("UPDATE dts_x_dates_services set ser_time='$t' where dts_id='$dts' and service='$serv_id'");
                    }
				}
			}
			$p=$t=0;
			foreach($serv_data as $s){
				$t+=$s['ser_time']*_set_pn68gsh6dj;
				$p+=$s['price'];
			}
			return array($t,$p);
		}
	}
	if($type==3){		
		if($srvs){
			$sql="select * from xry_m_services where id IN($srvs) order by ord ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);		
			if($rows>0){
				$serv_data=array();
				while($r=mysql_f($res)){
					$s_id=$r['id'];			
					$serv_data[$s_id]['ser_time']=$r['ser_time'];				
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];				
					$serv_data[$s_id]['price']=$hos_part+$doc_part;

				}			
				$p=$t=0;
				foreach($serv_data as $s){
					$t+=$s['ser_time']*_set_pn68gsh6dj;
					$p+=$s['price'];
				}
				return array($t,$p);
			}
		}
	}
	if($type==5 || $type==6){	
		$sql="select * from bty_m_services where id IN($srvs) order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);		
		if($rows>0){
			$p=$t=0;
			$serv_data=array();
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$t+=$r['ser_time'];
				if($type==5){
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];				
					$p+=$hos_part+$doc_part;
				}
			}
			$t=$t*_set_pn68gsh6dj;						
			return array($t,$p);
		}
	}
	if($type==7){
		$sql="select * from osc_m_services where id IN($srvs) order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);		
		if($rows>0){
			$serv_data=array();
			while($r=mysql_f($res)){
				$s_id=$r['id'];			
				$serv_data[$s_id]['ser_time']=$r['ser_time'];				
				$hos_part=$r['hos_part'];
				$doc_part=$r['doc_part'];				
				$serv_data[$s_id]['price']=$hos_part+$doc_part;

			}
			// $sql="select * from osc_m_services_prices where service IN($srvs) and doctor='$doc'";
			// $res=mysql_q($sql);
			// $rows=mysql_n($res);		
			// if($rows>0){
			// 	while($r=mysql_f($res)){
			// 		$serv_id=$r['service'];
			// 		$hos_part=$r['hos_part'];
			// 		$doc_part=$r['doc_part'];
			// 		$serv_data[$serv_id]['price']=$hos_part+$doc_part;
			// 	}
			// }
			// $sql="select * from osc_m_services_times where service IN($srvs) and doctor='$doc'";
			// $res=mysql_q($sql);
			// $rows=mysql_n($res);		
			// if($rows>0){
			// 	while($r=mysql_f($res)){
			// 		$serv_id=$r['service'];		
			// 		$serv_data[$serv_id]['ser_time']=$r['ser_time'];
			// 	}
			// }
			$p=$t=0;
			foreach($serv_data as $s){
				$t+=$s['ser_time']*_set_pn68gsh6dj;
				$p+=$s['price'];
			}
			return array($t,$p);
		}
	}
}
function get_docServPrice($doc,$srv,$mood){
	global $srvTables,$clinicCode;
	$out=array(0,0,0,0);
	$table=$srvTables[$mood];
	$out=get_val($table,'hos_part,doc_part,doc_percent',$srv);	 
    $price=get_val_con('gnr_m_services_prices','hos_part,doc_part,doc_percent',"service ='$srv' and doctor='$doc' and mood='$mood' ");
	if($price){$out=$price;$out[3]=1;}else{$out[3]=0;} 
	return $out;	
}
function fixInsureServic($id,$in_price,$incPrice,$x_ser,$mood,$in_res,$company,$curectMood=0){
	global $now,$visXTables;
	list($perc,$units_price)=get_val('gnr_m_insurance_prov','company_perc,lab_unit_price',$company);
	$table=$visXTables[$mood];
	if($mood==1){ 		
		$new_hos_part=0;
		$new_doc_part=0;	list($hos_part,$doc_part,$doc_percent,$vis,$patient,$s_status,$service)=get_val('cln_x_visits_services','hos_part,doc_part,doc_percent,visit_id,patient,status,service',$x_ser);
		list($visStatus,$pay_type_link)=get_val($table,'status,pay_type_link',$vis);
		$mainPrice=$hos_part+$doc_part;
		$in_price_net=$in_price*(100-$perc)/100;
		$cost=$in_price-$in_price_net;	
		$new_doc_part=$doc_part;
		if($in_price_net<$mainPrice){
			if($hos_part==0){
				$new_doc_part=$in_price_net;
			}else{				
                $new_perc=$doc_part*100/$mainPrice;
                $new_doc_part=$in_price_net*$new_perc/100;
                //$new_doc_part=$in_price_net-$hos_part; 
			}
		}
		$pay_type=0;
		if($in_res==1){$pay_type=3;}
		$new_hos_part=$in_price-$new_doc_part;
		$pay_net=$in_price-$incPrice;
		
		$doc_bal=($new_doc_part*$doc_percent)/100;
		$hos_bal=($new_doc_part+$new_hos_part)-$doc_bal;
		$sql="UPDATE cln_x_visits_services SET 
		hos_part='$new_hos_part', 
		doc_part='$new_doc_part',
		hos_bal='$hos_bal', 
		doc_bal='$doc_bal', 
		total_pay='$in_price',
		pay_net='$pay_net',
		pay_type='$pay_type',
        
        doc_bal=0,
        doc_dis=0,
        hos_bal=0,
        hos_dis=0,
        app=0
        
		where id='$x_ser';
		";		
		mysql_q($sql);
        mysql_q("UPDATE cln_x_visits SET app=0 where id='$vis';");
		if($curectMood==0){
            //echo '('.$visStatus.'-'.$s_status.'-'.$s_status.')';
			if($visStatus!=0 && $s_status!=2 && $s_status!=5){
				$backPay=$mainPrice-$pay_net;
				if($backPay){
					$sql="INSERT INTO gnr_x_insur_pay_back (`insur_rec`,`patient`,`mood`,`visit`,`service_x`,`amount`,`date`)values
					('$id','$patient','$mood','$vis','$x_ser','$backPay','$now')";
					mysql_q($sql);
				}
			}
			if($s_status==5){
				if(!$pay_net){
					//mysql_q("UPDATE gnr_x_visits_services_alert SET amount='$pay_net' where mood='$mood' and visit_id='$vis' and  service='$service' ");
				//}else{
					mysql_q("UPDATE cln_x_visits_services SET status=1 where visit_id='$vis' and  id='$x_ser' and status=5 ");
					//mysql_q("DELETE from gnr_x_visits_services_alert where mood='$mood' and visit_id='$vis' and  service='$service' limit 1");
					if(getTotalCO('gnr_x_visits_services_alert',"visit_id='$vis' and status=0")==0){
						//mysql_q("DELETE from gnr_x_visits_services_alert where mood='$mood' and visit_id='$vis' ");
                        mysql_q("UPDATE gnr_x_visits_services_alert SET statu=1 , date='$now' where mood='$mood' and visit_id='$vis' ");
					}
				}
			}
		}
	}
	if($mood==3){		
		$new_hos_part=0;
		$new_doc_part=0;	list($hos_part,$doc_part,$doc_percent,$vis,$patient,$s_status,$service)=get_val('xry_x_visits_services','hos_part,doc_part,doc_percent,visit_id,patient,status,service',$x_ser);		
		list($visStatus,$pay_type_link)=get_val($table,'status,pay_type_link',$vis);
		$mainPrice=$hos_part+$doc_part;
		$in_price_net=$in_price*(100-$perc)/100;
		$cost=$in_price-$in_price_net;	
		$new_doc_part=$doc_part;
		if($in_price_net<$mainPrice){
			if($hos_part==0){			
				$new_doc_part=$in_price_net;
			}else{
				$new_doc_part=($doc_part*$in_price_net/$in_price_net);
			}
		}
		$pay_type=0;
		if($in_res==1){$pay_type=3;}
		$new_hos_part=$in_price-$new_doc_part;
		$pay_net=$in_price-$incPrice;
		
		$doc_bal=($new_doc_part*$doc_percent)/100;
		$hos_bal=($new_doc_part+$new_hos_part)-$doc_bal;
		$sql="UPDATE xry_x_visits_services SET 
		hos_part='$new_hos_part', 
		doc_part='$new_doc_part',
		hos_bal='$hos_bal', 
		doc_bal='$doc_bal', 
		total_pay='$in_price',
		pay_net='$pay_net',
		pay_type='$pay_type',
        
        doc_bal=0,
        doc_dis=0,
        hos_bal=0,
        hos_dis=0,
        app=0
        
		where id='$x_ser'; ";
		mysql_q($sql);
        mysql_q("UPDATE xry_x_visits SET app=0 where id='$vis';");
		if($curectMood==0){
			if($visStatus!=0 && $s_status!=2 && $s_status!=5){
				$backPay=$mainPrice-$pay_net;
				if($backPay){
					$sql="INSERT INTO gnr_x_insur_pay_back (`insur_rec`,`patient`,`mood`,`visit`,`service_x`,`amount`,`date`)values
					('$id','$patient','$mood','$vis','$x_ser','$backPay','$now')";
					mysql_q($sql);
				}
			}
			if($s_status==5){			
				if(!$pay_net){
					//mysql_q("UPDATE gnr_x_visits_services_alert SET amount='$pay_net' where mood='$mood' and visit_id='$vis' and  service='$service' ");
				//}else{
					mysql_q("UPDATE xry_x_visits_services SET status=1 where visit_id='$vis' and  id='$x_ser' and status=5 ");
					//mysql_q("DELETE from gnr_x_visits_services_alert where mood='$mood' and visit_id='$vis' and  service='$service' limit 1");
					if(getTotalCO('gnr_x_visits_services_alert',"visit_id='$vis' and status=0")==0){
						//mysql_q("DELETE from gnr_x_visits_services_alert where mood='$mood' and visit_id='$vis' ");
                        mysql_q("UPDATE gnr_x_visits_services_alert SET statu=1 , date='$now' where mood='$mood' and visit_id='$vis' ");
					}
				}
			}
		}
	}
	if($mood==2){
		
		list($unit,$vis,$patient,$service)=get_val('lab_x_visits_services','units,visit_id,patient,service',$x_ser);		
		list($visStatus,$pay_type_link)=get_val($table,'status,pay_type_link',$vis);
		$units_p=$units_price;
		//echo " insur='$company' and service='$service' <br>"; 
		$customPrice=get_val_con('gnr_m_insurance_prices_custom','price'," insur='$company' and service='$service' ");
		if($customPrice){$units_p=$customPrice;}
		$mainPrice=$unit*$units_p;
		$in_price_net=$in_price*(100-$perc)/100;
		$cost=$in_price-$in_price_net;
		$pay_type=0;
		if($in_res==1){$pay_type=3;}
		$pay_net=$in_price-$incPrice;
		$sql="UPDATE lab_x_visits_services SET 
		units_price='$units_p' ,
		total_pay='$in_price',
		pay_net='$pay_net',	
		pay_type='$pay_type'
		where id='$x_ser';
		";
		mysql_q($sql);
		if($curectMood==0){
			if($visStatus!=0){
				$backPay=$mainPrice-$pay_net;
				if($backPay){
					$sql="INSERT INTO gnr_x_insur_pay_back (`insur_rec`,`patient`,`mood`,`visit`,`service_x`,`amount`,`date`)values
					('$id','$patient','$mood','$vis','$x_ser','$backPay','$now')";
					mysql_q($sql);
				}
			}
		}	
	}
	if($mood==7){		
		$new_hos_part=0;
		$new_doc_part=0;        
        list($hos_part,$doc_part,$doc_percent,$vis,$patient,$s_status,$service)=get_val('osc_x_visits_services','hos_part,doc_part,doc_percent,visit_id,patient,status,service',$x_ser);        
		list($visStatus,$pay_type_link)=get_val($table,'status,pay_type_link',$vis);
		/*$mainPrice=$hos_part+$doc_part;
		$in_price_net=$in_price*(100-$perc)/100;
		$cost=$in_price-$in_price_net;	
		$new_doc_part=$doc_part;
		if($in_price_net<$mainPrice){
			if($hos_part==0){			
				$new_doc_part=$in_price_net;
			}else{
				$new_doc_part=($doc_part*$in_price_net/$in_price_net);
			}
		}
		$pay_type=0;
		if($in_res==1){$pay_type=3;}
		$new_hos_part=$in_price-$new_doc_part;
		$pay_net=$in_price-$doc_bal;
		
		$doc_bal=$new_doc_part*$doc_percent/100;
		$hos_bal=($new_doc_part+$new_hos_part)-$doc_bal;*/
        $new_hos_part=0;
        $new_doc_part=$in_price;
        $doc_bal=($in_price/100)*$doc_percent;
        $hos_bal=$in_price-$doc_bal;
        $pay_net=$in_price-$incPrice;
        
		$sql="UPDATE osc_x_visits_services SET 
		hos_part='$new_hos_part', 
		doc_part='$new_doc_part',
		hos_bal='$hos_bal', 
		doc_bal='$doc_bal', 
		total_pay='$in_price',
		pay_net='$pay_net',
		pay_type='$pay_type',
        
        doc_bal=0,
        doc_dis=0,
        hos_bal=0,
        hos_dis=0,
        app=0
        
		where id='$x_ser';";
		mysql_q($sql);
		mysql_q("UPDATE osc_x_visits SET app=0 where id='$vis';");
		if($curectMood==0){
			if($visStatus!=0 && $s_status!=2 && $s_status!=5){
				$backPay=$mainPrice-$pay_net;
				if($backPay){
					$sql="INSERT INTO gnr_x_insur_pay_back (`insur_rec`,`patient`,`mood`,`visit`,`service_x`,`amount`,`date`)values
					('$id','$patient','$mood','$vis','$x_ser','$backPay','$now')";
					mysql_q($sql);
				}
			}
			if($s_status==5){			
				if(!$pay_net){
					//mysql_q("UPDATE gnr_x_visits_services_alert SET amount='$pay_net' where mood='$mood' and visit_id='$vis' and  service='$service' ");
				//}else{
					mysql_q("UPDATE osc_x_visits_services SET status=1 where visit_id='$vis' and  service='$service' and status=5 ");
					//mysql_q("DELETE from gnr_x_visits_services_alert where mood='$mood' and visit_id='$vis' and  service='$service' limit 1");
					if(getTotalCO('gnr_x_visits_services_alert',"visit_id='$vis' and status=0")==0){
						//mysql_q("DELETE from gnr_x_visits_services_alert where mood='$mood' and visit_id='$vis' ");
                        mysql_q("UPDATE gnr_x_visits_services_alert SET statu=1, date='$now' where mood='$mood' and visit_id='$vis' ");
					}
				}
			}
		}
	}
	if(!$pay_type_link){
		mysql_q("UPDATE $table SET pay_type_link='$company' where id='$vis' ");
	}
}
function payInsur($id){
	$amount=get_val('gnr_x_insur_pay_back','amount',$id);
	return '<div class="bu bu_t1 buu fl" onclick="backInsur('.$id.','.$amount.')">'.k_amount_ret.'</div>';
}
function getDocWorkTime($v,$clinic){
	global $now,$thisUser;
	$sql="select vis , mood , time_need from gnr_x_roles where status < 3 and clic in ($clinic) and (doctor='$thisUser' or doctor=0 )";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$co=0;
		while($r=mysql_f($res)){
			$vis=$r['vis'];
			$time_need=$r['time_need'];
            $mood=$r['mood'];			
			$tt=($time_need*_set_pn68gsh6dj)-getRealWorkTime($vis,$mood);
			if($tt<0)$tt=0;
			$co+=$tt;
		}
	}
	return $co;	
}
function getVistInfo($vis,$mood){
	global $visXTables;
	$out=array();
	$table=$visXTables[$mood];
	if($mood==2){
		list($patient,$reg_user)=get_val($table,'patient,reg_user',$vis);
		$doctor='';
		$clinic=get_val_c('gnr_m_clinics','id',2,'type');	
	}else{
	list($patient,$reg_user,$clinic,$doctor)=get_val($table,'patient,reg_user,clinic,doctor',$vis);	
	}
	$out['p']=$patient;
	$out['u']=$reg_user;
	$out['c']=$clinic;
	$out['d']=$doctor;

	return $out;
}
function servisNames($id,$val,$type){
	if($type==1){
		$mood=get_val('gnr_x_insurance_rec','mood',$id);
		return srvName($mood,$val);
	}
}
function srvName($mood,$srv){
	global $lg;
	if($mood==1){return get_val('cln_m_services','name_'.$lg,$srv);}
	if($mood==2){return get_val('lab_m_services','name_'.$lg,$srv);}
	if($mood==3){return get_val('xry_m_services','name_'.$lg,$srv);}
	if($mood==4){return get_val('den_m_services','name_'.$lg,$srv);}
	if($mood==5){return get_val('bty_m_services','name_'.$lg,$srv);}
	if($mood==6){return get_val('bty_m_services','name_'.$lg,$srv);}
}
function printHeader($type){
	global $m_path;
	$out='';
	$headerSize=3.5;
	$imgCode='';
	if($type==4){
		$imgCode=_set_14jk4yqz3w;
		$hs= floatval(_set_g6t04uxz0n);
		if($hs){$headerSize=$hs;}
	}
	if($type==5){
		$imgCode=_set_50wxlrujf;
		$hs= floatval(_set_76nyqowzwb);
		if($hs){$headerSize=$hs;}		
	}
	$out.='<div class="ppinHead" style="height:'.$headerSize.'cm">';
	if($imgCode){
		$image=getImages($imgCode);
		$file=$image[0]['file'];
		$folder=$image[0]['folder'];
		list($w,$h)=getimagesize("sData/".$folder.$file);
		$fullfile=$m_path.'upi/'.$folder.$file;
		$out.='<img src="'.$fullfile.'" width="100%"/>';
	}
	//if($logo){$out.='<div class=" fr w100">'.$logo.'</div>';}
	$out.='</div>';
	return $out;
}
function exportTitle($title,$cols){
	return '<tr><td txt colspan="'.$cols.'" style="font-size:30">'.$title.'</td></tr>';
}
function isNewPat($pat,$doc,$mood){
	global $visXTables;
	$newPat=1;
	$table=$visXTables[$mood];	
	$q_doc="and doctor='$doc'";	
	if($mood==2){$q_doc='';}	
	if(getTotalCO($table," patient='$pat' $q_doc ")){$newPat=0;}
	return $newPat;
}
/*****************/
function getDocTimeDay($doc,$dayNo){
	$out=0;
	list($h_type,$hData,$days)=get_val('gnr_m_users_times','type,data,days',$doc);
	$d_days=explode(',',$days);
	if(in_array($dayNo,$d_days)){		
		if($h_type==1){
			$d_dates=explode(',',$hData);
			$out=($d_dates[1]-$d_dates[0])+($d_dates[3]-$d_dates[2]);				
		}else{
			$d_dates=explode('|',$hData);			
			$i=0;
			foreach($d_days as $d){
				if($d==$dayNo){
					$d_d=explode(',',$d_dates[$i]);				
					$out=($d_d[1]-$d_d[0])+($d_d[3]-$d_d[2]);	
				}
				$i++;
			}
		}
	}
	return $out/60;
}
function sencDocWork(){
	global $ss_day;
	$lastSenc=strtotime(_set_prexiyzsj);
	if($lastSenc<$ss_day-(86400*3)){
		$newDay=$lastSenc+86400;
		$newDayDate=date('Y-m-d',$newDay);
		sencDocWorkDoo($newDay);
		backupPayment($newDay);
		$lastSenc2=get_val_c('_settings','val','prexiyzsj','code');
		if($lastSenc2==_set_prexiyzsj){
			mysql_q("UPDATE _settings SET val='$newDayDate' where code='prexiyzsj' ");
		}
	}    
}
function sencDocWorkDoo($d_s,$doc=0){
	global $visXTables,$srvXTables;
	$docClnicType=array();
	$doc_data=array();
	$table='gnr_r_docs_details';
	$d_e=$d_s+86400;
	$q2='';
	if($doc){$q2=" and id='$doc' ";}
	$sql="select id,subgrp,grp_code from _users where grp_code IN('7htoys03le','nlh8spit9q','fk590v9lvl','9yjlzayzp','66hd2fomwt','1ceddvqi3g','9k0a1zy2ww') and act=1 $q2 ";
	$res=mysql_q($sql);	
	$q=" and  d_start>='$d_s' and d_start < '$d_e' ";
	while($r=mysql_f($res)){
		$doc_id=$r['id'];
		$clinic=$r['subgrp'];
		$grp=$r['grp_code'];
		$mood=get_val_con('gnr_m_clinics','type'," id IN ($clinic)" );
		$docClnicType[$doc_id]=$mood;
		$tab=$visXTables[$mood];
		$visits=getTotalCO($tab,"status=2  and doctor='$doc_id' $q");
		$workTime=getDocTimeDay($doc_id,date('w',$d_s));
		$doc_data[$doc_id]['estimat']=$workTime;
		$doc_data[$doc_id]['grp']=$grp;
		$doc_data[$doc_id]['clinic']=$clinic;
		if($visits || $workTime){
			$doc_data[$doc_id]['v_free']=$doc_data[$doc_id]['v_cash']=0;
			$doc_data[$doc_id]['vis']=$visits;			
			if($mood==1){$doc_data[$doc_id]['v_free']=getTotalCO($tab,"status=2 and  doctor='$doc_id' and t_total_pay=0 $q ");}
			if($mood==3){
				$doc_data[$doc_id]['v_free']=getTotalCO($tab,"status=2 and  ray_tec='$doc_id' and t_total_pay=0 $q ");
				$doc_data[$doc_id]['clinic']=0;
			}			
			$doc_data[$doc_id]['v_cash']=$visits-$doc_data[$doc_id]['v_free'];			
			$doc_data[$doc_id]['v_new_pat']=getTotalCO($tab,"status=2 and  doctor='$doc_id' and new_pat='1' $q ");
			$doc_data[$doc_id]['v_employee']=getTotalCO($tab,"status=2 and  doctor='$doc_id' and emplo='1' $q ");
			$doc_data[$doc_id]['pt0']=getTotalCO($tab,"status=2 and  doctor='$doc_id' and pay_type='0' $q ");
			$doc_data[$doc_id]['pt1']=getTotalCO($tab,"status=2 and  doctor='$doc_id' and pay_type='1' $q ");
			$doc_data[$doc_id]['pt2']=getTotalCO($tab,"status=2 and  doctor='$doc_id' and pay_type='2' $q ");
			$doc_data[$doc_id]['pt3']=getTotalCO($tab,"status=2 and  doctor='$doc_id' and pay_type='3' $q ");
		}else{
			mysql_q("DELETE from $table where date ='$d_s' and doctor='$doc_id' ");
		}
	}
	// CLN
	$sql="select * from cln_x_visits_services  where status=1 and  d_start>='$d_s' and d_start < '$d_e' order by id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){				
		while($r=mysql_f($res)){
			$doc=$r['doc'];
			$vis=$r['visit_id'];			
			if($doc){
				$service=$r['service'];
				$serviceTime=get_val('cln_m_services','ser_time',$service)*_set_pn68gsh6dj;
				$total_pay=$r['total_pay'];				
				$srv_type=$r['srv_type'];
				$doc_data[$doc]['srv']++;
				$doc_data[$doc]['total']+=$total_pay;
				$doc_data[$doc]['srvTime']+=$serviceTime;
				$doc_data[$doc]['st'.$srv_type]++;
			}
		}
	}
	// XRY
	$sql="select * from xry_x_visits_services  where status=1 and  d_start>='$d_s' and d_start < '$d_e' order by id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){				
		while($r=mysql_f($res)){
			$doc=$r['doc'];
			$vis=$r['visit_id'];
			$doc=get_val('xry_x_visits','ray_tec',$vis);
			if($doc){
				$service=$r['service'];
				$serviceTime=get_val('cln_m_services','ser_time',$service)*_set_pn68gsh6dj;
				$total_pay=$r['total_pay'];				
				$srv_type=$r['srv_type'];
				$doc_data[$doc]['srv']++;
				$doc_data[$doc]['total']+=$total_pay;
				$doc_data[$doc]['srvTime']+=$serviceTime;
				$doc_data[$doc]['st'.$srv_type]++;
			}
		}
	}
	// DEN
	$sql="select * from den_x_visits_services  where status=1 and  doc!=0 and d_start>='$d_s' and d_start < '$d_e' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$doc=$r['doc'];
			$vis=$r['visit_id'];
			if($doc){
				$service=$r['service'];
				$serviceTime=get_val('den_m_services','ser_time',$service)*_set_pn68gsh6dj;
				
				$total_pay=$r['total_pay'];				
				$srv_type=$r['srv_type'];
				
				$doc_data[$doc]['srv']++;
				$doc_data[$doc]['total']+=$total_pay;
				$doc_data[$doc]['srvTime']+=$serviceTime;
				$doc_data[$doc]['st'.$srv_type]++;
			}
		}
	}
	// BTY
	$sql="select * from bty_x_visits_services  where status=1 and  doc!=0 and d_start>='$d_s' and d_start < '$d_e' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$doc=$r['doc'];
			$vis=$r['visit_id'];			
			if($doc){
				$service=$r['service'];
				$serviceTime=get_val('bty_m_services','ser_time',$service)*_set_pn68gsh6dj;
				
				$total_pay=$r['total_pay'];				
				$srv_type=$r['srv_type'];
				
				$doc_data[$doc]['srv']++;
				$doc_data[$doc]['total']+=$total_pay;
				$doc_data[$doc]['srvTime']+=$serviceTime;
				$doc_data[$doc]['st'.$srv_type]++;
			}
		}
	}
	// LSR
	$sql="select * from bty_x_laser_visits  where status=2 and  doctor!=0 and d_start>='$d_s' and d_start < '$d_e' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){			
			$v_id=$r['id'];
			$doc=$r['doctor'];
			
			$serviceTime=get_sum('bty_m_services','ser_time'," id IN ( select service from bty_x_laser_visits_services where visit_id='$v_id')")*_set_pn68gsh6dj;
			$srvTotalCo=getTotal('bty_x_laser_visits_services'," visit_id='$v_id')");
			
			$total_pay=$r['total_pay'];
			$hos_dis=$r['dis'];

			$hos_part=$total_pay;					
			$hos_bal=$total_pay;
			$pay_net=$total_pay;

			$doc_data[$doc]['srv']+=$srvTotalCo;
			$doc_data[$doc]['total']+=$total_pay;
			$doc_data[$doc]['srvTime']+=$serviceTime;
			$doc_data[$doc]['st0']++;

		}
	}
	// OSC
	$sql="select * from osc_x_visits_services  where status=1 and  d_start>='$d_s' and d_start < '$d_e' order by id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){				
		while($r=mysql_f($res)){
			$doc=$r['doc'];
			$vis=$r['visit_id'];			
			if($doc){
				$service=$r['service'];
				$serviceTime=get_val('osc_m_services','ser_time',$service)*_set_pn68gsh6dj;
				$total_pay=$r['total_pay'];				
				$srv_type=$r['srv_type'];
				$doc_data[$doc]['srv']++;
				$doc_data[$doc]['total']+=$total_pay;
				$doc_data[$doc]['srvTime']+=$serviceTime;
				$doc_data[$doc]['st'.$srv_type]++;
			}
		}
	}
	/******************************/
	foreach($doc_data as $k => $d){
		$d_id=$k;
		$doc_type=$docClnicType[$k];
		$estimat=$d['estimat'];
		$v_total=$d['vis'];
		$d_grp=$d['grp'];
		$d_clinic=$d['clinic'];
		$v_cash=$d['v_cash'];
		$v_free=$d['v_free'];
		$v_employee=$d['v_employee'];
		$v_new_pat=$d['v_new_pat'];
		$s_total=$d['srv'];
		$s_total_time=$d['srvTime'];
		$total_revenue=$d['total'];
		$st0=$d['st0'];$st1=$d['st1'];$st2=$d['st2'];
		$pt0=$d['pt0'];$pt1=$d['pt1'];$pt2=$d['pt2'];$pt3=$d['pt3'];		
		$rec=getRecCon($table," date='$d_s' and doc='$d_id' ");

		if($s_total || $estimat){			
			if(!$v_employee){$v_employee=0;}
			if(!$v_new_pat){$v_new_pat=0;}
			if(!$estimat){$estimat=0;}
			if(!$v_cash){$v_cash=0;}
			if(!$v_free){$v_free=0;}				
			if(!$v_total){$v_total=0;}
			if(!$s_total){$s_total=0;}				
			if(!$s_total_time){$s_total_time=0;}
			if(!$total_revenue){$total_revenue=0;}
			if(!$st0){$st0=0;}if(!$st1){$st1=0;}if(!$st2){$st2=0;}
			if(!$pt0){$pt0=0;}if(!$pt1){$pt1=0;}if(!$pt2){$pt2=0;}if(!$pt3){$pt3=0;}			
			if($rec['r']){			
				if(
					$doc_type!=$rec['doc_type'] ||
					$v_total!=$rec['v_total'] ||
					$v_new_pat!=$rec['v_new_pat'] ||							
					$v_free!=$rec['v_free'] ||
					$v_cash!=$rec['v_cash'] ||
					$estimat!=$rec['estimated'] ||
					$s_total!=$rec['s_total']
				){
					$sql="UPDATE $table SET 
					estimated='$estimat',
					v_total='$v_total',
					v_normal='$pt0',
					v_exemption='$pt1',
					v_charity='$pt2',
					v_insurance='$pt3',
					v_cash='$v_cash',
					v_free='$v_free',
					v_employee='$v_employee',
					v_new_pat='$v_new_pat',
					s_total='$s_total',
					s_preview='$st0',
					s_procedure='$st1',
					s_review='$st2',
					s_total_time='$s_total_time',
					total_revenue='$total_revenue'
					where date ='$d_s' and doc='$d_id' ";
					mysql_q($sql);
				}
			}else{				
				$sql="INSERT INTO $table (date,doc,doc_type,estimated,v_total,v_normal,v_exemption,v_charity,v_insurance,v_cash,v_free,v_employee,v_new_pat,s_total,s_preview,s_procedure,s_review,s_total_time,total_revenue,grp,clinic)						values('$d_s','$d_id','$doc_type','$estimat','$v_total','$pt0','$pt1','$pt2','$pt3','$v_cash','$v_free','$v_employee','$v_new_pat','$s_total','$st0','$st1','$st2','$s_total_time','$total_revenue','$d_grp','$d_clinic')";
				mysql_q($sql);
			}
		}else{
			if($rec['r']){mysql_q("DELETE from $table where date ='$d_s' and doc='$d_id' ");}
		}
	}	
	mysql_q("DELETE from gnr_x_temp_oprs where date < '$d_s' ");
	foreach($visXTables as $k => $table){
		if($k){
			$tableSrv=$srvXTables[$k];
			$vis=get_vals($table,'id'," status=0 and d_start < '$d_e'");
			if($vis){
				mysql_q("delete from $table where id in($vis)");
				mysql_q("delete from $tableSrv where visit_id in($vis)");		
			}
		}
	}	
}
function backupPayment(){
	$last_id=intval(getMaxMin('max','gnr_x_acc_p','id'));
    $sql="select * from gnr_x_acc_payments where id > $last_id and pay_type=1 ";
    $res=mysql_q($sql);
    while($r=mysql_f($res)){
        $id=$r['id'];
        $type=$r['type'];
        $vis=$r['vis'];
        $amount=$r['amount'];
        $date=$r['date'];
        $casher=$r['casher'];
        $mood=$r['mood'];
        $sql="INSERT INTO gnr_x_acc_p (`id`,`type`,`vis`,`amount`,`date`,`casher`,`mood`) values ('$id','$type','$vis','$amount','$date','$casher','$mood')";
        mysql_q($sql);
    }
}
function getRealWorkTime($vis,$mood,$real=0){
	global $now,$thisUser;
	$sql="select s_time , e_time , work from gnr_x_visits_timer where visit_id='$vis' and mood ='$mood' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$s_time=$r['s_time'];
        $e_time=$r['e_time'];
		$work=$r['work'];
        $out=$work+$now-$s_time;
        if($real){
            $out=$work+$e_time-$s_time;
        }
		return $out;
	}
	return 0;
}
function fixWorkTime($vis,$mood){
    global $now,$visXTables;
    $work_time=getRealWorkTime($vis,$mood,1);
    if($work_time){
        $table=$visXTables[$mood];
        mysql_q("UPDATE $table set work='$work_time' where status=2 and id='$vis'");
        mysql_q("DELETE from gnr_x_visits_timer where visit_id='$vis' and mood ='$mood' ");
        $time=$now+(10*60*60);       
    }
    mysql_q("DELETE from gnr_x_visits_timer where e_time>'$time' ");
}
/*****************Notv////*/
function api_notif($pat,$p_type,$type,$rec_id,$title='',$body='',$outType=1){                  
	global $now;
	$message_status='';
	$tokens=array();
	if(mysql_q("INSERT INTO api_notifications (`patient`,`type`,`p_type`,`rec_no`,`date`)values('$pat','$type','$p_type','$rec_id','$now')")){
        $not_id=last_id();
        list($message,$notData)=getTxtNotType($type,$rec_id,$title,$body,$not_id);
        
		$sql="select * from api_notifications_push where patient='$pat' and p_type='$p_type' ";
		$res=mysql_q($sql);
		if(mysql_n($res)>0){
			while($r=mysql_f($res)){
				$app=$r['app'];				
				//array_push($r["token"],$tokens);
				array_push($tokens,$r["token"]);
			}
			$key=get_val_c('api_users','notf_code',$app,'code');
			$out = send_single_notification($key,$tokens, $message,$notData);
            $out=json_decode($out,true);
            if($outType==1){
                $message_status=[$out['success'],$out['failure']];
            }else{
                $message_status=$out;
            }
		}
	}
	return $message_status;
} 
function notiStatus($data){    
    $message_id=$data['message_id'];
    $message_ids='';
    foreach($data['message_id'] as $id){
        $message_ids.=$id;
    }
    $out='Multicast_id: '.$data['multicast_id'].'<br>';
    $out.='Success: '.$data['success'].'<br>';
    $out.='Failure: '.$data['failure'].'<br>';
    $out.='Error: '.$data['results'][0]['error'].'<br>';
    $out.='Message_id: '.$data['results'][1]['message_id'].'<br>';
    return $out;
}
function getTxtNotType($type,$rec_id,$title='',$body='',$not_id=''){
	global $lg,$thisUser;
	$out=array();
    
    list($d_title,$d_body)=get_val_c('api_noti_list','name_'.$lg.',body_'.$lg,$type,'no');
    if(!$title){$title=$$d_title;}
    if(!$body){$body=$d_body;}
	$rSet=getRecCon('api_noti_set'," 1=1 ");
	if($rSet['r']){
//		$out[0]=array(
//			'title'=>$title,
//			'body'=>$body,		
//			'sound'=>$rSet['sound'],
//			'icon'=>$rSet['icon'],
//			'color'=>$rSet['color'],
//			'priority'=>$rSet['priority'],
//			'android_channel_id'=>$rSet['channal']
//		);
//		$out[1]=array(
//			'type'=>$type,
//			'id'=>$rec_id,
//            'cat'=>$cat,
//		);
        $out[0]=array('title'=>$title,'body'=>$body);
		$out[1]=array(
            'title'=>$title,
			'body'=>$body,		
			'sound'=>$rSet['sound'],
			'icon'=>$rSet['icon'],
			'color'=>$rSet['color'],
			'priority'=>$rSet['priority'],
			'android_channel_id'=>$rSet['channal'],
			'type'=>$type,
			'id'=>$rec_id,            
            'notification_id'=>$not_id,
		);
	}
	return $out;
}
function send_single_notification($key,$tokens,$message,$data){
	$url = 'https://fcm.googleapis.com/fcm/send';
	//$fields =array('registration_ids' => $tokens,'notification' => $message,'data' => $data);
    $fields =array('registration_ids' => $tokens,'data' => $data);
	$headers=array('Authorization:key ='.$key,'Content-Type: application/json');
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_POST,true);
	curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);  
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
	$result=curl_exec($ch);           
	if ($result === FALSE){die('Curl failed:'.curl_error($ch));}
	curl_close($ch);
	return $result;
}
/********************************/
function DTS_PayBalans($id,$vis=0,$mood=0){
    if($id){
        $q='';
        if($vis){$q= " OR (type=7 and vis='$vis' and mood='$mood') ";}
        $in=get_sum('gnr_x_acc_payments' ,'amount', " (type=6 and vis='$id') $q");
        $out=get_sum('gnr_x_acc_payments','amount', " type=8 and vis= '$id' ");
        return $in-$out;
    }
}
function offerSet($id){
	global $clinicTypes,$thisGrp;
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
    if($thisGrp!='o9yqmxot8'){
	   $out.='<div class="fr ic40 icc2 ic40_set" onclick="'.$action.'" title="'.k_offer_set.'"></div>';
    }
	return $out;
}
function ofItPrice($id,$opr,$filed,$val){
	$out='';
	if($opr=='add' || $opr=='edit'){
		$out.='<ff class="clr1 ofitInput" >'.$val.'</ff>';
		$out.='<input type="hidden" name="'.$filed.'" id="ofitInput" value="'.$val.'" >';
		$out.=Script('SETOfPrice();');
	}else{
		$out='<ff>'.$val.'</ff>';
	}
	return $out;
}
function oldMPats($id,$opr,$filed,$val){
	$out='<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" over="0" type="static" >';
	$d=explode('|',$val);
	$clr='fot';
	foreach($d as $d2){
		$out.='<tr '.$clr.'>';
		$d3=explode('^',$d2);
		$num=$d3[0];
		if(is_numeric($num)){$num=number_format($num);}
		$out.='
			<td width="100"><ff>'.$num.'</ff></td>
			<td width="300" txt>'.$d3[1].'</td>
			<td width="100"><ff>'.$d3[2].'</ff></td>
			<td width="100"><ff>'.$d3[3].'</ff></td>
			<td><div class="f1 clr5 fs14">'.$d3[4].'</ff></td>';
		$out.='</tr>';
		$clr='';
	}
	$out.='</table>';
	//$out='<div class="fl  lh40 fs16">'.$val.'</div>';
	return $out;
}
function offerStatus($mood,$v_id,$p){
	global $now;
	$out='';
	$msg='';
	$date_off_end=$now-86400;
	$masTypes=array();
	$patOffer=get_vals('gnr_x_offers_patient','offer'," patient='$p'",'arr');
	$bayOffer=get_vals('gnr_x_offers','offer_id'," patient='$p' and date_s < $now and date_e > $date_off_end and status=0 ",'arr');
	$sql="select * from gnr_m_offers where act =1 and date_s < $now and date_e > $date_off_end and FIND_IN_SET('$mood',`clinics`)> 0 order by type ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){		
		$types=modListToArray('we76o3udy');
		while($r=mysql_f($res)){
			$id=$r['id'];
			$type=$r['type'];
			$name=$r['name'];
			if(in_array($id,$bayOffer) && $type==1){
				$msg.='<div class="f1 fs14 clr5">'.$name.'</div>';
			}
			if(in_array($id,$patOffer) && $type==4){
				$msg.='<div class="f1 fs14 clr5">'.$name.'</div>';
			}
			$masTypes[$type]++;
		}
		$i=0;
		foreach($types as $k=> $m){
			if($masTypes[$k]){
				$msg.=$m.' <ff> ( '.$masTypes[$k].' )</ff> | ';
			}
			$i++;
		}
		$out='<div class=" fl w100">
			<div class="fl f1 fs16 cbg66  clrw  lh40 TC Over" fix="w:100" onclick="patOfferWin('.$mood.','.$v_id.','.$p.')">'.k_offers.'</div>
			<div class="fl f1 fs14 cbg4 lh20 pd10 ofx so" fix="wp:100|h:40">'.$msg.'</div>
		</div>';
	}
	return $out;
}
function fixOfferMood($id){
	$vals=get_vals('gnr_m_offers_items','mood'," offers_id='$id' ");
	mysql_q("UPDATE gnr_m_offers set clinics='$vals' where id='$id'");	
}
function offerOpr($mood,$pat,$offer_id,$offer_item,$service,$visit,$x_service,$doc){
	global $srvXTables,$srvTables,$now;
	$srvTable=$srvTables[$mood];
	$table=$srvXTables[$mood];
    $oPrice=0;
    if($mood==2){
        list($units,$units_price)=get_val($table,'units,units_price',$x_service);
        $oPrice=$units*$units_price;
    }else{
        //list($units,$units_price)=get_val($table,'units,units_price',$x_service);
        list($hp,$dp)=get_val($table,'hos_part,doc_part',$x_service);
        $oPrice=$hp+$dp;
    }
    if($oPrice>0){
        $date_off_end=$now-86400;
        $r=getRecCon('gnr_m_offers',"id='$offer_id' and act =1 and date_s < $now and date_e > $date_off_end and FIND_IN_SET('$mood',`clinics`)> 0 ");    
        $p_net='xz';
        if($r['r']){
		$o_type=$r['type'];
		$o_clinic=$r['clinics'];
		$o_sett=$r['sett'];
		$o_act=$r['act'];
		if($o_act){
			if(in_array($mood,array(1,3,4,5,7))){				   
				list($hos_part,$doc_part,$doc_percent)=get_val($srvTable,'hos_part,doc_part,doc_percent',$service);
                $org_price=$hos_part+$doc_part;
                $newPrice=get_docServPrice($doc,$service,$mood);
                $newP=$newPrice[0]+$newPrice[1];
                if($newP){
                    $hos_part= $newPrice[0] ;
                    $doc_part=$newPrice[1];
                    $org_price=$hos_part+$doc_part;
                }
			}			
			if($mood==2){				
				list($hos_part,$cus_unit_price)=get_val($srvTable,'unit,cus_unit_price',$service);
				$doc_part=_set_x6kmh3k9mh;
                if($cus_unit_price){$doc_part=$cus_unit_price;}
				$org_price=$hos_part*$doc_part;
				$doc_percent=0;
			}
			if($o_type==1 || $o_type==6){
				$r3=getRec('gnr_x_offers_items',$offer_item);
				if($r3['r']){
					$hos_part=$r3['hos_part'];
					$doc_part=$r3['doc_part'];
					$doc_percent=$r3['doc_percent'];
					$p_net=0;					
					if($mood!=$r3['mood'] || $pat!=$r3['patient'] || $service!=$r3['service']){return 0;}
				}			
			}
			if($o_type==2){
				$r3=getRec('gnr_m_offers_items',$offer_item);
				if($r3['r']){
					$hos_part=$r3['hos_part'];
					$doc_part=$r3['doc_part'];
					$doc_percent=$r3['doc_percent'];
					if($mood!=$r3['mood'] || $service!=$r3['service']){return 0;}
				}			
			}			
			if($o_type==3 || $o_type==4 || $o_type==5){
				$o_clinic_arr=explode(',',$o_clinic);
				if(in_array($mood,$o_clinic_arr)){
					$o_sett_arr=explode('|',$o_sett);
					$o_sett_arr2=explode(',',$o_sett_arr[0]);
					$disPerc=$o_sett_arr2[$mood-1];
					if($disPerc){
						if($mood!=2){
							$hos_part=intval(($hos_part/100)*(100-$disPerc));
						}
						$doc_part=intval(($doc_part/100)*(100-$disPerc));
						
						if($o_type==5){
							if($o_sett_arr[2]){
								$o_sett_arr3=explode(',',$o_sett_arr[2]);
								if(!($offer_item>=$o_sett_arr3[0] && $offer_item<=$o_sett_arr3[1])){
									return 0;
								}
							}
						}
					}else{
						return 0;
					}		
				}
			}			
			if(!$doc_percent){$doc_percent=0;}
			if(in_array($mood,array(1,3,4,5))){
				$newPrice=$hos_part+$doc_part;				
				if($p_net==='xz'){$p_net=$newPrice;}				
				$sql="UPDATE $table SET hos_part='$hos_part' , doc_part='$doc_part' ,doc_percent='$doc_percent' , pay_net='$p_net' , total_pay='$newPrice' , offer=1 where id='$x_service'  ";				
			}			
			if($mood==2){
				$newPrice=$hos_part*$doc_part;
				if($p_net==='xz'){$p_net=$newPrice;}
				$sql="UPDATE $table SET units='$hos_part' , units_price='$doc_part' , pay_net='$p_net' , total_pay='$newPrice' , offer=1 where id='$x_service' and offer=0";
				$newPrice=$hos_part*$doc_part;
			}			
			if(mysql_q($sql)){
				$sql="INSERT INTO gnr_x_offers_oprations (mood,patient,offer_type,offer,offer_item,offer_srv_price,service,visit,visit_srv,visit_srv_price,date,doc)
				values ('$mood','$pat','$o_type','$offer_id',$offer_item,'$newPrice','$service','$visit','$x_service','$org_price','$now','$doc')";
				if(mysql_q($sql)){return 1;}
			}
		}else{
			return 0;
		}
	}
    }
}
function getSrvOfeerS($offer,$mood,$vis,$srv){
	$out='';
	if($offer){
		$ro=getRecCon('gnr_x_offers_oprations',"mood='$mood' and visit='$vis' and visit_srv='$srv'");
		if($ro['r']){
			$offerNa=get_val_arr('gnr_m_offers','name',$ro['offer'],'off');
			$out='<div class="f1 lh20 clr66 offerItem" title="'.k_offer_cancel.'" onclick="cancelSrvOffer('.$ro['id'].','.$mood.','.$vis.')">'.k_offer.' : '.$offerNa.'</div>';
		}
	}
	return $out;
}
function getSrvPrice($mood,$srv){
	global $srvTables;
	$price=0;
	$table=$srvTables[$mood];
	if($mood==2){
		$unit=get_val($table,'unit',$srv);
		$price=$unit*_set_x6kmh3k9mh;
	}else{
		list($p1,$p2)=get_val($table,'hos_part,doc_part',$srv);
		$price=$p1+$p2;
	}
	return $price;
}
function delOfferVis($mood,$vis,$s=0){
	global $srvXTables;
	//$x_srv=get_vals($srvXTables[$mood],'id',"visit_id='$vis' and `status`=$s and `offer`=1 ");
	delOfferSrv($mood,$vis);	
}
function delOfferSrv($mood,$vis,$srv=0){
    global $srvXTables;
    $table=$srvXTables[$mood];
	if($vis){
		$q='';
		if($srv){$q=" and visit_srv='$srv' ";}
		$sql="select * from gnr_x_offers_oprations where mood='$mood' and visit='$vis' $q ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		while($r=mysql_f($res)){	
			$id=$r['id'];
			$type=$r['offer_type'];
			$offer_item=$r['offer_item'];
			if($type==1){
				mysql_q("UPDATE gnr_x_offers_items SET vis=0 ,srv_x_id=0 ,date='' ,status=0 where id='$offer_item' ");
			}
			mysql_q("DELETE from gnr_x_offers_oprations where id='$id'");
		}
		if($mood!=6){
        	mysql_q("UPDATE $table SET offer=0 where visit_id='$vis' ");
		}
		return 1;
	}
}
function activeOffer($mood,$cln,$doc,$pat,$visit,$service,$x_service){
	global $now;
	$actOffer=0;
	$offer_item=0;
	$offerSrvs=array();
    $vp_offer=get_val_con('gnr_x_offers_patient','offer'," patient='$pat'");
    $q2='';
    if($vp_offer){$q2=" OR side='$vp_offer' ";}
	$sql="select * from gnr_m_offers where act =1 and date_s < $now and date_e > $now and (side=0 $q2 ) and FIND_IN_SET('$mood',`clinics`)> 0 and type!=5 ORDER BY FIELD(type,3,2,1,4,6) ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	
	if($rows){
		while($r=mysql_f($res)){
			$o_id=$r['id'];
			$type=$r['type'];
			$sett=$r['sett'];
			if($type==3){$actOffer=$o_id;}
			if($type==4 && $vp_offer==$o_id){$actOffer=$o_id;}
			if($type==2){
                $item=get_val_con('gnr_m_offers_items','id',"offers_id ='$o_id' and mood='$mood' and service='$service'");
                if($item){
                    $offer_item=$item;
                    $actOffer=$o_id;
                }
			}
			if($type==1 || $type==6){
				$offItem=get_val_con('gnr_x_offers_items','id',"offer_id='$o_id' and mood='$mood' and service='$service' and patient='$pat' and status=0");
                //echo " select * from gnr_x_offers_items where offer_id='$o_id' and mood='$mood' and service='$service' and patient='$pat' and status=0";
				if($offItem){
					$actOffer=$o_id;
					$offer_item=$offItem;
				}
			}
		}
	}    
	if($actOffer){
		if(offerOpr($mood,$pat,$actOffer,$offer_item,$service,$visit,$x_service,$doc)){
            $sql=" UPDATE gnr_x_offers_items SET status=1 , date='$now' , vis='$visit' , srv_x_id='$x_service' where id='$offer_item' ";
            mysql_q($sql);
        }
	}
}
function getSrvOffers($mood,$pat){
	global $now;
    $vp_offer=get_val_con('gnr_x_offers_patient','offer'," patient='$pat'");
    $q2='';
    if($vp_offer){$q2=" OR side='$vp_offer' ";}
	$offers=get_vals('gnr_m_offers','id'," type=2 and date_s<='$now' and date_e >'$now' and act=1 and (side=0 $q2 ) ");    
	if($offers){//type2
		$sql="select * from gnr_m_offers_items where offers_id IN($offers) and mood='$mood'";
		$res=mysql_q($sql);
        $rows=mysql_n($res);
		while($r=mysql_f($res)){
			$oId=$r['id'];
			$s=$r['service'];
			$d=$r['dis_percent'];
            $mood=$r['mood'];
            $p=$r['price'];
			$srvs[]=[2,$s,$d,$oId,$p];
		}
	}
	/*********************/
	$offers=get_vals('gnr_x_offers','id'," patient='$pat' and date_s<='$now' and date_e >'$now' ");	
	if($offers){//type1 , type6
		$sql="select id,service from gnr_x_offers_items where x_offer_id IN($offers) and mood='$mood' and status=0";
		$res=mysql_q($sql);
        $rows=mysql_n($res);
		while($r=mysql_f($res)){
			$oId=$r['id'];
			$s=$r['service'];
			$srvs[]=array(1,$s,0,$oId);
		}
	}
	return $srvs;
}
function offersList($mood,$pat){
	global $now,$bupOffer;
	$out='';
    $vp_offer=intval(get_val_con('gnr_x_offers_patient','offer'," patient='$pat'"));
    $q2='';
    if($vp_offer){$q2=" OR side='$vp_offer' ";}
	$sql="select * from gnr_m_offers where act =1 and type IN(3,4) and date_s < $now and date_e > $now 
    and (side=0 $q2) and FIND_IN_SET('$mood',`clinics`)> 0  order by type ASC , date_s ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows){		
		while($r=mysql_f($res)){
			$o_id=$r['id'];
			$name=$r['name'];
			$type=$r['type'];
			$sett=$r['sett'];
			$settArr=explode(',',$sett);
			$perc=$settArr[$mood-1];
			if($type==3){
				$out.='<div class="f1 fs14 clr66 b_bord lh40 w100 pd10">- '.$name.'<ff> ('.$perc.'%)</ff></div>';
				$bupOffer=[3,$perc];
			}else{
				$actOffer=getTotalCO('gnr_x_offers_patient'," offer='$o_id' and patient='$pat' ");
				if(!$vp_offer || $vp_offer==$o_id){
					if($vp_offer==$o_id){
						$out.='<div class="f1 fs14 clr5 lh40 w100 pd10">- '.$name.'</div>';
						$bupOffer=[4,$perc];
					}else{
                        $out.='<div class="ic30 ic30_link icc22 ic30Txt mg10v" oNo="'.$o_id.'">'.$name.'</div>';
					}
				}
			}
		}
	}
    $sql="select * from gnr_m_offers where act =1 and date_s < $now and date_e > $now 
    and side>0  and FIND_IN_SET('$mood',`clinics`)> 0  order by type ASC , date_s ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){		
		while($r=mysql_f($res)){
			$o_id=$r['id'];
			$name=$r['name'];
            $side=$r['side'];
            $name=get_val('gnr_m_offers','name',$side);
			if($vp_offer==$side){
                $out.='<div class="f1 fs14 clr5 lh40 w100 pd10">- '.$name.'</div>';                
            }else{
                $out.='<div class="ic30 ic30_link icc22 ic30Txt mg10v" oNo="'.$side.'">'.$name.'</div>';
            }
		}
	}
	return $out;
}
function visStaPayFot($vis,$mood,$total,$pay_type,$editable){
    $out='<div class="fl w100 lh50 cbg4 t_bord">';
    $xTotal='';
    if($editable){
        if($total>=0){
            $netPayment=$total;
            $payText="يجب على الزبون دفع";
            $butCol='cbg6';
            $butCol2='cbg66';

            if($netPayment<0){
                $netPayment=$netPayment*(-1);
                $payText="يجب إرجاع للزبون";
                $butCol='cbg5';
                $butCol2='cbg55';
                if($mood==2){
                    $xTotal='x="1"';
                }
            }
            if($netPayment==0){					
                $payText="تسوية";
                $butCol='cbg8';
                $butCol2='cbg88';
            }
            $payBox=number_format($netPayment);
            if($mood==6){
                $payText="حجز الخدمات";
                $butCol='cbg5';
                $butCol2='cbg5';
                $payBox='';
            }
            if($mood!=4){
                if($mood==2){
                    $payBox='
                <input type="number" id="l_pay" '.$xTotal.' max="'.$netPayment.'" value="'.$netPayment.'" style="width:100px;"/>';
                }
                $out.='<div class="lh50 '.$butCol2.' fr">
                <div class="fr clrw f1 fs14 pd10 ">'.$payText.'</div>				
                <div class="fr clrw f1 fs14 pd10 "><ff class="fs20">'.$payBox.'</ff></div>';
                if(_set_chwdxj3h2l && $netPayment >0 && !in_array($mood,array(4,6)) ){
                    $out.='<div class="fl payMTN icc22" visPayMtn par="'.$vis.'" mood="'.$mood.'" pay="'.$netPayment.'" title="دفع MTN"></div>';
                }
				if(_set_l1acfcztzu && $netPayment >0 && !in_array($mood,array(4,6)) ){
                    $out.='<div class="fl payCard icc22" visPayCard="1" par="'.$vis.'" mood="'.$mood.'" title="دفع الكتروني"></div>';
                }
				
                $out.='<div class="fl payBut icc22" visPayBut vis="'.$vis.'" mood="'.$mood.'" title="تنفيذ الدفعة نقدا"></div>
                </div>';
            }
        }
        $out.='<div class="fl ic50_del icc2 wh50" visDel  title="'.k_delete.'" ></div>'; 
        if($pay_type==0){
            $den='';
            if($mood==4){$den='Den';}
            $out.='<div class="fl ic50_edit icc1 wh50" visEdit'.$den.'  title="'.k_edit.'"></div>';
        }
        
    }else{
        $out.='<div class="f1 fs14 clr5 TC">لا يمكن تحرير الزيارة</div>';
    }
    if($total==0 && $mood!=2){$out.=Script("$('[payt],[cubon]').hide()");}
    $out.='</div>';
    return $out;
}
function visTicketFot($vis,$mood,$status,$total,$visChanges,$deleteAble=1,$pay_type=0){ 
    if($status!=3){
        $x=0;
        $out='<div class="fl w100 lh50 cbg4 t_bord">';
        
        $netPayment=$total;
        $payText="يجب على الزبون دفع";
        $butCol='cbg6';
        $butCol2='cbg66';

        if($netPayment<0){
            if($mood==2){$x=1;}
            $netPayment=$netPayment*(-1);
            $payText="يجب إرجاع للزبون";
            $butCol='cbg5';
            $butCol2='cbg55';
        }
        if($netPayment==0){					
            $payText="تسوية";
            $butCol='cbg8';
            $butCol2='cbg88';
        }
        $payBox=number_format($netPayment);            
        
        if($mood==4){
            $out.='<div class="lh50 ic40 ic40Txt icc1 fr ic40_price pd5v" stt="'.$visChanges.'">كشف حساب</div>';
        }else{
            if($visChanges){
                if($mood==2){
                    $payBox='
                    <input type="number" id="l_pay" max="'.$netPayment.'" x="'.$x.'" value="'.$netPayment.'" style="width:100px;"/>';
                }
                $out.='<div class="lh50 '.$butCol2.' fr">
                <div class="fr clrw f1 fs14 pd10 "><ff class="fs20">'.$payBox.'</ff></div>
                <div class="fr clrw f1 fs14 pd10 " >'.$payText.'</div>';
                
                if(_set_l1acfcztzu && $netPayment >0 && !in_array($mood,array(4,6)) ){
                    $out.='<div class="fl payCard icc22" visPayCard="3" par="'.$vis.'" mood="'.$mood.'" title="دفع الكتروني"></div>';
                }
                $out.='<div class="fl payBut icc22" visPayFixBut vis="'.$vis.'" mood="'.$mood.'" title="تنفيذ الدفعة نقدا"></div>
                </div>';
            } 
        }
        
        $r_status=get_val_con('gnr_x_roles','status'," `vis`='$vis' and mood='$mood'");
        if($status<2 && $deleteAble==1){
            $out.='<div class="fl ic50_del icc22 wh50" cancelDel="'.$vis.'" mood="'.$mood.'" title="'.k_cancel_visit.'" ></div>';                        
        }
        if($mood==2 && ($status==1 || $status ==4) && $pay_type==0){
            $out.='<div class="fl ic50_edit icc1 wh50" labVisEdit="'.$vis.'" title="تحرير"></div>';
        }
        if($status && $status!=3){
            $out.='<div class="fl ic50_print icc1 wh50" visPrint="'.$vis.'" mood="'.$mood.'" title="طباعة الوصل"></div>';
        }
        if($status==1){
            if($r_status!=''){
                if($r_status==3){
                    $out.='<div class="fl ic50_tik icc33 wh50" visTik2="'.$vis.'" mood="'.$mood.'" title="تفعيل الدور"></div>';    
                }
            }else{        
                $out.='<div class="fl ic50_tik icc33 wh50" visTik="'.$vis.'" mood="'.$mood.'" title="دور جديد"></div>';
            }
        }
        $out.='</div>';
        return $out;
    }
}
function visTicketFotCancel($vis,$mood,$netPayment){
    $payText="يجب إرجاع للزبون";
    $butCol='cbg5';
    $butCol2='cbg55';
	$out='';
    if($netPayment<0){
        $netPayment=$netPayment*(-1);
        $payText="يجب على الزبون دفع";
        $butCol='cbg6';
        $butCol2='cbg66';
    }
    if($netPayment==0){					
        $payText="تسوية";
        $butCol='cbg8';
        $butCol2='cbg88';
    }
    $payBox=number_format($netPayment);
    $out.='<div class="fl w100 lh50 cbg4 t_bord">';
    if($mood==6){
        $out.='<div class="fl ic50_del icc22" visPayCancle vis="'.$vis.'" mood="'.$mood.'" title=" الغاء الزيارة"></div>';
    }else{
        $out.='
        <div class="lh50 '.$butCol2.' fr">
            <div class="fr clrw f1 fs14 pd10 "><ff class="fs20">'.$payBox.'</ff></div>
            <div class="fr clrw f1 fs14 pd10 " >'.$payText.'</div>
            <div class="fl payBut icc22" visPayCancle vis="'.$vis.'" mood="'.$mood.'" title=" الغاء الزيارة"></div>
        </div>';
    }
    $out.='</div>';
    return $out;
}
function visStaPayAlertFot($alert_id,$vis,$mood,$total,$alert_status=0){
    $out='<div class="fl w100 lh50 cbg4 t_bord">';
    if($total>=0){
        $netPayment=$total;
        $payText="يجب على الزبون دفع";
        $butCol='cbg6';
        $butCol2='cbg66';

        if($netPayment<0){
            $netPayment=$netPayment*(-1);
            $payText="يجب إرجاع للزبون";
            $butCol='cbg5';
            $butCol2='cbg55';
        }
        if($netPayment==0){					
            $payText="تسوية";
            $butCol='cbg8';
            $butCol2='cbg88';
        }
        $payBox=number_format($netPayment);
        
        if($mood==4){
            $payBox='<input type="number" id="den_pay" value="'.$netPayment.'" style="width:100px;"/>';
        }
        $out.='<div class="lh50 '.$butCol2.' fr">
        
        <div class="fr clrw f1 fs14 pd10 "><ff class="fs20">'.$payBox.'</ff></div>
        <div class="fr clrw f1 fs14 pd10 ">'.$payText.'</div>';
        if($alert_status==1){
            if(_set_l1acfcztzu && $netPayment>0){
                $out.='<div class="fl payCard icc22" visPayCard="2" par="'.$alert_id.'" mood="'.$mood.'" title="دفع الكتروني"></div>';
            }
        
            $out.='<div class="fl payBut icc22" viAlrtBut amount="'.$netPayment.'" vis="'.$vis.'" mood="'.$mood.'" title="تنفيذ التنبيه"></div>
            </div>';
        }
        
    }    
    $out.='</div>';
    if($alert_status==0){$out.='<div class="fl clr5  pd10 f1">لا يمكن تنفيذ التنبيه حتى تغلق الزيارة</div>';}
    return $out;
}
function ex_cubon($mood){
	global $now;
	$out=0;
	if(_set_9iaut3jze){
		$sql="select * from gnr_m_offers where act =1 and date_s < $now and date_e > $now and FIND_IN_SET('$mood',`clinics`)> 0 and type=5 ";
		$res=mysql_q($sql);
		$out=mysql_n($res);		
	}
	return $out;
}
function getSrvView($offer,$mood,$vis,$srv){
	$out='';
	if($offer){
		$ro=getRecCon('gnr_x_offers_oprations',"mood='$mood' and visit='$vis' and visit_srv='$srv'");
		if($ro['r']){
			$offerNa=get_val_arr('gnr_m_offers','name',$ro['offer'],'off');
			$out='<div class="f1 fs12 lh20 clr66 offerItVi" title="'.k_offer_cancel.'" foNo="'.$ro['id'].'">'.k_offer.' : '.$offerNa.'</div>';
		}
	}
	return $out;
}
/**********************/
function servPayAler($srv,$mood,$s=0){
	global $now,$srvXTables,$lg;
	if($mood==22){
		mysql_q("INSERT INTO gnr_x_visits_services_alert(mood,amount,status,date,clinic)values(22,'$srv',2,'$now',0)");
	}else{
        $r=getRec($srvXTables[$mood],$srv);
		if($r['r']){
			$doc=$r['doc'];
			$clinic=$r['clinic'];
			$service=$r['service'];
			$pay_net=$r['pay_net'];
			$patient=$r['patient'];
			$visit_id=$r['visit_id'];
            if(getTotalCo('gnr_x_visits_services_alert',"mood='$mood' and visit_id='$visit_id' and status='$s' ")==0){
                $pat_name=get_p_name($patient);
                $cln_name=get_val('gnr_m_clinics','name_'.$lg,$clinic);
                $sql="INSERT INTO gnr_x_visits_services_alert 
                (mood,visit_id,clinic,doc,patient,date,pat_name,clinic_name)values
                ('$mood','$visit_id','$clinic','$doc','$patient','$now','$pat_name','$cln_name')";
                mysql_q($sql);
            }
        }
		/*$r=getRec($srvXTables[$mood],$srv);
		if($r['r']){
			$doc=$r['doc'];
			$clinic=$r['clinic'];
			$service=$r['service'];
			$pay_net=$r['pay_net'];
			$patient=$r['patient'];
			$visit_id=$r['visit_id'];
            $pat_name=get_p_name($patient);
			mysql_q("INSERT INTO gnr_x_visits_services_alert 
			(mood,visit_id,clinic,doc,service,patient,date,pat_name)values
			('$mood','$visit_id','$clinic','$doc','$service','$patient','$now','$pat_name')");	
		}*/
	}
}
function makeSerPayAlert($vis,$mood,$amount=0){
	global $visXTables,$srvXTables,$now,$lg;
    if($mood==4 || $mood==6){
        list($p,$c,$d)=get_val($visXTables[$mood],'patient,clinic,doctor',$vis);
        $pat_name=get_p_name($p);
        $cln_name=get_val('gnr_m_clinics','name_'.$lg,$c);
        mysql_q("INSERT INTO gnr_x_visits_services_alert (visit_id,clinic,doc,patient,date,status,mood,pat_name,clinic_name,amount) values ('$vis','$c','$d','$p','$now',1,'$mood','$pat_name','$cln_name','$amount') ");
    }else{
        $id=get_val_con('gnr_x_visits_services_alert','id',"visit_id='$vis' and mood='$mood' and status=0  ");
        if($id){
            mysql_q("UPDATE gnr_x_visits_services_alert SET status=1 , date='$now' where id='$id' ");
        }else{
            if(getTotalCO($srvXTables[$mood],"visit_id='$vis' and (status IN(2,3,4,5))")){//|| pay_type=3
                list($p,$c,$d)=get_val($visXTables[$mood],'patient,clinic,doctor',$vis);                
                $pat_name=get_p_name($p);
                $cln_name=get_val('gnr_m_clinics','name_'.$lg,$c);
                mysql_q("INSERT INTO gnr_x_visits_services_alert (visit_id,clinic,doc,patient,date,status,mood,pat_name,clinic_name) values ('$vis','$c','$d','$p','$now',1,'$mood','$pat_name','$cln_name') ");
            }
        }        
    }
}
function payAlertBe($vis,$mood){
	global $srvXTables,$visXTables,$lg,$now;
	if(_set_ruqswqrrpl==0){
		$alert=0;
		if(getTotalCO($srvXTables[$mood]," visit_id='$vis' and status IN(2,4) ")){
			$alert=1;
		}
		$alertRec=getTotalCO('gnr_x_visits_services_alert',"visit_id='$vis' and mood='$mood' and status=5 ");		
		if($alert && $alertRec==0){
			$r=getRec($visXTables[$mood],$vis);
			if($r['r']){
				$doc=$r['doctor'];
				$clinic=$r['clinic'];				
				$patient=$r['patient'];	
                $pat_name=get_p_name($patient);
                $cln_name=get_val('gnr_m_clinics','name_'.$lg,$clinic);
				$sql="INSERT INTO gnr_x_visits_services_alert 
				(mood,visit_id,clinic,doc,patient,date,status,pat_name,clinic_name)values
				('$mood','$vis','$clinic','$doc','$patient','$now',5,'$pat_name','$cln_name')";
                mysql_q($sql);               
			}
		}
		if($alert==0 && $alertRec){
			mysql_q(" DELETE FROM gnr_x_visits_services_alert where visit_id='$vis' and mood='$mood' and status=5");
		}
	}
}
/********************************/
function addTempOpr($patient,$type,$mood,$clinic,$vis){
	global $now,$thisUser;
    if(getTotalCo('gnr_x_temp_oprs',"mood='$mood' and type='$type' and patient='$patient' and clinic='$clinic' and vis='$vis' and status!=0")==0){
        if($type==61 || $type==62){
            if($type==61){
                $pat_name=get_p_name($patient);
            }else{
                list($f_name,$l_name)=get_val('dts_x_patients','f_name,l_name',$patient);
                $pat_name=$f_name.' '.$l_name;
            }
        }else{
            $pat_name=get_p_name($patient);		
        }
        $sql="INSERT INTO gnr_x_temp_oprs (`patient`,`type`,`mood`,`clinic`,`vis`,`pat_name`,`date`,`user`) values ('$patient','$type','$mood','$clinic','$vis','$pat_name','$now','$thisUser' )";
        mysql_q($sql);
    }
}
function delTempOpr($mood,$vis,$type=''){
	$q=" and type not IN(4,9) ";
	if($type!=''){
        if($type=='a'){
            $q='';
        }else{
            $q=" and type IN($type) ";
        }
    }
    $q2=" and mood='$mood' ";
    if($type==9){$q2="";}
    //echo "delete from gnr_x_temp_oprs where vis='$vis' $q2 $q";
	mysql_q("delete from gnr_x_temp_oprs where vis='$vis' $q2 $q");
}
function editTempOpr($mood,$vis,$type,$status,$subStatus=0){
	$q='';
	if($subStatus){" , sub_status='$subStatus' ";}
	mysql_q("UPDATE gnr_x_temp_oprs SET status='$status' $q where vis='$vis' and  mood='$mood' and  type='$type' " );	
}
/**************clinics Opr****************/
function clinicOpr_icons($mood){
	global $lg,$thisUser,$now,$stopAlert,$userSubType,$clinicCode,$ss_day,$ee_day;
	if($mood==1){
		$clinic=intval($userSubType);
		$out='';
		$r=getRecCon('gnr_x_roles',"doctor='$thisUser' and no=0 ");
		if($r['r']){
			$date=$r['date'];
			$out.=topIconCus(k_wrk,'ti_play fr','stopRowDo()');
			$out.='<input type="hidden" id="stopVal" value="0"/>';
			if(($date-$now)>0){
				$stopAlert='<div class="visRows2 fs16 f1 cb TC" >'.k_trn_spd_rsm.' <ff>'.dateToTimeS2($date-$now).'</ff></div>';
			}else{
				$stopAlert='<div class="visRows22 fs16 f1 cb TC" >'.k_rsm_wrk.' <ff>'.dateToTimeS2($now-$date).'</ff></div>';
			}
		}else{
			$out.=topIconCus(k_pse,'ti_stop fr','stopRow()');				
		}
	
		if(getTotalCO('gnr_x_arc_stop_clinic'," clic='$clinic' and e_date=0 ")==0){			
			$out.=topIconCus(k_stp_rsvtn,'ti_stop2 fr','stopClinic(1)');
		}else{			
			$out.=topIconCus(k_run_rsrvtn,'ti_play fr','stopClinic(2)');
		}
	}
	if($mood==3){		
		$t=getTotalCO('xry_x_pro_radiography_report',"doc='$thisUser' and date>=$ss_day and date < $ee_day ");
		$tt='';
		if($t){$tt='<div>'.$t.'</div>';}
		$out.=topIconCus(k_day_reps,'ti_card fr','xryRepToday()','',$tt);		
	}
	$action=$clinicCode[$mood].'_vit_d_ref(1)';
	$out.=topIconCus(k_refresh,'ti_ref fr',$action);	
	return $out;
}
function clinicOpr_docStatus($mood){
	global $lg,$thisUser,$now,$docTimeStatus,$docTimeStatusClr,$limitPatData,$visXTables;
	$out='';
	$dayNo=date('w');
	list($t_days,$t_type,$t_data)=get_val('gnr_m_users_times','days,type,data',$thisUser);
	if(in_array($dayNo,explode(',',$t_days))){	
		$d_time=get_doc_Time($t_type,$t_data,$t_days);
		$st=$d_time[0];
		$et=$d_time[1];
		$shortNow=$now%86400;
		if($d_time[3]){$et=$d_time[3];}
		$sta=0;	
		if($shortNow<$et){$sta=2;$sta_time=$et-$shortNow;}
		if($shortNow<$st){$sta=1;$sta_time=$st-$shortNow;}
		if($shortNow>$et){$sta=3;$sta_time=$shortNow-$et;}
		$out.='<span class="fs12 f1  cb lh30 " style="color:'.$docTimeStatusClr[$sta].'">'.$docTimeStatus[$sta].'<span class="ff fs14 B"> ( '.dateToTimeS2($sta_time).' )</span></span>';
	}else{
		$out='<span class="fs14 f1 cb lh30 clr5" >'.k_tday_dnt_word.'</span>';
	}	
	$stopPrv=0;
	$p_limit=get_val('_users','p_limit',$thisUser);
	if($p_limit>0){
		$v_date=$now-($now%86400);
		$nn=getTotalCO($visXTables[$mood]," doctor='$thisUser' and d_start > '$v_date' ");
		$nnX=$p_limit-$nn;
		if($nnX<1){$stopPrv=1;}
		$limitPatData= '<div class="f1 fs16 lh40 clr1111">'.k_num_pats.' <ff>'.$nn.'</ff> '.k_from.' <ff>'.$p_limit.'</ff></div>
		<div class="uLine cb lh1">&nbsp;</div>';
	}
	return $out;
}
function clinicOpr_waiting($mood,$thisVis=0){
	global $lg,$thisUser,$ss_day,$ee_day,$userSubType,$thisGrp,$now,$denVisType,$rola_opr_txt,$f_path;
	$out='';
	$visAct=0;
	if(chProUsed('dts')){
		$visAct=getTotalCO('dts_x_dates'," doctor='$thisUser' and d_start >= $ss_day and d_start < $ee_day and status IN (3) ");
	}
	if($mood!=3){
		$m_pat=get_val('gnr_m_clinics','m_patients',$userSubType);
	}
	$sql="select * from gnr_x_roles where no!=0 and status < 4 and clic IN ($userSubType) and ( doctor='$thisUser' or doctor=0) and fast!=2 order by fast DESC , no ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$rr=array();
		while($r=mysql_f($res)){
			$rec_data='';
			$r_id=$r['id'];
			$vis=$r['vis'];
			$clic=$r['clic'];
			$pat=$r['pat'];
			$date=$r['date'];
			$fast=$r['fast'];
			$status=$r['status'];		
			$sClass='stu0';
            $sCs='s0';
			$no=$r['no'];
			$pat_name=$r['pat_name'];
			$services=$r['services'];
            
			$action='';
			$over='';
			if($mood==3){
				$m_pat=get_val('gnr_m_clinics','m_patients',$clic);
			}
			
			if($rr[$clic]!=2 && $status<3 && $fast !=2){
				if($status==0){
					$rr[$clic]=2;
					//if(!$stopPrv){
						if($m_pat || $visAct==0){
							$sClass='stu1';
                            $sCs='s1';
                            $action="d_vis_Play(".$r_id.",".$status.",".$mood.","._set_7h5mip7t6n.")";
							$over='visRowsO Over';
						}
					//}
				}
				if($status==1){
					$rr[$clic]=2;
					$sClass='stu2';
                    $sCs='s5';
					$action="d_vis_Play(".$r_id.",".$status.",".$mood.","._set_7h5mip7t6n.")";
					$over='visRowsO Over';
				}			
			}
			if($status==2){
				$visAct++;
				$sClass='stu3';	
                $sCs='s2';
                if(in_array($thisGrp,array('7htoys03le','1ceddvqi3g','nlh8spit9q','66hd2fomwt','9yjlzayzp','9k0a1zy2ww'))){
				$action="addVisToDoc(".$vis.")";}
				if($mood==4){
                    if(_set_7h5mip7t6n==1){
                        $action="loc('".$f_path."_Preview-Den-New.".$vis."')";
                    }else{
                        $action="loc('".$f_path."_Preview-Den.".$vis."')";
                    }
                }
				$over='visRowsO Over';
			}
			$fCode='icc1';if($fast>0){$fCode='icc2';}	
            if($sClass!='s0'){$staTxt=' (  '.$rola_opr_txt[$status].' ) ';}
		    if($fast>0){$sCs='s4';$staTxt=' ( '.k_emergency.' ) ';}
			if($status==3){
				$over='visRowsO Over';
                $rec_data.='
				<div class="visWBlc w100 pd10" s3>
					<div class="f1s fs16x lh30 pd10v clr3 uLine ">
					<ff>'.$no.' - </ff>'.$pat_name.' <span class="f1">( '.$rola_opr_txt[$status].' )</span></div>
					<div class="f1 lh30">'.$services.'</div>					
				</div>';
			}else{
				$servicesTxt=$services;
				if($mood==4){                    
					$servicesTxt='<div class="fr i30 i30_info" title="'.k_details.'" onclick="denHis('.$pat.','.$vis.')"></div>'.$denVisType[$services];
				}
				if($thisVis!=$vis){
					$rec_data.= '
                    <div class="visWBlc w100 pd10 " '.$sCs.'>
                        <div class="f1s fs16x lh30 pd10v clr3 uLine ">
                            <div class="fr ic40x '.$sClass.' fl br5" onclick="'.$action.'"></div>
                            <ff>'.$no.' - </ff>'.$pat_name.' <span class="f1 fs14"> '.$staTxt.' </span>
                        </div>
                        <div class="f1 lh30">'.$servicesTxt.'</div>                        
                    </div>';
				}
			}
			$out.=$rec_data;
		}
	}
	return $out;
}
function clinicOpr_DTS($mood,$thisVis=''){
	global $lg,$thisUser,$ss_day,$ee_day,$srvTables,$now,$userSubType,$denVisType,$f_path;    
	$out='';
	$sql="select * from dts_x_dates_temp where (doctor='$thisUser' OR doctor=0) and type='$mood' and clinic in($userSubType) and d_start >= $ss_day and d_start < $ee_day and status IN (1,2,3) order by d_start ASC , reserve ASC ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
    $lastDate=0;	
	$visAct=0;
	if($rows>0){
		while($r=mysql_f($res)){
			$sClass='stu0';	
			$dts_id=$r['id'];
			$patient=$r['patient'];
			$p_type=$r['p_type'];
			$d_start=$r['d_start'];
            $d_end=$r['d_end'];
            $dTime=($d_end-$d_start)/60;
			$d_start_r=$r['d_start_r'];
			$status=$r['status'];
			$vis_link=$r['vis_link'];
            $dts_note=$r['note'];
            $reserve=$r['reserve'];
            $pat_name=$r['pat_name'];
            $servicesTxt=$r['services'];
            if($mood==4){                
				$servicesTxt='<div class="fr i30  i30_info"  title="'.k_details.'" onclick="denHis('.$patient.','.$vis_link.')"></div>'.$denVisType[$servicesTxt];
			} 
			$action=$over=$status_txt=''; 
            $r_id=0;
			if($vis_link){
                $r_id=get_val_con('gnr_x_roles','id'," vis='$vis_link' and mood='$mood' ");
            }
			$flasher='';
            $sCs='s0';
			if($status==1){
                $sCs='s0';
				if($d_start>$now){				
					$status_txtD=k_left_start_appoint;
					$status_date=dateToTimeS2($d_start-$now);
					$status_color='cbg111';
				}else{						
					$status_txtD=k_delayed_of;
					$status_date=dateToTimeS2($now-$d_start);
					$status_color='cbg55';
				}
			}	
			if($status==2 || $status==3){		
				if(!$vis_link){$status=1;}
			}
			
			if($status==2){
                $sCs='s1';
				if($d_start>$now){
					$status_txtD=k_left_start_appoint;
					$status_date=dateToTimeS2($d_start-$now);
					$status_color='cbg6';										
				}else{
					$status_txtD=k_delayed_clinic_enter;
					$status_date=dateToTimeS2($now-$d_start);
					$status_color='cbg5';
					$flasher='flasher2';
                    $sCs='s4';
					if( $d_start < $now-(60*_set_d9c90np40z ) ){
						$flasher='flasher';						
					}
				}
				if($m_pat || $visAct<=1){
					$action="d_vis_Play(".$r_id.",0,".$mood.","._set_7h5mip7t6n.")";
					$over="Over";
					$sClass='stu1';	$visAct++;
				}else{
					$over="";
				}
			}
			if($status==3){
				$visAct++;
				$sClass='stu3';
                $sCs='s2';
				$status_txt= ' ( '.k_srvc_doing.' )';
				$status_date=dateToTimeS2($now-$d_start_r);
				$status_color='cbg1111';
				if($mood==4){
                    //$action="loc('".$f_path."_Preview-Den.".$vis_link."')";
                    if(_set_7h5mip7t6n==1){
                       $action="loc('".$f_path."_Preview-Den-New.".$vis_link."')";
                    }else{
                       $action="loc('".$f_path."_Preview-Den.".$vis_link."')";
                    }
                }else{
                    $action='addVisToDoc('.$vis_link.')';
                }				
				$over="Over";
	           
		    }
			if($lastDate!=$d_start && $d_start>$now){
                if($lastDate==0){$lastDate=$now;}
                $defTime=intval(($d_start-$lastDate)/60);
                $out.= '<div class="bord pd10f cbg777 br5 w100 pd10 TC uLine" >
                <div class="f1 lh20 clr55 fs12">الوقت الفارغ : '. $defTime.' '.k_thminute.'</div>
                <div class="ff">'.date('A h:i',$lastDate).' - '.date('A h:i',$d_start).'</div>
                
                </div>';
            }
            $lastDate=$d_end;
			if($thisVis!=$vis_link){
                $reserveTxt='';
                if($reserve){
                    $reserveTxt='<ss class="f1 cbg5 clrw lh20 pd10 pd5v br5 fs12">احتياطي</ss>';
                }
                $out.= '
                    <div class="visWBlc w100 pd10 " '.$sCs.'>
                        <div class="f1s fs16x lh40 pd10v clr3 uLine ">
                            <div class="fr ic40x '.$sClass.' fl br5 '.$flasher.'" onclick="'.$action.'"></div>
                            <ff>'.clockStr($d_start-$ss_day).' - </ff>'.$pat_name.'
                            <div class="f1 lh20 clr5">'.$dTime.' '.k_thminute.'</div>
                            '.$reserveTxt.'<span class="f1 fs14"> '.$status_txt.' </span>
                        </div>
                        <div class="f1 lh30">'.$servicesTxt.' </div>';
                        if($dts_note){
                            $out.='<div class="lh30 f1  clr5" >'.k_note.': '.$dts_note.'</div>';
                        }
                        if($status_txtD){
                            $out.='<div class="lh30 f1 t_bord clr1 TC" >'.$status_txtD.'- <ff14>'.$status_date.'</ff14></div>';
                        }
                $out.='</div>';
			}
            
		}
	}
	return $out;
}
function clinicOpr_alerts($mood){
	global $lg,$now,$userSubType,$visXTables,$thisUser,$f_path;	
	$out='';
	$sql="select * from gnr_x_temp_oprs where status =1 and clinic in($userSubType) and mood='$mood' and 
	(doc='$thisUser' OR doc=0) and type>3 and 
	vis NOT IN(select vis from gnr_x_roles where vis=gnr_x_temp_oprs.vis and mood='$mood') ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$out.='<div class="f1 lh40 clr5 fs16">'.k_unfshd_vis.'</div><div class="uLine"> </div>';
		while($r=mysql_f($res)){
			$o_id=$r['id'];
			$vis=$r['vis'];
			$clic=$r['clinic'];
			$pat=$r['patient'];
			$date=$r['date'];
			$doc=$r['doc'];			
			if($mood==4){                
                if(_set_7h5mip7t6n==1){
                    $action="loc('".$f_path."_Preview-Den-New.".$vis."')";
                }else{
                    $action="loc('".$f_path."_Preview-Den.".$vis."')";
                }

            }else{
                $action='addVisToDoc('.$vis.')';
            }		
			$pat_name=$r['pat_name'];		
			$show=1;
			if($doc==0 && $mood!=2){
				$docCol='doctor';
				if($mood==3){$docCol='ray_tec';}
				$doctor=get_val($visXTables[$mood],$docCol,$vis);
				mysql_q("UPDATE gnr_x_temp_oprs SET doc='$doctor' where id='$o_id'");
				if($doctor!=$doc){$show=0;}
			}
			if($show){
                $out.= '
                    <div class="visWBlc w100 pd10 " Over s4 onclick="'.$action.'">
                        <div class="fr lh40"><ff14>'.dateToTimeS2($now-$date).'</ff14></div>
                        <div class="f1s fs16x lh30 pd10v clr3 ">
                            <ff>'.$vis.' - </ff>'.$pat_name.'
                        </div>
                    </div>';
			}
		}
		$out.='</div>';
	}
	return $out;
}
function getMdcList($id,$style=0){
	global $lg,$clr1;
    $out='';
    $complaint=get_val('gnr_x_prescription','complaint_txt',$id);
    if($complaint){
        $out.='<div class="f1 fs14 pd10v" style="border-top: 1px #999 solid;">التشخيص: '.$complaint.'</div>';
    }		
	$sql="select * from gnr_x_prescription_itemes where presc_id='$id' order by id";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		$i=1;
		while($r=mysql_f($res)){
			$addWay=k_dosage;
			$mad_id=$r['mad_id'];
			$dose=$r['dose'];
			$dose_s=$r['dose_s'];
			$num=$r['num'];
			$duration=$r['duration'];            
            $note=$r['note'];
            $presc_quantity=$r['presc_quantity'];
			$name=$dose_t=$num_t=$duration_t='';
			$name=get_val_arr('gnr_m_medicines','name',$mad_id,'m');
			$perDe=array();
			$mdesDet='';
			if($dose){array_push($perDe,get_val_arr('gnr_m_medicines_doses','name_'.$lg,$dose,'m1'));}
			if($num){array_push($perDe,get_val_arr('gnr_m_medicines_times','name_'.$lg,$num,'m2'));}
			if($dose_s){array_push($perDe,get_val_arr('gnr_m_medicines_doses_status','name_'.$lg,$dose_s,'m4'));}
			if($duration){array_push($perDe,get_val_arr('gnr_m_medicines_duration','name_'.$lg,$duration,'m3'));}
						
			$mdesDet=implode(' - ',$perDe);
			if($mdesDet){
                $mdesDet='<div dir="ltr"><div class="fl f2" dir="rtl">[ عدد '.$presc_quantity.' ]</div><bdi class="clr2 f2">'.$mdesDet.' </bdi></div>';
            }
			if($style==0){
				$out.='<div class="sel_mdc" mdc="'.$id.'">				
					<div class="blc_win_title_icons fr hide"  id="bwtto">
						<div class="fr delToList" onclick="delMdc('.$id.')" title="'.k_delete.'"></div> 
						<div class="fr editToList" onclick="editMdc('.$id.')" title="'.k_edit.'"></div>
					</div>
					<div class="fs18">'.$name.'</div>
					<div  dir="rtl"><bdi class="f1 fs18 clr1">'.$mdesDet.'</bdi></div>
				</div>';
			}else{
                if($note){$note='<div class="fs12 f2 clr2">'.$note.'</div>';}
				$out.='
				<div class="sel_mdc_p " dir="ltr">
					<span class="f1 " style="font-size:18px;">'.$i.'-'.$name.'</span>
					'.$mdesDet.$note.'
                </div>';                
                
			}
			$i++;
			unset($perDe);
            
		}
        $prsNote=get_val('gnr_x_prescription','note',$id);
        if($prsNote){
            if($prsNote){$out.='<div class="pd10v lh20 fs12 f2">'.k_note.': '.$prsNote.'</div>';}
        }
	}
	return $out;
}
function getWayItems($type,$val=0,$t=0){
	$out='';
	global $lg;
	if($type==1){$table='gnr_m_medicines_doses';}
	if($type==2){$table='gnr_m_medicines_times';}
	if($type==3){$table='gnr_m_medicines_duration';}
	if($type==4){$table='gnr_m_medicines_doses_status';}
	if($t!=0 && $type==1){
		$Q=" and type='$t'";
	}
	$sql="select * from $table where act=1 $Q order by id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			$tName='';
			if($type==1){
				$t=$r['type'];
				$tName=get_val('gnr_m_medicines_doses_type','name_'.$lg,$t).' - ';
			}
			$act='';
			if($id==$val){$act='act';}
			$out.='<div '.$act.' t="'.$type.'" mw_id="'.$id.'">'.splitNo($tName.$name).'</div>';
		}		
	}
	return $out; 
}
function getMdc($v_id){
	$str='';
	$sql=" select * from cln_x_medicines where visit='$v_id' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$f=0;
		while($r=mysql_f($res)){
			$mad_id=$r['mad_id'];
			$dose=$r['dose'];
			$num=$r['num'];
			$duration=$r['duration'];			
			if($f!=0){$str.='|';}
			$str.=$mad_id.':'.$dose.':'.$num.':'.$duration;
			$f=1;
		}
	}
	return $str;
}
function visDelLog($mood,$vis,$type=1){
	global $thisUser,$now,$visXTables,$srvXTables,$srvTables,$lg;
	$table=$visXTables[$mood];
	$r=getRec($table,$vis);
	if($r['r']){
		$doctor=$r['doctor'];
		$patient=$r['patient'];
		$clinic=$r['clinic'];
		$d_start=$r['d_start'];
		$reg_user=$r['reg_user'];
		$price=0;
		if($mood!=6){
			$price=get_sum($srvXTables[$mood],'total_pay',"visit_id='$vis'");
		}
		$servicesTxt='';
		$services=get_vals($srvXTables[$mood],'service',"visit_id='$vis'");
		if($services){
			$servicesTxt=get_vals($srvTables[$mood],'name_'.$lg,"id in($services) ",' :: ');
		}
		$sql="INSERT INTO gnr_x_visits_delete_log (`mood`,`vis_id`,`doctor`,`patient`,`clinic`,`vis_date`,`reg_user`,`price`,`service`,`user`,`date`,`type`)values(
		'$mood','$vis','$doctor','$patient','$clinic','$d_start','$reg_user','$price','$servicesTxt','$thisUser','$now','$type') ";
		mysql_q($sql);
	}
}
function fixPatintAcc($p){
	$den_pay_in=get_sum('gnr_x_acc_patient_payments','amount',"patient='$p' and mood=4 and type in(0,1,3,4,10)");
	$den_pay_out=get_sum('gnr_x_acc_patient_payments','amount',"patient='$p' and mood=4 and type in(2)");
	$den_pay=$den_pay_in-$den_pay_out;
	$den_service=get_sum('den_x_visits_services','total_pay',"patient='$p'");
	$den_service_done=get_sum('den_x_visits_services_levels','price',"patient='$p' and status=2");
	$den_balance=$den_service_done-$den_pay;
	if(getTotalCO('gnr_m_patients_balance'," `patient`='$p' ")){
		$sql="UPDATE gnr_m_patients_balance SET `den_pay`='$den_pay', `den_service`='$den_service', `den_service_done`='$den_service_done',`den_balance`='$den_balance' where patient ='$p' ";
	}else{	
		$sql="INSERT INTO gnr_m_patients_balance 
		(`patient`,`den_pay`,`den_service`,`den_service_done`,`den_balance` ) values
		('$p','$den_pay','$den_service','$den_service_done','$den_balance') ";
	}
	mysql_q($sql);
}
function patient_payment($patient,$mood,$type,$amount,$payment_id,$doc=0,$sub_id=0){
	global $now;	
	if(mysql_q("INSERT INTO gnr_x_acc_patient_payments(`patient`,`type`,`mood`,`sub_mood`,`amount`,`payment_id`,`date`,`doc`)
	values('$patient','$type','$mood','$sub_id','$amount','$payment_id','$now','$doc')")){
        fixPatAccunt($patient);
	   return 1;
	}
}
/***************************************/
function fixCharitOpr($id,$type){
	global $visXTables,$srvXTables;
	$table=$visXTables[$type];
	$table2=$srvXTables[$type];
	$payType=get_val($table,'pay_type',$id);
	if($payType==2){
		$sql="select sum(total_pay-pay_net) as c from  $table2 where visit_id='$id' and status !=3 ";
		$res=mysql_q($sql);		
		$r=mysql_f($res);
		$c=$r['c'];
		mysql_q("update gnr_x_referral_charities set rece_amount='$c' where vis='$id' and c_type='$type'");
		mysql_q("update $table set sub_status='1' where id='$id' and sub_status='3' ");
	}
}
function addPay($id,$type,$clinic,$amount,$mood=0,$pt=1,$comm=0,$differ=0,$bank=0){
	global $now,$thisUser;
	if($mood==0){$mood=get_val('gnr_m_clinics','type',$clinic);}
	if($amount){;
        mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`,`pay_type`,`commi`,`differ`,`bank`) values ('$type','$id','$amount','$thisUser','$now','$mood','$pt','$comm','$differ','$bank')");		
	}	
	fixCasherData($thisUser);
	//fixDashData($clic,$mood);
	return 1;
}
function convertPayment($dts_id,$vis_id){
	mysql_q("UPDATE gnr_x_acc_payments SET vis='$vis_id' , type=7 where type=6 and vis='$dts_id' ");
}
function fixDtsPay($vis,$dts_id,$mood){
    $dtsPay=0;
    if($dts_id){			
        $dtsPay=DTS_PayBalans($dts_id,$vis,$mood);
        if($dtsPay){addPay($vis,9,0,$dtsPay,$mood);}
        convertPayment($dts_id,$vis);
    }
    return $dtsPay;
}
function addPayType1($mood,$dts_id,$vis,$type,$amo=0,$pt=1,$comm=0,$differ=0,$bank=0){
    global $thisUser,$now,$visXTables,$srvXTables;
    $m_table=$visXTables[$mood];
    $m_table2=$srvXTables[$mood];
    $dtsPay=0;
    if($mood==7){$doc_fees=get_val_c($m_table2,'doc_fees',$vis,'visit_id');}
    if($mood!=2){$dtsPay=fixDtsPay($vis,$dts_id,$mood);}
    if(getTotalCO('gnr_x_acc_payments'," `vis`='$vis' and `type`='$type' and mood='$mood' and pay_type=1")==0){	
        $amount=get_sum($m_table2,'pay_net'," visit_id ='$vis'");
        if($mood==7){
            $doc_fees=get_val_c($m_table2,'doc_fees',$vis,'visit_id');
            $amount+=$doc_fees;
        }
        $bankPay=get_sum('gnr_x_acc_payments','amount',"`vis`='$vis' and `type`='$type' and mood='$mood' and pay_type=2");
        $amount=$amount-$dtsPay-$bankPay;

        if($amount<0){
            $amount=$amount*(-1);
            $type=4;
        }
        if(($amo && $pt==2)|| $mood==2){$amount=$amo;}
        if($amount){				
            mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`,`pay_type`,`commi`,`differ`,`bank`)values('$type','$vis','$amount','$thisUser','$now','$mood','$pt','$comm','$differ','$bank')");
        }
        if($pt==1 || ($amo==0 && $pt==2)){
            mysql_q("UPDATE $m_table SET status=1 where id ='$vis' ");	
            if($dts_id){conformDatePay($dts_id);}
        }
        if($mood==7 && $doc_fees){ 
            if(getTotalCo('gnr_x_acc_payments',"mood='$mood' and vis='$vis' and type=4 and amount='$doc_fees'")==0){
                mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values(4,'$vis','$doc_fees','$thisUser','$now','$mood')");
            }
        }
    }
    return $type;
}
function addBankPay2($vis,$mood,$amount,$comm,$differ,$bank=0){
    global $now,$thisUser;	
    $type=2;
    if($amount>0){        
        mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`,`pay_type`,`commi`,`differ`,`bank`)values('$type','$vis','$amount','$thisUser','$now','$mood',2,'$comm','$differ','$bank')");
        return 1;
    }
    fixCasherData($thisUser);
}
function addCashPay2($vis,$mood,$amount){
    global $thisUser,$now,$visXTables,$srvXTables;
    $m_table=$visXTables[$mood];
    $m_table2=$srvXTables[$mood];
    $type=2;
    if($amount){
        if($amount<0){
            $type=4;
            $amount=$amount*(-1);
        }
        mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`) values ('$type','$vis','$amount','$thisUser','$now','$mood')");
        mysql_q("UPDATE $m_table2 SET status=1  where visit_id ='$vis' and status=5 ");
        mysql_q("UPDATE $m_table2 SET status=4  where visit_id ='$vis' and status=3 ");
    }
    mysql_q("DELETE from gnr_x_visits_services_alert where visit_id='$vis' and mood='$mood' ");
    $clic=get_val($m_table,'clinic',$vis);
    fixCasherData($thisUser);	
    fixDashData($clic,$mood);
    return 1;
}
function addPay1($id,$type,$amo=0,$pt=1,$comm=0,$differ=0,$bank=0){
	global $now,$thisUser;	
	$m_table='cln_x_visits';$m_table2='cln_x_visits_services';	
	$mood=1;
	$sql="select * from $m_table where id= '$id' limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$reg_user=$r['reg_user'];
		$pay_type=$r['pay_type'];
		$status=$r['status'];
		$dts_id=$r['dts_id'];
		//$dtsPay=fixDtsPay($id,$dts_id,$mood);
		if($reg_user!=$thisUser){mysql_q("UPDATE $m_table set reg_user='$thisUser' where id= '$id'");}
		if($type==1){
            $type=addPayType1($mood,$dts_id,$id,$type,$amo,$pt,$comm,$differ,$bank);
			/*if(getTotalCO('gnr_x_acc_payments'," `vis`='$id' and `type`='$type' and mood='$mood' and pay_type=1")==0){	
				$amount=get_sum($m_table2,'pay_net'," visit_id ='$id'");
                $bankPay=get_sum('gnr_x_acc_payments','amount',"`vis`='$id' and `type`='$type' and mood='$mood' and pay_type=2");
				$amount=$amount-$dtsPay-$bankPay;
                
				if($amount<0){
					$amount=$amount*(-1);
					$type=4;
				}
                if($amo && $pt==2){$amount=$amo;}
				if($amount){				
					mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`,`pay_type`,`commi`,`differ`)values('$type','$id','$amount','$thisUser','$now','$mood','$pt','$comm','$differ')");
				}
                if($pt==1 || ($amo==0 && $pt==2)){
                    mysql_q("UPDATE $m_table SET status=1 where id ='$id' ");	
                    if($dts_id){conformDatePay($dts_id);}
                }
			}*/
		}
		if($type==2){
			$amount=0;
			$sql="select * from $m_table2  where visit_id='$id' and status=2";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){					
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$pay_net=$r['pay_net'];					
					$amount+=$pay_net;
				}				
			}
			mysql_q("UPDATE $m_table2 SET status=0  where visit_id ='$id' and status=2 ");
			if($amount>0){								
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");                
			}
		}
		if($type==22){
			$type=2;
			$amount=0;
			$sql="select * from $m_table2  where visit_id='$id' and status=5";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$pay_net=$r['pay_net'];					
					$amount+=$pay_net;
				}				
			}
			mysql_q("UPDATE $m_table2 SET status=1  where visit_id ='$id' and status=5 ");
			if($amount>0){								
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
		}
		if($type==3){
			if(getTotalCO('gnr_x_acc_payments'," `vis`='$id' and `type`='$type' and `mood`='$mood'")==0){				
				$amount=get_sum($m_table2,'pay_net'," visit_id ='$id' and status IN(0,1,2)");
				if($amount>0 && $status==1){			
					mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
				}
				mysql_q("UPDATE $m_table SET status=3 , d_finish='$now' where id = '$id' ");
				mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' and status in(0,1,2)");
				delOfferVis($mood,$id,3);
				mysql_q("UPDATE gnr_x_roles SET status=4 where vis ='$id' and mood='$mood'");				
			}
		}
		if($type==4){			
			$amount=get_sum($m_table2,'pay_net'," visit_id ='$id' and status IN(0,4) ");
			if($amount>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
			mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' and status IN(0,4); ");
			delOfferVis($mood,$id,3);
		}
		if($type==44){
			$type=4;			
			$amount=get_sum($m_table2,'pay_net'," visit_id ='$id' and status=4 ");			
			if($amount>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
			mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' and status=4 ");
			delOfferVis($mood,$id,3);
		}
		if($type==6){
			$type=4;					
			if($amo>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amo','$thisUser','$now','$mood')");
			}			
		}
		//fixCharitOpr($id,$mood);
	}
	if($type==5){
		if(getTotalCO('gnr_m_patients'," `id`='$id' ")){			
			$amount=0;
			$pay=get_val('gnr_m_patients','pay',$id);
			if($pay==1){$amount=_set_pwnlndtt;}
			if($pay>1){$amount=_set_o3rzlow59o;}
			if($amount>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}		
		}
	}
	$clic=get_val($m_table,'clinic',$id);
	fixCasherData($thisUser);	
	fixDashData($clic,$mood);
	return 1;
}
function addPay2($id,$type,$amo=0,$pt=1,$comm=0,$differ=0,$bank=0){//$amo=0
	global $now,$thisUser;
	$mood=2;
	$user=$thisUser;
	$m_table='lab_x_visits';
    $m_table2='lab_x_visits_services';
	$sql="select * from $m_table where id= '$id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$reg_user=$r['reg_user'];
		$status=$r['status'];
		if($reg_user==0){mysql_q("UPDATE $m_table set reg_user='$thisUser' where id= '$id'");}
		if($type==1){
            addPayType1($mood,0,$id,$type,$amo,$pt,$comm,$differ,$bank);
			/*if(getTotalCO('gnr_x_acc_payments'," `vis`='$id' and `type`='$type' and mood='$mood' ")==0){
				if($amo){
					mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`) values('$type','$id','$amo','$thisUser','$now','$mood')");
				}
				mysql_q("UPDATE $m_table SET status=1 where id ='$id' ");					
			}*/
            
		}
		if($type==2){            
			if($amo){
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`) values('$type','$id','$amo','$thisUser','$now','$mood')");				
				mysql_q("UPDATE $m_table2 SET status=0 where visit_id ='$id' and status=2 ");
				mysql_q("UPDATE $m_table2 SET status=3 where visit_id ='$id' and status=4 ");
				delOfferVis($mood,$id,3);
			}
		}
		if($type==3){
			$pay1=get_sum('gnr_x_acc_payments','amount'," vis='$id' and mood=2  ");
			if($status<2){
				$payIN=get_sum('gnr_x_acc_payments','amount'," vis='$id' and mood='2' and type IN(1,2,7,11) ");
				$payOUT=get_sum('gnr_x_acc_payments','amount'," vis='$id' and mood='2' and type IN(3,4) ");
				$pay1=$payIN-$payOUT;	
				if($pay1){
					mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$pay1','$thisUser','$now','$mood')");
				}
				mysql_q("UPDATE $m_table SET status=3 , d_finish='$now' where id = '$id' ");
				mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' ");
				delOfferVis($mood,$id,3);
				mysql_q("UPDATE lab_x_visits_samlpes set status=5 where visit_id='$id'");				
				mysql_q("UPDATE gnr_x_roles SET status=4 where vis ='$id' and mood='$mood'");
			}
		}
		if($type==4){			
			if($amo>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amo','$thisUser','$now','$mood')");
			}
			mysql_q("UPDATE $m_table2 SET status=0 where visit_id ='$id' and status=2 ");
			mysql_q("UPDATE $m_table2 set status=3 where visit_id ='$id' and status =4; ");
			delOfferVis($mood,$id,3);
			
		}
		if($type==6){
			$type=4;					
			if($amo>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amo','$thisUser','$now','$mood')");
			}			
		}
		//fixCharitOpr($id,2);
	}
	$clic=get_val_c('gnr_m_clinics','id',2,'type');
	fixCasherData($thisUser);	
	fixDashData($clic,$mood);	
	return 1;
	
}
function addPay3($id,$type,$amo=0,$pt=1,$comm=0,$differ=0,$bank=0){
	global $now,$thisUser;	
	$m_table='xry_x_visits';$m_table2='xry_x_visits_services';	
	$mood=3;
	$sql="select * from $m_table where id= '$id' limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$reg_user=$r['reg_user'];
		$pay_type=$r['pay_type'];		
		$status=$r['status'];	
		$dts_id=$r['dts_id'];
		$clinic=$r['clinic'];
		//$dtsPay=fixDtsPay($id,$dts_id,$mood);
		if($reg_user!=$thisUser){mysql_q("UPDATE $m_table set reg_user='$thisUser' where id= '$id'");}
		if($type==1){
            $type=addPayType1($mood,$dts_id,$id,$type,$amo,$pt,$comm,$differ,$bank);
			/*if(getTotalCO('gnr_x_acc_payments'," `vis`='$id' and `type`='$type' and mood='$mood' and pay_type=1")==0){	
				$amount=get_sum($m_table2,'pay_net'," visit_id ='$id'");
                $bankPay=get_sum('gnr_x_acc_payments','amount',"`vis`='$id' and `type`='$type' and mood='$mood' and pay_type=2");
				$amount=$amount-$dtsPay-$bankPay;				
				if($amount<0){
					$amount=$amount*(-1);
					$type=4;
				}
                if($amo && $pt==2){$amount=$amo;}
				if($amount){				
					mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`,`pay_type`,`commi`,`differ`)values('$type','$id','$amount','$thisUser','$now','$mood','$pt','$comm','$differ')");
				}
                if($pt==1 || ($amo==0 && $pt==2)){
                    mysql_q("UPDATE $m_table SET status=1 where id ='$id' ");	
                    if($dts_id){conformDatePay($dts_id);}
                }
			}*/
		}
		if($type==2){
			$amount=0;
			$sql="select * from $m_table2  where visit_id='$id' and status=2";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){					
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$pay_net=$r['pay_net'];					
					$amount+=$pay_net;
				}				
			}
			mysql_q("UPDATE $m_table2 SET status=0  where visit_id ='$id' and status=2 ");
			if($amount>0){								
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
		}
		if($type==22){
			$type=2;
			$amount=0;
			$sql="select * from $m_table2  where visit_id='$id' and status=5";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$pay_net=$r['pay_net'];					
					$amount+=$pay_net;
				}				
			}
			mysql_q("UPDATE $m_table2 SET status=1  where visit_id ='$id' and status=5 ");
			if($amount>0){								
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
		}
		if($type==3){
			if(getTotalCO('gnr_x_acc_payments'," `vis`='$id' and `type`='$type' and `mood`='$mood'")==0){				
				$amount=get_sum($m_table2,'pay_net'," visit_id ='$id' and status IN(0,2)");
				if($amount>0 && $status==1){			
					mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
				}
				mysql_q("UPDATE $m_table SET status=3 , d_finish='$now' where id = '$id' ");
				mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' and status in(0,2)");
				delOfferVis($mood,$id,3);
				mysql_q("UPDATE gnr_x_roles SET status=4 where vis ='$id' and mood='$mood'");				
			}
		}
		if($type==4){			
			$amount=get_sum($m_table2,'pay_net'," visit_id ='$id' and status IN(0,4) ");
			if($amount>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
			mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' and status IN(0,4); ");	
			delOfferVis($mood,$id,3);
		}
		if($type==44){
			$type=4;			
			$amount=get_sum($m_table2,'pay_net'," visit_id ='$id' and status=4 ");			
			if($amount>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
			mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' and status=4 ");
			delOfferVis($mood,$id,3);
		}
		if($type==6){
			$type=4;					
			if($amo>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amo','$thisUser','$now','$mood')");
			}			
		}
		//fixCharitOpr($id,1);
	}
	if($type==5){
		if(getTotalCO('gnr_m_patients'," `id`='$id' ")){			
			$amount=0;
			$pay=get_val('gnr_m_patients','pay',$id);
			if($pay==1){$amount=_set_pwnlndtt;}
			if($pay>1){$amount=_set_o3rzlow59o;}
			if($amount>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}		
		}
	}
	$clic=get_val($m_table,'clinic',$id);
	fixCasherData($thisUser);	
	fixDashData($clic,$mood);
	return 1;
}
function addPay4($id,$type,$amount=0,$doc=0,$pt=1,$comm=0,$differ=0,$bank=0){
	global $now,$thisUser;
	$m_table='den_x_visits';
	$mood=4;
	$sql="select * from $m_table where id= '$id' limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$reg_user=$r['reg_user'];		
		$s_type=$r['type'];
		$status=$r['status'];
		$dts_id=$r['dts_id'];
		$patient=$r['patient'];
		$doc=$r['doctor'];
        //$dtsPay=fixDtsPay($id,$dts_id,$mood);
		if($reg_user!=$thisUser){mysql_q("UPDATE $m_table set reg_user='$thisUser' where id= '$id'");}
		if($type==1){				
			$amount=_set_lbza344hl;
			if($amount){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)
				values('$type','$id','$amount','$thisUser','$now','$mood')");
				$p_id=last_id();
				patient_payment($patient,$mood,1,$amount,$p_id,$doc,$id);
			}
			mysql_q("UPDATE $m_table SET status=1 where id ='$id' ");	
			if($dts_id){conformDatePay($dts_id);}			
		}
		if($type==11){	
			if($amount>0){
				$type=1;
				if(checkDublPay($mood,$id)){
                    if(mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`,`pay_type`,`commi`,`differ`,`bank`)values('$type','$id','$amount','$thisUser','$now','$mood','$pt','$comm','$differ','$bank')")){
                    
					//if(mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')")){
						$p_id=last_id();
						patient_payment($patient,$mood,1,$amount,$p_id,$doc,$id);
					}
				}
			}
		}
		if($type==2){
			if($amount>0){								
				if(mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')")){
					$p_id=last_id();
					patient_payment($patient,$mood,2,$amount,$p_id,$doc,$id);
				}
			}
		}
		if($type==3 || $type==4 || $type==5){
			if($amount>0){								
				$p_id=0;
				patient_payment($patient,$mood,$type,$amount,$p_id,$doc,$id);
			}
		}
		if($type==6){
			$amount=get_val_con('gnr_x_acc_payments','amount'," `vis`='$id' and `type`='1' and `mood`='$mood'");
			if($amount>0 && $status==1){	
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('4','$id','$amount','$thisUser','$now','$mood')");				
			}
			mysql_q("UPDATE $m_table SET status=3 , d_finish='$now' where id = '$id' ");
			//mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' and status in(0,2)");
			//delOfferVis($mood,$id,3);
			mysql_q("UPDATE gnr_x_roles SET status=4 where vis ='$id' and mood='$mood'");
			mysql_q("DELETE from gnr_x_acc_patient_payments where sub_mood ='$id' and mood='$mood'");		
		}
	}
	$clic=get_val($m_table,'clinic',$id);
	fixCasherData($thisUser);	
	fixDashData($clic,$mood);
	return 1;
}
function addPay5($id,$type,$amo=0,$pt=1,$comm=0,$differ=0,$bank=0){
	global $now,$thisUser;	
	$m_table='bty_x_visits';$m_table2='bty_x_visits_services';
	$clinic=get_val($m_table,'clinic',$id);
	$mood=get_val('gnr_m_clinics','type',$clinic);
	$sql="select * from $m_table where id= '$id' limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$reg_user=$r['reg_user'];
		$pay_type=$r['pay_type'];
		$status=$r['status'];		
		$dts_id=$r['dts_id'];
		//$dtsPay=fixDtsPay($id,$dts_id,$mood);
		if($reg_user!=$thisUser){mysql_q("UPDATE $m_table set reg_user='$thisUser' where id= '$id'");}
		if($type==1){
            $type=addPayType1($mood,$dts_id,$id,$type,$amo,$pt,$comm,$differ,$bank);
			/*if(getTotalCO('gnr_x_acc_payments'," `vis`='$id' and `type`='$type' and mood='$mood' ")==0){	
				$amount=get_sum($m_table2,'pay_net'," visit_id ='$id'");
				$amount-=$dtsPay;
				if($amount<0){
					$amount=$amount*(-1);
					$type=4;
				}
				if($amount){				
					mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
				}				
				mysql_q("UPDATE $m_table SET status=1 where id ='$id' ");	
				if($dts_id){conformDatePay($dts_id);}
			}*/
		}
		if($type==2){
			$amount=0;
			$sql="select * from $m_table2  where visit_id='$id' and status=2";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){					
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$pay_net=$r['pay_net'];					
					$amount+=$pay_net;
				}				
			}
			mysql_q("UPDATE $m_table2 SET status=0  where visit_id ='$id' and status=2 ");
			if($amount>0){								
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
		}
		if($type==22){
			$type=2;
			$amount=0;
			$sql="select * from $m_table2  where visit_id='$id' and status=5";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$pay_net=$r['pay_net'];					
					$amount+=$pay_net;
				}				
			}
			mysql_q("UPDATE $m_table2 SET status=1  where visit_id ='$id' and status=5 ");
			if($amount>0){								
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
		}
		if($type==3){
			if(getTotalCO('gnr_x_acc_payments'," `vis`='$id' and `type`='$type' and `mood`='$mood'")==0){				
				$amount=get_sum($m_table2,'pay_net'," visit_id ='$id' and status IN(0,2)");
				if($amount>0 && $status==1){			
					mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
				}
				mysql_q("UPDATE $m_table SET status=3 , d_finish='$now' where id = '$id' ");
				mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' and status in(0,2)");
				delOfferVis($mood,$id,3);
				mysql_q("UPDATE gnr_x_roles SET status=4 where vis ='$id' and mood='$mood'");				
			}
		}
		if($type==4){			
			$amount=get_sum($m_table2,'pay_net'," visit_id ='$id' and status IN(0,4) ");
			if($amount>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
			mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' and status IN(0,4); ");				
		}
		if($type==44){
			$type=4;			
			$amount=get_sum($m_table2,'pay_net'," visit_id ='$id' and status=4 ");			
			if($amount>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
			mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' and status=4 ");
			delOfferVis($mood,$id,3);
		}
		if($type==6){
			$type=4;					
			if($amo>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amo','$thisUser','$now','$mood')");
			}			
		}		
	}
	$clic=get_val($m_table,'clinic',$id);
	fixCasherData($thisUser);	
	fixDashData($clic,$mood);
	return 1;
}
function addPay6($id,$amo=0,$pt=1,$comm=0,$differ=0,$bank=0){
	global $now,$thisUser;	
	$type=1;
	$m_table='bty_x_laser_visits';$m_table2='bty_x_laser_visits_services';
	$clinic=get_val($m_table,'clinic',$id);
	$mood=6;
	$sql="select * from $m_table where id= '$id' limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$reg_user=$r['reg_user'];		
		$status=$r['status'];
		$dts_id=$r['dts_id'];
		$amount=$r['total_pay'];		
		$dts_id=$r['dts_id'];
        //$dtsPay=fixDtsPay($id,$dts_id,$mood);
		//$amount-=$dtsPay;
		$bankPay=get_sum('gnr_x_acc_payments','amount',"mood='$mood' and vis='$id' and pay_type=2 and type=1");
        $amount-=$bankPay;
		if($reg_user!=$thisUser){mysql_q("UPDATE $m_table set reg_user='$thisUser' where id= '$id'");}
        if($amo){$amount=$amo;} 
		if($amount>0){
			if(checkDublPay($mood,$id)){              
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`,`pay_type`,`commi`,`differ`,`bank`)values('$type','$id','$amount','$thisUser','$now','$mood','$pt','$comm','$differ','$bank')");
			}           
		}
		/********************************************************/
	}
	$clic=get_val($m_table,'clinic',$id);
	fixCasherData($thisUser);
	fixDashData($clic,$mood);
	return 1;

}
function addPay7($id,$type,$amo=0,$pt=1,$comm=0,$differ=0,$bank=0){
	global $now,$thisUser;	
	$m_table='osc_x_visits';$m_table2='osc_x_visits_services';	
	$mood=7;
	$sql="select * from $m_table where id= '$id' limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$reg_user=$r['reg_user'];
		$pay_type=$r['pay_type'];		
		$status=$r['status'];	
		$dts_id=$r['dts_id'];
		$clinic=$r['clinic'];
		//$dtsPay=fixDtsPay($id,$dts_id,$mood);
		if($reg_user!=$thisUser){mysql_q("UPDATE $m_table set reg_user='$thisUser' where id= '$id'");}
		if($type==1){
            list($amount,$doc_fees)=get_val_c($m_table2,'pay_net,doc_fees',$id,'visit_id');            
            $type=addPayType1($mood,$dts_id,$id,$type,$amo,$pt,$comm,$differ,$bank);
            
			/*if(getTotalCO('gnr_x_acc_payments'," `vis`='$id' and `type`='$type' and mood='$mood' ")==0){	
				list($amount,$doc_fees)=get_val_c($m_table2,'pay_net,doc_fees',$id,'visit_id');
				$amount-=$dtsPay;
				if($amount<0){
					$amount=$amount*(-1);
					$type=4;
				}
				if($amount){
                    if($doc_fees){$amount+=$doc_fees;}
					mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
                    if($doc_fees){
					   mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values(4,'$id','$doc_fees','$thisUser','$now','$mood')");
                    }
				}				
				mysql_q("UPDATE $m_table SET status=1 where id ='$id' ");	
				if($dts_id){conformDatePay($dts_id);}
			}*/
		}
		if($type==2){
			$amount=0;
			$sql="select * from $m_table2  where visit_id='$id' and status=2";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){					
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$pay_net=$r['pay_net'];					
					$amount+=$pay_net;
				}				
			}
			mysql_q("UPDATE $m_table2 SET status=0  where visit_id ='$id' and status=2 ");
			if($amount>0){								
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
		}
		if($type==22){
			$type=2;
			$amount=0;
			$sql="select * from $m_table2  where visit_id='$id' and status=5";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$pay_net=$r['pay_net'];					
					$amount+=$pay_net;
				}				
			}
			mysql_q("UPDATE $m_table2 SET status=1  where visit_id ='$id' and status=5 ");
			if($amount>0){								
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
		}
		if($type==3){
			if(getTotalCO('gnr_x_acc_payments'," `vis`='$id' and `type`='$type' and `mood`='$mood'")==0){				
				$amount=get_sum($m_table2,'pay_net'," visit_id ='$id' and status IN(0,2)");
				if($amount>0 && $status==1){			
					mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
				}
				mysql_q("UPDATE $m_table SET status=3 , d_finish='$now' where id = '$id' ");
				mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' and status in(0,2)");
				delOfferVis($mood,$id,3);
				mysql_q("UPDATE gnr_x_roles SET status=4 where vis ='$id' and mood='$mood'");				
			}
		}
		if($type==4){			
			$amount=get_sum($m_table2,'pay_net'," visit_id ='$id' and status IN(0,4) ");
			if($amount>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
			mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' and status IN(0,4); ");	
			delOfferVis($mood,$id,3);
		}
		if($type==44){
			$type=4;			
			$amount=get_sum($m_table2,'pay_net'," visit_id ='$id' and status=4 ");			
			if($amount>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}
			mysql_q("UPDATE $m_table2 set status=3 where visit_id='$id' and status=4 ");
			delOfferVis($mood,$id,3);
		}
		if($type==6){
			$type=4;					
			if($amo>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amo','$thisUser','$now','$mood')");
			}			
		}
		//fixCharitOpr($id,1);
	}
	if($type==5){
		if(getTotalCO('gnr_m_patients'," `id`='$id' ")){			
			$amount=0;
			$pay=get_val('gnr_m_patients','pay',$id);
			if($pay==1){$amount=_set_pwnlndtt;}
			if($pay>1){$amount=_set_o3rzlow59o;}
			if($amount>0){				
				mysql_q("INSERT INTO gnr_x_acc_payments(`type`,`vis`,`amount`,`casher`,`date`,`mood`)values('$type','$id','$amount','$thisUser','$now','$mood')");
			}		
		}
	}
	$clic=get_val($m_table,'clinic',$id);
	fixCasherData($thisUser);	
	fixDashData($clic,$mood);
	return 1;
}
/********************/
function fixCasherData($user,$pay_type=1){
	global $now,$clinicTypes;
    $payData=balance($user);    
	$in=$payData[$pay_type]['in'];
	$out=$payData[$pay_type]['out'];
	for($i=1;$i<count($clinicTypes);$i++){
		${'in'.$i}=$payData[$pay_type]['in'.$i];
		${'out'.$i}=$payData[$pay_type]['out'.$i];		
	}
	$card=$payData[$pay_type]['card'];
	$offer=$payData[$pay_type]['offer'];
	$vis=visitsTotal($user);
	
	if(getTotalCO('gnr_x_tmp_cash',"casher='$user' and pay_type='$pay_type' ")==0){
		list($bal_in,$bal_out)=allBalance($user);		
		$sql="INSERT INTO gnr_x_tmp_cash (`date`,`casher`,`amount_in`,`amount_out`,`vis`,
		`a1_in`,`a1_out`,`a2_in`,`a2_out`,`a3_in`,`a3_out`,`a4_in`,`a4_out`,
		`a5_in`,`a5_out`,`a6_in`,`a6_out`,`a7_in`,`a7_out`,
		`bal_in`,`bal_out`,`card`,`offer`,`pay_type`)
        values
        ('$now','$user','$in','$out','$vis',
		'$in1','$out1','$in2','$out2','$in3','$out3','$in4','$out4',
		'$in5','$out5','$in6','$out6','$in7','$out7',
		'$bal_in','$bal_out','$card','$offer',$pay_type)";
	}else{
		$sql="UPDATE  gnr_x_tmp_cash SET		
		`amount_in`='$in',`amount_out`='$out',`vis`='$vis',
		`a1_in`='$in1',`a1_out`='$out1',
		`a2_in`='$in2',`a2_out`='$out2',
		`a3_in`='$in3',`a3_out`='$out3',
		`a4_in`='$in4',`a4_out`='$out4',
		`a5_in`='$in5',`a5_out`='$out5',
		`a6_in`='$in6',`a6_out`='$out6',
		`a7_in`='$in7',`a7_out`='$out7',
		`card`='$card',`offer`='$offer'
		where casher='$user' and `pay_type`='$pay_type' ";
	}
	mysql_q($sql);
    if($pay_type==1 && _set_l1acfcztzu){
        fixCasherData($user,2);
    }
}
function fixCasherBalans($user){
	if(_set_vyo1ykjlhm){
		if(getTotalCO('gnr_x_tmp_cash',"casher='$user'")){
			list($bal_in,$bal_out)=allBalance($user);
			$sql="UPDATE  gnr_x_tmp_cash SET `bal_in`='$bal_in',`bal_out`='$bal_out' where casher='$user' ";
		}	
		mysql_q($sql);
	}
}
function fixDashData($c_id,$type){
	global $now,$visXTables,$srvXTables,$ss_day;
	//$c_type=get_val('gnr_m_clinics','type',$c_id);	
	$vis=0;
	$table=$visXTables[substr($type,0,1)];
	$table2=$srvXTables[substr($type,0,1)];
	$q='';
	$q2='';
	
	if($type!=2){
		$q=" and clinic='$c_id'  ";
		$q2=" and vis IN(select id from $table where clinic='$c_id' ) ";
	}
	
	$vis=getTotalCO($table,"   d_start > '$ss_day' $q ");	
	$cash_in=get_sum('gnr_x_acc_payments','amount'," type IN(1,2,6,7,11) and date>'$ss_day' $q2 and mood=$type ");
	$cash_ou=get_sum('gnr_x_acc_payments','amount'," type IN(3,4,8) and date>'$ss_day' $q2 and mood=$type ");
	$amount=$cash_in-$cash_ou;
	
	if($type==6){
		$std=get_sum($table,'total_pay'," d_start>'$ss_day' ");
		$scd=$st=$sc=$std;
	}else if($type==4){
		$std=get_sum('den_x_visits_services_levels','price'," date_e>'$ss_day' and status = 2 $q2 ");
		$scd=$st=$sc=$std;
	}else{
		$q=" and clinic='$c_id' ";
		$q2=" and status=1";
		if($type==2){$q='';$q2=' and status in(1,5,6,7,8,9,10)';}	

		list($std,$scd)=get_sum($table2,'total_pay,pay_net'," d_start>'$ss_day' $q $q2");
		list($st,$sc)=get_sum($table2,'total_pay,pay_net'," d_start>'$ss_day' $q and status!=3 ");
	}
	mysql_q("DELETE from gnr_x_tmp_dash where clinic='$c_id' ");
	mysql_q("INSERT INTO gnr_x_tmp_dash (`date`,`clinic`,`vis`,`c_type`,`srv_total`,`srv_cash`,`srv_total_done`,`srv_cash_done`,`amount`)
	values('$now','$c_id','$vis','$type','$st','$sc','$std','$scd','$amount')");
} 
function checkDublPay($mood,$vis){
	$out=1;
	if($mood==4 && $vis!=0){
		if(getTotalCO('gnr_x_acc_payments'," mood='$mood' and vis='$vis' and pay_type=1")>0){$out=0;}
	}
	if($mood==6){
		if(getTotalCO('gnr_x_acc_payments'," mood='$mood' and vis='$vis' and pay_type=1 ")>0){$out=0;}
	}
	return $out;
}
function addRoles($id,$mood,$type=0){
	global $now,$ss_day,$visXTables,$srvXTables;
	$m_table=$visXTables[$mood];$m_table2=$srvXTables[$mood];
	$sql="select * from $m_table where id= '$id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$fast=0;
	if($rows>0){
		$r=mysql_f($res);
		if($mood==2){
			$clinic=get_val_c('gnr_m_clinics','id',2,'type');
			$dts_id=0;
			$dts_date=0;
			$doctor=0;
			$fast=$r['fast'];
		}else{
			$clinic=$r['clinic'];
			$dts_id=$r['dts_id'];
			$dts_date=$r['dts_date'];
			$doctor=$r['doctor'];
			if($mood==3){$doctor=$r['ray_tec'];}
		}
		if($mood==1 || $mood==3){$fast=$r['fast'];}		
		$patient=$r['patient'];
		$pat_name=get_p_name($patient);
		if(getTotalCO('gnr_x_roles'," vis='$id' and mood='$mood' ")>0){
			$no=get_val_con('gnr_x_roles','no'," vis='$id' and mood='$mood' ");
			if($dts_id==0){return $no;}else{return clockStr($no); }
		}else{
			$time_need=get_time_need($id,$mood);
			if($mood==4){
				$services=$type;
			}else{
				$services=get_roles_servises($id,$mood);
			}			
			if($dts_id==0){
				$no=getMaxValOrder('gnr_x_roles','no'," where `clic`='$clinic' and fast!=2 ");
				$date=$now;
				$texNo=$no;
			}else{
				$no=$dts_date-$ss_day;
				$texNo=clockStr($no);
				$date=$now;
				$fast=2;
			}
			if(mysql_q("INSERT INTO gnr_x_roles (`vis`,`clic`,`pat`,`no`,`date`,`fast`,`mood`,`time_need`,`doctor`,`pat_name`,`services`)values('$id','$clinic','$patient','$no','$date','$fast','$mood','$time_need','$doctor','$pat_name','$services')")){
			editTempOpr($mood,$id,4,1);
			return $texNo;
			
			}else{return 0;}			
		}
	}else{return 0;}
}
function get_roles_servises($id,$mood){
	global $srvTables,$srvXTables,$lg;
	$out='';
	$table=$srvTables[$mood];
	$table2=$srvXTables[$mood];
	$rev=0;
	if(!in_array($mood,[2,5,6])){
		$rev=get_vals($table2,'rev',"visit_id='$id' ");
	}	
	$sql="select * from $table2 where visit_id='$id' ";
	$res=mysql_q($sql);
	while($r=mysql_f($res)){
		$service=$r['service'];
		$rev=$r['rev'];
		if($mood==2){
			$srvTxt=get_val_arr($table,'short_name',$service,'sr');
		}else{
			$srvTxt=get_val_arr($table,'name_'.$lg,$service,'sr');
		}
		if($out){$out.=' :: ';}
		$out.=$srvTxt;
		if($rev){$out.=' <span class="clr5"> ( مراجعة ) </span> ';}
	}
	return $out;
}
function get_time_need($id,$mood){
	global $srvTables,$srvXTables;
	if($mood==4){
		return _set_a5ddlqulxk;
	}else{
		if($mood==2){
			return 0;
		}
		$table=$srvTables[$mood];
		$table2=$srvXTables[$mood];
		$time=get_sum($table,'ser_time'," id IN( select service from $table2 where visit_id= '$id' and status=0 )");
		return $time*_set_pn68gsh6dj;
	}	
}
function resetRles(){
	global $ss_day,$now;
    $resetDate=_set_2zpwcuzice;
    $newDay=date('Y-m-d',$ss_day);
    $changeDate=0;
    if($resetDate==0){
        $changeDate=1;
    }else{
        if($resetDate!=$newDay){
            $changeDate=1;
            mysql_q("DELETE from gnr_x_roles where `date`<'$ss_day'");
            if(getTotal('gnr_x_roles')==0){mysql_q("ALTER TABLE gnr_x_roles AUTO_INCREMENT = 1");}

            mysql_q("DELETE from gnr_x_tmp_cash where `date`<'$ss_day'");
            if(getTotal('gnr_x_tmp_cash')==0){mysql_q("ALTER TABLE gnr_x_tmp_cash AUTO_INCREMENT = 1");}

            mysql_q("DELETE from gnr_x_tmp_dash where `date`<'$ss_day'");
            if(getTotal('gnr_x_tmp_dash')==0){mysql_q("ALTER TABLE gnr_x_tmp_dash AUTO_INCREMENT = 1");}

            mysql_q("UPDATE gnr_x_arc_stop_clinic set e_date='$now' where e_date=0 and `s_date`<'$ss_day'");
            mysql_q("DELETE from gnr_x_temp_oprs where `date`<'".($now-(86400*3))."'");          
            if(proAct('dts')){
                resetDTS();
                mysql_q("DELETE from dts_x_dates_temp where `d_start`<'$ss_day'");
                loadTodayDates();
                vacaConflictAlert();
            }
        }
    }
    if($changeDate){
        mysql_q("UPDATE _settings SET val='$newDay' where code='2zpwcuzice'");
    }
}
function resetDTS(){
	global $ss_day;
	$sql="select id,p_type,patient from dts_x_dates where status=1 and `d_start`< $ss_day  ";
	$res=mysql_q($sql);
    $rows=mysql_n($res);
	while($r=mysql_f($res)){
		$id=$r['id'];
		$patient=$r['patient'];
		$p_type=$r['p_type'];
		setDtsBList($p_type,$patient,'x');
		mysql_q("UPDATE dts_x_dates set status=6 where id='$id' and status=1");
	}
}
function loadTodayDates(){
    global $ss_day,$ee_day,$now,$srvTables,$lg;
    if(proAct('dts')){
        mysql_q("DELETE from dts_x_dates_temp where d_start <'$ss_day' ");
        $sql="select * from dts_x_dates where d_start>='$ss_day' and  d_start<'$ee_day' and status!=0 and id NOT IN(select id from dts_x_dates_temp)";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows){
            while($r=mysql_f($res)){
                $id=$r['id'];
                $mood=$r['type'];
                $pat_name=get_p_dts_name($r['patient'],$r['p_type']);
                $srvs=get_vals('dts_x_dates_services','service',"dts_id='$id' ");
				$services='';
				if($srvs){
					if($mood==4){
						$services=$srvs;
					}else{
						$services=get_vals($srvTables[$mood],'name_'.$lg,"id IN($srvs)",' :: ');
					}
				}       
                $sql="
                INSERT INTO dts_x_dates_temp(id,doctor,patient,p_type,clinic,type,date,d_start,d_start_r,d_end,d_end_r,d_confirm,status,note,reg_user,vis_link,pat_note,app,other,rate,reserve,pat_name,services)values(
                '".$r['id']."',
                '".$r['doctor']."',
                '".$r['patient']."',
                '".$r['p_type']."',
                '".$r['clinic']."',
                '".$r['type']."',
                '".$r['date']."',
                '".$r['d_start']."',
                '".$r['d_start_r']."',
                '".$r['d_end']."',
                '".$r['d_end_r']."',
                '".$r['d_confirm']."',
                '".$r['status']."',
                '".$r['note']."',
                '".$r['reg_user']."',
                '".$r['vis_link']."',
                '".$r['pat_note']."',
                '".$r['app']."',
                '".$r['other']."',
                '".$r['rate']."',
                '".$r['reserve']."',                
                '$pat_name',
                '$services'
                )";                
                mysql_q($sql);
            }
        }
    }
}
function datesTempUp($id){
    global $ss_day,$ee_day,$now,$srvTables,$lg;
    $token='';
    if(proAct('dts')){
        $r=getRecCon('dts_x_dates',"id='$id' and d_start>='$ss_day' and  d_start<'$ee_day'");
        if($r['r']){
            $id=$r['id'];
            $mood=$r['type'];
            list($pat_name,$token)=get_p_dts_name($r['patient'],$r['p_type'],0,1);
            $srvs=get_vals('dts_x_dates_services','service',"dts_id='$id' ");
			$services='';
			if($srvs){
				$services='';
				if($srvs){
					if($mood==4){
						$services=$srvs;
					}else{				
						$services=get_vals($srvTables[$mood],'name_'.$lg,"id IN($srvs)",' :: ');
					} 
				}
			}
            $r2=getRec('dts_x_dates_temp',$id);
            if($r2['r']){
                $sql="UPDATE dts_x_dates_temp SET 
                doctor='".$r['doctor']."',
                patient='".$r['patient']."',
                p_type='".$r['p_type']."',
                clinic='".$r['clinic']."',
                type='".$r['type']."',
                date='".$r['date']."',
                d_start='".$r['d_start']."',
                d_start_r='".$r['d_start_r']."',
                d_end='".$r['d_end']."',
                d_end_r='".$r['d_end_r']."',
                d_confirm='".$r['d_confirm']."',
                status='".$r['status']."',
                note='".$r['note']."',
                reg_user='".$r['reg_user']."',
                vis_link='".$r['vis_link']."',
                pat_note='".$r['pat_note']."',
                app='".$r['app']."',
                other='".$r['other']."',
                rate='".$r['rate']."',
                reserve='".$r['reserve']."',
                pat_name='$pat_name',
                services='$services',
                token='$token'
                where id='$id' ";
            }else{
                $sql="
                INSERT INTO dts_x_dates_temp(id,doctor,patient,p_type,clinic,type,date,d_start,d_start_r,d_end,d_end_r,d_confirm,status,note,reg_user,vis_link,pat_note,app,other,rate,reserve,pat_name,services,token)values(
                '".$r['id']."',
                '".$r['doctor']."',
                '".$r['patient']."',
                '".$r['p_type']."',
                '".$r['clinic']."',
                '".$r['type']."',
                '".$r['date']."',
                '".$r['d_start']."',
                '".$r['d_start_r']."',
                '".$r['d_end']."',
                '".$r['d_end_r']."',
                '".$r['d_confirm']."',
                '".$r['status']."',
                '".$r['note']."',
                '".$r['reg_user']."',
                '".$r['vis_link']."',
                '".$r['pat_note']."',
                '".$r['app']."',
                '".$r['other']."',
                '".$r['rate']."',
                '".$r['reserve']."', 
                '$pat_name',
                '$services',
                '$token'
                )";
            }
            mysql_q($sql);
           
        }else{
            mysql_q("delete from dts_x_dates_temp where id='$id'");
        }
    }
}
function setDtsBList($p_type,$pat,$s){
	global $blockTime,$now;
	$table='dts_x_patients_black_list';
	$con =" pat_type='$p_type' and patient='$pat' ";
	if($s==1){
		mysql_q("delete from $table where ($con) OR date > $blockTime");
	}else{
		if(getTotalCO($table," $con ")){
			$sql="UPDATE $table SET times=times+1 where $con ";	
		}else{
			$sql="INSERT INTO $table (`pat_type`,`patient`,`times`,`date`)VALUES('$p_type','$pat',1,$now) ";	
		}		
		mysql_q($sql);
	}
}
function fixPatAccunt($id){
	$out=$total=$visits=$srv_bty=$srv_cln=$srv_den=$srv_lab=$srv_laser=$srv_xry=$points=$last_vis=0;
	//CLN
	$vis=get_vals('cln_x_visits','id'," patient='$id' and status =2 ");	
	if($vis){
		$table='cln_x_visits_services';
		$vis_arr=explode(',',$vis);
		$visits+=count($vis_arr);
		$total+=get_sum($table,'total_pay'," visit_id in($vis) and status!=3");
		$srv_cln+=getTotalCO($table," visit_id in($vis) and status!=3 and bty=0 ");
		$srv_bty+=getTotalCO($table," visit_id in($vis) and status!=3 and bty=1 ");
		$date=get_val_con($table,'d_start',"patient='$id'",' order by d_start DESC');		
		$last_vis=max($last_vis,$date);
	}	
	//LAB
	$vis=get_vals('lab_x_visits','id'," patient='$id' and status not in (0,3) ");
	if($vis){
		$table='lab_x_visits_services';
		$vis_arr=explode(',',$vis);
		$visits+=count($vis_arr);
		$total+=get_sum($table,'(units*units_price)'," visit_id in($vis) and status!=3");
		$srv_lab=getTotalCO($table," visit_id in($vis) and status!=3");
		$date=get_val_con($table,'d_start',"patient='$id'",' order by d_start DESC');
		$last_vis=max($last_vis,$date);
	}	
	//XRY
	$vis=get_vals('xry_x_visits','id'," patient='$id' and status =2 ");
	if($vis){
		$table='xry_x_visits_services';
		$vis_arr=explode(',',$vis);
		$visits+=count($vis_arr);
		$total+=get_sum($table,'total_pay'," visit_id in($vis) and status!=3");
		$srv_xry=getTotalCO($table," visit_id in($vis) and status!=3");		
		$date=get_val_con($table,'d_start',"patient='$id'",' order by d_start DESC');
		$last_vis=max($last_vis,$date);
	}	
	//BTY
	$vis=get_vals('bty_x_visits','id'," patient='$id' and status =2 ");
	if($vis){
		$table='bty_x_visits_services';
		$vis_arr=explode(',',$vis);
		$visits+=count($vis_arr);
		$total+=get_sum($table,'total_pay'," visit_id in($vis) and status!=3");
		$srv_bty+=getTotalCO($table," visit_id in($vis) and status!=3");
		$date=get_val_con($table,'d_start',"patient='$id'",' order by d_start DESC');
		$last_vis=max($last_vis,$date);
	}	
	//LSR
	$vis=get_vals('bty_x_laser_visits','id'," patient='$id' and status =2 ");
	if($vis){
		$table='bty_x_laser_visits';
		$vis_arr=explode(',',$vis);
		$visits+=count($vis_arr);
		$total+=get_sum($table,'total_pay'," patient='$id' and status!=3");
		$srv_laser=getTotalCO($table," patient='$id' and status!=3");
		$date=get_val_con($table,'d_start',"patient='$id'",' order by d_start DESC');
		$last_vis=max($last_vis,$date);
	}	
	//DEN
	$vis=get_vals('den_x_visits','id'," patient='$id' and status =2 ");
    $table='den_x_visits_services';
	if($vis){		
		$vis_arr=explode(',',$vis);
		$visits+=count($vis_arr);
		//$total+=get_sum($table,'total_pay'," visit_id in($vis) and status=1");        
		//$srv_den=getTotalCO($table," visit_id in($vis) and status=1");        
		$date=get_val_con($table,'d_start',"patient='$id'",' order by d_start DESC');
		$last_vis=max($last_vis,$date);        
	}
    
    $srv_den=getTotalCO($table," patient='$id' and status!=3");    
    $total+=get_sum('gnr_x_acc_patient_payments','amount'," patient ='$id' ");
	//OSC
	$vis=get_vals('osc_x_visits','id'," patient='$id' and status =2 ");	
	if($vis){
		$table='osc_x_visits_services';
		$vis_arr=explode(',',$vis);
		$visits+=count($vis_arr);
		$total+=get_sum($table,'total_pay'," visit_id in($vis) and status!=3");
		$srv_osc=getTotalCO($table," visit_id in($vis) and status!=3");
		$date=get_val_con($table,'d_start',"patient='$id'",' order by d_start DESC');
		$last_vis=max($last_vis,$date);		
	}	
	if($visits){
		$out=1;
		$eva=getTotalCO('gnr_m_patients_evaluation',"id='$id'");
		if($eva){
			$sql="UPDATE gnr_m_patients_evaluation set 
			new_payments='$total' , 
			visits='$visits' ,
			srv_cln='$srv_cln' ,
			srv_lab='$srv_lab' ,
			srv_xry='$srv_xry' ,
			srv_den='$srv_den' ,
			srv_bty='$srv_bty' ,
			srv_laser='$srv_laser' ,
			srv_osc='$srv_osc' ,
			points='$points' ,
			last_vis='$last_vis' 		
			where id='$id' ";
		}else{
			list($birth,$mobile)=get_val('gnr_m_patients','birth_date,mobile',$id);
			$sql="INSERT INTO gnr_m_patients_evaluation (`id`,`new_payments`, `visits`, `srv_cln`, `srv_lab`, `srv_xry`, `srv_den`, `srv_bty`, `srv_laser`, `points`, `last_vis`,`birth`,`mobile`,`srv_osc`) values ( '$id', '$total', '$visits', '$srv_cln', '$srv_lab', '$srv_xry', '$srv_den', '$srv_bty', '$srv_laser', '$points', '$last_vis', '$birth', '$mobile', '$srv_osc') ";
		}
		//echo $sql.'<br>';
		mysql_q($sql);
		//if($eva){
		
		//}
	}
    mysql_q("UPDATE gnr_m_patients_evaluation set total=(old_payments+new_payments) where id='$id' ");
	mysql_q("UPDATE gnr_m_patients set t_points=1 where id='$id' ");
	return $out;
}
function getMClinic($c){
	$out=$c;
	$cc=get_val('gnr_m_clinics','linked',$c);
	if($cc){$out=$cc;}
	return $out;
}
function getAllLikedClinics($clinic,$c='|'){
	$m_clinic=getMClinic($clinic);
	return get_vals('gnr_m_clinics','id'," id='$m_clinic' OR linked='$m_clinic' " , $c);
}
function updatePat($id,$type=2){
	list($pat,$sex,$bd)=get_val('gnr_m_patients_medical_info','patient,sex,birth_date',$id);
	mysql_q("UPDATE gnr_m_patients SET birth_date='$bd' , sex='$sex' where id='$pat' ");
    if($type==4){
        labJsonPat($id);
    }
}
function labJsonPat($id){
    if(_set_wr54mldf53==1){
        $data=array();
        $json='';
        $pat=getRec('gnr_m_patients',$id);
        if($pat['r']){
            $data[0]['patient_id']=$id;
            $data[0]['name']=$pat['f_name'];
            $data[0]['l_name']=$pat['l_name'];
			$data[0]['mobile']=$pat['mobile'];
            $data[0]['father_name']=$pat['ft_name'];
            $data[0]['birth_date']=$pat['birth_date'];
            $data[0]['sex']=$pat['sex'];
            $json=json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        if($json){
            if(!file_exists('../../../Pats')){mkdir('../../../Pats',0777);}
            $file='../../../Pats/'.$id.'.txt';
            $myfile=fopen($file, "r");
            file_put_contents($file,$json);
            //fclose($myfile);
        }
    }
}
function GINA($type,$sex,$scale,$Mval){
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
function gi_age($id,$opr,$filed,$val){
	if($opr=='add' || $opr=='edit'){
		$out='<select name="'.$filed.'" >';		
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
		$out.='</select><span>'.k_age_in_month.'</span>';
	}else{
		$out='<ff>'.$val.'</ff>';
	}
	return $out;
}
function gi_getMonthAge($date,$sDate=''){
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
			if($d-$dd[2]>=8){$out+=0.5;}
		}else{
			$out-=1;
			$t=$d+30-$dd[2];
			if($t>=8 && $t<22){$out+=0.5;}
			if($t>=22){$out+=1;}
		}
	}
	return $out;
}
function delVis($id,$mood,$type=1){
	global $thisGrp,$thisUser,$visXTables,$srvXTables;
	$v_table=$visXTables[$mood];
	$v_table2=$srvXTables[$mood];
	delOfferVis($mood,$id);
    visDelLog($mood,$id,$type);
	if($mood==6){
		mysql_q("UPDATE $v_table SET pay_type=0 where id='$id' and status=2");
		mysql_q("delete from $v_table where id='$id' and status=0");
		mysql_q("delete from $v_table2 where visit_id='$id' and status=0");
		mysql_q("delete from bty_x_laser_visits_services_vals where visit_id='$id' ");
	}else{
		mysql_q("delete from $v_table2 where visit_id='$id' and status=0");
		mysql_q("delete from $v_table where id='$id' and status=0");
	}
	mysql_q("DELETE from gnr_x_insurance_rec where mood='$mood' and visit='$id' ");
	mysql_q("DELETE from gnr_x_charities_srv where mood='$mood' and vis='$id' ");
    mysql_q("DELETE from gnr_x_exemption_srv where mood='$mood' and vis='$id' ");
    mysql_q("DELETE from gnr_x_acc_payments where mood='$mood' and vis='$id' ");
    
	delTempOpr($mood,$id,'a');
	return 1;
}

function balance($u=0){
	global $now,$ss_day,$clinicTypes;
	$res=array();
	$q='';
	if($u){$q=" and casher = '$u' ";}
	$t='gnr_x_acc_payments';
	$c='amount';	
	for($i=1;$i<count($clinicTypes);$i++){
        //---Cash---
		$qu=" mood='$i' and date > $ss_day $q and ";
		$res[1]['in'.$i]=get_sum($t,$c," $qu type IN(1,2,6,7) and pay_type=1");
		$res[1]['in']+=$res[1]['in'.$i];
		$res[1]['out'.$i]=get_sum($t,$c," $qu type IN(3,4,8)  and pay_type=1");
		$res[1]['out']+=$res[1]['out'.$i];	
        //---Bank---
        $res[2]['in'.$i]=get_sum($t,$c," $qu type IN(1,2,6,7) and pay_type=2");
		$res[2]['in']+=$res[2]['in'.$i];
		$res[2]['out'.$i]=get_sum($t,$c," $qu type IN(3,4,8)  and pay_type=2");
		$res[2]['out']+=$res[2]['out'.$i];	
	}	
    //---Cash---
    if(_set_9iaut3jze==1){
	   $res[1]['offer']=get_sum('gnr_x_acc_payments','amount'," type=10 and pay_type=1 and date > $ss_day $q");
	   $res[1]['in']+=$res[1]['offer'];
    }
    if(_set_pwnlndtt!=0){
        $res[1]['card']=get_sum('gnr_x_acc_payments','amount'," type=5  and pay_type=1 and date > $ss_day $q");
        $res[1]['in']+=$res['card'];
    }
    //---Bank---
    if(_set_9iaut3jze==1){
        $res[2]['offer']=get_sum('gnr_x_acc_payments','amount'," type=10 and pay_type=2 and date > $ss_day $q");
        $res[2]['in']+=$res[2]['offer'];
    }
    //--------------
	return $res;
}
function allBalance($u){	
	$q=" and casher = '$u' ";
	$box_in=get_sum('gnr_x_acc_payments','amount'," type IN(1,2,5,6,7,10) and pay_type=1 $q");	
	$box_out=get_sum('gnr_x_acc_payments','amount'," type IN(3,4,8) and pay_type=1 $q");
	$box_out+=get_sum('gnr_x_box_take','amount'," box='$u' ");
	return array($box_in,$box_out);
}
function visitsTotal($u=0){
	global $now,$thisUser,$ss_day,$visXTables;
	$total=0;
	if($u){$q=" and reg_user = '$u' ";}
	foreach($visXTables as $table){
		if($table){$total+=getTotalCO($table," d_start > $ss_day $q");}
	}
	return $total;
}
function vacaConflict($type,$emp,$s_date,$e_date){
	if($type=='add'){
		$sql="UPDATE `dts_x_dates` SET status=9 where doctor='$emp' and ((d_start > $s_date and d_start < $e_date) OR (d_end > $s_date and d_end < $e_date)) and status in(1,10)";
	}elseif($type=='del'){
		$sql="UPDATE `dts_x_dates` SET status=1 where doctor='$emp' and ((d_start > $s_date and d_start < $e_date) OR (d_end > $s_date and d_end < $e_date)) and status =9 ";
	}
	if(mysql_q($sql)){vacaConflictAlert();}
}
function vacaConflictAlert(){
    global $ss_day;
	$confl=getTotalCO('dts_x_dates'," status=9 and d_start> $ss_day");
	mysql_q("delete from gnr_x_visits_services_alert where mood=22 ");
	if($confl){servPayAler($confl,22);}	
}
function vacaDel($id,$no){
	if($no==5){
		$r=getRec('gnr_x_vacations',$id);
		$_SESSION['vaca'.$id]=$r;
		echo script('co_del_rec('.$id.')');
	}	
	if($no==6){
		$data=$_SESSION['vaca'.$id];		
		$emp=$data['emp'];
		$type=$data['type'];
		$s_date=$data['s_date'];
		$e_date=$data['e_date'];
		$s_hour=$data['s_hour'];
		$e_hour=$data['e_hour'];
		$e_s_date=$s_date;
		$e_e_date=$e_date+86400;
		if($type==2){
			$e_s_date=$s_date+$s_hour;
			$e_e_date=$s_date+$e_hour;
		}
		vacaConflict('del',$emp,$e_s_date,$e_e_date);		
	}
}
function show_docs($id){
	return '<div class="fr ic40 icc1 ic40_det ic40Txt" onclick="patDocs('.$id.',1)"> '.k_documents.'</div>';
}
function getWRSamm($rep,$part,$d_start,$d_end,$min_avg,$max_avg){
	global $visXTables,$clinicTypes;
	$min_avg=$min_avg*60;
	$max_avg=$max_avg*60;
	$out=array(0,0,0,0);
	if($rep==1){
		$q=" d_start>='$d_start' and d_start < '$d_end' and d_check > 0 ";
		$q2=" and dts_id=0 ";
		if($part==2){$q2='';}
		if($part==0){
			foreach($clinicTypes as $k=>$m){
				if($k){					
					$out[0]+=getTotalCO($visXTables[$k],$q.$q2);
					if($min_avg){
						$out[1]+=getTotalCO($visXTables[$k],$q.$q2." and (d_check-d_start)<$min_avg ");
					}
					if($max_avg){
						$out[2]+=getTotalCO($visXTables[$k],$q.$q2." and (d_check-d_start)>=$max_avg ");
					}
				}
			}
		}else{
			$out[0]+=getTotalCO($visXTables[$part],$q.$q2);
			if($min_avg){
				$out[1]+=getTotalCO($visXTables[$part],$q.$q2." and (d_check-d_start)<$min_avg ");
			}
			if($max_avg){
				$out[2]+=getTotalCO($visXTables[$part],$q.$q2." and (d_check-d_start)>=$max_avg ");
			}
		}
		$out[3]=$out[0]-$out[1]-$out[2];
	}
	if($rep==2){
		$q=" d_start>='$d_start' and d_start < '$d_end' and status = 4 ";		
		if($part){$q.=" and type='$part' ";}         
		$out[1]+=getTotalCO('dts_x_dates',$q." and d_confirm <= d_start and reserve=0");
		$out[2]+=getTotalCO('dts_x_dates',$q." and d_confirm > d_start and reserve=0");			
		$out[0]=$out[1]+$out[2];
	}
	
	return $out;
}
function get_wr_data($rep,$part,$d_start,$d_end,$min_avg,$max_avg,$chart_avg){
	global $visXTables,$clinicTypes;
	$out=array();
	if($rep==1){
		for($i=$min_avg;$i<$max_avg;$i+=$chart_avg){			
			$name=$i.'-'.($i+$chart_avg);			
			$n=0;
			$sd=$i*60;
			$ed=(($i+$chart_avg)*60);
			if($i+$chart_avg>$max_avg){$ed=$max_avg*60;$name=$i.'-'.$max_avg;}
			if($ed==($max_avg*60)){$ed++;}
			$q=" d_start>='$d_start' and d_start < '$d_end' and d_check > 0 ";
			$q2=" and dts_id=0 ";
			if($part==2){$q2='';}			
			if($part==0){
				foreach($clinicTypes as $k=>$m){
					if($k){	
						$n+=getTotalCO($visXTables[$k],$q.$q2." and (d_check-d_start)>=$sd and (d_check-d_start)<$ed ");
					}
				}
			}else{				
				$n=getTotalCO($visXTables[$part],$q.$q2." and (d_check-d_start)>=$sd and (d_check-d_start)<$ed ");
			}			
			$out[$name]=$n;
		}
	}else{
		if($rep==2){
			$q=" d_start>='$d_start' and d_start < '$d_end' and status = 4 and d_confirm <= d_start ";
		}
		if($rep==3 || $rep==4){
			$q=" d_start>='$d_start' and d_start < '$d_end' and status = 4 and d_confirm > d_start ";
		}		
		if($part){$q.=" and type='$part' ";}
		for($i=$min_avg;$i<$max_avg;$i+=$chart_avg){			
			$name=$i.'-'.($i+$chart_avg);			
			$n=0;
			$sd=$i*60;
			$ed=(($i+$chart_avg)*60);			
			if($i+$chart_avg>$max_avg){$ed=$max_avg*60;$name=$i.'-'.$max_avg;}
			if($ed==($max_avg*60)){$ed++;}
			if($rep==2){
				$n=getTotalCO('dts_x_dates',$q." and (d_start_r-d_start)>=$sd and (d_start_r-d_start)<$ed ");
			}
			if($rep==3){
				$n=getTotalCO('dts_x_dates',$q." and (d_start_r-d_confirm)>=$sd and (d_start_r-d_confirm)<$ed ");
			}
			if($rep==4){				
				$n=getTotalCO('dts_x_dates',$q." and (d_confirm-d_start)>=$sd and (d_confirm-d_start)<$ed ");
			}
			$out[$name]=$n;
		}
		
	}
	return $out;
}
function getCharInfo($id){
	global $lg;
	$r=getRec('gnr_m_charities',$id);
	if($r['r']){
		$ch_name=$r['name_'.$lg];
		$person=$r['person'];
		$phone=$r['phone'];
		$mobile=$r['mobile'];		
		$address=$r['address'];
		$out='
		<div class="b_bord">
			<div class="f1 fs16 clr55">'.$ch_name.'</div>
			<div class="f1 fs12 lh30">'.$person.' <ff14>'.$mobile.' / '.$phone.'</ff14></div>
			<div class="f1 fs12 lh30">'.$address.'</div>			
		</div>';
	}
	return $out;
}
function fixCharServ($mood,$id){
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
				mysql_q("UPDATE gnr_x_charities_srv SET status=1 where mood='$mood' and vis='$id' and x_srv='$s_id' ");
			}
		}
	}
}
function  fixExeServ($mood,$id){
	
}

function biludWiz($tap,$t=1){
	$newVisTaps=array();
    if($t==1){
        $newVisTaps[1]=array('cln',k_clinic);
        $newVisTaps[2]=array('pat',k_patient);
        $newVisTaps[3]=array('doc',k_dr);
        $newVisTaps[4]=array('srv',k_service);
        $newVisTaps[5]=array('pay',k_payms);
    }else{
        $newVisTaps[1]=array('cln',k_clinic);
        $newVisTaps[2]=array('srv',k_service);        
        $newVisTaps[3]=array('doc',k_dr);
        $newVisTaps[4]=array('pat',k_patient);        
    }
	$out='<div class="recWiz fxg" fxg="gtb:20px">';
	foreach($newVisTaps as $k => $t ){
		$s='';
		if($k<$tap){$s='end';}
		if($k==$tap){$s='act';}
		$out.='<div class="f1 fs14" '.$t[0].' '.$s.'><div></div>'.$t[1].'</div>';
	}
	$out.='</div>';
	return $out;
}
function patForm(){
	$focus='focus';
	$out='<div class="visPatL">';
	if(_set_gypwynoss==1){
		$out.='<div class="lh30 f1 clr55 fs12">'.k_pat_num.' : </div>
		<div><input type="number" ser_p="p1" focus/></div>';
		$focus='';
	}
	$out.='<div class="lh30 f1 clr1111 fs12">'.k_name.' :</div>
	<div><input type="text" ser_p="p2" '.$focus.'/></div>
	<div class="lh30 f1 clr1111 fs12">'.k_l_name.' : </div>
	<div><input type="text" ser_p="p3" /></div>
	<div class="lh30 f1 clr1111 fs12">'.k_fth_name.' : </div>
	<div><input type="text" ser_p="p4" /></div>
	<div class="lh30 f1 clr1111 fs12">'.k_mothr_name.' : </div>
	<div><input type="text" ser_p="p6" /></div>
	<div class="lh30 f1 clr1111 fs12">'.k_mobile.' : </div>
	<div><input type="text" ser_p="p5" /></div>';
	if(_set_gypwynoss==2){
		$out.='<div class="lh30 f1 clr55 fs12">'.k_pat_num.' : </div>
		<div><input type="number" ser_p="p1" /></div>';
	}
	$out.='</div>';
	return $out;
}

function showDocBlc($mood,$doc,$docPhoto,$doctor,$docStatus,$cln){
    if($cln && $mood==4){$cln=' <span class="clr6 f1 ">[ '.$cln.' ]</span>';}else{$cln='';}
	return '<div class="fl fxg" fxg="gtc:60px 1fr" doc="'.$doc.'" done >
	<div class="r_bord pd10" i>'.$docPhoto.'</div>
	<div >
		<div class="fs14 f1 of lh40 clr1111 pd10">'.$doctor.$cln.'</div>
		<div class="pd10 fs12">'.$docStatus.'</div>
	</div>
	</div>';
}
function showMedRec($id){
	list($n1,$n2,$n3)=get_val('gnr_m_patients','f_name,ft_name,l_name',$id);
	$name=$n1.' '.$n2.' '.$n3;
	return '<div class="fr ic40x ic40_info icc1 br0" title="'.k_med_rec.'" onclick="pat_hl_rec(1,'.$id.',\''.$name.'\')"></div>';
}
function getItemMark($doc,$it_id,$d_s,$d_e){
	$n=0;	
	if(in_array($it_id,array(1,2,3,4,5))){
		$m_table=array('','cln_x_prev_com','cln_x_prev_dia','cln_x_prev_cln','cln_x_prev_str','cln_x_prev_not');
		$table=$m_table[$it_id];
		$sql="select visit from $table where  date>='$d_s' and date<'$d_e' and doc='$doc' group by visit ";
		$res=mysql_q($sql);
		$n=mysql_n($res);		
	}
	if($it_id==6){$n=getTotalCO('gnr_x_visit_end'," vis_date>='$d_s' and vis_date<'$d_e' and doc='$doc'");}
	if($it_id==7){$n=getTotalCO('gnr_x_prescription'," date>='$d_s' and date<'$d_e' and doc='$doc'");}
	if($it_id==8){$n=getTotalCO('cln_x_vital'," date>='$d_s' and date<'$d_e' and doc='$doc'");}
	return $n;
}
function presc_info_doctor($doc){
	global $lg;
	$arr=[		
		'name'=>'',
		'mobile'=>'',
		'specialization'=>''
	];
	$sql="select * from _users where id='$doc'";
	$res=mysql_q($sql);
	if($info_doc=mysql_f($res)){
		$sex_doc=$info_doc['sex'];		
		$name=$info_doc['name_'.$lg];
		$title=$info_doc['title_'.$lg];
		$arr['name']=$title.' '.$name;
		if($info_doc['mobile']){$arr['mobile']=$info_doc['mobile'];}
		if($info_doc['specialization_'.$lg]){
			$arr['specialization']=$info_doc['specialization_'.$lg];
		}
	}
	return $arr;
}
function visBalPay($vis,$mood){
    global $visXTables,$srvXTables;
    $dtsPay=0;
    if(proAct('dts') && $mood != 2){
        $dts_id=get_val($visXTables[$mood],'dts_id',$vis);
        if($dts_id){$dtsPay=DTS_PayBalans($dts_id,$vis,$mood);}
    }    
    $srvTotal=get_sum($srvXTables[$mood],'pay_net',"visit_id='$vis' and status=0 ");
    $in=get_sum('gnr_x_acc_payments','amount'," mood='$mood' and vis='$vis' and type IN(1,2,7) ");
    $out=get_sum('gnr_x_acc_payments','amount'," mood='$mood' and vis='$vis' and type IN(3,4)");
    return $srvTotal-($in-$out)-$dtsPay;
}
function visBalPayAlert($vis,$mood){
    global $visXTables,$srvXTables;
    $table=$visXTables[$mood];
    $table2=$srvXTables[$mood];    
    $p=get_val($visXTables[$mood],'patient',$vis);
    $all_add=get_sum($srvXTables[$mood],'pay_net',"visit_id='$vis' and status IN(2,5)");
    $all_del=get_sum($srvXTables[$mood],'pay_net',"visit_id='$vis' and status IN(3,4)");
    $all_insur=get_sum('gnr_x_insur_pay_back','amount',"visit='$vis' and patient='$p' ");				
    $balans=$all_add-$all_del-$all_insur;
    return $balans;
}
    
function savePatPayment($id,$mood,$type,$pay,$doc,$pt=1,$comm=0,$differ=0,$bank=0){
    global $thisUser,$now;
    if($type==1){
        $mood=4;
        $sql="INSERT INTO gnr_x_acc_payments (`type`,`vis`,`amount`,`casher`,`date`,`mood`,`pay_type`,`commi`,`differ`,`bank`) values (1,0,'$pay','$thisUser','$now','$mood','$pt','$comm','$differ','$bank')";
        mysql_q($sql);        
        $p_id=last_id();
        patient_payment($id,$mood,0,$pay,$p_id,$doc,0);
        fixPatintAcc($id);
        fixCasherData($thisUser);
        return 1;
    }
    if($type==2){
        $mood=4;
        $sql="INSERT INTO gnr_x_acc_payments (`type`,`vis`,`amount`,`casher`,`date`,`mood`,`pay_type`,`commi`,`differ`,`bank`) values (8,0,'$pay','$thisUser','$now','$mood','$pt','$comm','$differ','$bank')";
        mysql_q($sql);
        $p_id=last_id();
        patient_payment($id,$mood,2,$pay,$p_id,$doc,0);
        fixPatintAcc($id);
        fixCasherData($thisUser);
        return 1;
    }
    if($type==10){
        patient_payment($id,$mood,10,$pay,0,$doc,0);
        return 1;
    }
}
function rateing($id,$opr,$val,$mood){
    $out='';
    if($val){
        $out='<div class="fl ic30 ic30_info ic30Txt icc33" onclick="rateVis('.$id.','.$mood.')">التقييم <ff>( '.$val.' )</ff></div>';
    }else{
        $out='<div class="fl ic30 ic30_add ic30Txt icc11" onclick="rateVis('.$id.','.$mood.')">قييم الزيارة</div>';
    }
    return $out;
}
function minDocClinc($cln,$doc){
    $out=$cln;
    $r=getRec('_users',$doc);
    if($r['r']){
        $subgrp=$r['subgrp'];
        if($cln!=$subgrp){
            $linked=get_val('gnr_m_clinics','linked',$subgrp);//لتاكد من رابط العيادة
            if($linked==$cln){
                $out=$subgrp;                
            }
        }
    }
    return $out;
}
function paymentName($type,$id){
    global $lg;
    $out='';
    if($type==1){$out=get_val_arr('gnr_m_exemption_reasons','reason',$id,'pt1');}
    if($type==2){$out=get_val_arr('gnr_m_charities','name_'.$lg,$id,'pt2');}
    if($type==3){$out=get_val_arr('gnr_m_insurance_prov','name_'.$lg,$id,'pt3');}
    return $out;
}
function activeAppDiscount($mood,$vis,$srv=0){
    global $visXTables,$srvXTables;
    $set=str_replace("'",'"',_set_0ydmtuvd3x);
    $set=json_decode($set,true);
    list($disType,$disVal)=$set[$mood];
    if($disType && $disVal){
        $r=getRec($visXTables[$mood],$vis);
        if($r['r']){
            if($r['pay_type']==0 && ($r['app']==1 || $srv!=0)){
                $serTable=$srvXTables[$mood];
                $q='';
                if($srv){$q=" and id='$srv'";}
                $sql="select * from $serTable where visit_id='$vis' and offer=0 and total_pay>0 $q ";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                while($r=mysql_f($res)){
                    $id=$r['id'];
                    $hos_part=$r['hos_part'];
                    $doc_part=$r['doc_part'];
                    $total_pay=$r['total_pay'];
                    $doc_percent=$r['doc_percent'];
                    if($hos_part+$doc_part>0){
                        $docTotal=0;
                        if($doc_percent && $doc_part){
                            $docTotal=($doc_part*$doc_percent)/100;
                        }
                        $hstTotal=$total_pay-$docTotal;
                        $disCount=$disVal;
                        if($disType==1){
                            $disCount=($total_pay*$disVal)/100;
                        }

                        $hotDis=($hstTotal*$disCount)/$total_pay;
                        $docDis=$disCount-$hotDis;

                        //echo '('.$disCount.'-'.$hotDis.'-'.$docDis.')';
                        $hos_bal=$hstTotal-$hotDis;
                        $doc_bal=$docTotal-$docDis;
                        $pay_net=$total_pay-$disCount;
                        $sql="UPDATE $serTable SET 
                        doc_bal= '$doc_bal',
                        doc_dis= '$docDis',
                        hos_bal= '$hos_bal',
                        hos_dis= '$hotDis',
                        pay_net= '$pay_net',
                        app=1
                        where id='$id' ";
                        mysql_q($sql);
                        if($mood==4){
                            mysql_q("UPDATE den_x_visits_services_levels set price='$pay_net' where x_srv='$id' ");
                        }
                    }
                }                
            }
            $sql="UPDATE ".$visXTables[$mood]." SET app= 2 where id='$vis' ";
            mysql_q($sql);
        }
    }
}
function nurs_st($id){
    return '<div class="fr ic40 ic40_report icc1 ic40Txt mg10f br0" nurs_no="'.$id.'">إحصاءات</div>';
} 
function del_pay($id,$n){
    if($n==5){        
        $_SESSION['payDelID']=get_val('gnr_x_acc_patient_payments','payment_id',$id);        
    }else{
        $pay_id=$_SESSION['payDelID'];        
        mysql_q("DELETE from gnr_x_acc_payments where id='$pay_id'");        
        $_SESSION['payDelID']=0;
    }
}

?>