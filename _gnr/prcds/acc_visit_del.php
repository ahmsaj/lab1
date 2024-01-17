<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['type'],$_POST['opr']) && $chPer[3]){
	$cType=pp($_POST['type']);
	$v_id=pp($_POST['id']);
	$opr=pp($_POST['opr']);
	if($opr==0){
		?>
		<div class="win_body">
		<div class="form_header f1">
		<div class="f1 fs18 clr1 lh40"><?=k_dl_vis?>  <?=k_num?> <ff> ( <?=$v_id?> ) </ff> <?=$clinicTypes[$cType]?></div>
		<div class="f1 fs16 clr5 lh30"> <?=k_del_data_note?> </div>
		</div>
		<div class="form_body so" type="full"><?
			$table=$visXTables[$cType];
			$table2=$srvXTables[$cType];
			$table3=$srvTables[$cType];
			if($cType==1){$page='cln_acc_visit_review';}
			if($cType==2){}
			if($cType==3){$page='xry_acc_visit_review';}
			if($cType==4){$page='den_acc_visit_review';}
			if($cType==5){$page='bty_acc_visit_review';}
			if($cType==6){$page='bty_lsr_acc_visit_review';}
			if($cType==7){$page='osc_acc_visit_review';}
			$clinic=0;
			if($cType!=2){$clinic=get_val($table,'clinic',$v_id);}
			?>
			<div class="f1 fs14 clr1 lh40"><?=k_datalist_to_del?></div><?
			$vis=getTotalCO($table,"id='$v_id'");
			$services=getTotalCO($table2," visit_id='$v_id' ");
			$payments=getTotalCO('gnr_x_acc_payments'," vis='$v_id' and mood like '$cType%' and type IN(1,2,3,4,7)");
			$insur=getTotalCO('gnr_x_insurance_rec'," visit='$v_id' and mood='$cType' ");
			$insur_pay=getTotalCO('gnr_x_insur_pay_back'," visit='$v_id' and mood='$cType' ");		
			$charities=getTotalCO('gnr_x_charities_srv'," vis='$v_id' and mood='$cType' ");
            $exemption=getTotalCO('gnr_x_exemption_srv'," vis='$v_id' and mood='$cType' ");
			
			$dates=getTotalCO('dts_x_dates'," vis_link='$v_id' and type='$cType' ");
			$roles=getTotalCO('gnr_x_roles'," vis='$v_id' and mood='$cType' ");
			$alerts=getTotalCO('gnr_x_visits_services_alert'," visit_id='$v_id' and mood='$cType' ");
			if($dates){
				$dates_serv=getTotalCO('dts_x_dates_services'," dts_id IN (select id from dts_x_dates where vis_link='$v_id' and type='$cType') ");
			}
			if($cType==1){
				$ana_req=getTotalCO('lab_x_visits_requested'," visit_id	='$v_id'");
				$docOpr1=getTotalCO('gnr_x_visits_timer'," visit_id ='$v_id' and mood='$cType'");
				$docOpr2=getTotalCO('cln_x_pro_analy_items'," ana_id IN ( select id from cln_x_pro_analy where v_id='$v_id' )");
				$docOpr3=getTotalCO('cln_x_pro_analy'," v_id ='$v_id'");
				$docOpr4=getTotalCO('xry_x_pro_radiography_items'," xph_id IN ( select id from xry_x_pro_radiography where v_id='$v_id' ) ");
				$docOpr5=getTotalCO('xry_x_pro_radiography'," v_id ='$v_id'");
				$docOpr6=getTotalCO('cln_x_pro_referral'," v_id ='$v_id'");
				//$docOpr7=getTotalCO('cln_x_prv_complaints'," visit ='$v_id'");
				//$docOpr8=getTotalCO('cln_x_prv_diagnosis'," visit ='$v_id'");
				//$docOpr9=getTotalCO('cln_x_pro_x_operations'," v_id ='$v_id'");
				//$docOpr10=getTotalCO('cln_x_medicines'," visit ='$v_id'");
				$docOpr=$docOpr1+$docOpr2+$docOpr3+$docOpr4+$docOpr5+$docOpr6+$docOpr7+$docOpr8+$docOpr9+$docOpr10;				
			}
			if($cType==2){
				$samples=getTotalCO('lab_x_visits_samlpes'," visit_id ='$v_id'");
				$outLab=getTotalCO('lab_x_visits_services_outlabs'," id IN ( select id from $table2 where visit_id='$v_id' ) ");
				$labRes1=getTotalCO('lab_x_visits_services_results'," serv_id IN ( select id from $table2 where visit_id='$v_id' ) ");
				$labRes2=getTotalCO('lab_x_visits_services_result_cs', " serv_id IN ( select id from $table2 where visit_id='$v_id' ) ");
				$labRes3=getTotalCO('lab_x_visits_services_results_x'," x_ser_id IN ( select id from $table2 where visit_id='$v_id' ) ");
			}
			if($cType==3){			
				$xray_req_report=getTotalCO('xry_x_pro_radiography_report',"id IN(select id from  $table2 where visit_id='$v_id' )");
				$xray_req=getTotalCO('xry_x_visits_requested'," visit_id ='$v_id'");
			}
			if($cType==4){			
				$den_level=getTotalCO('den_x_visits_services_levels',"vis ='$v_id'");
				$den_level_w=getTotalCO('den_x_visits_services_levels_w'," vis ='$v_id'");
				$den_pay_pat=getTotalCO('gnr_x_acc_patient_payments'," sub_mood='$v_id' and mood=4 ");
			}
			if($cType==6){
				$lsr_Srev=getTotalCO('bty_x_laser_visits_services_vals'," visit_id	='$v_id'");
			}
			if($cType==7){			
				$osc_req_report=getTotalCO('osc_x_report'," vis='$v_id' ");
				$osc_srv_add=getTotalCO('osc_x_visits_services_add'," visit_id ='$v_id'");
			}?>
			<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">
			<tr><th><?=k_department?></th><th width="60"><?=k_recs_num?></th></tr>
			<? if($vis){?><tr><td txt><?=k_thvisit?></td><td><ff class="clr5"><?=$vis?></ff></td></tr><? }?>
			<? if($services){?><tr><td txt><?=k_visit_srvcs?></td><td><ff class="clr5"><?=$services?></ff></td></tr><? }?>
			<? if($payments){?><tr><td txt><?=k_fin_recs?></td><td><ff class="clr5"><?=$payments?></ff></td></tr><? }?>
			<? if($insur){?><tr><td txt><?=k_insure_recs?></td><td><ff class="clr5"><?=$insur?></ff></td></tr><? }?>
			<? if($insur_pay){?><tr><td txt><?=k_insure_benefits?></td><td><ff class="clr5"><?=$insur_pay?></ff></td></tr><? }?>		
			<? if($charities){?><tr><td txt><?=k_charities_recs?></td><td><ff class="clr5"><?=$charities?></ff></td></tr><? }?>
            <? if($exemption){?><tr><td txt><?=k_exemptions?></td><td><ff class="clr5"><?=$exemption?></ff></td></tr><? }?>
                
			<? if($dates){?><tr><td txt><?=k_appointments?></td><td><ff class="clr5"><?=$dates?></ff></td></tr><? }?>
			<? if($roles){?><tr><td txt><?=k_role_table?></td><td><ff class="clr5"><?=$roles?></ff></td></tr><? }?>
			<? if($alerts){?><tr><td txt><?=k_alerts?></td><td><ff class="clr5"><?=$alerts?></ff></td></tr><? }?>
			<? if($lsr_Srev){?><tr><td txt><?=k_lsr_parts?></td><td><ff class="clr5"><?=$lsr_Srev?></ff></td></tr><? }?>
			
			<? if($dates_serv){?><tr><td txt><?=k_appoint_srvcs?></td><td><ff class="clr5"><?=$dates_serv?></ff></td></tr><? }?>		
			<? if($ana_req){?><tr><td txt><?=k_tests_reqs?></td><td><ff class="clr5"><?=$ana_req?></ff></td></tr><? }?>		
			<? if($xray_req){?><tr><td txt><?=k_xray_orders?></td><td><ff class="clr5"><?=$xray_req?></ff></td></tr><? }?>
			<? if($xray_req_report){?><tr><td txt><?=k_xray_writ_reps?></td><td><ff class="clr5"><?=$xray_req_report?></ff></td></tr><? }?>
			<? if($docOpr){?><tr><td txt><?=k_doc_proceds?></td><td><ff class="clr5"><?=$docOpr?></ff></td></tr><? }?>
			<? if($samples){?><tr><td txt><?=k_sampels?></td><td><ff class="clr5"><?=$samples?></ff></td></tr><? }?>
			<? if($outLab){?><tr><td txt><?=k_tests_external?></td><td><ff class="clr5"><?=$outLab?></ff></td></tr><? }?>
			<? if($labRes1){?><tr><td txt><?=k_test_res?> 1</td><td><ff class="clr5"><?=$labRes1?></ff></td></tr><? }?>
			<? if($labRes2){?><tr><td txt><?=k_test_res?> 2</td><td><ff class="clr5"><?=$labRes2?></ff></td></tr><? }?>
			<? if($labRes3){?><tr><td txt><?=k_test_res?> 3</td><td><ff class="clr5"><?=$labRes3?></ff></td></tr><? }?>
			
			<? if($den_level){?><tr><td txt><?=k_srv_levels?></td><td><ff class="clr5"><?=$den_level?></ff></td></tr><? }?>
			<? if($den_level_w){?><tr><td txt><?=k_srv_levels_entries?></td><td><ff class="clr5"><?=$den_level_w?></ff></td></tr><? }?>
			<? if($den_pay_pat){?><tr><td txt><?=k_pat_account?></td><td><ff class="clr5"><?=$den_pay_pat?></ff></td></tr><? }?>
			
			<? if($osc_req_report){?><tr><td txt><?=k_rep_elems_entered?></td><td><ff class="clr5"><?=$osc_req_report?></ff></td></tr><? }?>
			<? if($osc_srv_add){?><tr><td txt><?=k_staff_info?></td><td><ff class="clr5"><?=$osc_srv_add?></ff></td></tr><? }?>
			
			<? $allRecs=$vis+$services+$payments+$insur+$insur_pay+$charities+$exemption+$dates+$dates_serv+$ana_req+$xray_req+$xray_req_report+$docOpr+$samples+$outLab+$labRes1+$labRes2+$labRes3+$roles+$alerts+$den_level+$den_level_w+$den_pay_pat+$osc_req_report+$osc_srv_add;?>
			<tr fot><td txt><?=k_num_of_rec?></td><td><ff class="clr5"><?=$allRecs?></ff></td></tr>
			</table>
		</div>
		<div class="form_fot fr" >
			<? if($pay_type==0 && $status==2 && $editDoc==0){?><div class="bu bu_t1 fl" onclick="chechAccCal()"><?=k_save?></div><? }?>
			<div class="bu bu_t3 fl" onclick="delVisAcc(<?=$v_id?>,<?=$cType?>,1);" ><?=k_delete?></div>
			<div class="bu bu_t2 fr" onclick="win('close','#m_info2');" ><?=k_close?></div>
		</div>
		</div><?
	}
	if($opr==1){
		$table=$visXTables[$cType];
		$table2=$srvXTables[$cType];
		$table3=$srvTables[$cType];
		if($cType==1){$page='cln_acc_visit_review';}
		if($cType==2){$page='lab_acc_visit_review';}
		if($cType==3){$page='xry_acc_visit_review';}
		if($cType==4){$page='den_acc_visit_review';}
		if($cType==5){$page='bty_acc_visit_review';}
		if($cType==6){$page='bty_lsr_acc_visit_review';}
		if($cType==7){$page='osc_acc_visit_review';}
		$clinic=0;
		visDelLog($cType,$v_id);
		if($cType!=2) {$clinic=get_val($table,'clinic',$v_id);}
		delOfferVis($cType,$v_id);
		mysql_q("delete from $table where id='$v_id' ");
		mysql_q("delete from $table2 where visit_id='$v_id' ");
		mysql_q("delete from gnr_x_acc_payments where vis='$v_id' and mood like '$cType%' and type IN(1,2,3,4,7,9)");
		mysql_q("delete from gnr_x_insurance_rec where visit='$v_id' and mood='$cType' ");
		mysql_q("delete from gnr_x_insur_pay_back where visit='$v_id' and mood='$cType' ");		
		//mysql_q("delete from gnr_x_referral_charities where vis='$v_id' and c_type='$cType' ");
		mysql_q("delete from gnr_x_charities_srv where mood='$cType' and vis='$v_id' ");
        mysql_q("delete from gnr_x_exemption_srv where mood='$cType' and vis='$v_id' ");
        
		mysql_q("delete from dts_x_dates where vis_link='$v_id' and type='$cType' ");
		mysql_q("delete from dts_x_dates_services where dts_id IN (select id from dts_x_dates where vis_link='$v_id' and type='$cType') ");
		mysql_q("delete from gnr_x_roles where vis='$v_id' and mood='$cType' ");
		mysql_q("delete from gnr_x_visits_services_alert where visit_id='$v_id' and mood='$cType' ");

		if($cType==1){
			mysql_q("delete from lab_x_visits_requested where visit_id	='$v_id'");
			mysql_q("delete from xry_x_visits_requested where visit_id ='$v_id'");			
			mysql_q("delete from gnr_x_visits_timer where visit_id ='$v_id' and mood='$cType'");
			mysql_q("delete from cln_x_pro_analy_items where ana_id IN ( select id from cln_x_pro_analy where v_id='$v_id' )");
			mysql_q("delete from cln_x_pro_analy where v_id ='$v_id'");
			mysql_q("delete from xry_x_pro_radiography_items where xph_id IN ( select id from xry_x_pro_radiography where v_id='$v_id' ) ");
			mysql_q("delete from xry_x_pro_radiography where v_id ='$v_id'");
			mysql_q("delete from cln_x_pro_referral where v_id ='$v_id'");
			//mysql_q("delete from cln_x_prv_complaints where visit ='$v_id'");
			//mysql_q("delete from cln_x_prv_diagnosis where visit ='$v_id'");
			//mysql_q("delete from cln_x_pro_x_operations where v_id ='$v_id'");
			//mysql_q("delete from cln_x_medicines where visit ='$v_id'");
		}
		if($cType==2){
			mysql_q("delete from lab_x_visits_samlpes where visit_id ='$v_id'");			
			mysql_q("delete from lab_x_visits_services_outlabs where id IN ( select id from $table2 where visit_id='$v_id' ) ");
			mysql_q("delete from lab_x_visits_services_results where serv_val_id IN ( select id from $table2 where visit_id='$v_id' ) ");
			mysql_q("delete from lab_x_visits_services_result_cs where serv_id IN ( select id from $table2 where visit_id='$v_id' ) ");
			//mysql_q("delete from lab_x_visits_services_results_x where x_ser_id IN ( select id from $table2 where visit_id='$v_id' ) ");
            labJson($v_id,1);
		}
		if($cType==3){			
			mysql_q("delete from xry_x_pro_radiography_report where id IN(select id from  $table2 where visit_id='$v_id' )");
		}
		if($cType==4){
			mysql_q("delete from den_x_visits_services_levels where vis	='$v_id'");
			mysql_q("delete from den_x_visits_services_levels_w where vis ='$v_id'");			
			mysql_q("delete from gnr_x_acc_patient_payments where sub_mood='$v_id' and mood=4");
		}
		if($cType==6){			
			mysql_q("delete from bty_x_laser_visits_services_vals where visit_id ='$v_id' )");
		}
		if($cType==7){			
			mysql_q("delete from osc_x_report where vis='$v_id' ");
			mysql_q("delete from osc_x_visits_services_add where visit_id ='$v_id'");
		}
		echo 1;
	}
}?>
