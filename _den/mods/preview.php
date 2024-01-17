<? include("../../__sys/mods/protected.php");?>
<? $mood=4;
$visit_id=pp($_GET['m_id']);
$r=getRec('den_x_visits',$visit_id);
if($r['r']){?>
	<script src="<?=$m_path?>library/Highcharts/highcharts.src.js"></script>
	<script src="<?=$m_path?>library/Highcharts/highcharts-more.js"></script><?
	$_SESSION['denVis']=$visit_id;
	$status=$r['status'];
	$type=$r['type'];
	if($status==0){
		if(mysql_q("UPDATE den_x_visits SET status=1 where status=0 and id ='$visit_id' and doctor='$thisUser'")){$status=1;}
	}
	$patient_id=$r['patient'];
	$clinic=$r['clinic'];	list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$patient_id);
	$birthCount=birthCount($birth);
	$age=birthByTypes($birth);
	$years=$age[0];
	$scType=2;
	if($years>6){$scType=1;}	
	if($status==2 || $status==3){
		mysql_q("UPDATE gnr_x_roles set status=4 where vis='$visit_id' and mood=$mood");
		delTempOpr($mood,$visit_id,'a');
		if($status==3){
			loc('_Visit-Den');
			exit;
		}
	}?>
	<header>
		<div class="top_txt_sec fl">
			<div class="top_title fs16 f1s lh30 Over" fix="h:30" onclick="editPat(<?=$patient_id?>,1)"> <ff><?=$patient_id?></ff> | <?=get_p_name($patient_id,0)?> <ff> ( <?=$birthCount[0]?> </ff> <?=$birthCount[1]?> )
			</div>	
            <div class="fr clrw f1 icc33 lh30 pd10 mg10 br5" onclick="loc('_Preview-Den-New.<?=$visit_id?>')">استخدام الواجهة الجديد</div>
			<? 
			if($type==2){ echo '<div class="fl f1 fs14  clr5 pd10 lh30 " >'.k_consultation.'</div>';}
			if($pay_type==2){				
				$name_ch=get_val('gnr_m_charities','name_'.$lg,$ch_id);
				echo '<div class="fl f1 fs12 pd10 lh20 clr5 lh30">'.$name_ch.'</div>';
			}?>
		</div>
		<div class="top_icons"><?
			echo topIconCus(k_end,'cbg5 ti_77 fr','finshDenVis()');			
			echo topIconCus(k_med_rec,'ti_card fr','pat_hl_rec(1,'.$patient_id.',\''.$patName.'\')');
			if(modPer('b8kpe202f3','0')){
				echo topIconCus(k_documents,'ti_docs fr','patDocs('.$patient_id.',1)');		
			}
			if(chProUsed('dts')){
				echo topIconCus(k_appointments,'ti_date fr','selDtSrvs('.$clinic.',0,'.$patient_id.')');
			}
			echo topIconCus(k_precpiction,'ti_1 fr','prescrs('.$mood.',0)');			
			echo topIconCus(k_teeth_status,'ti_mouth fr','teethStatus('.$patient_id.')');
			echo topIconCus(k_dental_procedures,'ti_opr_den fr','denHis('.$patient_id.','.$visit_id.')');
			//echo topIconCus(k_consumables,'cost_icon fr','newCons('.$userStore.',\'\',\'docCostAdd([data])\',\'\');');
			?>
		</div>
	</header>
	<div class="centerSideInFull of">
	<div class="denInfo fl cbg3 ofx so" fix="w:200|hp:0">
		<div class="cb f1 w100 of" fix="" id="timeBar"></div>
		<div class="fl butDen w100 mg10v" actButt="act">
			<div den_i1 n="1" act><?=k_dental_anatomy?></div>
			<div den_i2 n="2"><?=k_dental_procedures?></div>			
		</div>		
	</div>
	<div class="fl of" fix="wp:200|hp:0" id="denData"></div>		
	</div>
	<script>
		sezPage='';
		visit_id=<?=$visit_id?>;
		patient_id=<?=$patient_id?>;
		$(document).ready(function(e){			
			denPrvSet(<?=$scType?>);
			//den_prv(1);
			//setDenOpr();
			//setOPeSrvDen();
			refPage('den2',12000);
			
		});
	</script><?
}else{}?>