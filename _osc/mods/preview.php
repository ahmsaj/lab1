<? include("../../__sys/mods/protected.php");?>
<?
$visit_id=pp($_GET['m_id']);
$mood=7;
list($doctor,$clinic)=get_val('osc_x_visits','doctor,clinic',$visit_id);
$relsDoc=get_val_con('gnr_x_roles','doctor'," vis='$visit_id' and clic='$clinic' ");
if($relsDoc==0){
	mysql_q("UPDATE gnr_x_roles SET doctor='$doctor' where vis='$visit_id' and clic='$clinic' ");
}
if($doctor==0){
	mysql_q("UPDATE osc_x_visits SET doctor='$thisUser' where id='$visit_id' ");
	mysql_q("UPDATE osc_x_visits_services SET doc='$thisUser' where visit_id='$visit_id' ");
	$doctor=$thisUser;
}
if($thisUser==$doctor){
	$sql2="select * from osc_x_visits where id='$visit_id' and doctor='$doctor' limit 1";
	$res2=mysql_q($sql2);
	$rows2=mysql_n($res2);
	if($rows2>0){
	$r2=mysql_f($res2);		
	$doctor=$r2['doctor'];
	$patient_id=$r2['patient'];
	$d_start=$r2['d_start'];
	$d_check=$r2['d_check'];
	$type=$r2['type'];
	$sub_type=$r2['sub_type'];
	$status=$r2['status'];
	$pay_type=$r2['pay_type'];
	$ref=$r2['ref'];
	$ref_no=$r2['ref_no'];
	$ref_date=$r2['ref_date'];
	if($type==2){$typ_text=$rev_type_arr[$sub_type];}		
	if($pay_type==3){
		mysql_q("UPDATE gnr_x_insurance_rec SET doc='$thisUser' where doc=0 and visit='$visit_id' and mood = 7 ");
	}
	if($status==2 || $status==3){
		mysql_q("UPDATE gnr_x_roles set status=4 where vis='$visit_id' and mood=$mood ");
		delTempOpr($mood,$visit_id,'a');
		if($status==3){
			loc('_Visits-OSC');
			exit;
		}
	}
	$r=getRec('gnr_m_patients',$patient_id);		
	if($r['r']){			
		$sex=$r['sex'];
		$birth=$r['birth_date'];
		$birthCount=birthCount($birth);			
		$endAction="loc('_Visits-OSC')";
		if($status==1){$endAction='oscVisEnd(1);';}
		$r3=getRecCon('osc_x_visits_services'," visit_id='$visit_id' ");
		$srv_id=$r3['id'];
		//if($r3['doc']==0){mysql_q("UPDATE osc_x_visits_services SET doc='$ray_tec' where id='$srv_id' ");}?>
		<header>				
			<div class="top_txt_sec fl">
				<div class="fs18 f1s pd10 lh40 " fix="h:35" style="margin: 0px" ><?=get_p_name($patient_id)?>
					<span class="f1 fs14 clr1 ">-  [ <ff><?=$birthCount[0]?> </ff><?=$birthCount[1]?> ]</span>
				</div>
				<div class="f1 fs14 clr1 pd10 lh30" fix="h:25"><?=get_val('osc_m_services','name_'.$lg,$r3['service'])?></div>
			</div>				
			<div class="top_icons"><?
				 echo topIconCus(k_end,'cbg5 ti_77 fr',$endAction);
				 echo topIconCus(k_end,'ti_back fr','loc(\'_Visits-OSC\')');
				 if(!modPer('b8kpe202f3','0')){
					echo topIconCus(k_documents,'ti_docs fr','patDocs('.$patient_id.',1)');			
				}?>
				<div class="cbg6 fr" id="oscTime"></div>				
			</div>    
		</header>			
		<div class="centerSideInFull of">
			<div class="fl bord" fix="w:300|hp:0">
				<div class="f1 fs18 clr1 uLine TC lh40 cbg44"><?=k_the_proced?></div>
				<div class="ofx so pd10" fix="hp:50" id="proc"><?=getOscReportEl($srv_id,$status)?></div>
			</div>
			<div class="fl bord" fix="wp:550|hp:0">
				<div class="f1 fs18 clr1 uLine TC lh40 cbg44"><?=k_work_summary?>   

				<div class="fr ic40x icc4 ic40_print" onclick="printOscRep(<?=$srv_id?>)" title="<?=k_report_print?>"></div>

				<div class="fr ic40x icc1 mg5 ic40_ord mg10" onclick="ordOsc()" title="<?=k_ord_proceds?> "></div>

				</div>

				<div class="ofx so pd10" fix="hp:50" id="proc_fin"><?=oscReportView($srv_id,$status)?></div>
			</div>
			<div class="fl bord" fix="w:250|hp:0">
				<div class="f1 fs18 clr1 uLine cbg44 TC lh40"><?=k_staff?>  
				<div class="fr ic40x icc4 ic40_edit" onclick="selTeam(<?=$srv_id?>)" title="<?=k_staff_edit?>"></div></div>
				<div class="cb pd10" id="oTeam"></div>
				<div class="f1 fs18 clr1 t_bord b_bord TC lh40"><?=k_addtn_srvs?>   
				<div class="fr ic40x icc4 ic40_add" onclick="OSCAddSrv(<?=$srv_id?>)" title="<?=k_add_srvs?>"></div></div>
				<div class="ofx so pd10" id="oscAddSrv"></div>
			</div>
		</div>
		<script>			
			var visit_id=parseInt(<?=$visit_id?>);
			var patient_id=<?=$patient_id?>;	
			$(document).ready(function(e){
				rev_osc_live(<?=$visit_id?>);refPage('osc2',5000);
				fixObjects($('header'));
				teamInfo(<?=$srv_id?>);
				loadOSCaddSrv();
				oscActSrv=<?=$srv_id?>;
				setOsc_pro_butts();
				fixPage();
				//osc_loadProc()
				oscOdrSet();
			});

		</script><? 
		}else{
			mysql_q("UPDATE osc_x_visits SET status=3 where id='$visit_id'");
			echo script("loc('_Visits-OSC')");
		}
	}
}else{
	$status=get_val('osc_x_visits','status',$visit_id);
	if($status==2 || $status==3){
		delTempOpr($mood,$visit_id,'a');
	}
	loc('_Visits-Osc');
}
		

?>