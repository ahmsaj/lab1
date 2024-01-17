<?/***DEN***/
function cavities($id,$opr,$filed,$val){	
	$out='';
	$valTxt=showCavText($val);
	if($opr=='add' || $opr=='edit'){
		$out.='<div class="ff fs18 clr1 uc lh40 w100 B TC" dir="ltr" id="cavTxt">'.$valTxt.'</div>';
		$out.='<input type="hidden" name="'.$filed.'" value="'.$val.'" required id="cavVal"/>';
		$out.='<div class="bu2 bu_t3 buu f1 fs14 clr5 Over TC" onclick="editCav('.$id.')">تحرير</div>';
	}
	if($opr=='list' || $opr=='view'){
		$out.='<div class="ff fs16 uc w100 B TC" dir="ltr">'.$valTxt.'</div>';
	}
	return $out;
}
function showCavText($val){
	global $cavCodes;
	if($val){
		for($i=count($cavCodes);$i>0;$i--){
			$val=str_replace("$i",$cavCodes[$i],$val);
		}
		$val=str_replace(',',' , ',$val);
		$val=str_replace('|',' | ',$val);
	}
	return $val;
}
function getPatDenOper($pat,$vis,$srv){
	global $lg,$denSrvS,$denSrvSCol,$thisUser;
	$out='';
	$selTeeth=0;	
	if($srv){
		$r=getRec('den_x_visits_services',$srv);		
		if($r['r']){
			$service=$r['service'];
			$teeth=$r['teeth'];
			$d_start=$r['d_start'];
			$status=$r['status'];
			$serviceTxt=get_val_arr('den_m_services','name_'.$lg,$service,'srv');
			
			$teethTxt='';
			if($teeth){
				$selTeeth=$teeth;
				$tt=explode(',',$teeth);
				$teethTxt.='<div class="cb w100 lh30 t_bord cbg7 clr1w">';
				foreach($tt as $ttt){$teethTxt.='<div class="fl clrw1 r_bord pd10 fs14 ff B ">'.$ttt.'</div>';}
				$teethTxt.='&nbsp;</div>';
			}
			
			$out.='
			<div class="fl w100 b_bord3">
				<div class="f1 fs18 clr5 lh30">'.$serviceTxt.'</div>				
				<div class="fl f1 lh30 '.$denSrvSCol[$status].'">'.$denSrvS[$status].'</div>
				<div class="fr ff fs16 B lh30 " dir="ltr">'.date('Y-m-d',$d_start).'</div>
				'.$teethTxt.'
			</div>
			<div class="lh10">&nbsp;</div>';
			
			//if($status==10){$out.='<div class="fl ic40 icc4 ic40_done" onclick=""></div>';}
			$levData=array();
			$sql="select * from den_x_visits_services_levels_w where x_srv='$srv' order by date ASC ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){				
				while($r=mysql_f($res)){
					$l_id=$r['id'];
					$date=$r['date'];
					$lev=$r['lev'];
					$x_lev=$r['x_lev'];
					$val=$r['val'];
					$l_status=$r['status'];
					//$docTxt=get_val_arr('_users','name_'.$lg,$doc,'dd');
					$desTxt=get_val_arr('den_m_services_levels_text','des',$val,'des');
					$levData[$x_lev]['end']=$r['end'];
					$levData[$x_lev]['d'].='					
					<div class="lh20 TJ desIn b_bord"><ff class="clr1 fs14">'.date('Y-m-d',$date).'</ff></br>'.nl2br($desTxt).'</div>';
				}
			}
			$sql="select * from den_x_visits_services_levels where x_srv='$srv' order by id ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){				
				while($r=mysql_f($res)){
					$id=$r['id'];
					$lev=$r['lev'];
					$lev_perc=$r['lev_perc'];
					$l_status=$r['status'];
					$serviceTxt=get_val('den_m_services_levels','name_'.$lg,$lev);
					$sTxt=k_new;					
					$sCbg='cbg3';
					if($l_status==1){$sTxt=k_inprgrss;$sCbg='cbg1';}
					if($l_status==2){$sTxt=k_level_done;$sCbg='cbg66';}
					$out.='
					<div l>
						<div b n="'.$id.'" class="'.$sCbg.' Over" >
							<div bb>'.$serviceTxt.'</div>
							<div class="f1 fs12 lh30 "><div class="fr ff fs16 lh30">%'.$lev_perc.'</div>'.$sTxt.'</div>
						</div>';
					if($levData[$id]){$out.='<div des><div>'.$levData[$id]['d'].'</div></div>';}
					$out.='</div>';					
				}
			}
		}
	}else{
		$sql="select * from den_x_visits_services where patient ='$pat' and (status=0 OR visit_id='$vis' ) order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			$out.='<div class="oprDen">';
			while($r=mysql_f($res)){
				$id=$r['id'];
				$service=$r['service'];
				$d_start=$r['d_start'];
				$status=$r['status'];
				$teeth=$r['teeth'];
				$serDoc=$r['doc'];
				$end_percet=$r['end_percet'];				$serviceTxt=get_val_arr('den_m_services','name_'.$lg,$service,'srv');
				list($s_ids,$subServ,$percet)=get_vals('den_m_services_levels','id,name_'.$lg.',percet'," service=$service",'arr');				
				$out.='<div a c'.$status.' no="'.$id.'">';
					if($status==0 && $serDoc==$thisUser){
					$out.='<div class="fr ic30x icc2 ic30_del" title="'.k_del_proce.'" onclick="denSrvDel('.$id.')"></div>';
					}
					$out.='<div s>'.$serviceTxt.'</div>';
					if($end_percet){$out.='<div class="fr ff B fs12 cbg66 pd5 clrw">%'.$end_percet.'</div>';}
					$out.='<div class=" f1 w100 lh30 '.$denSrvSCol[$status].'">'.$denSrvS[$status].'</div>';
					if($teeth){
						$tt=explode(',',$teeth);
						$out.='<div class="cb">';
						foreach($tt as $ttt){$out.='<div t>'.$ttt.'</div>';}
						$out.='</div>';
					}
					$out.='<div d>'.date('Y-m-d',$d_start).'</div>
				</div>';
			}
			$out.='</div>';
		}else{$out.='<div class="f1 fs14 lh40">'.k_no_ctin.' </div>';}
	}	
	$out.=script("mSelTeeth('".$selTeeth."');");
	return $out;
}
function fixDenServEnd($id){
	global $now;	
    list($service,$status,$teeth,$patient)=get_val('den_x_visits_services','service,status,teeth,patient',$id);	
	$endLevs=getTotalCO('den_x_visits_services_levels',"x_srv='$id' and status!=2 ");
	$q='';
	$newStatus=1;
	if($endLevs==0){$newStatus=2;}
	if($status!=$newStatus){
		$q=" , d_finish='$now' ";
		setEndStatus($id,$service,$teeth);
	}
	$end_percet=get_sum('den_x_visits_services_levels','lev_perc'," x_srv='$id' and status=2 ");
	mysql_q("UPDATE den_x_visits_services SET status='$newStatus' , end_percet='$end_percet' $q where id='$id' ");
    fixPatAccunt($patient);
}
function setEndStatus($id,$service,$teeth){
	global $now;
	if($teeth){
		$tooth=explode(',',$teeth);
		list($teeth_s,$root_s)=get_val('den_m_services','teeth_status,root_status',$service);
		if($teeth_s){
			$t=1;
			$opr_type=get_val('den_m_set_teeth','opr_type',$teeth_s);
			$vis=get_val('den_x_visits_services','visit_id',$id);
			list($doctor,$patient)=get_val('den_x_visits','doctor,patient',$vis);
			foreach($tooth as $n){				
				if($opr_type==1){
					mysql_q("UPDATE den_x_opr_teeth SET `last_opr`=0 where `patient`='$patient' and `teeth_no`='$n' and teeth_part=$t");
					$sql="INSERT INTO den_x_opr_teeth (visit,doctor,patient,teeth_no,teeth_part,opr_type,opr,teeth_part_sub,date,last_opr,cav_no)
					values('$vis','$doctor','$patient','$n','$t',1,'$teeth_s',0,'$now',1,0)";
					mysql_q($sql);
				}else{
					
				}
			}
		}
		if($root_s){
			$t=2;
			$opr_type=get_val('den_m_set_roots','opr_type',$root_s);
			$vis=get_val('den_x_visits_services','visit_id',$id);
			list($doctor,$patient)=get_val('den_x_visits','doctor,patient',$vis);
			foreach($tooth as $n){				
				if($opr_type==1){
					mysql_q("UPDATE den_x_opr_teeth SET `last_opr`=0 where `patient`='$patient' and `teeth_no`='$n' and teeth_part=$t");
					$sql="INSERT INTO den_x_opr_teeth (visit,doctor,patient,teeth_no,teeth_part,opr_type,opr,teeth_part_sub,date,last_opr,cav_no)
					values('$vis','$doctor','$patient','$n','$t',1,'$root_s',0,'$now',1,0)";
					mysql_q($sql);
				}else{
					
				}
			}
		}
	}
}
function patDenPay($p,$doc=0){
	$q='';
	if($doc){$q=" and doc='$doc' ";}
	$in=get_sum('gnr_x_acc_patient_payments','amount',"patient='$p' $q and mood=4 and type in(0,1,3,4,5)");
	$out=get_sum('gnr_x_acc_patient_payments','amount',"patient='$p' $q and mood=4 and type in(2)");
	return $in-$out;
}
function getCavNo($teeth,$r){
	$n=1;
	$cav=get_val_c('den_m_teeth','cavities',$teeth,'no');
	if($cav){
		$c=explode('|',$cav);		
		if($c[$r]){
			$cc=explode(',',$c[$r]);
			$n=count($cc);
		}
	}
	return $n;
}
function getArrKey($arr,$v){
	$out='';
	foreach($arr as $k=>$val){
		if($val==$v){$out=$k;}
	}
	return $out;
}
function selTDir($d,$n,$sn){
	if($sn==3){
		$dir='bottom';		
		if(in_array($d,array(1,2,5,6))){$dir='top';}
	}
	if($sn==4){
		$dir='right';		
		if(in_array($d,array(2,3,6,7))){$dir='left';}
	}
	if($sn==5){
		$dir='left';		
		if(in_array($d,array(2,3,6,7))){$dir='right';}
	}
	if($sn==7){$dir='top';}
	if($sn==6){$dir='bottom';}
	
	return $dir;
}
function chDenSrvLev($id){
	$percet=get_sum('den_m_services_levels','percet',"service='$id'");
	if($percet==100){return 1;}else{return 0;}
}
function fixDenLevPrices($srv){
	list($hos_part,$doc_part,$doc_percent)=get_val('den_x_visits_services','hos_part,doc_part,doc_percent',$srv);
    $pay=$hos_part+$doc_part;
	$sql="select * from den_x_visits_services_levels where x_srv='$srv' ";
	$res=mysql_q($sql);
	while($r=mysql_f($res)){
		$lev_id=$r['id'];
		$lev_perc=$r['lev_perc'];
        $l_doc_part=0;        
		$levelPrice=0;
		if($lev_perc>0){
			$levelPrice=$pay/100*$lev_perc;
			//$newPrice=($doc_part*$lev_perc)/100;
			
			if($hos_part){
				$doclevelPrice=$doc_part/100*$lev_perc;
				$l_doc_part=($doclevelPrice*$doc_percent)/100;
				
			}else{
				$l_doc_part=($levelPrice*$doc_percent)/100;
			}
		}
		mysql_q("UPDATE den_x_visits_services_levels SET price='$levelPrice' , doc_prec='$doc_percent' ,doc_part='$l_doc_part' where id='$lev_id' ");
	}
}
function patDenBal($pat,$doc=''){
	$q='';
	if($doc){$q="and doc='$doc'";}
	$in =get_sum('gnr_x_acc_patient_payments','amount',"patient='$pat' and mood=4 and type in(0,1,3,4) $q");
	$out=get_sum('gnr_x_acc_patient_payments','amount',"patient='$pat' and mood=4 and type in(2) $q");
	return $in-$out;
}
/******************New********************/
function selSrvs_den($vis,$c,$doc,$pat,$dts_id=0){
    global $denDateTimes;
    $mood=4;
    $out='<div class="f1 fs16 uLine clr66 lh50 w100 pd10">أختر مدة الموعد</div>
        <div class="pd10">';
        foreach($denDateTimes as $dd){
            $bg='icc11';
            if($dd==30){$bg='icc33';}
            $out.='<div class="bu fl br5 '.$bg.'" teethTime="'.$dd.'" ><ff>'.minToHour($dd).'</ff></div>';
        }
    $out.='</div>';
    return $out;
}
function den_selSrvs_save($vis_id,$pat,$doc){
	global $now,$thisUser,$visXTables,$srvXTables,$srvTables;
	$mood=4;
	$vTable=$visXTables[$mood];
	$sTable=$srvXTables[$mood];
	$smTable=$srvTables[$mood];
    $cln=get_val('_users','subgrp',$doc);
	if($vis_id==0){
		$new_pat=isNewPat($pat,$doc,$mood);
		$sql="INSERT INTO $vTable(`patient`,`clinic`,`d_start`,`reg_user`,`doctor`,`new_pat`)values ('$pat','$cln','$now','$thisUser','$doc','$new_pat')";
        if(mysql_q($sql)){
            return last_id();
        }
							
	}else{
        $sql="UPDATE $vTable SET `clinic`='$cln',`doctor`='$doc' where id='$vis_id'";    
        if(mysql_q($sql)){			
            return $vis_id;
        }
    }
}
function den_selSrvsSta($vis){
	global $f_path,$lg,$bupOffer,$payStatusArrRec,$reqStatusArr,$insurStatusColArr,$now;	
	$mood=1;
	$editable=1;
    $out='';
	$sql="select * from den_x_visits where id='$vis' ";
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
		$emplo=$r['emplo'];
        $consulPay=_set_lbza344hl;
        $consulPayTxt='';
        if($consulPay){
            //$consulPayTxt=' : <ff>'.$total2.'</ff> '.k_sp;
        }        
        $patVisSta='<div class="f1 fs14 clr5 pd10f br5 mg5f">إنها الزيارة الأولى للمريض</div>';
        $visDate=get_val_con('den_x_visits','d_start',"id!='$vis' and patient='$patient' and status=2"," order by d_start DESC");
        if($visDate){
            $patVisSta='<div class="f1 fs14 clr2 pd10f br5 TC cbg555 mg5f bord">تاريخ أخر زيارة : <span dir="ltr" class="f1 B fs16">'.date('Y-m-d',$visDate).'</span>
            <span class="f1 fs14 clr55">( منذ '.timeAgo($now-$visDate,' | ').' )</span>
            </div>';
        }
		list($c_name,$mood)=get_val('gnr_m_clinics','name_'.$lg.',type',$clinic);
		$out.='<div class="fl w100 ofx so pd10 fxg fxg-als-c">
            <div class="cbgw pd20f mgA bord br5 denActC" >                
                <div class="f1 fs16 lh40 pd10v TC">أختر نوع الزيارة</div>
                <div class="fxg" fxg="gtc:1fr 1fr">
                    <div class="f1 bord clrw pd10f mg5f icc11 lh40 fs16 TC br5" denAct="1">'.k_treatment_session.'</div>
                    <div class="f1 bord clrw pd10f mg5f icc22 lh40 fs16 TC br5" denAct="2">'.k_consultation.$consulPayTxt.'</div>
                </div>
                '.$patVisSta.'
            </div>
		</div>';
        $out.=visStaPayFot($vis,$mood,0,0,1);
    	
	}
    if($rows==0 || $status>0){
        delTempOpr($mood,$vis,'a');
		$out.= script("closeRecWin();");
    }
	return $out;
}
function den_recAlert($vis,$balans,$alert_id,$alert_status){
    global $visXTables,$srvXTables,$srvTables,$ser_status_Tex,$ser_status_color,$pay_types,$payStatusArrRec,$reqStatusArr,$payStatusArrRecClr,$insurStatusColArr,$lg;
    $mood=4;$out='';
    $table2=$srvXTables[$mood];
    $r=getRec($visXTables[$mood],$vis);
    if($r['r']){
        $pat=$r['patient'];
        $clinic=$r['clinic'];
        $doc=$r['doctor'];
        $pay_type=$r['pay_type'];
        $app=$r['app'];
        if($app){
            $sql="select id,service from den_x_visits_services where visit_id='$vis' ";
            $res=mysql_q($sql);
            while($r=mysql_f($res)){
                $s_id=$r['id'];
                $service=$r['service'];
                if(get_val('den_m_services','consul',$service)){                    
                    activeAppDiscount($mood,$vis,$s_id);
                }
            }            
        }
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
                        <div class=" lh30 f1 fs12 ">'.k_clinic.' : '.$cnlicName.'</div>
                        '.$docTxt.'
                    </div>
                    <div>';
                    if($pay_type==0){
                        if(ex_cubon($mood)){$out.='<div class="pay_icon icc84 ic40_offer fs16 Over" cubon>صرف كوبون</div>';}
                        if(_set_rkq2s40u5g){$out.='<div class="pay_icon icc83 ic40_insr fs16 Over" payT="3">طلب تأمين</div>';}
                        if(_set_n5ks40i6j8){$out.='<div class="pay_icon icc82 ic40_char fs16 Over" payT="2">طلب جمعية</div>';}
                        if(_set_hw3wi89dnk){$out.='<div class="pay_icon icc81 ic40_exem fs16 Over" payT="1">طلب إعفاء</div>';}
                        $out.='
                        <div class="hide" id="payMsgAl">
                            <div class="fxg" fxg="gtc:1fr 1fr|grs:2|gap:10px ">
                                <div class="f1 fs14 lh40 fxg hide" fxg="gcs:2" id="payMsg">طلب تأمين</div>
                                <div class="f1 clrw lh40 icc4 fs16 Over TC" ptBut1>تأكيد</div>
                                <div class="f1 clrw lh40 icc2 fs16 Over TC" ptBut2>الغاء</div>
                            </div>
                        </div>';
                    }else{
                        $out.='
                        <div class="f1 fs14 lh30">نوع الطلب : <span class="f1 fs14 clr1">'.$pay_types[$pay_type].'</span></div>
                        ';
                    }
                $out.='</div>
                </div>
            </div>
            <div class="ofx so pd10f b_bord">';
                /*****************/
                $srvs=get_sum('den_x_visits_services','pay_net',"patient='$pat'");
                $lastPay=patDenPay($pat);
                $bal=$srvs-$lastPay;
                //$r=mysql_f($res);        
                if($balans>0){$text=k_pat_shld_pay;$c="4";}
                if($balans<0){$text=k_ret_amnt_to_pat;$c="3"; $balans=$balans*(-1);}
                if($balans==0){$text=k_pat_shld_pay;$c="4";}
                $docs=get_vals($table2,'doc',"patient='$pat'");
                if($docs && $doc){
                    $docs.=','.$doc;
                }
                $dosList='لا يوجد أطباء';
                if($docs){
                    $dosList= make_Combo_box('_users','name_'.$lg,'id'," where id IN($docs)",'docs',1,$doc,'t');
                }
                $out.='
                <div class="f1 fs16 lh40 clr11 uLine">
                    <div class="fr ic30 ic30_price icc33 ic30Txt" patAcc="'.$pat.'">كشف حساب</div>'.k_pat_balance.'
                </div>';
                $sql="select * from den_x_visits_services where visit_id='$vis' order by d_start DESC";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                $t1=$t2=$t3=0;
                $srvData='';
                if($rows>0){                    
                    while($r=mysql_f($res)){
                        $service=$r['service'];
                        $total_pay=$r['total_pay'];
                        $d_start=$r['d_start'];
                        $end_percet=$r['end_percet'];
                        $srvTxt=get_val_arr('den_m_services','name_'.$lg,$service,'s');
                        $srvNet=0;
                        if($end_percet){$srvNet=$total_pay*$end_percet/100;}
                        $t1+=$total_pay;
                        $t2+=$end_percet;
                        $t3+=$srvNet;
                        $srvData.='<div class="w100 lh30 f1">'.$srvTxt.' |<ff14 class="clr1"> '.number_format($total_pay).'</ff14></div>';                        
                    }
                }else{
                    $srvData.='<div class="f1 fs14 clr5 lh40">'.k_no_srvcs.'</div>';
                }
                $out.='
                <table  border="0" cellspacing="0" cellpadding="4" type="static" class="grad_s2">
                    <tr class="cbg4">
                        <td class="f1 pd10"  width="120">'.k_visit_srvcs.' : </td>
                        <td class="TC f1 fs12" width="420">'.$srvData.'</td>
                    </tr>
                    <tr>
                        <td class="f1 pd10">'.k_val_srvs.' : </td>
                        <td class="TC " ><ff class="clr1">'.number_format($srvs).'</ff></td>
                    </tr>	';
                 $dis=get_sum('den_x_visits_services','doc_dis+hos_dis',"visit_id='$vis' and app=1");
                 if($dis){
                     $out.='<tr>
                        <td class="f1 pd10">حسم موعد التطبيق : </td>
                        <td class="TC " ><ff class="clr5">'.number_format($dis).'</ff></td>
                     </tr>';
                 }
                 $out.='<tr>
                        <td class="f1 pd10">'.k_prev_pays.'  :</td>
                        <td class="TC "><ff class="clr5">'.number_format($lastPay).'</ff></td>
                    </tr>
                    <tr>
                        <td class="f1 pd10">'.k_balance.' :</td>
                        <td class="TC "><ff class="clr6">'.number_format($bal).'</ff></td>
                    </tr>
                    <tr>
                        <td class="f1 pd10">'.k_proposed_amount_by_doc.'  :</td>
                        <td class="TC cbg666"><ff>'.number_format($balans-$dis).'</ff></td>
                    </tr>
                    <tr>
                        <td class="f1 pd10">'.k_dr.' :</td>
                        <td class="TC">'.$dosList.'</td>
                    </tr>';
                    $bankPay=get_sum('gnr_x_acc_payments','amount',"mood='$mood' and vis='$vis' and pay_type=2 and type=1");
                    if($bankPay){
                        $balans-=$bankPay;
                        $out.= '<tr class="cbg444">
                            <td class="f1 fs12">دفعات الكترونية</td>                            
                            <td class="TC"><ff class="clr5">'.number_format($bankPay).'</ff></td>
                        </tr>';
                    }
                    $out.='</table>             
            </div>
            <div class="cbg4">'.visStaPayAlertFot($alert_id,$vis,$mood,$balans-$dis,$alert_status).'</div>
        </div>';
    }
    return $out;
}
function den_ticket($r){
	global $lg,$ser_status_Tex,$srvXTables,$srvTables;	
	$mood=4;
    $out='';
    $srvTable=$srvXTables[$mood];
    $srvMTable=$srvTables[$mood];
	if($r['r']){
        $vis=$r['id'];
		$vis_status=$r['status'];
        $pat=$r['patient'];
						     
        $visChanges=getTotalCo($srvTable,"visit_id='$vis' and status IN(2,4)");
		$out.='<div class="fl w100 ofx so pd10 " >';	
		$sql="select * from $srvTable where visit_id='$vis' order by id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){            
            $srv_all=get_sum('den_x_visits_services_levels','price',"patient='$pat' ");
            $srv_done=get_sum('den_x_visits_services_levels','price',"patient='$pat' and status=2 ");
            $payments=patDenBal($pat);
            $balans=$srv_done-$payments;
			//$serviceNames=get_vals($srvMTable,'name_'.$lg,"id IN($serviceX)",' - ');
            $out.='
                <table class="grad_s2 cbgw mg10v mgA TC" cellpadding="4" cellspacing="0" width="100%">
                <tr><td class="f1 pd10">قيمة الخدمات</td>
                <td class="TC"><ff>'.number_format($srv_all).'</ff></td></tr>

                <tr><td class="f1 pd10">قيمة الخدمات المنجزة</td>
                <td class="TC"><ff>'.number_format($srv_done).'</ff></td></tr>                
                
                <tr><td class="f1 pd10">الدفعات</td>
                <td class="TC cbg666 "><ff class=" clr6 ">'.number_format($payments).'</ff></td></tr>
                
                <tr><td class="f1 pd10">الرصيد</td>
                <td class="TC  "><ff class="  ">'.number_format($balans).'</ff></td></tr>
            </table>';      
		}
		$out.='</div>'; 
        $out.=visTicketFot($vis,$mood,$vis_status,$balans,$pat);
	}
    return $out;
}
function changeSrvPrice($id,$price,$new=0){
    global $thisUser,$thisGrp,$ss_day;
    $p=$price;
    $r=getRec('den_x_visits_services',$id);
    if($r['r']){
        $doc=$r['doc'];
		if(!$doc){$doc=$thisUser;}
        $visit_id=$r['visit_id'];
        $service=$r['service'];
        $clinic=$r['clinic'];
        $total_pay=$r['total_pay'];
        $hos_part=$r['hos_part'];
        $doc_part=$r['doc_part'];
        $d_start=$r['d_start'];
        $doc_percent=$r['doc_percent'];
        $editOpr=1;		
        if(_set_nukjs8og6f==0){$editOpr=0;}
        if(_set_nukjs8og6f==1){if($d_start<$ss_day){$editOpr=0;}}

        $n_hos_part=$hos_part;
        $n_doc_part=$price-$hos_part;
        
        if($editOpr==1){
            list($hos_part,$doc_part)=get_val('den_m_services','hos_part,doc_part',$service);
            //$p=$hos_part+$doc_part;            
            $newPrice=get_docServPrice($thisUser,$service,4);            
            if($newPrice[3]){
                $newP=$newPrice[0]+$newPrice[1];
                $doc_percent=$newPrice[2];
                if($newP){      
                    $n_hos_part=$newPrice[0];
                    $n_doc_part=$newPrice[1];
                    $p=$newP;

                    if($total_pay!=$newP){
                        $n_doc_part=$price-$n_hos_part;
                    }            
                    $p=$n_doc_part+$n_hos_part;
                }
            }            
        }else{
            $p=$hos_part+$doc_part;
            $n_doc_part=$doc_part;
			$newPrice=get_docServPrice($doc,$service,4); 			
            if($newPrice[3]){				
                $newP=$newPrice[0]+$newPrice[1];
                $doc_percent=$newPrice[2];
                if($newP){      
                    $n_hos_part=$newPrice[0];
                    $n_doc_part=$newPrice[1];
                    $p=$newP;

                    if($total_pay!=$newP){
                        $n_doc_part=$newP-$n_hos_part;
                    }            
                    $p=$n_doc_part+$n_hos_part;
                }
            }
			$new=1;
        }
        if($editOpr || $new){
            $status=$r['status'];
            if(($doc==$thisUser && $status!=2)||$thisGrp=='hrwgtql5wk'){
                if($doc){priceDiff($id,$visit_id,$service,$clinic,$doc,$p);}              
                if(mysql_q("UPDATE den_x_visits_services SET pay_net='$p' , total_pay='$p' , hos_part='$n_hos_part' , doc_part='$n_doc_part', doc_percent='$doc_percent' where id='$id' ")){
                    //echo "UPDATE den_x_visits_services SET pay_net='$p' , total_pay='$p' , hos_part='$n_hos_part' , doc_part='$n_doc_part', doc_percent='$doc_percent' where id='$id' ";
                    fixDenLevPrices($id);
                    return 1;
                }
            }
        }
    }
}
function changeSrvPriceAcc($id,$price){
    global $thisUser,$thisGrp,$ss_day;
    $p=$price;
    $r=getRec('den_x_visits_services',$id);
    if($r['r']){
        $doc=$r['doc'];
		if(!$doc){$doc=$thisUser;}
        $visit_id=$r['visit_id'];
        $service=$r['service'];
        $clinic=$r['clinic'];
        $total_pay=$r['total_pay'];
        $hos_part=$r['hos_part'];
        $doc_part=$r['doc_part'];
        $d_start=$r['d_start'];
        $doc_percent=$r['doc_percent'];
        $editOpr=1;		
        if(_set_nukjs8og6f==0){$editOpr=0;}
        if(_set_nukjs8og6f==1){if($d_start<$ss_day){$editOpr=0;}}

        $n_hos_part=$hos_part;
        $n_doc_part=$price-$hos_part;
        
        if($editOpr==1){
            list($hos_part,$doc_part)=get_val('den_m_services','hos_part,doc_part',$service);
            //$p=$hos_part+$doc_part;            
            $newPrice=get_docServPrice($doc,$service,4);            
            if($newPrice[3]){
                $newP=$newPrice[0]+$newPrice[1];
                $doc_percent=$newPrice[2];
                if($newP){      
                    $n_hos_part=$newPrice[0];
                    $n_doc_part=$newPrice[1];
                    $p=$newP;

                    if($total_pay!=$newP){
                        $n_doc_part=$price-$n_hos_part;
                    }            
                    $p=$n_doc_part+$n_hos_part;
                }
            }            
        }
        
		$status=$r['status'];
		//if($status!=2){
			priceDiff($id,$visit_id,$service,$clinic,$thisUser,$p);
			if(mysql_q("UPDATE den_x_visits_services SET pay_net='$p' , total_pay='$p' , hos_part='$n_hos_part' , doc_part='$n_doc_part', doc_percent='$doc_percent' where id='$id' ")){
				//echo "UPDATE den_x_visits_services SET pay_net='$p' , total_pay='$p' , hos_part='$n_hos_part' , doc_part='$n_doc_part', doc_percent='$doc_percent' where id='$id' ";
				fixDenLevPrices($id);
				return 1;
			}
		//}
        
    }
}
function priceDiff($xSrv,$vis,$srv,$clinic,$doc,$price){
    global $now;
    list($hos_part,$doc_part)=get_val('den_m_services','hos_part,doc_part',$srv);
    $orgPrice=$hos_part+$doc_part;
    $sql='';
    $recId=get_val_con('den_x_visits_services_price_diff','id',"visit_id='$vis' and x_srv='$xSrv'");
    if($orgPrice!=$price){
        
        $diff=$price-$orgPrice;
        if($recId){
            $sql="UPDATE den_x_visits_services_price_diff SET org_price='$orgPrice' ,new_price='$price' ,date='$now' ,diff='$diff' where id='$recId' ";
        }else{
            $sql="INSERT INTO den_x_visits_services_price_diff (x_srv,visit_id,clinic,doc,service,org_price,new_price,diff,date) values ('$xSrv','$vis','$clinic','$doc','$srv','$orgPrice','$price','$diff','$now')";
        }
    }else{
        if($recId){$sql="DELETE from den_x_visits_services_price_diff where id='$recId'";}
    }
    if($sql){mysql_q($sql);}
}
function loadTeeth($n){
    global $oprStatus,$teethDaArr,$thethCodes,$facCodes,$lg; 
    $type=1;
    $opr=0;
    $clr=$clrTxt=$name=$nameTxt='';    
    $r=$oprStatus['1-'.$type.'-'.$n];
    if($r){
        $opr=$r['opr'];
        $clr=$teethDaArr[$type.'-1-'.$opr]['color'];        
        $name=$teethDaArr[$type.'-1-'.$opr]['name_'.$lg];        
        if($clr){$clrTxt='style="background-color:'.$clr.';"';}
        if($name){$nameTxt='title="'.$name.'"';}
    }
    $tCode=strtolower($thethCodes[$n]['t_code']);
    $tPos=$thethCodes[$n]['pos'];
    $c=$tCode[1];
    $l='d';$r='m';
    if($tPos==2 || $tPos==3){$r='d';$l='m';}
    if($tPos==1 || $tPos==2 ){
        $t=$tCode[0];
        $b=$tCode[2];
    }else{
        $t=$tCode[2];
        $b=$tCode[0];
    }
    
    //----top
    $t_face=getArrKey($facCodes, $t);    
    $t_faceRec=$oprStatus['2-'.$type.'-'.$n.'-'.$t_face];    
    if($t_faceRec){
        $opr=$t_faceRec['opr'];
        $t_clr=$teethDaArr[$type.'-2-'.$opr]['color'];        
        $t_name=$teethDaArr[$type.'-2-'.$opr]['name_'.$lg]; 
        if($t_clr){$t_clrTxt='style="background-color:'.$t_clr.';"';}
        if($t_name){$t_nameTxt='title="'.$t_name.'"';}
    }
    //----Bottom
    $b_face=getArrKey($facCodes, $b);    
    $b_faceRec=$oprStatus['2-'.$type.'-'.$n.'-'.$b_face];    
    if($b_faceRec){
        $opr=$b_faceRec['opr'];
        $b_clr=$teethDaArr[$type.'-2-'.$opr]['color'];        
        $b_name=$teethDaArr[$type.'-2-'.$opr]['name_'.$lg]; 
        if($b_clr){$b_clrTxt='style="background-color:'.$b_clr.';"';}
        if($b_name){$b_nameTxt='title="'.$b_name.'"';}
    }
    //----Center
    $c_face=getArrKey($facCodes, $c);    
    $c_faceRec=$oprStatus['2-'.$type.'-'.$n.'-'.$c_face];    
    if($c_faceRec){
        $opr=$c_faceRec['opr'];
        $c_clr=$teethDaArr[$type.'-2-'.$opr]['color'];        
        $c_name=$teethDaArr[$type.'-2-'.$opr]['name_'.$lg]; 
        if($c_clr){$c_clrTxt='style="background-color:'.$c_clr.';"';}
        if($c_name){$c_nameTxt='title="'.$c_name.'"';}
    }
    //----Left
    $l_face=getArrKey($facCodes, $l);    
    $l_faceRec=$oprStatus['2-'.$type.'-'.$n.'-'.$l_face];    
    if($l_faceRec){
        $opr=$l_faceRec['opr'];
        $l_clr=$teethDaArr[$type.'-2-'.$opr]['color'];        
        $l_name=$teethDaArr[$type.'-2-'.$opr]['name_'.$lg]; 
        if($l_clr){$l_clrTxt='style="background-color:'.$l_clr.';"';}
        if($l_name){$l_nameTxt='title="'.$l_name.'"';}
    }
    //----Right
    $r_face=getArrKey($facCodes, $r);    
    $r_faceRec=$oprStatus['2-'.$type.'-'.$n.'-'.$r_face];    
    if($r_faceRec){
        $opr=$r_faceRec['opr'];
        $r_clr=$teethDaArr[$type.'-2-'.$opr]['color'];        
        $r_name=$teethDaArr[$type.'-2-'.$opr]['name_'.$lg]; 
        if($r_clr){$r_clrTxt='style="background-color:'.$r_clr.';"';}
        if($r_name){$r_nameTxt='title="'.$r_name.'"';}
    }
    $out='
    <div t="'.$n.'" s="'.$opr.'" '.$clrTxt.' '.$nameTxt.'>
        <div c></div>
        <div '.$t_clrTxt.' '.$t_nameTxt.'></div>
        <div c></div>
        <div '.$l_clrTxt.' '.$l_nameTxt.'></div>
        <div '.$c_clrTxt.' '.$c_nameTxt.' n>'.$n.'</div>
        <div '.$r_clrTxt.' '.$r_nameTxt.'></div>
        <div c></div>
        <div '.$b_clrTxt.' '.$b_nameTxt.'></div>
        <div c></div>
    </div>';
    return $out;
}
function loadRoot($n){
    global $oprStatus,$rootDaArr,$thethCodes,$tsfc,$lg,$trno,$tun,$cavCodes;
    $type=2;
    $opr=0;
    $clr=$clrTxt=$name=$nameTxt='';
    $r=$oprStatus['2-'.$type.'-'.$n]; 
    $teethDaArr=array();   
    if($r){
        $opr=$r['opr'];
        $clr=$rootDaArr[$type.'-1-'.$opr]['color'];        
        $name=$rootDaArr[$type.'-1-'.$opr]['name_'.$lg]; 
        
        $opr=$r['opr'];
        $clr=$teethDaArr[$type.'-1-'.$opr]['color'];        
        $name=$teethDaArr[$type.'-1-'.$opr]['name_'.$lg];        
        if($clr){$clrTxt='style="background-color:'.$clr.';"';}
        if($name){$nameTxt='title="'.$name.'"';}
    }
    $p=$thethCodes[$n]['pos'];
    $roNo=$trno[$tun[$n]];    
    $TheethRoots='';    
    if($tsfc['2-'.$n]){
        $tsArr=$tsfc['2-'.$n];
        $tfStyles='';						
        $rpc=0;
        foreach($tsArr as $k => $ts){
            $oprType=$tsArr[$k]['opr_type'];
            $oprType_o=$tsArr[$k]['opr'];
            $rpc=$tsArr[$k]['cav_no'];
            $part_sub=$tsArr[$k]['teeth_part_sub'];            
            $opr=$tsArr[$k]['opr'];
            $rColor=$rootDaArr[$type.'-2-'.$oprType_o]['color'];
            $rName=$rootDaArr[$type.'-2-'.$oprType_o]['name_'.$lg];
            
            if($oprType==1){								
                //$bgColr=' background-color:'.$oprDataArr[$oprType_o]['color'].';';
                //$t_status=$oprDataArr[$oprType_o]['name'];
                //$bg=$bgColr;
                $rIc='style="background-color:'.$clr.'" title="'.$name.'"';
            }
            if($oprType==2){							
                $rIc='style="background-color:'.$rColor.'" title="'.strtoupper($cavCodes[$part_sub]).'-'.$rName.'"';
            }
            $TheethRoots.='<div ER="1" '.$rIc.'></div>';
        }						
        if($rpc>count($tsArr)){
            for($ii=count($tsArr);$ii<$rpc;$ii++){
                if($oprType==1){
                    $TheethRoots.='<div ER="0" '.$rIc.'></div>';
                }else{
                    $TheethRoots.='<div ER="0"></div>';
                }
            }
        }
        if($tfStyles){$bodrColr='style="'.$tfStyles.'"';}						
    }else{
        for($r=1;$r<=$roNo;$r++){	
            $TheethRoots.='<div ER="0"></div>';
        }
    }
    $out='<div r="'.$n.'" s="'.$opr.'" '.$clrTxt.' '.$nameTxt.'>'.$TheethRoots.'</div>';
    return $out;
}
function den_medical_history($pat,$name){
	global $align,$visStatus;
	$tools='';
    $patHis=getTotalCo('cln_x_medical_his',"patient='$pat'");
    if($patHis){
        $out='        
        <div class=" w100 fxg pd10f" fxg="gtc:1fr 1fr 1fr|gtc:1fr 1fr:1100|gtc:1fr:900|gap:10px"   >'.den_view_his_item($pat).'</div>
        <div>
            <div class="fl lh20 w100 pd10 t_bord cbg7">
                <div class="fl cbg5 hidCb"></div>
                <div class="fl clr5 f1  pd10 lh30">'.k_critical.'</div>
                <div class="fl cbg9 hidCb"></div>
                <div class="fl clr9 f1  pd10 lh30">'.k_inactive.'</div>
            </div>
        </div>		
        ';
    }else{
        echo '<div class="f1  clr5 pd10f">لا يوجد سوابق مرضية مدخلة</div>';
    }
	return $out;
}
function den_view_his_item($pat){
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
            <div class="fl pa cbg4 w100  oprDenH hide pd5f h100 br5" >
                <div class="fl i30 i30_edit" edthisD="'.$id.'" title="تحرير"></div>
                <div class="fl i30 i30_del" delhisD="'.$id.'" title="حذف"></div>
            </div>';
		}
		$med_txt='<div class="fl w100 b_bord pd5v pr">
            <div t '.$act.' '.$alrt.' class="clr2 lh20 f1">
                '.get_val('cln_m_medical_his','name_'.$lg,$med_id).$numTxt.$yearTxt.'
            </div>
        </div>';
        $data[$cat].='<div mhit no="'.$id.'" class="clr9 pr">'.$butts.$med_txt.$dateData.$notTxt.'</div>';
	}
	$c=count($data);	
	ksort($data);
	foreach($data as $k=>$d){
		$out.='<div class="fl  bord cbg8188 br5">
			<div class="f1 clr2 lh40 b_bord cbg7 pd10 br5" >
                '.get_val('cln_m_medical_his_cats','name_'.$lg,$k).'
            </div>
			<div class="fl w100 pd10f">'.$d.'</div>
		</div>';
	}
	return $out;
}
function fixLevelsPrice($srv){
    $total_pay=get_val('den_x_visits_services','total_pay',$srv);
    $levels=get_sum('den_x_visits_services_levels','price',"x_srv='$srv'");
    if($total_pay!=$levels){
        mysql_q("UPDATE den_x_visits_services_levels SET price=($total_pay/100*lev_perc) where x_srv='$srv'");
    }
}
/************************/
function denClincal($id,$opr,$filed,$val){
    $out='';
    //echo $val=addslashes($val);
    $type=get_val('den_m_prv_clinical_items','type',$id);
    $val=str_replace('"',"'",$val);
    if($opr=='add' || $opr=='edit'){
        $out='<div id="denCalSet" f="'.$filed.'">'.getDCV($type,$filed,$val).'</div>';
    }
    if($opr=='list' || $opr=='view'){
        $out='<div>'.getDCVeiw($type,$filed,$val).'</div>';
    }
    return $out;
}
function getDCV($type,$fil,$val){
    $out='';
    switch ($type){
        case 1:
            $sel='';
            if($val==2){$sel='selected';}
            $out='<select name="'.$fil.'" require>
                <option value="1">عنوان مستوى 1</option>
                <option value="2" '.$sel.'>عنوان مستوى 2</option>
            </select>';             
        break;
        case 2:
            $sel='';
            if($val==2){$sel='selected';}
            $out='<select name="'.$fil.'" require>
                <option value="1">نص عادي</option>
                <option value="2" '.$sel.'>نص كبير</option>
            </select>';
        break;
        case 3:
            $sel='';
            if($val==1){$sel='checked';}
            $out='<div class="lh40 f1 bord "><input type="checkbox" name="'.$fil.'" value="1" '.$sel.'/>  نص إضافة 
                </div>';
        break;
        case 4:
            $sel='';            
            $out='<div class="lh30 f1 fs12 clrw br5 Over icc1 in TX pd10 mg10v" objBil="denCln" objCb="showDCData(\'[obj]\')">إدخال الخيارات</div>
                <div class="lh20 f1 " txt_denCln>'.objListInpView('denCln',$val).'</div>
                <input type="hidden" name="'.$fil.'" value="'.$val.'" inp_denCln/>';
        break;
    }
    return $out;
}
function getDCVeiw($type,$fil,$val){    
    switch ($type){
        case 1:
            $out='عنوان مستوى 1';
            if($val==2){$out='عنوان مستوى 2';}                        
        break;
        case 2:
            $out='نص عادي';
            if($val==2){$out='نص كبير';}            
        break;
        case 3:            
            if($val==1){$out='نص إضافة';}
        break;
        case 4:
            $sel='';            
            $out='
                <div class="lh20 f1 " txt_denCln>'.objListInpView('denCln',$val).'</div>';
        break;
    }
    return $out;
}
function showDenClnINput($id,$type,$add_vals,$status,$req,$val=''){
    global $lg;
    $out='<div>';
    switch($type){
        case 2:
            if($add_vals==1){$out.='<input name="dci_'.$id.'" type="text" value="'.$val[0].'"/>';}
            if($add_vals==2){$out.='<textarea class="w100" t name="dci_'.$id.'">'.$val[0].'</textarea>';}
        break;
        case 3:
            $h='hide';
            $ch='';
            if($val[0]==1){$h=''; $ch='checked';}
            $out.='<input name="dci_'.$id.'" type="checkbox" value="'.$val[0].'" '.$ch.' par="chDC"/>';
            if($add_vals==1){
                $out.='<div class=""><input name="dci_'.$id.'_in" value="'.$val[1].'" type="text" class="'.$h.'" placeholder="حدد القيمة"/></div>';
            }
        break;
        case 4:
            $arr=json_decode($add_vals,true);
            $out.='<div class="radioBlc so fl" name="dci_'.$id.'" req="'.$req.'" par="riDC">';        
            $h='hide';            
            foreach($arr as $k=>$v){
                $id_t=$v['id'];
                $title=$v['title'][$lg];
                $show=$v['objAdd']['show'];
                $status=$v['objAdd']['status'];
                $ch='';
                if($id_t==$val[0]){
                    $ch='checked';
                    if($show){$h='';}
                }
                $out.='<input type="radio" name="dci_'.$id.'"  value="'.$id_t.'" par="'.$show.'" st="'.$status.'" '.$ch.'/><label>'.$title.'</label>';
            }
            $out.='</div>';
            $out.='<div class=""><input name="dci_'.$id.'_in" type="text" value="'.$val[1].'" class="dciM '.$h.'" placeholder="حدد القيمة"/></div>';
            
        break;
    }
    $out.='</div>';
    return $out;
}
function get_levetNote($srv_x,$srv_m){
    global $lg;
    $out='';
    $levels=get_vals('den_m_services_levels','id,name_'.$lg,"service = $srv_m and show_in_report=1",'arr');       
    if($levels){
        foreach($levels[0] as $k=>$level){
            $text=get_vals('den_x_visits_services_levels_txt','txt',"x_srv = $srv_x and lev in ($level) ",'arr');
            $out.='<div class="lh20 fs12">'.$levels[1][$k].': ';
            foreach($text as $k=>$txt){
                if($k){$out.=' - ';}
                $out.=$txt;
            }
            $out.='</div>';
        }
    }
    return $out;

}
?>