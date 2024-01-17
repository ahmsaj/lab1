<?/***OSC***/ 
function get_ser_osc_cats($clinic){	
	global $lg,$clr1;	
	$sql="select * from osc_m_services_cat where clinic_id='$clinic'  order by name_$lg ASC";
	$out='';	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$out.='<div class="ana_list_cat">';
		$out.='<div class="actCat" cat_num="0">'.k_all_proceds.' </div>';		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$catname=$r['name_'.$lg];
			$out.='<div class="norCat" cat_num="'.$id.'">'.$catname.'</div>';
		}
		$out.='</div>';
	}
	return $out;
}
function get_ser_osc($id,$doc){
	global $lg,$clr1;
	$out='';
	$selected=array();
	$sql=" SELECT * FROM osc_m_services where act=1 and clinic='$id' ORDER BY name_$lg ASC";	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$out.='<div class="ana_list_mdc">';
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			$cat=$r['cat'];			
			$ana_count=$r['ana_count'];
			$hos_part=$r['hos_part'];
			$doc_part=$r['doc_part'];
			$price=$hos_part+$doc_part;
			if($price && $doc){						
				$newPrice=get_docServPrice($doc,$id,7);
				$newP=$newPrice[0]+$newPrice[1];							
				if($newP){$price=$newP;}
			}
			$del=0;
			if(in_array($id,$selected)){$del=1;}
			$out.='<div class="norCat TL " cat_mdc="'.$cat.'" mdc="'.$id.'" code="" name="'.$name.'" del="'.$del.'" price="'.$price.'">'.$name.' <ff> (  '.number_format($price).' )</ff></div>';
		}
		$out.='</div>';			
	}
	return $out;
}

function getOscReportEl($id,$status){	
	global $lg,$clr1;
	$out=$q='';
	if($status==1){
		$usedRep=get_vals('osc_x_report','report'," srv='$id' ");
		if($usedRep){$q=" AND id NOT IN($usedRep)";}	
		$sql=" SELECT * FROM osc_m_report where act=1  $q ORDER BY ord ASC";	
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){		
			$out.='<div id="osc_pro_butts">';
			while($r=mysql_f($res)){
				$id=$r['id'];
				$name=$r['name_'.$lg];
				$type=$r['type'];
				$out.='<div class=" " no="'.$id.'" t="'.$type.'" >'.$name.'</div>';
			}
			$out.='</div>';			
		}
	}else{
		$out='<div class="f1 fs16 clr5 lh40">'.k_cant_add_visit_finshd.'</div>';
	}
	return $out;
}
function oscReportView($id,$status){
	global $lg,$clr1;
	$out='';	
	$sql=" SELECT m.name_$lg , x.* FROM osc_m_report m , osc_x_report x where x.srv='$id' and x.report=m.id ORDER BY x.ord ASC";	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){	
		$out.='<div class="oscWList">';
		while($r=mysql_f($res)){
			$r_id=$r['id'];
			$report=$r['report'];
			$report_txt=$r['name_'.$lg];
			$type=$r['report_type'];
			$val=$r['report_val'];
			$out.='<div class="uLine bord">';
			if($status==1){
				$out.='<div class="fr">
				<div class="fr ic40 icc1 ic40_edit" onclick="osc_sel_pro('.$type.','.$report.',\''.$val.'\')" title="'.k_edit.'"></div>
				<div class="fr ic40 icc2 ic40_del" onclick="osc_pro_del('.$r_id.')" title="'.k_delete.'"></div>
				</div>';
			}			
			$out.='<div class="f1 fs18 lh50 clr1 pd10 cbg444 b_bord" >'.$report_txt.'</div>';
			if($type==1 || $type==2){
				$valls=explode(',',$val);
				foreach($valls as $v){					$report_val=get_val_arr('osc_m_report_items','name_'.$lg,$v,'repVal1');
					$out.='<div class="f1 fs14 lh30 pd10" >- '.splitNo($report_val).'</div>';
				}
			}
			if($type==3){
				$out.='<div class="f1 fs14 lh30 uLine" >'.splitNo(nl2br($val)).'</div>';
			}
			$out.='</div>';	
		}
		$out.='</div>';			
	}
	return $out;
	
}
function fixVisitSevesOsc($id){
	$sql="select * from osc_x_visits where id='$id' and  status>1 limit 1";	
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		while($r=mysql_f($res)){
			$patient=$r['patient'];
			$doctor=$r['doctor'];
			$clinic=$r['clinic'];
			$d_start=$r['d_start'];
			$d_finish=$r['d_finish'];				
			$pay_type=$r['pay_type'];
			$sql2="select * from osc_x_visits_services where visit_id='$id' ";
			$res2=mysql_q($sql2);
			$rows2=mysql_n($res2);
			if($rows2>0){
				$r2=mysql_f($res2);
				$s_id=$r2['id'];
				$hos_part=$r2['hos_part'];
				$doc_part=$r2['doc_part'];
				$doc_percent=$r2['doc_percent'];

				$service=$r2['service'];
				$pay_net=$r2['pay_net'];
				$cost=$r2['cost'];
				$clinic=$r2['clinic'];
			
				/**********************/
				$fp_dd=0;
				$fp_hh=0;
				$total_pay=$hos_part+$doc_part;
				$dis=$total_pay-$pay_net;

				if($pay_type==2 || $pay_type==3){$dis==0;}
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
					$doc_bal=intval(($doc_part-$fp_dd)/100*$doc_percent); 
					$hos_bal=($total_pay-$dis)-$doc_bal;					
				}

				$sql3="UPDATE osc_x_visits_services set 
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
				//echo '<br>';
				mysql_q($sql3);	
				/**********************/
				fixPatAccunt($patient);				
			}                    
		}
		if($pay_type==2){fixCharServ(7,$id);}
		if($pay_type==1){fixExeServ(7,$id);}
	}
}
/******************New********************/
function osc_selSrvs($vis,$c,$doc,$pat,$type,$dts_id=0){
	global $f_path,$lg,$bupOffer,$srvXTables,$srvTables;
	$mood=7;
	$out='';
	$ms_table=$srvTables[$mood];
	$xs_table=$srvXTables[$mood];
    $docPartPrice='';
    $fxg='gtc:1fr 140px|gtc:1fr 50px 140px:900';
    if(_set_qejqlfmies){
        $docPartPrice='<div class="lh40 fl pd10">
			<input type="text" fix="h:40" class="cbg7" placeholder="'.k_please_spe_doc_fees.'" id="fee"/>
		</div>';
        $fxg='gtc:1fr 1fr 140px|gtc:1fr 50px 140px:900';
    }
	$out.='
	<div class="fl w100 lh50 b_bord cbg4 pd10f fxg" fxg="'.$fxg.'">'.$docPartPrice.'        
		<div class="lh40 fl">
			<input type="text" fix="h:40" class=" " placeholder="'.k_search.'" id="srvSrch"/>
		</div>
        <div class="srvEmrg fr f1 fs14" s="0">'.k_emergency.'</div>
	</div>
	<div class="fl w100 ofx so pd10">';
	$m_clinic=getMClinic($c);
	$emplo=get_val('gnr_m_patients','emplo',$pat);
	if(_set_9iaut3jze){$offerSrv=getSrvOffers($mood,$pat);}
	$sql="select * from $ms_table where clinic='$m_clinic' and act=1 order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$out.='
		<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v overTr" srvList>		
		<th>'.k_service.'</th>
		<th>'.k_notes.'</th>		
		<th width="80">'.k_price.'</th></tr>';
		$q_pay='';
		$q_price=0;		
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$name=$r['name_'.$lg];
			$hos_part=$r['hos_part'];						
			$doc_part=$r['doc_part'];
			$edit_price=$r['edit_price'];
			$total_pay=$hos_part+$doc_part;
			$rev=$r['rev'];
			$def=$r['def'];
			$multi=$r['multi'];
			$price=$hos_part+$doc_part;
			//$ch_p=ch_prv($s_id,$pat,$doc);
            $ch_p=0;
			$revTxt='';
			$ch='';
			$edit_priceTxt='';
			$offerTxt='';
			$trClr='';
			$offerDisPrice=0;
			if($ch_p==1 && !$rev){$price=0;$revTxt='<div class="f1 clr5 fs12">'.k_review.'</div>';}
			if($price && $doc){						
				$newPrice=get_docServPrice($doc,$s_id,7);
				$newP=$newPrice[0]+$newPrice[1];							
				if($newP){$price=$newP;}
			}
			
            if($def && $emplo==0){
                if(_set_p7svouhmy5==0){$ch=" checked ";}
                if($q_pay!=''){$q_pay.=' , ';}
                $q_pay.=$name;
                //$q_price+=$price;
            }
			
			$price2=$price;
			if(_set_9iaut3jze && $price>0){
                $Nprice=$price;
				if($bupOffer[0]==3){
					$offerTxt='<div class="f1 fs12 clr66">'.k_gen_discount.' <ff14>%'.$bupOffer[1].'</ff14></div>';
					$offerDisPrice=$price2;
					$Nprice=($price2/100)*(100-$bupOffer[1]);
				}
				if($bupOffer[0]==4){
					$offerTxt='<div class="f1 fs12 clr66">'.k_for_discount.' <ff14>%'.$bupOffer[1].'</ff14></div>';
					$offerDisPrice=$price2;
					$Nprice=($price2/100)*(100-$bupOffer[1]);
				}
				foreach($offerSrv as $o){			
                    if($o[1]==$s_id ){					
                        if($o[0]==2){
                            $offerTxt='<div class="f1 fs12 clr66">'.k_ser_descount.' <ff14>%'.$o[2].'</ff14></div>';
                            $offerDisPrice=$price2;
                            //$Nprice=($price2/100)*(100-$o[2]);
                            $Nprice=$o[4];
                        }
                        if($o[0]==1){
                            $offerTxt='<div class="f1 fs12 clr55">'.k_patient_bou_ser.' </div>';
                            $Nprice=0;						
                        }
                        $trClr=' cbg666 ';
                    }
                }
                $price=$Nprice;
			}						
			$offerDisPriceTxt='';
			if($offerDisPrice){$offerDisPriceTxt='<br><ff14 class="fs12 clr5 LT">'.number_format($offerDisPrice).'</ff>';}
			$out.='<tr class="" serName="'.$name.'" oscSrv="'.$s_id.'" t="'.$type.'">			
			<td class="f1 fs12">'.$name.'</td>
			<td class="f1 fs12">'.$offerTxt.$revTxt.$edit_priceTxt.'</td>			
			<td><ff class="clr1111 fs20">'.number_format($price).$offerDisPriceTxt.'<ff></td>
			</tr>';
		}
		$out.='</table>';
	
	}
	$out.='</div>';
	return $out;
}
function osc_selSrvs_save($vis_id,$pat,$emplo,$cln,$doc,$fast){
	global $now,$thisUser,$visXTables,$srvXTables,$srvTables,$lg;
	$mood=7;
	$vTable=$visXTables[$mood];
	$sTable=$srvXTables[$mood];
	$smTable=$srvTables[$mood];
	$m_clinic=getMClinic($cln);
    $cln=minDocClinc($cln,$doc);
	if($vis_id==0){
		$doc_ord=0;
		$new_pat=isNewPat($pat,$doc,$mood);
		$sql="INSERT INTO $vTable(`patient`,`clinic`,`d_start`,`reg_user`,`fast`,`emplo`,`doctor`,`new_pat`)values ('$pat','$cln','$now','$thisUser','$fast','$emplo','$doc','$new_pat')";
		if(mysql_q($sql)){			
			$vis_id=last_id();
		}					
	}else{
		delOfferVis($mood,$vis_id);
		mysql_q("DELETE from $sTable where `visit_id`='$vis_id' ");				
	}
	/****************************/
	if($vis_id){
        $srvs=pp($_POST['srvs']);        
        if($srvs){
            $sql="select * from $smTable where clinic='$m_clinic' and id ='$srvs' and act=1 order by ord ASC";
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
                //$ch_p=ch_prv($s_id,$pat,$doc);
                $ch_p=0;
                if($ch_p==1 && $rev){$hos_part=0;$doc_part=0;}
                $pay_net=$hos_part+$doc_part;
                if($pay_net && $doc){								
                    $newPrice=get_docServPrice($doc,$s_id,7);
                    $newP=$newPrice[0]+$newPrice[1];
                    if($newP){
                        $doc_percent=$newPrice[2];
                        $hos_part=$newPrice[0];
                        $doc_part=$newPrice[1];
                        $pay_net=$newP;$total_pay=$newP;
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

                $fee=0;
                if(_set_qejqlfmies){                        
                    $fee=pp($_POST['fee']);
                }
                $sql="INSERT INTO $sTable (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`, `rev`,`d_start`,`total_pay`, `patient`,`doc`,`srv_type`,`doc_fees`)	values ('$vis_id','$m_clinic','$s_id','$hos_part','$doc_part','$doc_percent','$pay_net','$ch_p','$now','$total_pay','$pat','$doc','$opr_type','$fee')";                
                mysql_q($sql);
                $srv_x_id=last_id();									
                
                if(_set_9iaut3jze){
                    activeOffer($mood,$cln,$doc,$pat,$vis_id,$s_id,$srv_x_id);
                }	
                
			}			
			return $vis_id;
		    }else{return '0';}
        }
	}
}
function osc_selSrvsSta($vis){
	global $f_path,$lg,$bupOffer,$payStatusArrRec,$reqStatusArr,$insurStatusColArr;	
	$mood=7;
	$editable=1;
    $out='';
	$sql="select * from osc_x_visits where id='$vis' ";
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
		$sql="select * from osc_x_visits_services where visit_id='$vis' order by id ASC";
		$res=mysql_q($sql);
		$rows2=mysql_n($res);
		if($rows2>0){
            if($pay_type==1){
                $gm_note=get_val_con('gnr_x_exemption_notes','note'," vis='$vis' and mood='$mood' "); 
                if($gm_note){$out.='<div class="f1 fs14 lh50 clr5">'.k_management_notes.' : '.$gm_note.'  </div>';}else{$out.='<div class="hh10"></div>';}
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
                $service=$r['service'];	list($serviceName,$edit_price,$hPart,$dPart)=get_val('osc_m_services','name_'.$lg.',edit_price,hos_part,doc_part',$service);
				$srvPriceOrg=$hPart+$dPart;
                $hos_part=$r['hos_part'];
                $doc_part=$r['doc_part'];
				$offer=$r['offer'];
                $app=$r['app'];
				$edit_priceTxt='';
				if($edit_price){$hos_part=$doc_part=0;$edit_priceTxt='<div class="f1 clr1111 lh30">'.k_price_det_by_dr.'</div>';}
                $pay_net=$r['pay_net']+$r['doc_fees'];
				$rev=$r['rev'];
                $total_price=$hos_part+$doc_part;
                $price=$total_price;
				if($emplo && $price){
					$price=$srvPriceOrg;
				}
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
                $out.='<td class="'.$totClr2.'"><ff>'.number_format($total2).'</ff></td>
                <td class="'.$totClr2.'"><ff>'.number_format($total1-$total2).'</ff></td>';
            }
            $out.='<td class="fs18 ff B '.$totClr1.' "><ff class="clrw">'.number_format($total2).'</ff></td></tr>';
			$showNetPay=0;
            $cardPay=get_sum('gnr_x_acc_payments','amount',"mood='$mood' and vis='$vis' and pay_type=2");
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
function osc_ticket($r){
	global $lg,$ser_status_Tex,$srvXTables,$srvTables;	
	$mood=7;
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
            while($r=mysql_f($res)){					
                $s_id=$r['id'];
                $service=$r['service'];	list($serviceName,$edit_price,$hPart,$dPart)=get_val($srvMTable,'name_'.$lg.',edit_price,hos_part,doc_part',$service);
				$srvPriceOrg=$hPart+$dPart;
                $hos_part=$r['hos_part'];
                $doc_part=$r['doc_part'];
                $price=$hos_part+$doc_part;
				$offer=$r['offer'];
                $status=$r['status'];
				$edit_priceTxt='';				
                $pay_net=$r['pay_net'];
				$rev=$r['rev'];
                $price2=$price;
                if(_set_9iaut3jze &&  $status==2 && $price>0){
                    $Nprice=$price;
                    if($bupOffer[0]==3){
                        $offerTxt='<div class="f1 fs12 clr66">'.k_gen_discount.' <ff14>%'.$bupOffer[1].'</ff14></div>';
                        $offerDisPrice=$price2;
                        $Nprice=($price2/100)*(100-$bupOffer[1]);
                    }
                    if($bupOffer[0]==4){
                        $offerTxt='<div class="f1 fs12 clr66">'.k_for_discount.' <ff14>%'.$bupOffer[1].'</ff14></div>';
                        $offerDisPrice=$price2;
                        $Nprice=($price2/100)*(100-$bupOffer[1]);
                    }
                    foreach($offerSrv as $o){			
                        if($o[1]==$s_id ){					
                            if($o[0]==2){
                                $offerTxt='<div class="f1 fs12 clr66">'.k_ser_descount.' <ff14>%'.$o[2].'</ff14></div>';
                                $offerDisPrice=$price2;
                                //$Nprice=($price2/100)*(100-$o[2]);
                                $Nprice=$o[4];
                            }
                            if($o[0]==1){
                                $offerTxt='<div class="f1 fs12 clr55">'.k_patient_bou_ser.' </div>';
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
        $out.=visTicketFot($vis,$mood,$vis_status,$totalPay,$visChanges);
	}
    return $out;
}
function osc_ticket_cancel($r){
	global $lg,$payArry;	
	$mood=7;
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