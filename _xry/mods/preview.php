<? include("../../__sys/mods/protected.php");?>
<?
$visit_id=pp($_GET['m_id']);
$mood=3;
list($ray_tec,$doctor,$clinic)=get_val('xry_x_visits','ray_tec,doctor,clinic',$visit_id);
if($thisGrp=='nlh8spit9q'){
	if($doctor==0){mysql_q("UPDATE xry_x_visits SET doctor='$thisUser' ,  ray_tec='$thisUser' where id='$visit_id' ");}
	$docDet=$sex_txt[$sex];
}
if($thisGrp=='1ceddvqi3g'){
	if($ray_tec==0){mysql_q("UPDATE xry_x_visits SET  ray_tec='$thisUser' where id='$visit_id' ");}
	$docDet=$sex_txt_tec[$sex];
}
if($thisUser==$ray_tec || $thisUser==$doctor || ($ray_tec==0 && $doctor==0)){
	echo getEditorSet();
	$relsDoc=get_val_con('gnr_x_roles','doctor'," vis='$visit_id' and clic='$clinic' ");
	if($relsDoc==0){mysql_q("UPDATE gnr_x_roles SET doctor='$ray_tec' where vis='$visit_id' and clic='$clinic' ");}
	$sql2="select * from xry_x_visits where id='$visit_id' and ray_tec='$ray_tec' limit 1";
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
			mysql_q("UPDATE gnr_x_insurance_rec SET doc='$thisUser' where doc=0 and visit='$visit_id' and mood = 3 ");
		}
		if($status==2 || $status==3){
			delTempOpr($mood,$visit_id,'a');
		}
		$sql="select * from gnr_m_patients where id='$patient_id' limit 1";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$sex=$r['sex'];
			$birth=$r['birth_date'];
			$birthCount=birthCount($birth);
			$blood=$r['blood'];
			$B2='';
			if($blood==''){$B2='blod_box_0';};
			$bloodStyle=str_replace('-','0',$bloodStyle);
			$endAction="loc('_Visits-XRY')";
			if($status==1){$endAction='xry_endPrv();';}?>
			<header>
			<div class="top_txt_sec fl">
				<div class="fs16 f1 lh40 pd10 po"> <ff><?=$patient_id?></ff> | <?=get_p_name($patient_id,0)?> <ff> ( <?=$birthCount[0]?> </ff> <?=$birthCount[1]?> )</div>				
			</div>
			<div class="top_icons"><?
				echo topIconCus(k_end,'cbg5 ti_77 fr',$endAction);
				echo topIconCus(k_back,'ti_back fr','loc(\'_Visits-XRY\')');				
				if($userStore){ 
					//echo topIconCus(k_consumables,'cost_icon fr','newCons('.$userStore.',\'\',\'docCostAdd([data])\',\'\');');
				}?>
				<div class="fr timeStatus" onclick="loadPrvSwitch();">
					<div line>   	
						<div icon class="fr"></div>                
						<div class="fr ff fs18 B" num id="stu_1"><?=getTotalCO("gnr_x_roles","status < 3 and clic='$clinic'");?></div>
					</div>
					<div line2>
						<div class="fr" icon2></div>
						<div class="fr ff fs18 B" num2 id="stu_2"><?=dateToTimeS2(getDocWorkTime($visit_id,$clinic))?></div>
					</div>            
				</div><div class="fr swWin so"></div>
				<? 
				if(modPer('b8kpe202f3','0')){
					echo topIconCus(k_documents,'ti_docs fr','patDocs('.$patient_id.',1)');
				}
				echo topIconCus(k_med_rec,'ti_card fr','pat_hl_rec(1,'.$patient_id.',\''.$patName.'\')');?>
				<div id="prv_slider" class="fr cbg777 l_bord" fix="w:250|h:60"></div>
			</div>    
			</header>    
			<div class="centerSideInFull of">
				<div class="r_bord fl of w100" fix="w:300|hp:0">
					<div fix="h:40" class="b_bord cbg44">
						<div class="f1 fs18 clr1 lh40 pd10 "><?=k_rq_srv?> [ <ff id="xsrvN"> 0 </ff> ]</div>
					</div>
					<div id="sevises_list" class="pd10f ofx so" fix="w:300|hp:40"></div>
				</div>
				<div fix="wp:300|hp:0" class="fl of l_bord">
					<div fix="h:40" class="fl w100 b_bord cbg44" id="srvTitle"></div>
					<div id="sevises_data" class="fl of " fix="wp:0|hp:45"></div>
				</div>
			</div>
			<script>
				sezPage='Preview-Xray';
				var visit_id=parseInt(<?=$visit_id?>);
				var patient_id=<?=$patient_id?>;	
				$(document).ready(function(e){
					xry_rev_ref(1,<?=$visit_id?>);
					refPage('xry3',5000);
					xry_prv_srvs(<?=$visit_id?>,0);
					fixPage();						
				});
			</script><? 
		}else{
			mysql_q("UPDATE xry_x_visits SET status=3 where id='$visit_id'");
			echo script("loc('_Visits-XRY')");
		}
	}
}else{
	$status=get_val('xry_x_visits','status',$visit_id);
	if($status==2 || $status==3){delTempOpr($mood,$visit_id,'a');}
	loc('_Visits-XRY');
}?>