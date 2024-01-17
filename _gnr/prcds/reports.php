<? $repCode='gnr';
$pageSize='print_page4';
/**************************************************/
$head=1;$breakC='^';$page_mood=0;
if(isset($_GET['mood'])){$page_mood=intval($_GET['mood']);}
if($page_mood==2){include("../../__sys/prcds/ajax_head_cFile.php");}else{include("../../__sys/prcds/ajax_header.php");}
reportStart($page_mood);
$report_kWord=k_repot;
$fin=1;//إظهار العلومات المالية
if($thisGrp=='o9yqmxot8'){//مجموعة التسويق
    $fin=0;
}
/*******Report Title*******************************/
if($page==1){
	$title1=' '.k_trtmnt_procs.' ';
	if($tab==1){$titleVal=reportTapTitle('day');}
	if($tab==2){$titleVal=reportTapTitle('month');}
	if($tab==3){$titleVal=reportTapTitle('date');}
}
if($page==2){
	$title1=' '.k_boxs.' ';
	if($tab==1){$titleVal=reportTapTitle('day');}
	if($tab==111){$titleVal=reportTapTitle('day',' '.k_dly_lb.' ');}
	if($tab==11){$titleVal=reportTapTitle('date');$pageSize='print_page4W';}
	if($tab==2){$titleVal=reportTapTitle('month');}
	if($tab==3){$titleVal=reportTapTitle('year');}
	if($tab==4){$title2=' '.k_general_report.' ';}
	if($tab==5){$titleVal=reportTapTitle('date',k_frm_dte);}
	if($tab==6){$titleVal=reportTapTitle('date',k_dfrnc);}	
}
if($page==3){
	$title1=' '.k_boxs.' ';
	if($tab==1){$titleVal=reportTapTitle('day');}
}
if($page==4){
	$title1=' '.k_drs.' ';
	if($tab==0){$titleVal=reportTapTitle('day',k_srvcs_day);}	
	if($tab==1){$titleVal=reportTapTitle('month',k_mth_inctv);}
	if($tab==2){$titleVal=reportTapTitle('month',k_mth_tol);}	
	if($tab==3){$titleVal=reportTapTitle('date');}
}
if($page==5){
	$title1=' '.k_rad_drs.' ';
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month',k_mth_inctv);}
	if($tab==2){$titleVal=reportTapTitle('month',k_mth_tol);}	
	if($tab==3){$titleVal=reportTapTitle('date');}
}
if($page==6){
	$title1=' '.k_charities.' ';
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('date');}
	if($tab==3){$titleVal=reportTapTitle('day');}
	if($tab==4){$titleVal=reportTapTitle('month');}
	if($tab==5){$titleVal=reportTapTitle('date');}
}
if($page==7){
	$title1=' '.k_exemp_reports.' ';
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('date');}
}
if($page==8){
	$title1=' '.k_operations_table.' ';	
	if($tab==1){$titleVal=reportTapTitle('week');}
	if($tab==2){$titleVal=reportTapTitle('month');}
}
if($page==12){
	$title1=' '.k_insurance.' ';
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('date');}
}
if($page==13){
	$title1=' '.k_drs.' ';
	if($tab==0){$titleVal=reportTapTitle('day',k_srvcs_day);}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('date');}
}
if($page==14){	
	$title1=' '.k_drs.' ';
	$pageSize='print_paW4';
	if($tab==0){$titleVal=reportTapTitle('day',' '.k_dly_drs_perf.' ');}
	if($tab==1){$titleVal=reportTapTitle('month',' '.k_mnthly_drs_perf.' ');}
	if($tab==2){$titleVal=reportTapTitle('date',' '.k_drs_perf_by_dat.'  ');}
}
if($page==15){
	$title1=' '.k_appointments.' ';
	if($tab==0){$titleVal=reportTapTitle('month');}
	if($tab==1){$titleVal=reportTapTitle('year');}
	if($tab==2){$title2=' '.k_general_report.' ';}
	if($tab==3){$titleVal=reportTapTitle('date');}
}
if($page==16){
	$title1=' '.k_deprts.' ';
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==10){$titleVal=reportTapTitle('month');}
    if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('year');}
}
if($page==17){
	$title1=' '.k_access_refs.' ';
	if($tab==0){$titleVal=reportTapTitle('month');}
	if($tab==1){$titleVal=reportTapTitle('year');}
	if($tab==2){$title2=' '.k_general_report.' ';}
	if($tab==3){$titleVal=reportTapTitle('date');}				
}
if($page==18){
	$title1=' '.k_emps_reports.' ';
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('year');}	
	if($tab==3){$titleVal=reportTapTitle('date');}				
}
if($page==19){
	$title1=' '.k_fnshd_visits.' ';
	if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('year');}	
	if($tab==3){$titleVal=reportTapTitle('date');}		
}
if($page==20){
	$title1=' إحصائي خدمات الأطباء ';
	if($tab==1){$titleVal=reportTapTitle('day');}
	if($tab==2){$titleVal=reportTapTitle('month');}
	if($tab==3){$titleVal=reportTapTitle('date');}		
}
if($page==21){
	$title1=' يومي تجمعي للإدارة ';
	if($tab==1){$titleVal=reportTapTitle('day');}	
}
if($page==22){
	$title1=' تحرير المرضى ';	
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('year');}	
	if($tab==3){$titleVal=reportTapTitle('date');}				
}
if($page==23){
	$title1=' سجلات التأمين';	
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('year');}	
	if($tab==3){$title2=' '.k_general_report.' ';}				
}
if($page==24){
	$title1=' طلبات الأطباء الخارجية';	
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('date');}		
}
if($page==25){
	$title1=' طلبات الأطباء الداخلية';	
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('date');}			
}
if($page==26){
	$title1=' حسومات المواعيد';
    if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('date');}			
}
if($page==27){
	$title1=' تقرير الممرضين';
    if($tab==0){$titleVal=reportTapTitle('day');}
	if($tab==1){$titleVal=reportTapTitle('month');}
	if($tab==2){$titleVal=reportTapTitle('date');}			
}

if($page==34){
	$title1=' إحصائيات الأدوية الموصوفة - ';
	if($tab==1){$titleVal=reportTapTitle('month');}
	elseif($tab==2){$titleVal=reportTapTitle('year');}
	elseif($tab==3){$titleVal=reportTapTitle('all');}
	elseif($tab==4){$titleVal=reportTapTitle('date');}

}
/*******Export File Name*******************************/
if($page==1){
	$fileName=$repCode.'_';
	if($tab==1){$fileName.='day';}
	if($tab==2){$fileName.='month';}
	if($tab==3){$fileName.='dateRang';}
}
if($page==2){
	$fileName='boxs_';
	if($tab==1){$fileName.='day';}				
	if($tab==11){$fileName.='day2';}
	if($tab==11){$fileName.='lab_day2';}
	if($tab==2){$fileName.='month';}
	if($tab==3){$fileName.='year';}
	if($tab==4){$fileName.='all';}
	if($tab==5){$fileName.='dateRang';}				
	if($tab==6){$fileName.='diff';}				
}
if($page==3){
	$fileName='boxs_parts_';
	if($tab==1){$fileName.='day';}		
}
if($page==4){
	$fileName='docs_';
	if($tab==0){$fileName.='day';}	
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='monthTotal';}				
	if($tab==3){$fileName.='dateRang';}				
}
if($page==5){
	$fileName='docXry_';				
	if($tab==0){$fileName.='day';}	
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='monthTotal';}				
	if($tab==3){$fileName.='dateRang';}					
}
if($page==6){
	$fileName='charities_';
	if($tab==0){$fileName.='day';}	
	if($tab==1){$fileName.='month';}								
	if($tab==2){$fileName.='dateRang';}
	if($tab==3){$fileName.='day';}	
	if($tab==4){$fileName.='month';}								
	if($tab==5){$fileName.='dateRang';}	
}
if($page==7){
	$fileName='exemp_';
	if($tab==0){$fileName.='day';}	
	if($tab==1){$fileName.='month';}								
	if($tab==2){$fileName.='dateRang';}
}
if($page==8){
	$fileName='operation_';
	if($tab==1){$fileName.='week';}
	if($tab==2){$fileName.='month';}
}
if($page==12){
	$fileName='insur_';
	if($tab==0){$fileName.='day';}
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRang';}
}
if($page==13){
	$fileName='labOut_';				
	if($tab==0){$fileName.='day';}	
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRang';}
}
if($page==14){
	$fileName='docPerf_';				
	if($tab==0){$fileName.='day';}	
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRang';}
}
if($page==15){
	$fileName='date_';								
	if($tab==0){$fileName.='month';}
	if($tab==1){$fileName.='year';}
	if($tab==2){$fileName.='full';}
	if($tab==3){$fileName.='dateRang';}
}
if($page==16){
	$fileName='managment_';
	if($tab==0){$fileName.='day';}
	if($tab==10){$fileName.='month';}
    if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='year';}
}
if($page==17){
	$fileName='reach_reference_';				
	if($tab==0){$fileName.='month';}
	if($tab==1){$fileName.='year';}
	if($tab==2){$fileName.='full';}
	if($tab==3){$fileName.='dateRang';}
}
if($page==18){
	$fileName='employees_';
	if($tab==0){$fileName.='day';}	
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='year';}	
	if($tab==3){$fileName.='dateRang';}
}
if($page==19){
	$fileName='ended_visits_';
	if($tab==0){$fileName.='day';}	
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='year';}	
	if($tab==3){$fileName.='dateRang';}
}
if($page==20){
	$fileName='docSrvSt_';
	if($tab==1){$fileName.='day';}
	if($tab==2){$fileName.='month';}
	if($tab==3){$fileName.='dateRang';}
}
if($page==21){
	$fileName='srv_doc_admin_';
	if($tab==1){$fileName.='day';}
}
if($page==22){
	$fileName='edit_pats_';	
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='year';}	
	if($tab==3){$fileName.='dateRang';}
}
if($page==23){
	$fileName='insur_rec_';	
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='year';}	
	if($tab==3){$fileName.='all';}
}
if($page==24){
	$fileName='doc_orders_out_';	
	if($tab==1){$fileName.='month';}	
	if($tab==2){$fileName.='dateRang';}
}
if($page==25){
	$fileName='doc_orders_in_';	
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRang';}
}
if($page==26){
	$fileName='dat_dis_';	
	if($tab==0){$fileName.='day';}
    if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRang';}
}
if($page==27){
	$fileName='nurse_';	
	if($tab==0){$fileName.='day';}
    if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='dateRang';}
}
/*PHR*/
if($page==30){
	$fileName='phr_prescription_statistics_';
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='year';}
	if($tab==3){$fileName.='all';}
	if($tab==4){$fileName.='date';}
}
if($page==31){
	$fileName='phr_prescription_sessions_report_';
	if($tab==2){$fileName.='year';}
}
if($page==32){
	$fileName='phr_presc_finan_reports_';
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='year';}
	if($tab==3){$fileName.='all';}
	if($tab==4){$fileName.='date';}
}
if($page==33){
	$fileName='phr_presc_notExist_drugs_reports_';
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='year';}
	if($tab==3){$fileName.='all';}
	if($tab==4){$fileName.='date';}
}
if($page==34){
	$fileName='phr_presc_drugs_reports_';
	if($tab==1){$fileName.='month';}
	if($tab==2){$fileName.='year';}
	if($tab==3){$fileName.='all';}
	if($tab==4){$fileName.='date';}
}
/**************************************************/
echo reportPageSet($page_mood,$fileName);
/**************************************************/
$docsGrpsQ="'".implode("','",$docsGrp)."'";
if($page==1){		
	if($tab==1){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
	}
	if($tab==2){		
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;			 
        $d_e=$d_s+(($monLen)*86400);
	}
	if($tab==3){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
	}
	echo $breakC;
	echo repTitleShow();					
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
	<tr>
		<th>'.k_dr.'</th>
		<th>'.k_service.'</th>
		<th>'.k_cat.'</th>
		<th>العدد</th>
		<th>المعاينة</th>
		<th>الإجراء</th>		
		<th>حصة المركز</th>
		<th>حصة الطبيب</th>
		<th>نسبة الطبيب</th>
	</tr>';
	$tot=array();
	$sql="select id,name_$lg,subgrp from _users where `grp_code` IN($docsGrpsQ) and `grp_code`!='66hd2fomwt' order by subgrp ASC , name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$totals=array();			
		while($r=mysql_f($res)){			
			$doc_id=$r['id'];
			$name=$r['name_'.$lg];
			$clinic=$r['subgrp'];
			$mood=get_val('gnr_m_clinics','type',intval($clinic));
			if($mood){
				$table=$srvXTables[$mood];
				if($val==0 || $mood==$val){
					if($mood==4){
						$sql2="select count(*)c, sum(price)price ,sum(doc_part)doc_p , service  from den_x_visits_services_levels where doc='$doc_id' and date_e>='$d_s' and date_e<'$d_e'  group by service ";
						$res2=mysql_q($sql2);
						$rows2=mysql_n($res2);
						if($rows2){
							$i=0;
							while($r2=mysql_f($res2)){
								$price=$r2['price'];
								$doc_p=$r2['doc_p'];
								$c=$r2['c'];
								$hos_p=$price-$doc_p;
								$service=$r2['service'];	
								$docPer=0;
								if($price){
									$docPer=($doc_p*100)/$price;
								}
								$totals[0]+=$c;
								$totals[2]+=$price;
								$totals[3]+=$hos_p;
								$totals[4]+=$doc_p;

								list($srvTxt,$cat)=get_val_arr('den_m_services','name_'.$lg.',cat',$service,'srv'.$mood);
								$catTxt=get_val_arr('den_m_services_cat','name_'.$lg,$cat,'cat'.$mood);
								echo '<tr>';
								if($i==0){
									echo '<td txt class="cur Over" rowspan="'.$rows2.'" onclick="chnRepVal('.$doc_id.')">'.$name.'</td>';
								}					
								echo '
									<td txt>'.$srvTxt.'</td>
									<td txt>'.$catTxt.'</td>							
									<td><ff class="clr1111">'.number_format($c).'</div></td>
									<td txt>-</td>
									<td><ff class="clr5">'.number_format($price).'</div></td>
									<td class="cbg666"><ff class="clr66">'.number_format($hos_p).'</div></td>
									<td class="cbg555"><ff class="clr55">'.number_format($doc_p).'</div></td>
									<td><ff class="clr1">%'.number_format($docPer).'</div></td>		
								</tr>';
								$i++;
							}
						}
					}else{
						$catCol=$subTablesOfeerCol[$mood];
						if($mood!=2){
							$sql2="select 
							count(*) c,
							sum(hos_part)hos_part_t ,
							sum(doc_part)doc_part_t , 
							sum(hos_bal)hos_bal_t , 
							sum(doc_bal)doc_bal_t , 
							service ,clinic from $table where doc='$doc_id' and d_start>='$d_s' and d_start<'$d_e' and status='1' group by service ";					
							$res2=mysql_q($sql2);
							$rows2=mysql_n($res2);
							if($rows2){
								$i=0;
								while($r2=mysql_f($res2)){
									$c=$r2['c'];
									$hos_part_t=$r2['hos_part_t'];
									$doc_part_t=$r2['doc_part_t'];
									$hos_bal_t=$r2['hos_bal_t'];
									$doc_bal_t=$r2['doc_bal_t'];
									$service=$r2['service'];
									$cat=$r2['clinic'];
									if($catCol=='cat'){
										list($srvTxt,$cat)=get_val_arr($srvTables[$mood],'name_'.$lg.',cat',$service,'srv'.$mood);
									}else{
										$srvTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$service,'srv2'.$mood);
									}
									$docPer=0;
									if($hos_part_t+$doc_part_t){
										$docPer=$doc_bal_t*100/($hos_part_t+$doc_part_t);
									}
									$totals[0]+=$c;
									$totals[1]+=$hos_part_t;
									$totals[2]+=$doc_part_t;
									$totals[3]+=$hos_bal_t;
									$totals[4]+=$doc_bal_t;

									$catTxt=get_val_arr($subTablesOfeer[$mood],'name_'.$lg,$cat,'cat'.$mood);						
									echo '<tr>';
									if($i==0){
										echo '<td txt class="cur Over" rowspan="'.$rows2.'" onclick="chnRepVal('.$doc_id.')">'.$name.'</td>';
									}					
									echo '
										<td txt>'.$srvTxt.'</td>
										<td txt>'.$catTxt.'</td>
										<td><ff class="clr1111">'.number_format($c).'</div></td>
										<td><ff class="clr6">'.number_format($hos_part_t).'</div></td>
										<td><ff class="clr5">'.number_format($doc_part_t).'</div></td>
										<td class="cbg666"><ff class="clr66">'.number_format($hos_bal_t).'</div></td>
										<td class="cbg555"><ff class="clr55">'.number_format($doc_bal_t).'</div></td>
										<td><ff class="clr1">%'.number_format($docPer).'</div></td>		
									</tr>';
									$i++;
								}
							}
						}
					}
				}
			}
		}			
	}
	$docPer=0;
	if($totals[1]+$totals[2]){	
		$docPer=$totals[4]*100/($totals[1]+$totals[2]);
	}
	echo '<tr fot>
	<td txt colspan="3">'.k_total.'</td>
	<td><ff class="clr1111">'.number_format($totals[0]).'</div></td>
	<td><ff class="clr6">'.number_format($totals[1]).'</div></td>
	<td><ff class="clr5">'.number_format($totals[2]).'</div></td>
	<td class="cbg666"><ff class="clr66">'.number_format($totals[3]).'</div></td>
	<td class="cbg555"><ff class="clr55">'.number_format($totals[4]).'</div></td>
	<td><ff class="clr1">%'.number_format($docPer,2).'</div></td>                  
	</tr>
	</table>';	
}
if($page==2){	 
	if($thisGrp=='buvw7qvpwq' || $thisGrp=='pfx33zco65'){$val=$thisUser;}
	if($thisGrp=='tmbx9qnjx4' || $thisGrp=='hrwgtql5wk'){
        if($tab==0 || $tab==11){
            $cashTable='gnr_r_cash';
            if($tab==0){
                echo repoNav($fil,1,$page,$tab,0,0,$page_mood);
                $d_s=$todyU;
                $d_e=$d_s+86400;
                $repTable='gnr_r_cash';
                if($d_s==$ss_day){$repTable='gnr_x_tmp_cash';}
            }else if($tab==11){
                echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
                $d_s=strtotime($df);			
                $d_e=strtotime($dt)+86400;
            }
            echo $breakC;
            echo repTitleShow();
            list($amount_in,$amount_out)=get_sum($repTable,'amount_in,amount_out'," date >= '$d_s' and date < '$d_e' and pay_type=1");            
            $cashTotal=$amount_in-$amount_out;
            if(_set_l1acfcztzu){
                list($amount_in,$amount_out)=get_sum($repTable,'amount_in,amount_out'," date >= '$d_s' and date < '$d_e' and pay_type=2");
                $epayTotal=$amount_in-$amount_out;
            }
            
            if(_set_l1acfcztzu){
                echo '<div class="f1 fs16 clr1 lh30">'.k_total.' : <ff>'.number_format($cashTotal+$epayTotal).'</ff> 
                <div class="lh20 uLine">
                    <span class="f1 " style="color:'.$payTypePClr[1].'">'.$payTypeP[1].' <ff14> ( '.number_format($cashTotal).' ) </ff14></span>
                    <span class="f1 "  style="color:'.$payTypePClr[2].'">'.$payTypeP[2].' <ff14> ( '.number_format($epayTotal).' ) </ff14></span>
                </div>
                </div>';
            }else{
                  echo '<div class="f1 fs16 clr1 lh30">'.k_total.' : <ff>'.number_format($cashTotal).'</ff></div>';
            }
            $sql="select 
            SUM(amount_in-amount_out)a,
            SUM(a1_in-a1_out) a1, 
            SUM(a2_in-a2_out) a2, 
            SUM(a3_in-a3_out) a3,
            SUM(a7_in-a7_out) a7,
            SUM(a4_in-a4_out) a4,
            SUM(a5_in-a5_out) a5,
            SUM(a6_in-a6_out) a6,
            SUM(card)card,SUM(offer)offer 
            from $repTable where date >= '$d_s' and date < '$d_e' limit 1";
            $res=mysql_q($sql);
            $r=mysql_f($res);
            $a=$r['a'];
            $a1=$r['a1'];
            $a2=$r['a2'];
            $a3=$r['a3'];				
            $a4=$r['a4'];
            $a5=$r['a5'];
            $a6=$r['a6'];
            $a7=$r['a7'];
            $card=$r['card'];
            $offer=$r['offer'];

            echo '<div class="cb TC">';
            if(proAct('cln')){
                if($a1){
                    echo '<div class="f1 fs16 clr1 lh40 fl pd5">'.k_clinics.' <ff class="clr6"> ( '.number_format($a1).' ) </ff></div>';
                }
            }
            if(proAct('lab')){					
                if($a2){
                    echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_thlab.' <ff class="clr6"> ( '.number_format($a2).' ) </ff> 	</div>';
                }
            }
            if(proAct('xry')){
                if($a3){
                    echo '<div class="f1 fs16 clr1 lh40 fl pd5">'.k_txry.' <ff class="clr6"> ( '.number_format($a3).' ) </ff></div>';
                }
                if($a7){
                    echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_endoscopy.' <ff class="clr6"> ( '.number_format($a7).' ) </ff></div>';
                }						
            }
            if(proAct('den')){					
                if($a4){
                    echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_thdental.' <ff class="clr6"> ( '.number_format($a4).' ) </ff></div>';
                }
    }
            if(proAct('bty')){						
                if($a5){
                    echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_tbty.' <ff class="clr6"> ( '.number_format($a5).' ) </ff></div>';
                }					
                if($a6){
                    echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_tlaser.' <ff class="clr6"> ( '.number_format($a6).' ) </ff></div>';
                }
            }            
            if(proAct('osc')){
                if($a7){
                    echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_endoscopy.' <ff class="clr6"> ( '.number_format($a7).' ) </ff></div>';
                }						
            }
            if(_set_gypwynoss==1){						
                if($card){
                    echo '<div class="f1 fs18 clr1 lh40 fl pd5"> '.k_cards.' <ff class="clr6"> ( '.number_format($card).' ) </ff></div>';
                }
    }
            if(_set_9iaut3jze==1){				
                if($offer){
                    echo '<div class="f1 fs18 clr1 lh40 fl pd5"> '.k_offers.' <ff class="clr6"> ( '.number_format($offer).' ) </ff></div>';	
                }
    }
            echo '</div>';
            /*********************/
            echo '<div class="cb"></div>';
            /***************/
            $payType=1;
            $sql="select * from _users where `grp_code` IN('buvw7qvpwq','pfx33zco65')";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows>0){
                echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH uLine" type="static" >
                <th>'.k_box.'</th>
                <th>'.k_totl.'</th>';
                if(proAct('cln')){echo '<th>'.k_clinics.'</th>';}
                if(proAct('lab')){echo '<th>'.k_thlab.'</th>';}
                if(proAct('xry')){echo '<th>'.k_txry.'</th>';echo '<th>'.k_endoscopy.'</th>';}
                if(proAct('den')){echo '<th>'.k_thdental.'</th>';}
                if(proAct('bty')){echo '<th>'.k_tbty.'</th>';}				
                if(_set_9iaut3jze==1){echo '<th>'.k_offers.'</th>';}
                if(_set_gypwynoss==1){echo '<th>'.k_cards.'</th>';}
                while($r=mysql_f($res)){
                    $u_id=$r['id'];
                    $name=$r['name_'.$lg];
                    /******/
                    $payType=1;
                    $sql2="select SUM(amount_in)amount_in , SUM(amount_out)amount_out , 
                    SUM(a1_in)a1_in , SUM(a1_out)a1_out ,
                    SUM(a2_in)a2_in , SUM(a2_out)a2_out ,
                    SUM(a3_in)a3_in , SUM(a3_out)a3_out ,
                    SUM(a7_in)a7_in , SUM(a7_out)a7_out ,
                    SUM(a4_in)a4_in , SUM(a4_out)a4_out ,
                    SUM(a5_in)a5_in , SUM(a5_out)a5_out ,
                    SUM(a6_in)a6_in , SUM(a6_out)a6_out ,
                    SUM(card)card ,SUM(offer)offer 
                    from $cashTable where date>='$d_s' and date < '$d_e' and casher='$u_id' and pay_type='$payType'";
                    $res2=mysql_q($sql2);
                    $r2=mysql_f($res2);
                    if($res2){
                        $amount_in=$r2['amount_in'];
                        $amount_out=$r2['amount_out'];
                        $cash_net=$amount_in-$amount_out;
                        $a1_in=$r2['a1_in'];
                        $a1_out=$r2['a1_out'];
                        $a2_in=$r2['a2_in'];
                        $a2_out=$r2['a2_out'];
                        $a3_in=$r2['a3_in'];
                        $a3_out=$r2['a3_out'];
                        $a7_in=$r2['a7_in'];
                        $a7_out=$r2['a7_out'];
                        $a4_in=$r2['a4_in'];
                        $a4_out=$r2['a4_out'];
                        $a5_in=$r2['a5_in'];
                        $a5_out=$r2['a5_out'];
                        $a6_in=$r2['a6_in'];
                        $a6_out=$r2['a6_out'];
                        $card=$r2['card'];
                        $offer=$r2['offer'];
                    }
                    if($cash_net){
                        echo '<tr>
                        <td txt>'.$name.' <span class="f1" style="color:'.$payTypePClr[$payType].'">( '.$payTypeP[$payType].' )</span> </td>
                        <td>
                        <div class="clr6">'.number_format($cash_in).'</div>
                        <div class="clr5">'.number_format($cash_ou).'</div>
                        <div class="clr1 cbg4">'.number_format($cash_net).'</div></td>';

                        if(proAct('cln')){
                            echo '<td><div class="clr6">'.number_format($a1_in).'</div>
                            <div class="clr5">'.number_format($a1_out).'</div>
                            <div class="clr1">'.number_format($a1_in-$a1_out).'</div></td>';
                        }
                        if(proAct('lab')){
                            echo '<td><div class="clr6">'.number_format($a2_in).'</div>
                            <div class="clr5">'.number_format($a2_out).'</div>	
                            <div class="clr1">'.number_format($a2_in-$a2_out).'</div></td>';
                        }
                        if(proAct('xry')){
                            echo '<td><div class="clr6">'.number_format($a3_in).'</div>
                            <div class="clr5">'.number_format($a3_out).'</div>
                            <div class="clr1">'.number_format($a3_in-$a3_out).'</div></td>';
                            echo '<td><div class="clr6">'.number_format($a7_in).'</div>
                            <div class="clr5">'.number_format($a7_out).'</div>
                            <div class="clr1">'.number_format($a7_in-$a7_out).'</div></td>';
                        }
                        if(proAct('den')){
                            echo '<td><div class="clr6">'.number_format($a4_in).'</div>
                            <div class="clr5">'.number_format($a4_out).'</div>
                            <div class="clr1">'.number_format($a4_in-$a4_out).'</div></td>';
                        }
                        if(proAct('bty')){
                            echo '<td><div class="clr6">'.number_format($a5_in+$a6_in).'</div>
                            <div class="clr5">'.number_format($a5_out+$a6_out).'</div>
                            <div class="clr1">'.number_format($a5_in+$a6_in-$a5_out-$a6_out).'</div></td>';
                        }
                        if(_set_9iaut3jze==1){echo '<td><div class="clr6">'.number_format($offer).'</div></td>';}
                        if(_set_gypwynoss==1){echo '<td><div class="clr6">'.number_format($card).'</div></td>';}
                        echo '</tr>';
                    }
                    /******/
                    $payType=2;
                    $sql2="select SUM(amount_in)amount_in , SUM(amount_out)amount_out , 
                    SUM(a1_in)a1_in , SUM(a1_out)a1_out ,
                    SUM(a2_in)a2_in , SUM(a2_out)a2_out ,
                    SUM(a3_in)a3_in , SUM(a3_out)a3_out ,
                    SUM(a7_in)a7_in , SUM(a7_out)a7_out ,
                    SUM(a4_in)a4_in , SUM(a4_out)a4_out ,
                    SUM(a5_in)a5_in , SUM(a5_out)a5_out ,
                    SUM(a6_in)a6_in , SUM(a6_out)a6_out ,
                    SUM(card)card ,SUM(offer)offer 
                    from $cashTable where date>='$d_s' and date < '$d_e' and casher='$u_id' and pay_type='$payType'";
                    $res2=mysql_q($sql2);
                    $r2=mysql_f($res2);
                    if($res2){
                        $amount_in=$r2['amount_in'];
                        $amount_out=$r2['amount_out'];
                        $cash_net=$amount_in-$amount_out;
                        $a1_in=$r2['a1_in'];
                        $a1_out=$r2['a1_out'];
                        $a2_in=$r2['a2_in'];
                        $a2_out=$r2['a2_out'];
                        $a3_in=$r2['a3_in'];
                        $a3_out=$r2['a3_out'];
                        $a7_in=$r2['a7_in'];
                        $a7_out=$r2['a7_out'];
                        $a4_in=$r2['a4_in'];
                        $a4_out=$r2['a4_out'];
                        $a5_in=$r2['a5_in'];
                        $a5_out=$r2['a5_out'];
                        $a6_in=$r2['a6_in'];
                        $a6_out=$r2['a6_out'];
                        $card=$r2['card'];
                        $offer=$r2['offer'];
                    }
                    if($cash_net){
                        echo '<tr>
                        <td txt>'.$name.' <span class="f1" style="color:'.$payTypePClr[$payType].'">( '.$payTypeP[$payType].' )</span> </td>
                        <td>
                        <div class="clr6">'.number_format($cash_in).'</div>
                        <div class="clr5">'.number_format($cash_ou).'</div>
                        <div class="clr1 cbg4">'.number_format($cash_net).'</div></td>';

                        if(proAct('cln')){
                            echo '<td><div class="clr6">'.number_format($a1_in).'</div>
                            <div class="clr5">'.number_format($a1_out).'</div>
                            <div class="clr1">'.number_format($a1_in-$a1_out).'</div></td>';
                        }
                        if(proAct('lab')){
                            echo '<td><div class="clr6">'.number_format($a2_in).'</div>
                            <div class="clr5">'.number_format($a2_out).'</div>	
                            <div class="clr1">'.number_format($a2_in-$a2_out).'</div></td>';
                        }
                        if(proAct('xry')){
                            echo '<td><div class="clr6">'.number_format($a3_in).'</div>
                            <div class="clr5">'.number_format($a3_out).'</div>
                            <div class="clr1">'.number_format($a3_in-$a3_out).'</div></td>';
                            echo '<td><div class="clr6">'.number_format($a7_in).'</div>
                            <div class="clr5">'.number_format($a7_out).'</div>
                            <div class="clr1">'.number_format($a7_in-$a7_out).'</div></td>';
                        }
                        if(proAct('den')){
                            echo '<td><div class="clr6">'.number_format($a4_in).'</div>
                            <div class="clr5">'.number_format($a4_out).'</div>
                            <div class="clr1">'.number_format($a4_in-$a4_out).'</div></td>';
                        }
                        if(proAct('bty')){
                            echo '<td><div class="clr6">'.number_format($a5_in+$a6_in).'</div>
                            <div class="clr5">'.number_format($a5_out+$a6_out).'</div>
                            <div class="clr1">'.number_format($a5_in+$a6_in-$a5_out-$a6_out).'</div></td>';
                        }
                        if(_set_9iaut3jze==1){echo '<td><div class="clr6">'.number_format($offer).'</div></td>';}
                        if(_set_gypwynoss==1){echo '<td><div class="clr6">'.number_format($card).'</div></td>';}
                        echo '</tr>';
                    }
                    /******/
                }
                echo '</table>';
            }			        
            /************************************************/
            echo '
            <section class="cb"  w="60" m=32" c_ord>';
            $sql="select * from gnr_m_clinics where act=1 order by ord ASC";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            $bf='../';
            $labAvl=1;
            if($rows>0){
                while($r=mysql_f($res)){
                    $c_id=$r['id'];
                    $photo=$r['photo'];
                    $code=$r['code'];
                    $cType=$r['type'];			
                    $name=$r['name_'.$lg];
                    $ph_src=viewImage($photo,1,150,150,'img','clinic.png');
                    $sql2="select sum(pay_net)t from gnr_r_clinic where clinic='$c_id' and date>='$d_s' and date < '$d_e' ";
                    $res2=mysql_q($sql2);						
                    if($res2){
                        $r2=mysql_f($res2);
                        $t=$r2['t'];											
                    }
                    if($t>0){
                    echo '<div class="dashBloc dB2 fl TC" c_ord >
                        <div b>'.$ph_src.'</div>
                        <div nn>'.number_format($t).'</div>
                        <div tt>'.$name.'</div>				
                    </div>';
                    }
                    if($cType==2){$labAvl=0;}
                }
                echo '</section>';
            }
        }
	}
	if($tab==1){
        $cashTable='gnr_r_cash';
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
		$q='';
		$cn=1;
		echo $breakC;
		echo repTitleShow();
        $add_title='';
		if($val){
			$q="and casher='$val'";
			$add_title=get_val('_users','name_'.$lg,$val);
            $cn=0;
        }
        echo '<div class="f1 fs14 lh40">'.$add_title.'</div>';
        $repTable='gnr_r_cash';
        if($d_s==$ss_day){$repTable='gnr_x_tmp_cash';}
        list($amount_in,$amount_out)=get_val_con($repTable,'amount_in,amount_out'," date >= '$d_s' and date < '$d_e' and pay_type=1 $q");        
        $cashTotal=$amount_in-$amount_out;
        if(_set_l1acfcztzu){
            list($amount_in,$amount_out)=get_val_con($repTable,'amount_in,amount_out'," date >= '$d_s' and date < '$d_e' and pay_type=2 $q");
            $epayTotal=$amount_in-$amount_out;
        }
        if(_set_l1acfcztzu){
            echo '<div class="f1 fs16 clr1 lh30">'.k_total.' : <ff>'.number_format($cashTotal+$epayTotal).'</ff> | 
                <span class="f1 " style="color:'.$payTypePClr[1].'">'.$payTypeP[1].' <ff14> ( '.number_format($cashTotal).' ) </ff14></span>
                <span class="f1 "  style="color:'.$payTypePClr[2].'">'.$payTypeP[2].' <ff14> ( '.number_format($epayTotal).' ) </ff14></span>
            
            </div>';
        }else{
              echo '<div class="f1 fs16 clr1 lh30">'.k_total.' : <ff>'.number_format($cashTotal).'</ff></div>';
        }

        $sql="select 
        SUM(amount_in-amount_out)a,
        SUM(a1_in-a1_out) a1, 
        SUM(a2_in-a2_out) a2, 
        SUM(a3_in-a3_out) a3,
        SUM(a7_in-a7_out) a7,
        SUM(a4_in-a4_out) a4,
        SUM(a5_in-a5_out) a5,
        SUM(a6_in-a6_out) a6,
        SUM(card)card,SUM(offer)offer 
        from $repTable where date >= '$d_s' and date < '$d_e' $q limit 1";
        $res=mysql_q($sql);
        $r=mysql_f($res);
        $a=$r['a'];
        $a1=$r['a1'];
        $a2=$r['a2'];
        $a3=$r['a3'];				
        $a4=$r['a4'];
        $a5=$r['a5'];
        $a6=$r['a6'];
        $a7=$r['a7'];
        $card=$r['card'];
        $offer=$r['offer'];
        
        
        echo '<div class="cb TC">';
        if(proAct('cln')){
            if($a1){
                echo '<div class="f1 fs16 clr1 lh40 fl pd5">'.k_clinics.' <ff class="clr6"> ( '.number_format($a1).' ) </ff></div>';
            }
        }
        if(proAct('lab')){					
            if($a2){
                echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_thlab.' <ff class="clr6"> ( '.number_format($a2).' ) </ff> 	</div>';
            }
        }
        if(proAct('xry')){
            if($a3){
                echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_txry.' <ff class="clr6"> ( '.number_format($a3).' ) </ff></div>';
            }
            if($a7){
                echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_endoscopy.' <ff class="clr6"> ( '.number_format($a7).' ) </ff></div>';
            }						
        }
        if(proAct('den')){					
            if($a4){
                echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_thdental.' <ff class="clr6"> ( '.number_format($a4).' ) </ff></div>';
            }
}
        if(proAct('bty')){						
            if($a5){
                echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_tbty.' <ff class="clr6"> ( '.number_format($a5).' ) </ff></div>';
            }					
            if($a6){
                echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_tlaser.' <ff class="clr6"> ( '.number_format($a6).' ) </ff></div>';
            }
        }
        if(proAct('xry')){
            if($a3){
                echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_txry.' <ff class="clr6"> ( '.number_format($a3).' ) </ff></div>';
            }					
        }
        if(proAct('osc')){
            if($a7){
                echo '<div class="f1 fs16 clr1 lh40 fl pd5"> '.k_endoscopy.' <ff class="clr6"> ( '.number_format($a7).' ) </ff></div>';
            }						
        }
        if(_set_gypwynoss==1){						
            if($card){
                echo '<div class="f1 fs18 clr1 lh40 fl pd5"> '.k_cards.' <ff class="clr6"> ( '.number_format($card).' ) </ff></div>';
            }
}
        if(_set_9iaut3jze==1){				
            if($offer){
                echo '<div class="f1 fs18 clr1 lh40 fl pd5"> '.k_offers.' <ff class="clr6"> ( '.number_format($offer).' ) </ff></div>';	
            }
}
        echo '</div>';
		$sql="select * from gnr_x_acc_payments where date>='$d_s' and date < '$d_e' and type!=9 $q  order by date ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);

		if($rows>0){?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th><?=k_ref_num?></th>
				<th><?=k_tim?></th>
				<? if(!$val){echo '<th>'.k_cashier.'</th>';}?>
				<th><?=k_patient?></th>
				<th><?=k_doctor?></th>
				<th><?=k_clinic?></th>                      
				<th><?=k_type?></th>
				<th><?=k_incm_fnd?></th>
				<th><?=k_outcm_fnd?></th>
                <th>دفع الكتروني</th>
			</tr><?
			$in_all=0;
			$out_all=0;
            $e_all=0;
			while($r=mysql_f($res)){
				$pay_id=$r['id'];
				$type=$r['type'];
				$vis=$r['vis'];
				$mood=substr($r['mood'],0,1);
				$amount=$r['amount'];
				$casher=$r['casher'];
				$date=$r['date'];
                $pay_type=$r['pay_type'];
				$in='0';
				$out='0';
                $e_pay='0';
				$p_type=1;
                if($pay_type==1){
                    if(in_array($type,array(1,2,5,6,7,10))){
                        $in=$amount;
                        $in_all+=$in;
                    }else{
                        $out=$amount;
                        $out_all+=$out;
                    }
                }else{
                    $e_pay=$amount;
                    $e_all+=$e_pay;
                }
				if($type==5){
					$patient=$vis;$doctor='';$clinic='';$vis='';
				}if($type==10){
					$dr=getRec('gnr_x_offers',$vis);						
					$patient=$dr['patient'];
					$doctor='';$clinic='';
				}elseif($type==6){
					$dr=getRec('dts_x_dates',$vis);						
					$patient=$dr['patient'];
					$p_type=$dr['p_type'];
					$clinic=$dr['clinic'];
					$doctor=$dr['doctor'];						
				}else{
					if($mood==4 && $vis==0){	list($pp_id,$patient,$doctor)=get_val_c('gnr_x_acc_patient_payments','id,patient,doc',$pay_id,'payment_id');
						$clinic=get_val_arr('_users','subgrp',$doctor,'cl');
						$vis=$pp_id;
					}else{
						$visInfo=getVistInfo($vis,$mood);
						$patient=$visInfo['p'];
						$clinic=$visInfo['c'];
						$doctor=$visInfo['d'];
					}

				}
				$patientName=get_p_dts_name($patient,1);
				$docName=get_val_arr('_users','name_'.$lg,$doctor,'d');
				$clicName=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c');
                $code=$mood;
				echo '
				<tr>
				<td><ff14>#'.$code.'-'.$vis.'</ff14></td>
				<td><ff14>'.clockStr($date-$todyU).'</ff14></td>';
				if(!$val){
					$casherName=get_val_arr('_users','name_'.$lg,$casher,'d');
					echo '<td class="f1">'.$casherName.'</td>';
				}
				echo '
				<td class="f1 fs12">'.$patientName.'</td>
				<td class="f1 fs12">'.$docName.'</td>
				<td class="f1 fs12">'.$clicName.'</td>				
				<td><div style="color:'.$payArry_col[$type].'" class="f1 fs10">'.$payArry[$type].'</div></td>
				<td><ff class="clr6">'.number_format($in).'</ff></td>
				<td><ff class="clr5">'.number_format($out).'</ff></td>
                <td><ff style="color:'.$payTypePClr[2].'">'.number_format($e_pay).'</ff></td>                
				</tr>';
			}
			echo '
			<tr fot>
			<td colspan="'.(6+$cn).'" class="f1 fs14" style="text-align:'.k_Xalign.'">'.k_total.'</td>                
			<td><ff14 class="clr6 ">'.number_format($in_all).'</ff14></td>
			<td><ff14 class="clr5 ">'.number_format($out_all).'</ff14></td>
            <td><ff14 style="color:'.$payTypePClr[2].'">'.number_format($e_all).'</ff14></td> 
			</tr>';
			echo '
			<tr>
			<td colspan="'.(6+$cn).'" class="f1 fs14" style="text-align:'.k_Xalign.'">'.k_fin_blnc.'</td> 
			<td colspan="2"><ff class="clr1 fs22">'.number_format($in_all-$out_all).'</ff></td>
            <td></td>
			</tr></table>';
		}else{echo '<div class="f1 fs14 clr5">'.k_nopr_fnd.'</div>';}
	}	
	if($tab==2){
        $cashTable='gnr_r_cash';
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);			
		$q='';
		echo $breakC;
		echo repTitleShow();
		if($val){$q="and casher='$val'"; $add_title=get_val('_users','name_'.$lg,$val);}
		echo '<div class="f1 fs18 clr1 lh40">'.$add_title.'</div>';
        /*******/
        $d_s=$mm;
		$d_e=$d_s+($monLen*86400);
        list($amount_in,$amount_out)=get_sum($cashTable,'amount_in,amount_out'," date >= '$d_s' and date < '$d_e' and pay_type=1 $q");
        $cashTotal=$amount_in-$amount_out;
        if(_set_l1acfcztzu){
            list($amount_in,$amount_out)=get_sum($cashTable,'amount_in,amount_out'," date >= '$d_s' and date < '$d_e' and pay_type=2 $q");
            $epayTotal=$amount_in-$amount_out;
        }

        if(_set_l1acfcztzu){
            echo '<div class="f1 fs16 clr1 lh30">'.k_total.' : <ff>'.number_format($cashTotal+$epayTotal).'</ff> 
            <div class="lh20 uLine">
                <span class="f1 " style="color:'.$payTypePClr[1].'">'.$payTypeP[1].' <ff14> ( '.number_format($cashTotal).' ) </ff14></span>
                <span class="f1 "  style="color:'.$payTypePClr[2].'">'.$payTypeP[2].' <ff14> ( '.number_format($epayTotal).' ) </ff14></span>
            </div>
            </div>';
        }else{
              echo '<div class="f1 fs16 clr1 lh30">'.k_total.' : <ff>'.number_format($cashTotal).'</ff></div>';
        }?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th width="30"><?=k_tday?></th><? 
			if(proAct('cln')){ echo '<th>'.k_clinics.'</th> ';}
			if(proAct('lab')){ echo '<th>'.k_thlab.'</th> ';}
			if(proAct('xry')){ echo '<th>'.k_txry.'</th>';}
			if(proAct('den')){ echo '<th>'.k_thdental.'</th> ';}
			if(proAct('bty')){ echo '<th>'.k_tbty.'</th><th>'.k_tlaser.'</th> ';}
			if(proAct('osc')){ echo '<th>'.k_endoscopy.'</th> ';}
			if(_set_gypwynoss==1){ echo '<th>'.k_cards.'</th> ';}
			if(_set_9iaut3jze==1){ echo '<th>'.k_offers.'</th> ';}?>
			<th><?=k_total?></th>            
		</tr>  
		<?
		$t=$t1=$t2=$t3=$t4=$t5=$t6=$t7=$t8=$t9=0;
		for($ss=0;$ss<$monLen;$ss++){
			$d_s=$mm+($ss*86400);
			$d_e=$d_s+86400;
			$sql2="select 
			SUM(amount_in-amount_out) a,
			SUM(a1_in-a1_out) a1, 
			SUM(a2_in-a2_out) a2, 
			SUM(a3_in-a3_out) a3,				
			SUM(a4_in-a4_out) a4,
			SUM(a5_in-a5_out) a5,
			SUM(a6_in-a6_out) a6,
			SUM(a7_in-a7_out) a7,
			SUM(card)card,SUM(offer)offer
			from gnr_r_cash where date >= '$d_s' and date < '$d_e' $q limit 1";
			$res2=mysql_q($sql2);
			if($res2){
				$r2=mysql_f($res2);
				$a=$r2['a'];
				$a1=$r2['a1'];
				$a2=$r2['a2'];
				$a3=$r2['a3'];
				$a7=$r2['a7'];
				$a4=$r2['a4'];
				$a5=$r2['a5'];
				$a6=$r2['a6'];
				$card=$r2['card'];
				$offer=$r2['offer'];
				$t+=$a;
				$t1+=$a1;
				$t2+=$a2;
				$t3+=$a3;						
				$t4+=$a4;
				$t5+=$a5;
				$t6+=$a6;
				$t7+=$a7;
				$t8+=$card;
				$t9+=$offer;
			}	
			if($a){?>           
				<tr><td><div class="ff fs18 B txt_Over" onclick="loadRep(<?=$page?>,1,<?=$d_s?>)"><?=($ss+1)?></div></td><?
				if(proAct('cln')){echo '<td><ff>'.number_format($a1).'</ff></td>';}
				if(proAct('lab')){echo '<td><ff>'.number_format($a2).'</ff></td>';}
				if(proAct('xry')){echo '<td><ff>'.number_format($a3).'</ff></td>';}
				if(proAct('den')){echo '<td><ff>'.number_format($a4).'</ff></td>';}
				if(proAct('bty')){ 
					echo '<td><ff>'.number_format($a5).'</ff></td>';
					echo '<td><ff>'.number_format($a6).'</ff></td>';
				}
				if(proAct('osc')){echo '<td><ff>'.number_format($a7).'</ff></td>';}
				if(_set_gypwynoss==1){ echo '<td><ff>'.number_format($card).'</ff></td>';}
				if(_set_9iaut3jze==1){ echo '<td><ff>'.number_format($offer).'</ff></td>';}?>
				<td><ff><?=number_format($a)?></ff></td>                
				</tr><?	
			}
		}?> 
		<tr fot>
			<td class="f1 fs14"><?=k_ggre?></td>
			<?
			if(proAct('cln')){echo '<td><ff>'.number_format($t1).'</ff></td>';}
			if(proAct('lab')){echo '<td><ff>'.number_format($t2).'</ff></td>';}
			if(proAct('xry')){echo '<td><ff>'.number_format($t3).'</ff></td>';}
			if(proAct('den')){ echo '<td><ff>'.number_format($t4).'</ff></td>';}
			if(proAct('bty')){ 
				echo '<td><ff>'.number_format($t5).'</ff></td>';
				echo '<td><ff>'.number_format($t6).'</ff></td>';
			}
			if(proAct('osc')){echo '<td><ff>'.number_format($t7).'</ff></td>';}
			if(_set_gypwynoss==1){ echo '<td><ff>'.number_format($t8).'</ff></td>';}
			if(_set_9iaut3jze==1){ echo '<td><ff>'.number_format($t9).'</ff></td>';}?>
			<td><ff><?=number_format($t)?></ff></td>               
		</tr>
		</table><?		
	}
	if($thisGrp=='tmbx9qnjx4' || $thisGrp=='hrwgtql5wk'){
		if($tab==3){
			echo repoNav($fil,3,$page,$tab,1,1,$page_mood);
			$q='';
			echo $breakC;
			echo repTitleShow();
			if($val){$q="and casher='$val'"; $add_title=get_val('_users','name_'.$lg,$val);}?>
			<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?
            /*******/
            $cashTable='gnr_r_cash';
            $d_s=mktime(0,0,0,1,1,$selYear);
			$d_e=mktime(0,0,0,1,1,$selYear+1);
            list($amount_in,$amount_out)=get_sum($cashTable,'amount_in,amount_out'," date >= '$d_s' and date < '$d_e' and pay_type=1 $q");            
            $cashTotal=$amount_in-$amount_out;
            if(_set_l1acfcztzu){
                list($amount_in,$amount_out)=get_sum($cashTable,'amount_in,amount_out'," date >= '$d_s' and date < '$d_e' and pay_type=2 $q");
                $epayTotal=$amount_in-$amount_out;
            }
            if(_set_l1acfcztzu){
                echo '<div class="f1 fs16 clr1 lh30">'.k_total.' : <ff>'.number_format($cashTotal+$epayTotal).'</ff> 
                <div class="lh20 uLine">
                    <span class="f1 " style="color:'.$payTypePClr[1].'">'.$payTypeP[1].' <ff14> ( '.number_format($cashTotal).' ) </ff14></span>
                    <span class="f1 "  style="color:'.$payTypePClr[2].'">'.$payTypeP[2].' <ff14> ( '.number_format($epayTotal).' ) </ff14></span>
                </div>
                </div>';
            }else{
                  echo '<div class="f1 fs16 clr1 lh30">'.k_total.' : <ff>'.number_format($cashTotal).'</ff></div>';
            }?>
			<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
			<tr>
				<th width="30"><?=k_month?></th><? 
				if(proAct('cln')){ echo '<th>'.k_clinics.'</th> ';}
				if(proAct('lab')){ echo '<th>'.k_thlab.'</th> ';}
				if(proAct('xry')){ echo '<th>'.k_txry.'</th> ';}
				if(proAct('den')){ echo '<th>'.k_thdental.'</th> ';}
				if(proAct('bty')){ echo '<th>'.k_tbty.'</th><th>'.k_tlaser.'</th> ';}
				if(proAct('osc')){ echo '<th>'.k_endoscopy.'</th>';}
				if(_set_gypwynoss==1){ echo '<th>'.k_cards.'</th> ';}
				if(_set_9iaut3jze==1){ echo '<th>'.k_offers.'</th> ';}?>
				<th><?=k_total?></th>		
			</tr> 
			<?
			$t=$t1=$t2=$t3=$t4=$t5=$t6=$t7=$t8=$t9=0;          
			for($ss=1;$ss<13;$ss++){
				$d_s=mktime(0,0,0,$ss,1,$selYear);
				$d_e=mktime(0,0,0,$ss+1,1,$selYear);
				$sql2="select 
				SUM(amount_in-amount_out) a,
				SUM(a1_in-a1_out) a1, 
				SUM(a2_in-a2_out) a2, 
				SUM(a3_in-a3_out) a3,					
				SUM(a4_in-a4_out) a4,
				SUM(a5_in-a5_out) a5,
				SUM(a6_in-a6_out) a6,
				SUM(a7_in-a7_out) a7,
				SUM(card)card,SUM(offer)offer
				from gnr_r_cash where date >= '$d_s' and date < '$d_e' $q limit 1";
				$res2=mysql_q($sql2);
				if($res2){
					$r2=mysql_f($res2);
					$a=$r2['a'];
					$a1=$r2['a1'];
					$a2=$r2['a2'];
					$a3=$r2['a3'];						
					$a4=$r2['a4'];
					$a5=$r2['a5'];
					$a6=$r2['a6'];
					$a7=$r2['a7'];
					$card=$r2['card'];
					$offer=$r2['offer'];
					$t+=$a;
					$t1+=$a1;
					$t2+=$a2;
					$t3+=$a3;						
					$t4+=$a4;
					$t5+=$a5;
					$t6+=$a6;
					$t7+=$a7;
					$t8+=$card;
					$t9+=$offer;
				}
				if($a){?>           
				<tr>
					<td><div class="f1 fs14 txt_Over" onclick="loadRep(<?=$page?>,2,'<?=($selYear.'-'.$ss)?>')"><?=$monthsNames[$ss]?></div></td><?
					if(proAct('cln')){echo '<td><ff>'.number_format($a1).'</ff></td>';}
					if(proAct('lab')){echo '<td><ff>'.number_format($a2).'</ff></td>';}
					if(proAct('xry')){echo '<td><ff>'.number_format($a3).'</ff></td>';}
					if(proAct('den')){ echo '<td><ff>'.number_format($a4).'</ff></td>';}
					if(proAct('bty')){ 
						echo '<td><ff>'.number_format($a5).'</ff></td>';
						echo '<td><ff>'.number_format($a6).'</ff></td>';
					}
					if(proAct('osc')){echo '<td><ff>'.number_format($a7).'</ff></td>';}
					if(_set_gypwynoss==1){ echo '<td><ff>'.number_format($card).'</ff></td>';}
					if(_set_9iaut3jze==1){ echo '<td><ff>'.number_format($offer).'</ff></td>';}?>
					<td><ff><?=number_format($a)?></ff></td>
				</tr><?	
				}
			}?> 
			<tr fot>
				<td class="f1 fs14"><?=k_ggre?></td><?
				if(proAct('cln')){echo '<td><ff>'.number_format($t1).'</ff></td>';}
				if(proAct('lab')){echo '<td><ff>'.number_format($t2).'</ff></td>';}
				if(proAct('xry')){echo '<td><ff>'.number_format($t3).'</ff></td>';}
				if(proAct('den')){echo '<td><ff>'.number_format($t4).'</ff></td>';}
				if(proAct('bty')){ 
					echo '<td><ff>'.number_format($t5).'</ff></td>';
					echo '<td><ff>'.number_format($t6).'</ff></td>';
				}
				if(proAct('osc')){echo '<td><ff>'.number_format($t7).'</ff></td>';}
				if(_set_gypwynoss==1){ echo '<td><ff>'.number_format($t8).'</ff></td>';}
				if(_set_9iaut3jze==1){ echo '<td><ff>'.number_format($t9).'</ff></td>';}?>
				<td><ff><?=number_format($t)?></ff></td>               
			</tr>
			</table><?		
		}
		if($tab==4){
			echo repoNav($fil,0,$page,$tab,1,1,$page_mood);
			$q='';
			echo $breakC;
			echo repTitleShow();?>
			<div class="f1 fs18 clr1 lh40"><?=$add_title?></div><?
            /*******/
            $cashTable='gnr_r_cash';
            $d_s=mktime(0,0,0,1,1,$selYear);
			$d_e=mktime(0,0,0,1,1,$selYear+1);
            list($amount_in,$amount_out)=get_sum($cashTable,'amount_in,amount_out'," pay_type=1");            
            $cashTotal=$amount_in-$amount_out;
            if(_set_l1acfcztzu){
                list($amount_in,$amount_out)=get_sum($cashTable,'amount_in,amount_out'," pay_type=2");
                $epayTotal=$amount_in-$amount_out;
            }
            if(_set_l1acfcztzu){
                echo '<div class="f1 fs16 clr1 lh30">'.k_total.' : <ff>'.number_format($cashTotal+$epayTotal).'</ff> 
                <div class="lh20 uLine">
                    <span class="f1 " style="color:'.$payTypePClr[1].'">'.$payTypeP[1].' <ff14> ( '.number_format($cashTotal).' ) </ff14></span>
                    <span class="f1 "  style="color:'.$payTypePClr[2].'">'.$payTypeP[2].' <ff14> ( '.number_format($epayTotal).' ) </ff14></span>
                </div>
                </div>';
            }else{
                  echo '<div class="f1 fs16 clr1 lh30">'.k_total.' : <ff>'.number_format($cashTotal).'</ff></div>';
            }?>
			<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
			<tr>
				<th><?=k_year?></th><? 
				if(proAct('cln')){ echo '<th>'.k_clinics.'</th> ';}
				if(proAct('lab')){ echo '<th>'.k_thlab.'</th> ';}
				if(proAct('xry')){ echo '<th>'.k_txry.'</th><th>'.k_endoscopy.'</th> ';}
				if(proAct('den')){ echo '<th>'.k_thdental.'</th> ';}
				if(proAct('bty')){ echo '<th>'.k_tbty.'</th><th>'.k_tlaser.'</th> ';}				
				if(_set_gypwynoss==1){ echo '<th>'.k_cards.'</th> ';}
				if(_set_9iaut3jze==1){ echo '<th>'.k_offers.'</th> ';}?>
				<th><?=k_total?></th>			
			</tr>  
			<?
			$t=$t1=$t2=$t3=$t7=$t4=$t5=$t6=$t7=$t8=0; 	
			$years=getYearsOfRec('gnr_r_cash','date',str_replace('and','',$q2));
			if($years[0]!=0){         
			for($ss=$years[0];$ss<=$years[1];$ss++){
				$d_s=strtotime($ss.'-1-1');
				$d_e=strtotime(($ss+1).'-1-1');					
				$sql2="select 
				SUM(amount_in-amount_out) a,
				SUM(a1_in-a1_out) a1, 
				SUM(a2_in-a2_out) a2, 
				SUM(a3_in-a3_out) a3,					
				SUM(a4_in-a4_out) a4,
				SUM(a5_in-a5_out) a5,
				SUM(a6_in-a6_out) a6,
				SUM(a7_in-a7_out) a7,
				SUM(card)card,SUM(offer)offer
				from gnr_r_cash where date >= '$d_s' and date < '$d_e' $q limit 1";
				$res2=mysql_q($sql2);
				if($res2){
					$r2=mysql_f($res2);
					$a=$r2['a'];
					$a1=$r2['a1'];
					$a2=$r2['a2'];
					$a3=$r2['a3'];						
					$a4=$r2['a4'];
					$a5=$r2['a5'];
					$a6=$r2['a6'];
					$a7=$r2['a7'];
					$card=$r2['card'];
					$offer=$r2['offer'];
					$t+=$a;
					$t1+=$a1;
					$t2+=$a2;
					$t3+=$a3;						
					$t4+=$a4;
					$t5+=$a5;
					$t6+=$a6;
					$t7+=$a7;
					$t7+=$card;
					$t8+=$offer;
				}
				if($a){?>           
				<tr>
				<td><div class="ff fs18 B txt_Over" onclick="loadRep(<?=$page?>,3,'<?=($ss)?>')"><?=$ss?></div></td><?
				if(proAct('cln')){echo '<td><ff>'.number_format($a1).'</ff></td>';}
				if(proAct('lab')){echo '<td><ff>'.number_format($a2).'</ff></td>';}
				if(proAct('xry')){echo '<td><ff>'.number_format($a3).'</ff></td>';}
				if(proAct('den')){echo '<td><ff>'.number_format($a4).'</ff></td>';}
				if(proAct('bty')){ 
					echo '<td><ff>'.number_format($a5).'</ff></td>';
					echo '<td><ff>'.number_format($a6).'</ff></td>';
				}
				if(proAct('osc')){echo '<td><ff>'.number_format($a7).'</ff></td>';}
				if(_set_gypwynoss==1){ echo '<td><ff>'.number_format($card).'</ff></td>';}
				if(_set_9iaut3jze==1){ echo '<td><ff>'.number_format($offer).'</ff></td>';}?>
				<td><ff><?=number_format($a)?></ff></td>
				</tr><?	
				}
			}?> 
			<tr fot>
				<td class="f1 fs14"><?=k_ggre?></td><?
				if(proAct('cln')){echo '<td><ff>'.number_format($t1).'</ff></td>';}
				if(proAct('lab')){echo '<td><ff>'.number_format($t2).'</ff></td>';}
				if(proAct('xry')){echo '<td><ff>'.number_format($t3).'</ff></td>';}
				if(proAct('den')){echo '<td><ff>'.number_format($t4).'</ff></td>';}
				if(proAct('bty')){ 
					echo '<td><ff>'.number_format($t5).'</ff></td>';
					echo '<td><ff>'.number_format($t6).'</ff></td>';
				}
				if(proAct('osc')){echo '<td><ff>'.number_format($t7).'</ff></td>';}
				if(_set_gypwynoss==1){ echo '<td><ff>'.number_format($t7).'</ff></td>';}
				if(_set_9iaut3jze==1){ echo '<td><ff>'.number_format($t8).'</ff></td>';}?>
				<td><ff><?=number_format($t)?></ff></td>               
			</tr>
			</table><?
			}
		}
		if($tab==5){
			echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
			$d_ss=strtotime($df);
			$d_e=$d_ee=strtotime($dt)+86400;
			echo $breakC;
			echo repTitleShow();
			if($val==0){$q='';$q2='';}else{
				$q=" and casher='$val' "; $q2=" and casher='$val' ";
				echo '<div class="f1 fs18 clr1 lh40">'.get_val('_users','name_'.$lg,$val).'</div>';
			}
            /*******/
            $cashTable='gnr_r_cash';            
            list($amount_in,$amount_out)=get_sum($cashTable,'amount_in,amount_out'," date >= '$d_ss' and date < '$d_ee' and pay_type=1 $q2");            
            $cashTotal=$amount_in-$amount_out;
            if(_set_l1acfcztzu){
                list($amount_in,$amount_out)=get_sum($cashTable,'amount_in,amount_out'," date >= '$d_ss' and date < '$d_ee' and pay_type=2 $q2");
                $epayTotal=$amount_in-$amount_out;
            }
            if(_set_l1acfcztzu){
                echo '<div class="f1 fs16 clr1 lh30">'.k_total.' : <ff>'.number_format($cashTotal+$epayTotal).'</ff> 
                <div class="lh20 uLine">
                    <span class="f1 " style="color:'.$payTypePClr[1].'">'.$payTypeP[1].' <ff14> ( '.number_format($cashTotal).' ) </ff14></span>
                    <span class="f1 "  style="color:'.$payTypePClr[2].'">'.$payTypeP[2].' <ff14> ( '.number_format($epayTotal).' ) </ff14></span>
                </div>
                </div>';
            }else{
                  echo '<div class="f1 fs16 clr1 lh30">'.k_total.' : <ff>'.number_format($cashTotal).'</ff></div>';
            }
			
			if($d_ss<$d_ee){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th width="130"><?=k_tday?></th><? 
					if(proAct('cln')){ echo '<th>'.k_clinics.'</th> ';}
					if(proAct('lab')){ echo '<th>'.k_thlab.'</th> ';}
					if(proAct('xry')){ echo '<th>'.k_txry.'</th>';}
					if(proAct('den')){ echo '<th>'.k_thdental.'</th> ';}
					if(proAct('bty')){ echo '<th>'.k_tbty.'</th><th>'.k_tlaser.'</th> ';}			if(proAct('osc')){ echo '<th>'.k_endoscopy.'</th> ';}
					if(_set_gypwynoss==1){ echo '<th>'.k_cards.'</th> ';}
					if(_set_9iaut3jze==1){ echo '<th>'.k_offers.'</th> ';}?>
					<th><?=k_total?></th>		
				</tr> 
			<?
			$t=$t1=$t2=$t3=$t4=$t5=$t6=$t7=$t8=$t9=0;
			for($ss=$d_ss;$ss<$d_ee;$ss=$ss+86400){			
				$d_s=$ss;
				$d_e=$d_s+86400;
				$sql2="select 
				SUM(amount_in-amount_out) a,
				SUM(a1_in-a1_out) a1, 
				SUM(a2_in-a2_out) a2, 
				SUM(a3_in-a3_out) a3,					
				SUM(a4_in-a4_out) a4,
				SUM(a5_in-a5_out) a5,
				SUM(a6_in-a6_out) a6,
				SUM(a7_in-a7_out) a7,
				SUM(card)card,SUM(offer)offer
				from gnr_r_cash where date >= '$d_s' and date < '$d_e' $q limit 1";
				$res2=mysql_q($sql2);
				if($res2){
					$r2=mysql_f($res2);
					$a=$r2['a'];
					$a1=$r2['a1'];
					$a2=$r2['a2'];
					$a3=$r2['a3'];						
					$a4=$r2['a4'];
					$a5=$r2['a5'];
					$a6=$r2['a6'];
					$a7=$r2['a7'];
					$card=$r2['card'];
					$offer=$r2['offer'];
					$t+=$a;
					$t1+=$a1;
					$t2+=$a2;
					$t3+=$a3;						
					$t4+=$a4;
					$t5+=$a5;
					$t6+=$a6;
					$t7+=$a7;
					$t8+=$card;
					$t9+=$offer;
				}	
				if($a){?>           
					<tr><td><div class="ff fs18 B txt_Over" onclick="loadRep(<?=$page?>,1,<?=$d_s?>)"><?=date('Y-m-d',$ss)?></div></td><?
					if(proAct('cln')){echo '<td><ff>'.number_format($a1).'</ff></td>';}
					if(proAct('lab')){echo '<td><ff>'.number_format($a2).'</ff></td>';}
					if(proAct('xry')){echo '<td><ff>'.number_format($a3).'</ff></td>';}
					if(proAct('den')){echo '<td><ff>'.number_format($a4).'</ff></td>';}
					if(proAct('bty')){ 
						echo '<td><ff>'.number_format($a5).'</ff></td>';
						echo '<td><ff>'.number_format($a6).'</ff></td>';
					}
					if(proAct('osc')){echo'<td><ff>'.number_format($a7).'</ff></td>';}
					if(_set_gypwynoss==1){echo '<td><ff>'.number_format($card).'</ff></td>';}
					if(_set_9iaut3jze==1){echo '<td><ff>'.number_format($offer).'</ff></td>';}?>
					<td><ff><?=number_format($a)?></ff></td>
					</tr><?	
				}
			}?> 
			<tr fot>
				<td class="f1 fs14"><?=k_ggre?></td>
				<?
				if(proAct('cln')){echo '<td><ff>'.number_format($t1).'</ff></td>';}
				if(proAct('lab')){echo '<td><ff>'.number_format($t2).'</ff></td>';}
				if(proAct('xry')){echo '<td><ff>'.number_format($t3).'</ff></td>';}
				if(proAct('den')){echo '<td><ff>'.number_format($t4).'</ff></td>';}
				if(proAct('bty')){ 
					echo '<td><ff>'.number_format($t5).'</ff></td>';
					echo '<td><ff>'.number_format($t6).'</ff></td>';
				}
				if(proAct('osc')){echo '<td><ff>'.number_format($t7).'</ff></td>';}
				if(_set_gypwynoss==1){ echo '<td><ff>'.number_format($t8).'</ff></td>';}
				if(_set_9iaut3jze==1){ echo '<td><ff>'.number_format($t9).'</ff></td>';}?>
				<td><ff><?=number_format($t)?></ff></td>               
			</tr>
			</table><?                			
			}else{echo '<div class="f1 fs16 clr5">'.k_err_ent_date.'</div>';}
		}		
	}
	if($tab==111){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
		$q='';	
		echo $breakC;
		echo repTitleShow();
		if($val){
			$q="and casher='$val'";
			$add_title=get_val('_users','name_'.$lg,$val);
		}

		$sql="select * from gnr_x_acc_payments where date>='$d_s' and date < '$d_e' and mood=2 and pay_type=1 $q  order by date ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		echo '<div class="f1 fs18 clr1 lh40">'.$add_title.'</div>';
		if($rows>0){?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th><?=k_visit_num?></th>
				<th><?=k_tim?></th>
				<th><?=k_patient?></th>                                                       
				<th><?=k_type?></th>
				<th><?=k_incm_fnd?></th>
				<th><?=k_outcm_fnd?></th>
			</tr>
			<?
			$in_all=0;
			$out_all=0;
			while($r=mysql_f($res)){
				$type=$r['type'];
				$vis=$r['vis'];
				$mood=$r['mood'];
				$amount=$r['amount'];
				$date=$r['date'];
				$visInfo=getVistInfo($vis,$mood);
				$patient=$visInfo['p'];
				$clinic=$visInfo['c'];
				$doctor=$visInfo['d'];
				$in='0';
				$out='0';
				if(in_array($type,array(1,2,5,6,7,10))){$in=$amount;$in_all+=$in;}else{$out=$amount;$out_all+=$out;}					
				if($type==5){$patient=$vis;$doctor='';$clinic='';$vis='';}
				echo '
				<tr>
				<td><ff>#'.$vis.'</ff></td>
				<td><ff>'.clockStr($date-$todyU).'</ff></td>
				<td class="f1 fs14">'.get_p_name($patient).'</td>													
				<td><div style="color:'.$payArry_col[$type].'" class="f1 fs14">'.$payArry[$type].'</div></td>
				<td><ff class="clr6">'.number_format($in).'</ff></td>
				<td><ff class="clr5">'.number_format($out).'</ff></td>
				</tr>';
			}
			echo '
			<tr style="background-color:#eee">
			<td colspan="4" class="f1 fs18" style="text-align:'.k_Xalign.'">'.k_total.'</td>                
			<td><ff class="clr6 fs22">'.number_format($in_all).'</ff></td>
			<td><ff class="clr5 fs22">'.number_format($out_all).'</ff></td>
			</tr>';
			echo '
			<tr style="background-color:#">
			<td colspan="4" class="f1 fs18" style="text-align:'.k_Xalign.'">'.k_fin_blnc.'</td>    
			<td colspan="2"><ff class="clr1 fs22">'.number_format($in_all-$out_all).'</ff></td>				
			</tr></table>';
		}else{echo '<div class="f1 fs18 clr5">'.k_nopr_fnd.'</div>';}

	}
}
if($page==3){
	if($tab==1){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
		$q='';
		$cn=1;
		echo $breakC;
		echo repTitleShow();
		if($val){
			$q="and mood='$val'";
			$add_title=$clinicTypes[$val];
			$cn=0;
			echo '<div class="f1 fs18 clr1 lh40">'.$add_title.'</div>';
		}
		$sql="select * from gnr_x_acc_payments where date>='$d_s' and date < '$d_e' and type!=9  $q  order by date ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th width="30"><?=k_ref_num?></th>
				<th><?=k_tim?></th>
				<th><?=k_cashier?></th>
				<th><?=k_patient?></th>
				<th><?=k_doctor?></th>
				<th><?=k_clinic?></th>                      
				<th><?=k_type?></th>
				<th><?=k_incm_fnd?></th>
				<th><?=k_outcm_fnd?></th>
			</tr><?
			$in_all=0;
			$out_all=0;
			while($r=mysql_f($res)){
				$pay_id=$r['id'];
				$type=$r['type'];
				$vis=$r['vis'];
				$mood=substr($r['mood'],0,1);
				$amount=$r['amount'];
				$casher=$r['casher'];
				$date=$r['date'];
				$in='0';
				$out='0';
				$p_type=1;
				if(in_array($type,array(1,2,5,6,7,10))){$in=$amount;$in_all+=$in;}else{$out=$amount;$out_all+=$out;}

				if($type==5){
					$patient=$vis;$doctor='';$clinic='';$vis='';
				}if($type==10){
					$dr=getRec('gnr_x_offers',$vis);						
					$patient=$dr['patient'];
					$doctor='';$clinic='';
				}elseif($type==6){
					$dr=getRec('dts_x_dates',$vis);						
					$patient=$dr['patient'];
					$p_type=$dr['p_type'];
					$clinic=$dr['clinic'];
					$doctor=$dr['doctor'];						
				}else{
					if($mood==4 && $vis==0){	list($pp_id,$patient,$doctor)=get_val_c('gnr_x_acc_patient_payments','id,patient,doc',$pay_id,'payment_id');
						$clinic=get_val_arr('_users','subgrp',$doctor,'cl');
						$vis=$pp_id;
					}else{
						$visInfo=getVistInfo($vis,$mood);
						$patient=$visInfo['p'];
						$clinic=$visInfo['c'];
						$doctor=$visInfo['d'];
					}
				}
				$patientName=get_p_dts_name($patient,1);
				$docName=get_val_arr('_users','name_'.$lg,$doctor,'d');
				$clicName=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c');
				$casherName=get_val_arr('_users','name_'.$lg,$casher,'d');
				echo '
				<tr>
				<td><ff>#'.$vis.'</ff></td>
				<td><ff>'.clockStr($date-$todyU).'</ff></td>
				<td>'.$casherName.'</td>
				<td class="f1 ">'.$patientName.'</td>
				<td class="f1 ">'.$docName.'</td>
				<td class="f1 ">'.$clicName.'</td>				
				<td><div style="color:'.$payArry_col[$type].'" class="f1 ">'.$payArry[$type].'</div></td>
				<td><ff class="clr6">'.number_format($in).'</ff></td>
				<td><ff class="clr5">'.number_format($out).'</ff></td>
				</tr>';
			}
			echo '
			<tr style="background-color:#eee">
			<td colspan="7" class="f1 fs14" style="text-align:'.k_Xalign.'">'.k_total.'</td>                
			<td><ff class="clr6 fs16">'.number_format($in_all).'</ff></td>
			<td><ff class="clr5 fs16">'.number_format($out_all).'</ff></td>
			</tr>';
			echo '
			<tr style="background-color:#">
			<td colspan="7" class="f1 fs14" style="text-align:'.k_Xalign.'">'.k_fin_blnc.'</td>    
			<td colspan="2"><ff class="clr1 fs22">'.number_format($in_all-$out_all).'</ff></td>				
			</tr></table>';
		}else{echo '<div class="f1 fs14 clr5">'.k_nopr_fnd.'</div>';}

	}
}
if($page==4){
	$reportGroup='7htoys03le';$clinic_type=1;
	$reportGroup=implode("','",$docsGrp);
	$doc=0;if(in_array($thisGrp,$docsGrp)){$val=$thisUser;$doc=1;}
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();
		if($val==0){
			$d_s=$todyU;
			$d_e=$d_s+86400;
			$q='';		
			
			echo '<div class="f1 fs18 clr1 lh40">'.$add_title.'</div>';
			?>
			<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
			<tr>            	
				<th width="20">#</th>
				<th><?=k_doctor?></th>
				<th><?=k_services?></th>
				<th><?=k_nt_prv?></th>
				<th><?=k_nt_actn?></th>
				
				<th><?=k_totl?></th>
				<th><?=k_hsp_rvnu?></th>
				<th><?=k_general_expenses?></th>
				<th><?=k_incvs_doc?></th>
				<th><?=k_perc_doc?></th>         			
			</tr><?
			$sql="select id , name_$lg , subgrp from _users where `grp_code` IN('$reportGroup') order by name_$lg ASC";  
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$iii=0;
				$pm1=0;$pm2=0;$pm3=0;$pm4=0;$pm5=0;$pm6=0;			
				while($r=mysql_f($res)){
					$u_id=$r['id'];
					$name=$r['name_'.$lg];
					$clinic=$r['subgrp'];
					$sql2="select 
					SUM(srv)t0 , 
					SUM(prv)t1 , 
					SUM(opr)t2 , 				
					SUM(prv_d)t11 ,
					SUM(por_d)t22 ,				
					SUM(hos_p)t5 , 
					SUM(doc_p)t6 ,
					SUM(cost)t8 ,
					AVG(doc_per)t7
					from gnr_r_docs  where doc='$u_id' and date >='$d_s' and date < '$d_e' ";
					$res2=mysql_q($sql2);
					$r2=mysql_f($res2);
					$tt0=$r2['t0'];
					$tt11=$r2['t11'];
					$tt22=$r2['t22'];
					$tt1=$r2['t1']-$tt11;
					$tt2=$r2['t2']-$tt22;

					$tt3=$tt11+$tt22;
					$tt4=$tt1+$tt2;
					$tt5=$r2['t5'];
					$tt6=$r2['t6'];
					$doc_per=$r2['t7'];
					$tt8=$r2['t8'];
					//$doc_per=$tt6*100/$tt2;
					$pm0+=$tt0;$pm1+=$tt1+$tt11;$pm2+=$tt2+$tt22;$pm3+=$tt3;$pm4+=$tt4;$pm5+=$tt5;$pm6+=$tt6;$pm8+=$tt8;

					$tt6=round($tt6,-1);
					$tt5=$tt4-$tt6;

					//$t1Txt='';if($tt11){$t1Txt=' <span class="ff clr5">[ '.number_format($tt11).' ]</span>';}
					//$t2Txt='';if($tt22){$t2Txt=' <span class="ff clr5">[ '.number_format($tt22).' ]</span>';}
					$doc_per=0;
					if($tt2){
						$doc_per=$tt6*100/$tt2;
					}
					$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
					if($tt0){
						$iii++;
						echo '<tr>
						<td><ff>'.$iii.'</ff></td>						
						<td class="f1 fs14">'.$name.' [ '.get_val('gnr_m_clinics','name_'.$lg,$clinic).' ]</td>
						<td><ff>'.number_format($tt0).'</ff></td>
						<td><ff>'.number_format($tt1+$tt11).$t1Txt.'</ff></td>
						<td><ff>'.number_format($tt2+$tt22).$t2Txt.'</ff></td>
						
						<td><ff>'.number_format($tt4).'</ff></td>
						<td><ff>'.number_format($tt5).'</ff></td>		
						<td><ff>'.number_format($tt8).'</ff></td>
						<td><ff>'.number_format($tt6).'</ff></td>
						<td><ff>'.$doc_per_txt.'</ff></td>
						</tr>';
					}
				}
				/***************/
				echo '<tr fot>
				<td class="f1 fs14" colspan="2">'.k_total.'</td>
				<td><ff>'.number_format($pm0).'</ff></td>
				<td><ff>'.number_format($pm1).'</ff></td>
				<td><ff>'.number_format($pm2).'</ff></td>
				
				<td><ff>'.number_format($pm4).'</ff></td>
				<td><ff>'.number_format($pm5).'</ff></td>
				<td><ff>'.number_format($pm8).'</ff></td>
				<td><ff>'.number_format($pm6).'</ff></td>
				<td></td>
				</tr>';
			}
			?>
			</table><?                           
		}else{			
			$d_s=$todyU;
			$d_e=$d_s+86400;
			$q='';

			$sql="select * from cln_x_visits_services  where status=1 and doc='$val' and d_start >= $d_s and d_start < $d_e ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$clinic=get_val('_users','subgrp',$val);
			echo '<div class="f1 fs18 clr1 lh40">'.get_val('_users','name_'.$lg,$val).' [ '.get_val('gnr_m_clinics','name_'.$lg,$clinic).' ] <ff> ( '.number_format($rows).' ) </ff></div>';
			if($rows>0){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th width="20"><?=k_num_serv?></th>                        
					<th><?=k_patient?></th>            
					<th><?=k_service?></th>
					<th><?=k_nt_prv?></th>
					<th><?=k_nt_actn?></th>
					
					<th><?=k_totl?></th>
					<th><?=k_hsp_rvnu?></th>
					<th><?=k_expenss?></th>
					<th><?=k_incvs_doc?></th>
					<th><?=k_perc_doc?></th>
				</tr><?                    
				$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t11=0;$t22=0;                   
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$patient=$r['patient'];
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$doc_percent=$r['doc_percent'];
					$pay_net=$r['pay_net'];
					$service=$r['service'];
					$pay_type=$r['pay_type'];
					$d_start=$r['d_start'];
					$doc_bal=$r['doc_bal'];
					$doc_dis=$r['doc_dis'];
					$hos_bal=$r['hos_bal'];
					$hos_dis=$r['hos_dis'];
					$cost=$r['cost'];
					$total_pay=$r['total_pay'];
					$dis=$doc_dis+$hos_dis;

					//$t1Txt='';if($hos_dis){$t1Txt=' <span class="ff clr5">[ '.number_format($hos_dis).' ]</span>';}
					//$t2Txt='';if($doc_dis){$t2Txt=' <span class="ff clr5">[ '.number_format($doc_dis).' ]</span>';}

					$t1+=$hos_part;$t2+=$doc_part;$t3+=$dis;$t4+=$pay_net;$t5+=$hos_bal;$t6+=$doc_bal;$t8+=$cost;
					$doc_per=$doc_bal*100/$doc_part;
					$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
					echo '<tr>
					<td><ff>'.$s_id.'</ff></td>						
					<td class="f1 fs14">'.get_p_name($patient).'</td>
					<td class="f1 fs14">'.get_val('cln_m_services','name_'.$lg,$service).'</td>
					<td><ff>'.number_format($hos_part).$t1Txt.'</ff></td>
					<td><ff>'.number_format($doc_part).$t2Txt.'</ff></td>
					
					<td><ff>'.number_format($total_pay).'</ff></td>
					<td><ff>'.number_format($hos_bal).'</ff></td>
					<td><ff>'.number_format($cost).'</ff></td>
					<td><ff>'.number_format($doc_bal).'</ff></td>
					<td><ff>'.$doc_per_txt.'</ff></td>
					</tr>';
				}
				$in=get_sum('gnr_x_acc_payments','amount'," type IN(1,2) and date>'$d_s' and date < '$d_e'");
				$out=get_sum('gnr_x_acc_payments','amount'," type IN(3,4) and date>'$d_s' and date < '$d_e'");
				$p_no=getTotalCO('cln_x_visits'," d_start>'$d_s' and d_start < '$d_e' ");
				echo '<tr fot>
				<td colspan="3" class="f1 fs16">'.k_total.'</td>	
				<td><ff>'.number_format($t1).'</ff></td>
				<td><ff>'.number_format($t2).'</ff></td>
				
				<td><ff>'.number_format($t4).'</ff></td>					
				<td><ff>'.number_format($t5,1).'</ff></td>
				<td><ff>'.number_format($t8).'</ff></td>
				<td><ff>'.number_format($t6,1).'</ff></td>
				<td></td>
				</tr>';
				?></table><?
			}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}      
		}
	}
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		if($val){$clinic=get_val('_users','subgrp',$val);?>
			<div class="f1 fs18 clr1 lh40"><?=get_val('_users','name_'.$lg,$val)?> [ <?=get_val('gnr_m_clinics','name_'.$lg,$clinic)?> ]</div>
		<? } 
		echo $breakC;
		echo repTitleShow();?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th width="30"><?=k_tday?></th>
			<th><?=k_services?></th>
			<th><?=k_nt_prv?></th>
			<th><?=k_nt_actn?></th>
			
			<th><?=k_totl?></th>
			<th><?=k_hsp_rvnu?></th>
			<th><?=k_expenss?></th>
			<th><?=k_incvs_doc?></th>
			<th><?=k_perc_doc?></th>             			
		</tr>  
		<?
		$pm0=0;$pm1=0;$pm2=0;$pm3=0;$pm4=0;$pm5=0;$pm6=0;          
		for($ss=0;$ss<$monLen;$ss++){
			$d_s=$mm+($ss*86400);
			$d_e=$d_s+86400;
			if($val){$q="and  doc='$val'"; }else{$q="";}
			/************************************/				
			$sql2="select 
			SUM(srv)t0 , 
			SUM(prv)t1 , 
			SUM(opr)t2 , 				
			SUM(prv_d)t11 ,
			SUM(por_d)t22 ,				
			SUM(hos_p)t5 , 
			SUM(doc_p)t6 ,
			AVG(doc_per)t7,
			SUM(cost)t8 

			from gnr_r_docs  where date ='$d_s' and clinic_type='$clinic_type' $q ";
			$res2=mysql_q($sql2);
			$r2=mysql_f($res2);
			$tt0=$r2['t0'];
			$tt11=$r2['t11'];
			$tt22=$r2['t22'];
			$tt1=$r2['t1']-$tt11;
			$tt2=$r2['t2']-$tt22;

			$tt3=$tt11+$tt22;
			$tt4=$tt1+$tt2;
			$tt5=$r2['t5'];
			$tt6=$r2['t6'];
			$doc_per=$r2['t7'];
			$tt8=$r2['t8'];
			//$doc_per=$tt6*100/$tt2;
			$pm0+=$tt0;$pm1+=$tt1+$tt11;$pm2+=$tt2+$tt22;$pm3+=$tt3;$pm4+=$tt4;$pm5+=$tt5;$pm6+=$tt6;$pm8+=$tt8;

			$tt6=round($tt6,-1);
			$tt5=$tt4-$tt6;

			//$t1Txt='';if($tt11){$t1Txt=' <span class="ff clr5">[ '.number_format($tt11).' ]</span>';}
			//$t2Txt='';if($tt22){$t2Txt=' <span class="ff clr5">[ '.number_format($tt22).' ]</span>';}
			$doc_per=0;
			if($tt2){
				$doc_per=$tt6*100/$tt2;
			}
			$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
			if($tt0){
				echo '<tr>
				<td class="Over" onclick="loadRep('.$page.',0,'.$d_s.')"><ff>'.($ss+1).'</ff></td>
				<td><ff>'.number_format($tt0).'</ff></td>
				<td><ff>'.number_format($tt1+$tt11).$t1Txt.'</ff></td>
				<td><ff>'.number_format($tt2+$tt22).$t2Txt.'</ff></td>
				
				<td><ff>'.number_format($tt4).'</ff></td>
				<td><ff>'.number_format($tt5).'</ff></td>
				<td><ff>'.number_format($tt8).'</ff></td>
				<td><ff>'.number_format($tt6).'</ff></td>
				<td><ff>'.$doc_per_txt.'</ff></td>
				</tr>';
			}

			/***************************************/
		}
		$pm5=round($pm5,-1);
		echo '<tr fot>
			<td class="f1 fs14">'.k_total.'</td>
			<td><ff>'.number_format($pm0).'</ff></td>
			<td><ff>'.number_format($pm1).'</ff></td>
			<td><ff>'.number_format($pm2).'</ff></td>
			
			<td><ff>'.number_format($pm4).'</ff></td>
			<td><ff>'.number_format($pm5).'</ff></td>
			<td><ff>'.number_format($pm8).'</ff></td>
			<td><ff>'.number_format($pm6).'</ff></td>
			<td></td>
			</tr>';
		?>
		</table><?		
	}
	if($tab==2 && $doc==0){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm+($ss*86400);
		$d_e=$d_s+($monLen*86400);
		echo $breakC;
		echo repTitleShow();?>			
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>            	
			<th width="20">#</th>
			<th><?=k_doctor?></th>
			<th><?=k_services?></th>
			<th><?=k_nt_prv?></th>
			<th><?=k_nt_actn?></th>
			
			<th><?=k_totl?></th>
			<th><?=k_hsp_rvnu?></th>
			<th><?=k_expenss?></th>
			<th><?=k_incvs_doc?></th>
			<th><?=k_perc_doc?></th>         			
		</tr><?
		$sql="select id , name_$lg , subgrp from _users where `grp_code` IN('$reportGroup') and `grp_code`!='fk590v9lvl' order by name_$lg ASC";  
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$iii=0;
			$pm1=0;$pm2=0;$pm3=0;$pm4=0;$pm5=0;$pm6=0;$pm7=0;$pm8=0;
			$pd1=0;$pd2=0;
			while($r=mysql_f($res)){
				$u_id=$r['id'];
				$name=$r['name_'.$lg];
				$clinic=$r['subgrp'];

				$sql2="select 
				SUM(srv)t0 , 
				SUM(prv)t1 , 
				SUM(opr)t2 , 				
				SUM(prv_d)t11 ,
				SUM(por_d)t22 ,				
				SUM(hos_p)t5 , 
				SUM(doc_p)t6 ,
				SUM(cost)t8 ,
				AVG(doc_per)t7

				from gnr_r_docs  where doc='$u_id' and date >='$d_s' and date < '$d_e' ";
				$res2=mysql_q($sql2);
				$r2=mysql_f($res2);
				$tt0=$r2['t0'];
				$tt11=$r2['t11'];
				$tt22=$r2['t22'];
				$tt1=$r2['t1']-$tt11;
				$tt2=$r2['t2']-$tt22;
				$tt3=$tt11+$tt22;
				$tt4=$tt1+$tt2;
				$tt5=$r2['t5'];
				$tt6=$r2['t6'];
				$tt8=$r2['t8'];
				$doc_per=$r2['t7'];
				//$doc_per=$tt6*100/$tt2;
				

				$tt6=round($tt6,-1);
				$tt5=$tt4-$tt6;
				
				$pm0+=$tt0;$pm1+=$tt1+$tt11;$pm2+=$tt2+$tt22;$pm3+=$tt3;$pm4+=$tt4;$pm5+=$tt5;$pm6+=$tt6;$pm8+=$tt8;

				$t1Txt='';if($tt11){$pd1+=$tt11;$t1Txt=' <span class="ff clr5">[ '.number_format($tt11).' ]</span>';}
				$t2Txt='';if($tt22){$pd2+=$tt22;$t2Txt=' <span class="ff clr5">[ '.number_format($tt22).' ]</span>';}
				$doc_per=0;
				if($tt2){
					$doc_per=$tt6*100/$tt2;
				}
				$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
				if($tt0){
					$iii++;
					echo '<tr>
					<td><ff>'.$iii.'</ff></td>						
					<td class="f1 fs14">'.$name.' [ '.get_val('gnr_m_clinics','name_'.$lg,$clinic).' ]</td>
					<td><ff>'.number_format($tt0).'</ff></td>
					<td><ff>'.number_format($tt1+$tt11).$t1Txt.'</ff></td>
					<td><ff>'.number_format($tt2+$tt22).$t2Txt.'</ff></td>
					
					<td><ff>'.number_format($tt4).'</ff></td>
					<td><ff>'.number_format($tt5).'</ff></td>
					<td><ff>'.number_format($tt8).'</ff></td>
					<td><ff>'.number_format($tt6).'</ff></td>
					<td><ff>'.$doc_per_txt.'</ff></td>
					</tr>';
				}
			}
			/***************/
			$t1Txt='';if($pd1){$t1Txt=' <span class="ff clr5">[ '.number_format($pd1).' ]</span>';}
			$t2Txt='';if($pd2){$t2Txt=' <span class="ff clr5">[ '.number_format($pd2).' ]</span>';}
			echo '<tr fot>
			<td class="f1 fs14" colspan="2">'.k_total.'</td>
			<td><ff>'.number_format($pm0).'</ff></td>
			<td><ff>'.number_format($pm1).$t1Txt.'</ff></td>
			<td><ff>'.number_format($pm2).$t2Txt.'</ff></td>
			
			<td><ff>'.number_format($pm4).'</ff></td>
			<td><ff>'.number_format($pm5).'</ff></td>
			<td><ff>'.number_format($pm8).'</ff></td>
			<td><ff>'.number_format($pm6).'</ff></td>
			<td></td>
			</tr>';
		}
		?>
		</table><?		
	}
	if($tab==3){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		echo $breakC;
		echo repTitleShow();
		if($d_s<$d_e){
			if($val==0){?>
				<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
				<tr>            	
					<th width="20">#</th>
					<th><?=k_doctor?></th>
					<th><?=k_services?></th>
					<th><?=k_nt_prv?></th>
					<th><?=k_nt_actn?></th>

					<th><?=k_totl?></th>
					<th><?=k_hsp_rvnu?></th>
					<th><?=k_expenss?></th>
					<th><?=k_incvs_doc?></th>
					<th><?=k_perc_doc?></th>          			
				</tr><?
				$sql="select id , name_$lg , subgrp from _users where `grp_code` IN('$reportGroup') order by name_$lg ASC";  
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					$iii=0;
					$pm1=0;$pm2=0;$pm3=0;$pm4=0;$pm5=0;$pm6=0;			
					while($r=mysql_f($res)){
						$u_id=$r['id'];
						$name=$r['name_'.$lg];
						$subgrp=$r['subgrp'];	

						$sql2="select 
						SUM(srv)t0 , 
						SUM(prv)t1 , 
						SUM(opr)t2 , 				
						SUM(prv_d)t11 ,
						SUM(por_d)t22 ,				
						SUM(hos_p)t5 , 
						SUM(doc_p)t6 ,
						SUM(cost)t8 ,
						AVG(doc_per)t7

						from gnr_r_docs  where doc='$u_id' and date >='$d_s' and date < '$d_e' ";
						$res2=mysql_q($sql2);
						$r2=mysql_f($res2);
						$tt0=$r2['t0'];
						$tt11=$r2['t11'];
						$tt22=$r2['t22'];
						$tt1=$r2['t1']-$tt11;
						$tt2=$r2['t2']-$tt22;

						$tt3=$tt11+$tt22;
						$tt4=$tt1+$tt2;
						$tt5=$r2['t5'];
						$tt6=$r2['t6'];
						$doc_per=$r2['t7'];
						$tt8=$r2['t8'];
						//$doc_per=$tt6*100/$tt2;
						$pm0+=$tt0;$pm1+=$tt1+$tt11;$pm2+=$tt2+$tt22;$pm3+=$tt3;$pm4+=$tt4;$pm5+=$tt5;$pm6+=$tt6;$pm8+=$tt8;

						$tt6=round($tt6,-1);
						$tt5=$tt4-$tt6;

						//$t1Txt='';if($tt11){$t1Txt=' <span class="ff clr5">[ '.number_format($tt11).' ]</span>';}
						//$t2Txt='';if($tt22){$t2Txt=' <span class="ff clr5">[ '.number_format($tt22).' ]</span>';}
						$doc_per=0;
						if($tt2){
							$doc_per=$tt6*100/$tt2;
						}
						$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
						if($tt0){
							$iii++;
							echo '<tr>
							<td><ff>'.$iii.'</ff></td>						
							<td><div class="clr5 Over f1 fs14" onclick="chnRepVal('.$u_id.')">'.$name.' [ '.get_val('gnr_m_clinics','name_'.$lg,$subgrp).' ]<div></td>
							<td><ff>'.number_format($tt0).'</ff></td>
							<td><ff>'.number_format($tt1+$tt11).$t1Txt.'</ff></td>
							<td><ff>'.number_format($tt2+$tt22).$t2Txt.'</ff></td>

							<td><ff>'.number_format($tt4).'</ff></td>
							<td><ff>'.number_format($tt5).'</ff></td>
							<td><ff>'.number_format($tt8).'</ff></td>
							<td><ff>'.number_format($tt6).'</ff></td>
							<td><ff>'.$doc_per_txt.'</ff></td>
							</tr>';
						}
					}
					/***************/
					echo '<tr fot>
					<td class="f1 fs14" colspan="2">'.k_total.'</td>
					<td><ff>'.number_format($pm0).'</ff></td>
					<td><ff>'.number_format($pm1).'</ff></td>
					<td><ff>'.number_format($pm2).'</ff></td>

					<td><ff>'.number_format($pm4).'</ff></td>
					<td><ff>'.number_format($pm5).'</ff></td>
					<td><ff>'.number_format($pm8).'</ff></td>
					<td><ff>'.number_format($pm6).'</ff></td>
					<td></td>
					</tr>';
				}
				?>
				</table><?
			}else{					
				$q='';				
				$sql="select * from cln_x_visits_services  where status=1 and doc='$val' and d_start > '$d_s' and d_start < '$d_e' order by id ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				$clinic=get_val('_users','subgrp',$val);
				echo '<div class="f1 fs18 clr1 lh40">'.get_val('_users','name_'.$lg,$val).' [ '.get_val('gnr_m_clinics','name_'.$lg,$clinic).' ] <ff> ( '.number_format($rows).' ) 
				</ff></div><?=$breakC?>';
				if($rows>0){?>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
					<tr>
						<th width="20"><?=k_num_serv?></th>
						<th><?=k_date?></th>            
						<th><?=k_patient?></th>            
						<th><?=k_service?></th>
						<th><?=k_nt_prv?></th>
						<th><?=k_nt_actn?></th>
						
						<th><?=k_totl?></th>
						<th><?=k_hsp_rvnu?></th>
						<th><?=k_expenss?></th>
						<th><?=k_incvs_doc?></th>
						<th><?=k_perc_doc?></th>
					</tr><?
					$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t11=0;$t22=0;                   
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						$patient=$r['patient'];
						$hos_part=$r['hos_part'];
						$doc_part=$r['doc_part'];
						$doc_percent=$r['doc_percent'];
						$pay_net=$r['pay_net'];
						$service=$r['service'];
						$pay_type=$r['pay_type'];
						$d_start=$r['d_start'];
						$doc_bal=$r['doc_bal'];
						$doc_dis=$r['doc_dis'];
						$hos_bal=$r['hos_bal'];
						$hos_dis=$r['hos_dis'];							
						$cost=$r['cost'];
						$total_pay=$r['total_pay'];						

						$dis=$doc_dis+$hos_dis;

						//$t1Txt='';if($hos_dis){$t1Txt=' <span class="ff clr5">[ '.number_format($hos_dis).' ]</span>';}
						//$t2Txt='';if($doc_dis){$t2Txt=' <span class="ff clr5">[ '.number_format($doc_dis).' ]</span>';}

						$t1+=$hos_part;$t2+=$doc_part;$t3+=$dis;$t4+=$pay_net;$t5+=$hos_bal;$t6+=$doc_bal;$t8+=$cost;
						$doc_per=$doc_bal*100/$doc_part;
						$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
						echo '<tr>
						<td><ff>'.$s_id.'</ff></td>
						<td><ff>'.date('Y-m-d',$d_start).'</ff></td>
						<td class="f1 fs14">'.get_p_name($patient).'</td>
						<td class="f1 fs14">'.get_val('cln_m_services','name_'.$lg,$service).'</td>
						<td><ff>'.number_format($hos_part).$t1Txt.'</ff></td>
						<td><ff>'.number_format($doc_part).$t2Txt.'</ff></td>
						
						<td><ff>'.number_format($total_pay).'</ff></td>
						<td><ff>'.number_format($hos_bal).'</ff></td>
						<td><ff>'.number_format($cost).'</ff></td>
						<td><ff>'.number_format($doc_bal).'</ff></td>
						<td><ff>'.$doc_per_txt.'</ff></td>
						</tr>';
					}
					$in=get_sum('gnr_x_acc_payments','amount'," type IN(1,2) and date>'$d_s' and date < '$d_e'");				
					$out=get_sum('gnr_x_acc_payments','amount'," type IN(3,4) and date>'$d_s' and date < '$d_e'");
					$p_no=getTotalCO('cln_x_visits'," d_start>'$d_s' and d_start < '$d_e' ");
					echo '<tr fot>
					<td colspan="4" class="f1 fs16">'.k_total.'</td>						
					<td><ff>'.number_format($t1).'</ff></td>
					<td><ff>'.number_format($t2).'</ff></td>
					
					<td><ff>'.number_format($t4).'</ff></td>
					<td><ff>'.number_format($t5).'</ff></td>
					<td><ff>'.number_format($t8).'</ff></td>
					<td><ff>'.number_format($t6).'</ff></td>
					<td></td>
					</tr>';
					?></table><?
				}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}
			}
		}else{echo '<div class="f1 fs16 clr5">'.k_err_ent_date.'</div>';}
	}		
}
if($page==5){
	//$reportGroup='nlh8spit9q';$clinic_type=3;
	$doc=0;if($thisGrp==$reportGroup){$val=$thisUser;$doc=1;}		
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);	
		echo $breakC;
		echo repTitleShow();
		if($val==0){
			$d_s=$todyU;
			$d_e=$d_s+86400;
			$q='';
			echo '<div class="f1 fs18 clr1 lh40">'.$add_title.'</div>';
			?>
			<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
			<tr>            	
				<th width="20">#</th>
				<th><?=k_doctor?></th>
				<th><?=k_services?></th>
				<th><?=k_nt_prv?></th>
				<th><?=k_nt_actn?></th>
				<th><?=k_discount?></th>
				<th><?=k_totl?></th>
				<th><?=k_hsp_rvnu?></th>
				<th><?=k_general_expenses?></th>
				<th><?=k_incvs_doc?></th>
				<th><?=k_perc_doc?></th>         			
			</tr><?
			"select id , name_$lg , subgrp from _users where `grp_code` IN('$reportGroup') order by name_$lg ASC";  
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$iii=0;
				$pm1=0;$pm2=0;$pm3=0;$pm4=0;$pm5=0;$pm6=0;			
				while($r=mysql_f($res)){
					$u_id=$r['id'];
					$name=$r['name_'.$lg];
					$clinic=$r['subgrp'];
					$sql2="select 
					SUM(srv)t0 , 
					SUM(prv)t1 , 
					SUM(opr)t2 , 				
					SUM(prv_d)t11 ,
					SUM(por_d)t22 ,				
					SUM(hos_p)t5 , 
					SUM(doc_p)t6 ,
					SUM(cost)t8 ,
					AVG(doc_per)t7
					from gnr_r_docs  where doc='$u_id' and date >='$d_s' and date < '$d_e' ";
					$res2=mysql_q($sql2);
					$r2=mysql_f($res2);
					$tt0=$r2['t0'];
					$tt11=$r2['t11'];
					$tt22=$r2['t22'];
					$tt1=$r2['t1']-$tt11;
					$tt2=$r2['t2']-$tt22;

					$tt3=$tt11+$tt22;
					$tt4=$tt1+$tt2;
					$tt5=$r2['t5'];
					$tt6=$r2['t6'];
					$doc_per=$r2['t7'];
					$tt8=$r2['t8'];
					//$doc_per=$tt6*100/$tt2;
					$pm0+=$tt0;$pm1+=$tt1+$tt11;$pm2+=$tt2+$tt22;$pm3+=$tt3;$pm4+=$tt4;$pm5+=$tt5;$pm6+=$tt6;$pm8+=$tt8;

					$tt6=round($tt6,-1);
					$tt5=$tt4-$tt6;

					$t1Txt='';if($tt11){$t1Txt=' <span class="ff clr5">[ '.number_format($tt11).' ]</span>';}
					$t2Txt='';if($tt22){$t2Txt=' <span class="ff clr5">[ '.number_format($tt22).' ]</span>';}
					$doc_per=0;
					if($tt2){
						$doc_per=$tt6*100/$tt2;
					}
					$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
					if($tt0){
						$iii++;
						echo '<tr>
						<td><ff>'.$iii.'</ff></td>						
						<td class="f1 fs14">'.$name.' [ '.get_val('gnr_m_clinics','name_'.$lg,$clinic).' ]</td>
						<td><ff>'.number_format($tt0).'</ff></td>
						<td><ff>'.number_format($tt1+$tt11).$t1Txt.'</ff></td>
						<td><ff>'.number_format($tt2+$tt22).$t2Txt.'</ff></td>
						<td><ff>'.number_format($tt3).'</ff></td>
						<td><ff>'.number_format($tt4).'</ff></td>
						<td><ff>'.number_format($tt5).'</ff></td>		
						<td><ff>'.number_format($tt8).'</ff></td>
						<td><ff>'.number_format($tt6).'</ff></td>
						<td><ff>'.$doc_per_txt.'</ff></td>
						</tr>';
					}
				}
				/***************/
				echo '<tr fot>
				<td class="f1 fs14" colspan="2">'.k_total.'</td>
				<td><ff>'.number_format($pm0).'</ff></td>
				<td><ff>'.number_format($pm1).'</ff></td>
				<td><ff>'.number_format($pm2).'</ff></td>
				<td><ff>'.number_format($pm3).'</ff></td>
				<td><ff>'.number_format($pm4).'</ff></td>
				<td><ff>'.number_format($pm5).'</ff></td>
				<td><ff>'.number_format($pm8).'</ff></td>
				<td><ff>'.number_format($pm6).'</ff></td>
				<td></td>
				</tr>';
			}
			?>
			</table><?                           
		}else{			
			$d_s=$todyU;
			$d_e=$d_s+86400;
			$q='';

			$sql="select * from cln_x_visits_services  where status=1 and doc='$val' and d_start >= $d_s and d_start < $d_e ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$clinic=get_val('_users','subgrp',$val);
			echo '<div class="f1 fs18 clr1 lh40">'.get_val('_users','name_'.$lg,$val).' [ '.get_val('gnr_m_clinics','name_'.$lg,$clinic).' ] <ff> ( '.number_format($rows).' ) </ff></div>';
			if($rows>0){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th width="20"><?=k_num_serv?></th>                        
					<th><?=k_patient?></th>            
					<th><?=k_service?></th>
					<th><?=k_nt_prv?></th>
					<th><?=k_nt_actn?></th>
					<th><?=k_discount?></th>
					<th><?=k_totl?></th>
					<th><?=k_hsp_rvnu?></th>
					<th><?=k_expenss?></th>
					<th><?=k_incvs_doc?></th>
					<th><?=k_perc_doc?></th>
				</tr><?                    
				$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t11=0;$t22=0;                   
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$patient=$r['patient'];
					$hos_part=$r['hos_part'];
					$doc_part=$r['doc_part'];
					$doc_percent=$r['doc_percent'];
					$pay_net=$r['pay_net'];
					$service=$r['service'];
					$pay_type=$r['pay_type'];
					$d_start=$r['d_start'];
					$doc_bal=$r['doc_bal'];
					$doc_dis=$r['doc_dis'];
					$hos_bal=$r['hos_bal'];
					$hos_dis=$r['hos_dis'];
					$cost=$r['cost'];
					$total_pay=$r['total_pay'];
					$dis=$doc_dis+$hos_dis;

					$t1Txt='';if($hos_dis){$t1Txt=' <span class="ff clr5">[ '.number_format($hos_dis).' ]</span>';}
					$t2Txt='';if($doc_dis){$t2Txt=' <span class="ff clr5">[ '.number_format($doc_dis).' ]</span>';}

					$t1+=$hos_part;$t2+=$doc_part;$t3+=$dis;$t4+=$pay_net;$t5+=$hos_bal;$t6+=$doc_bal;$t8+=$cost;
					$doc_per=$doc_bal*100/$doc_part;
					$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
					echo '<tr>
					<td><ff>'.$s_id.'</ff></td>						
					<td class="f1 fs14">'.get_p_name($patient).'</td>
					<td class="f1 fs14">'.get_val('cln_m_services','name_'.$lg,$service).'</td>
					<td><ff>'.number_format($hos_part).$t1Txt.'</ff></td>
					<td><ff>'.number_format($doc_part).$t2Txt.'</ff></td>
					<td><ff>'.number_format($dis).'</ff></td>
					<td><ff>'.number_format($total_pay).'</ff></td>
					<td><ff>'.number_format($hos_bal).'</ff></td>
					<td><ff>'.number_format($cost).'</ff></td>
					<td><ff>'.number_format($doc_bal).'</ff></td>
					<td><ff>'.$doc_per_txt.'</ff></td>
					</tr>';
				}
				$in=get_sum('gnr_x_acc_payments','amount'," type IN(1,2) and date>'$d_s' and date < '$d_e'");
				$out=get_sum('gnr_x_acc_payments','amount'," type IN(3,4) and date>'$d_s' and date < '$d_e'");
				$p_no=getTotalCO('cln_x_visits'," d_start>'$d_s' and d_start < '$d_e' ");
				echo '<tr fot>
				<td colspan="3" class="f1 fs16">'.k_total.'</td>	
				<td><ff>'.number_format($t1).'</ff></td>
				<td><ff>'.number_format($t2).'</ff></td>
				<td><ff>'.number_format($t3).'</ff></td>
				<td><ff>'.number_format($t4).'</ff></td>					
				<td><ff>'.number_format($t5,1).'</ff></td>
				<td><ff>'.number_format($t8).'</ff></td>
				<td><ff>'.number_format($t6,1).'</ff></td>
				<td></td>
				</tr>';
				?></table><?
			}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}      
		}
	}
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood); 
		echo $breakC;
		echo repTitleShow();
		if($val){$clinic=get_val('_users','subgrp',$val);?>
			<div class="f1 fs18 clr1 lh40"><?=get_val('_users','name_'.$lg,$val)?> [ <?=get_val('gnr_m_clinics','name_'.$lg,$clinic)?> ]</div>
		<? }?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th width="30"><?=k_tday?></th>
			<th><?=k_services?></th>
			<th><?=k_nt_prv?></th>
			<th><?=k_nt_actn?></th>
			<th><?=k_discount?></th>
			<th><?=k_totl?></th>
			<th><?=k_hsp_rvnu?></th>
			<th><?=k_expenss?></th>
			<th><?=k_incvs_doc?></th>
			<th><?=k_perc_doc?></th>             			
		</tr>  
		<?
		$pm0=0;$pm1=0;$pm2=0;$pm3=0;$pm4=0;$pm5=0;$pm6=0;          
		for($ss=0;$ss<$monLen;$ss++){
			$d_s=$mm+($ss*86400);
			$d_e=$d_s+86400;
			if($val){$q="and  doc='$val'"; }else{$q="";}
			/************************************/				
			$sql2="select 
			SUM(srv)t0 , 
			SUM(prv)t1 , 
			SUM(opr)t2 , 				
			SUM(prv_d)t11 ,
			SUM(por_d)t22 ,				
			SUM(hos_p)t5 , 
			SUM(doc_p)t6 ,
			AVG(doc_per)t7,
			SUM(cost)t8 

			from gnr_r_docs  where date ='$d_s' and clinic_type='$clinic_type' $q ";
			$res2=mysql_q($sql2);
			$r2=mysql_f($res2);
			$tt0=$r2['t0'];
			$tt11=$r2['t11'];
			$tt22=$r2['t22'];
			$tt1=$r2['t1']-$tt11;
			$tt2=$r2['t2']-$tt22;

			$tt3=$tt11+$tt22;
			$tt4=$tt1+$tt2;
			$tt5=$r2['t5'];
			$tt6=$r2['t6'];
			$doc_per=$r2['t7'];
			$tt8=$r2['t8'];
			//$doc_per=$tt6*100/$tt2;
			$pm0+=$tt0;$pm1+=$tt1+$tt11;$pm2+=$tt2+$tt22;$pm3+=$tt3;$pm4+=$tt4;$pm5+=$tt5;$pm6+=$tt6;$pm8+=$tt8;

			$tt6=round($tt6,-1);
			$tt5=$tt4-$tt6;

			$t1Txt='';if($tt11){$t1Txt=' <span class="ff clr5">[ '.number_format($tt11).' ]</span>';}
			$t2Txt='';if($tt22){$t2Txt=' <span class="ff clr5">[ '.number_format($tt22).' ]</span>';}
			$doc_per=0;
			if($tt2){
				$doc_per=$tt6*100/$tt2;
			}
			$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
			if($tt0){
				echo '<tr>
				<td class="Over" onclick="loadRep('.$page.',0,'.$d_s.')"><ff>'.($ss+1).'</ff></td>
				<td><ff>'.number_format($tt0).'</ff></td>
				<td><ff>'.number_format($tt1+$tt11).$t1Txt.'</ff></td>
				<td><ff>'.number_format($tt2+$tt22).$t2Txt.'</ff></td>
				<td><ff>'.number_format($tt3).'</ff></td>
				<td><ff>'.number_format($tt4).'</ff></td>
				<td><ff>'.number_format($tt5).'</ff></td>
				<td><ff>'.number_format($tt8).'</ff></td>
				<td><ff>'.number_format($tt6).'</ff></td>
				<td><ff>'.$doc_per_txt.'</ff></td>
				</tr>';
			}

			/***************************************/
		}
		$pm5=round($pm5,-1);
		echo '<tr fot>
			<td class="f1 fs14">'.k_total.'</td>
			<td><ff>'.number_format($pm0).'</ff></td>
			<td><ff>'.number_format($pm1).'</ff></td>
			<td><ff>'.number_format($pm2).'</ff></td>
			<td><ff>'.number_format($pm3).'</ff></td>
			<td><ff>'.number_format($pm4).'</ff></td>
			<td><ff>'.number_format($pm5).'</ff></td>
			<td><ff>'.number_format($pm8).'</ff></td>
			<td><ff>'.number_format($pm6).'</ff></td>
			<td></td>
			</tr>';
		?>
		</table><?		
	}
	if($tab==2){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);			
		$d_s=$mm;
		$d_e=$mm+($monLen*86400);
		echo $breakC;
		echo repTitleShow();?>			
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>            	
			<th width="20">#</th>
			<th><?=k_doctor?></th>
			<th><?=k_services?></th>
			<th><?=k_nt_prv?></th>

			<th><?=k_nt_actn?></th>
			
			<th><?=k_totl?></th>
			<th><?=k_hsp_rvnu?></th>
			<th><?=k_expenss?></th>
			<th><?=k_incvs_doc?></th>
			<th><?=k_perc_doc?></th>         			
		</tr><?
		$sql="select id , name_$lg , subgrp from _users where `grp_code` IN('$reportGroup') order by name_$lg ASC";  
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$iii=0;
			$pm1=0;$pm2=0;$pm3=0;$pm4=0;$pm5=0;$pm6=0;			
			while($r=mysql_f($res)){
				$u_id=$r['id'];
				$name=$r['name_'.$lg];
				$clinic=$r['subgrp'];	

				$sql2="select 
				SUM(srv)t0 , 
				SUM(prv)t1 , 
				SUM(opr)t2 , 				
				SUM(prv_d)t11 ,
				SUM(por_d)t22 ,				
				SUM(hos_p)t5 , 
				SUM(doc_p)t6 ,
				SUM(cost)t8 ,
				AVG(doc_per)t7

				from gnr_r_docs  where doc='$u_id' and date >='$d_s' and date < '$d_e' ";

				$res2=mysql_q($sql2);
				$r2=mysql_f($res2);
				$r2['r'];
				$tt0=$r2['t0'];
				$tt11=$r2['t11'];
				$tt22=$r2['t22'];
				$tt1=$r2['t1']-$tt11;
				$tt2=$r2['t2']-$tt22;
				$tt3=$tt11+$tt22;
				$tt4=$tt1+$tt2;
				$tt5=$r2['t5'];
				$tt6=$r2['t6'];
				$tt8=$r2['t8'];
				$doc_per=$r2['t7'];
				//$doc_per=$tt6*100/$tt2;
				$pm0+=$tt0;$pm1+=$tt1+$tt11;$pm2+=$tt2+$tt22;$pm3+=$tt3;$pm4+=$tt4;$pm5+=$tt5;$pm6+=$tt6;$pm8+=$tt8;

				$tt6=round($tt6,-1);
				$tt5=$tt4-$tt6;

				//$t1Txt='';if($tt11){$t1Txt=' <span class="ff clr5">[ '.number_format($tt11).' ]</span>';}
				//$t2Txt='';if($tt22){$t2Txt=' <span class="ff clr5">[ '.number_format($tt22).' ]</span>';}
				$doc_per=0;
				if($tt2){
					$doc_per=$tt6*100/$tt2;
				}
				$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
				if($tt0){
					$iii++;
					echo '<tr>
					<td><ff>'.$iii.'</ff></td>						
					<td class="f1 fs14">'.$name.' [ '.get_val('gnr_m_clinics','name_'.$lg,$clinic).' ]</td>
					<td><ff>'.number_format($tt0).'</ff></td>
					<td><ff>'.number_format($tt1+$tt11).$t1Txt.'</ff></td>
					<td><ff>'.number_format($tt2+$tt22).$t2Txt.'</ff></td>
					
					<td><ff>'.number_format($tt4).'</ff></td>
					<td><ff>'.number_format($tt5).'</ff></td>
					<td><ff>'.number_format($tt8).'</ff></td>
					<td><ff>'.number_format($tt6).'</ff></td>
					<td><ff>'.$doc_per_txt.'</ff></td>
					</tr>';
				}
			}
			/***************/
			echo '<tr fot>
			<td class="f1 fs14" colspan="2">'.k_total.'</td>
			<td><ff>'.number_format($pm0).'</ff></td>
			<td><ff>'.number_format($pm1).'</ff></td>
			
			<td><ff>'.number_format($pm3).'</ff></td>
			<td><ff>'.number_format($pm4).'</ff></td>
			<td><ff>'.number_format($pm5).'</ff></td>
			<td><ff>'.number_format($pm8).'</ff></td>
			<td><ff>'.number_format($pm6).'</ff></td>
			<td></td>
			</tr>';
		}
		?>
		</table><?		
	}
	if($tab==3){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		echo $breakC;
		echo repTitleShow();
		if($d_s<$d_e){
			if($val==0){?>
				<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>            	
			<th width="20">#</th>
		  <th><?=k_doctor?></th>
			<th><?=k_services?></th>
			<th><?=k_nt_prv?></th>
			<th><?=k_nt_actn?></th>
			<th><?=k_discount?></th>
			<th><?=k_totl?></th>
			<th><?=k_hsp_rvnu?></th>
			<th><?=k_expenss?></th>
			<th><?=k_incvs_doc?></th>
			<th><?=k_perc_doc?></th>          			
		</tr><?
		$sql="select id , name_$lg , subgrp from _users where `grp_code` IN('$reportGroup') order by name_$lg ASC";  
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$iii=0;
			$pm1=0;$pm2=0;$pm3=0;$pm4=0;$pm5=0;$pm6=0;			
			while($r=mysql_f($res)){
				$u_id=$r['id'];
				$name=$r['name_'.$lg];
				$subgrp=$r['subgrp'];	

				$sql2="select 
				SUM(srv)t0 , 
				SUM(prv)t1 , 
				SUM(opr)t2 , 				
				SUM(prv_d)t11 ,
				SUM(por_d)t22 ,				
				SUM(hos_p)t5 , 
				SUM(doc_p)t6 ,
				SUM(cost)t8 ,
				AVG(doc_per)t7

				from gnr_r_docs  where doc='$u_id' and date >='$d_s' and date < '$d_e' ";
				$res2=mysql_q($sql2);
				$r2=mysql_f($res2);
				$tt0=$r2['t0'];
				$tt11=$r2['t11'];
				$tt22=$r2['t22'];
				$tt1=$r2['t1']-$tt11;
				$tt2=$r2['t2']-$tt22;

				$tt3=$tt11+$tt22;
				$tt4=$tt1+$tt2;
				$tt5=$r2['t5'];
				$tt6=$r2['t6'];
				$doc_per=$r2['t7'];
				$tt8=$r2['t8'];
				//$doc_per=$tt6*100/$tt2;
				$pm0+=$tt0;$pm1+=$tt1+$tt11;$pm2+=$tt2+$tt22;$pm3+=$tt3;$pm4+=$tt4;$pm5+=$tt5;$pm6+=$tt6;$pm8+=$tt8;

				$tt6=round($tt6,-1);
				$tt5=$tt4-$tt6;

				$t1Txt='';if($tt11){$t1Txt=' <span class="ff clr5">[ '.number_format($tt11).' ]</span>';}
				$t2Txt='';if($tt22){$t2Txt=' <span class="ff clr5">[ '.number_format($tt22).' ]</span>';}
				$doc_per=0;
				if($tt2){
					$doc_per=$tt6*100/$tt2;
				}
				$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
				if($tt0){
					$iii++;
					echo '<tr>
					<td><ff>'.$iii.'</ff></td>						
					<td class="f1 fs14">'.$name.' [ '.get_val('gnr_m_clinics','name_'.$lg,$subgrp).' ]</td>
					<td><ff>'.number_format($tt0).'</ff></td>
					<td><ff>'.number_format($tt1+$tt11).$t1Txt.'</ff></td>
					<td><ff>'.number_format($tt2+$tt22).$t2Txt.'</ff></td>
					<td><ff>'.number_format($tt3).'</ff></td>
					<td><ff>'.number_format($tt4).'</ff></td>
					<td><ff>'.number_format($tt5).'</ff></td>
					<td><ff>'.number_format($tt8).'</ff></td>
					<td><ff>'.number_format($tt6).'</ff></td>
					<td><ff>'.$doc_per_txt.'</ff></td>
					</tr>';
				}
			}
			/***************/
			echo '<tr fot>
			<td class="f1 fs14" colspan="2">'.k_total.'</td>
			<td><ff>'.number_format($pm0).'</ff></td>
			<td><ff>'.number_format($pm1).'</ff></td>
			<td><ff>'.number_format($pm2).'</ff></td>
			<td><ff>'.number_format($pm3).'</ff></td>
			<td><ff>'.number_format($pm4).'</ff></td>
			<td><ff>'.number_format($pm5).'</ff></td>
			<td><ff>'.number_format($pm8).'</ff></td>
			<td><ff>'.number_format($pm6).'</ff></td>
			<td></td>
			</tr>';
		}
		?>
		</table><?
			}else{					
				$q='';				
				$sql="select * from cln_x_visits_services  where status=1 and doc='$val' and d_start > '$d_s' and d_start < '$d_e' order by id ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				$clinic=get_val('_users','subgrp',$val);
				echo '<div class="f1 fs18 clr1 lh40">'.get_val('_users','name_'.$lg,$val).' [ '.get_val('gnr_m_clinics','name_'.$lg,$clinic).' ] <ff> ( '.number_format($rows).' ) 
				</ff></div><?=$breakC?>';
				if($rows>0){?>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
					<tr>
						<th width="20"><?=k_num_serv?></th>
						<th><?=k_date?></th>            
						<th><?=k_patient?></th>            
						<th><?=k_service?></th>
						<th><?=k_nt_prv?></th>
						<th><?=k_nt_actn?></th>
						<th><?=k_discount?></th>
						<th><?=k_totl?></th>
						<th><?=k_hsp_rvnu?></th>
						<th><?=k_expenss?></th>
						<th><?=k_incvs_doc?></th>
						<th><?=k_perc_doc?></th>
					</tr><?
					$t1=0;$t2=0;$t3=0;$t4=0;$t5=0;$t6=0;$t11=0;$t22=0;                   
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						$patient=$r['patient'];
						$hos_part=$r['hos_part'];
						$doc_part=$r['doc_part'];
						$doc_percent=$r['doc_percent'];
						$pay_net=$r['pay_net'];
						$service=$r['service'];
						$pay_type=$r['pay_type'];
						$d_start=$r['d_start'];
						$doc_bal=$r['doc_bal'];
						$doc_dis=$r['doc_dis'];
						$hos_bal=$r['hos_bal'];
						$hos_dis=$r['hos_dis'];							
						$cost=$r['cost'];
						$total_pay=$r['total_pay'];						

						$dis=$doc_dis+$hos_dis;

						$t1Txt='';if($hos_dis){$t1Txt=' <span class="ff clr5">[ '.number_format($hos_dis).' ]</span>';}
						$t2Txt='';if($doc_dis){$t2Txt=' <span class="ff clr5">[ '.number_format($doc_dis).' ]</span>';}

						$t1+=$hos_part;$t2+=$doc_part;$t3+=$dis;$t4+=$pay_net;$t5+=$hos_bal;$t6+=$doc_bal;$t8+=$cost;
						$doc_per=$doc_bal*100/$doc_part;
						$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
						echo '<tr>
						<td><ff>'.$s_id.'</ff></td>
						<td><ff>'.date('Y-m-d',$d_start).'</ff></td>
						<td class="f1 fs14">'.get_p_name($patient).'</td>
						<td class="f1 fs14">'.get_val('cln_m_services','name_'.$lg,$service).'</td>
						<td><ff>'.number_format($hos_part).$t1Txt.'</ff></td>
						<td><ff>'.number_format($doc_part).$t2Txt.'</ff></td>
						<td><ff>'.number_format($dis).'</ff></td>
						<td><ff>'.number_format($total_pay).'</ff></td>
						<td><ff>'.number_format($hos_bal).'</ff></td>
						<td><ff>'.number_format($cost).'</ff></td>
						<td><ff>'.number_format($doc_bal).'</ff></td>
						<td><ff>'.$doc_per_txt.'</ff></td>
						</tr>';
					}
					$in=get_sum('gnr_x_acc_payments','amount'," type IN(1,2) and date>'$d_s' and date < '$d_e'");				
					$out=get_sum('gnr_x_acc_payments','amount'," type IN(3,4) and date>'$d_s' and date < '$d_e'");
					$p_no=getTotalCO('cln_x_visits'," d_start>'$d_s' and d_start < '$d_e' ");
					echo '<tr fot>
					<td colspan="4" class="f1 fs16">'.k_total.'</td>						
					<td><ff>'.number_format($t1).'</ff></td>
					<td><ff>'.number_format($t2).'</ff></td>
					<td><ff>'.number_format($t3).'</ff></td>
					<td><ff>'.number_format($t4).'</ff></td>
					<td><ff>'.number_format($t5).'</ff></td>
					<td><ff>'.number_format($t8).'</ff></td>
					<td><ff>'.number_format($t6).'</ff></td>
					<td></td>
					</tr>';
					?></table><?
				}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}
			}
		}else{echo '<div class="f1 fs16 clr5">'.k_err_ent_date.'</div>';}
	}		
}
if($page==6){	
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
	}
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm+($ss*86400);
		$d_e=$d_s+($monLen*86400);
	}
	if($tab==2){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
	}
	if($tab<3){
		echo $breakC;
		echo repTitleShow();
		$q='';
		if($val){$q=" and charity='$val' ";}
		echo '<div class="f1 fs18 clr1 lh40">'.get_val('gnr_m_charities','name_'.$lg,$val).'</div>';
		$sql="select * from gnr_x_charities_srv where date>='$d_s' and date< '$d_e' $q order by date DESC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<th><?=k_date?></th>
				<th><?=k_patient?></th>					
				<th><?=k_department?></th>					
				<th><?=k_service?></th>
				<th><?=k_status?></th>
				<th><?=k_price?></th>
				<th><?=k_rcvble?></th>
			</tr><?
			$p1=$p2=0;
			while($r=mysql_f($res)){
				$rec_no=$r['rec_no'];
				$patient=$r['patient'];
				$mood=$r['mood'];
				$clinic=$r['clinic'];
				$vis=$r['vis'];
				$x_srv=$r['x_srv'];
				$m_srv=$r['m_srv'];
				$srv_price=$r['srv_price'];
				$srv_covered=$r['srv_covered'];
				$date=$r['date'];
				$status=$r['status'];
				$p1+=$srv_price;
				$p2+=$srv_covered;
				$clinicTxt='';
				$statusTxt='بانتظار تنفيذ الخدمة';
				$statusClr='clr5';
				if($status){$statusTxt='تمت الخدمة';$statusClr='clr6';}
				if($mood!=2){
					$clinicTxt='<div class="f1 clr1">'.get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'cln').'</div>';
				}
				$serviceTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$m_srv,'srv'.$mood);
				$srvDate=date('A h:i',$date);
				if($tab){$srvDate=date('Y-m-d',$date);}
				echo '<tr>
					<td><ff14>'.$srvDate.'</ff14><div class="clr5 fs14">'.$rec_no.'</div></td>
					<td class="f1">'.get_p_name($patient,5).'</td>
					<td class="f1">'.$clinicTypes[$mood].$clinicTxt.'</td>
					<td class="f1">'.$serviceTxt.'</td>
					<td><div class="f1 '.$statusClr.'">'.$statusTxt.'</div></td>
					<td><ff class="clr1">'.number_format($srv_price).'</ff></td>
					<td><ff class="clr5">'.number_format($srv_covered).'</ff></td>
				</tr>';
			}
			echo '<tr fot>
				<td colspan="5" class="f1 fs16">'.k_total.'</td>
				<td><ff class="clr1">'.number_format($p1).'</ff></td>
				<td><ff class="clr5">'.number_format($p2).'</ff></td>
				</tr>';
			?></table><?			
		}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}
	}
	if($tab==3){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
		echo $breakC;
		echo repTitleShow();
		if($val==0){	
			echo '<div class="f1 fs18 clr1 lh40">'.$add_title.'</div>';
			$sql="select * from gnr_r_charities where date='$d_s'  order by covered DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th><?=k_the_charity?></th>					
					<th><?=k_service?></th>					
					<th><?=k_price?></th>
					<th><?=k_rcvble?></th>
				</tr><?
				$p1=$p2=$p3=0;				
				while($r=mysql_f($res)){
					$c_id=$r['charity'];
					$srvs=$r['srvs'];
					$price=$r['price'];
					$covered=$r['covered'];
					$p1+=$srvs;
					$p2+=$price;
					$p3+=$covered;
					$name=get_val('gnr_m_charities','name_'.$lg,$c_id);					
					echo '<tr>
					<td class="f1 fs14 cur " onclick="chnRepVal('.$c_id.')">'.$name.'</td>
					<td><ff class="clr1">'.number_format($srvs).'</ff></td>
					<td><ff class="clr6">'.number_format($price).'</ff></td>
					<td><ff class="clr5">'.number_format($covered).'</ff></td>
					</tr>';
					
				}					
				echo '
				<tr fot>
				<td class="f1 fs14">'.k_total.'</td>
				<td><ff class="clr1">'.number_format($p1).'</ff></td>
				<td><ff class="clr6">'.number_format($p2).'</ff></td>
				<td><ff class="clr5">'.number_format($p3).'</ff></td>
				</tr>';
				?></table><?
			}else{echo '<div class="f1 fs18 clr5">'.k_nsrvs_cmpt.'</div>';}          
		}else{		
			$d_s=$todyU;
			$d_e=$d_s+86400;
			echo '<div class="f1 fs18 clr1 lh40">'.get_val('gnr_m_charities','name_'.$lg,$val).'</div>';
			$sql="select * from gnr_x_charities_srv where date>='$d_s' and date< '$d_e' and charity='$val' order by date DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th><?=k_date?></th>
					<th><?=k_patient?></th>					
					<th><?=k_department?></th>					
					<th><?=k_service?></th>
					<th><?=k_status?></th>
					<th><?=k_price?></th>
					<th><?=k_rcvble?></th>
				</tr><?
				$p1=$p2=0;
				while($r=mysql_f($res)){
					$rec_no=$r['rec_no'];
					$patient=$r['patient'];
					$mood=$r['mood'];
					$clinic=$r['clinic'];
					$vis=$r['vis'];
					$x_srv=$r['x_srv'];
					$m_srv=$r['m_srv'];
					$srv_price=$r['srv_price'];
					$srv_covered=$r['srv_covered'];
					$date=$r['date'];
					$status=$r['status'];
					$p1+=$srv_price;
					$p2+=$srv_covered;
					$clinicTxt='';
					$statusTxt='بانتظار تنفيذ الخدمة';
					$statusClr='clr5';
					if($status){$statusTxt='تمت الخدمة';$statusClr='clr6';}
					if($mood!=2){
						$clinicTxt='<div class="f1 clr1">'.get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'cln').'</div>';
					}
					$serviceTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$m_srv,'srv'.$mood);
					echo '<tr>
						<td><ff14>'.date('A h:i',$date).'</ff14><div class="clr5 fs14">'.$rec_no.'</div></td>
						<td class="f1">'.get_p_name($patient,5).'</td>
						<td class="f1">'.$clinicTypes[$mood].$clinicTxt.'</td>
						<td class="f1">'.$serviceTxt.'</td>
						<td><div class="f1 '.$statusClr.'">'.$statusTxt.'</div></td>
						<td><ff class="clr1">'.number_format($srv_price).'</ff></td>
						<td><ff class="clr5">'.number_format($srv_covered).'</ff></td>
					</tr>';
				}
				echo '<tr fot>
					<td colspan="5" class="f1 fs16">'.k_total.'</td>
					<td><ff class="clr1">'.number_format($p1).'</ff></td>
					<td><ff class="clr5">'.number_format($p2).'</ff></td>
					</tr>';
				?></table><?			
			}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}
		}
	}
	if($tab==4){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm+($ss*86400);
		$d_e=$d_s+($monLen*86400);
		echo $breakC;
		echo repTitleShow();
		if($val==0){
			echo '<div class="f1 fs18 clr1 lh40">'.$add_title.'</div>';
			$sql="select id , name_$lg from gnr_m_charities order by name_$lg ASC";				
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th><?=k_the_charity?></th>					
					<th><?=k_service?></th>					
					<th><?=k_price?></th>
					<th><?=k_rcvble?></th>     
				</tr><?
				$p1=$p2=$p3=0;
				while($r=mysql_f($res)){
					$c_id=$r['id'];
					$name=$r['name_'.$lg];
					$sql2="select sum(srvs) as s , sum(price) as p , sum(covered) as c from gnr_r_charities where date >='$d_s' and date <'$d_e' and charity='$c_id' ";
					$res2=mysql_q($sql2);						
					$r2=mysql_f($res2);
					$srvs=$r2['s'];
					$price=$r2['p'];
					$covered=$r2['c'];
					if($srvs){
						$p1+=$srvs;
						$p2+=$price;
						$p3+=$covered;
						$name=get_val('gnr_m_charities','name_'.$lg,$c_id);
						echo '<tr>
						<td class="f1 fs14 cur " onclick="chnRepVal('.$c_id.')">'.$name.'</td>
						<td><ff class="clr1">'.number_format($srvs).'</ff></td>
						<td><ff class="clr6">'.number_format($price).'</ff></td>
						<td><ff class="clr5">'.number_format($covered).'</ff></td>
						</tr>';
					}
				}					
				echo '
				<tr fot>
				<td class="f1 fs14">'.k_total.'</td>
				<td><ff class="clr1">'.number_format($p1).'</ff></td>
				<td><ff class="clr6">'.number_format($p2).'</ff></td>
				<td><ff class="clr5">'.number_format($p3).'</ff></td>
				</tr>';
				?></table><?
			}else{echo '<div class="f1 fs18 clr5">'.k_nsrvs_cmpt.'</div>';}           
		}else{		
			echo '<div class="f1 fs18 clr1 lh40">'.get_val('gnr_m_charities','name_'.$lg,$val).'</div>';
			$sql="select * from gnr_x_charities_srv where date>='$d_s' and date< '$d_e' and charity='$val' order by date DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th><?=k_date?></th>
					<th><?=k_patient?></th>					
					<th><?=k_department?></th>					
					<th><?=k_service?></th>
					<th><?=k_status?></th>
					<th><?=k_price?></th>
					<th><?=k_rcvble?></th>
				</tr><?
				$p1=$p2=0;
				while($r=mysql_f($res)){
					$rec_no=$r['rec_no'];
					$patient=$r['patient'];
					$mood=$r['mood'];
					$clinic=$r['clinic'];
					$vis=$r['vis'];
					$x_srv=$r['x_srv'];
					$m_srv=$r['m_srv'];
					$srv_price=$r['srv_price'];
					$srv_covered=$r['srv_covered'];
					$date=$r['date'];
					$status=$r['status'];
					$p1+=$srv_price;
					$p2+=$srv_covered;
					$clinicTxt='';
					$statusTxt='بانتظار تنفيذ الخدمة';
					$statusClr='clr5';
					if($status){$statusTxt='تمت الخدمة';$statusClr='clr6';}
					if($mood!=2){
						$clinicTxt='<div class="f1 clr1">'.get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'cln').'</div>';
					}
					$serviceTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$m_srv,'srv'.$mood);
					echo '<tr>
						<td><ff14>'.date('Y-m-d',$date).'</ff14><div class="clr5 fs14">'.$rec_no.'</div></td>
						<td class="f1">'.get_p_name($patient,5).'</td>
						<td class="f1">'.$clinicTypes[$mood].$clinicTxt.'</td>
						<td class="f1">'.$serviceTxt.'</td>
						<td><div class="f1 '.$statusClr.'">'.$statusTxt.'</div></td>
						<td><ff class="clr1">'.number_format($srv_price).'</ff></td>
						<td><ff class="clr5">'.number_format($srv_covered).'</ff></td>
					</tr>';
				}
				echo '<tr fot>
					<td colspan="5" class="f1 fs16">'.k_total.'</td>
					<td><ff class="clr1">'.number_format($p1).'</ff></td>
					<td><ff class="clr5">'.number_format($p2).'</ff></td>
					</tr>';
				?></table><?			
			}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}       
		}		
	}
	if($tab==5){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		echo $breakC;
		echo repTitleShow();
		if($d_s<$d_e){
			if($val==0){				
				echo '<div class="f1 fs18 clr1 lh40">'.$add_title.'</div>';
				$sql="select id , name_$lg from gnr_m_charities order by name_$lg ASC";				
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){?>
					<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
					<tr>
						<th><?=k_the_charity?></th>					
						<th><?=k_service?></th>					
						<th><?=k_price?></th>
						<th><?=k_rcvble?></th>     
					</tr><?
					$p1=$p2=$p3=0;
					while($r=mysql_f($res)){
						$c_id=$r['id'];
						$name=$r['name_'.$lg];
						$sql2="select sum(srvs) as s , sum(price) as p , sum(covered) as c from gnr_r_charities where date >='$d_s' and date <'$d_e' and charity='$c_id' ";
						$res2=mysql_q($sql2);						
						$r2=mysql_f($res2);
						$srvs=$r2['s'];
						$price=$r2['p'];
						$covered=$r2['c'];
						if($srvs){
							$p1+=$srvs;
							$p2+=$price;
							$p3+=$covered;
							$name=get_val('gnr_m_charities','name_'.$lg,$c_id);
							echo '<tr>
							<td class="f1 fs14 cur " onclick="chnRepVal('.$c_id.')">'.$name.'</td>
							<td><ff class="clr1">'.number_format($srvs).'</ff></td>
							<td><ff class="clr6">'.number_format($price).'</ff></td>
							<td><ff class="clr5">'.number_format($covered).'</ff></td>
							</tr>';
						}
					}					
					echo '
					<tr fot>
					<td class="f1 fs14">'.k_total.'</td>
					<td><ff class="clr1">'.number_format($p1).'</ff></td>
					<td><ff class="clr6">'.number_format($p2).'</ff></td>
					<td><ff class="clr5">'.number_format($p3).'</ff></td>
					</tr>';
					?></table><?
				}else{echo '<div class="f1 fs18 clr5">'.k_nsrvs_cmpt.'</div>';}
			}else{		
			echo '<div class="f1 fs18 clr1 lh40">'.get_val('gnr_m_charities','name_'.$lg,$val).'</div>';
			$sql="select * from gnr_x_charities_srv where date>='$d_s' and date< '$d_e' and charity='$val' order by date DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th><?=k_date?></th>
					<th><?=k_patient?></th>					
					<th><?=k_department?></th>					
					<th><?=k_service?></th>
					<th><?=k_status?></th>
					<th><?=k_price?></th>
					<th><?=k_rcvble?></th>
				</tr><?
				$p1=$p2=0;
				while($r=mysql_f($res)){
					$rec_no=$r['rec_no'];
					$patient=$r['patient'];
					$mood=$r['mood'];
					$clinic=$r['clinic'];
					$vis=$r['vis'];
					$x_srv=$r['x_srv'];
					$m_srv=$r['m_srv'];
					$srv_price=$r['srv_price'];
					$srv_covered=$r['srv_covered'];
					$date=$r['date'];
					$status=$r['status'];
					$p1+=$srv_price;
					$p2+=$srv_covered;
					$clinicTxt='';
					$statusTxt='بانتظار تنفيذ الخدمة';
					$statusClr='clr5';
					if($status){$statusTxt='تمت الخدمة';$statusClr='clr6';}
					if($mood!=2){
						$clinicTxt='<div class="f1 clr1">'.get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'cln').'</div>';
					}
					$serviceTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$m_srv,'srv'.$mood);
					echo '<tr>
						<td><ff14>'.date('Y-m-d',$date).'</ff14><div class="clr5 fs14">'.$rec_no.'</div></td>
						<td class="f1">'.get_p_name($patient,5).'</td>
						<td class="f1">'.$clinicTypes[$mood].$clinicTxt.'</td>
						<td class="f1">'.$serviceTxt.'</td>
						<td><div class="f1 '.$statusClr.'">'.$statusTxt.'</div></td>
						<td><ff class="clr1">'.number_format($srv_price).'</ff></td>
						<td><ff class="clr5">'.number_format($srv_covered).'</ff></td>
					</tr>';
				}
				echo '<tr fot>
					<td colspan="5" class="f1 fs16">'.k_total.'</td>
					<td><ff class="clr1">'.number_format($p1).'</ff></td>
					<td><ff class="clr5">'.number_format($p2).'</ff></td>
					</tr>';
				?></table><?			
			}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}             
		}
		}else{echo '<div class="f1 fs16 clr5">'.k_err_ent_date.'</div>';}
	}	
}
if($page==7){
	if($tab==0){	
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
	}
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm+($ss*86400);
		$d_e=$d_s+($monLen*86400);
	}
	if($tab==2){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
	}
	echo $breakC;
	echo repTitleShow();
	$sql="select * from gnr_x_exemption_srv where date>='$d_s' and date< '$d_e'  order by date DESC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){?>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>
			<th><?=k_date?></th>
			<th><?=k_patient?></th>					
			<th><?=k_department?></th>
            <th><?=k_notes?></th>
            <th><?=k_reason?></th>
			<th><?=k_service?></th>			
			<th><?=k_price?></th>            
			<th><?=k_discount?></th>
		</tr><?
		$p1=$p2=0;        
        $services=[];
        $actVis=0;
		while($r=mysql_f($res)){            
			$rec_no=$r['rec_no'];
			$patient=$r['patient'];
			$mood=$r['mood'];
			$clinic=$r['clinic'];
			$vis=$r['vis'];
			$x_srv=$r['x_srv'];
			$m_srv=$r['m_srv'];
			$srv_price=$r['srv_price'];
			$srv_covered=$r['srv_covered'];
			$date=$r['date'];
			$status=$r['status'];
			$p1+=$srv_price;
			$p2+=$srv_covered;
			
            //echo '('.$mood.'-'.$vis.'-'.$m_srv.')';
			
			$srvDate=date('A h:i',$date);
			if($tab){$srvDate=date('Y-m-d',$date);}
                       
            if($actVis!=$vis && $actVis!=0){
                $n=count($services);
                foreach($services as $k=>$s){
                    echo '<tr>';
                    if($k==0){
                        $vis2=$lastRec['vis'];
                        $mood2=$lastRec['mood'];
                        $clinicTxt='';
                        $statusTxt='بانتظار تنفيذ الخدمة';
                        $statusClr='clr5';
                        if($s[3]){$statusTxt='تمت الخدمة';$statusClr='clr6';}
                        if($mood!=2){
                            $clinicTxt='<div class="f1 clr1">'.get_val_arr('gnr_m_clinics','name_'.$lg,$lastRec['clinic'],'cln').'</div>';
                        }
                        $note='';
                       // if(!in_array($vis2,$visits)){
                            $note=get_val_con('gnr_x_exemption_notes','note',"mood='$mood2' and vis='$vis2' ");
                            if($note){$note='<div class="clr5"> '.k_note.':'.$note.'</div>';}
                            $ress=get_val($visXTables[$mood2],'pay_type_link',$vis2);
                            $ressTxt='';
                            if($ress){
                                $ressTxt=get_val('gnr_m_exemption_reasons','reason',$ress);
                            }
                        //} 
                        
                        echo '<td rowspan="'.$n.'"><ff14>'.$srvDate.'</ff14><div class="clr5 fs14">'.$rec_no.'</div></td>
                        <td rowspan="'.$n.'" class="f1">'.get_p_name($lastRec['patient'],5).'</td>
                        <td rowspan="'.$n.'" class="f1">'.$clinicTypes[$mood2].$clinicTxt.'</td>
                        <td rowspan="'.$n.'" class="f1 clr5">'.$note.'</td>
                        <td rowspan="'.$n.'" class="f1">'.$ressTxt.'</td>';
                    }
                    echo '<td class="f1">'.$s[0].'</td>
                    <td><ff class="clr1">'.number_format($s[1]).'</ff></td>
                    <td><ff class="clr5">'.number_format($s[2]).'</ff></td>
                    </tr>';
                    
                }
                unset($services);
            }
            $serviceTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$m_srv,'srv'.$mood);
            $services[]=array($serviceTxt,$srv_price,$srv_covered,$status);
            
            $lastRec=$r;
            $actVis=$vis;
            //k_management_notes.''
		}
        if(count($services)){
            foreach($services as $k=>$s){
                echo '<tr>';
                if($k==0){
                    echo '<td rowspan="'.$n.'"><ff14>'.$srvDate.'</ff14><div class="clr5 fs14">'.$rec_no.'</div></td>
                    <td rowspan="'.$n.'" class="f1">'.get_p_name($lastRec['patient'],5).'</td>
                    <td rowspan="'.$n.'" class="f1">'.$clinicTypes[$mood2].$clinicTxt.'</td>
                    <td rowspan="'.$n.'" class="f1 clr5">'.$note.'</td>
                    <td rowspan="'.$n.'" class="f1">'.$ressTxt.'</td>';
                }
                echo '<td class="f1">'.$s[0].'</td>
                <td><ff class="clr1">'.number_format($s[1]).'</ff></td>
                <td><ff class="clr5">'.number_format($s[2]).'</ff></td>
                </tr>';
            }
        }
		echo '<tr fot>
			<td colspan="6" class="f1 fs16">'.k_total.'</td>
			<td><ff class="clr1">'.number_format($p1).'</ff></td>
			<td><ff class="clr5">'.number_format($p2).'</ff></td>
			</tr>';
		?></table><?			
	}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}
}
if($thisGrp=='7htoys03le'){
	$doc=$thisUser;
	if($page==8){				
		if($tab==0){
			?><div class="fl f1 winOprNote"><?=k_fini_oper?></div><?
			$date=date('Y-m-d H:i:s',$now);
			$sql="select * from cln_x_pro_x_operations where date<'$date' and status=0  and doc='$doc' order by date ASC ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				?>
				<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH">
					<thead>
					<tr>				
					<th><?=k_operation?></th>
					<th><?=k_date_of_operation?></th>
					<th><?=k_patient?></th>
					<th><?=k_the_hospital?></th>
					<th><?=k_status?></th>                
					<th><div>&nbsp;</div></th>
				</tr>
				</thead><tbody><?
				$dayCont=0;
				$Day=0;
				while($r=mysql_f($res)){
					$opr_id=$r['id'];
					$opration=$r['opration'];
					$p_id=$r['p_id'];
					$hospital=$r['hospital'];
					$date=$r['date'];
					$date2=strtotime(substr($date,0,10).' '.substr($date,10,6));
					?>
					<tr>
					<td class="f1 fs14"><?=get_val('cln_m_pro_operations','name_'.$lg,$opration)?></td>
					<td>
					<div class="ff fs16"><?=substr($date,0,10)?></div>
					<div class="ff fs18"><strong><?=substr($date,10,6)?></strong></div>
					</td>
					<td class="f1 fs14"><?=get_p_name($p_id)?></td>
					<td class="f1 fs14"><?=get_val('cln_m_pro_referral_hospitals','name_'.$lg,$hospital)?></td>
					<td class="f1 fs14"><?=k_oper_done_snc?>( <?=timeAgo($now-$date2,' / ',2)?> )</td>

					<td>
						  <div class="fr ic40 icc1 ic40_info" onclick="slopr_d(<?=$opr_id?>,2,'<?=$startW.'-'.$page.'-'.$tab?>')" title="<?=k_oper_info?>"></div>
						  <div class="fr ic40 icc2 ic40_del"  onclick="act_opr_detales=<?=$opr_id?>;delOperation(<?=$opr_id?>)" title="<?=k_delete?>"></div>
						
					</div>
					</td>
					</tr><?
				}

				?>
				</tbody>        
				</table>   
				<? 
			}else{ echo '<div class="warn_msg f1 cb">'.k_no_results.'</div>';}
		}
		if($tab==1){
			echo $breakC;
			if($fil==0){
			$week=getThisWeek();
			$startW=$week[0];
			$endW=$week[1];
		}else{			
			$startW=$fil;
			$endW=$startW+(86400*7);			
		}
			$start=date('Y-m-d h:i:s a',$startW);
			$end=date('Y-m-d h:i:s a',$endW);
			
			//echo '('.$start.'|'.$end.')';
			$sql="select * from cln_x_pro_x_operations where date>'$start' and date<'$end'  and doc='$doc' order by date ASC ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);?>
			<div class="lh40 f1 winOprNote"><?=k_wek_oper_tbl?></div>
			<div class="dateHeader fl lh60" style="margin-bottom:20px;">
			<div class="fl dth dt_l" onclick="<?='loadRep('.$page.','.$tab.','.($startW-(86400*7)).')'?>"></div>
			<div class="fl dHeader dHeader55 f1" >
			<?= k_from.' <ff dir="ltr">'.date('Y-m-d',$startW).'</ff> '.k_to.' <ff dir="ltr">'.date('Y-m-d',$endW).'</ff>';?></div>        
			<div class="fl dth dt_r" onclick="<?='loadRep('.$page.','.$tab.','.$endW.')'?>"></div>
			</div>
			<div class="bu bu_t3 fr" onclick="printReport(1)"><?=k_prn_tbl?></div><div class="uLine cb"></div>
			<div>
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<thead>
				<tr>				
				<th><?=k_day?></th>
				<th><?=k_tim?></th>
				<th><?=k_operation?></th>
				<th><?=k_patient?></th>
				<th><?=k_the_hospital?></th>
				<th><?=k_status?></th>                         
				<th><div>&nbsp;</div></th>
			</tr>
			</thead><tbody><?
				$dates=array();
				$i=0;
				while($r=mysql_f($res)){                     
					$dates[$i]['id']=$r['id'];
					$dates[$i]['opration']=$r['opration'];
					$dates[$i]['p_id']=$r['p_id'];
					$dates[$i]['hospital']=$r['hospital'];
					$dates[$i]['status']=$r['status'];
					$dates[$i]['date']=$r['date'];
					$i++;
				}				
				for($d=$startW;$d<$endW;$d=$d+86400){
					$cols=0;			
					foreach($dates as $da){
						$date=date('U',strtotime($da['date']));
						if($date> $d && $date <($d+86400)){
							$cols++;
						}
					}
					if($cols==0){?>
						<tr>
						<td class="f1 fs14" bgcolor="#fafafa">
						<div class="f1 fs14"><strong><?=$wakeeDays[date('w',$d)]?></strong></div>
						<div><ff><?=date('Y-m-d',$d)?></ff></div>					
						</td>                
						<td colspan="6" class="f1 fs14" bgcolor="#f8f8f8"><?=k_no_oper_today?></td>
						</tr>
					<?					
					}else{
						$f=0;
						foreach($dates as $da){
							$date=date('U',strtotime($da['date']));
							if($date> $d && $date <($d+86400)){
								$opr_id=$da['id'];
								$opration=$da['opration'];
								$p_id=$da['p_id'];
								$hospital=$da['hospital'];
								$status=$da['status'];		
								$date=$da['date'];				
								$date2=date('U',strtotime($date));
								$date3=date('Y-m-d h:i:s a',strtotime($date));
								$bg='';
								if($status==1){
									$bg='#a9ff9b';
									$stat= k_report_done;
								}else{						
									$T_time=$now-$date2; 
									if($T_time>0){
										$bg='#ff9b9b';
										$stat= ' '.k_oper_done_snc.' ( '.timeAgo($T_time).' )';
									}else{
										$stat= ' '.k_rem_tim_for_oper.' ( '.timeAgo($T_time*(-1)).' )';
									}
								}?>				
								<tr bgcolor="<?=$bg?>">
								<? if($f==0){?>
									<td class="f1 fs14" rowspan="<?=$cols?>">
										<div class="f1 fs16"><strong><?=$wakeeDays[date('w',$d)]?></strong></div>
										<div class="ff fs16"><?=date('Y-m-d',$d)?></div>					
									</td>
								<? }?>      
								<td>
								<div class="ff fs18"><strong><?=substr($date3,10,6).' '.substr($date3,20,2)?></strong></div></td>
								<td class="f1 fs14"><?=get_val('cln_m_pro_operations','name_'.$lg,$opration)?></td>
								<td class="f1 fs14"><?=get_p_name($p_id)?></td>
								<td class="f1 fs14"><?=get_val('cln_m_pro_referral_hospitals','name_'.$lg,$hospital)?></td>
								<td class="f1 fs14"><?=$stat?></td>								
								<td>
										<div class="fr ic40 icc1 ic40_info" onclick="slopr_d(<?=$opr_id?>,2,'<?=$startW.'-'.$page.'-'.$tab?>')" title="<?=k_oper_info?>"></div>
										<div class="fr ic40 icc2 ic40_del"  onclick="act_opr_detales=<?=$opr_id?>;delOperation()" title="<?=k_delete?>"></div>
									
								
								</td>
								</tr><?
								$f=1;
							}
						}
					}
				}

				?>
				</tbody>        
				</table>  
			</div><? 
		}
		if($tab==2){
			echo $breakC;
			if($fil==0){				
				$y=date('Y');
				$m=date('n');	
			}else{								
				$y=date('Y',$fil);
				$m=date('n',$fil);
			}
			$last= mktime(0,0,0,$m-1,1,$y);
			$startW = mktime(0,0,0,$m,1,$y);
			$endW = mktime(0,0,0,$m+1,1,$y);

			$start=date('Y-m-d h:i:s a',$startW);
			$end=date('Y-m-d h:i:s a',$endW);
			//echo '('.$start.'|'.$end.')';
			$sql="select * from cln_x_pro_x_operations where date>'$start' and date<'$end'  and doc='$doc' order by date ASC ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);	
			?>
			<div class=" f1 winOprNote lh40"><?=k_mon_opers_tbl?></div>			
			<div class="dateHeader fl lh60" style="margin-bottom:20px;">
				<div class="fl dth dt_l" onclick="<?='loadRep('.$page.','.$tab.','.($last).')'?>"></div>
				<div class="fl dHeader dHeader55 f1"><?= $monthsNames[$m].' <ff">'.$y.'</ff>';?></div>        
				<div class="fl dth dt_r" onclick="<?='loadRep('.$page.','.$tab.','.$endW.')'?>"></div>    
			</div>
			<div class="bu bu_t3 fr" onclick="printReport(1)"><?=k_prn_tbl?></div><div class="uLine cb"></div>
			<?
			if($rows>0){?>

				<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH">
					<thead>
					<tr>				
					<th><?=k_day?></th>
					<th><?=k_day?></th>
					<th><?=k_tim?></th>
					<th><?=k_operation?></th>
					<th><?=k_patient?></th>
					<th><?=k_the_hospital?></th>
					<th><?=k_status?></th>                         
					<th><div>&nbsp;</div></th>
				</tr>
				</thead><tbody><?
					$dates=array();
					$i=0;
					while($r=mysql_f($res)){                     
						$dates[$i]['id']=$r['id'];
						$dates[$i]['opration']=$r['opration'];
						$dates[$i]['p_id']=$r['p_id'];
						$dates[$i]['hospital']=$r['hospital'];
						$dates[$i]['status']=$r['status'];
						$dates[$i]['date']=$r['date'];
						$i++;
					}
					for($d=$startW;$d<$endW;$d=$d+86400){
						$cols=0;						
						foreach($dates as $da){
							$date=date('U',strtotime($da['date']));
							if($date> $d && $date <($d+86400)){
								$cols++;
							}
						}

						if($cols>0){					
							$f=0;
							foreach($dates as $da){
								$date=date('U',strtotime($da['date']));
								if($date> $d && $date <($d+86400)){
									$opr_id=$da['id'];
									$opration=$da['opration'];
									$p_id=$da['p_id'];
									$hospital=$da['hospital'];
									$status=$da['status'];		
									$date=$da['date'];				
									$date2=date('U',strtotime($date));
									$date3=date('Y-m-d h:i:s a',strtotime($date));
									$bg='';
									if($status==1){
										$bg='#a9ff9b';
										$stat= k_oper_done_snc;
									}else{						
										$T_time=$now-$date2; 
										if($T_time>0){
											$bg='#ff9b9b';
											$stat= ' '.k_oper_done_snc.' ( '.timeAgo($T_time).' )';
										}else{
											$stat= ' '.k_rem_tim_for_oper.' ( '.timeAgo($T_time*(-1)).' )';
										}
									}
										?>				
									<tr bgcolor="<?=$bg?>">
									<? if($f==0){?>
										<td class="f1 fs14" rowspan="<?=$cols?>">
											<div class="f1 fs14"><strong><?=$wakeeDays[date('w',$d)]?></strong></div>
											<div><ff><?=date('Y-m-d',$d)?></ff></div>
										</td>
									<? }?>      
									<td>
									<div class="ff fs18"><strong><?=substr($date3,10,6).' '.substr($date3,20,2)?></strong></div></td>
									<td class="f1 fs14"><?=get_val('cln_m_pro_operations','name_'.$lg,$opration)?></td>
									<td class="f1 fs14"><?=get_p_name($p_id)?></td>
									<td class="f1 fs14"><?=get_val('cln_m_pro_referral_hospitals','name_'.$lg,$hospital)?></td>
									<td class="f1 fs14"><?=$stat?></td>								
									<td>
											<div class="fr ic40 icc1 ic40_info" onclick="slopr_d(<?=$opr_id?>,2,'<?=$startW.'-'.$page.'-'.$tab?>')" title="<?=k_oper_info?>"></div>
											<div class="fr ic40 icc2 ic40_del"  onclick="act_opr_detales=<?=$opr_id?>;delOperation()" title="<?=k_delete?>"></div>
									</td>
									</tr><?
									$f=1;
								}
							}
						}


			}

			?>
			</tbody>        
			</table>  
			<? 
			}else{ echo '<div class="warn_msg f1 cb">'.k_no_results.'</div>';}	
		}
	}
	if($page==100){//10
		$q= " and id IN(select patient from cln_x_visits where doctor='$thisUser')";
		$q2=" where id IN(select patient from cln_x_visits where doctor='$thisUser')";
		$q3=" and e.doc='$thisUser' ";
		$q4=" where doctor='$thisUser' ";
		$res=mysql_q("select count(*)c from gnr_m_patients $q2");
		$r=mysql_f($res);$t1=$r['c'];
		$res=mysql_q("select count(*)c from gnr_m_patients where sex=1 $q");
		$r=mysql_f($res);$t2=$r['c'];
		$res=mysql_q("select count(*)c from gnr_m_patients where sex=2 $q");
		$r=mysql_f($res);$t3=$r['c'];
		/******************************************************************************************/
		if($tab==0){
			$chart_title=k_pats_comps;
			$table_1='cln_m_prv_complaints';
			$table_2='cln_x_prv_complaints';
		}
		if($tab==1){
			$chart_title=k_sick_story;
			$table_1='cln_m_prv_story';
			$table_2='cln_x_prv_story';
		}
		if($tab==2){
			$chart_title=k_clincal_examination;
			$table_1='cln_m_prv_clinical';
			$table_2='cln_x_prv_clinical';
		}
		if($tab==3){
			$chart_title=k_diagnoses;
			$table_1='cln_m_prv_diagnosis';
			$table_2='cln_x_prv_diagnosis';
		}
		if($fil){							
				$c_id=get_val_c($table_1,'id',$fil,'name');
				$sql2=" SELECT COUNT(*) AS c FROM gnr_m_patients where sex=1 
				and id IN(select patient from $table_2 where opr_id='$c_id')";
				$res2=mysql_q($sql2);
				$r2=mysql_f($res2);
				$m_res=$r2['c'];
				$sql3=" SELECT COUNT(*) AS c FROM gnr_m_patients where sex=2 
				and id IN(select patient from $table_2 where opr_id='$c_id')";
				$res3=mysql_q($sql3);		
				$r3=mysql_f($res3);
				$f_res=$r3['c'];?>
				<script type="text/javascript">		
				data=new Array(['<?=k_mls?>',<?=$m_res?>],['<?=k_fems?>',<?=$f_res?>]);	
				$('#rep_container').highcharts({
					chart: {
						plotBackgroundColor: null,
						plotBorderWidth: 1,//null,
						plotShadow: false
					},
					title: {
						text: '<?=$fil?>'
					},
					tooltip: {
						pointFormat:'<br>{point.y:.lf}</br>',
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								format: '<div	>{point.name} </div>: <div>%{point.percentage:.1f}</div>',
								style: {
									color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
								}
							}
						}
					},
					series: [{
						type: 'pie',
						name: k_nums,
						data:data
					}],
					colors:['#8c89ee','#ee8989']
				});
				</script>
				<?	
				$res=mysql_q("select count(*)c from gnr_m_patients where  id IN(select patient from $table_2 where opr_id='$c_id')");
				$r=mysql_f($res);
				$t1=$r['c'];

				$res=mysql_q("select count(*)c from gnr_m_patients where sex=1 and id IN(select patient from $table_2 where opr_id='$c_id')");
				$r=mysql_f($res);
				$t2=$r['c'];

				$res=mysql_q("select count(*)c from gnr_m_patients where sex=2 and id IN(select patient from $table_2 where opr_id='$c_id')");
				$r=mysql_f($res);
				$t3=$r['c'];

				$agePer=10;
				$maxAge=100;		
				$script='';
				for($i=0;$i<$maxAge;$i+=$agePer){	
					$smallNum=$i;
					$bigNum=$i+$agePer;
					$y=date('Y');
					$smallNumDate=mktime(0,0,0,1,1,$y-$smallNum);
					$bigNumDate=mktime(0,0,0,1,1,$y-$bigNum);
					$text=$smallNum.'-'.$bigNum.' '.k_year;
					$script.="cats.push('".$text."');";	
					$timeCo=" birth_date < '".date('Y-m-d',$smallNumDate)."' and birth_date > '".date('Y-m-d',$bigNumDate)."' 
					and id IN(select patient from $table_2 where opr_id='$c_id') ";

					$res=mysql_q("select count(*)c from gnr_m_patients where $timeCo ");
					$r=mysql_f($res);
					$rows=$r['c'];
					$t11=number_format($rows*100/$t1,1);
					$script.='data_all.push('.$t11.');';

					$res=mysql_q("select count(*)c from gnr_m_patients where $timeCo  and sex=1 ");
					$r=mysql_f($res);
					$rows=$r['c'];
					$t22=number_format($rows*100/$t2,1);
					$script.='data_m.push('.$t22.');';	

					$res=mysql_q("select count(*)c from gnr_m_patients where $timeCo and sex=2 ");
					$r=mysql_f($res);
					$rows=$r['c'];
					$t33=number_format($rows*100/$t3,1);
					$script.='data_f.push('.$t33.');';	
				}?>
				<script>
				cats=new Array();
				data_m=new Array();
				data_f=new Array();
				data_all=new Array();
				<?=$script?>
				$('#rep_container2').highcharts({
					chart: {type: 'column'},
					title: {text: '<?=k_distrb?> <?=k_age?>'},
					xAxis: {categories: cats},
					yAxis: {min: 0,title:{text: k_percent}},
					tooltip: {
						headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
						pointFormat: '<tr><td class="f1" style="color:{series.color};padding:0">{series.name}: </td>' +
							'<td style="padding:0"><b>{point.y}%</b></td></tr>',
						footerFormat: '</table>',
						shared: true,
						useHTML: true
					},plotOptions: {column: {pointPadding: 0.2,borderWidth:0}},
					series: [
					{name: '<?=k_both_sex?>',data: data_all,color:'#8eee89', dataLabels:{enabled: true,format: '{y}%',rotation:-90,align:'left',y:-5}}, 
					{name: '<?=k_mls?>',data:data_m,color:'#8c89ee', dataLabels: {enabled: true,format: '{y}%',rotation:-90,align:'left',y:-5}}, 
					{name: '<?=k_fems?>',data: data_f,color:'#ee8989', dataLabels: {enabled: true,format: '{y}%',rotation:-90,align:'left',y:-5}}, 
					]
				});
				</script>
				<div id="rep_container" style="height:360px; min-width: 310px; direction:ltr"></div>
				<div id="rep_container2" style="height:460px; min-width: 310px; direction:ltr"></div><?
			}else{
			$sql=" SELECT e.name_$lg as name , COUNT(p.opr_id) AS c FROM $table_1 e , $table_2 p where  e.id=p.opr_id $q3 GROUP BY e.id order by c DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$script='';
			if($rows>0){
				while($r=mysql_f($res)){
					$name=$r['name'];
					$total=$r['c'];$t11=number_format($total*100/$t1,2);
					if($t11>0.8 || $rows<50){
						$script.="cats.push('".$name."');";	
						$script.="data_all.push(".$t11.");";
					}
				}
			}?>            	
			<script type="text/javascript">
			cats=new Array();
			data_all=new Array();	
			<?=$script?>
			$('#rep_container').highcharts({
				chart: {type: 'column'},
				title: {text: '<?=$chart_title?>'},
				navigator : {enabled : false},
					scrollbar : {enabled : false},	
					rangeSelector : {enabled : false},	
				xAxis: {categories: cats,labels:{rotation:-90}},
				yAxis: {min: 0,title:{text: k_percent}},
				tooltip: {
					headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
					pointFormat: '<tr><td class="f1" style="color:{series.color};padding:0">{series.name}: </td>' +
						'<td style="padding:0"><b>{point.y}%</b></td></tr>',
					footerFormat: '</table>',
					shared: true,
					useHTML: true
				},
				//plotOptions: {column: {pointPadding: 0.2,borderWidth:0}},
				plotOptions: {
							column: {                   
								point: {
									events: {
										click: function() {	
											loadRep(<?=$page?>,<?=$tab?>,this.category); 
										}
									}
								}
							}
						}	,
				series: [
				{name: k_pats_comps,data: data_all, dataLabels:{enabled: true,format: '{y}%',rotation:-90,align:'left',y:-5}}, 

				]
			});
			</script>
			<div id="rep_container" style="height:460px; min-width: 310px; direction:ltr"></div><? 

		}
		/******************************************************************************************/
		if($tab==4){				
			$sql=" SELECT e.name , COUNT(p.mad_id) AS c FROM gnr_m_medicines e , cln_x_medicines p where e.id=p.mad_id
			and p.visit IN(select id from cln_x_visits $q4) GROUP BY e.id order by c DESC limit 50 ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);?>		
			<script type="text/javascript">
			cats=new Array();
			data_all=new Array();<?
			if($rows>0){
				while($r=mysql_f($res)){
					$name=$r['e.name'];
					$total=$r['c'];
					echo "cats.push('".$name."');";	
					echo 'data_all.push('.$total.');';
				}
			}?>		
			$('#rep_container').highcharts({
			chart: {type: 'column'},
			title: {text: k_medicines},
			navigator : {enabled : false},
			scrollbar : {enabled : false},	
			rangeSelector : {enabled : false},	
			xAxis: {categories: cats,labels:{rotation:-90}},
			yAxis: {min: 0,title:{text: k_nums}},
			tooltip: {
				headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
				pointFormat: '<tr><td class="f1" style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			//plotOptions: {column: {pointPadding: 0.2,borderWidth:0}},
			plotOptions: {
						column: {                   
							point: {
								events: {
									click: function() {	
										//loadRep(<?=$t?>,this.category,1,<?=$r?>); 
									}
								}
							}
						}
					}	,
			series: [
			{name: k_num_of_tim,data: data_all, dataLabels:{enabled: true,format: '{y}',rotation:-90,align:'left',y:-5}}, 

			]
		});
			</script>
			<div id="rep_container" style="height:460px; min-width: 310px; direction:ltr"></div>	
			<?
		}			
	}
	if($page==11){
		if($tab==0){
			echo repoNav($fil,1,$page,$tab,0,0,$page_mood);				
			$d_s=$todyU;
			$d_e=$d_s+86400;
			echo $breakC;
			echo repTitleShow();
			/***********************/
			$reps_names=array();
			$service_data=array();
			//$sql="select id , name_$lg from _users where `grp_code` IN('pfx33zco65','buvw7qvpwq')";
			//$res=mysql_q($sql);
			//while($r=mysql_f($res)){$reps_names[$r['id']]=$r['name_'.$lg];}
			/*****/
			$sql="select * from _users where `grp_code` IN('7htoys03le','nlh8spit9q','fk590v9lvl','9yjlzayzp','66hd2fomwt','1ceddvqi3g')  and id='$thisUser' ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$doc_id=$r['id'];
					$doc_name=$r['name_'.$lg];
					$doc_sex=$r['sex'];
					$docSexTxt=intval($r['subgrp']);						
					list($cln_name,$mood)=get_val('gnr_m_clinics','name_'.$lg.',type',$docSexTxt);
					$table=$srvXTables[$mood];
					$table2=$srvTables[$mood];
					$table3=$visXTables[$mood];
					$docSexTxt=$sex_txt[$doc_sex];					
					if($mood==5 || $mood==6){$docSexTxt=$sex_txt2[$doc_sex];}
					$d_q=" and d_start >=$d_s and  d_start<$d_e ";
					if($mood==3){
						$serTotal=getTotalCO($table3,"ray_tec='$doc_id' $d_q ");
					}else{
						$serTotal=getTotalCO($table,"doc='$doc_id' $d_q ");
					}
					if($serTotal>0){
						echo '<div class="f1 fs16 clr1 lh40">'.k_detailed_daily_srvcs.''.$add_title.'<ff> ( '.$serTotal.' )</ff></div>';

						if($mood==1 || $mood==3 || $mood==5){
							echo '<div><table width="100%" border="0" class="grad_s holdH" type="static" cellspacing="0" cellpadding="4">								
							</tr>
							<tr>
							<th>'.k_visit_num.'</th>
							<th>'.k_patient.'</th>							
							<th>'.k_service.'</th>							
							<th>'.k_val_srv.'</th>
							<th>'.k_amount_coverge.'</th>
							<th>'.k_uncovered_amount.'</th>
							<th>'.k_status.'</th>								
							</tr>';
							if($mood==3){
								$sql2="select * from $table where visit_id in(select id from $table3  where ray_tec='$doc_id' $d_q ) order by visit_id ASC";
							}else{
								$sql2="select * from $table where doc='$doc_id' $d_q order by visit_id ASC";
							}
							$res2=mysql_q($sql2);
							$activeVis=0;
							$servTotal=0;
							$cashTotal=0;
							$norTotal=0;
							$netTotal=0;
							$payTotal=0;
							while($r2=mysql_f($res2)){
								$p_name=get_p_name($r2['patient']);
								$visit=$r2['visit_id'];
								$srv_no=$r2['id'];
								$service=$r2['service'];
								$status=$r2['status'];
								$total_pay=$r2['total_pay'];
								$pay_net=$r2['pay_net'];
								$srv_pay_type=$r2['pay_type'];
								$rev=$r2['rev'];
								$revTxt='';
								if($rev){$revTxt=' <span class="clr5 f1"> ( '.k_review.' ) </span>';}
								list($reg_user,$d_check,$pay_type)=get_val($table3,'reg_user,d_check,pay_type',$visit);
								if($status!=3){
									if($service_data[$service]){
										$serName=$service_data[$service]['name'];
									}else{
										$serName=get_val($table2,'name_'.$lg,$service);
										$service_data[$service]['name']=$serName;
									}									
									$service_data[$service]['no']++;
									if($srv_pay_type==3){
										$nor_pay=0;
										$ins_net=$total_pay-$pay_net;
										$ins_pay=$pay_net;
									}else{
										$nor_pay=$total_pay;
										$ins_net=0;
										$ins_pay=0;										
									}
									$service_data[$service]['total_pay']+=$total_pay;									$service_data[$service]['pay_net']+=$pay_net;
									$norTotal+=$nor_pay;
									$netTotal+=$ins_net;
									$payTotal+=$ins_pay;
								}
								/***************/
								if($activeVis!=$visit){

									$serTotal=getTotalCO($table,"visit_id='$visit' $d_q ");
									if(!$d_check){$d_check='-';}else{$d_check=date('h:i',$d_check);}
									$d_start=$r2['d_start'];if(!$d_start){$d_start='-';}else{$d_start=date('h:i',$d_start);}
									$d_start=$r2['d_start'];if(!$d_start){$d_start='-';}else{$d_start=date('h:i',$d_start);}
									$timeTxt=$d_start.' | '.$d_check.' | '.$d_start;
									$payTypeTxt='';
									if($pay_type>0){$payTypeTxt=$pay_types[$pay_type];}
									echo '<tr>';
									echo '<td rowspan="'.$serTotal.'"><ff>#'.$mood.'-'.$visit.'</ff></td>';
									echo '<td txt rowspan="'.$serTotal.'">'.$p_name.'<div class="clr5 f1 fs14">'.$payTypeTxt.'</div></td>';
									echo '<td txt>'.$serName.$revTxt.'</td>';
									echo '<td><ff class="clr1">'.number_format($nor_pay).'</ff></td>';
									echo '<td><ff class="clr6">'.number_format($ins_net).'</ff></td>';
									echo '<td><ff class="clr5">'.number_format($ins_pay).'</ff></td>';
									echo '<td txt bgcolor="'.$ser_status_color[$status].'">'.$ser_status_Tex[$status].'</td>
									</tr>';
								}else{
									echo '<tr>';			
									echo '<td txt>'.$serName.'</td>';
									echo '<td><ff class="clr1">'.number_format($nor_pay).'</ff></td>';
									echo '<td><ff class="clr6">'.number_format($ins_net).'</ff></td>';
									echo '<td><ff class="clr5">'.number_format($ins_pay).'</ff></td>';
									echo '<td txt bgcolor="'.$ser_status_color[$status].'">'.$ser_status_Tex[$status].'</td>';
									echo '</tr>';
								}
								$activeVis=$visit;
							}														
							echo '<tr fot>';	
							echo '<td colspan="3" txt>'.k_srvcs_tot_val.'</td>';
							echo '<td><ff class="clr1">'.number_format($norTotal).'</ff></td>';
							echo '<td><ff class="clr6">'.number_format($netTotal).'</ff></td>';
							echo '<td><ff class="clr5">'.number_format($payTotal).'</ff></td>';
							echo '<td>-</td>';
							echo '</tr>';
							echo '</table></div>';	

							if($service_data>0){
								echo '<div class="f1 fs16 clr1 lh40">'.k_aggr_srvcs.' : <ff> ( '.count($service_data).' ) </ff></div>';
								echo '<table width="100%" border="0" class="grad_s holdH" type="static" cellspacing="0" cellpadding="4">
								<tr><th>'.k_service.'</th><th>'.k_number.'</th><th>'.k_val_srvs.'</th><th>'.k_monetary.'</th>
									</tr>';
								foreach($service_data as $sd){
									echo '<tr>
									<td txt>'.$sd['name'].'</td>
									<td><ff>'.number_format($sd['no']).'</ff></td>
									<td><ff class="clr1">'.number_format($sd['total_pay']).'</ff></td>
									<td><ff class="clr6">'.number_format($sd['pay_net']).'</ff></td>
									</tr>';
								}
								echo '</table>';
							}
							unset($service_data);
						}
						if($mood==6){
							echo '<div><table width="100%" border="0" class="grad_s holdH" type="static" cellspacing="0" cellpadding="4">
							<tr><th colspan="10">'.k_trtmnt_procs.'</th><th>'.k_fin_proceds.'</th>
							</tr>
							<tr bgcolor="#e5e5e5">
							<td txt>'.k_visit_num.'</td>
							<td txt>'.k_patient.'</td>							
							<td txt>'.k_reception.'</td>
							<td txt>'.k_services.'</td>							
							<td txt>'.k_num_of_strikes.'</td>
							<td txt>'.k_strike_price.'</td>
							<td txt>'.k_val_srv.'</td>
							<td txt>'.k_discount.'</td>
							<td txt>'.k_paid_amount.'</td>
							<td txt>'.k_notes.'</td>
							<td txt>'.k_fin_oprs.'</td>
							</tr>';
							$sql2="select * from $table3 where doctor='$doc_id' $d_q order by id ASC";  
							$res2=mysql_q($sql2);
							$total_pays=0;							
							$cashTotal=0;
							while($r2=mysql_f($res2)){								
								$p_name=get_p_name($r2['patient']);								
								$v_id=$r2['id'];
								$service=$r2['service'];
								$status=$r2['status'];
								$total_pay=$r2['total_pay'];
								$status=$r2['status'];
								$reg_user=$r2['reg_user'];
								$rvis_shoot_r=$r2['vis_shoot_r'];
								$price=$r2['price'];
								$total=$r2['total'];
								$dis=$r2['dis'];
								$total_pay=$r2['total_pay'];
								$note=$r2['note'];
								$resption=$reps_names[$reg_user];								
								$total_pays+=$total_pay;
								$ser_ids=get_vals('bty_x_laser_visits_services','service'," visit_id='$v_id' and status!=3");
								$serName='';
								if($ser_ids){
									$serName=get_vals('bty_m_services','name_'.$lg," id IN ($ser_ids)",' :: ');
								}
								echo '<tr>';
								echo '<td><ff>#'.$mood.'-'.$v_id.'</ff></td>';
								echo '<td txt>'.$p_name.'</td>';		
								echo '<td txt>'.$resption.'</td>';								
								echo '<td txt>'.$serName.'</td>';
								echo '<td><ff class="clr1">'.number_format($rvis_shoot_r).'</ff></td>';
								echo '<td><ff class="clr1">'.number_format($price).'</ff></td>';
								echo '<td><ff class="clr1">'.number_format($total).'</ff></td>';
								echo '<td><ff class="clr5">'.number_format($dis).'</ff></td>';
								echo '<td><ff class="clr6">'.number_format($total_pay).'</ff></td>';
								echo '<td><span class="clr5 f1">'.$note.'<span></td>';

								echo '<td >';
								$sql3="select * from gnr_x_acc_payments where vis='$v_id' and mood='$mood'";
								$res3=mysql_q($sql3);
								$rows3=mysql_n($res3);
								if($rows3){
									echo '<table width="100%" border="0" class="grad_s holdH" type="static" cellspacing="0" cellpadding="4">';
									while($r3=mysql_f($res3)){
										$amount=$r3['amount'];
										if($r3['type']==3 || $r3['type']==4){
											$cashTotal-=$amount;
										}else{
											$cashTotal+=$amount;
										}
										echo '
										<tr>
										<td txt>'.$reps_names[$r3['casher']].'</td>
										<td txt><ff>'.date('h:i',$r3['date']).'</ff></td>
										<td><ff>'.number_format($amount).'</ff></td>
										<td><div class=" f1 fs14" style="color:'.$payArry_col[$r3['type']].'">'.$payArry[$r3['type']].'</td>
										</tr>';
									}
									echo '</table>';
								}else{ echo '<div class="f1 fs14 clr5">'.k_no_recs.'</div>';}
								echo '</td>
								</tr>';

							}														
							echo '<tr fot>';	
							echo '<td colspan="6" txt>'.k_srvcs_tot_val.'</td>';
							echo '<td><ff class="clr1"></ff></td>';
							echo '<td><ff class="clr6"></ff></td>';
							echo '<td><ff class="clr6">'.number_format($total_pays).'</ff></td>';
							echo '<td><ff class="clr6"></ff></td>';
							echo '<td><ff>'.number_format($cashTotal).'</ff></td>';
							echo '</tr>';
							echo '</table></div>';	
						}
					}
				}
			}
		}
		if($tab==1){
			echo repoNav($fil,2,$page,$tab,0,0,$page_mood); 
			echo $breakC;
			echo repTitleShow();
			if($val){$clinic=get_val('_users','subgrp',$val);?>
				<div class="f1 fs18 clr1 lh40"><?=get_val('_users','name_'.$lg,$val)?> [ <?=get_val('gnr_m_clinics','name_'.$lg,$clinic)?> ]</div>
			<? }?>
			<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
			<tr>
				<th width="30"><?=k_tday?></th>
				<th><?=k_services?></th>                
				<th><?=k_val_srvs?></th>
				<th><?=k_monetary?></th>
				<th><?=k_uncovered_amount?></th>					

			</tr>  
			<?
			$pm0=0;$pm1=0;$pm2=0;$pm3=0;$pm4=0;         
			for($ss=0;$ss<$monLen;$ss++){
				$d_s=$mm+($ss*86400);
				$d_e=$d_s+86400;					
				/************************************/				
				$sql2="select 
				SUM(srv)t0 , 
				SUM(total)t1 , 
				SUM(pay_net)t2 ,
				SUM(pay_insur)t3 ,
				SUM(dis)t4 
				from gnr_r_docs  where date ='$d_s'  and  doc='$thisUser' ";
				$res2=mysql_q($sql2);
				$r2=mysql_f($res2);
				$t0=$r2['t0'];
				$t1=$r2['t1'];
				$t2=$r2['t2'];
				$t3=$r2['t3'];
				$t4=$r2['t4'];
				$pm0+=$t0;$pm1+=$t1;$pm2+=$t2;$pm3+=$t3;$pm4+=$t4;
				$doc_per=0;
				if($tt2){
					$doc_per=$tt6*100/$tt2;
				}
				$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
				if($t0){
					echo '<tr>
					<td class="Over" onclick="loadRep('.$page.',0,'.$d_s.')"><ff>'.($ss+1).'</ff></td>
					<td><ff>'.number_format($t0).'</ff></td>					
					<td><ff class="clr1">'.number_format($t1).'</ff></td>
					<td><ff class="clr6">'.number_format($t2).'</ff></td>
					<td><ff class="clr1">'.number_format($t3).'</ff></td>						
					</tr>';
				}

				/***************************************/
			}
			$pm5=round($pm5,-1);
			echo '<tr fot>
				<td class="f1 fs14">'.k_total.'</td>
				<td><ff>'.number_format($pm0).'</ff></td>
				<td><ff class="clr1">'.number_format($pm1).'</ff></td>
				<td><ff class="clr6">'.number_format($pm2).'</ff></td>
				<td><ff class="clr1">'.number_format($pm3).'</ff></td>					
				</tr>';
			?>
			</table><?		
		}
	}
}
if($page==9){		
    $t1=getTotal('gnr_m_patients');
    $t2=getTotalCo('gnr_m_patients',"sex=1");
    $t3=getTotalCo('gnr_m_patients',"sex=2");
    /******************************************************************************************/
    if($tab==0){
        ?><script type="text/javascript">
         data=new Array(['<?=k_mls?>',<?=$t2?>],['<?=k_fems?>',<?=$t3?>]);
        $('#rep_container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
            text: k_per_pat_m_f
        },
        tooltip: {
            pointFormat:'<div><ff>%{point.percentage:.1f}</ff></div>',
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<div class="f1 fs16">{point.name} :</div><div> <ff>%{point.percentage:.1f}</ff></div>',
                    style: {

                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: k_nums,
            data:data,

        }],
        colors:['#8c89ee','#ee8989']
    });
        </script>
        <div id="rep_container" style="height:400px; min-width: 310px; direction:ltr"></div><?
    }
    /******************************************************************************************/
    if($tab==1){
        $q='';
        $agePer=10;
        $maxAge=100;		
        $script='';
        for($i=0;$i<$maxAge;$i+=$agePer){	
            $smallNum=$i;
            $bigNum=$i+$agePer;
            $y=date('Y');
            $smallNumDate=mktime(0,0,0,1,1,$y-$smallNum);
            $bigNumDate=mktime(0,0,0,1,1,$y-$bigNum);
            $text=$smallNum.'-'.$bigNum.' '.k_year;
            $script.="cats.push('".$text."');";	
            $timeCo=" birth_date < '".date('Y-m-d',$smallNumDate)."' and birth_date > '".date('Y-m-d',$bigNumDate)."' ";

            $rows=getTotalCo('gnr_m_patients',"$timeCo $q");
            $t11=number_format($rows*100/$t1,1);
            $script.='data_all.push('.$t11.');';

            $rows=getTotalCo('gnr_m_patients',"$timeCo and sex=1 $q");				
            $t22=number_format($rows*100/$t2,1);
            $script.='data_m.push('.$t22.');';	

            $rows=getTotalCo('gnr_m_patients',"$timeCo and sex=2 $q");
            $t33=number_format($rows*100/$t3,1);
            $script.='data_f.push('.$t33.');';	
        }?>
        <script type="text/javascript">
        cats=new Array();
        data_m=new Array();
        data_f=new Array();
        data_all=new Array();		
        <?=$script;?>
        $('#rep_container').highcharts({
        chart: {type: 'column'},
        title: {text: k_per_pat_ags},
        xAxis: {categories: cats},
        yAxis: {min: 0,title:{text: k_percent}},
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td class="f1" style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y}%</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {column: {pointPadding: 0.2,borderWidth:0}},
        series: [
        {name: '<?=k_both_sex?>',data: data_all,color:'#8eee89', dataLabels:{enabled: true,format: '{y}%',rotation:-90,align:'left',y:-5}}, 
        {name: '<?=k_mls?>',data:data_m,color:'#8c89ee', dataLabels: {enabled: true,format: '{y}%',rotation:-90,align:'left',y:-5}}, 
        {name: '<?=k_fems?>',data: data_f,color:'#ee8989', dataLabels: {enabled: true,format: '{y}%',rotation:-90,align:'left',y:-5}}, 
        ]
    });
        </script>

        <div id="rep_container" style="height:460px; min-width: 310px; direction:ltr"></div><?
    }
    if($tab==2){
        $ages=[0,13,21,36,46,60,120];
        
        $sql="select p_area,count(*)c from gnr_m_patients group by p_area order by c DESC";
        $res=mysql_q($sql);
        $all=mysql_n($res);        
        $sql="select p_area,count(*)c from gnr_m_patients group by p_area order by c DESC limit 100";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        ?>
        <div class="f1 fs16 lh40">عدد المناطق <ff><?=$all?>/<?=$rows?></ff></div>
        <table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v">
        <tr>
            <th>المنطقة</th>
            <th>العدد</th>
            <th>الذكر</th>
            <th>الأنثى</th><?
            $i=0;
            foreach($ages as $k=>$age){
                $s=$age;
                $e=$ages[$k+1]-1;
                if($e!=-1){
                    echo '<th colspan="2" width="80"><ff>'.$s.'-'.$e.'</ff></th>';
                }
            }?>
        <tr><?
        $areas=get_arr('gnr_m_areas','id','name');
        while($r=mysql_f($res)){
            $p_area=$r['p_area'];
            if($p_area){
                $areaName=$areas[$p_area];
            }else{
                $areaName='--غير محدد--';
            }
            $sex1=getTotalCo('gnr_m_patients',"p_area='$p_area' and sex=1");
            $sex2=getTotalCo('gnr_m_patients',"p_area='$p_area' and sex=2");
            $no=$r['c'];
            echo '
            <tr>
                <td txtS>'.$areaName.'</td>
                <td><ff>'.number_format($no).'</ff></td>
                <td><ff class="clr8">'.number_format($sex1).'</ff></td>
                <td><ff class="clr5">'.number_format($sex2).'</ff></td>';
                $i=0;
                foreach($ages as $k=>$age){                 
                    $smallNum=$age;
                    $bigNum=$ages[$k+1];
                    if($bigNum){
                    $y=date('Y');
                        $smallNumDate=mktime(0,0,0,1,1,$y-$smallNum);
                        $bigNumDate=mktime(0,0,0,1,1,$y-$bigNum);	
                        $timeCo=" birth_date < '".date('Y-m-d',$smallNumDate)."' and birth_date > '".date('Y-m-d',$bigNumDate)."' ";
                        
                        $n1=getTotalCo('gnr_m_patients',"p_area='$p_area' and sex=1 and $timeCo");	
                        $n2=getTotalCo('gnr_m_patients',"p_area='$p_area' and sex=2 and $timeCo");	
                        echo '
                        <td class="cbg888"><ff class="clr8">'.number_format($n1).'</ff></td>
                        <td class="cbg555"><ff class="clr5">'.number_format($n2).'</ff></td>';
                    }
                }
            echo '<tr>';
        }?>
        </table ><?
        //gnr_m_areas
    }
}
if($page==12){	
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
		$q='';
		echo $breakC;
		echo repTitleShow();
		$recMarg=8;
		if($val){
			$q=" and company = '$val' ";
			$recMarg=7;
			echo '<div class="f1 fs18 clr1 lh40">'.get_val('gnr_m_insurance_prov','name_'.$lg,$val).'</div>';
		}
		$sql="select * from gnr_x_insurance_rec where s_date>='$d_s' and s_date<'$d_e' $q order by s_date ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<tr>
				<? if($val==0){?><th><?=k_company?></th><? }?>
				<th><?=k_insurance_no?></th>
				<th><?=k_patient?></th>
				<th><?=k_doctor?></th>						
				<th><?=k_thvisit?></th>
				<th><?=k_service?></th>
				<th><?=k_inpt?></th>
				<th><?=k_price_serv?></th>
				<th><?=k_insure_price?></th>
				<th><?=k_includ?></th>
				<th><?=k_uncovered_amount?></th>
				<th><?=k_bill_number?></th>
				<th><?=k_status?></th>
			</tr><?
			$all_pi=0;
			$all_pii=0;
			while($r=mysql_f($res)){
				$c_id=$r['company'];
				$insur_no=$r['insur_no'];
				$patient=$r['patient'];
				$doc=$r['doc'];
				$mood=$r['mood'];
				$visit=$r['visit'];
				$service_x=$r['service_x'];
				$service=$r['service'];
				$price=$r['price'];
				$in_price=$r['in_price'];
				$in_price_includ=$r['in_price_includ'];
				$in_cost=$r['in_cost'];
				$s_date=$r['s_date'];
				$r_date=$r['r_date'];
				$user=$r['user'];
				$res_status=$r['res_status'];
				$ref_no=$r['ref_no'];
				$userName=get_val('_users','name_'.$lg,$user);
				$docName=get_val('_users','name_'.$lg,$doc);
				if($mood==1){$serName=get_val('cln_m_services','name_'.$lg,$service);}
				if($mood==2){$serName=get_val('lab_m_services','name_'.$lg,$service);}
				if($mood==3){$serName=get_val('xry_m_services','name_'.$lg,$service);}
				if($mood==4){$serName=get_val('den_m_services','name_'.$lg,$service);}
				if($mood==5){$serName=get_val('bty_m_services','name_'.$lg,$service);}
				$all_pi+=$in_price;
				$all_pii+=$in_price_includ;
				$prisX=0;
				if($res_status==1){
					$prisX=$in_price-$in_price_includ;
					$all_pix+=$prisX;
				}
				echo '<tr>';
				if($val==0){
				echo '<td class="f1 fs14 cur " onclick="chnRepVal('.$c_id.')">'.get_val('gnr_m_insurance_prov','name_'.$lg,$c_id).'</td>';
				}
				echo '<td><ff>'.$insur_no.'</ff></td>
				<td class="f1">'.get_p_name($patient).'</td>
				<td class="f1">'.$docName.'</td>
				<td class="f1">'.$clinicTypes[$mood].'<br><ff class="fs14">'.$mood.'-'.$visit.'</ff></td>
				<td class="f1">'.$serName.'</td>
				<td class="f1">'.$userName.'</td>
				<td><ff>'.number_format($price).'</ff></td>
				<td><ff class="clr1">'.number_format($in_price).'</ff></td>
				<td><ff class="clr6">'.number_format($in_price_includ).'</ff></td>
				<td><ff class="clr5">'.number_format($prisX).'</ff></td>
				<td><ff>'.$ref_no.'</ff></td>
				<td><span class="f1 '.$insurStatusColArr[$res_status].'">'.$reqStatusArr[$res_status].'</span></td>
				</tr>';

			}	
			echo '<tr fot>
			<td colspan="'.$recMarg.'" class="f1 fs16">'.k_total.'</td>
			<td><ff class="clr1">'.number_format($all_pi).'</ff></td>
			<td><ff class="clr6">'.number_format($all_pii).'</ff></td>
			<td><ff class="clr5">'.number_format($all_pix).'</ff></td>
			<td></td>
			<td></td>
			</tr>';					
			?></table><?
		}else{echo '<div class="f1 fs18 clr5">'.k_no_recs.' '.k_tday.'</div>';}
	}
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$q='';
		echo $breakC;
		echo repTitleShow();
		if($val){
			$q=" and company='$val'";				
			$add_title=get_val('gnr_m_insurance_prov','name_'.$lg,$val);
		}?>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th width="30"><?=k_tday?></th>
			<th><?=k_reqs_num?></th>    
			<th><?=k_srvcs_prices?></th>
			<th><?=k_insure_price?></th>
			<th><?=k_includ?></th>
			<th><?=k_uncovered_amount?></th>
			<th><?=k_acpt?></th>
			<th><?=k_rjct?></th>			
		</tr>  
		<?
		$pm1=$pm2=$pm3=$pm4=$pm5=$pm6=$pm7=0;          
		for($ss=0;$ss<$monLen;$ss++){
			$d_s=$mm+($ss*86400);
			$d_e=$d_s+86400;
			$sql="select SUM(apps)apps,SUM(price_srv)price_srv,SUM(price_in)price_in,SUM(price_in_in)price_in_in ,SUM(not_caver)not_caver, SUM(accepted)accepted , SUM(reject)reject from gnr_r_insurance where  date >= '$d_s' and date < '$d_e' $q limit 1";
			$res=mysql_q($sql);
			if($res){
				$r=mysql_f($res);
				$apps=$r['apps'];
				$price_srv=$r['price_srv'];
				$price_in=$r['price_in'];
				$price_in_in=$r['price_in_in'];
				$not_caver=$r['not_caver'];
				$accepted=$r['accepted'];
				$reject=$r['reject'];

				$pm1+=$apps;$pm2+=$price_srv;$pm3+=$price_in;$pm4+=$price_in_in;$pm5+=$not_caver; $pm6+=$accepted; $pm7+=$reject;
				if($apps+$price_srv+$price_in+$price_in_in+$not_caver+$accepted+$reject){?>           
				<tr>
				<td><div class="ff fs18 B txt_Over" onclick="loadRep(<?=$page?>,0,<?=$d_s?>)"><?=($ss+1)?></div></td>    
				<td><ff class=""><?=number_format($apps)?></ff></td>
				<td><ff class=""><?=number_format($price_srv)?></ff></td>        
				<td><ff class="clr1"><?=number_format($price_in)?></ff></td>
				<td><ff class="clr6"><?=number_format($price_in_in)?></ff></td>
				<td><ff class="clr5"><?=number_format($not_caver)?></ff></td>        
				<td><ff class="clr6"><?=number_format($accepted)?></ff></td>  
				<td><ff class="clr5"><?=number_format($reject)?></ff></td>					
				</tr><?	
				}
			}
		}?> 
		<tr fot>
			<td class="f1 fs14"><?=k_total?></td>    
			<td><ff class=""><?=number_format($pm1)?></ff></td>
			<td><ff class=""><?=number_format($pm2)?></ff></td>
			<td><ff class="clr1"><?=number_format($pm3)?></ff></td>
			<td><ff class="clr6"><?=number_format($pm4)?></ff></td>
			<td><ff class="clr5"><?=number_format($pm5)?></ff></td>
			<td><ff class="clr6"><?=number_format($pm6)?></ff></td>
			<td><ff class="clr5"><?=number_format($pm7)?></ff></td>


		</tr>
		</table><?		
	}
	if($tab==2){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		$q='';
		echo $breakC;
		echo repTitleShow();
		$recMarg=8;
		if($d_s<$d_e){
			if($val){
				$q=" and company = '$val' ";
				$recMarg=7;
				echo '<div class="f1 fs18 clr1 lh40">'.get_val('gnr_m_insurance_prov','name_'.$lg,$val).'</div>';
			}
			$sql="select * from gnr_x_insurance_rec where s_date>='$d_s' and s_date<'$d_e' $q order by s_date ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<? if($val==0){?><th><?=k_company?></th><? }?>
					<th><?=k_insurance_no?></th>
					<th><?=k_patient?></th>
					<th><?=k_doctor?></th>						
					<th><?=k_thvisit?></th>
					<th><?=k_service?></th>
					<th><?=k_inpt?></th>
					<th><?=k_price_serv?></th>
					<th><?=k_insure_price?></th>
					<th><?=k_includ?></th>
					<th><?=k_uncovered_amount?></th>
					<th><?=k_bill_number?></th>
					<th><?=k_status?></th>
				</tr><?
				$all_pi=0;
				$all_pii=0;
				while($r=mysql_f($res)){
					$c_id=$r['company'];
					$insur_no=$r['insur_no'];
					$patient=$r['patient'];
					$doc=$r['doc'];
					$mood=$r['mood'];
					$visit=$r['visit'];
					$service_x=$r['service_x'];
					$service=$r['service'];
					$price=$r['price'];
					$in_price=$r['in_price'];
					$in_price_includ=$r['in_price_includ'];
					$in_cost=$r['in_cost'];
					$s_date=$r['s_date'];
					$r_date=$r['r_date'];
					$user=$r['user'];
					$res_status=$r['res_status'];
					$ref_no=$r['ref_no'];
					$userName=get_val('_users','name_'.$lg,$user);
					$docName=get_val('_users','name_'.$lg,$doc);
					if($mood==1){$serName=get_val('cln_m_services','name_'.$lg,$service);}
					if($mood==2){$serName=get_val('lab_m_services','name_'.$lg,$service);}
					if($mood==3){$serName=get_val('xry_m_services','name_'.$lg,$service);}
					if($mood==4){$serName=get_val('den_m_services','name_'.$lg,$service);}
					if($mood==5){$serName=get_val('bty_m_services','name_'.$lg,$service);}
					$all_pi+=$in_price;
					$all_pii+=$in_price_includ;
					$prisX=0;
					if($res_status==1){
						$prisX=$in_price-$in_price_includ;
						$all_pix+=$prisX;
					}
					echo '<tr>';
					if($val==0){
					echo '<td class="f1 fs14 cur " onclick="chnRepVal('.$c_id.')">'.get_val('gnr_m_insurance_prov','name_'.$lg,$c_id).'</td>';
					}
					echo '<td><ff>'.$insur_no.'</ff></td>
					<td class="f1">'.get_p_name($patient).'</td>
					<td class="f1">'.$docName.'</td>
					<td class="f1">'.$clinicTypes[$mood].'<br><ff class="fs14">'.$mood.'-'.$visit.'</ff></td>
					<td class="f1">'.$serName.'</td>
					<td class="f1">'.$userName.'</td>
					<td><ff>'.number_format($price).'</ff></td>
					<td><ff class="clr1">'.number_format($in_price).'</ff></td>
					<td><ff class="clr6">'.number_format($in_price_includ).'</ff></td>
					<td><ff class="clr5">'.number_format($prisX).'</ff></td>
					<td><ff>'.$ref_no.'</ff></td>
					<td><span class="f1 '.$insurStatusColArr[$res_status].'">'.$reqStatusArr[$res_status].'</span></td>
					</tr>';

				}	
				echo '<tr fot>
				<td colspan="'.$recMarg.'" class="f1 fs16">'.k_total.'</td>
				<td><ff class="clr1">'.number_format($all_pi).'</ff></td>
				<td><ff class="clr6">'.number_format($all_pii).'</ff></td>
				<td><ff class="clr5">'.number_format($all_pix).'</ff></td>
				<td></td>
				<td></td>
				</tr>';					
				?></table><?
			}
		}else{echo '<div class="f1 fs16 clr5">'.k_err_ent_date.'</div>';}
	}
	if($tab==22){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		echo $breakC;
		echo repTitleShow();
		if($d_s<$d_e){
			if($val==0){
			echo '<div class="f1 fs18 clr1 lh40">'.$add_title.'</div>';
			$sql="select id , name_$lg from gnr_m_charities order by name_$lg ASC";				
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th><?=k_the_charity?></th>
					<th><?=k_vis_no?></th>
					<th><?=k_rcvble?></th>      
				</tr><?
				$all_a=0;
				$all_p=0;
				while($r=mysql_f($res)){
					$c_id=$r['id'];
					$name=$r['name_$lg'];
					$sql2="select sum(receivable) as r , sum(visit_total) as c from gnr_r_charities where date >='$d_s' and date <'$d_e' and chr_id='$c_id' ";						
					$res2=mysql_q($sql2);						
					$r2=mysql_f($res2);
					$receivable=$r2['r'];
					$visit_total=$r2['c'];						
					$all_a+=$receivable;
					$all_p+=$visit_total;
					$name=get_val('gnr_m_charities','name_'.$lg,$c_id);						
					if($receivable || $visit_total){
						echo '<tr>
						<td class="f1 fs14 cur " onclick="chnRepVal('.$c_id.')">'.$name.'</td>
						<td><ff>'.number_format($visit_total).'</ff></td>
						<td><ff class="clr6">'.number_format($receivable).'</ff></td>
						</tr>';
					}
				}					
				echo '
				<tr fot>
				<td class="f1 fs14">'.k_total.'</td>
				<td><ff>'.number_format($all_p).'</ff></td>
				<td><ff class="">'.number_format($all_a).'</ff></td>
				</tr>';
				?></table><?
			}else{echo '<div class="f1 fs18 clr5">'.k_nsrvs_cmpt.'</div>';}           
			}else{			
			$sql="select * from cln_x_visits where pay_type=2 and pay_type_link='$val'
			and d_start >'$d_s' and d_start < '$d_e' order by id ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);

			$sql11="select * from lab_x_visits x where pay_type=2 and pay_type_link='$val'
			and d_start>'$d_s' and d_start < '$d_e' order by id ASC";
			$res11=mysql_q($sql11);
			$rows11=mysql_n($res11);

			echo '<div class="f1 fs18 clr1 lh40">'.get_val('gnr_m_charities','name_'.$lg,$val).'</div>'.$breakC;
			if($rows+$rows11>0){ ?>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th width="20"><?=k_visit_num?></th>
					<!--<th width="20">رقم الإحالة</th>-->
					<th><?=k_date?></th>
					<!--<th>رقم التسجيل</th>-->
					<th><?=k_patient?></th>
					<th><?=k_age?></th>                        
					<th><?=k_mobile?></th>
					<th><?=k_phone?></th>
					<th><?=k_clinic?></th>
					<th><?=k_doctor?></th>            
					<th><?=k_srvs_prvd?></th>
					<th><?=k_rcvble?></th>
				</tr><?                    
				$allRec=0;
				while($r=mysql_f($res)){
					$x_id=$r['id'];
					$patient=$r['patient'];
					$r_no=$r['no'];
					$rec_no=$r['rec_no'];						
					$pay_type=$r['pay_type'];
					$x_doctor=$r['doctor'];
					$x_clinic=$r['clinic'];
					$date=$r['d_start'];						
					$service_txt='';
					$service_val=0;
					$mToPay=0;

					$sql2="select * from  cln_x_visits_services where visit_id='$x_id' and status=1 ";
					$res2=mysql_q($sql2);
					$rows2=mysql_n($res2);					
					if($rows2>0){
						while($r2=mysql_f($res2)){
							$total_pay=$r2['total_pay'];							
							$pay_net=$r2['pay_net'];
							$service=$r2['service'];
							if($service_txt){$service_txt.=' / ';}
							$service_txt.=get_val('cln_m_services','name_'.$lg,$service);
							$service_val+=$total_pay+$pay_net;								
						}
					}
					$mToPay+=$service_val;
					$p_data=get_p_name($patient,3);
					if($service_val || $mToPay || $pay_n){						
						echo '<tr>
						<td><ff>'.$x_id.'</ff></td>
						<!--<td><ff>'.$r_no.'</ff></td>-->
						<td><ff>'.date('Y-m-d',$date).'</ff></td>
						<!--<td><ff>'.$rec_no.'</ff></td>-->
						<td class="f1 fs14">'.$p_data[0].'</td>
						<td class="f1 fs14">'.$p_data[1].'</td>
						<td class="f1 fs14">'.$p_data[2].'</td>
						<td class="f1 fs14">'.$p_data[3].'</td>
						<td class="f1 fs14">'.get_val('gnr_m_clinics','name_'.$lg,$x_clinic).'</td>
						<td class="f1 fs14">'.get_val('_users','name_'.$lg,$x_doctor).'</td>		
						<td class="f1 fs14">'.$service_txt.'</td>
						<td><ff>'.number_format($mToPay).'</ff></td>
						</tr>';
					}												
					$allRec+=$mToPay;
					$actVis=$x_id;
				}
				while($r=mysql_f($res11)){
					$x_id=$r['id'];
					$patient=$r['patient'];
					$r_no=$r['no'];
					$rec_no=$r['rec_no'];						
					$pay_type=$r['pay_type'];
					$x_doctor=$r['doctor'];
					$x_clinic=$r['clinic'];
					$date=$r['d_start'];						
					$service_txt='';
					$service_val=0;
					$mToPay=0;

					$sql2="select * from  lab_x_visits_services where visit_id='$x_id' and status>0";
					$res2=mysql_q($sql2);
					$rows2=mysql_n($res2);					
					if($rows2>0){
						while($r2=mysql_f($res2)){
							$total_pay=$r2['total_pay'];							
							$pay_net=$r2['pay_net'];
							$service=$r2['service'];
							if($service_txt){$service_txt.=' / ';}
							$service_txt.=get_val('lab_m_services','short_name',$service);
							$service_val+=$total_pay+$pay_net;								
						}
					}
					$mToPay+=$service_val;
					$p_data=get_p_name($patient,3);
					if($service_val || $mToPay || $pay_n){						
						echo '<tr>
						<td><ff>'.$x_id.'</ff></td>
						<!--<td><ff>'.$r_no.'</ff></td>-->
						<td><ff>'.date('Y-m-d',$date).'</ff></td>
						<!--<td><ff>'.$rec_no.'</ff></td>-->
						<td class="f1 fs14">'.$p_data[0].'</td>
						<td class="f1 fs14">'.$p_data[1].'</td>
						<td class="f1 fs14">'.$p_data[2].'</td>
						<td class="f1 fs14">'.$p_data[3].'</td>
						<td class="f1 fs14">'.get_val_c('gnr_m_clinics','name_'.$lg,2,'type').'</td>
						<td class="f1 fs14">-</td>		
						<td class="f1 fs14">'.splitNO($service_txt).'</td>
						<td><ff>'.number_format($mToPay).'</ff></td>
						</tr>';
					}
					$allRec+=$mToPay;
					$actVis=$x_id;
				}
				echo '<tr fot>
				<td colspan="9" class="f1 fs16">'.k_total.'</td>
				<td><ff class="fs20">'.number_format($allRec).'</ff></td>
				</tr>';
				?></table><?
			}else{echo '<div class="f1 fs18 clr5">'.k_no_ctin.'</div>';}            
		}
		}else{echo '<div class="f1 fs16 clr5">'.k_err_ent_date.'</div>';}
	}		
}
if($page==13){
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$q='';
		echo $breakC;
		echo repTitleShow();
		if($val){$q=" and id='$val' ";}
		$d_s=$todyU;
		$d_e=$d_s+86400;
		/***********************/
		$reps_names=array();
		$service_data=array();
		$sql="select id , name_$lg from _users where `grp_code` IN('pfx33zco65','buvw7qvpwq')";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){$reps_names[$r['id']]=$r['name_'.$lg];}
		/*****/
		echo '<div class="f1 fs18 clr1 lh40">'.k_detailed_daily_srvcs.''.$add_title.'</div>';
		$sql="select * from _users where `grp_code` IN('7htoys03le','nlh8spit9q','fk590v9lvl','9yjlzayzp','66hd2fomwt','1ceddvqi3g','9k0a1zy2ww')  $q order by name_$lg ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$doc_id=$r['id'];
				$doc_name=$r['name_'.$lg];
				$doc_sex=$r['sex'];
				$career_code=$r['career_code'];
				$docSexTxt=intval($r['subgrp']);						
				list($cln_name,$mood)=get_val('gnr_m_clinics','name_'.$lg.',type',$docSexTxt);
				$table=$srvXTables[$mood];
				$table2=$srvTables[$mood];
				$table3=$visXTables[$mood];
				$docSexTxt=$sex_txt[$doc_sex];					
				$d_q=" and d_start >=$d_s and  d_start<$d_e ";
				if($mood==3){
					$serTotal=getTotalCO($table3,"ray_tec='$doc_id' $d_q ");
				}else{
					$serTotal=getTotalCO($table,"doc='$doc_id' $d_q ");
				}
				if($serTotal>0){
					echo '<div class="f1 fs14 clr11 lh30">'.$docSexTxt.': '.$doc_name.' <ff14>'.$career_code.'</ff14> ( '.$cln_name.' ) 
					<ff14 class="clr5">('.$serTotal.')</ff14></div>';
					if($mood==1 || $mood==3 || $mood==5 || $mood==7){
						echo '<div><table width="100%" border="0" class="grad_s holdH" type="static" cellspacing="0" cellpadding="4">
						<tr><th colspan="9">'.k_trtmnt_procs.'</th><th>'.k_fin_proceds.'</th>
						</tr>
						<tr bgcolor="#e5e5e5">
						<td txtS>'.k_visit_num.'</td>
						<td txtS>'.k_patient.'</td>							
						<td txtS>'.k_reception.'</td>
                        <td txtS>'.k_service.'</td> 
                        <td txtS>'.k_val_srv.'</td>
                        <td txtS>المبلغ المدفوع</td>
						<td txtS>'.k_amount_coverge.'</td>
						<td txtS>'.k_uncovered_amount.'</td>
						<td txtS>'.k_status.'</td>							
						<td txtS>'.k_fin_oprs.'</td>
						</tr>';
						if($mood==3){
							$sql2="select * from $table where visit_id in(select id from $table3  where ray_tec='$doc_id' $d_q ) order by visit_id ASC";
							$docQ='';
						}else{
							$sql2="select * from $table where doc='$doc_id' $d_q order by visit_id ASC";
							$docQ=" and doc='$doc_id' ";
						}
						$res2=mysql_q($sql2);
						$activeVis=0;
						$servTotal=0;
						$cashTotal=[0];
                        $serPayTotal=0;
						$norTotal=0;
						$netTotal=0;
						$payTotal=0;
						$btySrvs=0;
						while($r2=mysql_f($res2)){
							$p_name=get_p_name($r2['patient']);
							$visit=$r2['visit_id'];
							$srv_no=$r2['id'];
							$service=$r2['service'];
							$status=$r2['status'];
							$total_pay=$r2['total_pay'];                            
                            $doc_dis=$r2['doc_dis'];
                            $hos_dis=$r2['hos_dis'];
                            $discount=$doc_dis+$hos_dis;
							$pay_net=$r2['pay_net'];
							$srv_pay_type=$r2['pay_type'];
                            $payLinkName='';
                            list($reg_user,$d_check,$pay_type,$pay_type_link)=get_val($table3,'reg_user,d_check,pay_type,pay_type_link',$visit);
                            
                            if($pay_type_link){
                                $payLinkName=paymentName($srv_pay_type,$pay_type_link);
                            }
							
							if($status!=3){
								if($service_data[$service]){
									$serName=$service_data[$service]['name'];
								}else{
									$serName=get_val($table2,'name_'.$lg,$service);
									if($mood==1){
										$bty=get_val($table2,'bty',$service);
										if($bty){$btySrvs=1;}
										$service_data[$service]['bty']=$bty;
									}
									$service_data[$service]['name']=$serName;
								}									
								$service_data[$service]['no']++;
								
                                
								if($srv_pay_type==3){									//list($nor_pay,$in_cover)=get_val_con('gnr_x_insurance_rec','in_price,in_price_includ',"service_x='$srv_no' and mood='$mood'");
									$nor_pay=0;
									$ins_net=$total_pay-$pay_net;
									$ins_pay=$pay_net;
								}else{
									$nor_pay=$total_pay-$discount;
									$ins_net=0;
									$ins_pay=0;										
								}
								$service_data[$service]['total_pay']+=$total_pay;									
                                $service_data[$service]['pay_net']+=$pay_net;
								$norTotal+=$nor_pay;
								$netTotal+=$ins_net;
								$payTotal+=$ins_pay;
                                $serPayTotal+=$total_pay;
							}
							/***************/
							if($activeVis!=$visit){
								$resption=$reps_names[$reg_user];									
								$serTotal=getTotalCO($table,"visit_id='$visit' $docQ $d_q ");
								if(!$d_check){$d_check='-';}else{$d_check=date('h:i',$d_check);}
								$d_start=$r2['d_start'];if(!$d_start){$d_start='-';}else{$d_start=date('h:i',$d_start);}
								$d_start=$r2['d_start'];if(!$d_start){$d_start='-';}else{$d_start=date('h:i',$d_start);}
								$timeTxt=$d_start.' | '.$d_check.' | '.$d_start;
								$payTypeTxt='';
								if($pay_type>0){$payTypeTxt=$pay_types[$pay_type].' - '.$payLinkName;}
								echo '<tr>';
								echo '<td rowspan="'.$serTotal.'"><ff14>#'.$mood.'-'.$visit.'</ff14></td>';
								echo '<td txtS rowspan="'.$serTotal.'">'.$p_name.'<div class="clr5 f1 fs12">'.$payTypeTxt.'</div></td>';		
								echo '<td rowspan="'.$serTotal.'" txtS>'.$resption.'</td>';								
								echo '<td txtS>'.$serName;
                                if($r2['offer']){ echo '<span class="f1 clr5"><br> ( عرض )</span>';}
                                echo '</td>';
                                echo '<td><ff14 class="clr1">'.number_format($total_pay).'</ff14></td>';
								echo '<td><ff14 class="clr1">'.number_format($nor_pay).'</ff14></td>';                                
								echo '<td><ff14 class="clr6">'.number_format($ins_net).'</ff14></td>';
								echo '<td><ff14 class="clr5">'.number_format($ins_pay).'</ff14></td>';
								echo '<td txtS bgcolor="'.$ser_status_color[$status].'">'.$ser_status_Tex[$status].'</td>';
								echo '<td rowspan="'.$serTotal.'">';
								$sql3="select * from gnr_x_acc_payments where vis='$visit' and mood='$mood'";
								$res3=mysql_q($sql3);
								$rows3=mysql_n($res3);
								if($rows3){
									echo '<table width="100%" border="0" class="grad_s holdH" type="static" cellspacing="0" cellpadding="4">';
									while($r3=mysql_f($res3)){
										$amount=$r3['amount'];
                                        $payType=$r3['pay_type'];
										if($r3['type']==3 || $r3['type']==4){
											$cashTotal[$payType]-=$amount;
										}else{
											$cashTotal[$payType]+=$amount;
										}
										echo '
										<tr>
										<td txtS>'.$reps_names[$r3['casher']].'</td>
										<td txtS><ff14>'.date('h:i',$r3['date']).'</ff14></td>
										<td><ff14 style="color:'.$payTypePClr[$payType].'">'.number_format($amount).'</ff14></td>
										<td><div class=" f1 fs12" style="color:'.$payArry_col[$r3['type']].'">'.$payArry[$r3['type']].'</td>
										</tr>';
									}
									echo '</table>';
								}else{ echo '<div class="f1 fs14 clr5">'.k_no_recs.'</div>';}
								echo '</td>
								</tr>';
							}else{
								echo '<tr>';			
								echo '<td txtS>'.$serName.'</td>';
                                echo '<td><ff14 class="clr1">'.number_format($total_pay).'</ff14></td>';
								echo '<td><ff14 class="clr1">'.number_format($nor_pay).'</ff14></td>';                                
								echo '<td><ff14 class="clr6">'.number_format($ins_net).'</ff14></td>';
								echo '<td><ff14 class="clr5">'.number_format($ins_pay).'</ff14></td>';
								echo '<td txtS bgcolor="'.$ser_status_color[$status].'">'.$ser_status_Tex[$status].'</td>';
								echo '</tr>';
							}
							$activeVis=$visit;
						}														
						echo '<tr fot>';	
						echo '<td colspan="4" txtS>'.k_srvcs_tot_val.'</td>';
                        echo '<td><ff14 class="clr1">'.number_format($serPayTotal).'</ff14></td>'; 
						echo '<td><ff14 class="clr1">'.number_format($norTotal).'</ff14></td>';                                               
						echo '<td><ff14 class="clr6">'.number_format($netTotal).'</ff14></td>';
						echo '<td><ff14 class="clr5">'.number_format($payTotal).'</ff14></td>';
						echo '<td>-</td>';
						echo '<td>';
                            if(_set_l1acfcztzu){
                                echo '<div class="fl f1 pd10" style="color:'.$payTypePClr[1].'">نقدا :
                                    <ff14>'.number_format($cashTotal[1]).'</ff14>
                                </div>
                                <div class="fl f1 pd10" style="color:'.$payTypePClr[2].'">الكتروني :
                                    <ff14>'.number_format($cashTotal[2]).'</ff14>
                                </div>
                                <div class="fl f1 pd10 clr66">المجموع :
                                    <ff14>'.number_format($cashTotal[1]+$cashTotal[2]).'</ff14>
                                </div>';
                            }else{
                                echo '<ff14>'.number_format($cashTotal[1]+$cashTotal[2]).'</ff14>';
                            }
                        echo '</td>';
						echo '</tr>';
						echo '</table></div>';	

						if($service_data>0){
							echo '<div class="f1 fs14 clr11 lh40">'.$docSexTxt.': '.$doc_name.' ( '.$cln_name.' ) |  '.k_aggr_srvcs.' : <ff14 class="clr5"> ('.count($service_data).')</ff14></div>';
							echo '<table width="100%" border="0" class="grad_s holdH" type="static" cellspacing="0" cellpadding="4">';
							if($btySrvs){
								echo '
								<tr><th rowspan="2">'.k_service.'</th><th rowspan="2">'.k_number.'</th><th colspan="2">'.k_srv_med.'</th><th colspan="2">'.k_srv_bty.'</th></tr>
								<tr><th>'.k_val_srvs.'</th><th>'.k_monetary.'</th><th>'.k_val_srvs.'</th><th>'.k_monetary.'</th></tr>';
							}else{
								echo '<tr><th>'.k_service.'</th><th>'.k_number.'</th><th>'.k_val_srvs.'</th><th>'.k_monetary.'</th></tr>';
							}
							$madTotal=$btyTotal=array();
							$servTotal=0;
							foreach($service_data as $sd){
								$servTotal+=$sd['no'];
								echo '<tr>
								<td txtS>'.$sd['name'].'</td>
								<td><ff14>'.number_format($sd['no']).'</ff14></td>';
								if($btySrvs && $sd['bty']==1){
									echo '<td>-</td><td>-</td>';
									$btyTotal[0]+=$sd['total_pay'];
									$btyTotal[1]+=$sd['pay_net'];
								}
								echo '<td><ff14>'.number_format($sd['total_pay']).'</ff14></td>
								<td><ff14>'.number_format($sd['pay_net']).'</ff14></td>';
								if($sd['bty']==0){
									if($btySrvs){echo '<td>-</td><td>-</td>';}
									$madTotal[0]+=$sd['total_pay'];
									$madTotal[1]+=$sd['pay_net'];
								}
								echo '</tr>';
							}
							echo '<tr fot>
								<td txtS>'.k_total.'</td>
								<td><ff14>'.number_format($servTotal).'</ff14></td>
								<td><ff14>'.number_format($madTotal[0]).'</ff14></td>
								<td><ff14>'.number_format($madTotal[1]).'</ff14></td>';
								if($btySrvs){
									echo '<td><ff14>'.number_format($btyTotal[0]).'</ff14></td>
									<td><ff14>'.number_format($btyTotal[1]).'</ff14></td>';
								}									
								echo '</tr>';
							echo '</table>';
						}
						unset($service_data);
					}
					if($mood==6){
						echo '<div><table width="100%" border="0" class="grad_s holdH" type="static" cellspacing="0" cellpadding="4">
						<tr><th colspan="10">'.k_trtmnt_procs.'</th><th>'.k_fin_proceds.'</th>
						</tr>
						<tr bgcolor="#e5e5e5">
						<td txtS>'.k_visit_num.'</td>
						<td txtS>'.k_patient.'</td>							
						<td txtS>'.k_reception.'</td>
						<td txtS>'.k_services.'</td>							
						<td txtS>'.k_num_of_strikes.'</td>
						<td txtS>'.k_strike_price.'</td>
						<td txtS>'.k_val_srv.'</td>
						<td txtS>'.k_discount.'</td>
						<td txtS>'.k_paid_amount.'</td>
						<td txtS>'.k_notes.'</td>
						<td txtS>'.k_fin_oprs.'</td>
						</tr>';
						$sql2="select * from $table3 where doctor='$doc_id' $d_q order by id ASC";  
						$res2=mysql_q($sql2);
						$total_pays=0;							
						$cashTotal=[0];
						while($r2=mysql_f($res2)){								
							$p_name=get_p_name($r2['patient']);								
							$v_id=$r2['id'];
							$service=$r2['service'];
							$status=$r2['status'];
							$total_pay=$r2['total_pay'];
							$status=$r2['status'];
							$reg_user=$r2['reg_user'];
							$rvis_shoot_r=$r2['vis_shoot_r'];
							$price=$r2['price'];
							$total=$r2['total'];
							$dis=$r2['dis'];
							$total_pay=$r2['total_pay'];
							$note=$r2['note'];
							$resption=$reps_names[$reg_user];								
							$total_pays+=$total_pay;
							$ser_ids=get_vals('bty_x_laser_visits_services','service'," visit_id='$v_id' and status!=3");
							$serName='';
							if($ser_ids){
								$serName=get_vals('bty_m_services','name_'.$lg," id IN ($ser_ids)",' :: ');
							}
							echo '<tr>';
							echo '<td><ff14>#'.$mood.'-'.$v_id.'</ff14></td>';
							echo '<td txtS>'.$p_name.'</td>';		
							echo '<td txtS>'.$resption.'</td>';								
							echo '<td txtS>'.$serName.'</td>';
							echo '<td><ff14 class="clr1">'.number_format($rvis_shoot_r).'</ff14></td>';
							echo '<td><ff14 class="clr1">'.number_format($price).'</ff14></td>';
							echo '<td><ff14 class="clr1">'.number_format($total).'</ff14></td>';
							echo '<td><ff14 class="clr5">'.number_format($dis).'</ff14></td>';
							echo '<td><ff14 class="clr6">'.number_format($total_pay).'</ff14></td>';
							echo '<td><span class="clr5 f1">'.$note.'<span></td>';

							echo '<td >';
							$sql3="select * from gnr_x_acc_payments where vis='$v_id' and mood='$mood'";
							$res3=mysql_q($sql3);
							$rows3=mysql_n($res3);
							if($rows3){
								echo '<table width="100%" border="0" class="grad_s holdH" type="static" cellspacing="0" cellpadding="4">';
								while($r3=mysql_f($res3)){
									$amount=$r3['amount'];
                                    $payType=$r3['pay_type'];
                                    if($r3['type']==3 || $r3['type']==4){
                                        $cashTotal[$payType]-=$amount;
                                    }else{
                                        $cashTotal[$payType]+=$amount;
                                    }									
									echo '
									<tr>
									<td txtS>'.$reps_names[$r3['casher']].'</td>
									<td txtS><ff14>'.date('h:i',$r3['date']).'</ff14></td>
									<td><ff14 style="color:'.$payTypePClr[$payType].'">'.number_format($amount).'</ff14></td>
									<td><div class=" f1 fs12" style="color:'.$payArry_col[$r3['type']].'">'.$payArry[$r3['type']].'</td>
									</tr>';
								}
								echo '</table>';
							}else{ echo '<div class="f1 clr5">'.k_no_recs.'</div>';}
							echo '</td>
							</tr>';

						}														
						echo '<tr fot>';	
						echo '<td colspan="6" txtS>'.k_srvcs_tot_val.'</td>';
						echo '<td><ff14 class="clr1"></ff14></td>';
						echo '<td><ff14 class="clr6"></ff14></td>';
						echo '<td><ff14 class="clr6">'.number_format($total_pays).'</ff14></td>';
						echo '<td><ff14 class="clr6"></ff14></td>';
						echo '<td>';
                            if(_set_l1acfcztzu){
                                echo '<div class="fl f1 pd10" style="color:'.$payTypePClr[1].'">نقدا :
                                    <ff14>'.number_format($cashTotal[1]).'</ff14>
                                </div>
                                <div class="fl f1 pd10" style="color:'.$payTypePClr[2].'">الكتروني :
                                    <ff14>'.number_format($cashTotal[2]).'</ff14>
                                </div>
                                <div class="fl f1 pd10 clr66">المجموع :
                                    <ff14>'.number_format($cashTotal[1]+$cashTotal[2]).'</ff14>
                                </div>';
                            }else{
                                echo '<ff14>'.number_format($cashTotal[1]+$cashTotal[2]).'</ff14>';
                            }
                        echo '</td>';
						echo '</tr>';
						echo '</table></div>';	
					}
				}
			}
		}
	}
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();
		if($val){
			$clinic=get_val('_users','subgrp',$val);
			echo '<div class="f1 fs18 clr1 lh40">
			'.get_val('_users','name_'.$lg,$val).' [ '.get_val('gnr_m_clinics','name_'.$lg,$clinic).' ]</div>';
		}?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th width="30"><?=k_tday?></th>
			<th><?=k_services?></th>                
			<th><?=k_val_srvs?></th>
			<th><?=k_monetary?></th>
			<th><?=k_uncovered_amount?></th>
			<th><?=k_discount?></th>

		</tr>  
		<?
		$pm0=0;$pm1=0;$pm2=0;$pm3=0;$pm4=0;$pm5=0;$pm6=0;          
		for($ss=0;$ss<$monLen;$ss++){
			$d_s=$mm+($ss*86400);
			$d_e=$d_s+86400;
			if($val){$q="and  doc='$val'"; }else{$q="";}
			/************************************/				
			$sql2="select 
			SUM(srv)t0 , 
			SUM(total)t1 , 
			SUM(pay_net)t2 ,
			SUM(pay_insur)t3 ,
			SUM(dis)t4 
			from gnr_r_docs  where date ='$d_s'  $q ";
			$res2=mysql_q($sql2);
			$r2=mysql_f($res2);
			$t0=$r2['t0'];
			$t1=$r2['t1'];
			$t2=$r2['t2'];
			$t3=$r2['t3'];
			$t4=$r2['t4'];
			$pm0+=$t0;$pm1+=$t1;$pm2+=$t2;$pm3+=$t3;$pm4+=$t4;
			$doc_per=0;
			if($tt2){
				$doc_per=$tt6*100/$tt2;
			}
			$doc_per_txt='-';if($doc_per)$doc_per_txt='% '.number_format($doc_per,2);
			if($t0){
				echo '<tr>
				<td class="Over" onclick="loadRep('.$page.',0,'.$d_s.')"><ff>'.($ss+1).'</ff></td>
				<td><ff>'.number_format($t0).'</ff></td>					
				<td><ff class="clr1">'.number_format($t1).'</ff></td>
				<td><ff class="clr6">'.number_format($t2).'</ff></td>
				<td><ff class="clr1">'.number_format($t3).'</ff></td>
				<td><ff class="clr5">'.number_format($t4).'</ff></td>
				</tr>';
			}

			/***************************************/
		}
		$pm5=round($pm5,-1);
		echo '<tr fot>
			<td class="f1 fs14">'.k_total.'</td>
			<td><ff>'.number_format($pm0).'</ff></td>
			<td><ff class="clr1">'.number_format($pm1).'</ff></td>
			<td><ff class="clr6">'.number_format($pm2).'</ff></td>
			<td><ff class="clr1">'.number_format($pm3).'</ff></td>
			<td><ff class="clr5">'.number_format($pm4).'</ff></td>
			</tr>';
		?>
		</table><?		
	}
	if($tab==2){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		echo $breakC;
		echo repTitleShow();?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th rowspan="2"><?=k_doctor?></th>
			<th rowspan="2"><?=k_specialty?></th>
			<th rowspan="2"><?=k_job_code?></th>			
			<th colspan="4"><?=k_visits?></th>             
			<th colspan="4"><?=k_services?></th>				
			<th colspan="5"><?=k_financial?></th>
		</tr> 
		<tr>            	
			<th><?=k_tot_num?></th>
			<th><?=k_insurance?></th>
			<th><?=k_unpaid?></th>
			<th><?=k_new_pats?></th>
			<th><?=k_tot_num?></th>
			<th><?=k_proced?></th>
			<th><?=k_preview?></th>
			<th><?=k_review?></th>
			<th><?=k_val_srvs?> </th>
			<th><?=k_monetary?></th>
			<th><?=k_insurance?></th>
			<th><?=k_uncovered_amount?></th>
            <th>الحسم</th>
		</tr>
		<?
		$pm0=$pm1=$pm2=$pm3=$pm4=$pm5=$pm6=$pm7=$pm8=$pm9=$pm10=$pm11=0;
		$sql="select * from _users where grp_code IN('7htoys03le','nlh8spit9q','fk590v9lvl','9yjlzayzp','66hd2fomwt','1ceddvqi3g') order by name_$lg ASC";
		$res=mysql_q($sql);			
		while($r=mysql_f($res)){
			$doc_id=$r['id'];
			$grp_code=$r['grp_code'];
			$subgrp=$r['subgrp'];
			$doc_name=$r['name_'.$lg];
			$career_code=$r['career_code'];
			$clinic='';
			if($subgrp){
				$clinic=get_val_con('gnr_m_clinics','name_'.$lg," id IN ($subgrp)" );
			}

			/************************************/				
			$sql2="select 
			SUM(vis)t0 , 
			SUM(vis_free) t1 ,
			SUM(new_pat) t2 ,
			SUM(srv) t3 ,
			SUM(st0) t4 ,
			SUM(st1) t5 ,
			SUM(st2) t6 ,
			SUM(pt3) t11 ,
			SUM(total) t7 ,
			SUM(pay_net) t8 ,
			SUM(pay_insur) t9,
            SUM(dis) t12

			from gnr_r_docs where doc='$doc_id' and `date`>='$d_s' and `date`<'$d_e'   ";
			$res2=mysql_q($sql2);
			$r2=mysql_f($res2);
			$t0=$r2['t0'];
			$t1=$r2['t1'];
			$t2=$r2['t2'];
			$t3=$r2['t3'];
			$t4=$r2['t4'];
			$t5=$r2['t5'];
			$t6=$r2['t6'];
			$t7=$r2['t7'];
			$t8=$r2['t8'];
			$t9=$r2['t9'];
			$t11=$r2['t11'];
            $t12=$r2['t12'];
			$t8-=$t9;
			$t10=$t7-$t8;
			if($t0){					
				$pm0+=$t0;$pm1+=$t1;$pm2+=$t2;$pm3+=$t3;$pm4+=$t4;$pm5+=$t5;$pm6+=$t6;$pm7+=$t7;$pm8+=$t8;$pm9+=$t9;$pm10+=$t10;$pm12+=$t12;
				$pm11+=$t11;
				echo '<tr>
				<td txt>'.$doc_name.'</td>
				<td txt>'.$clinic.'</td>
				<td><ff>'.$career_code.'</ff></td>
				<td><ff class="clr6">'.number_format($t0).'</ff></td>
				<td><ff class="clr1">'.number_format($t11).'</ff></td>
				<td><ff class="clr5">'.number_format($t1).'</ff></td>
				<td><ff class="clr1">'.number_format($t2).'</ff></td>
				<td><ff class="clr6">'.number_format($t3).'</ff></td>
				<td><ff class="clr1">'.number_format($t4).'</ff></td>
				<td><ff class="clr1">'.number_format($t5).'</ff></td>
				<td><ff class="clr1">'.number_format($t6).'</ff></td>
				<td><ff class="clr6">'.number_format($t7).'</ff></td>
				<td><ff class="clr1">'.number_format($t8).'</ff></td>
				<td><ff class="clr1">'.number_format($t10).'</ff></td>
				<td><ff class="clr5">'.number_format($t9).'</ff></td>
                <td><ff class="clr5">'.number_format($t12).'</ff></td>
				</tr>';
			}
			/***************************************/
		}
		$pm5=round($pm5,-1);
		echo '<tr fot>
			<td class="f1 fs14" colspan="3">'.k_total.'</td>
			<td><ff class="clr6">'.number_format($pm0).'</ff></td>
			<td><ff class="clr1">'.number_format($pm11).'</ff></td>
			<td><ff class="clr5">'.number_format($pm1).'</ff></td>
			<td><ff class="clr1">'.number_format($pm2).'</ff></td>
			<td><ff class="clr6">'.number_format($pm3).'</ff></td>
			<td><ff class="clr1">'.number_format($pm4).'</ff></td>
			<td><ff class="clr1">'.number_format($pm5).'</ff></td>
			<td><ff class="clr1">'.number_format($pm6).'</ff></td>
			<td><ff class="clr6">'.number_format($pm7).'</ff></td>
			<td><ff class="clr1">'.number_format($pm8).'</ff></td>
			<td><ff class="clr1">'.number_format($pm10).'</ff></td>
			<td><ff class="clr5">'.number_format($pm9).'</ff></td>
            <td><ff class="clr5">'.number_format($pm12).'</ff></td>
			</tr>
		</table>';
	}
}
if($page==14){
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
	}
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;
		$d_e=$mm+($monLen*86400);			
	}
	if($tab==2){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;			
	}
	echo $breakC;
	echo repTitleShow();?>
	<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
	<? if($page_mood==2){echo exportTitle($reportTitle,35);}?>
	<tr>
		<th rowspan="2"><?=k_specialty?></th>
		<th rowspan="2"><?=k_doctor?></th>		
		<th rowspan="2"><?=k_job_code?></th>
		<th rowspan="2"><?=k_ttime?></th>
		<th rowspan="2"><?=k_vacations?></th>
		<th rowspan="2"><?=k_vac_hours?></th>
		<th rowspan="2"><?=k_real_time?></th>
		<th rowspan="2"><?=k_actual_enter?></th>

		<th rowspan="2"><?=k_addi?></th>
		<th rowspan="2"><?=k_add_altr?></th>
		<th rowspan="2"><?=k_actu_time?></th>
		<th rowspan="2"><?=k_latency?></th>
		<th rowspan="2"><?=k_absence?></th>
		<th rowspan="2"><?=k_absence_hours?></th>
		<th rowspan="2"><?=k_clinic_busy?></th>
		<th rowspan="2"><?=k_busy_percent?></th>
		<th colspan="9"><?=k_visits?></th>             
		<th colspan="4"><?=k_services?></th>				
		<th rowspan="2"><?=k_srvcs_time?></th>
		<th rowspan="2"><?=k_val_srvs?></th>
		<th rowspan="2"><?=k_val_in_hours?></th>
		<th rowspan="2"><?=k_operations?></th>
		<th rowspan="2"><?=k_oprs_val?> </th>
		<th rowspan="2"><?=k_prog_use?></th>
	</tr> 	
	<tr>            	
		<th><?=k_tot_num?></th>
		<th><?=k_vnorm?></th>
		<th><?=k_exemption?></th>
		<th><?=k_charity?></th>
		<th><?=k_insurance?></th>
		<th><?=k_paid?></th>
		<th> <?=k_unpaid?></th>
		<th><?=k_employee?></th>
		<th><?=k_new_patient?></th>
		<th><?=k_tot_num?></th>
		<th><?=k_proced?></th>
		<th><?=k_preview?></th>
		<th><?=k_review?></th>

	</tr>
	<?
	$pm0=$pm1=$pm2=$pm3=$pm4=$pm5=$pm6=$pm7=$pm8=$pm9=$pm10=0;
	$sql="select * from _users where grp_code IN('7htoys03le','nlh8spit9q','fk590v9lvl','9yjlzayzp','66hd2fomwt','1ceddvqi3g','9k0a1zy2ww') order by grp_code ASC , subgrp ASC  ";
	$res=mysql_q($sql);
	$data=array();
	$clnArr=array();
	while($r=mysql_f($res)){
		$doc_id=$r['id'];
		$grp_code=$r['grp_code'];
		$subgrp=$r['subgrp'];
		$doc_name=$r['name_'.$lg];
		$career_code=$r['career_code'];		
		$clinic=get_vals('gnr_m_clinics','name_'.$lg," id IN ($subgrp)" );
		/************************************/				
		$sql2="select 
		SUM(estimated)estimated , 
		SUM(_vacation) _vacation ,
		SUM(_vacation_hrs) _vacation_hrs ,
		SUM(_actual) _actual ,
		SUM(_overtime_normal) _overtime_normal ,
		SUM(_overtime) _overtime ,
		SUM(_delay) _delay ,
		SUM(_absent) _absent ,
		SUM(_absent_hrs) _absent_hrs ,
		SUM(_operations) _operations , 
		SUM(_operatons_amount) _operatons_amount , 
		SUM(v_total) v_total , 
		SUM(v_normal) v_normal , 
		SUM(v_exemption) v_exemption , 
		SUM(v_charity) v_charity , 
		SUM(v_insurance) v_insurance , 
		SUM(v_cash) v_cash , 
		SUM(v_free) v_free , 
		SUM(v_employee) v_employee , 
		SUM(v_new_pat) v_new_pat , 
		SUM(s_total) s_total , 
		SUM(s_preview) s_preview , 
		SUM(s_procedure) s_procedure , 
		SUM(s_review) s_review , 
		SUM(s_total_time) s_total_time , 
		SUM(total_revenue) total_revenue , 
		SUM(it) it 				
		from gnr_r_docs_details where doc='$doc_id' and `date`>='$d_s' and `date`<'$d_e'   ";//and done=1
		$res2=mysql_q($sql2);
		$r2=mysql_f($res2);

		$estimated=$r2['estimated'];
		$_vacation=$r2['_vacation'];
		$_vacation_hrs=$r2['_vacation_hrs'];
		$_actual=$r2['_actual'];
		$_overtime_normal=$r2['_overtime_normal'];
		$_overtime=$r2['_overtime'];
		$_delay=$r2['_delay'];
		$_absent=$r2['_absent'];
		$_absent_hrs=$r2['_absent_hrs'];
		$_operations=$r2['_operations'];
		$_operatons_amount=$r2['_operatons_amount'];
		$v_total=$r2['v_total'];
		$v_normal=$r2['v_normal'];
		$v_exemption=$r2['v_exemption'];
		$v_charity=$r2['v_charity'];
		$v_insurance=$r2['v_insurance'];
		$v_cash=$r2['v_cash'];
		$v_free=$r2['v_free'];
		$v_employee=$r2['v_employee'];
		$v_new_pat=$r2['v_new_pat'];
		$s_total=$r2['s_total'];
		$s_preview=$r2['s_preview'];
		$s_procedure=$r2['s_procedure'];
		$s_review=$r2['s_review'];
		$s_total_time=$r2['s_total_time'];
		$total_revenue=$r2['total_revenue'];

		if($estimated || $s_total){
			$pm0+=$t0;$pm1+=$t1;$pm2+=$t2;$pm3+=$t3;$pm4+=$t4;$pm5+=$t5;$pm6+=$t6;$pm7+=$t7;$pm8+=$t8;$pm9+=$t9;$pm10+=$t10;

			$realTime=$estimated-$_vacation_hrs;
			$actualTime=$_actual+$_overtime;
			$occTime=$realTime+$_overtime;
			$occTimePer=$_actual/$realTime*100;
			$total_revenue_hrs=$total_revenue/($s_total_time/60);
			
			$clnTxt=$subgrp;
			if($grp_code=='1ceddvqi3g'){
				$clnTxt=k_ray_tech;
				$clinic=k_ray_tech;
			}
			if($grp_code=='nlh8spit9q'){
				$clnTxt=k_rad_dr;
				$clinic=k_rad_dr;
			}
			$data[$doc_id]['cln']=$clinic;
			$data[$doc_id]['grp']="'".$clnTxt."'";
			array_push($clnArr,"'".$clnTxt."'");
			$data[$doc_id]['data']='			
			<td txt class="ws">'.$doc_name.'</td>			
			<td><ff>'.$career_code.'</ff></td>
			<td><ff class="">'.minToHour($estimated).'</ff></td>					
			<td><ff class="clr1">'.number_format($_vacation).'</ff></td>
			<td><ff class="clr1">'.minToHour($_vacation_hrs).'</ff></td>
			<td><ff class="clr6">'.minToHour($realTime).'</ff></td>
			<td><ff class="">'.minToHour($_actual).'</ff></td>
			<td><ff class="clr1">'.minToHour($_overtime_normal).'</ff></td>
			<td><ff class="clr1">'.minToHour($_overtime).'</ff></td>
			<td><ff class="clr6">'.minToHour($actualTime).'</ff></td>
			<td><ff class="clr5">'.minToHour($_delay).'</ff></td>
			<td><ff class="clr5">'.number_format($_absent).'</ff></td>
			<td><ff class="clr5">'.minToHour($_absent_hrs).'</ff></td>
			<td><ff class="clr6">'.minToHour($_actual).'</ff></td>
			<td><ff class="clr6">'.number_format($occTimePer,1).'%</ff></td>

			<td><ff class="clr1">'.number_format($v_total).'</ff></td>
			<td><ff class="clr1">'.number_format($v_normal).'</ff></td>
			<td><ff class="clr1">'.number_format($v_exemption).'</ff></td>
			<td><ff class="clr1">'.number_format($v_charity).'</ff></td>
			<td><ff class="clr1">'.number_format($v_insurance).'</ff></td>
			<td><ff class="clr1">'.number_format($v_cash).'</ff></td>
			<td><ff class="clr1">'.number_format($v_free).'</ff></td>
			<td><ff class="clr1">'.number_format($v_employee).'</ff></td>
			<td><ff class="clr1">'.number_format($v_new_pat).'</ff></td>

			<td><ff class="clr1">'.number_format($s_total).'</ff></td>
			<td><ff class="clr1">'.number_format($s_preview).'</ff></td>
			<td><ff class="clr1">'.number_format($s_procedure).'</ff></td>
			<td><ff class="clr1">'.number_format($s_review).'</ff></td>

			<td><ff class="clr6">'.minToHour($s_total_time).'</ff></td>
			<td><ff class="clr6">'.number_format($total_revenue).'</ff></td>
			<td><ff class="clr6">'.number_format($total_revenue_hrs).'</ff></td>

			<td><ff class="clr1">'.number_format($_operations).'</ff></td>
			<td><ff class="clr1">'.number_format($_operatons_amount).'</ff></td>
			<td><ff class="clr1">'.number_format($it).'</ff></td>
			';
		}
		

		/***************************************/
	}
	$counts=array_count_values($clnArr);
	$selCln='';
	foreach($data as $d ){
		echo '<tr>';
		if($d['grp']!=$selCln){
			$c=$counts[$d['grp']];
			echo '<td txt rowspan="'.$c.'" class="ws">'.$d['cln'].'</td>';
			$selCln=$d['grp'];
		}
		echo $d['data'];
		echo '</tr>';
	}
	?>

	</table>
	<?	
}
if($page==15){
	if($tab==0){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_ss=$mm;
		$d_ee=$mm+($monLen*86400);			
	}	
	if($tab==3){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_ss=strtotime($df);
		$d_ee=strtotime($dt)+86400;
	}
	if($tab==0 || $tab==3){
		echo $breakC;
		echo repTitleShow();?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<? if($page_mood==2){echo exportTitle($reportTitle,8);}?>
		<tr>
			<th><?=k_tday?></th>
			<th><?=k_tot_num?></th>
			<th><?=k_reserved?></th>
			<th><?=k_appointmnt_cncld?></th>
			<th><?=k_apologized?></th>
			<th><?=k_attended?></th>
			<th><?=k_not_attend?></th>
			<th><?=k_attnd_percent?></th>
		</tr>
		<?
		$st0=$st1=$st2=$st3=$st4=$st5=$st6=$st7=0;
		for($ss=$d_ss;$ss<$d_ee;$ss=$ss+86400){			
			$d_s=$ss;
			$d_e=$d_s+86400;
			$q="`d_start`>='$d_s' and `d_start`<'$d_e'";				
			$s1=getTotalCO('dts_x_dates'," $q and status=1 and reserve=0 ");		
			$s4=getTotalCO('dts_x_dates'," $q and status=4 and reserve=0 ");
			$s5=getTotalCO('dts_x_dates'," $q and status=5 and reserve=0 ");
			$s6=getTotalCO('dts_x_dates'," $q and status=6 and reserve=0 ");
			$s7=getTotalCO('dts_x_dates'," $q and status=7 and reserve=0 ");

			$sa=$s1+$s4+$s5+$s6+$s7;
			$st1+=$s1;$st4+=$s4;$st5+=$s5;$st6+=$s6;$st7+=$s7;$sta+=$sa;

			if($sa){
				echo '<tr>
				<td><ff>'.date('Y-m-d',$ss).'</ff></td>
				<td><ff class="clr1">'.number_format($sa).'</ff></td>
				<td><ff class="">'.number_format($s1).'</ff></td>					
				<td><ff class="clr5">'.number_format($s5).'</ff></td>					
				<td><ff class="clr5">'.number_format($s7).'</ff></td>
				<td><ff class="clr6">'.number_format($s4).'</ff></td>
				<td><ff class="clr5">'.number_format($s6).'</ff></td>
				<td><ff class="">'.number_format((100*$s4)/($s6+$s4),1).' %</ff></td>
				</tr>';
			}
		}

		/***************************************/
		echo '<tr fot>
			<td txt>'.k_total.'</td>
			<td><ff class="clr1">'.number_format($sta).'</ff></td>
			<td><ff class="">'.number_format($st1).'</ff></td>					
			<td><ff class="clr5">'.number_format($st5).'</ff></td>					
			<td><ff class="clr5">'.number_format($st7).'</ff></td>
			<td><ff class="clr6">'.number_format($st4).'</ff></td>
			<td><ff class="clr5">'.number_format($st6).'</ff></td>			
			<td><ff class="">'.number_format((100*$st4)/($st6+$st4),1).' %</ff></td>			
		</tr>';
		?>

		</table><?
	}
	if($tab==1){
		echo repoNav($fil,3,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();
		$q='';
		if($val){$q="and casher='$val'"; $add_title=get_val('_users','name_'.$lg,$val);}?>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<? if($page_mood==2){echo exportTitle($reportTitle,8);}?>
		<tr>
			<th><?=k_month?></th>
			<th><?=k_tot_num?></th>
			<th><?=k_reserved?></th>
			<th><?=k_appointmnt_cncld?></th>
			<th><?=k_apologized?></th>
			<th><?=k_attended?></th>
			<th><?=k_not_attend?></th>
			<th><?=k_attnd_percent?></th>
		</tr> 
		<?			
		for($ss=1;$ss<13;$ss++){
			$d_s=mktime(0,0,0,$ss,1,$selYear);
			$d_e=mktime(0,0,0,$ss+1,1,$selYear);

			$q="`d_start`>='$d_s' and `d_start`<'$d_e'";				
			$s1=getTotalCO('dts_x_dates'," $q and status=1 and reserve=0");				
			$s4=getTotalCO('dts_x_dates'," $q and status=4 and reserve=0");
			$s5=getTotalCO('dts_x_dates'," $q and status=5 and reserve=0");
			$s6=getTotalCO('dts_x_dates'," $q and status=6 and reserve=0");
			$s7=getTotalCO('dts_x_dates'," $q and status=7 and reserve=0");

			$sa=$s1+$s4+$s5+$s6+$s7;
			$st1+=$s1;$st4+=$s4;$st5+=$s5;$st6+=$s6;$st7+=$s7;$sta+=$sa;

			if($sa){
				echo '<tr>
				<td txt class="Over" onclick="loadRep('.$page.',0,\''.($selYear.'-'.$ss).'\')">'.$monthsNames[$ss].'</td>
				<td><ff class="clr1">'.number_format($sa).'</ff></td>
				<td><ff class="">'.number_format($s1).'</ff></td>					
				<td><ff class="clr5">'.number_format($s5).'</ff></td>					
				<td><ff class="clr5">'.number_format($s7).'</ff></td>
				<td><ff class="clr6">'.number_format($s4).'</ff></td>
				<td><ff class="clr5">'.number_format($s6).'</ff></td>
				<td><ff class="">'.number_format((100*$s4)/($s6+$s4),1).' %</ff></td>
				</tr>';
			}
		}
		/***************************************/
		echo '<tr fot>
			<td txt>'.k_total.'</td>
			<td><ff class="clr1">'.number_format($sta).'</ff></td>
			<td><ff class="">'.number_format($st1).'</ff></td>					
			<td><ff class="clr5">'.number_format($st5).'</ff></td>					
			<td><ff class="clr5">'.number_format($st7).'</ff></td>
			<td><ff class="clr6">'.number_format($st4).'</ff></td>
			<td><ff class="clr5">'.number_format($st6).'</ff></td>			
			<td><ff class="">'.number_format((100*$st4)/($st6+$st4),1).' %</ff></td>			
		</tr>';?>
		</table><?		
	}
	if($tab==2){
		echo repoNav($fil,0,$page,$tab,1,1,$page_mood);
		$q='';
		echo $breakC;
		echo repTitleShow();
		if($val){$q="and casher='$val'"; $add_title=get_val('_users','name_'.$lg,$val);}?>
		<div class="f1 fs18 clr1 lh40"><?=$add_title?></div>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<? if($page_mood==2){echo exportTitle($reportTitle,8);}?>
		<tr>
			<th><?=k_year?></th>
			<th><?=k_tot_num?></th>
			<th><?=k_reserved?></th>
			<th><?=k_appointmnt_cncld?></th>
			<th><?=k_apologized?></th>
			<th><?=k_attended?></th>
			<th><?=k_not_attend?></th>
			<th><?=k_attnd_percent?></th>
		</tr> 
		<?
		$years=getYearsOfRec('dts_x_dates','date',str_replace('and','',$q2));
		if($years[0]!=0){         
			for($ss=$years[0];$ss<=$years[1];$ss++){
				$d_s=strtotime($ss.'-1-1');
				$d_e=strtotime(($ss+1).'-1-1');

				$q="`d_start`>='$d_s' and `d_start`<'$d_e'";				
				$s1=getTotalCO('dts_x_dates'," $q and status=1 and reserve=0");				
				$s4=getTotalCO('dts_x_dates'," $q and status=4 and reserve=0");
				$s5=getTotalCO('dts_x_dates'," $q and status=5 and reserve=0");
				$s6=getTotalCO('dts_x_dates'," $q and status=6 and reserve=0");
				$s7=getTotalCO('dts_x_dates'," $q and status=7 and reserve=0");

				$sa=$s1+$s4+$s5+$s6+$s7;
				$st1+=$s1;$st4+=$s4;$st5+=$s5;$st6+=$s6;$st7+=$s7;$sta+=$sa;

				if($sa){
					echo '<tr>						
					<td class="Over" onclick="loadRep('.$page.',1,\''.$ss.'\')"><ff>'.$ss.'</ff></td>
					<td><ff class="clr1">'.number_format($sa).'</ff></td>
					<td><ff class="">'.number_format($s1).'</ff></td>					
					<td><ff class="clr5">'.number_format($s5).'</ff></td>					
					<td><ff class="clr5">'.number_format($s7).'</ff></td>
					<td><ff class="clr6">'.number_format($s4).'</ff></td>
					<td><ff class="clr5">'.number_format($s6).'</ff></td>
					<td><ff class="">'.number_format((100*$s4)/($s6+$s4),1).' %</ff></td>
					</tr>';
				}
			}
			/***************************************/
			echo '<tr fot>
				<td txt>'.k_total.'</td>
				<td><ff class="clr1">'.number_format($sta).'</ff></td>
				<td><ff class="">'.number_format($st1).'</ff></td>					
				<td><ff class="clr5">'.number_format($st5).'</ff></td>					
				<td><ff class="clr5">'.number_format($st7).'</ff></td>
				<td><ff class="clr6">'.number_format($st4).'</ff></td>
				<td><ff class="clr5">'.number_format($st6).'</ff></td>			
				<td><ff class="">'.number_format((100*$st4)/($st6+$st4),1).' %</ff></td>			
			</tr>';?>
			</table><?
		}
	}		
}
if($page==16){	
	$script='';
	if($tab==0 && $fin){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;			
		echo $breakC;
		echo repTitleShow();
		$shifts=array(0,9,13,17,21,24);
		$clinicData=array();
		/*********************************/
		$sql="select * from cln_x_visits where d_start>='$d_s' and d_start < '$d_e' and status=2 order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$clinic=$r['clinic'];
				$d_start=$r['d_start'];
				$pay_type=$r['pay_type'];
				$t_total_pay=$r['t_total_pay'];
				$t_pay_net=$r['t_pay_net'];
				$credit=$t_total_pay-$t_pay_net;
				$visTime=$d_start%86400;
				$shift=0;
				foreach($shifts as $k => $sh){
					$shiftTime=$sh*3600;						
					if($shiftTime<$visTime){
						$shift=$k;
					}
				}					
				$clinicData[$clinic][$doctor]['cash'.$shift]+=$t_pay_net;
				$clinicData[$clinic][$doctor]['credit'.$shift]+=$credit;
			}
		}
		/*********************************/
		$sql="select * from lab_x_visits where d_start>='$d_s' and d_start < '$d_e' and status  not in (0,1) order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			$clinic=get_val_c('gnr_m_clinics','id',2,'type');
			$doctor='lab';
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$d_start=$r['d_start'];
				$pay_type=$r['pay_type'];					
				$credit=$r['t_insur'];
				$t_pay_net=$r['t_payments'];					
				$visTime=$d_start%86400;
				$shift=0;
				foreach($shifts as $k => $sh){
					$shiftTime=$sh*3600;						
					if($shiftTime<$visTime){$shift=$k;}
				}					
				$clinicData[$clinic][$doctor]['cash'.$shift]+=$t_pay_net;
				$clinicData[$clinic][$doctor]['credit'.$shift]+=$credit;
			}
		}
		/*********************************/
		$sql="select * from xry_x_visits where d_start>='$d_s' and d_start < '$d_e' and status=2 order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$clinic=$r['clinic'];
				$d_start=$r['d_start'];
				$pay_type=$r['pay_type'];
				$t_total_pay=$r['t_total_pay'];
				$t_pay_net=$r['t_pay_net'];
				$credit=$t_total_pay-$t_pay_net;
				$visTime=$d_start%86400;
				$shift=0;
				foreach($shifts as $k => $sh){
					$shiftTime=$sh*3600;						
					if($shiftTime<$visTime){
						$shift=$k;
					}
				}					
				$clinicData[$clinic][$doctor]['cash'.$shift]+=$t_pay_net;
				$clinicData[$clinic][$doctor]['credit'.$shift]+=$credit;
			}
		}
		/*********************************/
		$sql="select * from bty_x_visits where d_start>='$d_s' and d_start < '$d_e' and status=2 order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$clinic=$r['clinic'];
				$d_start=$r['d_start'];
				$pay_type=$r['pay_type'];
				$t_total_pay=$r['t_total_pay'];
				$t_pay_net=$r['t_pay_net'];

				$credit=$t_total_pay-$t_pay_net;
				$visTime=$d_start%86400;
				$shift=0;
				foreach($shifts as $k => $sh){
					$shiftTime=$sh*3600;						
					if($shiftTime<$visTime){
						$shift=$k;
					}
				}					
				$clinicData[$clinic][$doctor]['cash'.$shift]+=$t_pay_net;
				$clinicData[$clinic][$doctor]['credit'.$shift]+=$credit;
			}
		}
		/*********************************/
		$sql="select * from bty_x_laser_visits where d_start>='$d_s' and d_start < '$d_e' and status=2 order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$clinic=$r['clinic'];
				$d_start=$r['d_start'];
				$pay_type=$r['pay_type'];
				$t_total_pay=$r['total_pay'];
				$t_pay_net=$r['total_pay'];

				$credit=$t_total_pay-$t_pay_net;
				$visTime=$d_start%86400;
				$shift=0;
				foreach($shifts as $k => $sh){
					$shiftTime=$sh*3600;						
					if($shiftTime<$visTime){
						$shift=$k;
					}
				}					
				$clinicData[$clinic][$doctor]['cash'.$shift]+=$t_pay_net;
				$clinicData[$clinic][$doctor]['credit'.$shift]+=$credit;
			}
		}
		/*********************************/
		$sql="select * from osc_x_visits where d_start>='$d_s' and d_start < '$d_e' and status=2 order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$clinic=$r['clinic'];
				$d_start=$r['d_start'];
				$pay_type=$r['pay_type'];
				$t_total_pay=$r['t_total_pay'];
				$t_pay_net=$r['t_pay_net'];
				$credit=$t_total_pay-$t_pay_net;
				$visTime=$d_start%86400;
				$shift=0;
				foreach($shifts as $k => $sh){
					$shiftTime=$sh*3600;						
					if($shiftTime<$visTime){
						$shift=$k;
					}
				}					
				$clinicData[$clinic][$doctor]['cash'.$shift]+=$t_pay_net;
				$clinicData[$clinic][$doctor]['credit'.$shift]+=$credit;
			}
		}
		/*********************************/
		
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<? if($page_mood==2){echo exportTitle($reportTitle,((count($shifts)-1)*3)+5);}?>
			<tr>
				<th rowspan="2"><?=k_tclinic?></th>
				<th rowspan="2"><?=k_doctor?></th>
				<? for($s=0;$s<count($shifts)-1;$s++){
					echo '<th colspan="3"><ff>'.clockStye($shifts[$s]).' - '.clockStye($shifts[$s+1]).'</ff></th>';
				}?>
				<th colspan="3"><?=k_all_day?></th>                    
			</tr>
			<tr>
				<? for($s=0;$s<count($shifts)-1;$s++){
					echo '<th>'.k_monetary.'</th><th>'.k_postpaid.'</th><th>'.k_total.'</th>';
				}?>
				<th><?=k_monetary?></th>
				<th><?=k_postpaid?></th>
				<th><?=k_total?></th>

			</tr>
			<?
			$sql2="select * from gnr_m_clinics where act=1 and type!=13 order by type ASC , name_$lg ASC";
			$res2=mysql_q($sql2);
			$rows2=mysql_n($res2);			
			if($rows2>0){
				while($r2=mysql_f($res2)){
					$c_id=$r2['id'];
					$name=$r2['name_'.$lg];						
					$c_type=$r2['type'];
					$td_total=0;
					$docs=0;
					if($clinicData[$c_id]){
						$docs=count($clinicData[$c_id]);
					}
					if($docs){
						$d=0;
						foreach($clinicData[$c_id] as $dk=> $dv){
							$td_cash=0;
							$td_credit=0;
							$rowC=$docs;
							if($docs>1){$rowC++;}
							if($d==0){
								echo '
								<tr>
								<td class="f1 fs14" rowspan="'.$rowC.'">'.$name.'</td>
								<td class="f1 fs14">'.get_val('_users','name_'.$lg,$dk).'</td>';								
							}else{
								echo '<tr><td class="f1 fs14">'.get_val('_users','name_'.$lg,$dk).'</td>';
							}
							for($s=0;$s<count($shifts)-1;$s++){
								$cash=intval($clinicData[$c_id][$dk]['cash'.$s]);
								$credit=intval($clinicData[$c_id][$dk]['credit'.$s]);
								$total=$cash+$credit;

								$td_cash+=$cash;
								$td_credit+=$credit;
								echo '<td><ff class="clr6">'.number_format($cash).'</ff></td>
								<td><ff class="clr5">'.number_format($credit).'</ff></td>
								<td><ff class="clr1">'.number_format($total).'</ff></td>';
							}
							$td_total+=$td_cash+$td_credit;
							echo '<td><ff class="clr6">'.number_format($td_cash).'</ff></td>
							<td><ff class="clr5">'.number_format($td_credit).'</ff></td>
							<td><ff class="clr1">'.number_format($td_total).'</ff></td>
							</tr>';
							$d++;
							$td_total=$td_cash=0;
						}
						$td_cash=$td_credit=0;
						if($docs>1){
							echo '<tr fot>									
							<td class="f1 fs14">'.k_total.'</td>';							
							for($s=0;$s<count($shifts)-1;$s++){
								$cash=$credit=0;
								foreach($clinicData[$c_id] as $dk=> $dv){
									$cash+=intval($clinicData[$c_id][$dk]['cash'.$s]);
									$credit+=intval($clinicData[$c_id][$dk]['credit'.$s]);
								}
								$total=$cash+$credit;

								$td_cash+=$cash;
								$td_credit+=$credit;
								echo '<td><ff class="clr6">'.number_format($cash).'</ff></td>
								<td><ff class="clr5">'.number_format($credit).'</ff></td>
								<td><ff class="clr1">'.number_format($total).'</ff></td>';
							}
							$td_total+=$td_cash+$td_credit;
							echo '<td><ff class="clr6">'.number_format($td_cash).'</ff></td>
							<td><ff class="clr5">'.number_format($td_credit).'</ff></td>
							<td><ff class="clr1">'.number_format($td_total).'</ff></td>
							</tr>';
						}
					}

				}
			}
			/*********************************/
			$name=''.k_txry.'';					
			$c_id=$dk='xray';
			$td_cash=$td_credit=$td_total=0;
			$xrayTxt='<tr>
			<td class="f1 fs14" rowspan="'.$rowC.'">'.$name.'</td>
			<td class="f1 fs14">-</td>';
			for($s=0;$s<count($shifts)-1;$s++){
				$cash=intval($clinicData[$c_id][$c_id]['cash'.$s]);
				$credit=intval($clinicData[$c_id][$c_id]['credit'.$s]);
				$total=$cash+$credit;
				$td_cash+=$cash;
				$td_credit+=$credit;
				$xrayTxt.='<td><ff class="clr6">'.number_format($cash).'</ff></td>
				<td><ff class="clr5">'.number_format($credit).'</ff></td>
				<td><ff class="clr1">'.number_format($total).'</ff></td>';
			}
			$td_total+=$td_cash+$td_credit;
			$xrayTxt.='<td><ff class="clr6">'.number_format($td_cash).'</ff></td>
			<td><ff class="clr5">'.number_format($td_credit).'</ff></td>
			<td><ff class="clr1">'.number_format($td_total).'</ff></td>
			</tr>';
			if($td_total){echo $xrayTxt;}
			/*********************************/?>
			</table><?
	}
    if($tab==10 && $fin){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);		
        
        $d_s=$mm;
        $d_e=$d_s+($monLen*86400);
            
            
		echo $breakC;
		echo repTitleShow();
		$shifts=array(0,9,13,17,21,24);
		$clinicData=array();
		/*********************************/
		$sql="select * from cln_x_visits where d_start>='$d_s' and d_start < '$d_e' and status=2 order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$clinic=$r['clinic'];
				$d_start=$r['d_start'];
				$pay_type=$r['pay_type'];
				$t_total_pay=$r['t_total_pay'];
				$t_pay_net=$r['t_pay_net'];
				$credit=$t_total_pay-$t_pay_net;
				$visTime=$d_start%86400;
				$shift=0;
				foreach($shifts as $k => $sh){
					$shiftTime=$sh*3600;						
					if($shiftTime<$visTime){
						$shift=$k;
					}
				}					
				$clinicData[$clinic][$doctor]['cash'.$shift]+=$t_pay_net;
				$clinicData[$clinic][$doctor]['credit'.$shift]+=$credit;
			}
		}
		/*********************************/
		$sql="select * from lab_x_visits where d_start>='$d_s' and d_start < '$d_e' and status  not in (0,1) order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			$clinic=get_val_c('gnr_m_clinics','id',2,'type');
			$doctor='lab';
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$d_start=$r['d_start'];
				$pay_type=$r['pay_type'];					
				$credit=$r['t_insur'];
				$t_pay_net=$r['t_payments'];					
				$visTime=$d_start%86400;
				$shift=0;
				foreach($shifts as $k => $sh){
					$shiftTime=$sh*3600;						
					if($shiftTime<$visTime){$shift=$k;}
				}					
				$clinicData[$clinic][$doctor]['cash'.$shift]+=$t_pay_net;
				$clinicData[$clinic][$doctor]['credit'.$shift]+=$credit;
			}
		}
		/*********************************/
		$sql="select * from xry_x_visits where d_start>='$d_s' and d_start < '$d_e' and status=2 order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$clinic=$r['clinic'];
				$d_start=$r['d_start'];
				$pay_type=$r['pay_type'];
				$t_total_pay=$r['t_total_pay'];
				$t_pay_net=$r['t_pay_net'];
				$credit=$t_total_pay-$t_pay_net;
				$visTime=$d_start%86400;
				$shift=0;
				foreach($shifts as $k => $sh){
					$shiftTime=$sh*3600;						
					if($shiftTime<$visTime){
						$shift=$k;
					}
				}					
				$clinicData[$clinic][$doctor]['cash'.$shift]+=$t_pay_net;
				$clinicData[$clinic][$doctor]['credit'.$shift]+=$credit;
			}
		}
		/*********************************/
		$sql="select * from bty_x_visits where d_start>='$d_s' and d_start < '$d_e' and status=2 order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$clinic=$r['clinic'];
				$d_start=$r['d_start'];
				$pay_type=$r['pay_type'];
				$t_total_pay=$r['t_total_pay'];
				$t_pay_net=$r['t_pay_net'];

				$credit=$t_total_pay-$t_pay_net;
				$visTime=$d_start%86400;
				$shift=0;
				foreach($shifts as $k => $sh){
					$shiftTime=$sh*3600;						
					if($shiftTime<$visTime){
						$shift=$k;
					}
				}					
				$clinicData[$clinic][$doctor]['cash'.$shift]+=$t_pay_net;
				$clinicData[$clinic][$doctor]['credit'.$shift]+=$credit;
			}
		}
		/*********************************/
		$sql="select * from bty_x_laser_visits where d_start>='$d_s' and d_start < '$d_e' and status=2 order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$clinic=$r['clinic'];
				$d_start=$r['d_start'];
				$pay_type=$r['pay_type'];
				$t_total_pay=$r['total_pay'];
				$t_pay_net=$r['total_pay'];

				$credit=$t_total_pay-$t_pay_net;
				$visTime=$d_start%86400;
				$shift=0;
				foreach($shifts as $k => $sh){
					$shiftTime=$sh*3600;						
					if($shiftTime<$visTime){
						$shift=$k;
					}
				}					
				$clinicData[$clinic][$doctor]['cash'.$shift]+=$t_pay_net;
				$clinicData[$clinic][$doctor]['credit'.$shift]+=$credit;
			}
		}
		/*********************************/
		$sql="select * from osc_x_visits where d_start>='$d_s' and d_start < '$d_e' and status=2 order by d_start ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			while($r=mysql_f($res)){
				$v_id=$r['id'];
				$doctor=$r['doctor'];
				$clinic=$r['clinic'];
				$d_start=$r['d_start'];
				$pay_type=$r['pay_type'];
				$t_total_pay=$r['t_total_pay'];
				$t_pay_net=$r['t_pay_net'];
				$credit=$t_total_pay-$t_pay_net;
				$visTime=$d_start%86400;
				$shift=0;
				foreach($shifts as $k => $sh){
					$shiftTime=$sh*3600;						
					if($shiftTime<$visTime){
						$shift=$k;
					}
				}					
				$clinicData[$clinic][$doctor]['cash'.$shift]+=$t_pay_net;
				$clinicData[$clinic][$doctor]['credit'.$shift]+=$credit;
			}
		}
		/*********************************/
		
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<? if($page_mood==2){echo exportTitle($reportTitle,((count($shifts)-1)*3)+5);}?>
			<tr>
				<th rowspan="2"><?=k_tclinic?></th>
				<th rowspan="2"><?=k_doctor?></th>
				<? for($s=0;$s<count($shifts)-1;$s++){
					echo '<th colspan="3"><ff>'.clockStye($shifts[$s]).' - '.clockStye($shifts[$s+1]).'</ff></th>';
				}?>
				<th colspan="3"><?=k_all_day?></th>                    
			</tr>
			<tr>
				<? for($s=0;$s<count($shifts)-1;$s++){
					echo '<th>'.k_monetary.'</th><th>'.k_postpaid.'</th><th>'.k_total.'</th>';
				}?>
				<th><?=k_monetary?></th>
				<th><?=k_postpaid?></th>
				<th><?=k_total?></th>

			</tr>
			<?
			$sql2="select * from gnr_m_clinics where act=1 and type!=13 order by type ASC , name_$lg ASC";
			$res2=mysql_q($sql2);
			$rows2=mysql_n($res2);			
			if($rows2>0){
				while($r2=mysql_f($res2)){
					$c_id=$r2['id'];
					$name=$r2['name_'.$lg];						
					$c_type=$r2['type'];
					$td_total=0;
					$docs=0;
					if(isset($clinicData[$c_id])){
						$docs=count($clinicData[$c_id]);
					}					
					if($docs){
						$d=0;
						foreach($clinicData[$c_id] as $dk=> $dv){
							$td_cash=0;
							$td_credit=0;
							$rowC=$docs;
							if($docs>1){$rowC++;}
							if($d==0){
								echo '
								<tr>
								<td class="f1 fs14" rowspan="'.$rowC.'">'.$name.'</td>
								<td class="f1 fs14">'.get_val('_users','name_'.$lg,$dk).'</td>';								
							}else{
								echo '<tr><td class="f1 fs14">'.get_val('_users','name_'.$lg,$dk).'</td>';
							}
							for($s=0;$s<count($shifts)-1;$s++){
								$cash=intval($clinicData[$c_id][$dk]['cash'.$s]);
								$credit=intval($clinicData[$c_id][$dk]['credit'.$s]);
								$total=$cash+$credit;

								$td_cash+=$cash;
								$td_credit+=$credit;
								echo '<td><ff class="clr6">'.number_format($cash).'</ff></td>
								<td><ff class="clr5">'.number_format($credit).'</ff></td>
								<td><ff class="clr1">'.number_format($total).'</ff></td>';
							}
							$td_total+=$td_cash+$td_credit;
							echo '<td><ff class="clr6">'.number_format($td_cash).'</ff></td>
							<td><ff class="clr5">'.number_format($td_credit).'</ff></td>
							<td><ff class="clr1">'.number_format($td_total).'</ff></td>
							</tr>';
							$d++;
							$td_total=$td_cash=0;
						}
						$td_cash=$td_credit=0;
						if($docs>1){
							echo '<tr fot>									
							<td class="f1 fs14">'.k_total.'</td>';							
							for($s=0;$s<count($shifts)-1;$s++){
								$cash=$credit=0;
								foreach($clinicData[$c_id] as $dk=> $dv){
									$cash+=intval($clinicData[$c_id][$dk]['cash'.$s]);
									$credit+=intval($clinicData[$c_id][$dk]['credit'.$s]);
								}
								$total=$cash+$credit;

								$td_cash+=$cash;
								$td_credit+=$credit;
								echo '<td><ff class="clr6">'.number_format($cash).'</ff></td>
								<td><ff class="clr5">'.number_format($credit).'</ff></td>
								<td><ff class="clr1">'.number_format($total).'</ff></td>';
							}
							$td_total+=$td_cash+$td_credit;
							echo '<td><ff class="clr6">'.number_format($td_cash).'</ff></td>
							<td><ff class="clr5">'.number_format($td_credit).'</ff></td>
							<td><ff class="clr1">'.number_format($td_total).'</ff></td>
							</tr>';
						}
					}

				}
			}
			/*********************************/
			$name=''.k_txry.'';					
			$c_id=$dk='xray';
			$td_cash=$td_credit=$td_total=0;
			$xrayTxt='<tr>
			<td class="f1 fs14" rowspan="'.$rowC.'">'.$name.'</td>
			<td class="f1 fs14">-</td>';
			for($s=0;$s<count($shifts)-1;$s++){
				$cash=intval($clinicData[$c_id][$c_id]['cash'.$s]);
				$credit=intval($clinicData[$c_id][$c_id]['credit'.$s]);
				$total=$cash+$credit;
				$td_cash+=$cash;
				$td_credit+=$credit;
				$xrayTxt.='<td><ff class="clr6">'.number_format($cash).'</ff></td>
				<td><ff class="clr5">'.number_format($credit).'</ff></td>
				<td><ff class="clr1">'.number_format($total).'</ff></td>';
			}
			$td_total+=$td_cash+$td_credit;
			$xrayTxt.='<td><ff class="clr6">'.number_format($td_cash).'</ff></td>
			<td><ff class="clr5">'.number_format($td_credit).'</ff></td>
			<td><ff class="clr1">'.number_format($td_total).'</ff></td>
			</tr>';
			if($td_total){echo $xrayTxt;}
			/*********************************/?>
			</table><?
	}
    if($tab==11110 && $fin){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;			
		echo $breakC;
		echo repTitleShow();
		$shifts=array(0,9,13,17,21,24);
		$clinicData=array();
		/*********************************/
		
		
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
			<? if($page_mood==2){echo exportTitle($reportTitle,((count($shifts)-1)*3)+5);}?>
			<tr>
				<th rowspan="2"><?=k_tclinic?></th>
				<th rowspan="2"><?=k_doctor?></th>
				<? for($s=0;$s<count($shifts)-1;$s++){
					echo '<th colspan="3"><ff>'.clockStye($shifts[$s]).' - '.clockStye($shifts[$s+1]).'</ff></th>';
				}?>
				<th colspan="3"><?=k_all_day?></th>                    
			</tr>
			<tr>
				<? for($s=0;$s<count($shifts)-1;$s++){
					echo '<th>'.k_monetary.'</th><th>'.k_postpaid.'</th><th>'.k_total.'</th>';
				}?>
				<th><?=k_monetary?></th>
				<th><?=k_postpaid?></th>
				<th><?=k_total?></th>

			</tr>
			<?
            $clinics=get_arr('gnr_m_clinics','id','type,name_'.$lg," act=1 and type!=13",1,"order by type ASC , name_$lg ASC limit 30");
            $doctors=get_arr('_users','id','subgrp,name_'.$lg," act=1 and grp_code in($docsGrpStr)",1,"order by name_$lg ASC limit 30");
            $q="and d_start>='$d_s' and d_start < '$d_e'";//" and status=2
            foreach($clinics as $clinic_id => $clinic){
                $clincDoctors=[];
                $clinicTotal=[];
                $mood=$clinic['type'];
                $table=$visXTables[$mood];
                foreach($doctors as $k=>$doc){
                    if(intval($doc['subgrp'])==$clinic_id){                     
                        array_push($clincDoctors,$k);
                    }
                }                
                if(count($clincDoctors)){
                    $docTotals=[0,0,0];
                    $dosClnTot=count($clincDoctors);
                    if($dosClnTot>1){$dosClnTot++;}
                    echo '<tr>
                        <td txtS rowspan="'.$dosClnTot.'">'.$clinic['name_'.$lg].'</td>';
                        foreach($clincDoctors as $docId){
                            echo '<td txtS>'.$doctors[$docId]['name_'.$lg].'</td>';
                            for($k=0;$k<count($shifts)-1 ; $k++){                                
                                $shiftS=$sh*3600;
                                $shiftE=$shifts[$k+1]*3600;
                                $q2="and MOD(d_start,86400)>=$shiftS and  MOD(d_start,86400) < $shiftE";                                
                                list($total,$cash)=get_sum($table ,'t_total_pay,t_pay_net',"doctor='$clinic_id' $q $q2 ");
                                $total=intval($total);
                                $cash=intval($cash);                                
                                $credit=$total-$cash;
                                
                                $docTotals[0]+=$cash;
                                $docTotals[1]+=$credit;
                                $docTotals[2]+=$total;
                                
                                $clinicTotal[$k][0]+=$cash;
                                $clinicTotal[$k][1]+=$credit;
                                $clinicTotal[$k][3]+=$total;
                                
                                echo '<td><ff14 class="clr6">'.number_format($cash).'</ff14></td>
                                <td><ff14 class="clr5">'.number_format($credit).'</ff14></td>
                                <td><ff14 class="clr8">'.number_format($total).'</ff14></td>'; 
                            }

                            echo '<td><ff14 class="clr6">'.number_format($docTotals[0]).'</ff14></td>
                            <td><ff14 class="clr5">'.number_format($docTotals[1]).'</ff14></td>
                            <td><ff14 class="clr8">'.number_format($docTotals[2]).'</ff14></td>
                            </tr>';
                        }
                        $clnTotalsCash=$clnTotalsCredit=0;
                        if($dosClnTot>1){
                            echo '<td txtS fot>'.k_total.'</td>';
                            for($k=0;$k<count($shifts)-1 ; $k++){
                                $clnTotalsCash+=$clinicTotal[$k][0];
                                $clnTotalsCredit+=$clinicTotal[$k][1];                                
                                
                                echo '<td fot><ff14 class="clr6">'.number_format($clinicTotal[$k][0]).'</ff14></td>
                                <td fot><ff14 class="clr5">'.number_format($clinicTotal[$k][1]).'</ff14></td>
                                <td fot><ff14 class="clr8">'.number_format($clinicTotal[$k][2]).'</ff14></td>'; 
                            }

                            echo '<td fot><ff14 class="clr6">'.number_format($clnTotalsCash).'</ff14></td>
                            <td fot><ff14 class="clr5">'.number_format($clnTotalsCredit).'</ff14></td>
                            <td fot><ff14 class="clr8">'.number_format($clnTotalsCash+$clnTotalsCredit).'</ff14></td>
                            </tr>';
                        }

                    echo '';
                    unset($docTotals);
                }
                unset($clincDoctors);
                unset($clinicTotal);
            }
			$sql2="select * from gnr_m_clinics where act=1 and type!=13 order by type ASC , name_$lg ASC";
			$res2=mysql_q($sql2);
			$rows2=mysql_n($res2);			
			if($rows2>0){
				while($r2=mysql_f($res2)){
					$c_id=$r2['id'];
					$name=$r2['name_'.$lg];						
					$c_type=$r2['type'];
					$td_total=0;
					$docs=count($clinicData[$c_id]);
					if($docs){
						$d=0;
						foreach($clinicData[$c_id] as $dk=> $dv){
							$td_cash=0;
							$td_credit=0;
							$rowC=$docs;
							if($docs>1){$rowC++;}
							if($d==0){
								echo '
								<tr>
								<td class="f1 fs14" rowspan="'.$rowC.'">'.$name.'</td>
								<td class="f1 fs14">'.get_val('_users','name_'.$lg,$dk).'</td>';								
							}else{
								echo '<tr><td class="f1 fs14">'.get_val('_users','name_'.$lg,$dk).'</td>';
							}
							for($s=0;$s<count($shifts)-1;$s++){
								$cash=intval($clinicData[$c_id][$dk]['cash'.$s]);
								$credit=intval($clinicData[$c_id][$dk]['credit'.$s]);
								$total=$cash+$credit;

								$td_cash+=$cash;
								$td_credit+=$credit;
								echo '<td><ff class="clr6">'.number_format($cash).'</ff></td>
								<td><ff class="clr5">'.number_format($credit).'</ff></td>
								<td><ff class="clr1">'.number_format($total).'</ff></td>';
							}
							$td_total+=$td_cash+$td_credit;
							echo '<td><ff class="clr6">'.number_format($td_cash).'</ff></td>
							<td><ff class="clr5">'.number_format($td_credit).'</ff></td>
							<td><ff class="clr1">'.number_format($td_total).'</ff></td>
							</tr>';
							$d++;
							$td_total=$td_cash=0;
						}
						$td_cash=$td_credit=0;
						if($docs>1){
							echo '<tr fot>									
							<td class="f1 fs14">'.k_total.'</td>';							
							for($s=0;$s<count($shifts)-1;$s++){
								$cash=$credit=0;
								foreach($clinicData[$c_id] as $dk=> $dv){
									$cash+=intval($clinicData[$c_id][$dk]['cash'.$s]);
									$credit+=intval($clinicData[$c_id][$dk]['credit'.$s]);
								}
								$total=$cash+$credit;

								$td_cash+=$cash;
								$td_credit+=$credit;
								echo '<td><ff class="clr6">'.number_format($cash).'</ff></td>
								<td><ff class="clr5">'.number_format($credit).'</ff></td>
								<td><ff class="clr1">'.number_format($total).'</ff></td>';
							}
							$td_total+=$td_cash+$td_credit;
							echo '<td><ff class="clr6">'.number_format($td_cash).'</ff></td>
							<td><ff class="clr5">'.number_format($td_credit).'</ff></td>
							<td><ff class="clr1">'.number_format($td_total).'</ff></td>
							</tr>';
						}
					}

				}
			}
			/*********************************/
			$name=''.k_txry.'';					
			$c_id=$dk='xray';
			$td_cash=$td_credit=$td_total=0;
			$xrayTxt='<tr>
			<td class="f1 fs14" rowspan="'.$rowC.'">'.$name.'</td>
			<td class="f1 fs14">-</td>';
			for($s=0;$s<count($shifts)-1;$s++){
				$cash=intval($clinicData[$c_id][$c_id]['cash'.$s]);
				$credit=intval($clinicData[$c_id][$c_id]['credit'.$s]);
				$total=$cash+$credit;
				$td_cash+=$cash;
				$td_credit+=$credit;
				$xrayTxt.='<td><ff class="clr6">'.number_format($cash).'</ff></td>
				<td><ff class="clr5">'.number_format($credit).'</ff></td>
				<td><ff class="clr1">'.number_format($total).'</ff></td>';
			}
			$td_total+=$td_cash+$td_credit;
			$xrayTxt.='<td><ff class="clr6">'.number_format($td_cash).'</ff></td>
			<td><ff class="clr5">'.number_format($td_credit).'</ff></td>
			<td><ff class="clr1">'.number_format($td_total).'</ff></td>
			</tr>';
			if($td_total){echo $xrayTxt;}
			/*********************************/?>
			</table><?
	}
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);						
		echo $breakC;
		echo repTitleShow();
		for($c=1;$c<count($clinicTypes);$c++){
			$newPat=$newAll=0;
			?>
			<div class="f1 fs18 clr1 lh50"><?=$clinicTypes[$c]?></div>
			<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
			<tr>
				<th rowspan="2" width="30"><?=k_tday?></th>                  
				<th colspan="4"><?=k_visits_types?></th>
				<th rowspan="2"><?=k_visits_total?></th>
				<th rowspan="2"><?=k_new_pats?></th>
				<th rowspan="2"><?=k_old_pats?></th>		
			</tr>
			<tr>
				<th><?=k_vnorm?></th>
				<th><?=k_charity?></th>
				<th><?=k_insurance?></th>
				<th><?=k_employee?></th>
			</tr> 
			<?
			$pm1=0;$pm2=0;$pm3=0;$pm4=0;$pm5=0;          
			for($ss=0;$ss<$monLen;$ss++){
				$d_s=$mm+($ss*86400);
				$d_e=$d_s+86400;
				$a_1=$a_2=$a_3=$a_4=$a_5=$all=0;
				//$newPat=getTotalCO('gnr_m_patients'," date >= '$d_s' and date < '$d_e' ");
				$sql2="select SUM(pt0) a1, SUM(pt2) a2, SUM(pt3) a3, SUM(emplo)a4 , SUM(new_pat) a5 from gnr_r_clinic where date = '$d_s' and type=$c ";
				$res2=mysql_q($sql2);
				if($res2){
					$r2=mysql_f($res2);
					$a_1=$r2['a1'];
					$a_2=$r2['a2'];
					$a_3=$r2['a3'];
					$a_4=$r2['a4'];
					$newPat=$r2['a5'];
					$all=$a_1+$a_2+$a_3;
				}
				$oldPat=$all-$newPat;
				$pm1+=$a_1;$pm2+=$a_2;$pm3+=$a_3;$pm4+=$a_4;$pm5+=$all;
				$newAll+=$newPat;
				if($a_1 || $a_2||$a_3){					
					$script.="d1".$c.".push(".$all.");";	
					$script.="d2".$c.".push(".$newPat.");";
					$script.="d3".$c.".push(".$oldPat.");";
					$script.="g".$c.".push(".($ss+1).");";?>
					<tr><td><div class="ff fs18 B txt_Over" onclick=" loadRep(<?=$page?>,0,<?=$d_s?>)"><?=($ss+1)?></div></td>    
					<td><ff class=""><?=number_format($a_1)?></ff></td>
					<td><ff class=""><?=number_format($a_2)?></ff></td>
					<td><ff class=""><?=number_format($a_3)?></ff></td>  
					<td><ff class=""><?=number_format($a_4)?></ff></td> 
					<td><ff class="clr1"><?=number_format($all)?></ff></td>
					<td><ff class=""><?=number_format($newPat)?></ff></td>
					<td><ff class=""><?=number_format($oldPat)?></ff></td>
					</tr><?	
				}
			}?> 
			<tr fot>
				<td class="f1 fs14"><?=k_ggre?></td>    
				<td><ff class=""><?=number_format($pm1)?></ff></td>
				<td><ff class=""><?=number_format($pm2)?></ff></td> 
				<td><ff class=""><?=number_format($pm3)?></ff></td>                    
				<td><ff class=""><?=number_format($pm4)?></ff></td>           
				<td><ff class="clr1"><?=number_format($pm5)?></ff></td>				
				<td><ff class=""><?=number_format($newAll)?></ff></td>
				<td><ff class=""><?=number_format($pm5-$newAll)?></ff></td>
			</tr>
			</table>
			<script>
				var d1<?=$c?>=new Array();
				var d2<?=$c?>=new Array();
				var d3<?=$c?>=new Array();
				var g<?=$c?>=new Array();
				<?=$script?>
				if(g<?=$c?>.length>0){
					$('#rep_container<?=$c?>').highcharts({		
						title: {
							text:'<?=k_visitors?> <?=$clinicTypes[$c]?> <?=k_in_month?> <?=$monthsNames[date('n',$d_s)].' '.$monthsNames[date('Y',$d_s)]?>'
						},
						xAxis:{categories:g<?=$c?>},
						yAxis:{title:{text:'<?=k_num_pats?>'}},
						legend:{layout:'vertical',align:'right',verticalAlign:'middle'},
						plotOptions:{
							series:{label:{connectorAllowed:true}},
							line:{dataLabels:{enabled:true},enableMouseTracking:true}
						},
						series:[{name:'<?=k_all_pats?>',data:d1<?=$c?>},{name:'<?=k_new_pats?>',data:d2<?=$c?>},{name:'<?=k_old_pats?>',data:d3<?=$c?>}],
						responsive:{rules:[{condition:{maxWidth:500},
							chartOptions:{legend:{layout: 'horizontal',align:'center',verticalAlign:'bottom'}}}]
						}
					});
				}
			</script>
			<div id="rep_container<?=$c?>" dir="ltr"></div><?
		}
	}
	if($tab==2){
		echo repoNav($fil,3,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();
		for($c=1;$c<count($clinicTypes);$c++){
			$newPat=$newAll=0;
			?>
			<div class="f1 fs18 clr1 lh50"><?=$clinicTypes[$c]?></div>
			<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
			<tr>
				<th rowspan="2" width="30"><?=k_tday?></th>                  
				<th colspan="4"><?=k_visits_types?></th>
				<th rowspan="2"><?=k_visits_total?></th>
				<th rowspan="2"><?=k_new_pats?></th>
				<th rowspan="2"><?=k_old_pats?></th>		
			</tr>
			<tr>
				<th><?=k_vnorm?></th>
				<th><?=k_charity?></th>
				<th><?=k_insurance?></th>
				<th><?=k_employee?></th>
			</tr> 
			<?
			$pm1=0;$pm2=0;$pm3=0;$pm4=0;$pm5=0;          
			for($ss=1;$ss<13;$ss++){
				$d_s=mktime(0,0,0,$ss,1,$selYear);
				$d_e=mktime(0,0,0,$ss+1,1,$selYear);

				$a_1=$a_2=$a_3=$a_4=$a_5=$all=0;
				//$newPat=getTotalCO('gnr_m_patients'," date >= '$d_s' and date < '$d_e' ");
				//$sql2="select SUM(v_l) a1, SUM(v_y) a2, SUM(nce) a3, SUM(loyee)a4 , SUM(vew_pat) a5 from cln_rpo_doinfo where date >= '$d_s' and date < '$d_e' and doc_type=$c ";
				$sql2="select SUM(pt0) a1, SUM(pt2) a2, SUM(pt3) a3, SUM(emplo)a4 , SUM(new_pat) a5 from gnr_r_clinic where date  >= '$d_s' and date < '$d_e' and type=$c ";
				$res2=mysql_q($sql2);
				if($res2){
					$r2=mysql_f($res2);
					$a_1=$r2['a1'];
					$a_2=$r2['a2'];
					$a_3=$r2['a3'];
					$a_4=$r2['a4'];
					$newPat=$r2['a5'];
					$all=$a_1+$a_2+$a_3;
				}
				$oldPat=$all-$newPat;
				$pm1+=$a_1;$pm2+=$a_2;$pm3+=$a_3;$pm4+=$a_4;$pm5+=$all;
				$newAll+=$newPat;
				if($a_1 || $a_2||$a_3){					
					$script.="d1".$c.".push(".$all.");";
					$script.="d2".$c.".push(".$newPat.");";
					$script.="d3".$c.".push(".$oldPat.");";
					$script.="g".$c.".push('".($monthsNames[$ss])."');";?>
					<tr><td><div class="f1 fs14 B txt_Over" onclick=" loadRep(<?=$page?>,1,'<?=($selYear.'-'.$ss)?>')"><?=$monthsNames[$ss]?></div></td>    
					<td><ff class=""><?=number_format($a_1)?></ff></td>
					<td><ff class=""><?=number_format($a_2)?></ff></td>
					<td><ff class=""><?=number_format($a_3)?></ff></td>  
					<td><ff class=""><?=number_format($a_4)?></ff></td> 
					<td><ff class="clr1"><?=number_format($all)?></ff></td>
					<td><ff class=""><?=number_format($newPat)?></ff></td>
					<td><ff class=""><?=number_format($oldPat)?></ff></td>
					</tr><?	
				}		
			}?>
			<tr fot>
			<td class="f1 fs14"><?=k_ggre?></td>    
			<td><ff class=""><?=number_format($pm1)?></ff></td>
			<td><ff class=""><?=number_format($pm2)?></ff></td> 
			<td><ff class=""><?=number_format($pm3)?></ff></td>                    
			<td><ff class=""><?=number_format($pm4)?></ff></td>           
			<td><ff class="clr1"><?=number_format($pm5)?></ff></td>				
			<td><ff class=""><?=number_format($newAll)?></ff></td>
			<td><ff class=""><?=number_format($pm5-$newAll)?></ff></td>
		</tr>
			</table>
			<script>
				var d1<?=$c?>=new Array();
				var d2<?=$c?>=new Array();
				var d3<?=$c?>=new Array();
				var g<?=$c?>=new Array();
				<?=$script?>
				if(g<?=$c?>.length>0){
					$('#rep_container<?=$c?>').highcharts({		
						title: {
							text:'<?=k_visitors?> <?=$clinicTypes[$c]?> <?=k_in_year?> <?=$selYear?>'
						},
						xAxis:{categories:g<?=$c?>},
						yAxis:{title:{text:'<?=k_num_pats?>'}},
						legend:{layout:'vertical',align:'right',verticalAlign:'middle'},
						plotOptions:{
							series:{label:{connectorAllowed:true}},
							line:{dataLabels:{enabled:true},enableMouseTracking:true}
						},
						series:[{name:'<?=k_all_pats?>',data:d1<?=$c?>},{name:'<?=k_new_pats?>',data:d2<?=$c?>},{name:'<?=k_old_pats?>',data:d3<?=$c?>}],
						responsive:{rules:[{condition:{maxWidth:500},
							chartOptions:{legend:{layout: 'horizontal',align:'center',verticalAlign:'bottom'}}}]
						}
					}); 
				}
			</script>
			<div id="rep_container<?=$c?>" dir="ltr"></div><?
		}
	}
}
if($page==17){
	$data=array();
	$sql="select * from gnr_m_reach_references ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	while($r=mysql_f($res)){$data[]=$r;}
	if($tab==0){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_ss=$mm;
		$d_ee=$mm+($monLen*86400);			
	}	
	if($tab==3){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);
		$d_ss=strtotime($df);
		$d_ee=strtotime($dt)+86400;
	}
	if($tab==0 || $tab==3){
		echo $breakC;
		echo repTitleShow();?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<? if($page_mood==2){echo exportTitle($reportTitle,$rows+1);}
		echo '<tr>
			<th>'.k_tday.'</th>';				
			foreach($data as $d){echo '<th>'.$d['name_'.$lg].'</th>';}
		echo '</tr>';
		$p_total=array();
		for($ss=$d_ss;$ss<$d_ee;$ss=$ss+86400){			
			$d_s=$ss;
			$d_e=$d_s+86400;
			$q=" p.date>='$d_s' and p.date <'$d_e' ";				
			echo '<tr>
			<td><ff>'.date('Y-m-d',$ss).'</ff></td>';				
			$sql="SELECT r.id as rid, r.name_ar AS n,  Count(p.reach_reference) AS c
			FROM gnr_m_reach_references r LEFT OUTER JOIN gnr_m_patients p ON p.reach_reference = r.id and $q

			GROUP BY r.name_ar order by r.id";
			$res=mysql_q($sql);
			while($r=mysql_f($res)){
				$p_total[$r['rid']]+=$r['c'];
				echo '<td><ff class="clr1">'.number_format($r['c']).'</ff></td>';						
			}
			echo '</tr>';
		}
		/***************************************/
		echo '<tr fot><td txt>'.k_total.'</td>';				
		foreach($data as $d){echo '<td><ff>'.number_format($p_total[$d['id']]).'</ff></td>';}
		echo '</tr>';?>
		</table>
	<?
	}
	if($tab==1){
		echo repoNav($fil,3,$page,$tab,1,1,$page_mood);			
		echo $breakC;
		echo repTitleShow();?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<? if($page_mood==2){echo exportTitle($reportTitle,$rows+1);}
		echo '<tr>
			<th>'.k_tday.'</th>';				
			foreach($data as $d){echo '<th>'.$d['name_'.$lg].'</th>';}
		echo '</tr>';
		$p_total=array();			
		for($ss=1;$ss<13;$ss++){
			$d_s=mktime(0,0,0,$ss,1,$selYear);
			$d_e=mktime(0,0,0,$ss+1,1,$selYear);

			$q=" p.date>='$d_s' and p.date <'$d_e' ";				
			echo '<tr>				
			<td txt class="Over" onclick="loadRep('.$page.',0,\''.($selYear.'-'.$ss).'\')">'.$monthsNames[$ss].'</td>';
			$sql="SELECT r.id as rid, r.name_ar AS n,  Count(p.reach_reference) AS c
			FROM gnr_m_reach_references r LEFT OUTER JOIN gnr_m_patients p ON p.reach_reference = r.id and $q
			GROUP BY r.name_ar order by r.id";
			$res=mysql_q($sql);
			while($r=mysql_f($res)){
				$p_total[$r['rid']]+=$r['c'];
				echo '<td><ff class="clr1">'.number_format($r['c']).'</ff></td>';						
			}
			echo '</tr>';
		}
		/***************************************/
		echo '<tr fot><td txt>'.k_total.'</td>';				
		foreach($data as $d){echo '<td><ff>'.number_format($p_total[$d['id']]).'</ff></td>';}
		echo '</tr>';?>
		</table><?		
	}
	if($tab==2){
		echo repoNav($fil,0,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();?>
		<table width="100%" border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<? if($page_mood==2){echo exportTitle($reportTitle,$rows+1);}
		echo '<tr>
			<th>'.k_tday.'</th>';				
			foreach($data as $d){echo '<th>'.$d['name_'.$lg].'</th>';}
		echo '</tr>';
		$p_total=array();
		$years=getYearsOfRec('gnr_m_patients','date'," date!=0");
		if($years[0]!=0){         
			for($ss=$years[0];$ss<=$years[1];$ss++){
				$d_s=strtotime($ss.'-1-1');
				$d_e=strtotime(($ss+1).'-1-1');
				$q=" p.date>='$d_s' and p.date <'$d_e' ";
				echo '<tr>				
				<td txt class="Over" onclick="loadRep('.$page.',1,'.($year).')"><ff>'.$ss.'</ff></td>';
				$sql="SELECT r.id as rid, r.name_ar AS n,  Count(p.reach_reference) AS c
				FROM gnr_m_reach_references r LEFT OUTER JOIN gnr_m_patients p ON p.reach_reference = r.id and $q
				GROUP BY r.name_ar order by r.id";
				$res=mysql_q($sql);
				while($r=mysql_f($res)){
					$p_total[$r['rid']]+=$r['c'];
					echo '<td><ff class="clr1">'.number_format($r['c']).'</ff></td>';						
				}
				echo '</tr>';
			}
			/***************************************/
			echo '<tr fot><td txt>'.k_total.'</td>';				
			foreach($data as $d){echo '<td><ff>'.number_format($p_total[$d['id']]).'</ff></td>';}
			echo '</tr>'?>
			</table><?
		}
	}		
}
if($page==18){
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
	}		
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;            
		$d_e=$d_s+(($monLen)*86400);
	}		
	if($tab==2){
		echo repoNav($fil,3,$page,$tab,1,1,$page_mood);
		$d_s=mktime(0,0,0,1,1,$selYear);
		$d_e=mktime(0,0,0,1,1,$selYear+1);
	}		
	if($tab==3){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
	}
	echo $breakC;
	echo repTitleShow();
	$sql="select rec,
	sum(vis_cash) v_cash ,
	sum(vis_def) v_def ,
	sum(vis_cancel) v_cancel ,
	sum(vis_total) v_total ,
	sum(vis_act) v_act ,
	sum(dts_total) d_total ,
	sum(dts_cancel) d_cancel ,
	sum(dts_act) d_act ,
	sum(dts_ok) d_ok ,
	sum(dts_delay) d_delay ,
	sum(dts_do) d_do ,
	sum(dts_do_not) d_do_not ,
	sum(bal) r_bal 
	from gnr_r_recepion where date>='$d_s' and date < '$d_e' group by rec order by r_bal DESC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>				
			<th rowspan="2">#</th>
			<th rowspan="2"><?=k_themployee?></th>
			<th rowspan="2"><?=k_code?></th>
			<th colspan="5"><?=k_visits?></th>
			<th colspan="7"><?=k_appointments?></th>
			<th rowspan="2"><?=k_performance?></th>				
		</tr>
		<tr>
			<th><?=k_monetary?></th>
			<th><?=k_postpaid?></th>                      
			<th><?=k_totl?></th>
			<th><?=k_cncled?></th>
			<th><?=k_actual?></th>
			<th><?=k_reservation?></th>
			<th><?=k_cncled?></th>
			<th><?=k_actual?></th>
			<th><?=k_commited?></th>
			<th><?=k_late_attend?></th>
			<th><?=k_attended?></th>
			<th><?=k_not_attend?></th>
		</tr><?
		$i=1;
		while($r=mysql_f($res)){
			$rec=$r['rec'];
			list($career_code,$emp)=get_val('_users','career_code,name_'.$lg,$rec);
			$v_cash=$r['v_cash'];
			$v_def=$r['v_def'];
			$v_cancel=$r['v_cancel'];
			$v_total=$r['v_total'];
			$v_act=$r['v_act'];
			$d_total=$r['d_total'];
			$d_cancel=$r['d_cancel'];
			$d_act=$r['d_act'];
			$d_ok=$r['d_ok'];
			$d_delay=$r['d_delay'];
			$d_do=$r['d_do'];
			$d_do_not=$r['d_do_not'];
			$bal=$r['r_bal'];				
			echo '
			<tr>
			<td><ff>'.$i.'</ff></td>
			<td txt>'.$emp.'</td>
			<td><ff>'.$career_code.'</ff></td>				
			<td><ff class="clr1">'.number_format($v_cash).'</ff></td>
			<td><ff class="clr1">'.number_format($v_def).'</ff></td>
			<td><ff class="clr1">'.number_format($v_total).'</ff></td>
			<td><ff class="clr5">'.number_format($v_cancel).'</ff></td>
			<td><ff class="clr6">'.number_format($v_act).'</ff></td>
			<td><ff class="clr1">'.number_format($d_total).'</ff></td>
			<td><ff class="clr5">'.number_format($d_cancel).'</ff></td>
			<td><ff class="clr6">'.number_format($d_act).'</ff></td>
			<td><ff class="clr1">'.number_format($d_ok).'</ff></td>
			<td><ff class="clr1">'.number_format($d_delay).'</ff></td>
			<td><ff class="clr6">'.number_format($d_do).'</ff></td>
			<td><ff class="clr5">'.number_format($d_do_not).'</ff></td>
			<td><ff class="clr6">'.number_format($bal).'</ff></td>
			</tr>';
			$i++;
		}
		echo '</table>';
	}else{echo '<div class="f1 fs18 clr5">'.k_no_recs.'</div>';}
}
if($page==19){
	if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
	}		
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;			 
		$d_e=$d_s+(($monLen-1)*86400);
	}		
	if($tab==2){
		echo repoNav($fil,3,$page,$tab,1,1,$page_mood);
		$d_s=mktime(0,0,0,1,1,$selYear);
		$d_e=mktime(0,0,0,1,1,$selYear+1);
	}		
	if($tab==3){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
	}
	echo $breakC;
	echo repTitleShow();
	$sql="select doc, count(*)c from gnr_x_visit_end where vis_date>='$d_s' and vis_date < '$d_e' group by doc order by c DESC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	//echo '^';
	if($rows>0){?>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>				
			<th>#</th>
			<th><?=k_doctor?></th>
			<th><?=k_visits?></th>
			<th><?=k_fininshed_i?></th>
			<th><?=k_percent?></th>							
		</tr>
		<?

		$data=array();
		while($r=mysql_f($res)){
			$doc=$r['doc'];
			$c=$r['c'];	
			$docVis=get_sum('gnr_r_docs','vis'," doc='$doc' and  date>='$d_s' and date < '$d_e' ");
			$perc=$c*100/$docVis;
			//if($docVis){
				$data[$doc]= array('doc'=>$doc,'vis'=>$docVis,'end'=>$c,'perc'=>$perc);
			//}
		}
		$sortCol  = array_column($data, 'perc');
		array_multisort($sortCol, SORT_DESC, $data);
		$i=1;
		foreach($data as $d){
			$docTxt=get_val('_users','name_'.$lg,$d['doc']);
			echo '
			<tr>
			<td><ff>'.$i.'</ff></td>
			<td txt>'.$docTxt.'</td>
			<td><ff class="clr1">'.number_format($d['vis']).'</ff></td>
			<td><ff class="clr5">'.number_format($d['end']).'</ff></td>
			<td><ff class="clr55">'.number_format($d['perc'],2).'%</ff></td>
			</tr>';
			$i++;
		}

		echo '</table>';
	}else{echo '<div class="f1 fs18 clr5">'.k_no_recs.'</div>';}
}
if($page==20){		
	if($tab==1){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
	}
	if($tab==2){		
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;			 
        $d_e=$d_s+(($monLen)*86400);
	}
	if($tab==3){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
	}
	echo $breakC;
	echo repTitleShow();
	echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
	<tr>
		<th rowspan="2">'.k_code.'</th>
		<th rowspan="2">'.k_dr.'</th>
		<th rowspan="2">'.k_service.'</th>
		<th colspan="2">إجماليات</th>		
		<th colspan="2">نقدي</th>
		<th colspan="2">تأمين</th>
		<th colspan="2">جمعيات</th>
	</tr>
	<tr>
		<th>العدد</th>
		<th>القيمة</th>
		<th>العدد</th>
		<th>القيمة</th>
		<th>العدد</th>
		<th>القيمة</th>
		<th>العدد</th>
		<th>القيمة</th>
	</tr>';
	$tot=array();
	$q=" IN($docsGrpsQ) ";
	if($val){$q=" id='$val' ";}
	$sql="select id,name_$lg,subgrp from _users where `grp_code` $q and `grp_code`!='66hd2fomwt' order by subgrp ASC , name_$lg ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$totals=array();			
		while($r=mysql_f($res)){			
			$doc_id=$r['id'];
			$name=$r['name_'.$lg];
			$clinic=$r['subgrp'];
			$career_code=$r['career_code'];
			$mood=get_val('gnr_m_clinics','type',intval($clinic));
			$table=$srvXTables[$mood];
			$q=" doc='$doc_id' and d_start>='$d_s' and d_start<'$d_e' and status='1'";//
			$srvices=get_vals($table,'service',$q,'arr');
			$f=0;
			$srvData=array();
			foreach($srvices as $srv){	
				
				$srvTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv2'.$mood);
				echo '<tr>';	
				if($f==0){
					echo '<td rowspan="'.count($srvices).'">'.$career_code.'</td>
					<td txt class="cur Over" rowspan="'.count($srvices).'" onclick="chnRepVal('.$doc_id.')">'.$name.'</td>';
				}
				$f=1;
				
				$sql2="select count(*)c,sum(total_pay)v,pay_type from $table where $q and service='$srv' group by pay_type ASC";
				$res2=mysql_q($sql2);
				$rows2=mysql_n($res2);
				if($rows2){
					$i=0;
					while($r2=mysql_f($res2)){
						$c=$r2['c'];
						$v=$r2['v'];
						$pay_type=$r2['pay_type'];
						$srvData[$doc_id.'-'.$srv.'-'.$pay_type]['c']=$c;
						$srvData[$doc_id.'-'.$srv.'-'.$pay_type]['v']=$v;						
					}
					$c_0=$srvData[$doc_id.'-'.$srv.'-0']['c'];
					$v_0=$srvData[$doc_id.'-'.$srv.'-0']['v'];
					$c_2=$srvData[$doc_id.'-'.$srv.'-2']['c'];
					$v_2=$srvData[$doc_id.'-'.$srv.'-2']['v'];
					$c_3=$srvData[$doc_id.'-'.$srv.'-3']['c'];
					$v_3=$srvData[$doc_id.'-'.$srv.'-3']['v'];
					
					$totals[0]+=$c_0;
					$totals[1]+=$v_0;
					$totals[2]+=$c_2;
					$totals[3]+=$v_2;
					$totals[4]+=$c_3;
					$totals[5]+=$v_3;
					echo '
						<td txt>'.$srvTxt.'</td>						
						<td><ff class="clr1">'.number_format($c_0+$c_2+$c_3).'</div></td>
						<td><ff class="clr6">'.number_format($v_0+$v_2+$v_3).'</div></td>
						<td><ff class="clr1">'.number_format($c_0).'</div></td>
						<td><ff class="clr6">'.number_format($v_0).'</div></td>
						<td><ff class="clr1">'.number_format($c_2).'</div></td>
						<td><ff class="clr6">'.number_format($v_2).'</div></td>
						<td><ff class="clr1">'.number_format($c_3).'</div></td>
						<td><ff class="clr6">'.number_format($v_3).'</div></td>
					</tr>';
				}
			}
		}			
	}	
	
	echo '<tr fot>
	<td txt colspan="3">'.k_total.'</td>
	<td><ff class="clr1">'.number_format($totals[0]+$totals[2]+$totals[4]).'</div></td>
	<td><ff class="clr6">'.number_format($totals[1]+$totals[3]+$totals[5]).'</div></td>
	<td><ff class="clr1">'.number_format($totals[0]).'</div></td>
	<td><ff class="clr6">'.number_format($totals[1]).'</div></td>
	<td><ff class="clr1">'.number_format($totals[2]).'</div></td>
	<td><ff class="clr6">'.number_format($totals[3]).'</div></td>
	<td><ff class="clr1">'.number_format($totals[4]).'</div></td>
	<td><ff class="clr6">'.number_format($totals[5]).'</div></td>
	</tr>
	</table>';	
}
if($page==21){
	$x_times=array('0-13','13-17','17-21','21-24');
	if($tab==1){$qn=0;
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
		echo $breakC;
		echo repTitleShow();
		list($u_ids,$u_names,$u_clinic)=get_vals('_users','id,name_'.$lg.',subgrp'," grp_code IN($docsGrpsQ)",'arr',0);
		$repData=array();
		$sql="select id , name_$lg , type from  gnr_m_clinics where type not IN(2,6) order by type ASC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);		
		if($rows>0){			
			while($r=mysql_f($res)){
				$cln_id=$r['id'];
				$name=$r['name_'.$lg];
				$type=$r['type'];
				$subgrp=intval($r['subgrp']);				
				$table=$srvXTables[$type];				
				foreach($x_times as $k=>$x){
					$xx=explode('-',$x);
					$sH=$xx[0]*3600;
					$eH=$xx[1]*3600;
					$t_s=$d_s+$sH;
					$t_e=$d_s+$eH;
					$repData[$k][$cln_id]['id']=$cln_id;
					$repData[$k][$cln_id]['name']=$name;
					$repData[$k][$cln_id]['type']=$type;
					$repData[$k][$cln_id]['total']=0;
					$repData[$k][$cln_id]['data']=array();
					
					foreach($u_clinic as $k2=>$c){
						if(intval($c)==$cln_id){
							$doc_id=$u_ids[$k2];
							$doc_name=$u_names[$k2];						
							$q=" and doc='$doc_id' and d_start >= $t_s and d_start < $t_e and status=1";
							//$q="and doc='$doc_id'";
							$pay_cash=get_sum($table,'total_pay',"pay_type=0 $q ");$qn++;
							$pay_char=get_sum($table,'total_pay',"pay_type=2 $q ");$qn++;
							$pay_insur=get_sum($table,'total_pay',"pay_type=3 $q ");$qn++;
							
							$pay_all=$pay_cash+$pay_char+$pay_insur;
							if($pay_all){
								$rec=array($doc_id,$doc_name,$pay_cash,$pay_char,$pay_insur,$pay_all);
								$repData[$k][$cln_id]['data'][]=$rec;
								$repData[$k][$cln_id]['total']+=$pay_all;
							}
						}
					}
				}
			}
			foreach($repData as $k=>$x){
				echo '<div class="fl fs24 ff B lh40 clr1">'.viewRengTime($x_times[$k]).'</div>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
				<tr>
					<th>الاخصاص</th>
					<th>'.k_dr.'</th>
					<th>إجمالي نقدي</th>
					<th>إجمالي تأمين</th>
					<th>إجمالي جمعيات </th>
					<th>إجمالي</th>
					<th>إجمالي الاختصاص</th>
				</tr>';
				$actCln=0;				
				foreach($x as $k2=>$x2){					
					$rc=count($x2['data']);
					if($rc){
						foreach($x2['data'] as $d){										
							echo '<tr>';
							if($actCln!=intval($x2['id'])){
								echo '<td rowspan="'.$rc.'" txt>'.$x2['name'].'</td>';
							}
							echo '<td txt>'.$d[1].'</td>
							<td><ff>'.number_format($d[2]).'</ff></td>
							<td><ff>'.number_format($d[4]).'</ff></td>
							<td><ff>'.number_format($d[3]).'</ff></td>
							<td><ff>'.number_format($d[5]).'</ff></td>';
							if($actCln!=intval($x2['id'])){
								echo '<td  rowspan="'.$rc.'"><ff>'.number_format($x2['total']).'</ff></td>';
								$actCln=intval($x2['id']);								
							}							
							echo '</tr>';
						}
					}			
				}
				echo '</table>';
			}
			//echo $qn++;;
		}
	}	
}
if($page==22){		
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;            
		$d_e=$d_s+(($monLen)*86400);
	}		
	if($tab==2){
		echo repoNav($fil,3,$page,$tab,1,1,$page_mood);
		$d_s=mktime(0,0,0,1,1,$selYear);
		$d_e=mktime(0,0,0,1,1,$selYear+1);
	}		
	if($tab==3){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
	}
	echo $breakC;
	echo repTitleShow();
	$users=get_arr('_users','id','name_'.$lg," grp_code='pfx33zco65' ");
	$sql="select count(user)as tot , user from _log_opr where date>='$d_s' and date < '$d_e'  and `mod`='p7jvyhdf3' and opr=2 group by user order by tot DESC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		?>
		<table border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
		<tr>				
			<th width="40">#</th>
			<th><?=k_themployee?></th>
			<th width="150"><?=k_totl?></th>			
		</tr>
		<? $i=1;
		while($r=mysql_f($res)){
			$user=$r['user'];
			$tot=$r['tot'];							
			echo '
			<tr>
			<td><ff>'.$i.'</ff></td>
			<td txt>'.$users[$user].'</td>
			<td><ff class="clr1">'.number_format($tot).'</ff></td>
			</tr>';
			$i++;
		}
		echo '</table>';
	}else{echo '<div class="f1 fs18 clr5">'.k_no_recs.'</div>';}
}
if($page==23){	 
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		echo $breakC;
		echo repTitleShow();?>
		<table border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th width="30"><?=k_tday?></th>			
			<th width="120"><?=k_number?></th>		
		</tr>  
		<?
		$total=0;
		for($ss=0;$ss<$monLen;$ss++){
			$d_s=$mm+($ss*86400);
			$d_e=$d_s+86400;
			$no=getTotalCO('gnr_m_insurance_rec'," date >= '$d_s' and date < '$d_e' ");
			if($no){
				$total+=$no;?>           
				<tr><td><ff><?=($ss+1)?></ff></td>				
				<td><ff><?=number_format($no)?></ff></td>
				</tr><?	
			}
		}?> 
		<tr fot>
			<td class="f1 fs14"><?=k_total?></td>
			<td><ff><?=number_format($total)?></ff></td>               
		</tr>
		</table><?		
	}
	if($tab==2){ 
		echo repoNav($fil,3,$page,$tab,1,1,$page_mood);			
		echo $breakC;
		echo repTitleShow();?>			
		<table border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th width="120"><?=k_month?></th>
			<th width="120"><?=k_number?></th>		
		</tr><?
		$total=0;			
		for($ss=1;$ss<13;$ss++){
			$d_s=mktime(0,0,0,$ss,1,$selYear);
			$d_e=mktime(0,0,0,$ss+1,1,$selYear);
			$no=getTotalCO('gnr_m_insurance_rec'," date >= '$d_s' and date < '$d_e' ");
			if($no){
				$total+=$no;?>           
				<tr>
					<td><div class="f1 fs14 txt_Over" onclick="loadRep(<?=$page?>,1,'<?=($selYear.'-'.$ss)?>')"><?=$monthsNames[$ss]?></div></td>			
					<td><ff><?=number_format($no)?></ff></td>
				</tr><?	
			}
		}?> 
		<tr fot>
			<td class="f1 fs14"><?=k_total?></td>
			<td><ff><?=number_format($total)?></ff></td>               
		</tr>
		</table><?
	}
	if($tab==3){
		echo repoNav($fil,0,$page,$tab,1,1,$page_mood);
		$q='';
		echo $breakC;
		echo repTitleShow();?>
		<table border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
		<tr>
			<th width="80"><?=k_year?></th>
			<th width="120"><?=k_total?></th>			
		</tr><?
		$total=0;	
		$years=getYearsOfRec('gnr_m_insurance_rec','date',"date!=0");		
		if($years[0]!=0){
			for($ss=$years[0];$ss<=$years[1];$ss++){
				$d_s=strtotime($ss.'-1-1');
				$d_e=strtotime(($ss+1).'-1-1');
				$no=getTotalCO('gnr_m_insurance_rec'," date >= '$d_s' and date < '$d_e' ");
				if($no){
					$total+=$no;?>
					<tr>
						<td><div class="f1 fs14 txt_Over" onclick="loadRep(<?=$page?>,2,'<?=($ss)?>')"><ff><?=$ss?></ff></div></td>			
						<td><ff><?=number_format($no)?></ff></td>
					</tr><?
				}
			}?>
			<tr fot>
				<td class="f1 fs14"><?=k_total?></td>
				<td><ff><?=number_format($total)?></ff></td>               
			</tr>
			</table><?
		}
	}	
}
if($page==24){	
    if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;            
		$d_e=$d_s+(($monLen)*86400);
	}		
	if($tab==2){	
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
	}
    echo $breakC;
    echo repTitleShow();?>
    <table border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
    <tr>
        <th><?=k_dr?></th>			
        <th width="120">طلبات الأشعة</th>
        <th width="120">قيمة طلبات الأشعة</th>
        <th width="120">طلبات التحاليل</th>
        <th width="120">قيمة طلبات التحاليل</th>
        <th width="120">مجموع الطلبات</th>
        <th width="120">قيمة الطلبات</th>
    </tr><?
    $docData=[];
    $q=" and d_start>'$d_s' and d_start<'$d_e' ";
    $sql="select doc_ord,count(*)c , sum(t_total_pay)t from xry_x_visits where visit_link=0 and doc_ord!=0 $q group by doc_ord ";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows){
        while($r=mysql_f($res)){
            $doc=$r['doc_ord'];
            $count=$r['c'];
            $total=$r['t'];
            $docData[$doc]['xry_c']=$count;
            $docData[$doc]['xry_t']=$total;
        }
    }
    
    $sql="select doc_ord,count(*)c , sum(t_payments)t from lab_x_visits where visit_link=0 and doc_ord!=0 $q group by doc_ord ";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows){
        while($r=mysql_f($res)){
            $doc=$r['doc_ord'];
            $count=$r['c'];
            $total=$r['t'];
            $docData[$doc]['lab_c']=$count;
            $docData[$doc]['lab_t']=$total;
        }
    }
    
    foreach($docData as $k=>$doc){?>
        <tr>
            <td txt><?=get_val('gnr_m_doc_req','name',$k)?></td>			
            <td><ff class="clr8"><?=number_format($doc['xry_c'])?></ff14></td>
            <td><ff class="clr6"><?=number_format($doc['xry_t'])?></ff14></td>
            <td><ff class="clr8"><?=number_format($doc['lab_c'])?></ff14></td>
            <td><ff class="clr6"><?=number_format($doc['lab_t'])?></ff14></td>
            <td fot><ff class="clr8"><?=number_format($doc['xry_c']+$doc['lab_c'])?></ff14></td>
            <td fot><ff class="clr6"><?=number_format($doc['xry_t']+$doc['lab_t'])?></ff14></td>
        </tr><?
    }
    ?>
    </table><?
}
if($page==25){	
    if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;            
		$d_e=$d_s+(($monLen)*86400);
	}		
	if($tab==2){	
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
	}
    echo $breakC;
    echo repTitleShow();?>
    <table border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
    <tr>
        <th><?=k_dr?></th>			
        <th width="120">طلبات الأشعة</th>
        <th width="120">قيمة طلبات الأشعة</th>
        <th width="120">طلبات التحاليل</th>
        <th width="120">قيمة طلبات التحاليل</th>
        <th width="120">مجموع الطلبات</th>
        <th width="120">قيمة الطلبات</th>
    </tr><?
    $docData=[];
    $q=" and d_start>'$d_s' and d_start<'$d_e' ";
    $sql="select doc_ord,count(*)c , sum(t_total_pay)t from xry_x_visits where visit_link!=0 and doc_ord!=0 $q group by doc_ord ";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows){
        while($r=mysql_f($res)){
            $doc=$r['doc_ord'];
            $count=$r['c'];
            $total=$r['t'];
            $docData[$doc]['xry_c']=$count;
            $docData[$doc]['xry_t']=$total;
        }
    }
    
    $sql="select doc_ord,count(*)c , sum(t_payments)t from lab_x_visits where visit_link!=0 and doc_ord!=0 $q group by doc_ord ";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows){
        while($r=mysql_f($res)){
            $doc=$r['doc_ord'];
            $count=$r['c'];
            $total=$r['t'];
            $docData[$doc]['lab_c']=$count;
            $docData[$doc]['lab_t']=$total;
        }
    }
    
    foreach($docData as $k=>$doc){?>
        <tr>
            <td txt><?=get_val('_users','name_'.$lg,$k)?></td>			
            <td><ff class="clr8"><?=number_format($doc['xry_c'])?></ff14></td>
            <td><ff class="clr6"><?=number_format($doc['xry_t'])?></ff14></td>
            <td><ff class="clr8"><?=number_format($doc['lab_c'])?></ff14></td>
            <td><ff class="clr6"><?=number_format($doc['lab_t'])?></ff14></td>
            <td fot><ff class="clr8"><?=number_format($doc['xry_c']+$doc['lab_c'])?></ff14></td>
            <td fot><ff class="clr6"><?=number_format($doc['xry_t']+$doc['lab_t'])?></ff14></td>
        </tr><?
    }
    ?>
    </table><?
}
if($page==26){	
    if($tab==0){
		echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
		$d_s=$todyU;
		$d_e=$d_s+86400;
        echo $breakC;
        echo repTitleShow();
        foreach($clinicTypes as $k => $val){
            if(in_array($k,array(1,3,4,5,7))){
                $table=$srvXTables[$k];
                $sql="select * from $table where app=1 and status!=3 and d_start>=$d_s and d_start<$d_e";                
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows){?>
                    <div class="lh40 f1 fs18"><?=$val?></div>
                    <table border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
                        <tr>
                            <th width="180">التاريخ</th>			
                            <th width="80">الزيارة </th>
                            <th >العيادة </th>
                            <th >الطبيب</th>
                            <th >المريض</th>
                            <th >الخدمة</th>
                            <th width="120">القيمة قبل الحسم</th>
                            <th width="120">القيمة بعد الحسم</th>
                            <th width="120">الفرق</th>
                        </tr><?
                        while($r=mysql_f($res)){?>
                            <tr>
                                <td><ff14><?=date('Y-m-d Ah:i:s',$r['d_start'])?></ff14></td>
                                <td><ff14><?=number_format($r['visit_id'])?></ff14></td>
                                <td txt><?=get_val_arr('gnr_m_clinics','name_'.$lg,$r['clinic'],'c')?></ff14></td>
                                <td txt><?=get_val_arr('_users','name_'.$lg,$r['doc'],'d')?></td>
                                <td txt><?=get_p_name($r['patient'])?></td>
                                <td txt><?=get_val_arr($srvTables[$k],'name_'.$lg,$r['service'],'s');?></td>
                                <td><ff class="clr6"><?=number_format($r['total_pay'])?></ff></td>
                                <td><ff class="clr1"><?=number_format($r['pay_net'])?></ff></td>
                                <td><ff class="clr5"><?=number_format($r['total_pay']-$r['pay_net'])?></ff></td>  
                            </tr><?
                        }?>
                    </table><?
                }
            }
        }
	}else{
        if($tab==1){
            echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
            $d_s=$mm;            
            $d_e=$d_s+(($monLen)*86400);
        }		
        if($tab==2){	
            echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
            $d_s=strtotime($df);
            $d_e=strtotime($dt)+86400;
        }
        echo $breakC;
        echo repTitleShow();?>
        <table border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
        <tr>
            <th width="200">القسم</th>			
            <th width="120">عدد الخدمات</th>
            <th width="120">القيمة قبل الحسم</th>
            <th width="120">القيمة بعد الحسم</th>
            <th width="120">الفرق</th>
        </tr><?
        $t=[0,0,0];
        foreach($clinicTypes as $k => $val){
            if(in_array($k,array(1,3,4,5,7))){
                $no=getTotalCo($srvXTables[$k],"app=1 and status!=3 and d_start>=$d_s and d_start<$d_e");
                $total=get_sum($srvXTables[$k],'total_pay',"app=1 and d_start>=$d_s and d_start<$d_e");
                $net=get_sum($srvXTables[$k],'pay_net',"app=1 and d_start>=$d_s and d_start<$d_e");
                $def=$total-$net;
                $t[0]+=$no;
                $t[1]+=$total;
                $t[2]+=$net;?>
                <tr>
                    <td txt><?=$val?></td>			
                    <td><ff><?=number_format($no)?></ff14></td>
                    <td><ff class="clr6"><?=number_format($total)?></ff14></td>
                    <td><ff class="clr8"><?=number_format($net)?></ff14></td>
                    <td><ff class="clr5"><?=number_format($def)?></ff14></td>
                </tr><?
            }
        }?>
        <tr>
            <td txt><?=k_total?></td>			
            <td><ff><?=number_format($t[0])?></ff14></td>
            <td><ff class="clr6"><?=number_format($t[1])?></ff14></td>
            <td><ff class="clr8"><?=number_format($t[2])?></ff14></td>
            <td><ff class="clr5"><?=number_format($t[1]-$t[2])?></ff14></td>
        </tr>
        </table><?
    }
}
if($page==27){	
    if($tab==0){        
        echo repoNav($fil,1,$page,$tab,1,1,$page_mood);
        $d_s=$todyU;
        $d_e=$d_s+86400;        
    }
    if($tab==1){
        echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
        $d_s=$mm;            
        $d_e=$d_s+(($monLen)*86400);
    }		
    if($tab==2){	
        echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
        $d_s=strtotime($df);
        $d_e=strtotime($dt)+86400;
    }
    echo $breakC;
    echo repTitleShow();
    $q='';
    if($val){$q=" and doc='$val' ";}
    $nurss=get_arr('gnr_m_nurses','id','name');
    $sql="select nurs,count(*)c , AVG(rate)a from gnr_x_nurses_rate where date >= $d_s and date < $d_e $q group by nurs";
    $res=mysql_q($sql);
    $rows=mysql_n($res);        
    
    if($rows){
        if($val){?>
            <div class="lh40 f1 fs18">الدكتور: <?=get_val('_users','name_'.$lg,$val)?></div><? 
        }?>
        <table border="0" class="grad_s holdH" cellspacing="0" cellpadding="4">
            <tr>
                <th width="180">الممرض</th>			
                <th width="80">عدد التقيمات </th>
                <th>متوسط التقيم </th>                
            </tr><?
            while($r=mysql_f($res)){?>
                <tr>
                    <td txt><?=$nurss[$r['nurs']]?></td>
                    <td><ff class="clr1"><?=number_format($r['c'])?></ff></td>
                    <td><ff class="clr5"><?=number_format($r['a'],2)?></ff></td>                     
                </tr><?
            }?>
        </table><?
    }
}

if($page==30){
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;
		$d_e=$d_s+(($monLen)*86400);
		echo $breakC;//^
	    echo repTitleShow();
		/*******************/
		$monData=presc_data_statistical_reports($d_s,$d_e);
		if($monData){
		?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>					
					<th width="80"><?=k_tday?></th>
					<th>إجمالي الأدوية الموصوفة</th>
					<th>الأدوية المصروفة</th>
					<th>الأدوية غير المصروفة</th>
					<th>الأدوية غير المتوفرة</th>
					<th>نسبة الأدوية المصروفة </th>
					<th>نسبة الأدوية غير المصروفة </th>
					<th>نسبة الأدوية غير المتوفرة </th>
					<!--th>سعر الأدوية المصروفة</th>
					<th>سعر الأدوية غير المصروفة</th-->
				</tr>

				<?
				for($ss=0;$ss<$monLen;$ss++){
					$d_s=$mm+($ss*86400);
					$d_e=$d_s+86400;
					//-----------
					$dayData=presc_data_statistical_reports($d_s,$d_e);
					if($dayData){?>
						<tr>
							<td>
								<div class="ff fs18 B"><?=($ss+1)?></div>
							</td>				
							<td><ff class="clr1"><?=number_format($dayData['presc_co'])?></ff></td>
							<td>
								<ff class="clr6">
									<?=number_format($dayData['ex_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr77">
									<?=number_format($dayData['notEx_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr5">
									<?=number_format($dayData['notExist_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr6">
								<?=($t=$dayData['ex_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>
								<ff class="clr77">
									<?=($t=$dayData['notEx_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>
								<ff class="clr5">
									<?=($t=$dayData['notExist_per'])?$t.'%':'-';?>
								</ff>
							</td>
						</tr>

					<?
					}
				}
				?>
				<tr fot>
					<td txt>المجاميع</td>				
					<td>
						<ff class="clr1">
							<?=number_format($monData['presc_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
							<?=number_format($monData['ex_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=number_format($monData['notEx_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=number_format($monData['notExist_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
						<?=($t=$monData['ex_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=($t=$monData['notEx_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$monData['notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<!--td><ff class=""></ff></td>
					<td><ff class=""></ff></td>
					<td><ff class=""></ff></td-->

				</tr>


			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ</div>';
		}		
	}
	elseif($tab==2){		
		echo repoNav($fil,3,$page,$tab,1,1,$page_mood);		
		$d_s=strtotime($selYear.'-01-01');			 
        $d_e=strtotime($selYear.'-12-31');
		echo $breakC;//^
	    echo repTitleShow();
		/*********************/
		$yearData=presc_data_statistical_reports($d_s,$d_e);
		if($yearData){?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80">الشهر</th>
					<th>إجمالي الأدوية الموصوفة</th>
					<th>الأدوية المصروفة</th>
					<th>الأدوية غير المصروفة</th>
					<th>الأدوية غير المتوفرة</th>
					<th>نسبة الأدوية المصروفة </th>
					<th>نسبة الأدوية غير المصروفة </th>
					<th>نسبة الأدوية غير المتوفرة </th>
				</tr>

				<?
				for($ss=1;$ss<=12;$ss++){
					$m_s=strtotime($selYear.'-'.$ss.'-1');
					$monLen=date('t',$m_s);
					$m_e=$m_s+($monLen*86400);
					//-----------
					$monData=presc_data_statistical_reports($m_s,$m_e);
					if($monData){?>
						<tr>
							<td>
								<div class="f1 fs12 txt_Over" onclick="loadReport(<?=$page?>,1,'<?=$year.'-'.$ss?>')"><?=$monthsNames[$ss]?></div>
							</td>				
							<td>
								<ff class="clr1">
									<?=number_format($monData['presc_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr6">
									<?=number_format($monData['ex_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr77">
									<?=number_format($monData['notEx_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr5">
									<?=number_format($monData['notExist_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr6">
								<?=($t=$monData['ex_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>
								<ff class="clr77">
									<?=($t=$monData['notEx_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>

								<ff class="clr5">
									<?=($t=$monData['notExist_per'])?$t.'%':'-';?>
								</ff>
							</td>
						</tr>

					<?
					}
				}
				?>
				<tr fot>
					<td txt>المجاميع</td>				
					<td>
						<ff class="clr1">
							<?=number_format($yearData['presc_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
							<?=number_format($yearData['ex_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=number_format($yearData['notEx_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=number_format($yearData['notExist_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
						<?=($t=$yearData['ex_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=($t=$yearData['notEx_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$yearData['notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
				</tr>


			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ..</div>';
		}
	}
	elseif($tab==3){
		echo repoNav($fil,0,$page,$tab,1,1,$page_mood);				
		echo $breakC;//^
	    echo repTitleShow();
		/*******************/
		$minDate=date('Y',$totData['min_d']);
		$maxDate=date('Y',$totData['max_d']);
		$totData=presc_data_statistical_reports($minDate,$maxDate);
		
		if($totData){
			?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80">السنة</th>
					<th>إجمالي الأدوية الموصوفة</th>
					<th>الأدوية المصروفة</th>
					<th>الأدوية غير المصروفة</th>
					<th>الأدوية غير المتوفرة</th>
					<th>نسبة الأدوية المصروفة </th>
					<th>نسبة الأدوية غير المصروفة </th>
					<th>نسبة الأدوية غير المتوفرة </th>
					<!--th>سعر الأدوية المصروفة</th>
					<th>سعر الأدوية غير المصروفة</th-->
				</tr>
				<?
				for($ss=$minDate;$ss<=$maxDate;$ss++){
					$y_s=strtotime($ss.'-1-1');
					$y_e=strtotime($ss.'-12-31');
					//-----------
					$yearData=presc_data_statistical_reports($y_s,$y_e);
					if($yearData){?>
						<tr>
							<td>
								<div class="ff fs18 B txt_Over" onclick="loadReport(<?=$page?>,2,'<?=$ss.'-1'?>')"><?=($ss)?></div>
							</td>				
							<td>
								<ff class="clr1">
									<?=number_format($yearData['presc_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr6">
									<?=number_format($yearData['ex_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr77">
									<?=number_format($yearData['notEx_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr5">
									<?=number_format($yearData['notExist_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr6">
								<?=($t=$yearData['ex_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>
								<ff class="clr77">
									<?=($t=$yearData['notEx_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>
								<ff class="clr5">
									<?=($t=$yearData['notExist_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<!--td><ff class=""></ff></td>
							<td><ff class=""></ff></td>
							<td><ff class=""></ff></td-->

						</tr>

					<?
					}
				}
				?>
				<tr fot>
					<td txt>المجاميع</td>				

					<td><ff class="clr1"><?=$totData['presc_co']?></ff></td>
					<td><ff class="clr6"><?=$totData['ex_co']?></ff></td>
					<td>
						<ff class="clr77"><?=$totData['notEx_co']?></ff>
					</td>
					<td><ff class="clr5"><?=$totData['notExist_co']?></ff></td>
					<td>
						<ff class="clr6">
						<?=($t=$totData['ex_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=($t=$yearData['notEx_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$yearData['notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<!--td><ff class=""></ff></td>
					<td><ff class=""></ff></td>
					<td><ff class=""></ff></td-->

				</tr>


			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ</div>';
		}
	}
	elseif($tab==4){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		echo $breakC;//^
	    echo repTitleShow();
		$monData=presc_data_statistical_reports(strtotime($df),strtotime($dt)+1);
		if($monData){
			?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80"><?=k_tday?></th>
					<th>إجمالي الأدوية الموصوفة</th>
					<th>الأدوية المصروفة</th>
					<th>الأدوية غير المصروفة</th>
					<th>الأدوية غير المتوفرة</th>
					<th>نسبة الأدوية المصروفة </th>
					<th>نسبة الأدوية غير المصروفة </th>
					<th>نسبة الأدوية غير المتوفرة </th>
				</tr>

				<?
				$a=strtotime($df);
				$b=strtotime($dt);
				for($ss=$a;$ss<=$b;$ss+=86400){
					$d_s=$ss;
					$d_e=$d_s+86400;
					//-----------
					$dayData=presc_data_statistical_reports($d_s,$d_e);
					if($dayData){?>
						<tr>
							<td>
								<div class="ff fs18 B"><?=date('Y-m-d',$ss);?></div>
							</td>				
							<td>
								<ff class="clr1">
									<?=number_format($dayData['presc_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr6">
									<?=number_format($dayData['ex_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr77">
									<?=number_format($dayData['notEx_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr5">
									<?=number_format($dayData['notExist_co'])?>
								</ff>
							</td>
							<td>
								<ff class="clr6">
								<?=($t=$dayData['ex_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>
								<ff class="clr77">
									<?=($t=$dayData['notEx_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>
								<ff class="clr5">
									<?=($t=$dayData['notExist_per'])?$t.'%':'-';?>
								</ff>
							</td>
						</tr>
					<?
					}
				}
				?>
				<tr fot>
					<td txt>المجاميع</td>				
					<td>
						<ff class="clr1">
							<?=number_format($monData['presc_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
							<?=number_format($monData['ex_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=number_format($monData['notEx_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=number_format($monData['notExist_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
						<?=($t=$monData['ex_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=($t=$monData['notEx_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$monData['notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
				</tr>


			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ</div>';
		}
	}
		
	


}
if($page==31){
	if($tab==2){		
		echo repoNav($fil,3,$page,$tab,1,1,$page_mood);		
		$d_s=strtotime($selYear.'-01-01');			 
        $d_e=strtotime($selYear.'-12-31');
		echo $breakC;//^
	    echo repTitleShow();
		/*********************/
		$yearData=presc_data_season_reports($d_s,$d_e);
		$yearData_sum=$yearData[1];
		$yearData_day=$yearData[0];
		if(!empty($yearData)){?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" over="0">
				<tr>
					<th></th>
					<?
					$st='style="border-left:1px #aaa solid;"';
					for($i=1;$i<=12;$i++){
						if($i==12){$st='';}?>
						<th width="8%" <?=$st?> colspan="2"><?=$monthsNames[$i]?></th>
					<?
					}
					?>

				</tr>
				<tr style="border-bottom:1px #bbb solid;">
					<td class="f1 fs14"><?=k_tday?></td>
					<?
					$st1='';
					$st='style="border-left:1px #aaa solid;"';
					for($i=1;$i<=12;$i++){
						if($i==12){$st='';}?>
						<td class="cbg44">
							<span class="clr1111">الأدوية الموصوفة</span>
						</td>
						<td class="cbg555" <?=$st?>>
							<span class="clr55">غير المتوفرة</span>
						</td><?
					}?>
				</tr>
				<?
				foreach($yearData_day as $day=>$dayRow){
					//echo "day:$day-->";print_r($dayRow);echo "<br>";
					?>
					<tr rep>
						<td>
							<div class="ff fs18 B"><?=$day?></div>
						</td><?
						$st='style="border-left:1px #aaa solid;"';	
						for($mon=1;$mon<=12;$mon++){
							if($mon==12){$st='';}
							if(isset($dayRow[$mon])){
								$monView=$dayRow[$mon];
								$presc_d=$monView[0];
								$notExist_d=$monView[1];?>
								<td class="cbg44_">
									<ff class="clr1"><?=$presc_d?></ff>
								</td>
								<td <?=$st?> class="cbg555_">
									<ff class="clr5"><?=$notExist_d?></ff>
								</td><?
							}
							else{?>
								<td class="cbg44_">-</td>
								<td <?=$st?> class="cbg555_">-</td><?
							}
						 }?>
					</tr><?
				}?>
					<tr rep>
						<td>
							<div class="f1 fs14">المجاميع</div>
						</td><?
						 $st='style="border-left:1px #aaa solid;"';
						 for($mon=1;$mon<=12;$mon++){
							if($mon==12){$st='';}
							if(isset($yearData_sum[$mon])){
								//$monView=$dayRow[$mon]['sum'];
								$presc_d=$yearData_sum[$mon][0];
								$notExist_d=$yearData_sum[$mon][1];?>
								<td class="cbg44_">
									<ff class="clr1"><?=$presc_d?></ff>
								</td>
								<td <?=$st?> class="cbg555_">
									<ff class="clr5"><?=$notExist_d?></ff>
								</td><?
							}
							else{?>
								<td class="cbg44_">-</td>
								<td <?=$st?> class="cbg555_">-</td><?
							}
						 }?>
					</tr><?
				?>
			</table><?	
		}else{
			echo '<div class="fs16 f1 pd10 clr5">لا يوجد بيانات في هذا التاريخ..</div>';
		}
	
	}
}
if($page==32){
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;
		$d_e=$d_s+(($monLen)*86400);
		echo $breakC;//^
	    echo repTitleShow();
		/*******************/
		$monData=presc_data_financial_reports($d_s,$d_e);
		if($monData){?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80"><?=k_tday?></th>
					<th>سعر الأدوية الموصوفة</th>
					<th>العائد من الصرف</th>
					<th>سعر غير المتوفر</th>
					<th>نسبة العائد</th>
					<th>نسبة الخسارة من غير المتوفر</th>
					<th>نسبة الخسارة من غير المصروف </th>
				</tr>
				<?
				for($ss=0;$ss<$monLen;$ss++){
					$d_s=$mm+($ss*86400);
					$d_e=$d_s+86400;
					//-----------
					$dayData=presc_data_financial_reports($d_s,$d_e);
					if($dayData){?>
						<tr>
							<td>
								<div class="ff fs18 B"><?=($ss+1)?></div>
							</td>				
							<td>
								<ff class="clr1">
									<?=number_format($dayData['presc_price'])?>
								</ff>
							</td>
							<td>
								<ff class="clr6">
									<?=number_format($dayData['ex_price'])?>
								</ff>
							</td>
							<td>
								<ff class="clr5">
									<?=number_format($dayData['notExist_price'])?>
								</ff>
							</td>
							<td>
								<ff class="clr6">
									<?=($t=$dayData['profit_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>
								<ff class="clr5">
								<?=($t=$dayData['loss_notExist_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>
								<ff class="clr77">
								<?=($t=$dayData['loss_notEx_per'])?$t.'%':'-';?>
								</ff>
							</td>
						</tr>
					<?
					}
				}
				?>
				<tr fot>
					<td txt>المجاميع</td>				
					<td>
						<ff class="clr1">
							<?=number_format($monData['presc_price'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
							<?=number_format($monData['ex_price'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=number_format($monData['notExist_price'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
						<?=($t=$monData['profit_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$monData['loss_notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=($t=$monData['loss_notEx_per'])?$t.'%':'-';?>
						</ff>
					</td>

				</tr>


			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ</div>';
		}
	}
	elseif($tab==2){		
		echo repoNav($fil,3,$page,$tab,1,1,$page_mood);		
		$d_s=strtotime($selYear.'-01-01');			 
        $d_e=strtotime($selYear.'-12-31');
		echo $breakC;//^
	    echo repTitleShow();
		/*********************/
		$yearData=presc_data_financial_reports($d_s,$d_e);
		if($yearData){
			?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80">الشهر</th>
					<th>سعر الأدوية الموصوفة</th>
					<th>العائد من الصرف</th>
					<th>سعر غير المتوفر</th>
					<th>نسبة العائد</th>
					<th>نسبة الخسارة من غير المتوفر</th>
					<th>نسبة الخسارة من غير المصروف </th>
				</tr>
				<?
				for($ss=1;$ss<=12;$ss++){
					$m_s=strtotime($selYear.'-'.$ss.'-1');
					$monLen=date('t',$m_s);
					$m_e=$m_s+($monLen*86400);
					//-----------
					$monData=presc_data_financial_reports($m_s,$m_e);
					if($monData){?>
						<tr>
							<td>
								<div class="f1 fs12 txt_Over" onclick="loadReport(<?=$page?>,1,'<?=$year.'-'.$ss?>')"><?=$monthsNames[$ss]?></div>
							</td>				
							<td>
								<ff class="clr1">
									<?=number_format($monData['presc_price'])?>
								</ff>
							</td>
							<td>
								<ff class="clr6">
									<?=number_format($monData['ex_price'])?>
								</ff>
							</td>
							<td>
								<ff class="clr5">
									<?=number_format($monData['notExist_price'])?>
								</ff>
							</td>
							<!--td>
								<ff class="clr77"><?=$monData['notEx_price']?></ff>
							</td-->
							<td>
								<ff class="clr6">
									<?=($t=$monData['profit_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>
								<ff class="clr5">
									<?=($t=$monData['loss_notExist_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>
								<ff class="clr77">
								<?=($t=$monData['loss_notEx_per'])?$t.'%':'-';?>
								</ff>
							</td>
						</tr>

					<?
					}
				}
				?>
				<tr fot>
					<td txt>المجاميع</td>				
					<td><ff class="clr1"><?=$yearData['presc_price']?></ff></td>
					<td><ff class="clr6"><?=$yearData['ex_price']?></ff></td>
					<td>
						<ff class="clr5"><?=$yearData['notExist_price']?></ff>
					</td>
					<!--td><ff class="clr77"><?=$yearData['notEx_price']?></ff--></td>
					<td>
						<ff class="clr6">
						<?=($t=$yearData['profit_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$yearData['loss_notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=($t=$yearData['loss_notEx_per'])?$t.'%':'-';?>
						</ff>
					</td>

				</tr>


			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ..</div>';
		}
		
	}
	elseif($tab==3){
		echo repoNav($fil,0,$page,$tab,1,1,$page_mood);				
		echo $breakC;//^
	    echo repTitleShow();
		/*******************/		
		$minDate=date('Y',$totData['min_d']);
		$maxDate=date('Y',$totData['max_d']);
		$totData=presc_data_financial_reports($minDate,$maxDate);
		if($totData){
		?>
		<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
			<tr>
				<th width="80">السنة</th>
				<th>سعر الأدوية الموصوفة</th>
				<th>العائد من الصرف</th>
				<th>سعر غير المتوفر</th>
				<!--th>سعر غير المصروف</th-->
				<th>نسبة العائد</th>
				<th>نسبة الخسارة من غير المتوفر</th>
				<th>نسبة الخسارة من غير المصروف </th>
			</tr>
			<?
			for($ss=$minDate;$ss<=$maxDate;$ss++){
				$y_s=strtotime($ss.'-1-1');
				$y_e=strtotime($ss.'-12-31');
				//-----------
				$yearData=presc_data_financial_reports($y_s,$y_e);
				if($yearData){?>
					<tr>
						<td>
							<div class="ff fs18 B txt_Over" onclick="loadReport(<?=$page?>,2,'<?=$ss.'-1'?>')"><?=($ss)?></div>
						</td>				
						<td>
							<ff class="clr1">
								<?=number_format($yearData['presc_price'])?></ff>
						</td>
						<td>
							<ff class="clr6">
								<?=number_format($yearData['ex_price'])?>
							</ff>
						</td>
						<td>
							<ff class="clr5">
								<?=number_format($yearData['notExist_price'])?>
							</ff>
						</td>
						<!--td>
							<ff class="clr77"><?=$yearData['notEx_price']?></ff>
						</td-->
						<td>
							<ff class="clr6">
								<?=($t=$yearData['profit_per'])?$t.'%':'-';?>
							</ff>
						</td>
						<td>
							<ff class="clr5">
								<?=($t=$yearData['loss_notExist_per'])?$t.'%':'-';?>
							</ff>
						</td>
						<td>
							<ff class="clr77">
							<?=($t=$yearData['loss_notEx_per'])?$t.'%':'-';?>
							</ff>
						</td>
					</tr>

				<?
				}
			}
			?>
			<tr fot>
					<td txt>المجاميع</td>				
					<td>
						<ff class="clr1">
							<?=number_format($totData['presc_price'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
							<?=number_format($totData['ex_price'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=number_format($totData['notExist_price'])?>
						</ff>
					</td>
					<!--td><ff class="clr77"><?=$totData['notEx_price']?></ff--></td>
					<td>
						<ff class="clr6">
						<?=($t=$totData['profit_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$totData['loss_notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=($t=$totData['loss_notEx_per'])?$t.'%':'-';?>
						</ff>
					</td>

				</tr>

		</table>
		<?
	}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ</div>';
		}
	}
	elseif($tab==4){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		echo $breakC;//^
	    echo repTitleShow();
		/*******************/
		$monData=presc_data_financial_reports($d_s,$d_e);
		if($monData){
			?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80"><?=k_tday?></th>
					<th>سعر الأدوية الموصوفة</th>
					<th>العائد من الصرف</th>
					<th>سعر غير المتوفر</th>
					<!--th>سعر غير المصروف</th-->
					<th>نسبة العائد</th>
					<th>نسبة الخسارة من غير المتوفر</th>
					<th>نسبة الخسارة من غير المصروف </th>
				</tr>

				<?
				$a=strtotime($df);
				$b=strtotime($dt);
				for($ss=$a;$ss<=$b;$ss+=86400){
					$d_s=$ss;
					$d_e=$d_s+86400;
					//-----------
					$dayData=presc_data_financial_reports($d_s,$d_e);
					if($dayData){?>
						<tr>
							<td>
								<div class="ff fs18 B"><?=date('Y-m-d',$ss);?></div>
							</td>				
							<td>
								<ff class="clr1">
									<?=number_format($dayData['presc_price'])?>
								</ff>
							</td>
							<td>
								<ff class="clr6">
									<?=number_format($dayData['ex_price'])?>
								</ff>
							</td>
							<td>
								<ff class="clr5">
									<?=number_format($dayData['notExist_price'])?>
								</ff>
							</td>
							<!--td>
								<ff class="clr77"><?=$dayData['notEx_price']?></ff>
							</td-->
							<td>
								<ff class="clr6">
									<?=($t=$dayData['profit_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>
								<ff class="clr5">
								<?=($t=$dayData['loss_notExist_per'])?$t.'%':'-';?>
								</ff>
							</td>
							<td>
								<ff class="clr77">
								<?=($t=$dayData['loss_notEx_per'])?$t.'%':'-';?>
								</ff>
							</td>

						</tr>
					<?
					}
				}
				?>
				<tr fot>
					<td txt>المجاميع</td>				
					<td>
						<ff class="clr1">
						<?=number_format($monData['presc_price'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
							<?=number_format($monData['ex_price'])?>
						</ff></td>
					<td>
						<ff class="clr5">
							<?=number_format($monData['notExist_price'])?>
						</ff>
					</td>
					<!--td><ff class="clr77"><?=$monData['notEx_price']?></ff--></td>
					<td>
						<ff class="clr6">
						<?=($t=$monData['profit_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$monData['loss_notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=($t=$monData['loss_notEx_per'])?$t.'%':'-';?>
						</ff>
					</td>

				</tr>


			</table>
			<?}
		else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ</div>';
		}
	}
		
	


}
if($page==33){	
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;
		$d_e=$d_s+(($monLen)*86400);
		echo $breakC;//^
	    echo repTitleShow();
		/*******************/
		$monData=presc_data_notExistDrugs_reports($d_s,$d_e,1);
		if($monData){
			?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80"><?=k_tday?></th>
					<th>الدواء</th>
					<th>الكمية الموصوفة</th>
					<th>الكمية غير المتوفرة</th>
					<th>نسبة غير المتوفرة </th>
					<th>البدائل</th>
				</tr>
				<?
				for($ss=0;$ss<$monLen;$ss++){
					$d_s=$mm+($ss*86400);
					$d_e=$d_s+86400;
					//-----------
					if($cbg_glob && $cbg_glob=='cbg777'){$cbg_glob='cbg444';}
					else{$cbg_glob='cbg777';}
					$dayDrugData=presc_data_notExistDrugs_reports($d_s,$d_e);
					if($dayDrugData){
						$i=0;$row_s=count($dayDrugData);  $st='';
						foreach($dayDrugData as $drug=>$dayData){
							$i++; $v='';$st2='';
							if($i==1){$v=($ss+1);}
							if($i==$row_s){
								$st='style="border-bottom:2px #ddd solid;"';
							}
							else{
								$st2='style="border-bottom:1px white solid;"';
							}
							$drug_name=get_val('cln_m_medicines','name_'.$lg,$drug);
						?>
							<tr class="<?=$cbg_glob2?>" <?=$st?>>
								<td <?=$st2?>>
									<div class="ff fs18 B"><?=$v?></div>
								</td>
								<td txt><?=SplitNo($drug_name)?></td>
								<td>
									<ff class="clr1">
										<?=number_format($dayData['presc_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=number_format($dayData['notExist_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=($t=$dayData['notExist_per'])?$t.'%':'-';?>
									</ff>
								</td>
								<td>
									<?=presc_get_altrs_view($dayData['altrs'])?>
								</td>
							</tr>

					<?
						}
					}
				}
				?>
				<tr fot>
					<td txt>المجاميع</td>	
					<td></td>
					<td>
						<ff class="clr1">
							<?=number_format($monData['presc_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=number_format($monData['notExist_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$monData['notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td></td>

				</tr>


			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ</div>';
		}
	}
	elseif($tab==2){
		echo repoNav($fil,3,$page,$tab,1,1,$page_mood);		
		$d_s=strtotime($selYear.'-01-01');			 
        $d_e=strtotime($selYear.'-12-31');
		echo $breakC;//^
	    echo repTitleShow();
		/*********************/
		$yearData=presc_data_notExistDrugs_reports($d_s,$d_e,1);
		if($yearData){
			?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80">الشهر</th>
					<th>الدواء</th>
					<th>الكمية الموصوفة</th>
					<th>الكمية غير المتوفرة</th>
					<th>نسبة غير المتوفرة </th>
					<th>البدائل</th>
				</tr>
				<?
				for($ss=1;$ss<=12;$ss++){
					$m_s=strtotime($selYear.'-'.$ss.'-1');
					$monLen=date('t',$m_s);
					$m_e=$m_s+($monLen*86400);
					//-----------
					$monDrugData=presc_data_notExistDrugs_reports($m_s,$m_e);
					if($monDrugData){
						$i=0;$row_s=count($monDrugData);  $st=$st2='';
						foreach($monDrugData as $drug=>$monData){
							$i++; $v='';$st2='';
							if($i==1){$v=$monthsNames[$ss];}
							if($i==$row_s){
								$st='style="border-bottom:2px #ddd solid;"';
							}
							else{
								$st2='style="border-bottom:1px white solid;"';
							}
							$drug_name=get_val('cln_m_medicines','name_'.$lg,$drug);?>
							<tr class="<?=$cbg_glob2?>" <?=$st?>>
								<td <?=$st2?>>
									<div class=" f1 fs12"><?=$v?></div>
								</td>
								<td txt><?=SplitNo($drug_name)?></td>
								<td>
									<ff class="clr1">
										<?=number_format($monData['presc_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=number_format($monData['notExist_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=($t=$monData['notExist_per'])?$t.'%':'-';?>
									</ff>
								</td>
								<td>
									<?=presc_get_altrs_view($monData['altrs'])?>
								</td>
							</tr>

					<?
						}
					}
				}
				?>
				<tr fot>
					<td txt>المجاميع</td>	
					<td></td>
					<td>
						<ff class="clr1">
							<?=number_format($yearData['presc_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=number_format($yearData['notExist_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$yearData['notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td></td>

				</tr>


			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ..</div>';
		}
	}
	elseif($tab==3){
		echo repoNav($fil,0,$page,$tab,1,1,$page_mood);				
		echo $breakC;//^
	    echo repTitleShow();
		/*******************/
		$totData=presc_data_notExistDrugs_reports(0,0,1);
		$minDate=date('Y',$totData['min_d']);
		$maxDate=date('Y',$totData['max_d']);
		if($totData){
			?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80">السنة</th>
					<th>الدواء</th>
					<th>الكمية الموصوفة</th>
					<th>الكمية غير المتوفرة</th>
					<th>نسبة غير المتوفرة </th>
					<th>البدائل</th>
				</tr>
				<?
				for($ss=$minDate;$ss<=$maxDate;$ss++){
					$y_s=strtotime($ss.'-1-1');
					$y_e=strtotime($ss.'-12-31');
					//-----------
					$yearDrugData=presc_data_notExistDrugs_reports($y_s,$y_e);
					if($yearDrugData){
						$i=0;$row_s=count($yearDrugData);  $st=$st2='';
						foreach($yearDrugData as $drug=>$yearData){
							$i++; $v='';$st2='';
							if($i==1){$v=($ss);}
							if($i==$row_s){
								$st='style="border-bottom:2px #ddd solid;"';
							}
							else{
								$st2='style="border-bottom:1px white solid;"';
							}
							$drug_name=get_val('cln_m_medicines','name_'.$lg,$drug);?>
							<tr class="<?=$cbg_glob2?>" <?=$st?>>
								<td <?=$st2?>>
									<div class="ff fs18 B"><?=$v?></div>
								</td>
								<td txt><?=SplitNo($drug_name)?></td>
								<td>
									<ff class="clr1">
										<?=number_format($yearData['presc_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=number_format($yearData['notExist_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=($t=$yearData['notExist_per'])?$t.'%':'-';?>
									</ff>
								</td>
								<td>
									<?=presc_get_altrs_view($yearData['altrs'])?>
								</td>
							</tr>

					<?
						}
					}
				}
				?>
					<tr fot>
					<td txt>المجاميع</td>	
					<td></td>
					<td><ff class="clr1"><?=$totData['presc_co']?></ff></td>
					<td><ff class="clr5"><?=$totData['notExist_co']?></ff></td>
					<td>
						<ff class="clr5">
							<?=($t=$totData['notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td></td>

				</tr>


			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ</div>';
		}
	}
	elseif($tab==4){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		echo $breakC;//^
	    echo repTitleShow();
		/*******************/
		$monData=presc_data_notExistDrugs_reports($d_s,$d_e,1);
		if($monData){
			?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80"><?=k_tday?></th>
					<th>الدواء</th>
					<th>الكمية الموصوفة</th>
					<th>الكمية غير المتوفرة</th>
					<th>نسبة غير المتوفرة </th>
					<th>البدائل</th>
				</tr>
				<?
				$a=strtotime($df);
				$b=strtotime($dt);
				for($ss=$a;$ss<=$b;$ss+=86400){
					$d_s=$ss;
					$d_e=$d_s+86400;
					//-----------
					$monDrugData=presc_data_notExistDrugs_reports($d_s,$d_e);
					if($monDrugData){
						$i=0;$row_s=count($monDrugData);  $st=$st2='';
						foreach($monDrugData as $drug=>$dayData){
							$i++; $v='';$st2='';
							if($i==1){$v=date('Y-m-d',$ss);}
							if($i==$row_s){
								$st='style="border-bottom:2px #ddd solid;"';
							}
							else{
								$st2='style="border-bottom:1px white solid;"';
							}
							$drug_name=get_val('cln_m_medicines','name_'.$lg,$drug);?>
							<tr class="<?=$cbg_glob2?>" <?=$st?>>
								<td <?=$st2?>>
									<div class="ff fs18 B"><?=$v?></div>
								</td>
								<td txt><?=SplitNo($drug_name)?></td>
								<td>
									<ff class="clr1">
										<?=number_format($dayData['presc_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=number_format($dayData['notExist_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=($t=$dayData['notExist_per'])?$t.'%':'-';?>
									</ff>
								</td>
								<td>
									<?=presc_get_altrs_view($dayData['altrs'])?>
								</td>
							</tr>
					<?
						}
					}
				}
				?>
					<tr fot>
					<td txt>المجاميع</td>	
					<td></td>
					<td>
						<ff class="clr1">
							<?=number_format($monData['presc_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=number_format($monData['notExist_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$monData['notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td></td>

				</tr>
			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ</div>';
		}
	}
}
if($page==34){	
	if($tab==1){
		echo repoNav($fil,2,$page,$tab,1,1,$page_mood);
		$d_s=$mm;
		$d_e=$d_s+(($monLen)*86400);
		echo $breakC;//^
	    echo repTitleShow();
		/*******************/
		$monData=presc_data_statistical_reports($d_s,$d_e);
		if($monData){
			?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80"><?=k_tday?></th>
					<th>الدواء</th>
					<th>الكمية الموصوفة</th>
					<th>الكمية المصروفة</th>
					<th>الكمية غير المتوفرة</th>
					<th>نسبة الصرف </th>
					<th>نسبة غير المصروف </th>
					<th>نسبة غير المتوفرة </th>
				</tr>
				<?
				for($ss=0;$ss<$monLen;$ss++){
					$d_s=$mm+($ss*86400);
					$d_e=$d_s+86400;
					//-----------
					if($cbg_glob && $cbg_glob=='cbg777'){$cbg_glob='cbg444';}else{$cbg_glob='cbg777';}
					$dayDrugData=presc_data_drugs_reports($d_s,$d_e);
					if($dayDrugData){
						$i=0;$row_s=count($dayDrugData);  $st='';
						foreach($dayDrugData as $drug=>$dayData){
							$i++; $v='';$st2='';
							if($i==1){$v=($ss+1);}
							else{
								$st2='style="border-top:1px white solid;"';
							}
							if($i==$row_s){$st='style="border-bottom:2px #aaa solid;"';}
							$drug_name=get_val('cln_m_medicines','name_'.$lg,$drug);
						?>
							<tr class="<?=$cbg_glob2?>" <?=$st?></t>
								<td <?=$st2?>>
									<div class="ff fs18 B"><?=$v?></div>
								</td>
								<td txt><?=SplitNo($drug_name)?></td>
								<td>
									<ff class="clr1"><?=number_format($dayData['presc_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr6">
										<?=number_format($dayData['ex_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=number_format($dayData['notExist_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr6">
									<?=($t=$dayData['ex_per'])?$t.'%':'-';?>
									</ff>
								</td>
								<td>
									<ff class="clr77">
										<?=($t=$dayData['notEx_per'])?$t.'%':'-';?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=($t=$dayData['notExist_per'])?$t.'%':'-';?>
									</ff>
								</td>
							</tr>

					<?
						}
					}
				}
				?>
				<tr fot>
					<td txt>المجاميع</td>	
					<td></td>
					<td>
						<ff class="clr1">
							<?=number_format($monData['presc_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
							<?=number_format($monData['ex_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5"><?=number_format($monData['notExist_co'])?></ff>
					</td>
					<td>
						<ff class="clr6">
						<?=($t=$monData['ex_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=($t=$monData['notEx_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$monData['notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
				</tr>


			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ</div>';
		}
	}
	elseif($tab==2){
		echo repoNav($fil,3,$page,$tab,1,1,$page_mood);		
		$d_s=strtotime($selYear.'-01-01');			 
        $d_e=strtotime($selYear.'-12-31');
		echo $breakC;//^
	    echo repTitleShow();
		/*********************/
		$yearData=presc_data_statistical_reports($d_s,$d_e);
		if($yearData){
			?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80">الشهر</th>
					<th>الدواء</th>
					<th>الكمية الموصوفة</th>
					<th>الكمية المصروفة</th>
					<th>الكمية غير المتوفرة</th>
					<th>نسبة الصرف </th>
					<th>نسبة غير المصروف </th>
					<th>نسبة غير المتوفرة </th>
				</tr>
				<?
				for($ss=1;$ss<=12;$ss++){
					$m_s=strtotime($selYear.'-'.$ss.'-1');
					$monLen=date('t',$m_s);
					$m_e=$m_s+($monLen*86400);
					//-----------
					$monDrugData=presc_data_drugs_reports($m_s,$m_e);
					if($monDrugData){
						$i=0;$row_s=count($monDrugData);  $st=$st2='';
						foreach($monDrugData as $drug=>$monData){
							$i++; $v='';$st2='';
							if($i==1){$v=$monthsNames[$ss];}
							if($i==$row_s){
								$st='style="border-bottom:2px #ddd solid;"';
							}
							else{
								$st2='style="border-bottom:1px white solid;"';
							}
							$drug_name=get_val('cln_m_medicines','name_'.$lg,$drug);?>
							<tr <?=$st?>>
								<td <?=$st2?>>
									<div class="f1 fs12 txt_Over" onclick="loadReport(<?=$page?>,1,'<?=$year.'-'.$ss?>')"><?=$v?></div>
								</td>
								<td txt><?=SplitNo($drug_name)?></td>
								<td>
									<ff class="clr1">
										<?=number_format($monData['presc_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr6">
										<?=number_format($monData['ex_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=number_format($monData['notExist_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr6">
									<?=($t=$monData['ex_per'])?$t.'%':'-';?>
									</ff>
								</td>
								<td>
									<ff class="clr77">
										<?=($t=$monData['notEx_per'])?$t.'%':'-';?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=($t=$monData['notExist_per'])?$t.'%':'-';?>
									</ff>
								</td>
							</tr>

					<?
						}
					}
				}
				?>
				<tr fot>
					<td txt>المجاميع</td>		
					<td></td>
					<td>
						<ff class="clr1">
							<?=number_format($yearData['presc_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
							<?=number_format($yearData['ex_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=number_format($yearData['notExist_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
						<?=($t=$yearData['ex_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=($t=$yearData['notEx_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$yearData['notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
				</tr>
			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ..</div>';
		}
	}
	elseif($tab==3){
		echo repoNav($fil,0,$page,$tab,1,1,$page_mood);				
		echo $breakC;//^
	    echo repTitleShow();
		/*******************/		
		$minDate=date('Y',$totData['min_d']);
		$maxDate=date('Y',$totData['max_d']);
		$totData=presc_data_financial_reports($minDate,$maxDate);
		if($totData){
			?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80">السنة</th>
					<th>الدواء</th>
					<th>الكمية الموصوفة</th>
					<th>الكمية المصروفة</th>
					<th>الكمية غير المتوفرة</th>
					<th>نسبة الصرف </th>
					<th>نسبة غير المصروف </th>
					<th>نسبة غير المتوفرة </th>
				</tr>

				<?
				for($ss=$minDate;$ss<=$maxDate;$ss++){
					$y_s=strtotime($ss.'-1-1');
					$y_e=strtotime($ss.'-12-31');
					//-----------
					$yearDrugData=presc_data_drugs_reports($y_s,$y_e);
					if($yearDrugData){
						$i=0;$row_s=count($yearDrugData);  $st=$st2='';
						foreach($yearDrugData as $drug=>$yearData){
							$i++; $v='';$st2='';
							if($i==1){$v=($ss);}
							if($i==$row_s){
								$st='style="border-bottom:2px #ddd solid;"';
							}
							else{
								$st2='style="border-bottom:1px white solid;"';
							}
							$drug_name=get_val('cln_m_medicines','name_'.$lg,$drug);?>
							<tr <?=$st?>>
								<td <?=$st2?>>
									<div class="ff fs18 B txt_Over" onclick="loadReport(<?=$page?>,2,'<?=$ss.'-1'?>')"><?=$v?></div>
								</td>	
								<td><?=SplitNo($drug_name)?></td>
								<td>
									<ff class="clr1">
										<?=number_format($yearData['presc_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr6">
										<?=number_format($yearData['ex_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=number_format($yearData['notExist_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr6">
									<?=($t=$yearData['ex_per'])?$t.'%':'-';?>
									</ff>
								</td>
								<td>
									<ff class="clr77">
										<?=($t=$yearData['notEx_per'])?$t.'%':'-';?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=($t=$yearData['notExist_per'])?$t.'%':'-';?>
									</ff>
								</td>
							</tr>

					<?
						}
					}
				}
				?>
				<tr fot>
					<td txt>المجاميع</td>	
					<td></td>
					<td>
						<ff class="clr1">
							<?=number_format($totData['presc_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
							<?=number_format($totData['ex_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=number_format($totData['notExist_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
						<?=($t=$totData['ex_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=($t=$yearData['notEx_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$yearData['notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
				</tr>


			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ</div>';
		}
	}
	elseif($tab==4){
		echo repoNav($fil,4,$page,$tab,1,1,$page_mood);				
		$d_s=strtotime($df);
		$d_e=strtotime($dt)+86400;
		echo $breakC;//^
	    echo repTitleShow();
		/*******************/
		$monData=presc_data_statistical_reports($d_s,$d_e);
		if($monData){
			?>
			<table width="100%" class="grad_s" cellpadding="2" cellspacing="2" sHeader>
				<tr>
					<th width="80"><?=k_tday?></th>
					<th>الدواء</th>
					<th>الكمية الموصوفة</th>
					<th>الكمية المصروفة</th>
					<th>الكمية غير المتوفرة</th>
					<th>نسبة الصرف </th>
					<th>نسبة غير المصروف </th>
					<th>نسبة غير المتوفرة </th>
				</tr>
				<?
				$a=strtotime($df);
				$b=strtotime($dt);
				for($ss=$a;$ss<=$b;$ss+=86400){
					$d_s=$ss;
					$d_e=$d_s+86400;
					//-----------
					$monDrugData=presc_data_drugs_reports($d_s,$d_e);
					if($monDrugData){
						$i=0;$row_s=count($monDrugData);  $st=$st2='';
						foreach($monDrugData as $drug=>$dayData){
							$i++; $v='';$st2='';
							if($i==1){$v=date('Y-m-d',$ss);}
							if($i==$row_s){
								$st='style="border-bottom:2px #ddd solid;"';
							}
							else{
								$st2='style="border-bottom:1px white solid;"';
							}
							$drug_name=get_val('cln_m_medicines','name_'.$lg,$drug);?>
							<tr <?=$st?>>
								<td <?=$st2?>>
									<div class="ff fs18 B"><?=$v;?></div>
								</td>		
								<td><?=SplitNo($drug_name)?></td>
								<td>
									<ff class="clr1">
										<?=number_format($dayData['presc_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr6">
										<?=number_format($dayData['ex_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=number_format($dayData['notExist_co'])?>
									</ff>
								</td>
								<td>
									<ff class="clr6">
									<?=($t=$dayData['ex_per'])?$t.'%':'-';?>
									</ff>
								</td>
								<td>
									<ff class="clr77">
										<?=($t=$dayData['notEx_per'])?$t.'%':'-';?>
									</ff>
								</td>
								<td>
									<ff class="clr5">
										<?=($t=$dayData['notExist_per'])?$t.'%':'-';?>
									</ff>
								</td>
							</tr>
					<?
						}
					}
				}
				?>
				<tr fot>
					<td txt>المجاميع</td>				
					<td></td>				
					<td>
						<ff class="clr1">
							<?=number_format($monData['presc_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
							<?=number_format($monData['ex_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=number_format($monData['notExist_co'])?>
						</ff>
					</td>
					<td>
						<ff class="clr6">
						<?=($t=$monData['ex_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr77">
							<?=($t=$monData['notEx_per'])?$t.'%':'-';?>
						</ff>
					</td>
					<td>
						<ff class="clr5">
							<?=($t=$monData['notExist_per'])?$t.'%':'-';?>
						</ff>
					</td>
				</tr>
			</table>
			<?
		}else{
			echo '<div class="clr5 f1 fs16 pd10">لا يوجد بيانات في هذا التاريخ</div>';
		}
	}
}

/**************************************************/
if($page_mood==1){echo reportFooter();}?>