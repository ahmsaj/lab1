<?/***BTY***/
function get_bty_cats($clinic){	
	global $lg,$clr1;	
	$sql="select * from bty_m_services_cat where clinic='$clinic' order by name_$lg ASC";
	$out='';	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$out.='<div class="ana_list_cat">';
		$out.='<div class="actCat" cat_num="0">'.k_all_srvcs.'</div>';		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$catname=$r['name_'.$lg];
			$out.='<div class="norCat" cat_num="'.$id.'">'.$catname.'</div>';
		}
		$out.='</div>';
	}
	return $out;
}
function get_bty_srv($id,$doc=0){
	global $lg,$clr1;
	$out='';
	$selected=array();
	$sql2="select mad_id from bty_x_visits_services where service='$id'";
	$res2=mysql_q($sql2);
	$rows2=mysql_n($res2);	
	if($rows2>0){while($r2=mysql_f($res2)){$id2=$r2['service'];array_push($selected,$id2);}}
	
	$sql=" SELECT * FROM bty_m_services where act=1 and cat IN( select id from bty_m_services_cat where clinic='$id') ORDER BY name_$lg ASC";	
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
				$newPrice=get_docServPrice($doc,$id,5);
				$newP=$newPrice[0]+$newPrice[1];							
				if($newP){$price=$newP;}
			}
			$del=0;
			if(in_array($id,$selected)){$del=1;}
			$out.='<div class="norCat " cat_mdc="'.$cat.'" mdc="'.$id.'" code="" name="'.$name.'" del="'.$del.'" price="'.$price.'">'.$name.'</div>';
		}
		$out.='</div>';			
	}
	return $out;
}
function fixVisitSevesBty($id,$mood){
	if($mood==5){
		$sql="select * from bty_x_visits where id='$id' and  status>1 limit 1";	
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
				$sql2="select * from bty_x_visits_services where visit_id='$id' ";
				$res2=mysql_q($sql2);
				$rows2=mysql_n($res2);
				if($rows2>0){
					while($r2=mysql_f($res2)){
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

						$sql3="UPDATE bty_x_visits_services set 
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
					}
					fixPatAccunt($patient);
				}
			}
			if($pay_type==2){fixCharServ(5,$id);}
			if($pay_type==1){fixExeServ(5,$id);}
		}
	}
}
function setLaserServises($vis){
	global $now;
	list($status,$patient)=get_val('bty_x_laser_visits','status,patient',$vis);
	if($status==1){
		$sql="select * from bty_x_laser_visits_services where visit_id='$vis'  ";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){
			$serv_id=$r['id'];
			$service=$r['service'];
			$s_status=$r['status'];
			if($s_status==0){
				
				$parts=get_val('bty_m_services','parts',$service);
				if($parts){
					$partsAr=explode(',',$parts);
					foreach($partsAr as $p){
						if(getTotalCO('bty_x_laser_visits_services_vals',"visit_id='$vis' and serv_x='$serv_id' and part='$p' ")==0){
							mysql_q("INSERT INTO bty_x_laser_visits_services_vals (`visit_id`,`serv`,`serv_x`,`part`,`date`,`patient`)values('$vis','$service','$serv_id','$p','$now','$patient')");
						}
					}
				}
			}
		}
	}
}
function checkLsrSrvEnd($srv){
	global $thisUser,$now;
	if(getTotalCO('bty_x_laser_visits_services_vals'," serv_x='$srv' and status=0 ")==0){
		$shoots=get_sum('bty_x_laser_visits_services_vals','counter'," serv_x='$srv' ");
		mysql_q("UPDATE bty_x_laser_visits_services SET status=1 , doc='$thisUser' , srv_shoots='$shoots' , d_finish = '$now' where id='$srv' ");
		//servPayAler($srv,6);
	}
}
function getLastLsrPrice($p){
	$sql="select price from bty_x_laser where patient='$p' and price >0 order by id DESC";
	$res=mysql_q($sql);
	$r=mysql_f($res);
	return $r['price'];
}
/*************New*****************/
function get_ser_bty_catsN($c){
	global $lg,$clr1;	
	$sql="select * from bty_m_services_cat where clinic='$c' order by name_$lg ASC";
	$out='';	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$out.='<div class="ana_list_catN" actButt="act" type="5">';
		$out.='<div act cat_num="0">'.k_all_cats.'</div>';		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$catname=$r['name_'.$lg];
			$out.='<div cat_num="'.$id.'">'.$catname.'</div>';
		}
		$out.='</div>';
	}
	return $out;
}
function get_ser_btyN($vis,$pat,$clinic,$mood,$selectedSrvs){
	global $lg,$srvTables,$srvXTables;    
    $ms_table=$srvTables[$mood];
	$xs_table=$srvXTables[$mood];
	//echo $clinic=get_vals('gnr_m_clinics','id',"type='$mood'");
    
    $cats=get_vals('bty_m_services_cat','id',"clinic IN($clinic)");
	$out='';
    $q='';
    if($cats){
        $q=" and cat IN($cats) ";
    }
    $selectedSrvs=[];

    $sql=" SELECT * from bty_m_services where act=1 $q order by ord ASC";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows>0){
        $out.='<div class="ana_list_mdcN">';
        while($r=mysql_f($res)){
            $id=$r['id'];
            $code=$r['code'];
            $name=$r['name_'.$lg];
            $cat=$r['cat'];
            $hos_part=$r['hos_part'];
            $doc_part=$r['doc_part'];
            $price=$hos_part+$doc_part;
            $del='0';
            $c='';
            if(in_array($id,$selectedSrvs)){
                $del='1';
                $c='class="hide"';
            }
            $out.='<div '.$c.' cat_mdc="'.$cat.'" s="0"  code="'.strtolower($code).'" mdc="'.$id.'" name="'.$name.'" del="'.$del.'" price="'.$price.'">'.splitNo($name).'</div>';
        }
        $out.='</div>';			
    }
    
	return $out;
}
function showBtySrvOffer($id,$offerSrv,$bupOffer,$price){
    $Mprice=$Nprice=$price;  
    if($bupOffer[0]==3){
        $offerTxt='<div class="fl w100 clr66 lh30 pd5 cbg666 mg10v TC br5">'.k_gen_discount.'<ff14>%'.$bupOffer[1].'</ff14> <span class="LT clr5">('.number_format($Mprice).')</span></div>';
        $offerDisPrice=$price;
        $Nprice=($price/100)*(100-$bupOffer[1]);
    }
    if($bupOffer[0]==4){
        $offerTxt='<div class="fl w100 clr66 lh30 pd5 cbg666 mg10v TC br5">'.k_for_discount.'<ff14>%'.$bupOffer[1].'</ff14> <span class="LT clr5">('.number_format($Mprice).')</span></div>'; 
        $offerDisPrice=$price;
        $Nprice=($price/100)*(100-$bupOffer[1]);
    }
    foreach($offerSrv as $o){
        if($o[1]==$id){					
            if($o[0]==2){
                $offerTxt='<div class="fl w100 clr66 lh30 pd5 cbg666 mg10v TC br5">'.k_ser_descount.'<ff14>%'.$o[2].'</ff14> <span class="LT clr5">('.number_format($Mprice).')</span></div>';
                $offerDisPrice=$price;
                //$Nprice=($price/100)*(100-$o[2]);
                $Nprice=$o[4];
            }
            if($o[0]==1){
                $offerTxt='<div class="fl w100 clr66 lh30 pd5 cbg666 mg10v TC br5">'.k_patient_bou_ser.'<span class="LT clr5">('.number_format($Mprice).')</span></div>';
                $Nprice=0;						
            }
            $trClr=' cbg666 ';
        }
    }
    return array($Nprice,$offerTxt);
}
function get_edit_btyN($vis,$pat,$doc,$mood,$selectedSrvs){
    global $visXTables,$srvXTables,$srvTables,$lg,$bupOffer;
    $vTable=$visXTables[$mood];
	$sTable=$srvXTables[$mood];
	$smTable=$srvTables[$mood];    
    if(_set_9iaut3jze){
        $bupOffer=array();        
        $offersAv=offersList($mood,$pat);        
        $offerSrv=getSrvOffers($mood,$pat);
    }     
	$out='';
	$q='';
	//$q=" id IN (SELECT service from $sTable where visit_id='$vis') ";
    if($selectedSrvs){
        $q=" and  id IN (".implode(',',$selectedSrvs).") ";
        $sql=" SELECT * from $smTable where act=1  $q order by ord ASC";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows>0){
            while($r=mysql_f($res)){
                $id=$r['id'];
                $name=$r['name_'.$lg];            
                $hos_part=$r['hos_part'];
                $doc_part=$r['doc_part'];
                $multi=$r['multi'];
                $price=$hos_part+$doc_part;	
                if($price && $doc){		
                    $newPrice=get_docServPrice($doc,$id,$mood);
                    $newP=$newPrice[0]+$newPrice[1];							
                    if($newP){$price=$newP;}
                }            
                $offerTxt='';
                if(_set_9iaut3jze){
                    $offerTxt=showBtySrvOffer($id,$offerSrv,$bupOffer,$price);                
                    $price=$offerTxt[0];
                }            
                $out.=btyTempLoad($mood,$id,$price,$name,$offerTxt[1],$multi);            
            }	
        }
    }
	return $out;
}
function btyTempLoad($mood,$id,$price,$short_name,$offerTxt='',$multi){
    global $lg;
    $out='<div class="fl w100 bord pd10 cbgw br5 mg10v" anaSel="'.$id.'" pr="'.$price.'">
        <div class="fr i30 i30_x mg5v" delSelAna></div>
        <div class="f1 fs12 lh40 ">'.$short_name.'</div>';
        if($mood==5){
            $out.='<div class="fl w100 lh40 t_bord">';
            if($multi && $mood==5){
                $out.='<div class="fl lh40 f1">'.k_quantity.': <input multi type="number" name="m_'.$id.'" value="1" fix="w:60|h:30"/></div>';
            } 
            $out.='<div class="fr lh40"><ff class="clr6">'.number_format($price).'</ff></div>';
            $out.='</div>'.$offerTxt;
        }
        
    $out.='</div>';
    return $out;
}
function bty_selSrvs($vis,$c,$doc,$pat,$mood,$type,$dts_id=0){
	global $f_path,$lg,$bupOffer,$srvXTables,$srvTables;
    $out='';	
	$ms_table=$srvTables[$mood];
	$xs_table=$srvXTables[$mood];
    $selectedSrvs=[];
    if($vis){
        $selectedSrvs=get_vals($xs_table,'service',"visit_id='$vis'",'arr');}	
    if($dts_id){      
        $selectedSrvs=get_vals('dts_x_dates_services','service',"dts_id='$dts_id'",'arr');        
    } 
	$out.='
    <div class="fl w100 lh50 b_bord cbg4 pd10f fxg" fxg="gtc:1fr auto auto">		
        <div class="lh40 fl">
        <input type="text" fix="h:40" placeholder="'.k_search.'" id="srvLabSrch"/>
        </div>';
        if($mood==5){$out.='<div class="srvTotal fr"><ff rvTot>0</ff></div>';}
        $out.='<div class="winLabTmp of so"></div>
    </div>
    <div class="fl w100 of h100 fxg " fxg="gtc:220px 3fr 4fr">
        <div class="r_bord pd5f ofx so soL1 cbg4">'.get_ser_bty_catsN($c).'</div>
        <div class="r_bord pd5f  ofx so soL2">'.get_ser_btyN($vis,$pat,$c,$mood,$selectedSrvs).'</div> 
        <div class="pd10 fxg of h100" fxg="gtr:50px 1fr">
            <div class="f1 fs14 b_bord lh50">'.k_sel_reqmage.' <ff id="countAna">( 0 )</ff></div>
            <div id="anaSelected" class="pd10 ofx so">'.get_edit_btyN($vis,$pat,$doc,$mood,$selectedSrvs).'</div>
        </div>
    </div>
    <div class="fl w100 lh60 cbg4 pd10f t_bord">
        <div class="fl br0 ic40 icc2 ic40_save ic40Txt " saveBtySrv="'.$type.'">'.k_save.'</div>
    </div>';
	return $out;
}
function bty_selSrvs_save($vis_id,$pat,$emplo,$cln,$doc,$mood){                         
	global $now,$thisUser,$visXTables,$srvXTables,$srvTables,$lg;    
	$vTable=$visXTables[$mood];
	$sTable=$srvXTables[$mood];
	$smTable=$srvTables[$mood];
    $m_clinic=getMClinic($cln);
    $cln=minDocClinc($cln,$doc);
    if($vis_id==0){        		
        $new_pat=isNewPat($pat,$doc,$mood);
        if($mood==5){
            $sql="INSERT INTO $vTable (`patient`,`clinic`,`d_start`,`reg_user`,`emplo`,`doctor`,`new_pat`)values ('$pat','$cln','$now','$thisUser','$emplo','$doc','$new_pat')";
        }else{
            $device=get_val_c('bty_m_laser_device','id',$cln,'clinic');
            $sql="INSERT INTO $vTable (`patient`,`clinic`,`d_start`,`reg_user`,`emplo`,`doctor`,`new_pat`)values ('$pat','$cln','$now','$thisUser','$emplo','$doc','$new_pat')";
        
        }
        if(mysql_q($sql)){$vis_id=last_id();}
        
    }else{
        delOfferVis($mood,$vis_id);
        mysql_q("DELETE from $sTable where `visit_id`='$vis_id' ");
    }
    
    $srvs=pp($_POST['srvs'],'s');
    $srvAr=explode(',',$srvs);
    $srvArr=[];        
    foreach($srvAr as $v){
        $vv=explode(':',$v);
        $srvArr[$vv[0]]=$vv[1];
    } 
    $srvTxt=implode(',',array_keys($srvArr));
    /****************************/
    if($vis_id){
        $sql="select * from $smTable where id IN($srvTxt) and act=1 order by ord ASC";
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
                    $newPrice=get_docServPrice($doc,$s_id,$mood);
                    $newP=$newPrice[0]+$newPrice[1];
                    if($newP){
                        $doc_percent=$newPrice[2];
                        $hos_part=$newPrice[0];
                        $doc_part=$newPrice[1];
                        $pay_net=$newP;$total_pay=$newP;
                    }
                }
                if($emplo && $pay_net){
                    if(_set_z4084ro8wc){
                        $hos_part=$hos_part-($hos_part/100*_set_jqqjli38k7c);
                        $hos_part=round($hos_part,-1,PHP_ROUND_HALF_DOWN);
                        $doc_part=$doc_part-($doc_part/100*_set_jqqjli38k7);
                        $doc_part=round($doc_part,-1,PHP_ROUND_HALF_DOWN);
                        $pay_net=$hos_part+$doc_part;
                    }
                }
                if($mood==5){
                    $m=1;                
                    if($srvArr[$s_id]){$m=$srvArr[$s_id];}
                    for($s=0;$s<$m;$s++){						
                        $sql="INSERT INTO $sTable (`visit_id`, `clinic`, `service`, `hos_part`, `doc_part`, `doc_percent`, `pay_net`,`d_start`,`total_pay`, `patient`, `doc`) values ('$vis_id', '$m_clinic', '$s_id', '$hos_part', '$doc_part', '$doc_percent', '$pay_net','$now','$total_pay','$pat','$doc')";
                        mysql_q($sql);
                        $srv_x_id=last_id();                        
                        if(_set_9iaut3jze){
                            activeOffer($mood,$cln,$doc,$pat,$vis_id,$s_id,$srv_x_id);
                        }	
                    }
                }else{  
                    $sql="INSERT INTO bty_x_laser_visits_services (`visit_id`, `clinic`, `service`,`d_start`, `patient`,`doc`)values ('$vis_id','$cln','$s_id','$now','$pat','$doc')";
                    mysql_q($sql);
                }
            }
            mysql_q("UPDATE gnr_x_roles set status=2 where vis='$vis_id' and mood='$mood' and  status=4");
        }else{return '0';}
        return $vis_id;
    }else{return '0';}
}
function bty_selSrvsSta($vis,$mood){
	global $f_path,$lg,$bupOffer,$payStatusArrRec,$reqStatusArr,$insurStatusColArr,$visXTables,$srvXTables,$srvTables;
    $vTable=$visXTables[$mood];
	$sTable=$srvXTables[$mood];
	$smTable=$srvTables[$mood];
	$editable=1;
    $out='';
	$sql="select * from $vTable where id='$vis' ";
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
		$sql="select * from $sTable where visit_id='$vis' order by id ASC";
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
				<th>'.k_notes.'</th>';
                if($mood==5){$out.='<th width="80">'.k_price.'</th></tr>';}
			}
            $total1=0;
            $total2=0;
            while($r=mysql_f($res)){					
                $s_id=$r['id'];
                $service=$r['service'];
                $smTable;list($serviceName,$hPart,$dPart)=get_val($smTable,'name_'.$lg.',hos_part,doc_part',$service);
				$srvPriceOrg=$hPart+$dPart;
                $hos_part=$r['hos_part'];
                $doc_part=$r['doc_part'];
                $edit_price=$r['edit_price'];
				$offer=$r['offer'];
				$edit_priceTxt='';
				if($edit_price){$hos_part=$doc_part=0;$edit_priceTxt='<div class="f1 clr1111 lh30">'.k_price_det_by_dr.'</div>';}
                $pay_net=$r['pay_net'];
				$rev=$r['rev'];
                $app=$r['app'];
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
				    $out.='<td class="f1">'.$msg.$edit_priceTxt.$offerText.'</td>';
                    if($mood==5){$out.='<td><ff>'.number_format($pay_net).'</ff></td>';}
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
            if($mood==5){
                $out.='<tr >					
                <td class="f1 B '.$totClr2.'" colspan="2">'.k_total.'</td>';
                if($pay_type!=0){
                    $out.='<td class="'.$totClr2.'"><ff>'.number_format($total1).'</ff></td>
                    <td class="'.$totClr2.'"><ff>'.number_format($total1-$total2).'</ff></td>';
                }
                $out.='<td class="fs18 ff B '.$totClr1.' "><ff class="clrw">'.number_format($total2).'</ff></td></tr>';
            }
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
function bty_recAlert($vis,$alert_id,$alert_status){
    global $visXTables,$srvXTables,$srvTables,$ser_status_Tex,$ser_status_color,$lg;
    $mood=5;$out='';
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
            $bal=$payT-$backT;            
            $out.='</div>
                <div class="cbg4">'.visStaPayAlertFot($alert_id,$vis,$mood,$bal,$alert_status).'</div>
        </div>';
    }
    return $out;
}
function lzr_recAlert($vis,$alert_id,$alert_status){
    global $visXTables,$srvXTables,$srvTables,$ser_status_Tex,$ser_status_color,$lg;
    $mood=6;$out='';
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
                        <div class=" lh30 f1 fs12 ">'.k_clinic.' : '.$cnlicName.'</div>
                        '.$docTxt.'
                    </div>
                </div>
            </div>
            <div class="ofx so pd10f b_bord">';
            
            $sql="select * from $table2 where visit_id='$vis' and status=5 ";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows>0){												
                $r=getRec('bty_x_laser_visits',$vis);
                $all_total=$r['total'];
                $all_amount=$r['total_pay'];
                $dis=$r['dis'];
                $pay_type=$r['pay_type'];
                $note=$r['note'];
                $all_total-=$dis;
                $noteTxt='';
                if($note){$noteTxt= '<div class="f1 lh40 clr5">'.k_notes.' : '.$note.'</div>';}
                
                $out.='<div class="f1 fs16 clr1 lh40 uLine">'.k_srvs_prvd.'</div>'.$noteTxt.'
                    <table class="grad_s2" cellpadding="4" cellspacing="0" >
                    
                    <tr><td width="180" class="f1 fs14 pd10">'.k_prev_count.'</td>
                    <td class="TC" width="140"><ff>'.number_format($r['mac_s']).'</ff></td></tr>
                    
                    <tr><td class="f1 pd10">'.k_curr_count.'</td>
                    <td class="TC"><ff>'.number_format($r['mac_e']).'</ff></td></tr>
                    
                    <tr><td class="f1 pd10">'.k_num_of_strikes.' </td>
                    <td class="TC"><ff>'.number_format($r['vis_shoot_r']).'</ff></td></tr>
                    
                    <tr><td class="f1 pd10">'.k_strike_price.'</td>
                    <td class="TC"><ff>'.number_format($r['price']).'</ff></td></tr>';
                    if($dis){
                        $out.='<tr><td class="f1 pd10">'.k_discount.'</td>
                        <td class="TC"><ff class=" clr5">'.number_format($dis).'</ff></td></tr>';
                    }
                    $out.='<tr><td class="f1 pd10">'.k_tot_amount.' <ff14>('.number_format($all_total).')</ff14></td>
                    <td class="TC cbg666 ">
                    <ff class="fs24 clr6 ">'.number_format($all_amount).'</ff></td></tr>';
                    $bankPay=get_sum('gnr_x_acc_payments','amount',"mood='$mood' and vis='$vis' and pay_type=2 and type=1");
                    if($bankPay){
                        $all_amount-=$bankPay;
                        $out.= '<tr class="cbg444">
                            <td class="f1 fs12">'.k_ele_payments.'</td>
                            <td class="TC"><ff class="clr5">'.number_format($bankPay).'</ff></td>
                        </tr>';
                    }
                $out.='</table>';
            }
            $out.='</div>
            <div class="cbg4">'.visStaPayAlertFot($alert_id,$vis,$mood,$all_amount,$alert_status).'</div>
        </div>';
    }
    return $out;
}
function bty_ticket($r){
	global $lg,$ser_status_Tex,$srvXTables,$srvTables;	
	$mood=5;
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
                $service=$r['service'];
                list($serviceName,$hPart,$dPart)=get_val($srvMTable,'name_'.$lg.',hos_part,doc_part',$service);
				$srvPriceOrg=$hPart+$dPart;
                $hos_part=$r['hos_part'];
                $doc_part=$r['doc_part'];
                $price=$hos_part+$doc_part;
				$offer=$r['offer'];
                $status=$r['status'];							
                $pay_net=$r['pay_net'];
				$rev=$r['rev'];
                $price2=$price;
                if(_set_9iaut3jze &&  $status==2 && $price>0){
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
        $out.=visTicketFot($vis,$mood,$vis_status,$totalPay,$visChanges);
	}
    return $out;
}
function bty_ticket_cancel($r){
	global $lg,$payArry;	
	$mood=5;
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
function lzr_ticket_cancel($r){
	global $lg,$payArry;	
	$mood=6;
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
function lzr_ticket($r){
	global $lg,$ser_status_Tex,$srvXTables,$srvTables;	
	$mood=6;
    $out='';
    $srvTable=$srvXTables[$mood];
    $srvMTable=$srvTables[$mood];
	if($r['r']){		
        $vis=$r['id'];
        $vis=$r['id'];
		$all_total=$r['total'];
        $all_amount=$r['total_pay'];
        $dis=$r['dis'];
        $pay_type=$r['pay_type'];
        $note=$r['note'];
        $status=$r['status'];
        $all_total-=$dis;
		$vis_status=$r['status'];
        
		$out.='<div class="fl w100 ofx so pd10 " >';	
		$sql="select * from $srvTable where visit_id='$vis' order by id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
            $serviceX=get_vals($srvTable,'service',"visit_id='$vis' ");
			$serviceNames=get_vals($srvMTable,'name_'.$lg,"id IN($serviceX)",' - ');
            $out.='
                <table class="grad_s2 cbgw mg10v mgA TC" cellpadding="4" cellspacing="0" >
                <tr><td class="f1 pd10">'.k_services.'</td>
                <td class="f1 fs12 pd10 TC" width="250">'.$serviceNames.'</td></tr>

                <tr><td class="f1 pd10">'.k_num_of_strikes.' </td>
                <td class="TC"><ff>'.number_format($r['vis_shoot_r']).'</ff></td></tr>

                <tr><td class="f1 pd10">'.k_strike_price.'</td>
                <td class="TC"><ff>'.number_format($r['price']).'</ff></td></tr>';
                if($dis){
                    $out.='<tr><td class="f1 pd10">'.k_discount.'</td>
                    <td class="TC"><ff class=" clr5">'.number_format($dis).'</ff></td></tr>';
                }
                $out.='<tr><td class="f1 pd10">'.k_tot_amount.' <ff14>('.number_format($all_total).')</ff14></td>
                <td class="TC cbg666 ">
                <ff class="fs24 clr6 ">'.number_format($all_amount).'</ff></td></tr>
            </table>';            
		}
		$out.='</div>'; 
        $visChanges=getTotalCo($srvTable,"visit_id='$vis' and status IN(2,4)");
        $out.=visTicketFot($vis,$mood,$vis_status,$all_amount,$visChanges);
	}
    return $out;
}
function lsrSrv($id){
    global $lg;
    $srvs=get_vals('bty_x_laser_visits_services','id',"visit_id='$id'");
    if($srvs){
        $srvsTxt=get_vals('bty_m_services','name_'.$lg,"id IN($srvs)",' :: ');
        return $srvsTxt;
    }
}
?>